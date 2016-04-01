/*
 Cookies method
 */
function createCookie(name, value, days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = "; expires=" + date.toGMTString();
    }
    else {
        var expires = "";
        document.cookie = name + "=" + value + expires + "; path=/";
    }
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0)
            return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name, "", -1);
}

/*
 End Cookies method
 */

/*
 Ouibounce method
 */
// if you want to use the 'fire' or 'disable' fn,
// you need to save OuiBounce to an object

var x = readCookie('zzmcookie')
if (!x) {
    // If no cookies, show ouibounce
    var _ouibounce = ouibounce(document.getElementById('ouibounce-modal'), {
        aggressive: true,
        timer: 0,
        callback: function () {
        }
    });
}

// From Index Page button Clicked
function buttonClicked() {
    $('#ouibounce-modal').show();
}

function closeModal() {
    $('#ouibounce-modal').hide();

    // Create Cookies so that user will see it only once a day
    createCookie('zzmcookie', 'plcookie', 1);
}

$('#ouibounce-modal .modal-footer').on('click', function () {
    $('#ouibounce-modal').hide();

    // Create Cookies so that user will see it only once a day
    // createCookie('zzmcookie','plcookie',1);
});

$('#ouibounce-modal .modal').on('click', function (e) {
    e.stopPropagation();
});

/*
 Ouibounce method
 Submitting the form to zapzapmath subscription API.
 Date: 7 April 2015 
 */
function submitForm() {
    var email = $('#signup-form-email-exitpop').val();

    var email_data = {
        email: email
    }
    // Validate the Email
    if (validateEmail(email)) {
        $.ajax({
            type: 'POST',
            url: '/api/1.0/pre-launch/subscribe',
            data: email_data,
            success: function () {
                $('#ouibounce-modal').hide();
                responseMsg("Hooray!", "Thank you for signing up!<br />We will contact you if you've been chosen.");

                // Create Cookies
                createCookie('zzmcookie', 'plcookie', 365 * 10);
            },
            error: function () {
                responseMsg("Opps!", "I am sorry. Your email is not collected. <br />Please try again.");

                // Create Cookies so that user will see it only once a day
                createCookie('zzmcookie', 'plcookie', 1);

                $('#ouibounce-modal').hide();
            }
        });


        return false;
    } else {
        responseMsg('Opps', 'Please insert a valid email.');
    }

}

// Message Box function  
function responseMsg(title, body) {
    var messageboxwrapper = $('#message-box-wrapper');
    messageboxwrapper.css('display', 'block');
    messageboxwrapper.append("<div id='message-box' class='signup-success'><h2>" + title + "</h2><p class='hooray-desc'>" + body + "</p><button id='btn-success-ok' class='btn btn--green' onClick='closeMessage()'>OK</button></div>");

}

// Close the message box wrapper
function closeMessage() {
    $('#message-box-wrapper').fadeOut('fast');
}

function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}