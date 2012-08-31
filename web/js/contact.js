jQuery(document).ready(function($) {

    // Navigation
    $('.nav li:eq(6)').addClass('active');

    // Maps management

    $(".contact").on("click", ".toggle-map", function (event) {
    	var target = $(this).attr('data-target');
    	$(".toggle-map").toggleClass("active");
    	$("iframe").fadeOut(500, function () {
    		$("#" + target).fadeIn();
    	});
    	event.preventDefault();
    });

});
