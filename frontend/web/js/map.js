$(function() {

    var bgMap = $('#bg-map');
    if (bgMap.length !== 0) {
        var map = $.setMap({
            target: 'bg-map',
            poiImage: bgMap.data('poi-url'),
            disabledPoiImage: bgMap.data('disabled-poi-url'),
            highlightPoiImage: bgMap.data('poi-highlight-url'),
            highlightDisabledPoi: bgMap.data('disabled-poi-highlight-url'),
            clusterImage: bgMap.data('cluster-url'),
            locationImage: bgMap.data('location-url'),
            zoom: ($(window).width() < 500) ? 10 : 11.5,
            allDataUrl: '/map/get-all-markers/'
        });

        var mapItems = $('.map-item');
        var defaultInitialDisplay = 'recommendations';
        var initialDisplayIcons = $('#map-initial-icons').data('value');
        var whereTo = $('#whereto');
        var whereToSubmit = $('#whereto-submit');
        var recommendations = $('.recommendations');

        // initialize items on the map and bind 'highlight' functions to the click event.
        mapItems.each(function() {

            bindHighlightEvents($(this));

            switch($(this).data('content-type')) {

                case 'poi':
                    poiHandle($(this));
                    break;

                case 'trail':
                    trailHandle($(this));
                    break;

                case 'tag':
                    tagHandle($(this));
                    break;

                case 'story':
                    storyHandle($(this));
                    break;

            }
        });
        
        // display the initial element on the map and navigation.
        initialDisplay();
        
        // special case: 'recommendations' box must be interactive as well.
        recommendations.click(function() {
            // clear icons on map, un-activate navigation, hide preview modal.
            map.clearObjects();
            unActivateNavigationElements();
            $('.main-section.preview.in').removeClass('in');

            // display recommended icons and make map image red.
            showRecommendedIcons();
        });
    }

    // disable click on map icon in navigation
    $('.map-view .badge-icon.map').click(function(event) {
        event.preventDefault();
    });

    function poiHandle(that) {
        that.bind('click', function(event) {
            map.clearObjects();
            if (! $(event.target).parent().hasClass('remove-from-rucksack')) {
                selectPoi(that);
            }
        });
    }
    function addPoi(element) {
        map.addIcon(
            element.data('id'),
            element.data('geodata')['latitude'],
            element.data('geodata')['longitude']
        );
    }
    function selectPoi(element) {
        addPoi(element);
        map.highlightIcon(element.data('id'));
        map.centerMapToFeature(element.data('id'));
        loadInfoForElement('poi', element.data('id'));
    }

    function trailHandle(that) {
        that.bind('click', function(event) {
            map.clearObjects();
            if (! $(event.target).parent().hasClass('remove-from-rucksack')) {
                selectTrail(that);
            }
        });
    }
    function selectTrail(element) {
        map.addTrail(element.data('id'), element.data('geodata')['trail']);
        map.highlightTrail(element.data('id'));
        loadInfoForElement('trail', element.data('id'));
    }

    function tagHandle(that) {
        that.bind('click', function(event) {
            map.clearObjects();
            if (! $(event.target).parent().hasClass('remove-from-rucksack')) {
                selectTag(that);
            }
        });
    }
    function selectTag(element) {
        $.each(element.data('geodata')['pois'], function (id, coords) {
            map.addIcon(id, coords[0], coords[1]);
        });
        $.each(element.data('geodata')['trails'], function (id, coords) {
            map.addTrail(id, coords);
        });
        loadInfoForElement('tag', element.data('id'));
    }

    function storyHandle(that) {
        that.bind('click', function(event) {
            if (! $(event.target).parent().hasClass('remove-from-rucksack')) {
                loadInfoForElement('story', that.data('id'));
            }
        });
    }

    /**
     * Functions for global map handling. Make <li> and <a img> 'active' for the current element.
     */
    function activateNavigationElement(element) {
        // element is expected to be the '<li>'
        element.addClass('active');
        element.children('a').addClass('active');
        var parentTitle = element.closest('div.collapse');
        // if parent 'title' is not expaned, collapse all elements and expand the active elements' parent.
        if (! parentTitle.hasClass('in')) {
            parentTitle.collapse('show');
        }
    }
    function unActivateNavigationElements() {
        $('.badge-icon').removeClass('active');
        $('.list-group-item').removeClass('active');
        recommendations.removeClass('active');
    }

    function bindHighlightEvents(that) {
        that.bind('click', function(event) {
            unActivateNavigationElements();
            activateNavigationElement($(this));
        });
    }

    /**
     * Loading of elements: initial, highlighting and clicks on the map.
     */
    function initialDisplay() {
        if (initialDisplayIcons == defaultInitialDisplay) {
            showRecommendedIcons();
        } else {
            var splitted = initialDisplayIcons.split('-');
            if ((splitted.length != 0) && (splitted.length == 2)) {
                var element = $('[data-content-type="' + splitted[0] + '"][data-id="' + splitted[1] + '"]');
                if (element.length !== 0 && splitted[0] == 'poi') {
                    selectPoi(element);
                    activateNavigationElement(element);
                }
                if (element.length !== 0 && splitted[0] == 'trail') {
                    selectTrail(element);
                    activateNavigationElement(element);
                }
                if (element.length !== 0 && splitted[0] == 'tag') {
                    selectTag(element);
                    activateNavigationElement(element);
                }
                if (splitted[0] == 'custom') {
                    // load info according to id (from elasticsearch) and display icon.
                    $.ajax({
                        url: '/rucksack/helper/ajax-get-swiss-names-by-id',
                        data: {'id': splitted[1]},
                        dataType: 'json',
                        success: function(data) {
                            map.setSwissnamesLocation(data.geom[0], data.geom[1]);
                            whereTo.val(data.name).data('current', data);
                            whereToSubmit.prop('disabled', false);
                        }
                    });
                }
            }
        }
    }

    function showRecommendedIcons() {
        if($('[data-target="#Highlights"]').length !== 0) {
            var highlightElements = $('.highlight-list li');
        } else {
            var highlightElements = $('.recommendation-items span');
        }

        highlightElements.each(function() {
            switch ($(this).data('content-type')) {
                case 'poi':
                    addPoi($(this));
                    break;

                case 'trail':
                    map.addTrail($(this).data('id'), $(this).data('geodata')['trail']);
                    break;
            }
        });
        recommendations.addClass('active');
        recommendations.find('.badge-icon.map').addClass('active');
    }

    // event handler: triggered when element on map is clicked. the layer: allInformation is handled separately, as
    // there is only one feature submitted (no clustering).
    $(document).on('clickedIcon', function(event, features, layer, coordinate) {
        if (layer == 'allInformation') {
            if (features.get('features').length == 1) {
                var feature = features.get('features')[0];
                map.highlightDisabledElement(feature.get('type'), feature.get('identifier'));
                loadInfoForElement(feature.get('type'), feature.get('identifier'));
                unActivateNavigationElements();
            } else {
                map.zoomIn(coordinate);
            }
        } else if (layer == 'trails') {
            var identifier = features.get('identifier');
            var element = $('[data-content-type="trail"][data-id="' + identifier + '"]');
            map.highlightTrail(identifier);
            loadInfoForElement('trail', features.get('identifier'));
            if (element.length !== 0) {
                activateNavigationElement(element);
            }
        } else if (features.get('features').length == 1) {
            // highlight poi and load info.
            var identifier = features.get('features')[0].get('identifier');
            var element = $('[data-content-type="poi"][data-id="' + identifier + '"]');
            map.highlightIcon(identifier);
            loadInfoForElement('poi', identifier);
            if (element.length !== 0) {
                activateNavigationElement(element);
            }
        } else {
            // more than one feature: zoom in by simulating click.
            map.zoomIn(coordinate);
        }
    });
    
    // not all elements may be in the markup yet (can be loaded async. - see loadInfoForElement
    jQuery(document.body).on('hidden.bs.modal', function() {
        if ($('#bg-map').length !== 0) map.unhighlightAll();
    });

    // as 'modal' is not used as it should (=allow interaction with background), make sure all modals are closed before
    // showing a new one.
    jQuery(document.body).on('show.bs.modal', function () {
        hideModal();
    });

    // collapse the accordion menu and exchange its glyphicon
    $('.show-hide-accordion').on('click', function() {
        $(this).find('i:first').toggleClass('glyphicon-chevron-right glyphicon-chevron-down')
    })
});

/**
 * Load 'additional info' in the box. Data from 'Sammlung' is already in the markup; missing data is loaded
 * with an ajax-call.
 * This function requires vendor.js to be fully loaded.
 */
function loadInfoForElement(type, identifier) {
    var modalContainer = $('#map-info-modal');
    
	$.ajax({
		method: 'GET',
		url: '/map/get-info-modal',
		data: {
			type: type,
			id: identifier
		}
	}).done(function(data) {
		modalContainer.html(data);
		modalContainer.addClass('in');
	});
}

function hideModal() {
    $('.modal.in').each(function() {
       $(this).modal('hide').removeClass('in');
    });
}

$("#map-info-modal").on("click", ".close-preview", function() {
	$('#map-info-modal').removeClass('in');
});

$('.sidebar-handle').on('click', function() {
	$('.map-settings').toggleClass('in');
});
