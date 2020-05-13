jQuery.extend(jQuery.fn, {
    /*
     * проверка, если значение поля не превышает 3 символов (для имени и комментария)
     */
    validateAuthor: function () {
        if (jQuery(this).val().length < 3) {
            jQuery(this).addClass('error').before('<span class="comment-error-name">Пожалуйста, введите ваше Имя.</span>');
            return false
        } else {
            jQuery(this).removeClass('error');
            jQuery('.comment-error-name').remove();return true
        }
    },
    validateComment: function () {
        if (jQuery(this).val().length < 3) {
            jQuery(this).addClass('error').before('<span class="comment-error-comments">Пожалуйста, введите ваш Комментарий.</span>');
            return false
        } else {
            jQuery(this).removeClass('error');
            jQuery('.comment-error-comments').remove();return true
        }
    },
    /*
     * проверьте правильность электронной почты
	 * добавьте в свой CSS стили поля .error, например border-color: red;
     */
    validateEmail: function () {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/,
            emailToValidate = jQuery(this).val();
        if (!emailReg.test( emailToValidate ) || emailToValidate == "") {
            jQuery(this).addClass('error').before('<span class="comment-error-email">Пожалуйста, введите адрес вашей Электронной почты.</span>');
            return false
        } else {
            jQuery(this).removeClass('error');
            jQuery('.comment-error-email').remove();return true
        }
    },
});

jQuery(function($){

    /*
     * При заполнении формы комментария
     */
    $( '#commentform' ).submit(function(){

        // определяем некоторые переменные
        var button = $('#submit'), // кнопка отправки
            respond = $('#respond'), // контейнер формы коментария
            commentlist = $('.commentlist'), // контейнер списка коминтариев
            cancelreplylink = $('#cancel-comment-reply-link');

        // если пользователь залогинился то не проверять поля автора и поле эллетронной почты
        // noinspection JSJQueryEfficiency
        if( $( '#author' ).length )
            $( '#author' ).validateAuthor();

        // noinspection JSJQueryEfficiency
        if( $( '#email' ).length )
            $( '#email' ).validateEmail();

        // проверить коментарий в любом случае
            // noinspection JSJQueryEfficiency
        $( '#comment' ).validateComment();

        // если форма комментария не обрабатывается, отправить ее,
        if ( !button.hasClass('loadingform') && $( '.comment-form-author' ).has('.comment-error-name').length === 0 &&  $( '.comment-form-email').has('.comment-error-email').length === 0 &&  $( '.comment-form-comment' ).has('.comment-error-comments').length === 0){

            // запрос ajax
            $.ajax({
                type : 'POST',
                url : feedback_object.ajaxurl, // admin-ajax.php URL
                data: $(this).serialize() + '&action=ajaxcomments', // отправка данных формы (serialize() -  jQuery кодирует набор только успешных элементов формы в виде строки для отправки) + параметр действия
                beforeSend: function(xhr){
                    // что делать сразу после отправки формы
                    button.addClass('loadingform').val('Загружается...');
                },
                error: function (request, status, error) {
                    if( status == 500 ){
                        alert( 'Произошла ошибка сервера при добавлении Комментария' );
                    } else if( status == 'timeout' ){
                        alert('Ошибка : Сервер не отвечает.');
                    } else {
                        // обрабатываем ошибки WordPress
                        var wpErrorHtml = request.responseText.split("<p>"),
                            wpErrorStr = wpErrorHtml[1].split("</p>");
                        alert( 'Ошибка сервера : ' + wpErrorStr[0] );
                    }
                },
                success: function ( addedCommentHTML ) {

                    if (addedCommentHTML.success === false){
                        $.each(addedCommentHTML.data, function (key, val) {
                            // noinspection JSJQueryEfficiency
                            $('.comment-' + key).addClass('error');
                            // noinspection JSJQueryEfficiency
                            $('.comment-' + key).before('<span class="comment-error-' + key + '">' + val + '</span>');
                        });
                        $('#submit').val('Что-то пошло не так...');
                    }

                    // если в этом сообщении уже есть комментарии,
                    if( commentlist.length > 0 ){

                        // если в ответе на другой комментарий
                        if( respond.parent().hasClass( 'comment' ) ){

                            // если существуют другие ответы
                            if( respond.parent().children( '.children' ).length ){
                                respond.parent().children( '.children' ).append( addedCommentHTML );
                                commentlist.after( jQuery('#respond') );

                            }
                            else {
                                // если ответов нет, добавляем <ul class = "children">
                                addedCommentHTML = '<ul class="children">' + addedCommentHTML + '</ul>';
                                respond.parent().append( addedCommentHTML );
                                commentlist.after( jQuery('#respond') );

                            }
                            // закрыть форму ответа
                            cancelreplylink.trigger("click");
                        }
                        else {
                            // простой коментарий
                            commentlist.append( addedCommentHTML );
                            commentlist.after( jQuery('#respond') );

                        }
                    }else{
                        // если коментариев ещё нет
                        addedCommentHTML = '<ul class="commentlist">' + addedCommentHTML + '</ul>';
                        respond.before( $(addedCommentHTML) );
                    }
                    // очищаем поле текста коментария
                    $('#commentform').resetForm();
                },
                complete: function(){
                    // что делать после добавления комментария
                    button.removeClass( 'loadingform' ).val( 'Отправить коментарий' );
                }
            });
        }
        return false;
    });
});