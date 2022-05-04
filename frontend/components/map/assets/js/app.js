/******/ (function(modules) { // webpackBootstrap
/******/ 	// install a JSONP callback for chunk loading
/******/ 	function webpackJsonpCallback(data) {
/******/ 		var chunkIds = data[0];
/******/ 		var moreModules = data[1];
/******/ 		var executeModules = data[2];
/******/
/******/ 		// add "moreModules" to the modules object,
/******/ 		// then flag all "chunkIds" as loaded and fire callback
/******/ 		var moduleId, chunkId, i = 0, resolves = [];
/******/ 		for(;i < chunkIds.length; i++) {
/******/ 			chunkId = chunkIds[i];
/******/ 			if(Object.prototype.hasOwnProperty.call(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 				resolves.push(installedChunks[chunkId][0]);
/******/ 			}
/******/ 			installedChunks[chunkId] = 0;
/******/ 		}
/******/ 		for(moduleId in moreModules) {
/******/ 			if(Object.prototype.hasOwnProperty.call(moreModules, moduleId)) {
/******/ 				modules[moduleId] = moreModules[moduleId];
/******/ 			}
/******/ 		}
/******/ 		if(parentJsonpFunction) parentJsonpFunction(data);
/******/
/******/ 		while(resolves.length) {
/******/ 			resolves.shift()();
/******/ 		}
/******/
/******/ 		// add entry modules from loaded chunk to deferred list
/******/ 		deferredModules.push.apply(deferredModules, executeModules || []);
/******/
/******/ 		// run deferred modules when all chunks ready
/******/ 		return checkDeferredModules();
/******/ 	};
/******/ 	function checkDeferredModules() {
/******/ 		var result;
/******/ 		for(var i = 0; i < deferredModules.length; i++) {
/******/ 			var deferredModule = deferredModules[i];
/******/ 			var fulfilled = true;
/******/ 			for(var j = 1; j < deferredModule.length; j++) {
/******/ 				var depId = deferredModule[j];
/******/ 				if(installedChunks[depId] !== 0) fulfilled = false;
/******/ 			}
/******/ 			if(fulfilled) {
/******/ 				deferredModules.splice(i--, 1);
/******/ 				result = __webpack_require__(__webpack_require__.s = deferredModule[0]);
/******/ 			}
/******/ 		}
/******/
/******/ 		return result;
/******/ 	}
/******/
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// object to store loaded and loading chunks
/******/ 	// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 	// Promise = chunk loading, 0 = chunk loaded
/******/ 	var installedChunks = {
/******/ 		"app": 0
/******/ 	};
/******/
/******/ 	var deferredModules = [];
/******/
/******/ 	// script path function
/******/ 	function jsonpScriptSrc(chunkId) {
/******/ 		return __webpack_require__.p + "js/" + ({}[chunkId]||chunkId) + ".js"
/******/ 	}
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/ 	// This file contains only the entry chunk.
/******/ 	// The chunk loading function for additional chunks
/******/ 	__webpack_require__.e = function requireEnsure(chunkId) {
/******/ 		var promises = [];
/******/
/******/
/******/ 		// JSONP chunk loading for javascript
/******/
/******/ 		var installedChunkData = installedChunks[chunkId];
/******/ 		if(installedChunkData !== 0) { // 0 means "already installed".
/******/
/******/ 			// a Promise means "currently loading".
/******/ 			if(installedChunkData) {
/******/ 				promises.push(installedChunkData[2]);
/******/ 			} else {
/******/ 				// setup Promise in chunk cache
/******/ 				var promise = new Promise(function(resolve, reject) {
/******/ 					installedChunkData = installedChunks[chunkId] = [resolve, reject];
/******/ 				});
/******/ 				promises.push(installedChunkData[2] = promise);
/******/
/******/ 				// start chunk loading
/******/ 				var script = document.createElement('script');
/******/ 				var onScriptComplete;
/******/
/******/ 				script.charset = 'utf-8';
/******/ 				script.timeout = 120;
/******/ 				if (__webpack_require__.nc) {
/******/ 					script.setAttribute("nonce", __webpack_require__.nc);
/******/ 				}
/******/ 				script.src = jsonpScriptSrc(chunkId);
/******/
/******/ 				// create error before stack unwound to get useful stacktrace later
/******/ 				var error = new Error();
/******/ 				onScriptComplete = function (event) {
/******/ 					// avoid mem leaks in IE.
/******/ 					script.onerror = script.onload = null;
/******/ 					clearTimeout(timeout);
/******/ 					var chunk = installedChunks[chunkId];
/******/ 					if(chunk !== 0) {
/******/ 						if(chunk) {
/******/ 							var errorType = event && (event.type === 'load' ? 'missing' : event.type);
/******/ 							var realSrc = event && event.target && event.target.src;
/******/ 							error.message = 'Loading chunk ' + chunkId + ' failed.\n(' + errorType + ': ' + realSrc + ')';
/******/ 							error.name = 'ChunkLoadError';
/******/ 							error.type = errorType;
/******/ 							error.request = realSrc;
/******/ 							chunk[1](error);
/******/ 						}
/******/ 						installedChunks[chunkId] = undefined;
/******/ 					}
/******/ 				};
/******/ 				var timeout = setTimeout(function(){
/******/ 					onScriptComplete({ type: 'timeout', target: script });
/******/ 				}, 120000);
/******/ 				script.onerror = script.onload = onScriptComplete;
/******/ 				document.head.appendChild(script);
/******/ 			}
/******/ 		}
/******/ 		return Promise.all(promises);
/******/ 	};
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// on error function for async loading
/******/ 	__webpack_require__.oe = function(err) { console.error(err); throw err; };
/******/
/******/ 	var jsonpArray = window["webpackJsonp"] = window["webpackJsonp"] || [];
/******/ 	var oldJsonpFunction = jsonpArray.push.bind(jsonpArray);
/******/ 	jsonpArray.push = webpackJsonpCallback;
/******/ 	jsonpArray = jsonpArray.slice();
/******/ 	for(var i = 0; i < jsonpArray.length; i++) webpackJsonpCallback(jsonpArray[i]);
/******/ 	var parentJsonpFunction = oldJsonpFunction;
/******/
/******/
/******/ 	// add entry module to deferred list
/******/ 	deferredModules.push([0,"chunk-vendors"]);
/******/ 	// run deferred modules when ready
/******/ 	return checkDeferredModules();
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/App.vue?vue&type=script&lang=js":
/*!*******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1!./src/App.vue?vue&type=script&lang=js ***!
  \*******************************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _components_Map_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/Map.vue */ \"./src/components/Map.vue\");\n/* harmony import */ var _components_InfoBox_vue__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./components/InfoBox.vue */ \"./src/components/InfoBox.vue\");\n/* harmony import */ var _components_SideNav_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./components/SideNav.vue */ \"./src/components/SideNav.vue\");\n\n\n\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  name: 'map',\n  components: {\n    Map: _components_Map_vue__WEBPACK_IMPORTED_MODULE_0__[\"default\"],\n    InfoBox: _components_InfoBox_vue__WEBPACK_IMPORTED_MODULE_1__[\"default\"],\n    SideNav: _components_SideNav_vue__WEBPACK_IMPORTED_MODULE_2__[\"default\"]\n  }\n});\n\n//# sourceURL=webpack:///./src/App.vue?./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1");

/***/ }),

/***/ "./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/components/InfoBox.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1!./src/components/InfoBox.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  data: function data() {\n    return {\n      active: false,\n      url: null,\n      info: {\n        id: null,\n        type: null,\n        slug: null,\n        label: null,\n        title: null,\n        description: null,\n        img: {\n          url: null,\n          alt: null\n        }\n      },\n      translations: {\n        close: 'Close',\n        learnMore: 'Learn more'\n      }\n    };\n  },\n  methods: {\n    setInfo: function setInfo(info) {\n      this.info = info;\n      this.url = '/' + this.info.type + '/' + this.info.slug;\n      this.open();\n    },\n    open: function open() {\n      this.active = true;\n    },\n    close: function close() {\n      this.active = false;\n    },\n    setTranslations: function setTranslations() {\n      var el = document.getElementById('map-translations');\n\n      if (el) {\n        this.translations = JSON.parse(el.textContent);\n      }\n    }\n  },\n  mounted: function mounted() {\n    this.setTranslations();\n  }\n});\n\n//# sourceURL=webpack:///./src/components/InfoBox.vue?./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1");

/***/ }),

