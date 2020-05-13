<?php
/* В КАСТОМАЙЗЕР ДОБОВЛЯЕМ возмность загрузки кастомного логотипа, кастомного видео */

add_action( 'customize_register', 'lawyer_appearance_uploader' );
function lawyer_appearance_uploader($wp_customize) {
						/*ЛОГОТИПы КАСТОМНЫе ДВа.*/
//Вывод в админ. панель возможности загружать ДВА и более custom-логотипа, видео . Использовать это вместо "add_theme_support(custon-logo, [])".
	$wp_customize->add_section( 'upload_custom_logo', array(
		'title'          => 'Логотип',
		'description'    => 'Отобразить Ваш Логотип?',
		'priority'       => 25,
	) );
	//Логотип Тёмный
	$wp_customize->add_setting( 'custom_logo', array(
		'default'        => '',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'custom_logo', array(
		'label'   => 'Ваш Логотип № 1 :',
		'section' => 'upload_custom_logo',
		'settings'   => 'custom_logo',
	) ) );
	//Логотип Светлый
	$wp_customize->add_setting( 'custom_logo2', array(
		'default'        => '',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'custom_logo2', array(
		'label'   => 'Ваш Логотип № 2 :',
		'section' => 'upload_custom_logo', // put the name of whatever section you want to add your settings
		'settings'   => 'custom_logo2',
	) ) );

						/* ПАНЕЛЬ ПРЕЗЕНТАЦИИ */
	$wp_customize->add_section( 'upload_custom_presentation', array(
		'title'          => 'Презентация',
		'description'    => 'Загрузите Ваши презентационные фото, видео и укажите Ваши презентационные данные :',
		'priority'       => 27,
	) );
							/* ФОТО ПРЕЗЕНТАЦИИ */
//Вывод в админ панель возможности загрузки фото.
	$wp_customize->add_setting ('custom_photo', array(
		'default' => '',
		'transport' => 'refresh',
	) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize,'custom_photo', array(
		'label'    	=> 'Ваше презентационное фото :',
		'section'  	=> 'upload_custom_presentation',
		'settings' 	=> 'custom_photo',
		'mime_type' => 'image',
	) ) );
							/* ВИДЕО ПРЕЗЕНТАЦИИ */
//Вывод в админ панель возможности загрузки видео.
	$wp_customize->add_setting ('custom_video', array(
		'default' 	=> 'Presentation video',
		'transport' => 'refresh',
	));
	$wp_customize->add_control('custom_video', array(
		'label'    	=> 'Название Вашего презентационногоо видео :',
		'section'  	=> 'upload_custom_presentation',
		'settings' 	=> 'custom_video',
		'type'     => 'text',
	 ) );

