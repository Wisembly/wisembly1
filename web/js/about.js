jQuery(document).ready(function($) {

    // Navigation
    $('.nav li:eq(4)').addClass('active');


    // Sticky Nav

    var scroll_down = true;
    var scroll_up   = false;
    var context_offset = $('.context-menu').offset();
    var context_offset_top = context_offset.top - 60;

    function invertScroll(){
        scroll_down = !scroll_down;
        scroll_up   = !scroll_up;
    }

    $(document).scroll(function(){

        var doc_scroll = $(this).scrollTop();

        if (doc_scroll > context_offset_top && scroll_down) {
            $('.context-menu').css({'position': 'fixed', 'top' : '60px' });
            invertScroll();
        } else if (doc_scroll < context_offset_top && scroll_up) {
            $('.context-menu').css({'position': 'absolute', 'top' : '20px'});
            invertScroll();
        }

        var context_active;

        $('.main-content > div').each(function(){
            if ($('.context-menu').offset().top >= $(this).offset().top - 50) {
                context_active = $(this);
            };
        });


        $('.context-menu li').removeClass('active');
        $('a.'+context_active.attr('id')).parent('li').addClass('active');

    });

    $('.context-menu a').click(function(e){
       var target = $(this).attr('href');
       $('html, body').animate({
            scrollTop: $(target).offset().top - 60
       });
       $(".tooltip").remove();
        e.preventDefault();
    });


    // Carousel

    var slider = $("#slider-wrapper")
        .carousel({
            interval: 4000
        })
        .bind('slid', function() {
            var index = $(this).find(".active").index();
            $(this).find(".slider-pager a").removeClass('pager-active').eq(index).addClass('pager-active');
        });

    $("#slider-wrapper .slider-pager a").click(function(e){
        var index = $(this).index();
        slider.carousel(index);
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