/***/ "./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/components/Map.vue?vue&type=script&lang=js":
/*!******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1!./src/components/Map.vue?vue&type=script&lang=js ***!
  \******************************************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var core_js_modules_es_array_map_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.map.js */ \"./node_modules/core-js/modules/es.array.map.js\");\n/* harmony import */ var core_js_modules_es_array_map_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_map_js__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.regexp.exec.js */ \"./node_modules/core-js/modules/es.regexp.exec.js\");\n/* harmony import */ var core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_exec_js__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var core_js_modules_es_string_split_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.string.split.js */ \"./node_modules/core-js/modules/es.string.split.js\");\n/* harmony import */ var core_js_modules_es_string_split_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_split_js__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ \"./node_modules/core-js/modules/es.object.to-string.js\");\n/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_3__);\n/* harmony import */ var core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! core-js/modules/es.regexp.to-string.js */ \"./node_modules/core-js/modules/es.regexp.to-string.js\");\n/* harmony import */ var core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_regexp_to_string_js__WEBPACK_IMPORTED_MODULE_4__);\n/* harmony import */ var core_js_modules_es_number_constructor_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! core-js/modules/es.number.constructor.js */ \"./node_modules/core-js/modules/es.number.constructor.js\");\n/* harmony import */ var core_js_modules_es_number_constructor_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_number_constructor_js__WEBPACK_IMPORTED_MODULE_5__);\n/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! axios */ \"./node_modules/axios/index.js\");\n/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_6__);\n/* harmony import */ var ol_ol_css__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ol/ol.css */ \"./node_modules/ol/ol.css\");\n/* harmony import */ var ol_ol_css__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(ol_ol_css__WEBPACK_IMPORTED_MODULE_7__);\n/* harmony import */ var ol_Map__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ol/Map */ \"./node_modules/ol/Map.js\");\n/* harmony import */ var ol_proj_Projection__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ol/proj/Projection */ \"./node_modules/ol/proj/Projection.js\");\n/* harmony import */ var ol_layer__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ol/layer */ \"./node_modules/ol/layer.js\");\n/* harmony import */ var ol_source_TileWMS__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ol/source/TileWMS */ \"./node_modules/ol/source/TileWMS.js\");\n/* harmony import */ var ol_View__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ol/View */ \"./node_modules/ol/View.js\");\n/* harmony import */ var ol_proj__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ol/proj */ \"./node_modules/ol/proj.js\");\n/* harmony import */ var ol_style__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ol/style */ \"./node_modules/ol/style.js\");\n/* harmony import */ var ol_source__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! ol/source */ \"./node_modules/ol/source.js\");\n/* harmony import */ var ol_format_GeoJSON__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! ol/format/GeoJSON */ \"./node_modules/ol/format/GeoJSON.js\");\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\nvar projection = new ol_proj_Projection__WEBPACK_IMPORTED_MODULE_9__[\"default\"]({\n  code: 'EPSG:21781',\n  extent: [485869.5728, 76443.1884, 837076.5648, 299941.7864],\n  units: 'm'\n});\nObject(ol_proj__WEBPACK_IMPORTED_MODULE_13__[\"addProjection\"])(projection);\nvar styleCache = {};\nvar colors = {\n  primary: '#C90C0F',\n  primaryOpacity: 'rgba(201,12,15,0.65)'\n};\nvar perimeterVs = new ol_source__WEBPACK_IMPORTED_MODULE_15__[\"Vector\"]();\nvar heritageVs = new ol_source__WEBPACK_IMPORTED_MODULE_15__[\"Vector\"]();\nvar generalRouteVs = new ol_source__WEBPACK_IMPORTED_MODULE_15__[\"Vector\"]();\nvar routeVs = new ol_source__WEBPACK_IMPORTED_MODULE_15__[\"Vector\"]();\nvar poiVs = new ol_source__WEBPACK_IMPORTED_MODULE_15__[\"Vector\"]();\nvar poiClusterSource = new ol_source__WEBPACK_IMPORTED_MODULE_15__[\"Cluster\"]({\n  distance: 24,\n  minDistance: 10,\n  source: poiVs\n});\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  props: {},\n  data: function data() {\n    return {\n      map: false,\n      active: 'topo',\n      q: null,\n      showResults: false,\n      results: null,\n      inputName: null,\n      selected: null,\n      initialItem: {\n        'type': null,\n        'id': null\n      },\n      initialItemSelected: false,\n      layers: {\n        'topo': null,\n        'ortho': null,\n        'hiking': null,\n        'poi': null,\n        'route': null,\n        'heritage': null,\n        'perimeter': null\n      },\n      defaultOpacity: {\n        'topo': 1,\n        'ortho': 1,\n        'hiking': 0.3,\n        'poi': 1,\n        'route': 1,\n        'heritage': 1,\n        'perimeter': 0.12\n      }\n    };\n  },\n  methods: {\n    hideLayer: function hideLayer(layer) {\n      this.layers[layer].setOpacity(0);\n    },\n    showLayer: function showLayer(layer) {\n      this.layers[layer].setOpacity(this.defaultOpacity[layer]);\n    },\n    switchLayer: function switchLayer(layer) {\n      if (layer == 'ortho') {\n        this.layers.topo.setOpacity(0);\n        this.layers.ortho.setOpacity(1);\n        this.active = 'ortho';\n      } else {\n        this.layers.topo.setOpacity(1);\n        this.layers.ortho.setOpacity(0);\n        this.active = 'topo';\n      }\n    },\n    selectFeature: function selectFeature(e) {\n      var obj = this;\n      var map = this.map;\n      var view = map.getView();\n      map.forEachFeatureAtPixel(e.pixel, function (feature) {\n        obj.deselectFeature();\n        var properties = feature.getProperties(); // if cluster\n\n        if (properties.features) {\n          var clusterFeatures = properties.features;\n\n          if (clusterFeatures.length > 1) {\n            var coor = feature.getGeometry().getCoordinates();\n            var zoom = view.getZoom();\n            view.setCenter(coor);\n            view.setZoom(zoom + 1);\n          } else {\n            var poiFeature = clusterFeatures[0];\n            var poiProperties = poiFeature.getProperties();\n            obj.selected = poiFeature;\n            obj.fetchFeatureInfo(poiProperties);\n            poiFeature.set('highlighted', true);\n          }\n        } else {\n          obj.selected = feature;\n          obj.fetchFeatureInfo(properties);\n\n          if (properties.type == 'heritage') {\n            obj.selectedHeritage(feature);\n          }\n\n          if (properties.type == 'route') {\n            feature.set('highlighted', true);\n          }\n        }\n\n        return true;\n      });\n    },\n    deselectFeature: function deselectFeature() {\n      if (this.selected !== null) {\n        this.selected.set('highlighted', false);\n        this.selected = null;\n        this.$parent.$refs.infoBox.close();\n      }\n    },\n    selectedHeritage: function selectedHeritage(feature) {\n      var view = this.map.getView();\n      var coor = feature.getGeometry().getCoordinates();\n      view.setCenter(coor);\n      view.setZoom(5);\n    },\n    onPointerMove: function onPointerMove(e) {\n      // change mouse cursor when over marker\n      var pixel = this.map.getEventPixel(e.originalEvent); //let hit = this.map.hasFeatureAtPixel(pixel)\n\n      var hit = this.map.hasFeatureAtPixel(pixel, {\n        layerFilter: function layerFilter(layer) {\n          return layer.get('id') !== 'perimeter-layer';\n        }\n      });\n      this.map.getTarget().style.cursor = hit ? 'pointer' : '';\n    },\n\n    /*\n    searchOnInput() {\n    \tthis.results = null\n    \tthis.showResults = false\n    \tif (this.q.length > 2) {\n    \t\tthis.searchLocation()\n    \t}\n    },\n    searchLocation() {\n    \taxios.get('https://api3.geo.admin.ch/rest/services/api/SearchServer?type=locations&origins=gazetteer&searchText='+ this.q).then((result) => {\n    \t\tthis.results = result.data.results\n    \t\tthis.showResults = true\n    \t})\n    },\n    */\n    fetchPerimeters: function fetchPerimeters() {\n      axios__WEBPACK_IMPORTED_MODULE_6___default.a.get('heritage/perimeter').then(function (result) {\n        perimeterVs.addFeatures(new ol_format_GeoJSON__WEBPACK_IMPORTED_MODULE_16__[\"default\"]().readFeatures(result.data));\n      });\n    },\n    fetchPois: function fetchPois() {\n      var _this = this;\n\n      axios__WEBPACK_IMPORTED_MODULE_6___default.a.get('poi/list').then(function (result) {\n        poiVs.addFeatures(new ol_format_GeoJSON__WEBPACK_IMPORTED_MODULE_16__[\"default\"]().readFeatures(result.data));\n\n        _this.selectInitialItem('poi', poiVs);\n      });\n    },\n    fetchRoutes: function fetchRoutes() {\n      var _this2 = this;\n\n      axios__WEBPACK_IMPORTED_MODULE_6___default.a.get('route/list?type=detail').then(function (result) {\n        routeVs.addFeatures(new ol_format_GeoJSON__WEBPACK_IMPORTED_MODULE_16__[\"default\"]().readFeatures(result.data));\n\n        _this2.selectInitialItem('route', routeVs);\n      });\n      axios__WEBPACK_IMPORTED_MODULE_6___default.a.get('route/list?type=general').then(function (result) {\n        generalRouteVs.addFeatures(new ol_format_GeoJSON__WEBPACK_IMPORTED_MODULE_16__[\"default\"]().readFeatures(result.data));\n\n        _this2.selectInitialItem('route', generalRouteVs);\n      });\n    },\n    fetchHeritages: function fetchHeritages() {\n      var _this3 = this;\n\n      axios__WEBPACK_IMPORTED_MODULE_6___default.a.get('heritage/list').then(function (result) {\n        heritageVs.addFeatures(new ol_format_GeoJSON__WEBPACK_IMPORTED_MODULE_16__[\"default\"]().readFeatures(result.data));\n\n        _this3.selectInitialItem('heritage', heritageVs);\n      });\n    },\n    fetchFeatureInfo: function fetchFeatureInfo(properties) {\n      var obj = this;\n      var path = properties.type + '/' + properties.id;\n      axios__WEBPACK_IMPORTED_MODULE_6___default.a.get(path).then(function (result) {\n        obj.$parent.$refs.infoBox.setInfo(result.data);\n      });\n    },\n    selectInitialItem: function selectInitialItem(type, vs) {\n      if (!this.initialItemSelected && this.initialItem.type == type) {\n        var view = this.map.getView();\n        var features = vs.getFeatures();\n\n        for (var i = 0, ii = features.length; i < ii; i++) {\n          var feature = features[i];\n          var properties = feature.getProperties();\n\n          if (properties.id == this.initialItem.id) {\n            this.initialItemSelected = true;\n            this.selected = feature;\n            this.fetchFeatureInfo(properties);\n\n            if (type == 'heritage') {\n              this.selectedHeritage(feature);\n            } else {\n              view.fit(feature.getGeometry(), {\n                padding: [60, 60, 60, 60]\n              });\n\n              if (properties.type == 'route') {\n                feature.set('highlighted', true);\n              }\n\n              if (properties.type == 'poi') {\n                feature.set('highlighted', true);\n              }\n            }\n\n            break;\n          }\n        }\n      }\n    },\n    setInitalItem: function setInitalItem() {\n      var container = document.getElementById(\"heritage-map\");\n      var attr = container.getAttribute('show');\n\n      if (attr && attr != \"\") {\n        var props = attr.split('-');\n        this.initialItem.type = props[0];\n        this.initialItem.id = props[1];\n      }\n    }\n  },\n  mounted: function mounted() {\n    this.map = new ol_Map__WEBPACK_IMPORTED_MODULE_8__[\"default\"]({\n      target: this.$refs['map'],\n      layers: [this.layers.ortho = new ol_layer__WEBPACK_IMPORTED_MODULE_10__[\"Tile\"]({\n        id: \"ortho-layer\",\n        opacity: 0,\n        source: new ol_source_TileWMS__WEBPACK_IMPORTED_MODULE_11__[\"default\"]({\n          url: 'https://wms.geo.admin.ch/',\n          params: {\n            'LAYERS': 'ch.swisstopo.swissimage',\n            'FORMAT': 'image/jpeg'\n          },\n          serverType: 'mapserver'\n        })\n      }), this.layers.topo = new ol_layer__WEBPACK_IMPORTED_MODULE_10__[\"Tile\"]({\n        id: \"topo-layer\",\n        opacity: 1,\n        source: new ol_source_TileWMS__WEBPACK_IMPORTED_MODULE_11__[\"default\"]({\n          url: 'https://wms.geo.admin.ch/',\n          params: {\n            'LAYERS': 'ch.swisstopo.pixelkarte-grau',\n            'FORMAT': 'image/jpeg'\n          },\n          serverType: 'mapserver'\n        })\n      }), this.layers.perimeter = new ol_layer__WEBPACK_IMPORTED_MODULE_10__[\"Vector\"]({\n        id: \"perimeter-layer\",\n        minZoom: 3,\n        opacity: this.defaultOpacity.perimeter,\n        source: perimeterVs,\n        style: function style() {\n          return new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Style\"]({\n            fill: new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Fill\"]({\n              color: colors.primaryOpacity\n            })\n          });\n        }\n      }), this.layers.hiking = new ol_layer__WEBPACK_IMPORTED_MODULE_10__[\"Tile\"]({\n        id: \"hiking-layer\",\n        opacity: 0,\n        minZoom: 3,\n        source: new ol_source_TileWMS__WEBPACK_IMPORTED_MODULE_11__[\"default\"]({\n          url: 'https://wms.geo.admin.ch/',\n          params: {\n            'LAYERS': 'ch.swisstopo.swisstlm3d-wanderwege'\n          }\n        })\n      }), this.layers.route = new ol_layer__WEBPACK_IMPORTED_MODULE_10__[\"Vector\"]({\n        id: \"route-layer\",\n        minZoom: 3,\n        source: routeVs,\n        style: function style(feature) {\n          return routeStyle(feature);\n        }\n      }), this.layers.poi = new ol_layer__WEBPACK_IMPORTED_MODULE_10__[\"Vector\"]({\n        id: \"poi-layer\",\n        minZoom: 3,\n        source: poiClusterSource,\n        style: function style(feature) {\n          var features = feature.get('features');\n\n          if (features[0].get('highlighted')) {\n            var style = styleCache['poiSelected'];\n            var properties = features[0].getProperties();\n\n            if (!style) {\n              style = new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Style\"]({\n                image: new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Icon\"]({\n                  anchor: [20, 58],\n                  anchorXUnits: 'pixels',\n                  anchorYUnits: 'pixels',\n                  src: properties.marker\n                })\n              });\n              styleCache['poiSelected'] = style;\n            }\n\n            return style;\n          } else {\n            var size = features.length;\n            var _style = styleCache[size];\n\n            if (!_style) {\n              var radius = size + 11;\n\n              if (size > 20) {\n                radius = size * 0.2 + 11;\n              }\n\n              _style = new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Style\"]({\n                image: new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Circle\"]({\n                  radius: radius,\n                  stroke: new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Stroke\"]({\n                    color: '#fff',\n                    width: 2\n                  }),\n                  fill: new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Fill\"]({\n                    color: colors.primary\n                  })\n                }),\n                text: new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Text\"]({\n                  text: size.toString(),\n                  font: radius + 'px sans-serif',\n                  fill: new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Fill\"]({\n                    color: '#fff'\n                  })\n                })\n              });\n              styleCache[size] = _style;\n            }\n\n            return _style;\n          }\n        }\n      }), this.layers.generalRoute = new ol_layer__WEBPACK_IMPORTED_MODULE_10__[\"Vector\"]({\n        id: \"general-route-layer\",\n        source: generalRouteVs,\n        style: function style(feature) {\n          return routeStyle(feature);\n        }\n      }), this.layers.heritage = new ol_layer__WEBPACK_IMPORTED_MODULE_10__[\"Vector\"]({\n        id: \"heritage-layer\",\n        maxZoom: 3,\n        source: heritageVs,\n        style: function style(feature) {\n          var properties = feature.getProperties();\n          return new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Style\"]({\n            image: new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Icon\"]({\n              anchor: [38, 38],\n              anchorXUnits: 'pixels',\n              anchorYUnits: 'pixels',\n              src: properties.marker,\n              opacity: 0.9\n            })\n          });\n        }\n      })],\n      view: new ol_View__WEBPACK_IMPORTED_MODULE_12__[\"default\"]({\n        projection: projection,\n        center: Object(ol_proj__WEBPACK_IMPORTED_MODULE_13__[\"transform\"])([8.4, 46.7], 'EPSG:4326', 'EPSG:21781'),\n        zoom: 3,\n        minZoom: 3,\n        maxZoom: 12\n      })\n    });\n    this.map.on('pointermove', this.onPointerMove);\n    this.map.on('click', this.selectFeature);\n    this.setInitalItem();\n    this.fetchPerimeters();\n    this.fetchPois();\n    this.fetchRoutes();\n    this.fetchHeritages();\n  }\n});\n\nfunction routeStyle(feature) {\n  if (feature.get('highlighted')) {\n    return new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Style\"]({\n      stroke: new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Stroke\"]({\n        color: colors.primary,\n        width: 6,\n        opacity: 1\n      })\n    });\n  } else {\n    return new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Style\"]({\n      stroke: new ol_style__WEBPACK_IMPORTED_MODULE_14__[\"Stroke\"]({\n        color: colors.primaryOpacity,\n        width: 6\n      })\n    });\n  }\n} // We also declare EPSG:21781/EPSG:4326 transform functions. These functions\n// are necessary for the ScaleLine control and when calling ol/proj~transform\n// for setting the view's initial center (see below).\n\n\nObject(ol_proj__WEBPACK_IMPORTED_MODULE_13__[\"addCoordinateTransforms\"])('EPSG:4326', projection, function (coordinate) {\n  return [WGStoCHy(coordinate[1], coordinate[0]), WGStoCHx(coordinate[1], coordinate[0])];\n}, function (coordinate) {\n  return [CHtoWGSlng(coordinate[0], coordinate[1]), CHtoWGSlat(coordinate[0], coordinate[1])];\n});\n/*\n * Swiss projection transform functions downloaded from\n * https://www.swisstopo.admin.ch/en/knowledge-facts/surveying-geodesy/reference-systems/map-projections.html\n */\n// Convert WGS lat/long (° dec) to CH y\n\nfunction WGStoCHy(lat, lng) {\n  // Converts degrees dec to sex\n  lat = DECtoSEX(lat);\n  lng = DECtoSEX(lng); // Converts degrees to seconds (sex)\n\n  lat = DEGtoSEC(lat);\n  lng = DEGtoSEC(lng); // Axillary values (% Bern)\n\n  var lat_aux = (lat - 169028.66) / 10000;\n  var lng_aux = (lng - 26782.5) / 10000; // Process Y\n\n  var y = 600072.37 + 211455.93 * lng_aux - 10938.51 * lng_aux * lat_aux - 0.36 * lng_aux * Math.pow(lat_aux, 2) - 44.54 * Math.pow(lng_aux, 3);\n  return y;\n} // Convert WGS lat/long (° dec) to CH x\n\n\nfunction WGStoCHx(lat, lng) {\n  // Converts degrees dec to sex\n  lat = DECtoSEX(lat);\n  lng = DECtoSEX(lng); // Converts degrees to seconds (sex)\n\n  lat = DEGtoSEC(lat);\n  lng = DEGtoSEC(lng); // Axillary values (% Bern)\n\n  var lat_aux = (lat - 169028.66) / 10000;\n  var lng_aux = (lng - 26782.5) / 10000; // Process X\n\n  var x = 200147.07 + 308807.95 * lat_aux + 3745.25 * Math.pow(lng_aux, 2) + 76.63 * Math.pow(lat_aux, 2) - 194.56 * Math.pow(lng_aux, 2) * lat_aux + 119.79 * Math.pow(lat_aux, 3);\n  return x;\n} // Convert CH y/x to WGS lat\n\n\nfunction CHtoWGSlat(y, x) {\n  // Converts military to civil and to unit = 1000km\n  // Axillary values (% Bern)\n  var y_aux = (y - 600000) / 1000000;\n  var x_aux = (x - 200000) / 1000000; // Process lat\n\n  var lat = 16.9023892 + 3.238272 * x_aux - 0.270978 * Math.pow(y_aux, 2) - 0.002528 * Math.pow(x_aux, 2) - 0.0447 * Math.pow(y_aux, 2) * x_aux - 0.014 * Math.pow(x_aux, 3); // Unit 10000\" to 1 \" and converts seconds to degrees (dec)\n\n  lat = lat * 100 / 36;\n  return lat;\n} // Convert CH y/x to WGS long\n\n\nfunction CHtoWGSlng(y, x) {\n  // Converts military to civil and to unit = 1000km\n  // Axillary values (% Bern)\n  var y_aux = (y - 600000) / 1000000;\n  var x_aux = (x - 200000) / 1000000; // Process long\n\n  var lng = 2.6779094 + 4.728982 * y_aux + 0.791484 * y_aux * x_aux + 0.1306 * y_aux * Math.pow(x_aux, 2) - 0.0436 * Math.pow(y_aux, 3); // Unit 10000\" to 1 \" and converts seconds to degrees (dec)\n\n  lng = lng * 100 / 36;\n  return lng;\n} // Convert DEC angle to SEX DMS\n\n\nfunction DECtoSEX(angle) {\n  // Extract DMS\n  var deg = parseInt(angle, 10);\n  var min = parseInt((angle - deg) * 60, 10);\n  var sec = ((angle - deg) * 60 - min) * 60; // Result in degrees sex (dd.mmss)\n\n  return deg + min / 100 + sec / 10000;\n} // Convert Degrees angle to seconds\n\n\nfunction DEGtoSEC(angle) {\n  // Extract DMS\n  var deg = parseInt(angle, 10);\n  var min = parseInt((angle - deg) * 100, 10);\n  var sec = ((angle - deg) * 100 - min) * 100; // Avoid rounding problems with seconds=0\n\n  var parts = String(angle).split('.');\n\n  if (parts.length == 2 && parts[1].length == 2) {\n    min = Number(parts[1]);\n    sec = 0;\n  } // Result in degrees sex (dd.mmss)\n\n\n  return sec + min * 60 + deg * 3600;\n}\n\n//# sourceURL=webpack:///./src/components/Map.vue?./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1");

