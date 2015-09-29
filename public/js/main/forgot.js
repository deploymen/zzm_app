var forgotbtn = $('#btn-reset-password');
var btnokreset = $('#btn-ok-reset');
var forgotholder = $('#forgot-pw-holder');

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
		url      	: '/api/1.0/auth/forgot-password',
		data        : recoverydata,
		success  	: function(data){
			var status = data['status'];
			var message = data['message'];

			console.log(status);

			if (status === 'success') {
				// forgotform.css({
				// 	display: 'none'
				// });

				// forgotafter.removeClass('hideit');
				// emailforreset.text(emailresetinput.val());
				forgotholder.prepend('<span class="incorrect-details"><p>A reset email has been sent to '+ emailresetinput.val() +'</p></span>');
				emailresetinput.val('');
			} else if (status === 'fail' && message === 'user not found') {
				forgotholder.prepend('<span class="incorrect-details"><p>User not found</p></span>');
			} else if (status === 'fail' && message === 'invalid email format') {
				forgotholder.prepend('<span class="incorrect-details"><p>Invalid email format</p></span>');
			}
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