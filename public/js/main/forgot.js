var forgotbtn = $('#btn-reset-password');
var btnokreset = $('#btn-ok-reset');

function forgotPassword(){
	var forgotform = $('#forgot-password-form');
	var forgotafter = $('#forgot-after');
	var emailforreset = $('#email-for-reset');
	var emailresetinput = $('#users-reset-email');
	var recoverydata = {
		email      : emailresetinput.val()
	}

	$.ajax({
		type     	: 'PUT',
		url      	: '/api/auth/forgot-password',
		data        : recoverydata,
		success  	: function(){
			forgotform.css({
				display: 'none'
			});

			forgotafter.removeClass('hideit');
			emailforreset.text(emailresetinput.val());
		}
	});
};
forgotbtn.click(function(){
	forgotPassword();
});

btnokreset.click(function(){
	window.location = "/user/signin";
});

(function($, window, document, undefined){
	//
})(jQuery, this, this.document);