/* ВЫВОД в админ. панель возможности указывать КоличествА: ЧЛЕНОВ КОМАНДЫ, ПАРТНЁРОВ (Клиентов), ВЫЙГРАНЫХ ДЕЛ, НАГРАД. */
	//Гарантии конфеденциальности
	$wp_customize->add_setting ('custom_lawyers_amount', array(
		'default' 	=> '',
		'transport' => 'refresh',
	));
	$wp_customize->add_control( 'custom_lawyers_amount', array(
		'label'    => 'Укажите цифрами Процент гарантии конфеденциальности :',
		'section'  => 'upload_custom_presentation',
		'settings' => 'custom_lawyers_amount',
		'type'     => 'text',
	) ) ;
	//Количество часов для связи с клиентами
	$wp_customize->add_setting ('custom_trusted_clients', array(
		'default' 	=> '',
		'transport' => 'refresh',
	));
	$wp_customize->add_control( 'custom_trusted_clients', array(
		'label'    => 'Укажите цифрами Количество часов для связи с клиентами :',
		'section'  => 'upload_custom_presentation',
		'settings' => 'custom_trusted_clients',
		'type'     => 'text',
	) ) ;
	//Количество лет работы
	$wp_customize->add_setting ('custom_successful_cases', array(
		'default' 	=> '',
		'transport' => 'refresh',
	));
	$wp_customize->add_control( 'custom_successful_cases', array(
		'label'    => 'Укажите цифрами Количество лет работы на данном рынке :',
		'section'  => 'upload_custom_presentation',
		'settings' => 'custom_successful_cases',
		'type'     => 'text',
	) ) ;
	//Количество членов команды
	$wp_customize->add_setting ('custom_awards', array(
		'default' 	=> '',
		'transport' => 'refresh',
	));
	$wp_customize->add_control( 'custom_awards', array(
		'label'    => 'Укажите цифрами Количество членов Вашей команды :',
		'section'  => 'upload_custom_presentation',
		'settings' => 'custom_awards',
		'type'     => 'text',
	) ) ;
				/* СОЦИАЛЬНЫЕ СЕТИ в футере */
    //ПАНЕЛЬ Социальных сетей
	$wp_customize->add_section( 'social', array(
		'title'       => 'МЫ в Социальных Сетях',
		'description' => 'Укажите Ваши Адреса в Социальных сетях :',
		'priority'    => 28,
	) );
	//Твитер
	$wp_customize->add_setting ('social_twitter', array(
		'default' 	=> '',
		'transport' => 'refresh',
	));
	$wp_customize->add_control( 'social_twitter', array(
		'label'    => 'Укажите Ваш адрес в Twitter в формате "https://... и т.д." :',
		'section'  => 'social',
		'settings' => 'social_twitter',
		'type'     => 'text',
	) ) ;
	//Фейсбук
	$wp_customize->add_setting ('social_facebook', array(
		'default' 	=> '',
		'transport' => 'refresh',
	));
	$wp_customize->add_control( 'social_facebook', array(
		'label'    => 'Укажите Ваш адрес в Facebook  в формате "https://... и т.д." :',
		'section'  => 'social',
		'settings' => 'social_facebook',
		'type'     => 'text',
	) ) ;
	//Инстаграмм
	$wp_customize->add_setting ('social_instagram', array(
		'default' 	=> '',
		'transport' => 'refresh',
	));
	$wp_customize->add_control( 'social_instagram', array(
		'label'    => 'Укажите Ваш адрес в Instagram в формате "https://... и т.д." :',
		'section'  => 'social',
		'settings' => 'social_instagram',
		'type'     => 'text',
	) ) ;
						/* КОНТАКТЫ в Футере */
	$wp_customize->add_section( 'contacts', array(
		'title'       => 'Контакты',
		'description' => 'Укажите Ваш почтовый Адрес, Ваш номер Телефона, Ваш E-mail :',
		'priority'    => 29,
	) );
	//ПЕРВЫЙ Почтовый адрес
	$wp_customize->add_setting ('contacts_address', array(
		'default' 	=> '',
		'transport' => 'refresh',
	));
	$wp_customize->add_control( 'contacts_address', array(
		'label'    => 'Укажите Ваш ПОЧТОВЫЙ адрес :',
		'section'  => 'contacts',
		'settings' => 'contacts_address',
		'type'     => 'text',
	) );	
		//ВТОРОЙ Почтовый адрес
	$wp_customize->add_setting ('contacts_address2', array(
		'default' 	=> '',
		'transport' => 'refresh',
	));
	$wp_customize->add_control( 'contacts_address2', array(
		'label'    => 'Укажите Ваш ВТОРОЙ ПОЧТОВЫЙ адрес :',
		'section'  => 'contacts',
		'settings' => 'contacts_address2',
		'type'     => 'text',
	) );
	//Телефон
	$wp_customize->add_setting ('contacts_phone', array(
		'default' 	=> '',
		'transport' => 'refresh',
	));
	$wp_customize->add_control( 'contacts_phone', array(
		'label'    => 'Укажите Ваш номер телефона :',
		'section'  => 'contacts',
		'settings' => 'contacts_phone',
		'type'     => 'text',
	));
	//E-mail
	$wp_customize->add_setting ('contacts_e-mail', array(
		'default' 	=> '',
		'transport' => 'refresh',
	));
	$wp_customize->add_control( 'contacts_e-mail', array(
		'label'    => 'Укажите Ваш E-mail :',
		'section'  => 'contacts',
		'settings' => 'contacts_e-mail',
		'type'     => 'text',
	));
}