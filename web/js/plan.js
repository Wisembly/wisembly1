var Plan = function () {

    /** Init */

    this.target_btn             = $("#start_wiz");
    this.corporate_price        = $("#corporate_computed_price");
    this.expected_attendees     = $("#corporate_expected_attendees");
    this.error_test_passed      = true;

    this.translator             = null;
    this.router                 = null;


    /** Functions */

    this.attachTranslator = function (translator) {
    	this.translator = translator;
    }

    this.attachRouter = function (router) {
        this.router = router;
    }

    this.disableButton = function (error_code) {
        this.target_btn
            .text(this.translator.get(error_code, this.lang))
            .removeClass('btn-info')
            .removeAttr("href")
            .on("click", function () {
                return false;
            });
    }

    this.enableButton = function () {
        this.target_btn
            .text(this.translator.get('corporate_start_btn', this.lang))
            .addClass('btn-info')
            .off("click");
    }

    this.checkError = function (condition, error_code) {
        if (condition) {
            this.error_test_passed = false;
            this.disableButton(error_code);
        }

        return this;
    }

    this.clearErrors = function () {
        this.enableButton();
        this.error_test_passed = true;

        return this;
    }

    this.updatePrice = function (target) {
        var attendees = $(target).val();
        this.corporate_price.html(this.getPrice(attendees));

        return this;
    }

    this.updateHref = function () {
        var attendees_total = this.expected_attendees.val();
        if ( !isNaN(attendees_total) && "" != attendees_total ) {
            this.target_btn.attr("href", this.router.get('event_create') + '?attendees=' + attendees_total);
        } else {
            this.target_btn.removeAttr("href");
        }

        return this;
    }

    this.getPrice = function (attendees) {

        var   palier            = new Array(5, 50, 100, 220, 400)
            , cout              = new Array(0, 20, 14, 7, 3)
            , sum               = 0
            , previous_palier   = 0;


        // Some (very basic) errors handling
        this.checkError( isNaN(attendees),   'attendees_is_nan');
        this.checkError( attendees > 400,    'attendees_limit_exceeded');

        for (i in palier) {
            if (attendees < palier[i]) {
                return this.setNewPrice(sum + (attendees - previous_palier) * cout[i]);
            }
            sum += (palier[i] - previous_palier) * cout[i];
            previous_palier = palier[i];
        }

        return this.setNewPrice(sum + (attendees - previous_palier) * cout[i]);
    }

    this.setNewPrice = function (newprice) {
        return this.error_test_passed ? newprice + '€  <sup>Excl. VAT</sup>' : this.translator.get('corporate_default_price', this.lang);
    }
};