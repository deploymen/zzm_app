var btnresetpwd = $('#btn-reset-password');

function resetPassword(){
	var resetpwd = $('#confirmResetPassword').val();


	var resetpath = window.location.pathname.split( '/' );
	var resetc = resetpath[3];
	console.log(resetpath);

	var resetdetails = {
		password : resetpwd,
		secret   : resetc
	}

	$.ajax({
		type     : 'PUT',
		url      : '/api/auth/reset-password',
		data     : resetdetails,
		success  : function(){
			console.log(resetpwd);
			console.log(resetc);
		}
	});
}


(function($, window, document, undefined){
	btnresetpwd.click(function(){
		resetPassword();
	});

})(jQuery, this, this.document);