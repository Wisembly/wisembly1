jQuery(document).ready(function($) {

    // Navigation
    $('.nav li:eq(5)').addClass('active');

    // Carousel
    var slider = $("#slider-wrapper")
        .carousel({
            interval: false
        })
        .carousel($(".slider-pager > a").length - 1)
        .bind('slid', function() {
            var index = $(this).find(".active").index();
            $(this).find(".slider-pager a").removeClass('pager-active').eq(index).addClass('pager-active');
        });

    // reverse-history side
    var history_carousel = setInterval(function previous() {
        slider.carousel('prev');
        return false;
    }, 5000);

    $("#slider-wrapper .slider-pager a").click(function(e){
        var index = $(this).index();
        slider.carousel(index);

        // I want to look, stop the carousel right now!
        window.clearInterval(history_carousel);
        e.preventDefault();
    });


    // Meet the team :)
    $('#contentWrapper').movingGrid({
          'columns'     : 6
        , 'xScale'      : 3
        , 'yScale'      : 3
        , 'extendClick' : true
        , 'gutter'      : 20
        , 'collapseText' : '<i class="icon-remove-sign"></i>'
    });

    $("#contentWrapper")
        .on("mouseenter", ".pics", function () {
            $(".main-pic",this).hide();
            $(".secondary-pic",this).show();
        })
        .on("mouseleave", ".pics", function () {
            $(".main-pic",this).show();
            $(".secondary-pic",this).hide();
        })

    // Team filtering
    $(".about-team-filter").click ( function (e) {
        if ($(this).attr('id') == "reset-about-team-filter") {
            $(".about-team-member").removeClass("hollow");
        } else {
            $(".about-team-member").addClass("hollow");
            $("." + $(this).attr("href")).toggleClass("hollow");
        }
        $(".about-team-filter").addClass("hollow");
        $(this).removeClass("hollow");
        e.preventDefault();
    });

    // Tooltips
    $('body').tooltip({
        // On utilise 'selector' pour utiliser la délégation d'évènement (équivalent de 'live')
        selector: '[rel=tooltip], .tooltip'
    });

});
