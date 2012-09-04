/* Author:
    Nicolas Chenet -- nicolas@balloonup.com
*/

jQuery(document).ready(function($) {

    // Some nice animations for main titles

    var anim_params_from = {
        'left': '500%',
        'opacity' : 0
    }

    var anim_params_to = {
        'left': 0,
        'opacity' : 1
    }

    var anim_speed = 500;

    $('.main-header, .main-header small').css(anim_params_from);
    $('.main-header').animate(anim_params_to, anim_speed);
    $('.main-header small').animate(anim_params_to, anim_speed + 100);


    // Tooltips

    $('body').tooltip({
        // On utilise 'selector' pour utiliser la délégation d'évènement (équivalent de 'live')
        selector: '[rel=tooltip], .tooltip'
    });

    $('[rel="tooltip"]').tooltip();

    // Scroll to top

    var scroll_to_top = $('#nav_up').hide();

    $(window).scroll(function(){
        if($(window).scrollTop() > 100) {
            scroll_to_top.fadeIn('slow');
        } else {
            scroll_to_top.fadeOut('slow');
        }
    });

    scroll_to_top
        .click(function (event) {
            scroll_to_top.tooltip('hide');
            $('html, body').animate({scrollTop: '0px'}, 500, function(){
                scroll_to_top.hide('slow');
            });
            event.preventDefault();
        })
        .tooltip({
            placement : 'left'
        });

});