/***/ }),

/***/ "./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/components/SideNav.vue?vue&type=script&lang=js":
/*!**********************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1!./src/components/SideNav.vue?vue&type=script&lang=js ***!
  \**********************************************************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var core_js_modules_es_array_map_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.array.map.js */ \"./node_modules/core-js/modules/es.array.map.js\");\n/* harmony import */ var core_js_modules_es_array_map_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_map_js__WEBPACK_IMPORTED_MODULE_0__);\n\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  data: function data() {\n    return {\n      active: false,\n      display: {\n        pois: true,\n        routes: true,\n        perimeters: true,\n        hiking: false\n      },\n      view: 'topo',\n      translations: {\n        display: 'Display',\n        view: 'View',\n        pointOfInterest: 'Point of interests',\n        routes: 'Routes',\n        perimeter: 'World Heritage perimeters',\n        hikingTrailNetwork: 'Hiking trail network'\n      }\n    };\n  },\n  methods: {\n    toggleNav: function toggleNav() {\n      if (this.active) {\n        this.active = false;\n      } else {\n        this.active = true;\n      }\n    },\n    toggleDisplay: function toggleDisplay(e, type) {\n      var map = this.$parent.$refs.map;\n\n      if (e.target.checked) {\n        map.showLayer(type);\n      } else {\n        map.hideLayer(type);\n      }\n    },\n    switchLayer: function switchLayer(layer) {\n      var map = this.$parent.$refs.map;\n\n      if (layer == 'ortho') {\n        map.layers.topo.setOpacity(0);\n        map.layers.ortho.setOpacity(1);\n        this.view = 'ortho';\n      } else {\n        map.layers.topo.setOpacity(1);\n        map.layers.ortho.setOpacity(0);\n        this.view = 'topo';\n      }\n    },\n    getButtonClass: function getButtonClass(button) {\n      if (button == this.view) {\n        return 'btn-primary';\n      } else {\n        return 'btn-light';\n      }\n    },\n    setTranslations: function setTranslations() {\n      var el = document.getElementById('map-translations');\n\n      if (el) {\n        this.translations = JSON.parse(el.textContent);\n      }\n    }\n  },\n  mounted: function mounted() {\n    this.setTranslations();\n  }\n});\n\n//# sourceURL=webpack:///./src/components/SideNav.vue?./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1");

