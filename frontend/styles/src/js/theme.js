$(function () {
	$('[data-toggle="popover"]').popover()
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
