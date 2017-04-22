(function () {
    var rotateSlider;
    jQuery(function () {
        jQuery('#nav').on('click', 'a', function (e) {
            var active, theSlide;
            e = e != null ? e : { e: window.event };
            e.preventDefault();
            e.stopPropagation();
            if (jQuery('#nav').hasClass('active')) {
                return false;
            }
            jQuery('.focus').removeClass('focus');
            jQuery(this).addClass('focus');
            jQuery('#nav').addClass('active');
            theSlide = jQuery(this).attr('data-slide');
            active = jQuery('.active').attr('data-slide');
            jQuery('.slide').removeClass('active');
            return rotateSlider(theSlide, active);
        });
        setTimeout(function () {
            return jQuery('#nav a[data-slide="2"]').trigger('click');
        }, 1000);
        setTimeout(function () {
            return jQuery('#nav a[data-slide="3"]').trigger('click');
        }, 2400);
        setTimeout(function () {
            return jQuery('#nav a[data-slide="4"]').trigger('click');
        }, 3800);
        return setTimeout(function () {
            return jQuery('#nav a[data-slide="1"]').trigger('click');
        }, 5200);
    });
    rotateSlider = function (slide, active) {
        var delta, slides, theSlide;
        slides = {
            1: 'one',
            2: 'two',
            3: 'three',
            4: 'four'
        };
        theSlide = slides[slide];
        delta = Math.abs(slide - active);
        if (delta === 3 && active === '1') {
            jQuery('.slide[data-slide="' + slide + '"]').addClass('active');
            jQuery('.slider-inner').attr('class', 'slider-inner rotate two');
            setTimeout(function () {
                return jQuery('.slider-inner').attr('class', 'slider-inner rotate three');
            }, 400);
            setTimeout(function () {
                return jQuery('.slider-inner').attr('class', 'slider-inner rotate four');
            }, 800);
        } else if (delta === 3 && active === '4') {
            jQuery('.slide[data-slide="' + slide + '"]').addClass('active');
            jQuery('.slider-inner').attr('class', 'slider-inner rotate three');
            setTimeout(function () {
                return jQuery('.slider-inner').attr('class', 'slider-inner rotate two');
            }, 350);
            setTimeout(function () {
                return jQuery('.slider-inner').attr('class', 'slider-inner rotate one');
            }, 700);
        } else {
            
            jQuery('.slide[data-slide="' + slide + '"]').addClass('active');
            jQuery('.slider-inner').attr('class', 'slider-inner rotate ' + theSlide);
        }
        return jQuery('#nav').removeClass('active');
    };
}.call(this));