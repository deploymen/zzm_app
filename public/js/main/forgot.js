var forgotbtn = $('#btn-reset-password');

function forgotPassword(){
	var email = $('#users-reset-email').val();

	$.ajax({
		type     : 'PUT',
		url      : '/api/auth/forgot-password',
		data     : email,
		dataType : 'json',
		success  : function(){
			alert('Reset link has been sent');
		}
	});
};
forgotbtn.click(function(){
	forgotPassword();
});

(function($, window, document, undefined){
	//
	
})(jQuery, this, this.document);