/***/ }),

/***/ "./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader-v16/dist/templateLoader.js?!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/App.vue?vue&type=template&id=7ba5bd90":
/*!**************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1!./src/App.vue?vue&type=template&id=7ba5bd90 ***!
  \**************************************************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return render; });\n/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ \"./node_modules/vue/dist/vue.runtime.esm-bundler.js\");\n\nvar _hoisted_1 = {\n  id: \"app\"\n};\nfunction render(_ctx, _cache, $props, $setup, $data, $options) {\n  var _component_Map = Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"resolveComponent\"])(\"Map\");\n\n  var _component_InfoBox = Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"resolveComponent\"])(\"InfoBox\");\n\n  var _component_SideNav = Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"resolveComponent\"])(\"SideNav\");\n\n  return Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"openBlock\"])(), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementBlock\"])(\"div\", _hoisted_1, [Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createVNode\"])(_component_Map, {\n    ref: \"map\"\n  }, null, 512\n  /* NEED_PATCH */\n  ), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createVNode\"])(_component_InfoBox, {\n    ref: \"infoBox\"\n  }, null, 512\n  /* NEED_PATCH */\n  ), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createVNode\"])(_component_SideNav, {\n    ref: \"sideNav\"\n  }, null, 512\n  /* NEED_PATCH */\n  )]);\n}\n\n//# sourceURL=webpack:///./src/App.vue?./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1");

/***/ }),

