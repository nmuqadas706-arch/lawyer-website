$(document).ready(function() {
    // Initialize AOS Animation
    AOS.init({
        once: true,
        offset: 50,
        duration: 800
    });

    // Preloader
    $(window).on('load', function() {
        $('#preloader').fadeOut('slow');
    });

    // Sticky Navbar
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('.navbar').addClass('scrolled');
        } else {
            $('.navbar').removeClass('scrolled');
        }

        // Scroll to Top Button Visibility
        if ($(this).scrollTop() > 300) {
            $('#scrollTopBtn').fadeIn();
        } else {
            $('#scrollTopBtn').fadeOut();
        }
    });

    // Scroll to Top Action
    $('#scrollTopBtn').click(function() {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });

    // Smooth Scrolling for Links
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if( target.length ) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 80
            }, 800);
        }
    });

    // Statistics Counter
    var counted = 0;
    $(window).scroll(function() {
        var oTop = $('.stats-section').offset()?.top - window.innerHeight;
        if (counted == 0 && $(window).scrollTop() > oTop) {
            $('.counter').each(function() {
                var $this = $(this),
                    countTo = $this.attr('data-target');
                $({
                    countNum: $this.text()
                }).animate({
                        countNum: countTo
                    },
                    {
                        duration: 2000,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $this.text(this.countNum);
                        }
                    });
            });
            counted = 1;
        }
    });
});
