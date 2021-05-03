(function ($) {

    $.fn.setPoiMap = function ( options) {

        var settings = $.extend({
            latitude: 200000,
            longitude: 600000,
            iconImgSrc: '',
            zoom: 15,
            sliderElement: 'slider-id',
            sliderOrientation: "vertical",
            baseLayer: "ch.swisstopo.pixelkarte-farbe",
            secondLayer: "ch.swisstopo.swissimage",
            routesLayer: "ch.swisstopo.swisstlm3d-wanderwege",
            searchUrl: ''
        }, options);


        var iconFeature = new ol.Feature({
            geometry: new ol.geom.Point([settings.latitude, settings.longitude])
        });

        var iconStyle = new ol.style.Style({
            image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                src: settings.iconImgSrc,
                scale: 1,
                anchor: [0.5, 1]
            }))
        });

        iconFeature.setStyle(iconStyle);

        var vectorSource = new ol.source.Vector({
            features: [iconFeature]
        });

        var vectorLayer = new ol.layer.Vector({
            source: vectorSource
        });

        var swisstopoBase = ga.layer.create(settings.baseLayer);
        var swisstopoSecond = ga.layer.create(settings.secondLayer);
        var swisstopoRoutes = ga.layer.create(settings.routesLayer);
        swisstopoSecond.setOpacity(0);

        var map = new ga.Map({
            target: this.attr('id'),
            layers: [swisstopoBase, swisstopoSecond, swisstopoRoutes, vectorLayer],
            view: new ol.View({
                zoom: settings.zoom,
                center: [settings.latitude, settings.longitude]
            })
        });

        map.on('click', function (event) {
            $('#' + settings.inputField).val(
                event.coordinate[0] + ',' + event.coordinate[1]
            );
            iconFeature.setGeometry(new ol.geom.Point([event.coordinate[0], event.coordinate[1]]));
        });

        // initialize slider
        $("#" + settings.sliderElement).slider({
            value: 100,
            orientation: settings.sliderOrientation,
            slide: function (e, ui) {
                swisstopoBase.setOpacity(ui.value / 100);
                swisstopoSecond.setOpacity(1 - (ui.value / 100));
            }
        });

        // search: toggle input box when clicking on the icon
        $('#search').click(function(e) {
            toggleMapSearch();
            e.stopPropagation();
        });

        // search: input and autocomplete
        $('#search-input').autocomplete({
            autoFocus: true,
            minLength: 2,
            source: function(request, response) {
                $.ajax({
                    url: settings.searchUrl,
                    dataType: 'json',
                    data: {
                        q: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            if (item.geom !== null) {
                                return {
                                    label: item.title,
                                    geom: item.geom,
                                    id: item.id
                                };
                            }
                        }));

                    },
                    error: function( jqXHR , textStatus, errorThrown) {
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            },
            select: function(event, ui) {
                map.getView().setCenter([ui.item.geom[0], ui.item.geom[1]]);
                $('#search-button').click();
                return false;
            }
        }).autocomplete( "instance" )._renderItem = function( ul, item ) {
            return $("<li>", {'data-latitude': item.geom[0], 'data-longitude': item.geom[1]})
                .append(item.label)
                .appendTo(ul);
        };
        $("#search-input").keypress(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                event.preventDefault();
                event.stopPropagation();
            }
        });


        /**
         * Function to toggle the map search div.
         */
        function toggleMapSearch() {
            var searchdiv = $('#search-outer');

            if (searchdiv.css('display') == 'none') {
                // Show
                searchdiv.show();
                $('#search-input').val('').focus();
                $('html').click(function() {
                    toggleMapSearch();
                    $('html').unbind('click');
                });
                searchdiv.click(function(event) {
                    event.stopPropagation();
                });
            } else {
                // Hide
                searchdiv.hide();
                // If there is still some autocomplete suggestion (happens if nothing
                // was found and the user clicked outside the search div), hide it!
                $(".ui-autocomplete").hide();
                $('html').unbind('click');
            }
        }
    };

}(jQuery));