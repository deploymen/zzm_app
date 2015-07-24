// Sidebar Menu
function customiseMenubar(){
	var vpw = window.innerWidth;
	var titletabsection = $('#title-tab-section');
	var leftsidebar = $('.left-sidebar');
	var lsmenuitem = $('.left-sidebar li a');
	var pagecontentwrapper = $('.page-content-wrapper');
	var pageurl = window.location.href;

	if(vpw < 640) {
		titletabsection.addClass("middle");
	} else if(vpw >= 1026 && vpw <= 1279) {
		leftsidebar.mouseover(function(){
			pagecontentwrapper.stop().animate({
			    paddingLeft: "300px"
			  }, 300 );
		});

		leftsidebar.mouseout(function(){
			pagecontentwrapper.stop().animate({
			    paddingLeft: "100px"
			  }, 300 );
		});
	} else {
		titletabsection.removeClass("middle");
	}

	// Highlight active tab
	lsmenuitem.filter(function(){
		return this.href === pageurl;
	}).addClass('active');

};

// Sign Up Form
var btnsignup = $('#btn-signup');

function signup(){
	var signUpForm = $('#signup-form');
	var signUpName = $('#users_name');
	var signUpEmail = $('#users_email');
	var signUpPewPew = $('#users_password');
	var signUpCountry = $('#users_country');

	signUpForm.on('valid.fndtn.abide', function(){
		// The following variable "signupRole" NEEDS to be inside this function
		// Or else it is "undefined"
		// Don't ask me why, I really don't know
		var signupRole = $('#signup-form input[name=role]:checked');

		var signUpCred = {
			name 	 : signUpName.val(),
			email	 : signUpEmail.val(),
			password : signUpPewPew.val(),
			country	 : signUpCountry.val(),
			role     : signupRole.val()
		}

		$.ajax({
			type	: 'POST',
			url		: '/api/auth/sign-up',
			data	: signUpCred,
			success	: function(data, status){
				if(data && status==='success'){
					//window.location = '/user/profiles';//
				}
			},

			error	: function(data){
				//alert('Harlp, this is not an error!');
			}
		});

		function repsonseMsg(){
			// if(signUpCred){
			// 	window.location = '/user/profiles';	
			// } else {
			// 	alert("Please fill in the form");
			// }
			alert("Please fill in the form");
		};

		function errorMsg(){
			alert('Harlp, this is not an error!');
		};

		return false;
	});
};

btnsignup.click(function(){
	signup();
});
//End Sign Up Form

// Login Form
var btnsignin = $('#btn-signin');

function login(){
	var loginUsername = $('#users_login_email');
	var loginPewPew = $('#users_login_password');
	var loginForm = $('#login-form');

	var loginformholder = $('#signup-holder');
	var incorrectdetails = $('#incorrect-details');
	
	loginForm.on('valid.fndtn.abide', function(){
		var loginCred = {
			username : loginUsername.val(),
			password : loginPewPew.val()
		}

		$.ajax({
			type	   : 'POST', 
			url        : '/api/auth/sign-in',
			data       : loginCred,
			success    : function(data){
				var status = data['status'];
				//console.log('status: ' + status);
				//repsonseMsg();
				if(status === 'success') {
					window.location = '/user/profiles';
				} else if(status === 'fail') {
					loginformholder.prepend('<span class="incorrect-details"><p>Invalid email or password</p></span>');
					loginUsername.val('');
					loginPewPew.val('');
				}
			}
		});

		return false;
	});
};
btnsignin.click(function(){
	login();
});

//End Login Form


var btnlogout = $('#button-logout');

function logout(){
	var sessionval = Cookies.get('access_token');
	Cookies.remove('access_token');
	// Cookies.remove('zzmcookie', { path: '' });
	// console.log(Cookies.get());
	// console.log('Wanna logout!');
	console.log(Cookies.get());
};

btnlogout.click(function(){
	logout();
});

// Wrong Password
// function unableToLogin() {
// 	var loginformholder = $('#signup-holder');

// 	var pageurl = document.URL.split('?')[1];
// 	if(pageurl === 'no-access'){
// 		loginformholder.prepend('<p class="incorrect-details">You are not signed in. Please check that your username or password is incorrect and try again.</p>');
// 	}
// }

(function($, window, document, undefined){
	$(document).foundation();

	// Sign Up and Login Form function calls
	customiseMenubar();

	$( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();

})(jQuery, this, this.document);