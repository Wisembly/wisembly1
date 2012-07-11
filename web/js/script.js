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

});






