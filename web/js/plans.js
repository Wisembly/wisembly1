(function (plan, translator, router) {

    $(function () {

    	// Navigation
    	$('.nav li:eq(3)').addClass('active');


     	// Tooltips
	    $('body').tooltip({
	        // On utilise 'selector' pour utiliser la délégation d'évènement (équivalent de 'live')
	        selector: '[rel=tooltip], .tooltip'
	    });

	    // Let's attach our tools :)
	    plan.attachTranslator(translator);
	    plan.attachRouter(router);

        plan.expected_attendees
            .on("keyup", function (event) {
                plan
                    .clearErrors()
                    .updateHref()
                    .updatePrice(event.currentTarget);
            })
            .focus();

        plan.target_btn.on("click", function () {
            return !(plan.expected_attendees.val() == '');
        });

    });

})(new Plan(), new Translator(lang), new Router(lang));


