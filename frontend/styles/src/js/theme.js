$(function () {
	$('[data-toggle="popover"]').popover()
});

$(document).on('click', function(){
	$('[data-toggle="popover"]').popover('hide');
});

$('[data-toggle="popover"]').click(function(){
	return false;
});

$('[data-toggle="popover"]').click(function(){
	$('[data-toggle="popover"]').not(this).popover('hide');
});

$('.filter-checkbox').change(function() {
	updateContent();
});

var updateContent = function() {
	var params = [];
	$('.filter-checkbox').each(function() {
		var customControl = $(this).closest('.custom-control');
		if ($(this).is(':checked')) {
			var filterId = $(this).attr('id').substring(7);
			params.push(filterId);
			customControl.addClass('active');
		}
		else {
			customControl.removeClass('active');
		}
	});
	
	$.ajax({
		url: updateUrl +'&filters='+ params.join(),
		beforeSend: function() {
			// $('.filter-ajax-loader').show();
		},
		success: function(data) {
			$('#info').html(data);
		}
	});
}

$(document).on('click', '.rucksack-btn', function(e) {
	e.preventDefault();
	var btn = $(this);
	var contentId = btn.attr('content-id');

	if (btn.hasClass('active') === true) {
		btn.removeClass('active');
	}
	else {
		btn.addClass('active');
	}
	
	$.ajax({
		type: 'GET',
		url: '/rucksack/toggle',
		data: {id: contentId},
		success: function(data) {
		}
	});
});

var smoothScrollTo = function(id) {
	var margin = 45;
	var position = $(id).offset().top-margin;
	$('body, html').animate({
		scrollTop: position
    });
}

$(document).on("click", '.smooth-scroll', function(e) { 
	e.preventDefault();
	smoothScrollTo($(this).attr('href'));
});
