jQuery(document).ready(function($) {

    // Navigation
    $('.nav li:eq(4)').addClass('active');


     // Tooltips
    $('body').tooltip({
        // On utilise 'selector' pour utiliser la délégation d'évènement (équivalent de 'live')
        selector: '[rel=tooltip], .tooltip'
    });

});
