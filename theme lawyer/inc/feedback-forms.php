<?php  				/* ШОРТКОД Вывода Большой ФОРМЫ * @return string */
add_shortcode( 'art_feedback', 'art_feedback' );
function art_feedback() {
	ob_start();
	?>
    <form id="add_feedback">
        <div class="form-group">
            <input type="text" name="art_name" id="art_name" class="required art_name form-control" placeholder="Ваше Имя" value=""/>
        </div>
        <div class="form-group">
            <input type="email" name="art_email" id="art_email" class="required art_email form-control" placeholder="Ваш E-Mail" value=""/>
        </div>
        <div class="form-group">
            <input type="text" name="art_subject" id="art_subject" class="art_subject form-control" placeholder="Тема сообщения" value=""/>
        </div>
        <div class="form-group">
            <textarea name="art_comments" id="art_comments" placeholder="Сообщение" cols="30" rows="7" class="required art_comments form-control"></textarea>
        </div>
            <input type="checkbox" name="art_anticheck" id="art_anticheck" class="art_anticheck" style="display: none !important;" value="true" checked="checked"/>
            <input type="text" name="art_submitted" id="art_submitted" value="" style="display: none !important;"/>
        <div class="form-group">
    <?php if (is_page(49)) : ?>
            <input type="submit" id="submit-feedback" class="btn btn-primary py-3 px-5 align-content-center" value="Отправить сообщение"/>
    <?php else: ?>
            <input type="submit" id="submit-feedback" class="btn btn-primary py-3 px-3" value="Отправить сообщение"/>
    <?php endif; ?>
        </div>
    </form>
	<?php return ob_get_clean();
}

					/* ОБРАБОТКА скрипта Большой ФОРМЫ */

add_action( 'wp_ajax_feedback_action', 'ajax_action_callback' );
add_action( 'wp_ajax_nopriv_feedback_action', 'ajax_action_callback' );
function ajax_action_callback() {
// Массив ошибок
	$err_message = array();
// Проверяем nonce. Если проверкане прошла, то блокируем отправку
	if ( ! wp_verify_nonce( $_POST['nonce'], 'feedback-nonce' ) ) {
		wp_die( 'Данные отправлены с левого адреса' );
	}
// Проверяем на спам. Если скрытое поле заполнено или снят чек, то блокируем отправку
	if ( false === $_POST['art_anticheck'] || ! empty( $_POST['art_submitted'] ) ) {
		wp_die( 'Пошел нахрен, мальчик!(c)' );
	}
// Проверяем поле имени, если пустое, то пишем сообщение в массив ошибок
	if ( empty( $_POST['art_name'] ) || ! isset( $_POST['art_name'] ) ) {
		$err_message['name'] = 'Пожалуйста, введите ваше имя.';
	} else {
		$art_name = esc_attr(sanitize_text_field( $_POST['art_name'] ));
	}
// Проверяем поле емайла, если пустое, то пишем сообщение в массив ошибок
	if ( empty( $_POST['art_email'] ) || ! isset( $_POST['art_email'] ) ) {
		$err_message['email'] = 'Пожалуйста, введите адрес вашей электронной почты.';
	} elseif ( ! preg_match( '/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i', $_POST['art_email'] ) ) {
		$err_message['email'] = 'Адрес электронной почты некорректный.';
	} else {
		$art_email = esc_attr(sanitize_email( $_POST['art_email'] ));
	}
// Проверяем поле темы письма, если пустое, то пишем сообщение по умолчанию
	if ( empty( $_POST['art_subject'] ) || ! isset( $_POST['art_subject'] ) ) {
		$art_subject = 'Message from your site !';
	} else {
		$art_subject = esc_attr(sanitize_text_field( $_POST['art_subject'] ));
	}
// Проверяем полей сообщения, если пустое, то пишем сообщение в массив ошибок
	if ( empty( $_POST['art_comments'] ) || ! isset( $_POST['art_comments'] ) ) {
		$err_message['comments'] = 'Пожалуйста, введите ваше сообщение.';
	} else {
		$art_comments = esc_attr(sanitize_textarea_field( $_POST['art_comments'] ));
	}
// Проверяем массив ошибок, если не пустой, то передаем сообщение. Иначе отправляем письмо
	if ( $err_message ) {
		wp_send_json_error( $err_message );
	}
	else {
// Указываем адресат
		$email_to = '';
// Если адресат не указан, то берем данные из настроек сайта
		if ( ! $email_to ) {
			$email_to = get_option( 'admin_email' );
		}
		$body    = "Имя: $art_name \nEmail: $art_email \n\nСообщение: $art_comments";
		$headers = 'From: ' . $art_name . ' <' . $email_to . '>' . "\r\n" . 'Reply-To: ' . $email_to;
// Отправляем письмо
		wp_mail( $email_to, $art_subject, $body, $headers );
// Отправляем сообщение об успешной отправке
		$message_success = 'Собщение отправлено. В ближайшее время я свяжусь с вами.';
		wp_send_json_success( $message_success );

// На всякий случай убиваем еще раз процесс ajax
		wp_die();
	}
}

					/* ОБРАБОТКА скрипта Малой ФОРМЫ */

add_action( 'wp_ajax_feedback_action_small', 'ajax_action_callback_small' );
add_action( 'wp_ajax_nopriv_feedback_action_small', 'ajax_action_callback_small' );
function ajax_action_callback_small() {
// Массив ошибок
	$err_message = array();
// Проверяем nonce. Если проверкане прошла, то блокируем отправку
	if ( ! wp_verify_nonce( $_POST['nonce'], 'feedback-nonce' ) ) {
		wp_die( 'Данные отправлены с левого адреса' );
	}
// Проверяем на спам. Если скрытое поле заполнено или снят чек, то блокируем отправку
	if ( false === $_POST['art_anticheck_small'] || ! empty( $_POST['art_submitted_small'] ) ) {
		wp_die( 'Пошел нахрен, мальчик!(c)' );
	}

// Проверяем поле емайла, если пустое, то пишем сообщение в массив ошибок
	if ( empty( $_POST['art_email_small'] ) || ! isset( $_POST['art_email_small'] ) ) {
		$err_message['email'] = 'Пожалуйста, введите адрес вашей электронной почты.';
	}
	elseif ( ! preg_match( '/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i', $_POST['art_email_small'] ) ) {
		$err_message['email'] = 'Адрес электронной почты некорректный.';
	}
	else {
		$art_email = esc_attr(sanitize_email( $_POST['art_email_small'] ));
	}
// Пишем тему письма по умолчанию
		$art_subject = 'Message from your site !';
// Проверяем массив ошибок, если не пустой, то передаем сообщение. Иначе отправляем письмо
	if ( $err_message ) {
		wp_send_json_error( $err_message );
	}
	else {
// Указываем адресат
		$email_to = '';
// Если адресат не указан, то берем данные из настроек сайта
		if ( ! $email_to ) {
			$email_to = get_option( 'admin_email' );
		}
		$body    = "Мой Email: $art_email \nХочу полуть рассылку новостей!";
		$headers = 'From: <' . $email_to . '>' . "\r\n" . 'Reply-To: ' . $email_to;
// Отправляем письмо
		wp_mail( $email_to, $art_subject, $body, $headers );
// Отправляем сообщение об успешной отправке
		$message_success = 'Рад Вашей подписке. Интересные новости будут приходить раз или два в месяц.';
		wp_send_json_success( $message_success );

// На всякий случай убиваем еще раз процесс ajax
		wp_die();
	}
}