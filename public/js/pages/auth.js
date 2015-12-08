/**
 * Sign up
 */
$('#signup-form').on('valid.fndtn.abide', function (e) {
    $('.loading').show();
    $('.hide-on-submit').hide();

    var formResponseMessages = $('#form-response-messages');

    // Clear previous submit errors if any
    formResponseMessages.empty();

    var signUpCred = {
        name: $('#users_name').val(),
        email: $('#users_email').val(),
        password: $('#users_password').val(),
        country: $('#users_country').val(),
        role: $('#signup-form input[name=role]:checked').val()
    }

    $.ajax({
        type: 'POST',
        url: '/api/1.0/auth/sign-up',
        data: signUpCred,
        success: function (data) {
            $('.loading').hide();
            var status = data['status'];
            var message = data['message'];

            if (status === 'success') {
                formResponseMessages.append('<p class="success">Your account has been created. Please check your email for an activation link.</p>');
            } else {
                $('.hide-on-submit').show();

                if (message === 'password must be atleast 6 chars') {
                    formResponseMessages.append('<p>Password must be at least 6 characters long.</p>');
                } else if (message === 'email used') {
                    formResponseMessages.append('<p class="error">E-mail address is already in use.</p>');
                } else {
                    formResponseMessages.append('<p class="error">Error submitting form.</p>');
                }
            }
        },
        error: function (data) {
            $('.loading').hide();
            $('.hide-on-submit').show();
            formResponseMessages.append('<p class="error">Error submitting form.</p>');
        }
    });

    return false;
});

/**
 * Sign in
 */
$('#login-form').on('valid.fndtn.abide', function (e) {
    $('.loading').show();
    $('.hide-on-submit').hide();

    var formResponseMessages = $('#form-response-messages');
    var loginUsername = $('#users_login_email');
    var loginPassword = $('#users_login_password');

    // Clear previous submit errors if any
    formResponseMessages.empty();

    var loginCred = {
        username: loginUsername.val(),
        password: loginPassword.val()
    };

    $.ajax({
        type: 'POST',
        url: '/api/1.0/auth/sign-in',
        data: loginCred,
        success: function (data) {
            var status = data['status'];
            var message = data['message'];
            if (status === 'success') {
                window.location = '/user/welcome';
            } else if (status === 'fail') {
                if (message === 'invalid username/password') {
                    formResponseMessages.append('<p class="error">Invalid email or password.</p>');
                } else if (message === 'account is not activated') {
                    formResponseMessages.append('<p class="error">Account has not been activated yet.</p>');
                } else {
                    formResponseMessages.append('<p class="error">Something went wrong when trying to sign you in.</p>');
                }

                $('.loading').hide();
                $('.hide-on-submit').show();
                loginPassword.val('');
            }
        },
        error: function (data) {
            $('.loading').hide();
            $('.hide-on-submit').show();
            formResponseMessages.append('<p class="error">Error logging in.</p>');
        }
    });

    return false;
});

/**
 * Forgot password
 */
$('#forgot-password-form').on('valid.fndtn.abide', function (e) {
    $('.loading').show();
    $('.hide-on-submit').hide();

    var formResponseMessages = $('#form-response-messages');

    // Clear previous submit errors if any
    formResponseMessages.empty();

    var emailresetinput = $('#users-reset-email');
    var recoverydata = {
        email: emailresetinput.val()
    }

    $.ajax({
        type: 'PUT',
        url: '/api/1.0/auth/forgot-password',
        data: recoverydata,
        success: function (data) {
            $('.loading').hide();

            var status = data['status'];
            var message = data['message'];
            if (status === 'success') {
                formResponseMessages.append('<p class="success">A reset email has been sent to ' + emailresetinput.val() + '.</p>');
                emailresetinput.val('');
            } else {
                $('.hide-on-submit').show();

                if (message === 'user not found') {
                    formResponseMessages.append('<p class="error">User not found.</p>');
                } else if (message === 'invalid email format') {
                    formResponseMessages.append('<p class="error">Invalid email format.</p>');
                } else {
                    formResponseMessages.append('<p class="error">Error sending password reset email.</p>');
                }
            }
        },
        error: function (data) {
            $('.hide-on-submit').show();
            formResponseMessages.append('<p class="error">Error sending password reset email.</p>');
        }
    });
});

/**
 * Reset password
 */
$('#reset-password-form').on('valid.fndtn.abide', function (e) {
    $('.loading').show();
    $('.hide-on-submit').hide();

    var password = $('#password');
    var passwordConfirm = $('#confirmResetPassword');
    var formResponseMessages = $('#form-response-messages');

    // Clear previous submit errors if any
    formResponseMessages.empty();

    var resetpath = window.location.pathname.split('/');
    var resetc = resetpath[3];

    var resetdetails = {
        password: passwordConfirm.val(),
        secret: resetc
    }

    $.ajax({
        type: 'PUT',
        url: '/api/1.0/auth/set-password',
        data: resetdetails,
        success: function (data) {
            $('.loading').hide();
            var status = data['status'];
            if (status === 'success') {
                password.val('');
                passwordConfirm.val('');
                formResponseMessages.append('<p class="success">Password reset. Please sign in <a href="/user/signin">here</a>.</p>');
            } else {
                $('.hide-on-submit').show();
                formResponseMessages.append('<p class="error">Error resetting password.</p>');
            }
        },
        error: function (data) {
            $('.loading').hide();
            $('.hide-on-submit').show();
            formResponseMessages.append('<p class="error">Error resetting password.</p>');
        }
    });

});