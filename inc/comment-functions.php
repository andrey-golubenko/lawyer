<?php
/* ОБРАБОТКА скрипта КОММЕНТАРИЕВ */
add_action('wp_ajax_ajaxcomments', 'true_add_ajax_comment');
add_action('wp_ajax_nopriv_ajaxcomments', 'true_add_ajax_comment');
function true_add_ajax_comment(){

	// ПРОВЕРЯЕМ на СПАМ. Если скрытое поле заполнено или снят чек, то блокируем отправку
	if ( false === $_POST['com_anticheck'] || ! empty( $_POST['com_submitted'] ) ) {
		wp_die( 'Пошел Нахрен, мальчик!(c)' );
	}

// Проверяем nonce. Если проверкане прошла, то блокируем отправку
	if ( ! wp_verify_nonce( $_POST['lawyer_alex_nonce_field'], 'alex_lawyer_action' ) ) {
		wp_die( 'Внимание! Данные отправлены с левого адреса!' );
	}

	// Массив ошибок
	$com_err_message = array();

	// Проверяем поле имени, если пустое, то пишем сообщение в массив ошибок
	if ( !is_user_logged_in() && empty( $_POST['author'] ) ) {
		$com_err_message['author'] = 'Пожалуйста, введите ваше имя.';
	}

// Проверяем поле имейла, если пустое, то пишем сообщение в массив ошибок
	if ( !is_user_logged_in() && empty( $_POST['email'] ) ) {
		$com_err_message['email'] = 'Пожалуйста, введите адрес вашей электронной почты.';
	} elseif ( !is_user_logged_in() && ! preg_match( '/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i', $_POST['email'] ) ) {
		$com_err_message['email'] = 'Адрес электронной почты некорректный.';
	}

// Проверяем поле сообщения, если пустое, то пишем сообщение в массив ошибок
	if ( empty( $_POST['comment'] ) || ! isset( $_POST['comment'] ) ) {
		$com_err_message['comment'] = 'Пожалуйста, введите ваше Сообщение.';
	}
/*   */
// Проверяем массив ошибок, если не пустой, то передаем сообщение. Иначе записываем в БД
	if ( $com_err_message ) {
		wp_send_json_error( $com_err_message );
	}


		//БЕЗОПАСНОСТЬ - выбираем из суперглобального объекта - $_POST, те поля которые заполнил user и обрабатываем их (очищаем от лишних тегов и символов типа одинарной ковычки)
	$comment_author = esc_attr( sanitize_text_field( $_POST['author'] ) );
	$comment_author_email = esc_attr( sanitize_text_field( $_POST['email'] ) );
	$comment_content = esc_attr( sanitize_text_field( $_POST['comment'] ) );

	//ВОЗВРАЩАЕМ значение обработанных полей в суперглобальный объект - $_POST, который потом передаём в нижиследующую ф-цию для записи в БД и т.д.
	$_POST['author'] = $comment_author;
	$_POST['email'] = $comment_author_email;
	$_POST['comment'] = $comment_content;

	$comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
	if ( is_wp_error( $comment ) ) {
		$error_data = intval( $comment->get_error_data() );
		if ( ! empty( $error_data ) ) {
			wp_die( '<p>' . $comment->get_error_message() . '</p>', __( 'Comment Submission Failure', 'lawyer'), array( 'response' => $error_data, 'back_link' => true ) );
		} else {
			wp_die( 'Unknown error' );
		}
	}
	/*
	 * Set Cookies
	 */
	$user            = wp_get_current_user();
	$cookies_consent = ( isset( $_POST['wp-comment-cookies-consent'] ) );
	do_action( 'set_comment_cookies', $comment, $user, $cookies_consent );

	$comment_depth = 1;
	$comment_parent = $comment->comment_parent;
	while( $comment_parent ){
		$comment_depth++;
		$parent_comment = get_comment( $comment_parent );
		$comment_parent = $parent_comment->comment_parent;
	}
	/*
	 * Set the globals, so our comment functions below will work correctly
	 */
	$GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $comment_depth;
	/* Comment template */
	//Если НУЖНО в отображении НОВОГО комментария иметь ссылку для ОТВЕТА на него (REPLY) то ОБЯЗАТЕЛЬНО ЗАПИСЫВАЕМ ф-цию генерации ссылки на НОВЫЙ коментарий в ПЕРЕМЕННУЮ, а только потом эту переменную уже записываем в другую переменную для отправки на клиент и вывода там. Подругому НЕ РАБОТАЕТ (не генерирует ссылку).
	$reply_link = get_comment_reply_link(array(
		'reply_text' => "ОТВЕТИТЬ",
		'respond_id' => 'comment',
		'depth' => 5,
		'max_depth' => 10,
	), $comment->comment_ID, $comment->comment_post_ID );

	$comment_html = '<li ' . comment_class('new-comment', $comment, $comment->comment_ID, false ) . ' id="comment-' .  $comment->comment_ID . '"><div class="vcard bio">' . get_avatar( $comment, null, '', '', array( 'extra_attr'=>'style="width: 50px; height: 60px;"') ) . '</div><div class="comment-body"><h3>' . $comment->comment_author . '</h3><div class="meta">' .  get_comment_date('F d Y в H:i', $comment->comment_ID) . '</div>';
	if ( $comment->comment_approved == '0' ){
		$comment_html .= '<em>Ваш Комментарий ожидает модерации.</em><br/>';
	}
	else {
	    $comment_html .=  apply_filters( 'comment_text', get_comment_text( $comment ), $comment );
	}
	//$comment_html .= $reply_link; //Запись перемен. ссылки для ответа в перемен. для вывода НОВОГО коментария
	$comment_html .= '</div></li>';
	echo $comment_html;
	wp_die();
}

