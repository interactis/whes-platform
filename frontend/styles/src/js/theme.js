var breakPointLg = 992;

$(function () {
	$('[data-toggle="popover"]').popover()
		.on("mouseenter", function() {
			$('[data-toggle="popover"]').popover('hide'); // hide other popovers first
			$(this).popover("show");
			$(".popover").on("mouseleave", function() {
				$(this).popover('hide');
			});
		})
		.on("mouseleave", function() {
			if (!$(".popover:hover").length) {
				$(this).popover("hide");
			}
		});
	}
);

$('.filter-checkbox').change(function() {
	updateContent();
});

$('.dropdown-submenu').on("click", function(e) {
    var submenu = $(this).find('.dropdown-menu');
  	var width = $(document).width();
    if (width < breakPointLg) {
		if (submenu.hasClass('show')) {
			submenu.removeClass('show');
		}
		else {
			 openSubmenu(submenu);
		}
	}
	e.stopPropagation();
});

$('.dropdown-submenu').on("mouseover", function() {
	var width = $(document).width();
    if (width >= breakPointLg) {
		var submenu = $(this).find('.dropdown-menu');
		openSubmenu(submenu);
    }
});

var openSubmenu = function(submenu) {
    $('.dropdown-submenu .dropdown-menu').removeClass('show');
    submenu.addClass('show');
}

$('.dropdown').on("hidden.bs.dropdown", function() {
    // hide any open menus when parent closes
    $('.dropdown-menu.show').removeClass('show');
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
	
	var counter = $('#rucksack-count');
	var count = parseInt(counter.text());

	if (btn.hasClass('active') === true) {
		btn.removeClass('active');
		count = count-1;
	}
	else {
		btn.addClass('active');
		count = count+1;
	}
	
	$('.rucksack-count').text(count);
	if (count < 1) {
		$('.rucksack-count').hide();
	}
	else {
		$('.rucksack-count').show();
	}
	
	$.ajax({
		type: 'GET',
		url: '/rucksack/toggle',
		data: {id: contentId},
		success: function(data) {
		}
	});
});

$('.rucksack-info-btn').click(function(e) {
	e.preventDefault();
	$('.rucksack-info').hide();
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

$('.audio').on('play', function() { 
	let current = this;
	$('.audio').each(function() {
		if (this != current) {
			this.pause();
		}
	});
});

$('.jumbotron').click(function(e) {
	if (!$(e.target).parents('.ignore-modal').length) {
		if (!$(e.target).is('.ignore-modal')) {
			$('#imageModal').modal('show');
		}
	}
});