/***/ "./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader-v16/dist/templateLoader.js?!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/components/InfoBox.vue?vue&type=template&id=24a805bd":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1!./src/components/InfoBox.vue?vue&type=template&id=24a805bd ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return render; });\n/* harmony import */ var core_js_modules_es_symbol_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.symbol.js */ \"./node_modules/core-js/modules/es.symbol.js\");\n/* harmony import */ var core_js_modules_es_symbol_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_symbol_js__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var core_js_modules_es_symbol_description_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.symbol.description.js */ \"./node_modules/core-js/modules/es.symbol.description.js\");\n/* harmony import */ var core_js_modules_es_symbol_description_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_symbol_description_js__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue */ \"./node_modules/vue/dist/vue.runtime.esm-bundler.js\");\n\n\n\nvar _hoisted_1 = {\n  class: \"card preview-card map-preview fade-in\"\n};\nvar _hoisted_2 = [\"title\"];\n\nvar _hoisted_3 = /*#__PURE__*/Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"i\", {\n  class: \"fa fa-close\"\n}, null, -1\n/* HOISTED */\n);\n\nvar _hoisted_4 = [_hoisted_3];\nvar _hoisted_5 = {\n  class: \"row\"\n};\nvar _hoisted_6 = {\n  class: \"col-md-4 header-container\"\n};\nvar _hoisted_7 = {\n  class: \"card-header img-header\"\n};\nvar _hoisted_8 = [\"href\"];\nvar _hoisted_9 = [\"src\"];\nvar _hoisted_10 = {\n  class: \"col-md-8\"\n};\nvar _hoisted_11 = {\n  class: \"card-body small\"\n};\nvar _hoisted_12 = [\"innerHTML\"];\nvar _hoisted_13 = {\n  class: \"h3 card-title\"\n};\nvar _hoisted_14 = [\"href\", \"innerHTML\"];\nvar _hoisted_15 = [\"innerHTML\"];\nvar _hoisted_16 = [\"href\"];\n\nvar _hoisted_17 = /*#__PURE__*/Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"i\", {\n  class: \"fa fa-chevron-right\"\n}, null, -1\n/* HOISTED */\n);\n\nfunction render(_ctx, _cache, $props, $setup, $data, $options) {\n  return Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"openBlock\"])(), Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementBlock\"])(\"div\", {\n    id: \"map-info-box\",\n    class: Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"normalizeClass\"])({\n      active: $data.active\n    })\n  }, [Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"div\", _hoisted_1, [Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"div\", {\n    class: \"close close-preview\",\n    onClick: _cache[0] || (_cache[0] = function () {\n      return $options.close && $options.close.apply($options, arguments);\n    }),\n    title: this.translations.close\n  }, _hoisted_4, 8\n  /* PROPS */\n  , _hoisted_2), Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"div\", _hoisted_5, [Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"div\", _hoisted_6, [Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"div\", _hoisted_7, [Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"a\", {\n    class: \"img-link\",\n    href: this.url\n  }, [Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"img\", {\n    class: \"card-img-top\",\n    src: this.info.img.url,\n    alt: \"this.info.img.alt\"\n  }, null, 8\n  /* PROPS */\n  , _hoisted_9)], 8\n  /* PROPS */\n  , _hoisted_8)])]), Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"div\", _hoisted_10, [Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"div\", _hoisted_11, [Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"div\", {\n    class: \"label margin-bottom-sm\",\n    innerHTML: this.info.label\n  }, null, 8\n  /* PROPS */\n  , _hoisted_12), Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"div\", _hoisted_13, [Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"a\", {\n    href: this.url,\n    innerHTML: this.info.title\n  }, null, 8\n  /* PROPS */\n  , _hoisted_14)]), Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"div\", {\n    class: \"card-text\",\n    innerHTML: this.info.description\n  }, null, 8\n  /* PROPS */\n  , _hoisted_15), Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createElementVNode\"])(\"a\", {\n    href: this.url\n  }, [_hoisted_17, Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"createTextVNode\"])(\" \" + Object(vue__WEBPACK_IMPORTED_MODULE_2__[\"toDisplayString\"])($data.translations.learnMore), 1\n  /* TEXT */\n  )], 8\n  /* PROPS */\n  , _hoisted_16)])])])])], 2\n  /* CLASS */\n  );\n}\n\n//# sourceURL=webpack:///./src/components/InfoBox.vue?./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1");

/***/ }),

/***/ "./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader-v16/dist/templateLoader.js?!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/components/Map.vue?vue&type=template&id=3074bd5c":
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1!./src/components/Map.vue?vue&type=template&id=3074bd5c ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return render; });\n/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ \"./node_modules/vue/dist/vue.runtime.esm-bundler.js\");\n\nvar _hoisted_1 = {\n  class: \"map-container\"\n};\nvar _hoisted_2 = {\n  ref: \"map\",\n  class: \"map\"\n};\n\nvar _hoisted_3 = /*#__PURE__*/Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"div\", {\n  class: \"credits small\"\n}, \"©swisstopo\", -1\n/* HOISTED */\n);\n\nfunction render(_ctx, _cache, $props, $setup, $data, $options) {\n  return Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"openBlock\"])(), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementBlock\"])(\"div\", _hoisted_1, [Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"div\", _hoisted_2, null, 512\n  /* NEED_PATCH */\n  ), _hoisted_3]);\n}\n\n//# sourceURL=webpack:///./src/components/Map.vue?./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1");

/***/ }),