//Описываем (ЗАДАЁМ структуру) ОТОБРАЖЕНИЕ КАЖДОГО коментария для ф-ции wp_list_comments(), которая ВЫВОДИТ СПИСОК всех комментариев для поста в файле comments.php
//Данная ф-ция явл. callback для wp_list_comments()в файле comments.php                                  /***   ДЕЛАТЬ ОЧЕНЬ ВНИМАТЕЛЬНО   ***/
function lawyer_list_comments($comment, $args, $depth) {
	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}
	$classes = ' ' . comment_class( empty( $args['has_children'] ) ? '' : 'parent', null, null, false );
	?>
    <<?php echo $tag, $classes; ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) { ?>
        <div id="div-comment-<?php comment_ID() ?>" class="comment-body"><?php
	} ?>
    <div class="vcard bio">
		<?php
		if ( $args['avatar_size'] != 0 ) {
			echo get_avatar( $comment, null, '', '', array( 'extra_attr'=>'style="width: 50px; height: 60px;"') );
		}
		?>
    </div>
    <h3><?php comment_author(); ?></h3>
    <div class="meta">
		<?php
		/* translators: 1: date, 2: time */
		printf( __('%1$s at %2$s', 'lawyer'), get_comment_date('F d Y'), get_comment_time());
		?>
    </div>
	<?php
	if ( $comment->comment_approved == '0' ) { ?>
        <em class="comment-awaiting-moderation">
			<?php _e( 'Ваш Комментарий ожидает модерации.', 'lawyer'); ?></em><br/><?php
	}
    else{comment_text(); } ?>
	<?php
	comment_reply_link(
		array_merge(
			$args,
			array(
				'add_below' => $add_below,
				'depth'     => $depth,
				'max_depth' => $args['max_depth'],
				'reply_text' => "ОТВЕТИТЬ",
			)
		)
	);
	?>
	</div>
    <?php
}


