$( function () {

    // Sticky Nav

    var scroll_down = true;
    var scroll_up   = false;
    var scroll_bottom = true;
    var context = $('.context-menu');
    var context_offset = context.offset();
    var context_offset_top = context_offset.top - 60;

    function invertScroll(){
        scroll_down = !scroll_down;
        scroll_up   = !scroll_up;
    }

    $(document).scroll(function(){

        var doc_scroll = $(this).scrollTop();
        var isBottom = $(document).scrollTop() + context.height() + 60 >=  $('.main-footer').offset().top;

        if (doc_scroll < context_offset_top) {
            $('.context-menu').css({'position': 'absolute', 'top' : '20px'});
            scroll_bottom = true;
        } else {
            if (isBottom && scroll_bottom) {
                $('.context-menu').css({'position': 'absolute', 'top' : $(document).scrollTop() - context.height() / 2 + 'px'});
                scroll_bottom = false;
            } else if (!isBottom) {
                $('.context-menu').css({'position': 'fixed', 'top' : '60px' });
                scroll_bottom = true;
            }
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

})