/***/ "./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader-v16/dist/templateLoader.js?!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/components/SideNav.vue?vue&type=template&id=5b9dec4c":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1!./src/components/SideNav.vue?vue&type=template&id=5b9dec4c ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return render; });\n/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ \"./node_modules/vue/dist/vue.runtime.esm-bundler.js\");\n\nvar _hoisted_1 = {\n  class: \"side-nav\"\n};\nvar _hoisted_2 = {\n  class: \"h3 margin-bottom\"\n};\nvar _hoisted_3 = {\n  class: \"list-unstyled margin-bottom-md\"\n};\nvar _hoisted_4 = {\n  class: \"list-item\"\n};\nvar _hoisted_5 = {\n  class: \"form-check\"\n};\nvar _hoisted_6 = {\n  class: \"form-check-label\",\n  for: \"toggle-pois\"\n};\nvar _hoisted_7 = {\n  class: \"list-item\"\n};\nvar _hoisted_8 = {\n  class: \"form-check\"\n};\nvar _hoisted_9 = {\n  class: \"form-check-label\",\n  for: \"toggle-routes\"\n};\nvar _hoisted_10 = {\n  class: \"list-item\"\n};\nvar _hoisted_11 = {\n  class: \"form-check\"\n};\nvar _hoisted_12 = {\n  class: \"form-check-label\",\n  for: \"toggle-perimeters\"\n};\nvar _hoisted_13 = {\n  class: \"list-item\"\n};\nvar _hoisted_14 = {\n  class: \"form-check\"\n};\nvar _hoisted_15 = {\n  class: \"form-check-label\",\n  for: \"toggle-hiking\"\n};\nvar _hoisted_16 = {\n  class: \"h3 margin-bottom\"\n};\nvar _hoisted_17 = {\n  class: \"layer-switcher btn-group btn-group-sm\"\n};\n\nvar _hoisted_18 = /*#__PURE__*/Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"svg\", {\n  xmlns: \"http://www.w3.org/2000/svg\",\n  width: \"21.9\",\n  height: \"38.143\",\n  viewBox: \"0 0 21.9 38.143\"\n}, [/*#__PURE__*/Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"g\", {\n  transform: \"translate(22.966 39.209) rotate(180)\"\n}, [/*#__PURE__*/Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"path\", {\n  d: \"M2.48,2.48,20.137,20.137,2.48,37.794\",\n  fill: \"none\",\n  stroke: \"currentColor\",\n  \"stroke-miterlimit\": \"10\",\n  \"stroke-width\": \"4\"\n})])], -1\n/* HOISTED */\n);\n\nvar _hoisted_19 = [_hoisted_18];\nfunction render(_ctx, _cache, $props, $setup, $data, $options) {\n  return Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"openBlock\"])(), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementBlock\"])(\"div\", {\n    class: Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"normalizeClass\"])([\"side-nav-container\", {\n      active: $data.active\n    }])\n  }, [Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"div\", _hoisted_1, [Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"div\", _hoisted_2, Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"toDisplayString\"])($data.translations.display), 1\n  /* TEXT */\n  ), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"ul\", _hoisted_3, [Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"li\", _hoisted_4, [Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"div\", _hoisted_5, [Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"withDirectives\"])(Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"input\", {\n    type: \"checkbox\",\n    class: \"form-check-input\",\n    id: \"toggle-pois\",\n    \"onUpdate:modelValue\": _cache[0] || (_cache[0] = function ($event) {\n      return $data.display.pois = $event;\n    }),\n    onChange: _cache[1] || (_cache[1] = function ($event) {\n      return $options.toggleDisplay($event, 'poi');\n    })\n  }, null, 544\n  /* HYDRATE_EVENTS, NEED_PATCH */\n  ), [[vue__WEBPACK_IMPORTED_MODULE_0__[\"vModelCheckbox\"], $data.display.pois]]), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"label\", _hoisted_6, Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"toDisplayString\"])($data.translations.pointOfInterest), 1\n  /* TEXT */\n  )])]), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"li\", _hoisted_7, [Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"div\", _hoisted_8, [Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"withDirectives\"])(Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"input\", {\n    type: \"checkbox\",\n    class: \"form-check-input\",\n    id: \"toggle-routes\",\n    \"onUpdate:modelValue\": _cache[2] || (_cache[2] = function ($event) {\n      return $data.display.routes = $event;\n    }),\n    onClick: _cache[3] || (_cache[3] = function ($event) {\n      return $options.toggleDisplay($event, 'route');\n    })\n  }, null, 512\n  /* NEED_PATCH */\n  ), [[vue__WEBPACK_IMPORTED_MODULE_0__[\"vModelCheckbox\"], $data.display.routes]]), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"label\", _hoisted_9, Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"toDisplayString\"])($data.translations.routes), 1\n  /* TEXT */\n  )])]), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"li\", _hoisted_10, [Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"div\", _hoisted_11, [Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"withDirectives\"])(Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"input\", {\n    type: \"checkbox\",\n    class: \"form-check-input\",\n    id: \"toggle-perimeters\",\n    \"onUpdate:modelValue\": _cache[4] || (_cache[4] = function ($event) {\n      return $data.display.perimeters = $event;\n    }),\n    onClick: _cache[5] || (_cache[5] = function ($event) {\n      return $options.toggleDisplay($event, 'perimeter');\n    })\n  }, null, 512\n  /* NEED_PATCH */\n  ), [[vue__WEBPACK_IMPORTED_MODULE_0__[\"vModelCheckbox\"], $data.display.perimeters]]), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"label\", _hoisted_12, Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"toDisplayString\"])($data.translations.perimeter), 1\n  /* TEXT */\n  )])]), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"li\", _hoisted_13, [Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"div\", _hoisted_14, [Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"withDirectives\"])(Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"input\", {\n    type: \"checkbox\",\n    class: \"form-check-input\",\n    id: \"toggle-hiking\",\n    \"onUpdate:modelValue\": _cache[6] || (_cache[6] = function ($event) {\n      return $data.display.hiking = $event;\n    }),\n    onClick: _cache[7] || (_cache[7] = function ($event) {\n      return $options.toggleDisplay($event, 'hiking');\n    })\n  }, null, 512\n  /* NEED_PATCH */\n  ), [[vue__WEBPACK_IMPORTED_MODULE_0__[\"vModelCheckbox\"], $data.display.hiking]]), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"label\", _hoisted_15, Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"toDisplayString\"])($data.translations.hikingTrailNetwork), 1\n  /* TEXT */\n  )])])]), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"div\", _hoisted_16, Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"toDisplayString\"])($data.translations.view), 1\n  /* TEXT */\n  ), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"div\", _hoisted_17, [Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"button\", {\n    type: \"button\",\n    class: Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"normalizeClass\"])([\"btn\", $options.getButtonClass('topo')]),\n    onClick: _cache[8] || (_cache[8] = Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"withModifiers\"])(function ($event) {\n      return $options.switchLayer('topo');\n    }, [\"prevent\"]))\n  }, \"Topo\", 2\n  /* CLASS */\n  ), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"button\", {\n    type: \"button\",\n    class: Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"normalizeClass\"])([\"btn\", $options.getButtonClass('ortho')]),\n    onClick: _cache[9] || (_cache[9] = Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"withModifiers\"])(function ($event) {\n      return $options.switchLayer('ortho');\n    }, [\"prevent\"]))\n  }, \"Ortho\", 2\n  /* CLASS */\n  )])]), Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"createElementVNode\"])(\"div\", {\n    class: \"handle\",\n    onClick: _cache[10] || (_cache[10] = Object(vue__WEBPACK_IMPORTED_MODULE_0__[\"withModifiers\"])(function () {\n      return $options.toggleNav && $options.toggleNav.apply($options, arguments);\n    }, [\"prevent\"]))\n  }, _hoisted_19)], 2\n  /* CLASS */\n  );\n}\n\n//# sourceURL=webpack:///./src/components/SideNav.vue?./node_modules/cache-loader/dist/cjs.js??ref--13-0!./node_modules/babel-loader/lib!./node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!./node_modules/cache-loader/dist/cjs.js??ref--1-0!./node_modules/vue-loader-v16/dist??ref--1-1");

/***/ }),

/***/ "./node_modules/css-loader/dist/cjs.js?!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./src/scss/custom.scss":
/*!***************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader/dist/cjs.js??ref--9-oneOf-3-1!./node_modules/postcss-loader/src??ref--9-oneOf-3-2!./node_modules/sass-loader/dist/cjs.js??ref--9-oneOf-3-3!./src/scss/custom.scss ***!
  \***************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("// Imports\nvar ___CSS_LOADER_API_IMPORT___ = __webpack_require__(/*! ../../node_modules/css-loader/dist/runtime/api.js */ \"./node_modules/css-loader/dist/runtime/api.js\");\nexports = ___CSS_LOADER_API_IMPORT___(false);\n// Module\nexports.push([module.i, \"/*\\n@import './variables';\\n@import 'node_modules/bootstrap/scss/bootstrap';\\n@import './functions';\\n@import './type';\\n@import './map';\\n@import './nav';\\n@import './buttons';\\n@import './card';\\n\\nhtml,\\nbody {\\n\\theight: 100%;\\n\\tuser-select: none;\\n\\tcursor: default;\\n}\\n\\n::-webkit-scrollbar {\\n\\twidth: 11px;\\n\\theight: 11px;\\n\\tbackground: $white;\\n}\\n\\n::-webkit-scrollbar-thumb {\\n\\tbackground: $gray;\\n}\\n\\n#heritage-map {\\n\\tposition: absolute;\\n\\theight: 100%;\\n\\twidth: 100%;\\n\\toverflow: hidden;\\n}\\n\\nhr {\\n\\tmargin: 24px 0;\\n\\tborder-color: $gray;\\n}\\n\\n.margin-bottom-xs {\\n\\tmargin-bottom: 3px;\\n}\\n\\n.margin-bottom-sm {\\n\\tmargin-bottom: 12px;\\n}\\n\\n.margin-bottom {\\n\\tmargin-bottom: 30px;\\n}\\n\\n.margin-bottom-md {\\n\\tmargin-bottom: 48px;\\n}\\n\\n.margin-bottom-lg {\\n\\tmargin-bottom: 60px;\\n\\t@include media-breakpoint-up(md) {\\n\\t\\tmargin-bottom: 120px;\\n\\t}\\n}\\n\\n.margin-top-lg {\\n\\tmargin-top: 60px;\\n\\t@include media-breakpoint-up(md) {\\n\\t\\tmargin-top: 120px;\\n\\t}\\n}\\n\\n.fadein {\\n    opacity: 0;\\n    animation: fadein 0.6s;\\n\\tanimation-fill-mode:forwards;\\n\\tanimation-delay: 0.2s;\\n}\\n\\n@include media-breakpoint-up(xs) {\\n\\thr {\\n\\t\\tmargin: 30px 0;\\n\\t}\\n\\n\\t.margin-bottom-md {\\n\\t\\tmargin-bottom: 30px;\\n\\t}\\n\\n\\t.margin-bottom-lg {\\n\\t\\tmargin-bottom: 60px;\\n\\t}\\n}\\n\\n@include media-breakpoint-up(lg) {\\n\\t.margin-bottom {\\n\\t\\tmargin-bottom: 18px;\\n\\t}\\n\\n\\t.margin-bottom-md {\\n\\t\\tmargin-bottom: 48px;\\n\\t}\\n\\n\\t.margin-bottom-lg {\\n\\t\\tmargin-bottom: 120px;\\n\\t}\\n}\\n*/\", \"\"]);\n// Exports\nmodule.exports = exports;\n\n\n//# sourceURL=webpack:///./src/scss/custom.scss?./node_modules/css-loader/dist/cjs.js??ref--9-oneOf-3-1!./node_modules/postcss-loader/src??ref--9-oneOf-3-2!./node_modules/sass-loader/dist/cjs.js??ref--9-oneOf-3-3");

/***/ }),

