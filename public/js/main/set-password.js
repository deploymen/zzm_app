var btnresetpwd = $('#btn-reset-password');
var resetsuccess = $('#resetsuccess');

function resetPassword(){
	var resetpwd = $('#confirmResetPassword').val();

	var btnresetok = $('#btn-reset-ok');

	var modalbg = $('.reveal-modal-bg');

	var resetpath = window.location.pathname.split( '/' );
	var resetc = resetpath[3];

	var resetdetails = {
		password : resetpwd,
		secret   : resetc
	}

	$.ajax({
		type     : 'PUT',
		url      : '/api/auth/reset-password',
		data     : resetdetails,
		success  : function(){
			// modalbg.unbind();
			resetsuccess.foundation('reveal', 'open');
		}
	});
}


(function($, window, document, undefined){
	btnresetpwd.click(function(){
		resetPassword();
	});

	resetsuccess.click(function(){
		window.location = "/user/signin";
	});

})(jQuery, this, this.document);