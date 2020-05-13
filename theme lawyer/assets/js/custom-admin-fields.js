
(function($) {

	"use strict";

//В документации jQuery  рекоменд. использ. для textarea, но работает и без него
/*$.valHooks.textarea = {
  get: function( elem ) {
    return elem.value.replace( /\r?\n/g, "\r\n" );
  }
};
*/

					//Поле ОПИСАНИЯ ЮРИСТА в АДМИНКЕ

function count_lawyerDesc (){
const lawyerDesc = $(this).val();
const simbolCount = lawyerDesc.length;
	$('strong').remove();
	$('#lawyer-desc').append(`<strong style="color:red;">${simbolCount}</strong>`);
};
$('#field-lawyer-desc').on("keyup", count_lawyerDesc);
$('#field-lawyer-desc').on("paste", count_lawyerDesc);


					//Поле ОПИСАНИЯ КЛИЕНТА в АДМИНКЕ

function count_clientDesc (){
const clientDesc = $(this).val();
const simbolCount = clientDesc.length;
	$('strong').remove();
	$('#client-desc').append(`<strong style="color:red;">${simbolCount}</strong>`);
}
$('#field-client-desc').on("keyup", count_clientDesc);
$('#field-client-desc').on("paste", count_clientDesc);

})(jQuery);