/***/ "./src/App.vue":
/*!*********************!*\
  !*** ./src/App.vue ***!
  \*********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _App_vue_vue_type_template_id_7ba5bd90__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./App.vue?vue&type=template&id=7ba5bd90 */ \"./src/App.vue?vue&type=template&id=7ba5bd90\");\n/* harmony import */ var _App_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./App.vue?vue&type=script&lang=js */ \"./src/App.vue?vue&type=script&lang=js\");\n/* empty/unused harmony star reexport *//* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader-v16/dist/exportHelper.js */ \"./node_modules/vue-loader-v16/dist/exportHelper.js\");\n/* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__);\n\n\n\n\n\nconst __exports__ = /*#__PURE__*/_Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2___default()(_App_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__[\"default\"], [['render',_App_vue_vue_type_template_id_7ba5bd90__WEBPACK_IMPORTED_MODULE_0__[\"render\"]],['__file',\"src/App.vue\"]])\n/* hot reload */\nif (false) {}\n\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (__exports__);\n\n//# sourceURL=webpack:///./src/App.vue?");

/***/ }),

/***/ "./src/App.vue?vue&type=script&lang=js":
/*!*********************************************!*\
  !*** ./src/App.vue?vue&type=script&lang=js ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_App_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../node_modules/cache-loader/dist/cjs.js??ref--13-0!../node_modules/babel-loader/lib!../node_modules/cache-loader/dist/cjs.js??ref--1-0!../node_modules/vue-loader-v16/dist??ref--1-1!./App.vue?vue&type=script&lang=js */ \"./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/App.vue?vue&type=script&lang=js\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"default\", function() { return _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_App_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"]; });\n\n/* empty/unused harmony star reexport */ \n\n//# sourceURL=webpack:///./src/App.vue?");

/***/ }),

/***/ "./src/App.vue?vue&type=template&id=7ba5bd90":
/*!***************************************************!*\
  !*** ./src/App.vue?vue&type=template&id=7ba5bd90 ***!
  \***************************************************/
/*! exports provided: render */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_vue_loader_v16_dist_templateLoader_js_ref_6_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_App_vue_vue_type_template_id_7ba5bd90__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../node_modules/cache-loader/dist/cjs.js??ref--13-0!../node_modules/babel-loader/lib!../node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!../node_modules/cache-loader/dist/cjs.js??ref--1-0!../node_modules/vue-loader-v16/dist??ref--1-1!./App.vue?vue&type=template&id=7ba5bd90 */ \"./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader-v16/dist/templateLoader.js?!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/App.vue?vue&type=template&id=7ba5bd90\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_vue_loader_v16_dist_templateLoader_js_ref_6_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_App_vue_vue_type_template_id_7ba5bd90__WEBPACK_IMPORTED_MODULE_0__[\"render\"]; });\n\n\n\n//# sourceURL=webpack:///./src/App.vue?");

/***/ }),

/***/ "./src/components/InfoBox.vue":
/*!************************************!*\
  !*** ./src/components/InfoBox.vue ***!
  \************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _InfoBox_vue_vue_type_template_id_24a805bd__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./InfoBox.vue?vue&type=template&id=24a805bd */ \"./src/components/InfoBox.vue?vue&type=template&id=24a805bd\");\n/* harmony import */ var _InfoBox_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./InfoBox.vue?vue&type=script&lang=js */ \"./src/components/InfoBox.vue?vue&type=script&lang=js\");\n/* empty/unused harmony star reexport *//* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader-v16/dist/exportHelper.js */ \"./node_modules/vue-loader-v16/dist/exportHelper.js\");\n/* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__);\n\n\n\n\n\nconst __exports__ = /*#__PURE__*/_Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2___default()(_InfoBox_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__[\"default\"], [['render',_InfoBox_vue_vue_type_template_id_24a805bd__WEBPACK_IMPORTED_MODULE_0__[\"render\"]],['__file',\"src/components/InfoBox.vue\"]])\n/* hot reload */\nif (false) {}\n\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (__exports__);\n\n//# sourceURL=webpack:///./src/components/InfoBox.vue?");

/***/ }),

/***/ "./src/components/InfoBox.vue?vue&type=script&lang=js":
/*!************************************************************!*\
  !*** ./src/components/InfoBox.vue?vue&type=script&lang=js ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_InfoBox_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/cache-loader/dist/cjs.js??ref--13-0!../../node_modules/babel-loader/lib!../../node_modules/cache-loader/dist/cjs.js??ref--1-0!../../node_modules/vue-loader-v16/dist??ref--1-1!./InfoBox.vue?vue&type=script&lang=js */ \"./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/components/InfoBox.vue?vue&type=script&lang=js\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"default\", function() { return _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_InfoBox_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"]; });\n\n/* empty/unused harmony star reexport */ \n\n//# sourceURL=webpack:///./src/components/InfoBox.vue?");

/***/ }),

/***/ "./src/components/InfoBox.vue?vue&type=template&id=24a805bd":
/*!******************************************************************!*\
  !*** ./src/components/InfoBox.vue?vue&type=template&id=24a805bd ***!
  \******************************************************************/
/*! exports provided: render */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_vue_loader_v16_dist_templateLoader_js_ref_6_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_InfoBox_vue_vue_type_template_id_24a805bd__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/cache-loader/dist/cjs.js??ref--13-0!../../node_modules/babel-loader/lib!../../node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!../../node_modules/cache-loader/dist/cjs.js??ref--1-0!../../node_modules/vue-loader-v16/dist??ref--1-1!./InfoBox.vue?vue&type=template&id=24a805bd */ \"./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader-v16/dist/templateLoader.js?!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/components/InfoBox.vue?vue&type=template&id=24a805bd\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_vue_loader_v16_dist_templateLoader_js_ref_6_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_InfoBox_vue_vue_type_template_id_24a805bd__WEBPACK_IMPORTED_MODULE_0__[\"render\"]; });\n\n\n\n//# sourceURL=webpack:///./src/components/InfoBox.vue?");

/***/ }),

/***/ "./src/components/Map.vue":
/*!********************************!*\
  !*** ./src/components/Map.vue ***!
  \********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _Map_vue_vue_type_template_id_3074bd5c__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Map.vue?vue&type=template&id=3074bd5c */ \"./src/components/Map.vue?vue&type=template&id=3074bd5c\");\n/* harmony import */ var _Map_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Map.vue?vue&type=script&lang=js */ \"./src/components/Map.vue?vue&type=script&lang=js\");\n/* empty/unused harmony star reexport *//* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader-v16/dist/exportHelper.js */ \"./node_modules/vue-loader-v16/dist/exportHelper.js\");\n/* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__);\n\n\n\n\n\nconst __exports__ = /*#__PURE__*/_Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2___default()(_Map_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__[\"default\"], [['render',_Map_vue_vue_type_template_id_3074bd5c__WEBPACK_IMPORTED_MODULE_0__[\"render\"]],['__file',\"src/components/Map.vue\"]])\n/* hot reload */\nif (false) {}\n\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (__exports__);\n\n//# sourceURL=webpack:///./src/components/Map.vue?");

/***/ }),

/***/ "./src/components/Map.vue?vue&type=script&lang=js":
/*!********************************************************!*\
  !*** ./src/components/Map.vue?vue&type=script&lang=js ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_Map_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/cache-loader/dist/cjs.js??ref--13-0!../../node_modules/babel-loader/lib!../../node_modules/cache-loader/dist/cjs.js??ref--1-0!../../node_modules/vue-loader-v16/dist??ref--1-1!./Map.vue?vue&type=script&lang=js */ \"./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/components/Map.vue?vue&type=script&lang=js\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"default\", function() { return _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_Map_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"]; });\n\n/* empty/unused harmony star reexport */ \n\n//# sourceURL=webpack:///./src/components/Map.vue?");

/***/ }),

/***/ "./src/components/Map.vue?vue&type=template&id=3074bd5c":
/*!**************************************************************!*\
  !*** ./src/components/Map.vue?vue&type=template&id=3074bd5c ***!
  \**************************************************************/
/*! exports provided: render */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_vue_loader_v16_dist_templateLoader_js_ref_6_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_Map_vue_vue_type_template_id_3074bd5c__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/cache-loader/dist/cjs.js??ref--13-0!../../node_modules/babel-loader/lib!../../node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!../../node_modules/cache-loader/dist/cjs.js??ref--1-0!../../node_modules/vue-loader-v16/dist??ref--1-1!./Map.vue?vue&type=template&id=3074bd5c */ \"./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader-v16/dist/templateLoader.js?!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/components/Map.vue?vue&type=template&id=3074bd5c\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_vue_loader_v16_dist_templateLoader_js_ref_6_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_Map_vue_vue_type_template_id_3074bd5c__WEBPACK_IMPORTED_MODULE_0__[\"render\"]; });\n\n\n\n//# sourceURL=webpack:///./src/components/Map.vue?");

/***/ }),

