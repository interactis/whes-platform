$('.smooth-scroll').click(function(e) {
	e.preventDefault();
	var position = $($(this).attr('href')).offset().top-90;
	$('body, html').animate({
		scrollTop: position
	});
});
