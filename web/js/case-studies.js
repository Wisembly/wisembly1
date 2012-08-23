jQuery(document).ready(function($) {

    // Navigation
    $('.nav li:eq(2)').addClass('active');

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


    // Tooltips

    $('[rel="tooltip"]').tooltip({
        placement : 'right'
    });

});