//ФУНКЦИЯ, которая генерирует ВЫВОД ФОРМЫ коментариев ВМЕСТО СТАНДАРТНОЙ
function lawyer_comment_form( $args = array(), $post_id = null ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}
	// Exit the function when comments for the post are closed.
	if ( ! comments_open( $post_id ) ) {
		// Fires after the comment form if comments are closed.
		do_action( 'comment_form_comments_closed' );
		return;
	}
	$commenter     = wp_get_current_commenter();
	$user          = wp_get_current_user();
	$user_identity = $user->exists() ? $user->display_name : '';

	$args = wp_parse_args( $args );
	if ( ! isset( $args['format'] ) ) {
		$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
	}

	$req      = get_option( 'require_name_email' );
	$html_req = ( $req ? " required='required'" : '' );
	$html5    = 'html5' === $args['format'];

	$fields = array(
		'author' => sprintf(
			'<div class="form-group">' . '<p class="comment-form-author">%s %s</p>',
			sprintf(
				'<label for="author">%s%s</label>',
				__( 'Имя', 'lawyer' ),
				( $req ? ' <span class="required">*</span>' : '' )
			),
			sprintf(
				'<input id="author" class="form-control" name="author" type="text" value="%s" %s /></div>',
				esc_attr( $commenter['comment_author'] ),
				$html_req
			)
		),
		'email'  => sprintf(
			'<div class="form-group">' . '<p class="comment-form-email">%s %s</p>',
			sprintf(
				'<label for="email">%s%s</label>',
				__( 'Email', 'lawyer' ),
				( $req ? ' <span class="required">*</span>' : '' )
			),
			sprintf(
				'<input id="email" class="form-control" name="email" %s value="%s" size="30" maxlength="100" aria-describedby="email-notes"%s /></div>',
				( $html5 ? 'type="email"' : 'type="text"' ),
				esc_attr( $commenter['comment_author_email'] ),
				$html_req
			)
		)
	);

	if ( has_action( 'set_comment_cookies', 'wp_set_comment_cookies' ) && get_option( 'show_comments_cookies_opt_in' ) ) {
		$consent = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

		$fields['cookies'] = sprintf(
			'<p class="comment-form-cookies-consent">%s %s</p>',
			sprintf(
				'<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"%s />',
				$consent
			),
			sprintf(
				'<label for="wp-comment-cookies-consent">%s</label>',
				__( 'Сохранить моё имя и email в этом браузере для последующих моих комментариев.', 'lawyer' )
			)
		);

		// Ensure that the passed fields include cookies consent.
		if ( isset( $args['fields'] ) && ! isset( $args['fields']['cookies'] ) ) {
			$args['fields']['cookies'] = $fields['cookies'];
		}
	}

	$required_text = sprintf(
	/* translators: %s: Asterisk symbol (*). */
		'  ' . __( 'Обязательные для заполнения поля помечены %s', 'lawyer' ),
		'<span class="required">*</span>'
	);

	/**
	 * Filters the default comment form fields.
	 * @param string[] $fields Array of the default comment fields. */
	$fields = apply_filters( 'comment_form_default_fields', $fields );

	$defaults = array(
		'fields'               => $fields,
		'comment_field'        => sprintf(
			'<div class="form-group">' . '<p class="comment-form-comment">%s %s</p>',
			sprintf(
				'<label for="comment">%s%s</label>',
				_x( 'Комментарий', 'noun', 'lawyer' ),
				( $req ? ' <span class="required">*</span>' : '' )
			),
			'<textarea id="comment" class="form-control" name="comment" cols="30" rows="5" maxlength="45525" required="required"></textarea>
				<input type="text" name="com_submitted" id="com_submitted" value="" style="display: none !important;"/>
				<input type="checkbox" name="com_anticheck" id="com_anticheck" class="com_anticheck" style="display: none !important;" value="true" checked="checked"/>

</div>'
		),
		'must_log_in'          => sprintf(
			'<p class="must-log-in">%s</p>',
			sprintf(
			/* translators: %s: Login URL. */
				__( 'Вамм необходимо <a href="%s">зарегистрироваться</a> для комментария.', 'lawyer' ),
		/** This filter is documented in wp-includes/link-template.php */
				wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ) )
			)
		),
		'logged_in_as'         => sprintf(
			'<p class="logged-in-as">%s</p>',
			sprintf(
		/* translators: 1: Edit user link, 2: Accessibility text, 3: User name, 4: Logout URL. */
				__( '<a href="%1$s" aria-label="%2$s">Вы вошли в качестве %3$s</a>. <a href="%4$s">Выйти?</a>', 'lawyer' ),
				get_edit_user_link(),
		/* translators: %s: User name. */
				esc_attr( sprintf( __( 'Вы зарегистрированы как %s. Редактировать Ваш профиль.', 'lawyer' ), $user_identity ) ),
				$user_identity,
		/** This filter is documented in wp-includes/link-template.php */
				wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ), $post_id ) )
			)
		),
		'comment_notes_before' => sprintf(
			'<p class="comment-notes">%s%s</p>',
			sprintf(
				'<span id="email-notes">%s</span>'.'<br>',
				__( 'Ваш E-Mail не будет где-либо опубликован.', 'lawyer' )				
			),
			( $req ? $required_text : '' )
		),
		'comment_notes_after'  => '',
		'action'               => site_url( '/wp-comments-post.php' ),
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'class_form'           => 'p-3 bg-light',
		'class_submit'         => 'btn py-2 px-2 btn-primary',
		'name_submit'          => 'submit',
		'title_reply'          => __( 'Оставить комментарий', 'lawyer' ),
		/* translators: %s: Author of the comment being replied to. */
		'title_reply_to'       => __( 'Ответить %s', 'lawyer' ),
		'title_reply_before'   => '<h5 id="reply-title" class="comment-reply-title">',
		'title_reply_after'    => '</h5>',
		'cancel_reply_before'  => ' <small>',
		'cancel_reply_after'   => '</small>',
		'cancel_reply_link'    => __( 'Отменить ответ', 'lawyer' ),
		'label_submit'         => __( 'Отправить комментарий', 'lawyer' ),
		'submit_button'        => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
		'submit_field'         => '<div class="form-group">%1$s %2$s</div>',
		'format'               => 'xhtml',
	);
	/**
	 * Filters the comment form default arguments.
	 * Use {@see 'comment_form_default_fields'} to filter the comment fields.
	 * @param array $defaults The default comment form arguments.
	 */
	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

	// Ensure that the filtered args contain all required default values.
	$args = array_merge( $defaults, $args );

	// Remove aria-describedby from the email field if there's no associated description.
	if ( isset( $args['fields']['email'] ) && false === strpos( $args['comment_notes_before'], 'id="email-notes"' ) ) {
		$args['fields']['email'] = str_replace(
			' aria-describedby="email-notes"',
			'',
			$args['fields']['email']
		);
	}
	/* Fires before the comment form. 	 */
	do_action( 'comment_form_before' );
	?>
    <div id="respond" class="comment-respond">
		<?php
		echo $args['title_reply_before'];

		comment_form_title( $args['title_reply'], $args['title_reply_to'] );

		echo $args['cancel_reply_before'];

		cancel_comment_reply_link( $args['cancel_reply_link'] );

		echo $args['cancel_reply_after'];

		echo $args['title_reply_after'];

		if ( get_option( 'comment_registration' ) && ! is_user_logged_in() ) :

			echo $args['must_log_in'];
			/**
			 * Fires after the HTML-formatted 'must log in after' message in the comment form.		*/
			do_action( 'comment_form_must_log_in_after' );

		else :

			printf(
				'<form action="%s" method="post" id="%s" class="%s"%s>',
				esc_url( $args['action'] ),
				esc_attr( $args['id_form'] ),
				esc_attr( $args['class_form'] ),
				( $html5 ? ' novalidate' : '' )
			);

			/**
			 * Fires at the top of the comment form, inside the form tag. */
			do_action( 'comment_form_top' );

			if ( is_user_logged_in() ) :
				/**
				 * Filters the 'logged in' message for the comment form for display.
				 * @param string $args_logged_in The logged-in-as HTML-formatted message.
				 * @param array  $commenter      An array containing the comment author's username, email, and URL.
				 * @param string $user_identity  If the commenter is a registered user, the display name, blank otherwise.
				 */
				echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity );

				/**
				 * Fires after the is_user_logged_in() check in the comment form.
				 * @param array  $commenter     An array containing the comment author's username, email, and URL.
				 * @param string $user_identity If the commenter is a registered user, the display name, blank otherwise. */
				do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
			else :
				echo $args['comment_notes_before'];
			endif;

			// Prepare an array of all fields, including the textarea.
			$comment_fields = array( 'comment' => $args['comment_field'] ) + (array) $args['fields'];
			/**
			 * Filters the comment form fields, including the textarea.
			 * @param array $comment_fields The comment fields.			 */
			$comment_fields = apply_filters( 'comment_form_fields', $comment_fields );
			// Get an array of field names, excluding the textarea
			$comment_field_keys = array_diff( array_keys( $comment_fields ), array( 'comment' ) );

			// Get the first and the last field name, excluding the textarea
			$first_field = reset( $comment_field_keys );
			$last_field  = end( $comment_field_keys );

			foreach ( $comment_fields as $name => $field ) {

				if ( 'comment' === $name ) {

					/* Filters the content of the comment textarea field for display.
					 * @param string $args_comment_field The content of the comment textarea field.					 */
					echo apply_filters( 'comment_form_field_comment', $field );

					echo $args['comment_notes_after'];

				} elseif ( ! is_user_logged_in() ) {

					if ( $first_field === $name ) {
						/**
						 * Fires before the comment fields in the comment form, excluding the textarea.  */
						do_action( 'comment_form_before_fields' );
					}
					/**
					 * Filters a comment form field for display.
					 * The dynamic portion of the filter hook, `$name`, refers to the name of the comment form field. Such as 'author', 'email', or 'url'.
					 * @param string $field The HTML-formatted output of the comment form field. */
					echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";

					if ( $last_field === $name ) {
						/**
						 * Fires after the comment fields in the comment form, excluding the textarea.						 */
						do_action( 'comment_form_after_fields' );
					}
				}
			}

			$submit_button = sprintf(
				$args['submit_button'],
				esc_attr( $args['name_submit'] ),
				esc_attr( $args['id_submit'] ),
				esc_attr( $args['class_submit'] ),
				esc_attr( $args['label_submit'] )
			);

			/**
			 * Filters the submit button for the comment form to display.
			 * @param string $submit_button HTML markup for the submit button.
			 * @param array  $args          Arguments passed to comment_form().
			 */
			$submit_button = apply_filters( 'comment_form_submit_button', $submit_button, $args );

			$submit_field = sprintf(
				$args['submit_field'],
				$submit_button,
				get_comment_id_fields( $post_id ),
                wp_nonce_field( 'alex_lawyer_action', 'lawyer_alex_nonce_field' )
			);

			/**
			 * Filters the submit field for the comment form to display.
			 * The submit field includes the submit button, hidden fields for the
			   comment form, and any wrapper markup.
			 * @param string $submit_field HTML markup for the submit field.
			 * @param array  $args         Arguments passed to comment_form().
			 */
			echo apply_filters( 'comment_form_submit_field', $submit_field, $args );

			/* Fires at the bottom of the comment form, inside the closing </form> tag.
			 * @param int $post_id The post ID.
			 */
			do_action( 'comment_form', $post_id );

			echo  '</form>';
		endif;
		?>
    </div><!-- #respond -->
	<?php
	/**
	 * Fires after the comment form.
	 */
	do_action( 'comment_form_after' );
}