jQuery(document).ready(function($) {

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

    $("#customer-quotes-wrapper").carousel({
        interval: 10000
    })

});
