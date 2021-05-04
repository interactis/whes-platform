$('.article-filter').change(function() {
	var text = $(this).find('option:selected').text();
	var cancerType = $('#cancer-type-filter').val();
	var topic = $('#topic-filter').val();
	updateArticles(cancerType, topic);
	gtag('event', 'filter_set', {'event_category': 'filter', 'event_label': text});
	
});

var updateArticles = function(cancerType, topic) {
	$.ajax({
		url: articleUpdateUrl +'?cancerType='+ cancerType +'&topic='+ topic,
		beforeSend: function() {
			// $('.filter-ajax-loader').show();
		 },
		success: function(data) {
			$('#articles').html(data);
			
			$('.grid').masonry({
			  itemSelector: '.card',
			  gutter: 30
			});
			
			smoothScrollTo('#filter');
			//$('.filter-ajax-loader').hide();
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
