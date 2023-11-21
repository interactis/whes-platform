(function(e){function t(t){for(var r,o,s=t[0],l=t[1],c=t[2],h=0,p=[];h<s.length;h++)o=s[h],Object.prototype.hasOwnProperty.call(i,o)&&i[o]&&p.push(i[o][0]),i[o]=0;for(r in l)Object.prototype.hasOwnProperty.call(l,r)&&(e[r]=l[r]);u&&u(t);while(p.length)p.shift()();return a.push.apply(a,c||[]),n()}function n(){for(var e,t=0;t<a.length;t++){for(var n=a[t],r=!0,s=1;s<n.length;s++){var l=n[s];0!==i[l]&&(r=!1)}r&&(a.splice(t--,1),e=o(o.s=n[0]))}return e}var r={},i={app:0},a=[];function o(t){if(r[t])return r[t].exports;var n=r[t]={i:t,l:!1,exports:{}};return e[t].call(n.exports,n,n.exports,o),n.l=!0,n.exports}o.m=e,o.c=r,o.d=function(e,t,n){o.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},o.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(e,t){if(1&t&&(e=o(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(o.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)o.d(n,r,function(t){return e[t]}.bind(null,r));return n},o.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return o.d(t,"a",t),t},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},o.p="/";var s=window["webpackJsonp"]=window["webpackJsonp"]||[],l=s.push.bind(s);s.push=t,s=s.slice();for(var c=0;c<s.length;c++)t(s[c]);var u=l;a.push([0,"chunk-vendors"]),n()})({0:function(e,t,n){e.exports=n("56d7")},"56d7":function(e,t,n){"use strict";n.r(t);n("e260"),n("e6cf"),n("cca6"),n("a79d");var r=n("7a23"),i={id:"app"};function a(e,t,n,a,o,s){var l=Object(r["g"])("Map"),c=Object(r["g"])("Header"),u=Object(r["g"])("InfoBox");return Object(r["f"])(),Object(r["b"])("div",i,[Object(r["d"])(l,{ref:"map"},null,512),Object(r["d"])(c,{ref:"header"},null,512),Object(r["d"])(u,{ref:"infoBox"},null,512)])}var o={class:"header"},s=Object(r["c"])("img",{src:"/img/layout/eut-logo.svg",class:"eut-logo"},null,-1),l=Object(r["c"])("img",{src:"/img/layout/saja-logo.svg",class:"saja-logo"},null,-1),c=[s,l];function u(e,t,n,i,a,s){return Object(r["f"])(),Object(r["b"])("div",o,c)}var h={data:function(){return{currentLanguage:"de"}},methods:{setLanguage:function(e){alert(e)}}},p=n("6b0d"),d=n.n(p);const f=d()(h,[["render",u]]);var m=f,g={class:"map-container"},v={ref:"map",class:"map"},y=Object(r["c"])("div",{class:"credits small"},"©swisstopo",-1),b=Object(r["c"])("div",{id:"location-marker"},null,-1);function w(e,t,n,i,a,o){return Object(r["f"])(),Object(r["b"])("div",g,[Object(r["c"])("div",v,null,512),y,b])}n("d81d"),n("ac1f"),n("1276"),n("d3b7"),n("25f0"),n("a9e3");var O=n("bc3a"),j=n.n(O),I=(n("5bc0"),n("5eee")),M=n("f5dd"),x=n("480c"),F=n("3e6b"),P=n("f2f0"),S=n("a2c7"),k=n("256f"),E=n("6c77"),L=n("83a6"),R=n("6cbf"),T=n("ce2c"),A=n("8682"),Z=n("8295"),B=n("5831"),G=n("55bd"),C=n("a2e1"),H=new M["a"]({code:"EPSG:21781",extent:[485869.5728,76443.1884,837076.5648,299941.7864],units:"m"});Object(k["c"])(H);var _={},z={primary:"#968C1B",primaryOpacity:"rgba(150,140,27,0.7)"},Y=new B["a"],$=new B["a"],J=new B["a"],N=new B["a"],U=new G["a"]({distance:24,minDistance:10,source:N}),V={props:{},data:function(){return{map:!1,active:"topo",zoom:5,q:null,showResults:!1,results:null,inputName:null,selected:null,initialItem:{type:null,id:null},initialItemSelected:!1,layers:{topo:null,ortho:null,hiking:null,transport:null,poi:null,route:null,perimeter:null},defaultOpacity:{topo:1,ortho:1,hiking:.5,transport:1,poi:1,route:1,perimeter:.5}}},methods:{hideLayer:function(e){this.layers[e].setOpacity(0),"route"==e&&this.layers["generalRoute"].setOpacity(0)},showLayer:function(e){this.layers[e].setOpacity(this.defaultOpacity[e]),"route"==e&&this.layers["generalRoute"].setOpacity(this.defaultOpacity[e])},selectFeature:function(e){var t=this,n=this.map,r=n.getView();n.forEachFeatureAtPixel(e.pixel,(function(e){t.deselectFeature();var n=e.getProperties();if(n.features){var i=n.features;if(i.length>1){var a=e.getGeometry().getCoordinates(),o=r.getZoom();r.setCenter(a),r.setZoom(o+1)}else{var s=i[0],l=s.getProperties();t.selected=s,t.fetchFeatureInfo(l),s.set("highlighted",!0)}}else t.selected=e,t.fetchFeatureInfo(n),"route"==n.type&&e.set("highlighted",!0);return!0}),{hitTolerance:6})},deselectFeature:function(){null!==this.selected&&(this.selected.set("highlighted",!1),this.selected=null,this.$parent.$refs.infoBox.close())},onPointerMove:function(e){var t=this.map.getEventPixel(e.originalEvent),n=this.map.hasFeatureAtPixel(t,{layerFilter:function(e){return"perimeter-layer"!==e.get("id")}});this.map.getTarget().style.cursor=n?"pointer":""},onMoveend:function(){var e=this.map.getView(),t=this.map.getSize(),n=e.calculateExtent(t);this.fetchPerimeters(n,t[0],t[1]);var r=e.getZoom();this.zoom!=r&&(this.zoom=r)},fetchPerimeters:function(e,t,n){var r="https://sdi.cde.unibe.ch/geoserver/ourheritage/wms?service=WMS&version=1.1.0&request=GetMap&layers=ourheritage%3Awelterbe_perimeter&srs=EPSG%3A21781&styles=&format=geojson";r+="&bbox="+e,r+="&width="+t,r+="&height="+n,j.a.get(r).then((function(e){Y.clear(),Y.addFeatures((new C["a"]).readFeatures(e.data))}))},fetchPois:function(){var e=this;j.a.get("poi/list?frontend="+this.getFrontend()).then((function(t){N.addFeatures((new C["a"]).readFeatures(t.data)),e.selectInitialItem("poi",N)}))},fetchRoutes:function(){var e=this;j.a.get("route/list?type=detail&frontend="+this.getFrontend()).then((function(t){J.addFeatures((new C["a"]).readFeatures(t.data)),e.selectInitialItem("route",J)})),j.a.get("route/list?type=general&frontend="+this.getFrontend()).then((function(t){$.addFeatures((new C["a"]).readFeatures(t.data)),e.selectInitialItem("route",$)}))},getFrontend:function(){var e=document.getElementById("heritage-map");return e.getAttribute("frontend")},fetchFeatureInfo:function(e){var t=this,n=e.type+"/"+e.id+"?fullDescription=1";j.a.get(n).then((function(e){t.$parent.$refs.infoBox.setInfo(e.data)}))},selectInitialItem:function(e,t){if(!this.initialItemSelected&&this.initialItem.type==e)for(var n=this.map.getView(),r=t.getFeatures(),i=0,a=r.length;i<a;i++){var o=r[i],s=o.getProperties();if(s.id==this.initialItem.id){this.initialItemSelected=!0,this.selected=o,this.fetchFeatureInfo(s),"heritage"==e?this.selectedHeritage(o):(n.fit(o.getGeometry(),{padding:[60,60,60,60]}),"route"==s.type&&o.set("highlighted",!0),"poi"==s.type&&o.set("highlighted",!0));break}}},setInitalItem:function(){var e=document.getElementById("heritage-map"),t=e.getAttribute("show");if(t&&""!=t){var n=t.split("-");this.initialItem.type=n[0],this.initialItem.id=n[1]}}},mounted:function(){this.map=new I["a"]({target:this.$refs["map"],layers:[this.layers.ortho=new x["a"]({id:"ortho-layer",opacity:0,source:new P["a"]({url:"https://wms.geo.admin.ch/",params:{LAYERS:"ch.swisstopo.swissimage",FORMAT:"image/jpeg"},serverType:"mapserver"})}),this.layers.topo=new x["a"]({id:"topo-layer",opacity:1,source:new P["a"]({url:"https://wms.geo.admin.ch/",params:{LAYERS:"ch.swisstopo.pixelkarte-grau",FORMAT:"image/jpeg"},serverType:"mapserver"})}),this.layers.perimeter=new F["a"]({id:"perimeter-layer",minZoom:3,opacity:this.defaultOpacity.perimeter,source:Y,style:function(){return new E["b"]({fill:new L["a"]({color:z.primaryOpacity})})}}),this.layers.hiking=new x["a"]({id:"hiking-layer",opacity:0,minZoom:5,source:new P["a"]({url:"https://wms.geo.admin.ch/",params:{LAYERS:"ch.swisstopo.swisstlm3d-wanderwege"}})}),this.layers.route=new F["a"]({id:"route-layer",minZoom:3,source:J,style:function(e){return q(e)}}),this.layers.generalRoute=new F["a"]({id:"general-route-layer",source:$,style:function(e){return q(e)}}),this.layers.transport=new x["a"]({id:"transport-layer",opacity:0,minZoom:8,source:new P["a"]({url:"https://wms.geo.admin.ch/",params:{LAYERS:"ch.bav.haltestellen-oev"}})}),this.layers.poi=new F["a"]({id:"poi-layer",minZoom:3,source:U,style:function(e){var t=e.get("features");if(t[0].get("highlighted")){var n=_["poiSelected"],r=t[0].getProperties();return n||(n=new E["b"]({image:new R["a"]({anchor:[20,58],anchorXUnits:"pixels",anchorYUnits:"pixels",src:r.marker})}),_["poiSelected"]=n),n}var i=t.length,a=_[i];if(!a){var o=i+11;i>20&&(o=.2*i+11),a=new E["b"]({image:new T["a"]({radius:o,stroke:new A["a"]({color:"#fff",width:2}),fill:new L["a"]({color:z.primary})}),text:new Z["a"]({text:i.toString(),font:o+"px sans-serif",fill:new L["a"]({color:"#fff"})})}),_[i]=a}return a}})],view:new S["a"]({projection:H,center:Object(k["r"])([8,46.49],"EPSG:4326","EPSG:21781"),zoom:this.zoom,minZoom:5,maxZoom:12,enableRotation:!1})}),this.map.on("pointermove",this.onPointerMove),this.map.on("click",this.selectFeature),this.map.on("moveend",this.onMoveend),this.setInitalItem(),this.fetchPois(),this.fetchRoutes()}};function q(e){return e.get("highlighted")?new E["b"]({stroke:new A["a"]({color:z.primaryOpacity,width:11})}):new E["b"]({stroke:new A["a"]({color:z.primaryOpacity,width:8})})}function D(e,t){e=Q(e),t=Q(t),e=ee(e),t=ee(t);var n=(e-169028.66)/1e4,r=(t-26782.5)/1e4,i=600072.37+211455.93*r-10938.51*r*n-.36*r*Math.pow(n,2)-44.54*Math.pow(r,3);return i}function W(e,t){e=Q(e),t=Q(t),e=ee(e),t=ee(t);var n=(e-169028.66)/1e4,r=(t-26782.5)/1e4,i=200147.07+308807.95*n+3745.25*Math.pow(r,2)+76.63*Math.pow(n,2)-194.56*Math.pow(r,2)*n+119.79*Math.pow(n,3);return i}function X(e,t){var n=(e-6e5)/1e6,r=(t-2e5)/1e6,i=16.9023892+3.238272*r-.270978*Math.pow(n,2)-.002528*Math.pow(r,2)-.0447*Math.pow(n,2)*r-.014*Math.pow(r,3);return i=100*i/36,i}function K(e,t){var n=(e-6e5)/1e6,r=(t-2e5)/1e6,i=2.6779094+4.728982*n+.791484*n*r+.1306*n*Math.pow(r,2)-.0436*Math.pow(n,3);return i=100*i/36,i}function Q(e){var t=parseInt(e,10),n=parseInt(60*(e-t),10),r=60*(60*(e-t)-n);return t+n/100+r/1e4}function ee(e){var t=parseInt(e,10),n=parseInt(100*(e-t),10),r=100*(100*(e-t)-n),i=String(e).split(".");return 2==i.length&&2==i[1].length&&(n=Number(i[1]),r=0),r+60*n+3600*t}Object(k["b"])("EPSG:4326",H,(function(e){return[D(e[1],e[0]),W(e[1],e[0])]}),(function(e){return[K(e[0],e[1]),X(e[0],e[1])]}));const te=d()(V,[["render",w]]);var ne=te,re=(n("a4d3"),n("e01a"),{class:"card fade-in"}),ie=["title"],ae=Object(r["c"])("i",{class:"fa fa-times"},null,-1),oe=[ae],se={class:"row"},le={class:"col-lg-5 header-container"},ce={class:"card-header img-header"},ue=["src"],he={class:"col-lg-7"},pe={class:"card-body small"},de=["innerHTML"],fe=["innerHTML"];function me(e,t,n,i,a,o){return Object(r["f"])(),Object(r["b"])("div",{id:"map-info-box",class:Object(r["e"])({active:a.active})},[Object(r["c"])("div",{class:"backdrop",onClick:t[0]||(t[0]=function(){return o.close&&o.close.apply(o,arguments)})}),Object(r["c"])("div",re,[Object(r["c"])("div",{class:"close",onClick:t[1]||(t[1]=function(){return o.close&&o.close.apply(o,arguments)}),title:this.translations.close},oe,8,ie),Object(r["c"])("div",se,[Object(r["c"])("div",le,[Object(r["c"])("div",ce,[Object(r["c"])("img",{class:"card-img-top",src:this.info.img.url,alt:"this.info.img.alt"},null,8,ue)])]),Object(r["c"])("div",he,[Object(r["c"])("div",pe,[Object(r["c"])("div",{class:"h1 card-title margin-bottom",innerHTML:this.info.title},null,8,de),Object(r["c"])("div",{class:"card-text",innerHTML:this.info.description},null,8,fe)])])])])],2)}var ge={data:function(){return{active:!1,info:{id:null,type:null,slug:null,label:null,title:null,description:null,img:{url:null,alt:null}},translations:{close:"Close",learnMore:"Learn more"}}},methods:{setInfo:function(e){this.info=e,this.open()},open:function(){this.active=!0},close:function(){this.active=!1},setTranslations:function(){var e=document.getElementById("map-translations");e&&(this.translations=JSON.parse(e.textContent))}},mounted:function(){this.setTranslations()}};const ve=d()(ge,[["render",me]]);var ye=ve,be={name:"map",components:{Header:m,Map:ne,InfoBox:ye}};const we=d()(be,[["render",a]]);var Oe=we;n("9607");j.a.defaults.baseURL="https://api.ourheritage.ch/v1",Object(r["a"])(Oe).mount("#heritage-map")},9607:function(e,t,n){}});
//# sourceMappingURL=app.d951dc52.js.map