jQuery(document).ready(function($) {

    // Navigation
    $('.nav li:eq(0)').addClass('active');

    var slider = $("#slider-wrapper")
        .carousel({
            interval: 8000
        })
        .bind('slid', function() {
            var index = $(this).find(".active").index();
            $(this).find(".slider-pager a").removeClass('pager-active').eq(index).addClass('pager-active');
            if( $(".item",this).size() - 1 == index ) {
                $(this).carousel("pause");
            }
        });

    $("#slider-wrapper .slider-pager a").click(function(e){
        var index = $(this).index();
        slider.carousel(index);
        e.preventDefault();
    });


    var slider_customers = $("#customer-quotes-wrapper")
        .carousel("pause")
        .bind('slid', function(){
            var index = $(this).find(".active").index();
            $(".customers").find("a.customer").removeClass('active').eq(index).addClass('active');
            $(this).carousel("pause");
        });

    $('.customers a.customer').click(function(e){
        var index= $(this).index();
        slider_customers.carousel(index-1);
        e.preventDefault();
    });

    $(".customers img, .press img").each( function () {
        $(this).load( function () {
            $(this).css({
                  "position" : "relative"
                , "top" : "50%"
                , "margin-top" : "-" + $(this).height()/2 + "px"
            }).fadeIn();
        })
    });

});
