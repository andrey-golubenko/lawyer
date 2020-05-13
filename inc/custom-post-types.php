<?php		/* РЕГИСТРИРУЕМ типы ПОСТОВ для ввывода КЛИЕНТОВ и членов КОМАНДЫ */
add_action( 'init', function (){
	register_post_type('team', array(
		'labels' => array(
			'name'          => 'Наша Команда', //основное название для типа записи
			'singular_name' => 'Профиль Юриста', //назван для одной записи
			'add_new'       => 'Добавить профиль Юриста', // для добавления новой записи
			'add_new_item'  => 'Добавление профиля Юриста', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'     => 'Редактирование профиля Юриста', // для редактирования типа записи
			'new_item'      => 'Новый профиль Юриста', // текст новой записи
			'view_item'     => 'Смотреть профиль Юриста', // для просмотра записи этого типа.
			'search_items'  => 'Искать профиль Юриста', // для поиска по этим типам записи
			'not_found'     => 'Не найдено', // если в результате поиска ничего не было найдено
			'menu_name'     => 'Наша Команда', // название меню
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		//'rewrite'            => true,
		'menu_icon'          => 'dashicons-universal-access-alt',
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'            => [ 'title', 'author', 'thumbnail', 'revisions'],
	) );
	register_post_type('reviews', array(
		'labels' => array(
			'name'          => 'Отзывы Клиентов', // основ. назван для типа записи
			'singular_name' => 'Профиль отзыва Клиента', // название для одной записи этого типа
			'add_new'       => 'Добавить отзыв Клиента', // для добавления новой записи
			'add_new_item'  => 'Добавление отзыва Клиента', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'     => 'Редактирование отзыва Клиента', // для редактирования типа записи
			'new_item'      => 'Новый отзыв Клиента', // текст новой записи
			'view_item'     => 'Смотреть отзыв Клиента', // для просмотра записи этого типа.
			'search_items'  => 'Искать отзыв Клиента', // для поиска по этим типам записи
			'not_found'     => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Отзывы Клиентов', // название меню
		),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		//'rewrite'            => true,
		'menu_icon'          => 'dashicons-buddicons-buddypress-logo',
		'capability_type'    => 'post',
		//'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'            => [ 'title', 'author', 'thumbnail', 'revisions'],
	) );	
});
//ВЫВОДИМ в шаблон (front-page) ВСЕ посты с членами КОМАНДЫ
function get_post_lawyers($amount_posts = -1){// "-1" - НЕОГРАНИЧЕННОЕ кол-во постов на странице, указываем по умолчанию, а в шаблоне меняем на нужное нам кол-во.
    return get_posts( array(
		'numberposts' => $amount_posts,
		'orderby'     => 'date',
		'order'       => 'ASC',
		'post_type'   => 'team',
		'post_status' => array( 'publish' ),
    ) );

}
//ВЫВОДИМ в шаблон (front-page) ВСЕ посты с КЛИЕНТАМИ
function get_post_reviews(){
	return get_posts( array(		
		'order'       => 'ASC',
		'post_type'   => 'reviews',
	) );
}


		/** ДОПОЛНИТЕЛЬНЫЕ МЕТАБОКСЫ к типам постов - 'team' и 'reviews'. **/

// Подключаем функцию активации мета блока (my_extra_fields)
add_action('add_meta_boxes', 'my_extra_fields', 1);
function my_extra_fields() {
	add_meta_box( 'extra_fields_lawyers', 'Поля профиля Юриста', 'extra_fields_box_lawyers', 'team', 'normal', 'high');
	add_meta_box( 'extra_fields_clients', 'Поля отзыва Клиента', 'extra_fields_box_clients', 'reviews', 'normal', 'high'  );
}
// Код блока lawyers в МЕТАБОКСЕ админки
function extra_fields_box_lawyers( $post ){

	?>
	<p style="font-size: 18px;"><span>Введите Специализацию Юриста :</span>
		<label><input type="text" name="extra[specialty]" value="<?php echo esc_attr(get_post_meta($post->ID, 'specialty', 1)); ?>" style="width:100%; margin-top: 10px; font-size: 16px;" /></label>
	</p>
	<p id="lawyer-desc" style="font-size: 18px;"><span>Введите краткое (не более 300 символов) описание достоинств Юриста, либо иную информацию о Юристе (<ins>пробелы и другие знаки пунктуации так же являются символами</ins>) :</span>
		<textarea type="text" name="extra[description]" id="field-lawyer-desc" maxlength="300" style="width:100%;height:50px; margin-top: 10px; font-size: 16px;"><?php echo esc_attr(get_post_meta($post->ID, 'description', 1)); ?></textarea>
		<span>Количество введённых Вами символов : </span><strong style="color:red;"><?php echo mb_strlen(esc_attr(get_post_meta($post->ID, 'description', 1))) ; ?></strong>
	</p>
	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	<?php
}
// Код блока clients в  МЕТАБОКСЕ админки
function extra_fields_box_clients( $post ){
	?>
	<p style="font-size: 18px;"><span>Введите характеристики Клиента:</span>
		<label><input type="text" name="extra_client[kind]" value="<?php echo esc_attr(get_post_meta($post->ID, 'kind', 1)); ?>" style="width:100%; margin-top: 10px; font-size: 16px;" /></label>
	</p>
	<p id="client-desc" style="font-size: 18px;"><span>Введите краткий (200 символов) отзыв Клиента (<ins>пробелы и другие знаки пунктуации так же являются символами</ins>) :</span>
		<textarea type="text" name="extra_client[description]" id="field-client-desc" style="width:100%;height:50px; margin-top: 10px; font-size: 16px;"><?php echo esc_attr(get_post_meta($post->ID, 'description', 1)); ?></textarea>
		<span>Количество введённых Вами символов : </span><strong style="color:red;"><?php echo mb_strlen(esc_attr(get_post_meta($post->ID, 'description', 1))) ; ?></strong>
	</p>
	<input type="hidden" name="extra_fields_clients_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	<?php
}
// Включаем обновление полей при сохранении
add_action( 'save_post', 'my_extra_fields_update', 0 );
## Сохраняем данные, при сохранении поста
function my_extra_fields_update( $post_id ){
	if ($_POST['extra']){// базовая проверка
		if (
			empty( $_POST['extra'] )
			|| ! wp_verify_nonce( $_POST['extra_fields_nonce'], __FILE__ )
			|| wp_is_post_autosave( $post_id )
			|| wp_is_post_revision( $post_id )
		)
			return false;
		// Все ОК! Теперь, нужно сохранить/удалить данные
		$_POST['extra'] = array_map( 'sanitize_text_field', $_POST['extra'] ); // чистим все данные от пробелов по краям
		foreach( $_POST['extra'] as $key => $value ){
			//Обрезаем текст у поля 'description' до 280 символов, чтобы не ломать вёрстку
			if ($key === 'description') {
				$maxchar = 300;
				if ( mb_strlen( $value ) > $maxchar ){
					$value = mb_substr( $value, 0, $maxchar );
				}
			}
			if( empty($value) ){
				delete_post_meta( $post_id, $key ); // удаляем поле если значение пустое
				continue;
			}
			update_post_meta( $post_id, $key, $value ); // add_post_meta() работает автоматически
		}
		return $post_id;}
	elseif ($_POST['extra_client']){// базовая проверка
		if (
			empty( $_POST['extra_client'] )
			|| ! wp_verify_nonce( $_POST['extra_fields_clients_nonce'], __FILE__ )
			|| wp_is_post_autosave( $post_id )
			|| wp_is_post_revision( $post_id )
		)
			return false;
		// Все ОК! Теперь, нужно сохранить/удалить данные
		$_POST['extra_client'] = array_map( 'sanitize_text_field', $_POST['extra_client'] ); // чистим все данные от пробелов по краям
		foreach( $_POST['extra_client'] as $key => $value ){
					//Обрезаем текст у поля 'description' до 200 символов, чтобы не ломать вёрстку
			if ($key === 'description') {
				$maxchar = 200;
				if ( mb_strlen( $value ) > $maxchar ){
					$value = mb_substr( $value, 0, $maxchar );
				}
			}

			if( empty($value) ){
				delete_post_meta( $post_id, $key ); // удаляем поле если значение пустое
				continue;
			}
			update_post_meta( $post_id, $key, $value ); // add_post_meta() работает автоматически
		}
		return $post_id;}
	return false;
}

//ДОБАВЛЕНИЕ надписи над полем заголовка записи (ПОСТА) в админке в ТИПАХ ПОСТОВ 'team' и 'reviews'.
add_action( 'edit_form_top', 'callback__edit_form_top' );
function callback__edit_form_top( $post) {
	if ($post->post_type === 'team'):
		?>
	<div style="margin: 20px auto 10px auto; color: #000; font-size: 20px;">
		Введите имя и фамилию Юриста :
	</div>
		<?php
	elseif ($post->post_type === 'reviews'):
		?>
		<div style="margin: 20px auto 10px auto; color: #000; font-size: 20px;">
			Введите имя и фамилию Клиента:
		</div>
	<?php
	endif;
}
//УБИРАЕМ плейсхолдер в поле 'title' админки в ТИПАХ ПОСТОВ 'team' и 'reviews'.
add_filter( 'enter_title_here', 'lawyer_enter_title_here', 10, 2 );
function lawyer_enter_title_here( $text, $post ) {
	if ( $post->post_type === 'team' || $post->post_type === 'reviews' ) {
		$text = '';
	}
	return $text;
}