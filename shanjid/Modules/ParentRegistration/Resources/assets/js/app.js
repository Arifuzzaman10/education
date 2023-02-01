(function ($) {
        "use strict";

        
jQuery.validator.setDefaults({
     debug: true,
     success: "valid"
 });
 $("#login").validate({

     rules: {
         email: {
             required: true,
             email: true
         },
         password: {
             required: true,
             minlength: 6,
         },
         cpassword: {
             required: true,
             minlength: 6,
         },
         school_name: {
             required: true,
         }
     },
     submitHandler: function (form) {
         form.submit();
     }
 });
 if ($('.niceSelect').length) {
     $('.niceSelect').niceSelect();
 }

 //dropdown visiable js
 $(".single_additional_services").on('click', function () {
     $(this).find(".single_additional_text").toggleClass("active_pack");

 });

 //dropdown visiable js
 function totalIt() {
     var input = document.getElementsByName("additional_service");
     var total = 0;
     for (var i = 0; i < input.length; i++) {
         if (input[i].checked) {
             total = total + parseFloat(input[i].value);
         }
     }
     document.getElementsByName("total")[0].value = "$" + total.toFixed(2);
 }


$('.primary-btn').on('click', function (e) {
    // Remove any old one
    $('.ripple').remove();

    // Setup
    var primaryBtnPosX = $(this).offset().left,
        primaryBtnPosY = $(this).offset().top,
        primaryBtnWidth = $(this).width(),
        primaryBtnHeight = $(this).height();

    // Add the element
    $(this).prepend("<span class='ripple'></span>");

    // Make it round!
    if (primaryBtnWidth >= primaryBtnHeight) {
        primaryBtnHeight = primaryBtnWidth;
    } else {
        primaryBtnWidth = primaryBtnHeight;
    }

    // Get the center of the element
    var x = e.pageX - primaryBtnPosX - primaryBtnWidth / 2;
    var y = e.pageY - primaryBtnPosY - primaryBtnHeight / 2;

    // Add the ripples CSS and start the animation
    $('.ripple')
        .css({
            width: primaryBtnWidth,
            height: primaryBtnHeight,
            top: y + 'px',
            left: x + 'px'
        })
        .addClass('rippleEffect');
});

jQuery.validator.setDefaults({
    debug: true,
    success: "valid"
});
$("#login").validate({

    rules: {
        email: {
            required: true,
            email: true
        },
        password: {
            required: true,
            minlength: 6,
        },
        cpassword: {
            required: true,
            minlength: 6,
        },
        school_name: {
            required: true,
        }
    },
    submitHandler: function (form) {
        form.submit();
    }
});
if ($('.niceSelect').length) {
    $('.niceSelect').niceSelect();
}

//dropdown visiable js
$(".single_additional_services").on('click', function () {
    $(this).find(".single_additional_text").toggleClass("active_pack");

});

//dropdown visiable js
function totalIt() {
    var input = document.getElementsByName("additional_service");
    var total = 0;
    for (var i = 0; i < input.length; i++) {
        if (input[i].checked) {
            total = total + parseFloat(input[i].value);
        }
    }
    document.getElementsByName("total")[0].value = "$" + total.toFixed(2);
}

 })(jQuery);
