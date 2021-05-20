/**
 * setMap plugin
 * -------------
 *
 * initialize:
 * var map = $.setMap({'option': '123'});
 *
 * add/remove icons:
 * map.addIcon(id, contentType, latitude, longitude)
 * map.highlightIcon(id)
 * map.removeIcon(id)
 *
 * add/remove trail:
 * map.addTrail(id, coordinates)
 * map.highlightTrail(id)
 * map.removeTrail(id)
 *
 * center map:
 * map.centerMap(latitude, longitude)
 *
 * center map to feature:
 * map.centerMapToFeature(id)
 *
 * show/hide hike paths
 * map.addHikeLayer() / map.removeHikeLayer()
 *
 * center map to users geolocation
 * map.locateUser
 *
 * show/hide Aletsch perimeter
 * map.setPerimeterOpacity([0-1])
 *
 */

(function ($) {
    $.extend({
        setMap: function (options) {

            // Default settings.
            var settings = $.extend({
                target: 'map',
                zoom: 12,
                detailZoom: 6,
                latitude: 645500,
                longitude: 155000,
                layer: 'default',
                iconClickCallback: null,
                poiImage: '',
                disabledPoiImage: '',
                highlightPoiImage: '',
                highlightDisabledPoi: '',
                ambassadorImage: '',
                disabledAmbassadorImage: '',
                highlightAmbassadorImage: '',
                highlightDisabledAmbassador: '',
                clusterImage: '',
                locationImage: '',
                sliderElement: 'layer-slider',
                sliderOrientation: 'horizontal',
                allDataUrl: ''
            }, options);

            // 'Mapping' for convenient access to swisstopo-layers.
            var layers = {
                default: "ch.swisstopo.pixelkarte-farbe",
                image: "ch.swisstopo.swissimage",
                hike: "ch.swisstopo.swisstlm3d-wanderwege"
            };

            // 'Mapping' for convenient icon-access.
            var elements = {
               poi: settings.poiImage,
               disabledPoi: settings.disabledPoiImage,
               highlight: settings.highlightPoiImage,
               highlightDisabledPoi: settings.highlightDisabledPoi, 
               clusterImage: settings.clusterImage,
               location: settings.locationImage,
               ambassador: settings.ambassadorImage,
               disabledAmbassador: settings.disabledAmbassadorImage,
        	   highlightAmbassador: settings.highlightAmbassadorImage,
               highlightDisabledAmbassador: settings.highlightDisabledAmbassador, 
            };
            
            // All available icons (openlayers features).
            var iconFeatureReference = {};

            // All trails
            var trailFeatureReference = {};

            // The currently highlighted feature.
            var highlightedFeature = null;
            var highlightedTrail = null;

            // source to add POIs
            var vectorSource = new ol.source.Vector({
                name: 'default'
            });

            // source to add trails
            var trailSource = new ol.source.Vector({});

            // source to my location - this is cleared each time the location is set.
            var locationSource = new ol.source.Vector({});
            var currentPosition = null;

            // source for all 'disabled' / additional information
            var allInformationSource = new ol.source.Vector({});

            // flag for hike layer
            var hikeLayer = null;

            // Cluster for pois
            var clusterSource = new ol.source.Cluster({
                distance: 60,
                source: vectorSource
            });

            // Create styles just once - use this object for caching
            var stylesCache = {};

            // clustered vector with all features (POIs).
            var clusters = new ol.layer.Vector({
                source: clusterSource,
                style: function(feature, resolution) {
                    var size = feature.get('features').length;
                    if (size == 1) {
                    	var feature = feature.get('features')[0];
                        if (feature.get('is_highlighted') === true) {
                            if (feature.get('type') === 4) { // ambassador
                            	return highlightAmbassadorFeatureStyle();
                            }
                            else { // regular poi
                            	return highlightFeatureStyle();
                            }
                        } else {
                        	if (feature.get('type') === 4) { // ambassador
                            	return defaultAmbassadorFeatureStyle();
                            }
                            else { // regular poi
                            	return defaultFeatureStyle();
                            }
                        }
                    } else {
                        return disabledClusterStyle(size);
                    }
                }
            });

            // layer for trails
            var trails = new ol.layer.Vector({
                source: trailSource,
                name: 'trails',
                style: trailStyle()
            });

            // tiled perimeter from the wms server
            var perimeter = new ol.layer.Tile({
                source: new ol.source.TileWMS({
                    url: mapWmsUrl,
                    params: {
                        'version': '1.1.0',
                        'layers': 'aletsch:perimeter'
                    }
                })
            });

            // custom layer for 'my position' - mainly for style / grouping reasons.
            var location = new ol.layer.Vector({
                source: locationSource,
                style: myLocationStyle()
            });

            // Cluster for all information layer
            var allInformationCluster = new ol.source.Cluster({
                distance: 50,
                source: allInformationSource
            });

            // layer for all information; displayed only if zoomed in enough.
            var allInformation = new ol.layer.Vector({
                source: allInformationCluster,
                name: 'allInformation',
                style: function(feature, resolution) {
                    var size = feature.get('features').length;
                    if (size == 1) {
                    	var feature = feature.get('features')[0];
                        if (feature.get('is_highlighted') === true) {
                            if (feature.get('poiType') === 4) { // ambassador
                            	return highlightAmbassadorFeatureStyle();
                            }
                            else { // regular poi
                            	return highlightFeatureStyle();
                            }
                        } else {
                        	if (feature.get('poiType') === 4) { // ambassador
                            	return disabledAmbassadorFeatureStyle();
                            }
                            else { // regular poi
                            	return disabledFeatureStyle();
                            }
                        }
                    } else {
                        return disabledClusterStyle(size);
                    }
                }
            });

            // Create the base layers
            var swisstopo = ga.layer.create(layers[settings.layer]);
            var swissimage = ga.layer.create(layers['image']);
            swissimage.setOpacity(0);

            var mapView = new ol.View({
                center: [settings.latitude, settings.longitude],
                projection:'EPSG:21781',
                zoom: settings.zoom
                //extent: [[2617070, 1129447], [2668141,  1170583]],
                //resolution: 50,
            });

            // Create map canvas.
            var map = new ga.Map({
                target: settings.target,
                layers: [swisstopo, swissimage, perimeter, trails, clusters, location, allInformation],
                view: mapView,
                interactions: ol.interaction.defaults({
                    altShiftDragRotate: false, pinchRotate:false
                })
            });
            
            // this doesn't work - the workaround is to center the map an zoom on map loading
            // var extent = ol.extent.boundingExtent([[2617070, 1129447], [2668141,  1170583]]);
            // map.getView().fitExtent(extent, map.getSize());

            // When clicking on the map, trigger the callback.
            var clickIcon = function(e) {
                map.forEachFeatureAtPixel(e.pixel, function (feature, layer) {
                    // add callback.
                    $(document).trigger('clickedIcon', [feature, layer.get('name'), e.coordinate]);
                });
            };

            map.on('click', clickIcon);
            //map.on('singleclick', clickIcon);

            _drawAllInformationLayer();

            function unhighlightFeature() {
                if (highlightedFeature !== null) {
                    highlightedFeature.set('is_highlighted', false);
                }
                /*
                allInformationSource.forEachFeature(function(feature) {
                    var style = (feature.get('type') == 'trail') ? disabledTrailStyle(): disabledFeatureStyle();
                    feature.setStyle(style);
                });
                */
                unhighlightTrail();
            }

            function unhighlightTrail() {
                if (highlightedTrail !== null) {
                    // map.removeLayer(highlightedTrail);
                    var style = (highlightedTrail.get('isAllLayer')) ?  disabledTrailStyle(): trailStyle();
                    highlightedTrail.setStyle(style);
                }
            }

            /**
             * Functions for styles - cached so they are created only once.
             */
            function _cachedStyle(styleName, func) {
                if (typeof stylesCache[styleName] !== 'undefined') {
                    return stylesCache[styleName];
                } else {
                    var newStyle = func();
                    stylesCache[styleName] = newStyle;
                    return newStyle;
                }
            }

            function highlightFeatureStyle() {
                return _cachedStyle('highlightStyle', function() {
                    return [new ol.style.Style({
                        image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                            src: elements['highlight'],
                            anchor: [0.5, 0.8],
                            scale: 0.5
                        }))
                    })];
                });
            }
            
            function highlightAmbassadorFeatureStyle() {
                return _cachedStyle('highlightAmbassadorStyle', function() {
                    return [new ol.style.Style({
                        image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                            src: elements['highlightAmbassador'],
                            anchor: [0.5, 0.8],
                            scale: 0.5
                        }))
                    })];
                });
            }

            function defaultFeatureStyle() {
                return _cachedStyle('defaultStyle', function () {
                    return [new ol.style.Style({
                        image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                            src: elements['poi'],
                            scale: 0.5
                        }))
                    })];
                });
            }
            
            function defaultAmbassadorFeatureStyle() {
                return _cachedStyle('defaultAmbassadorStyle', function () {
                    return [new ol.style.Style({
                        image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                            src: elements['ambassador'],
                            scale: 0.5
                        }))
                    })];
                });
            }

            function disabledFeatureStyle() {
                return _cachedStyle('disabledStyle', function () {
                    return [new ol.style.Style({
                        image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                            src: elements['disabledPoi'],
                            opacity: 0.8,
                            scale: 0.5
                        }))
                    })];
                });
            }
            
            function disabledAmbassadorFeatureStyle() {
                return _cachedStyle('disabledAmbassadorStyle', function () {
                    return [new ol.style.Style({
                        image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                            src: elements['disabledAmbassador'],
                            opacity: 0.8,
                            scale: 0.5
                        }))
                    })];
                });
            }
            
            function clusterStyle(size) {
                return _cachedStyle('clusters-' + size, function () {
                    return [new ol.style.Style({
                        image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                            src: elements['clusterImage'],
                            scale: 0.5
                        })),
                        text: new ol.style.Text({
                            text: size.toString(),
                            fill: new ol.style.Fill({
                                color: '#d57772'
                            }),
                            font: 'bold 18px Arial, Verdana, Helvetica, sans-serif'
                        })
                    })];
                });
            }

            function disabledClusterStyle(size) {
                return _cachedStyle('clusters-disabled-' + size, function () {
                    return [new ol.style.Style({
                        image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                            src: elements['clusterImage'],
                            scale: 0.5
                        })),
                        text: new ol.style.Text({
                            text: size.toString(),
                            fill: new ol.style.Fill({
                                color: '#848484'
                            }),
                            font: 'bold 18px Arial, Verdana, Helvetica, sans-serif'
                        })
                    })];
                });
            }

            function trailStyle() {
                return _cachedStyle('trailStyle', function() {
                    return [
                        new ol.style.Style({
                            stroke: new ol.style.Stroke({
                                color: 'rgba(225, 147, 143, 0.8)',
                                width: 7
                            })
                        })
                    ];
                });
            }

            function disabledTrailStyle() {
                return _cachedStyle('disabledTrailStyle', function() {
                    return [
                        new ol.style.Style({
                            stroke: new ol.style.Stroke({
                                color: 'rgba(80, 80, 80, 0.7)',
                                width: 7
                            })
                        })
                    ];
                });
            }

            function trailHighlightStyle() {
                return _cachedStyle('trailHighlightStyle', function() {
                    return [
                        new ol.style.Style({
                            stroke: new ol.style.Stroke({
                                color: 'rgba(225, 35, 25, 0.8)',
                                width: 7
                            })
                        })
                    ];
                });
            }

            function myLocationStyle() {
                return _cachedStyle('myLocationStyle', function () {
                    return [new ol.style.Style({
                        image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
                            src: elements['location'],
                            scale: 0.5
                        }))
                    })];
                });
            }

            // initialize slider
            var slider = document.getElementById(settings.sliderElement);

            noUiSlider.create(slider, {
                start: [100],
                range: {
                    'min': 0,
                    'max': 100
                }
            });
            slider.noUiSlider.on('slide', function(){
                var value = slider.noUiSlider.get();
                swisstopo.setOpacity(value / 100);
                swissimage.setOpacity(1 - (value / 100));
            });

            // public function: center map for latitude / longitude.
            this.centerMap = function(latitude, longitude) {
                map.getView().setCenter([latitude, longitude]);
            };

            this.centerMapToFeature = function(id) {
                if (typeof iconFeatureReference[id] != 'undefined') {
                    var feature = iconFeatureReference[id];
                    map.getView().setCenter(feature.getGeometry().getCoordinates());
                }
            };

            /**
             * Functionality to handle Icons (pois)
             */
            this.clearObjects = function() {
                vectorSource.clear();
                trailSource.clear();
            };

            this.addIcon = function(identifier, latitude, longitude, type) {
                var iconFeature = new ol.Feature({
                    geometry: new ol.geom.Point([latitude, longitude]),
                    identifier: identifier,
                    type: type
                });
                iconFeatureReference[identifier] = iconFeature;
                iconFeature.setStyle(defaultFeatureStyle());
                vectorSource.addFeature(iconFeature);
            };

            // public function: highlight icon and center map.
            this.highlightIcon = function(id) {
                if (typeof iconFeatureReference[id] != 'undefined') {
                    var feature = iconFeatureReference[id];
                    unhighlightFeature();
                    feature.set('is_highlighted', true);
                    highlightedFeature = feature;
                    //map.getView().setZoom(settings.detailZoom);
                    map.getView().setCenter(feature.getGeometry().getCoordinates());
                }
                locationSource.clear();
            };

            this.removeIcon = function(id) {
                if (typeof iconFeatureReference[id] !== 'undefined') {
                    vectorSource.removeFeature(iconFeatureReference[id]);
                }
            };
            this.unhighlightAll = function() {
                unhighlightFeature();
            };

            /**
             * Handle icons for data from swissnames. Use the same icon as 'locate me'.
             */
            this.setSwissnamesLocation = function(latitude, longitude) {
                map.getView().setCenter([latitude, longitude]);
                locationSource.clear();
                locationSource.addFeature(new ol.Feature({
                    geometry: new ol.geom.Point([latitude, longitude]),
                    isMyLocation: true
                }));
                //map.getView().setZoom(settings.detailZoom);
            };

            /**
             * Handle trails
             */
            this.addTrail = function(id, coordinates) {
                var trailFeature = new ol.Feature({
                   geometry: new ol.geom.LineString(coordinates),
                   identifier: id,
                   type: 'trail',
                   isAllLayer: false
                });
                trailFeatureReference[id] = trailFeature;
                trailSource.addFeature(trailFeature);

                // center map to starting point if coordinates are not empty.
                if (typeof coordinates[0] !== 'undefined') {
                    this.centerMap(coordinates[0][0], coordinates[0][1]);
                }
            };

            // highlight trail and bring it to the front.
            this.highlightTrail = function(id) {
                var trail = trailFeatureReference[id];
                if (trail !== 'undefined') {
                    unhighlightFeature();
                    trail.setStyle(trailHighlightStyle());
                    highlightedTrail = trail;
                    //var extent = trail.getGeometry().getExtent();
                    //map.getView().fitExtent(extent, map.getSize());
                }
            };

            this.removeTrail = function(id) {
                if (typeof trailFeatureReference[id] !== 'undefined') {
                    trailSource.removeFeature(trailFeatureReference[id]);
                }
            };

            this.highlightDisabledElement = function(type, id) {
                if (type == 'trail') {
                    this.highlightTrail(id);
                } else {
                    // the default Poi layer is clustered and styled - simply apply the style here.
                    if (typeof iconFeatureReference[id] != 'undefined') {
                        var feature = iconFeatureReference[id];
                        feature.set('is_highlighted', true);
                        unhighlightFeature();
                        highlightedFeature = feature;
                        // map.getView().setCenter(feature.getGeometry().getCoordinates());
                    }
                }
            };
            
            this.zoomIn = function(coordinate) {
                // center to click
                map.getView().setCenter(coordinate);
                map.getView().setZoom(map.getView().getZoom() + 1);
            };

            /**
             * Handle hike layer. Create (if it doesn't exist) and set opacity according to method.
             */
            function addHikeLayer () {
                if (hikeLayer == null) {
                    hikeLayer = ga.layer.create(layers['hike']);
                    map.addLayer(hikeLayer);
                }
                hikeLayer.setOpacity(0.7);
            }

            function removeHikeLayer() {
                if (hikeLayer !== null) {
                    hikeLayer.setOpacity(0);
                }
            }

            // as the perimeter is loaded from an external service, don't remove the layer, but just update the opacity.
            function setPerimeterOpacity(opacity) {
                perimeter.setOpacity(opacity);
            }

            /**
             * Functionality to show the layer with 'all' information. Only display information that is not yet set on
             * the map.
             */
            function _drawAllInformationLayer() {
                $.getJSON(settings.allDataUrl, function(data) {
                    $.each(data.pois, function(key, val) {
                        if (!(val.id in iconFeatureReference) && $.isNumeric(val.geom[0]) && $.isNumeric(val.geom[1])) {
                            var poiFeature = new ol.Feature({
                                geometry: new ol.geom.Point([val.geom[0], val.geom[1]]),
                                identifier: val.id,
                                type: 'poi',
                                poiType: 1
                            });
                            allInformationSource.addFeature(poiFeature);
                            iconFeatureReference[val.id] = poiFeature;
                        }
                    });
                    $.each(data.routes, function(key, val) {
                        if (!(val.id in trailFeatureReference)) {
                            var trail = new ol.Feature({
                                geometry: new ol.geom.LineString(val.geom),
                                identifier: val.id,
                                type: 'trail',
                                isAllLayer: true
                            });
                            trail.setStyle(disabledTrailStyle());
                            trailSource.addFeature(trail);
                            trailFeatureReference[val.id] = trail;
                        }
                    });
                });
            }

            /**
             * Store the currentLocation, as the Geolocation object can fire once (which will result in noting happening
             * when clicking repeatedly) or multiple times (which fires on each change, so sometimes when switching
             * tabs).
             */
            function setMyLocation() {
                map.getView().setCenter(currentPosition);
                locationSource.clear();
                locationSource.addFeature(new ol.Feature({
                    geometry: new ol.geom.Point(currentPosition),
                    isMyLocation: true
                }));
            }
            function locateUser() {
            	
                if (currentPosition === null) {
                    var location = new ol.Geolocation({
                        projection: 'EPSG:21781',
                        trackingOptions: {
                            maximumAge: 0,
                            enableHighAccuracy: true,
                            timeout: 5000
                        },
                        tracking: true
                    });

                    location.once('change', function () {
                        currentPosition = location.getPosition();
                        setMyLocation();
                    });
                    location.on('error', function(error) {
                        $(document.body).find('#location-disabled').modal('show');
                    });
                } else {
                    setMyLocation();
                }
            }

            // event handlers for mapNavigation.js
            $(document).on('locateMe', function() {
                locateUser();
            });
            $(document).on('togglePerimeter', function(event, toggle) {
                (toggle) ? setPerimeterOpacity(1) : setPerimeterOpacity(0);
            });
            $(document).on('toggleHikeLyer', function(event, toggle) {
                toggle ? addHikeLayer() : removeHikeLayer();
            });

            // event handler for 'wo soll es hingehen'. this trigger may be registered after this file was loaded.
            var thisInstance = this;
            jQuery(document).on('goToWhereTo', function(event, latitude, longitude) {
                // add icon and highlight it.
                thisInstance.setSwissnamesLocation(latitude, longitude);
            });

            return this;
        }
    });
})(jQuery);
