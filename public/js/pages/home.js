$(document).ready(function () {
    initWow();
    initTabletSlider();
    initUfoShoot();
    initEmailOptIn();
});

function initTabletSlider() {
    $('.slide-holder').slick({
        autoplay: true,
        autoplaySpeed: 4000
    });
}

function initUfoShoot() {
    if (window.innerWidth > 641) {
        ufoshoot();
    }

    function ufoshoot() {
        var tlcomet1 = TweenMax.to($('#comet1'), 3, {x: -2000, y: 2000, delay: 1, repeat: 50, repeatDelay: 10});
        var tlcomet2 = TweenMax.to($('#comet2'), 2, {x: -2000, y: 2000, delay: 4, repeat: 50, repeatDelay: 10});
        var tlcomet3 = TweenMax.to($('#comet3'), 5, {x: -2000, y: 2000, delay: 6, repeat: 50, repeatDelay: 10});

        var ufo = $('#ufo-shooter');
        var duration = (Math.floor(Math.random() * (8)) + 1) * 1000;
        setTimeout(function () {
            ufo.addClass('spacecraft-shoot');
            setTimeout(function () {
                ufo.removeClass('spacecraft-shoot');
                ufoshoot(duration);
            }, 1000);
        }, duration);
    }
}

function initEmailOptIn() {
    $('#form-register-newsletter').on('valid.fndtn.abide', function (e) {
        var formResponseMessages = $('#opt-newsletter-feedback');
        formResponseMessages.empty();

        var data = {
            email: $('#newsletter-email-field').val(),
            launch_notified: 0,
            news_letter: 1
        }

        $.ajax({
            type: 'POST',
            url: '/api/1.0/launch-notification',
            data: data,
            success: function (data) {
                if (data['status'] === 'success') {
                    formResponseMessages.append('<p class="success">You have successfully signed up!</p>');
                } else {
                    formResponseMessages.append('<p class="error">' + data['message'] + '</p>');
                }
            },
            error: function (data) {
                formResponseMessages.append('<p class="error">Error :(</p>');
            }
        });

        return false;
    });
}

function initWow() {
    if (window.innerWidth >= 570) {
        var wow = new WOW({
            animateClass: 'animated',
            offset: 100
        });
        wow.init();
    }
}