/***/ "./src/components/SideNav.vue":
/*!************************************!*\
  !*** ./src/components/SideNav.vue ***!
  \************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _SideNav_vue_vue_type_template_id_5b9dec4c__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SideNav.vue?vue&type=template&id=5b9dec4c */ \"./src/components/SideNav.vue?vue&type=template&id=5b9dec4c\");\n/* harmony import */ var _SideNav_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SideNav.vue?vue&type=script&lang=js */ \"./src/components/SideNav.vue?vue&type=script&lang=js\");\n/* empty/unused harmony star reexport *//* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/vue-loader-v16/dist/exportHelper.js */ \"./node_modules/vue-loader-v16/dist/exportHelper.js\");\n/* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2__);\n\n\n\n\n\nconst __exports__ = /*#__PURE__*/_Users_dominik_Websites_whes_map_gui_node_modules_vue_loader_v16_dist_exportHelper_js__WEBPACK_IMPORTED_MODULE_2___default()(_SideNav_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_1__[\"default\"], [['render',_SideNav_vue_vue_type_template_id_5b9dec4c__WEBPACK_IMPORTED_MODULE_0__[\"render\"]],['__file',\"src/components/SideNav.vue\"]])\n/* hot reload */\nif (false) {}\n\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (__exports__);\n\n//# sourceURL=webpack:///./src/components/SideNav.vue?");

/***/ }),

/***/ "./src/components/SideNav.vue?vue&type=script&lang=js":
/*!************************************************************!*\
  !*** ./src/components/SideNav.vue?vue&type=script&lang=js ***!
  \************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_SideNav_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/cache-loader/dist/cjs.js??ref--13-0!../../node_modules/babel-loader/lib!../../node_modules/cache-loader/dist/cjs.js??ref--1-0!../../node_modules/vue-loader-v16/dist??ref--1-1!./SideNav.vue?vue&type=script&lang=js */ \"./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/components/SideNav.vue?vue&type=script&lang=js\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"default\", function() { return _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_SideNav_vue_vue_type_script_lang_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"]; });\n\n/* empty/unused harmony star reexport */ \n\n//# sourceURL=webpack:///./src/components/SideNav.vue?");

/***/ }),

/***/ "./src/components/SideNav.vue?vue&type=template&id=5b9dec4c":
/*!******************************************************************!*\
  !*** ./src/components/SideNav.vue?vue&type=template&id=5b9dec4c ***!
  \******************************************************************/
/*! exports provided: render */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_vue_loader_v16_dist_templateLoader_js_ref_6_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_SideNav_vue_vue_type_template_id_5b9dec4c__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../node_modules/cache-loader/dist/cjs.js??ref--13-0!../../node_modules/babel-loader/lib!../../node_modules/vue-loader-v16/dist/templateLoader.js??ref--6!../../node_modules/cache-loader/dist/cjs.js??ref--1-0!../../node_modules/vue-loader-v16/dist??ref--1-1!./SideNav.vue?vue&type=template&id=5b9dec4c */ \"./node_modules/cache-loader/dist/cjs.js?!./node_modules/babel-loader/lib/index.js!./node_modules/vue-loader-v16/dist/templateLoader.js?!./node_modules/cache-loader/dist/cjs.js?!./node_modules/vue-loader-v16/dist/index.js?!./src/components/SideNav.vue?vue&type=template&id=5b9dec4c\");\n/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, \"render\", function() { return _node_modules_cache_loader_dist_cjs_js_ref_13_0_node_modules_babel_loader_lib_index_js_node_modules_vue_loader_v16_dist_templateLoader_js_ref_6_node_modules_cache_loader_dist_cjs_js_ref_1_0_node_modules_vue_loader_v16_dist_index_js_ref_1_1_SideNav_vue_vue_type_template_id_5b9dec4c__WEBPACK_IMPORTED_MODULE_0__[\"render\"]; });\n\n\n\n//# sourceURL=webpack:///./src/components/SideNav.vue?");

/***/ }),

/***/ "./src/main.js":
/*!*********************!*\
  !*** ./src/main.js ***!
  \*********************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_core_js_modules_es_array_iterator_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./node_modules/core-js/modules/es.array.iterator.js */ \"./node_modules/core-js/modules/es.array.iterator.js\");\n/* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_core_js_modules_es_array_iterator_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_Users_dominik_Websites_whes_map_gui_node_modules_core_js_modules_es_array_iterator_js__WEBPACK_IMPORTED_MODULE_0__);\n/* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./node_modules/core-js/modules/es.promise.js */ \"./node_modules/core-js/modules/es.promise.js\");\n/* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_Users_dominik_Websites_whes_map_gui_node_modules_core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_1__);\n/* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_core_js_modules_es_object_assign_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./node_modules/core-js/modules/es.object.assign.js */ \"./node_modules/core-js/modules/es.object.assign.js\");\n/* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_core_js_modules_es_object_assign_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_Users_dominik_Websites_whes_map_gui_node_modules_core_js_modules_es_object_assign_js__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_core_js_modules_es_promise_finally_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./node_modules/core-js/modules/es.promise.finally.js */ \"./node_modules/core-js/modules/es.promise.finally.js\");\n/* harmony import */ var _Users_dominik_Websites_whes_map_gui_node_modules_core_js_modules_es_promise_finally_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_Users_dominik_Websites_whes_map_gui_node_modules_core_js_modules_es_promise_finally_js__WEBPACK_IMPORTED_MODULE_3__);\n/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vue */ \"./node_modules/vue/dist/vue.runtime.esm-bundler.js\");\n/* harmony import */ var _App_vue__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./App.vue */ \"./src/App.vue\");\n/* harmony import */ var _scss_custom_scss__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./scss/custom.scss */ \"./src/scss/custom.scss\");\n/* harmony import */ var _scss_custom_scss__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_scss_custom_scss__WEBPACK_IMPORTED_MODULE_6__);\n/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! axios */ \"./node_modules/axios/index.js\");\n/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_7__);\n\n\n\n\n\n\n\n\naxios__WEBPACK_IMPORTED_MODULE_7___default.a.defaults.baseURL = \"http://api.whes.local:8888\" + '/v1';\nObject(vue__WEBPACK_IMPORTED_MODULE_4__[\"createApp\"])(_App_vue__WEBPACK_IMPORTED_MODULE_5__[\"default\"]).mount('#heritage-map');\n\n//# sourceURL=webpack:///./src/main.js?");

/***/ }),

/***/ "./src/scss/custom.scss":
/*!******************************!*\
  !*** ./src/scss/custom.scss ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("// style-loader: Adds some css to the DOM by adding a <style> tag\n\n// load the styles\nvar content = __webpack_require__(/*! !../../node_modules/css-loader/dist/cjs.js??ref--9-oneOf-3-1!../../node_modules/postcss-loader/src??ref--9-oneOf-3-2!../../node_modules/sass-loader/dist/cjs.js??ref--9-oneOf-3-3!./custom.scss */ \"./node_modules/css-loader/dist/cjs.js?!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/dist/cjs.js?!./src/scss/custom.scss\");\nif(content.__esModule) content = content.default;\nif(typeof content === 'string') content = [[module.i, content, '']];\nif(content.locals) module.exports = content.locals;\n// add the styles to the DOM\nvar add = __webpack_require__(/*! ../../node_modules/vue-style-loader/lib/addStylesClient.js */ \"./node_modules/vue-style-loader/lib/addStylesClient.js\").default\nvar update = add(\"1fd08542\", content, false, {\"sourceMap\":false,\"shadowMode\":false});\n// Hot Module Replacement\nif(false) {}\n\n//# sourceURL=webpack:///./src/scss/custom.scss?");

/***/ }),

/***/ 0:
/*!***************************!*\
  !*** multi ./src/main.js ***!
  \***************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("module.exports = __webpack_require__(/*! ./src/main.js */\"./src/main.js\");\n\n\n//# sourceURL=webpack:///multi_./src/main.js?");

/***/ }),

/***/ 1:
/*!**********************!*\
  !*** http (ignored) ***!
  \**********************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("/* (ignored) */\n\n//# sourceURL=webpack:///http_(ignored)?");

/***/ }),

/***/ 2:
/*!***********************!*\
  !*** https (ignored) ***!
  \***********************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("/* (ignored) */\n\n//# sourceURL=webpack:///https_(ignored)?");

/***/ }),

/***/ 3:
/*!*********************!*\
  !*** url (ignored) ***!
  \*********************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("/* (ignored) */\n\n//# sourceURL=webpack:///url_(ignored)?");

/***/ }),

/***/ 4:
/*!********************!*\
  !*** fs (ignored) ***!
  \********************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("/* (ignored) */\n\n//# sourceURL=webpack:///fs_(ignored)?");

/***/ })

/******/ });