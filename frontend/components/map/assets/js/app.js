(function(e){function t(t){for(var r,o,s=t[0],c=t[1],l=t[2],h=0,p=[];h<s.length;h++)o=s[h],Object.prototype.hasOwnProperty.call(n,o)&&n[o]&&p.push(n[o][0]),n[o]=0;for(r in c)Object.prototype.hasOwnProperty.call(c,r)&&(e[r]=c[r]);u&&u(t);while(p.length)p.shift()();return a.push.apply(a,l||[]),i()}function i(){for(var e,t=0;t<a.length;t++){for(var i=a[t],r=!0,s=1;s<i.length;s++){var c=i[s];0!==n[c]&&(r=!1)}r&&(a.splice(t--,1),e=o(o.s=i[0]))}return e}var r={},n={app:0},a=[];function o(t){if(r[t])return r[t].exports;var i=r[t]={i:t,l:!1,exports:{}};return e[t].call(i.exports,i,i.exports,o),i.l=!0,i.exports}o.m=e,o.c=r,o.d=function(e,t,i){o.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:i})},o.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},o.t=function(e,t){if(1&t&&(e=o(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var i=Object.create(null);if(o.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)o.d(i,r,function(t){return e[t]}.bind(null,r));return i},o.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return o.d(t,"a",t),t},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},o.p="/";var s=window["webpackJsonp"]=window["webpackJsonp"]||[],c=s.push.bind(s);s.push=t,s=s.slice();for(var l=0;l<s.length;l++)t(s[l]);var u=c;a.push([0,"chunk-vendors"]),i()})({0:function(e,t,i){e.exports=i("56d7")},"56d7":function(e,t,i){"use strict";i.r(t);i("e260"),i("e6cf"),i("cca6"),i("a79d");var r=i("7a23"),n={id:"app"};function a(e,t,i,a,o,s){var c=Object(r["h"])("Map"),l=Object(r["h"])("InfoBox"),u=Object(r["h"])("SideNav");return Object(r["g"])(),Object(r["b"])("div",n,[Object(r["e"])(c,{ref:"map"},null,512),Object(r["e"])(l,{ref:"infoBox"},null,512),Object(r["e"])(u,{ref:"sideNav"},null,512)])}var o={class:"map-container"},s={ref:"map",class:"map"},c=Object(r["c"])("div",{class:"credits small"},"©swisstopo",-1),l=Object(r["c"])("i",{class:"fa fa-crosshairs icon"},null,-1),u=[l],h=Object(r["c"])("div",{id:"location-marker"},null,-1);function p(e,t,i,n,a,l){return Object(r["g"])(),Object(r["b"])("div",o,[Object(r["c"])("div",s,null,512),c,Object(r["c"])("div",{class:"track-position",onClick:t[0]||(t[0]=Object(r["l"])((function(e){return l.trackPosition()}),["prevent"]))},u),h])}i("d81d"),i("ac1f"),i("1276"),i("d3b7"),i("25f0"),i("a9e3");var f=i("bc3a"),d=i.n(f),g=(i("5bc0"),i("5eee")),m=i("f5dd"),b=i("480c"),y=i("3e6b"),v=i("f2f0"),O=i("a2c7"),w=i("256f"),j=i("6c77"),k=i("83a6"),I=i("6cbf"),x=i("ce2c"),M=i("8682"),P=i("8295"),S=i("5831"),C=i("55bd"),F=i("a2e1"),T=i("0710"),L=i("f53f"),E=new m["a"]({code:"EPSG:21781",extent:[485869.5728,76443.1884,837076.5648,299941.7864],units:"m"});Object(w["c"])(E);var R={},B={primary:"#C90C0F",primaryOpacity:"rgba(201,12,15,0.7)"},H=new S["a"],N=new S["a"],G=new S["a"],Z=new S["a"],A=new S["a"],U=new C["a"]({distance:24,minDistance:10,source:A}),V={props:{},data:function(){return{map:!1,active:"topo",q:null,showResults:!1,results:null,inputName:null,selected:null,initialItem:{type:null,id:null},initialItemSelected:!1,layers:{topo:null,ortho:null,hiking:null,poi:null,route:null,heritage:null,perimeter:null},defaultOpacity:{topo:1,ortho:1,hiking:.3,poi:1,route:1,heritage:1,perimeter:.5}}},methods:{hideLayer:function(e){this.layers[e].setOpacity(0),"route"==e&&this.layers["generalRoute"].setOpacity(0)},showLayer:function(e){this.layers[e].setOpacity(this.defaultOpacity[e]),"route"==e&&this.layers["generalRoute"].setOpacity(this.defaultOpacity[e])},switchLayer:function(e){"ortho"==e?(this.layers.topo.setOpacity(0),this.layers.ortho.setOpacity(1),this.active="ortho"):(this.layers.topo.setOpacity(1),this.layers.ortho.setOpacity(0),this.active="topo")},selectFeature:function(e){var t=this,i=this.map,r=i.getView();i.forEachFeatureAtPixel(e.pixel,(function(e){t.deselectFeature();var i=e.getProperties();if(i.features){var n=i.features;if(n.length>1){var a=e.getGeometry().getCoordinates(),o=r.getZoom();r.setCenter(a),r.setZoom(o+1)}else{var s=n[0],c=s.getProperties();t.selected=s,t.fetchFeatureInfo(c),s.set("highlighted",!0)}}else t.selected=e,t.fetchFeatureInfo(i),"heritage"==i.type&&t.selectedHeritage(e),"route"==i.type&&e.set("highlighted",!0);return!0}),{hitTolerance:6})},deselectFeature:function(){null!==this.selected&&(this.selected.set("highlighted",!1),this.selected=null,this.$parent.$refs.infoBox.close())},selectedHeritage:function(e){var t=this.map.getView(),i=e.getGeometry().getCoordinates();t.setCenter(i),t.setZoom(5)},onPointerMove:function(e){var t=this.map.getEventPixel(e.originalEvent),i=this.map.hasFeatureAtPixel(t,{layerFilter:function(e){return"perimeter-layer"!==e.get("id")}});this.map.getTarget().style.cursor=i?"pointer":""},fetchPerimeters:function(){var e="https://sdi.cde.unibe.ch/geoserver/ourheritage/wms?service=WMS&version=1.1.0&request=GetMap&layers=ourheritage%3Awelterbe_perimeter&bbox=502081.4375%2C83077.4453125%2C830547.375%2C288077.3125&width=768&height=479&srs=EPSG%3A21781&styles=&format=geojson";d.a.get(e).then((function(e){H.addFeatures((new F["a"]).readFeatures(e.data))}))},fetchPois:function(){var e=this;d.a.get("poi/list").then((function(t){A.addFeatures((new F["a"]).readFeatures(t.data)),e.selectInitialItem("poi",A)}))},fetchRoutes:function(){var e=this;d.a.get("route/list?type=detail").then((function(t){Z.addFeatures((new F["a"]).readFeatures(t.data)),e.selectInitialItem("route",Z)})),d.a.get("route/list?type=general").then((function(t){G.addFeatures((new F["a"]).readFeatures(t.data)),e.selectInitialItem("route",G)}))},fetchHeritages:function(){var e=this;d.a.get("heritage/list").then((function(t){N.addFeatures((new F["a"]).readFeatures(t.data)),e.selectInitialItem("heritage",N)}))},fetchFeatureInfo:function(e){var t=this,i=e.type+"/"+e.id;d.a.get(i).then((function(e){t.$parent.$refs.infoBox.setInfo(e.data)}))},trackPosition:function(){var e=this.map,t=this.map.getView(),i=new L["a"]({tracking:!0});i.on("change:position",(function(){var r=Object(w["s"])(i.getPosition(),"EPSG:4326","EPSG:21781");t.setCenter(r),t.setZoom(10);var n=new T["a"]({element:document.getElementById("location-marker"),positioning:"center-center"});n.setPosition(r),e.addOverlay(n)}))},selectInitialItem:function(e,t){if(!this.initialItemSelected&&this.initialItem.type==e)for(var i=this.map.getView(),r=t.getFeatures(),n=0,a=r.length;n<a;n++){var o=r[n],s=o.getProperties();if(s.id==this.initialItem.id){this.initialItemSelected=!0,this.selected=o,this.fetchFeatureInfo(s),"heritage"==e?this.selectedHeritage(o):(i.fit(o.getGeometry(),{padding:[60,60,60,60]}),"route"==s.type&&o.set("highlighted",!0),"poi"==s.type&&o.set("highlighted",!0));break}}},setInitalItem:function(){var e=document.getElementById("heritage-map"),t=e.getAttribute("show");if(t&&""!=t){var i=t.split("-");this.initialItem.type=i[0],this.initialItem.id=i[1]}}},mounted:function(){this.map=new g["a"]({target:this.$refs["map"],layers:[this.layers.ortho=new b["a"]({id:"ortho-layer",opacity:0,source:new v["a"]({url:"https://wms.geo.admin.ch/",params:{LAYERS:"ch.swisstopo.swissimage",FORMAT:"image/jpeg"},serverType:"mapserver"})}),this.layers.topo=new b["a"]({id:"topo-layer",opacity:1,source:new v["a"]({url:"https://wms.geo.admin.ch/",params:{LAYERS:"ch.swisstopo.pixelkarte-grau",FORMAT:"image/jpeg"},serverType:"mapserver"})}),this.layers.perimeter=new y["a"]({id:"perimeter-layer",minZoom:3,opacity:this.defaultOpacity.perimeter,source:H,style:function(){return new j["b"]({fill:new k["a"]({color:B.primaryOpacity})})}}),this.layers.hiking=new b["a"]({id:"hiking-layer",opacity:0,minZoom:3,source:new v["a"]({url:"https://wms.geo.admin.ch/",params:{LAYERS:"ch.swisstopo.swisstlm3d-wanderwege"}})}),this.layers.route=new y["a"]({id:"route-layer",minZoom:3,source:Z,style:function(e){return $(e)}}),this.layers.generalRoute=new y["a"]({id:"general-route-layer",source:G,style:function(e){return $(e)}}),this.layers.poi=new y["a"]({id:"poi-layer",minZoom:3,source:U,style:function(e){var t=e.get("features");if(t[0].get("highlighted")){var i=R["poiSelected"],r=t[0].getProperties();return i||(i=new j["b"]({image:new I["a"]({anchor:[20,58],anchorXUnits:"pixels",anchorYUnits:"pixels",src:r.marker})}),R["poiSelected"]=i),i}var n=t.length,a=R[n];if(!a){var o=n+11;n>20&&(o=.2*n+11),a=new j["b"]({image:new x["a"]({radius:o,stroke:new M["a"]({color:"#fff",width:2}),fill:new k["a"]({color:B.primary})}),text:new P["a"]({text:n.toString(),font:o+"px sans-serif",fill:new k["a"]({color:"#fff"})})}),R[n]=a}return a}}),this.layers.heritage=new y["a"]({id:"heritage-layer",maxZoom:3,source:N,style:function(e){var t=e.getProperties();return new j["b"]({image:new I["a"]({anchor:[38,38],anchorXUnits:"pixels",anchorYUnits:"pixels",src:t.marker,opacity:1})})}})],view:new O["a"]({projection:E,center:Object(w["s"])([8.4,46.7],"EPSG:4326","EPSG:21781"),zoom:2,minZoom:2,maxZoom:12,enableRotation:!1})}),this.map.on("pointermove",this.onPointerMove),this.map.on("click",this.selectFeature),this.setInitalItem(),this.fetchPerimeters(),this.fetchPois(),this.fetchRoutes(),this.fetchHeritages()}};function $(e){return e.get("highlighted")?new j["b"]({stroke:new M["a"]({color:B.primary,width:7,opacity:1})}):new j["b"]({stroke:new M["a"]({color:B.primaryOpacity,width:6})})}function D(e,t){e=q(e),t=q(t),e=W(e),t=W(t);var i=(e-169028.66)/1e4,r=(t-26782.5)/1e4,n=600072.37+211455.93*r-10938.51*r*i-.36*r*Math.pow(i,2)-44.54*Math.pow(r,3);return n}function _(e,t){e=q(e),t=q(t),e=W(e),t=W(t);var i=(e-169028.66)/1e4,r=(t-26782.5)/1e4,n=200147.07+308807.95*i+3745.25*Math.pow(r,2)+76.63*Math.pow(i,2)-194.56*Math.pow(r,2)*i+119.79*Math.pow(i,3);return n}function Y(e,t){var i=(e-6e5)/1e6,r=(t-2e5)/1e6,n=16.9023892+3.238272*r-.270978*Math.pow(i,2)-.002528*Math.pow(r,2)-.0447*Math.pow(i,2)*r-.014*Math.pow(r,3);return n=100*n/36,n}function J(e,t){var i=(e-6e5)/1e6,r=(t-2e5)/1e6,n=2.6779094+4.728982*i+.791484*i*r+.1306*i*Math.pow(r,2)-.0436*Math.pow(i,3);return n=100*n/36,n}function q(e){var t=parseInt(e,10),i=parseInt(60*(e-t),10),r=60*(60*(e-t)-i);return t+i/100+r/1e4}function W(e){var t=parseInt(e,10),i=parseInt(100*(e-t),10),r=100*(100*(e-t)-i),n=String(e).split(".");return 2==n.length&&2==n[1].length&&(i=Number(n[1]),r=0),r+60*i+3600*t}Object(w["b"])("EPSG:4326",E,(function(e){return[D(e[1],e[0]),_(e[1],e[0])]}),(function(e){return[J(e[0],e[1]),Y(e[0],e[1])]}));var X=i("6b0d"),z=i.n(X);const K=z()(V,[["render",p]]);var Q=K,ee=(i("a4d3"),i("e01a"),{class:"card preview-card map-preview fade-in"}),te=["title"],ie=Object(r["c"])("i",{class:"fa fa-close"},null,-1),re=[ie],ne={class:"row"},ae={class:"col-md-4 header-container"},oe={class:"card-header img-header"},se=["href"],ce=["src"],le={class:"col-md-8"},ue={class:"card-body small"},he=["innerHTML"],pe={class:"h3 card-title"},fe=["href","innerHTML"],de=["innerHTML"],ge=["href"],me=Object(r["c"])("i",{class:"fa fa-chevron-right"},null,-1);function be(e,t,i,n,a,o){return Object(r["g"])(),Object(r["b"])("div",{id:"map-info-box",class:Object(r["f"])({active:a.active})},[Object(r["c"])("div",ee,[Object(r["c"])("div",{class:"close close-preview",onClick:t[0]||(t[0]=function(){return o.close&&o.close.apply(o,arguments)}),title:this.translations.close},re,8,te),Object(r["c"])("div",ne,[Object(r["c"])("div",ae,[Object(r["c"])("div",oe,[Object(r["c"])("a",{class:"img-link",href:this.url},[Object(r["c"])("img",{class:"card-img-top",src:this.info.img.url,alt:"this.info.img.alt"},null,8,ce)],8,se)])]),Object(r["c"])("div",le,[Object(r["c"])("div",ue,[Object(r["c"])("div",{class:"label margin-bottom-sm",innerHTML:this.info.label},null,8,he),Object(r["c"])("div",pe,[Object(r["c"])("a",{href:this.url,innerHTML:this.info.title},null,8,fe)]),Object(r["c"])("div",{class:"card-text",innerHTML:this.info.description},null,8,de),Object(r["c"])("a",{href:this.url},[me,Object(r["d"])(" "+Object(r["i"])(a.translations.learnMore),1)],8,ge)])])])])],2)}var ye={data:function(){return{active:!1,url:null,info:{id:null,type:null,slug:null,label:null,title:null,description:null,img:{url:null,alt:null}},translations:{close:"Close",learnMore:"Learn more"}}},methods:{setInfo:function(e){this.info=e;var t=this.info.type;this.url="heritage"==t?"/"+this.info.slug:"/"+this.info.type+"/"+this.info.slug,this.open()},open:function(){this.active=!0},close:function(){this.active=!1},setTranslations:function(){var e=document.getElementById("map-translations");e&&(this.translations=JSON.parse(e.textContent))}},mounted:function(){this.setTranslations()}};const ve=z()(ye,[["render",be]]);var Oe=ve,we={class:"side-nav"},je={class:"h3 margin-bottom"},ke={class:"list-unstyled margin-bottom-md"},Ie={class:"list-item"},xe={class:"form-check"},Me={class:"form-check-label",for:"toggle-pois"},Pe={class:"list-item"},Se={class:"form-check"},Ce={class:"form-check-label",for:"toggle-routes"},Fe={class:"list-item"},Te={class:"form-check"},Le={class:"form-check-label",for:"toggle-perimeters"},Ee={class:"list-item"},Re={class:"form-check"},Be={class:"form-check-label",for:"toggle-hiking"},He={class:"h3 margin-bottom"},Ne={class:"layer-switcher btn-group btn-group-sm"},Ge=Object(r["c"])("svg",{xmlns:"http://www.w3.org/2000/svg",width:"21.9",height:"38.143",viewBox:"0 0 21.9 38.143"},[Object(r["c"])("g",{transform:"translate(22.966 39.209) rotate(180)"},[Object(r["c"])("path",{d:"M2.48,2.48,20.137,20.137,2.48,37.794",fill:"none",stroke:"currentColor","stroke-miterlimit":"10","stroke-width":"4"})])],-1),Ze=[Ge];function Ae(e,t,i,n,a,o){return Object(r["g"])(),Object(r["b"])("div",{class:Object(r["f"])(["side-nav-container",{active:a.active}])},[Object(r["c"])("div",we,[Object(r["c"])("div",je,Object(r["i"])(a.translations.display),1),Object(r["c"])("ul",ke,[Object(r["c"])("li",Ie,[Object(r["c"])("div",xe,[Object(r["k"])(Object(r["c"])("input",{type:"checkbox",class:"form-check-input",id:"toggle-pois","onUpdate:modelValue":t[0]||(t[0]=function(e){return a.display.pois=e}),onChange:t[1]||(t[1]=function(e){return o.toggleDisplay(e,"poi")})},null,544),[[r["j"],a.display.pois]]),Object(r["c"])("label",Me,Object(r["i"])(a.translations.pointOfInterest),1)])]),Object(r["c"])("li",Pe,[Object(r["c"])("div",Se,[Object(r["k"])(Object(r["c"])("input",{type:"checkbox",class:"form-check-input",id:"toggle-routes","onUpdate:modelValue":t[2]||(t[2]=function(e){return a.display.routes=e}),onClick:t[3]||(t[3]=function(e){return o.toggleDisplay(e,"route")})},null,512),[[r["j"],a.display.routes]]),Object(r["c"])("label",Ce,Object(r["i"])(a.translations.routes),1)])]),Object(r["c"])("li",Fe,[Object(r["c"])("div",Te,[Object(r["k"])(Object(r["c"])("input",{type:"checkbox",class:"form-check-input",id:"toggle-perimeters","onUpdate:modelValue":t[4]||(t[4]=function(e){return a.display.perimeters=e}),onClick:t[5]||(t[5]=function(e){return o.toggleDisplay(e,"perimeter")})},null,512),[[r["j"],a.display.perimeters]]),Object(r["c"])("label",Le,Object(r["i"])(a.translations.perimeter),1)])]),Object(r["c"])("li",Ee,[Object(r["c"])("div",Re,[Object(r["k"])(Object(r["c"])("input",{type:"checkbox",class:"form-check-input",id:"toggle-hiking","onUpdate:modelValue":t[6]||(t[6]=function(e){return a.display.hiking=e}),onClick:t[7]||(t[7]=function(e){return o.toggleDisplay(e,"hiking")})},null,512),[[r["j"],a.display.hiking]]),Object(r["c"])("label",Be,Object(r["i"])(a.translations.hikingTrailNetwork),1)])])]),Object(r["c"])("div",He,Object(r["i"])(a.translations.view),1),Object(r["c"])("div",Ne,[Object(r["c"])("button",{type:"button",class:Object(r["f"])(["btn",o.getButtonClass("topo")]),onClick:t[8]||(t[8]=Object(r["l"])((function(e){return o.switchLayer("topo")}),["prevent"]))},"Topo",2),Object(r["c"])("button",{type:"button",class:Object(r["f"])(["btn",o.getButtonClass("ortho")]),onClick:t[9]||(t[9]=Object(r["l"])((function(e){return o.switchLayer("ortho")}),["prevent"]))},"Ortho",2)])]),Object(r["c"])("div",{class:"handle",onClick:t[10]||(t[10]=Object(r["l"])((function(){return o.toggleNav&&o.toggleNav.apply(o,arguments)}),["prevent"]))},Ze)],2)}var Ue={data:function(){return{active:!1,display:{pois:!0,routes:!0,perimeters:!0,hiking:!1},view:"topo",translations:{display:"Display",view:"View",pointOfInterest:"Point of interests",routes:"Routes",perimeter:"World Heritage perimeters",hikingTrailNetwork:"Hiking trail network"}}},methods:{toggleNav:function(){this.active?this.active=!1:this.active=!0},toggleDisplay:function(e,t){var i=this.$parent.$refs.map;e.target.checked?i.showLayer(t):i.hideLayer(t)},switchLayer:function(e){var t=this.$parent.$refs.map;"ortho"==e?(t.layers.topo.setOpacity(0),t.layers.ortho.setOpacity(1),this.view="ortho"):(t.layers.topo.setOpacity(1),t.layers.ortho.setOpacity(0),this.view="topo")},getButtonClass:function(e){return e==this.view?"btn-primary":"btn-outline-primary"},setTranslations:function(){var e=document.getElementById("map-translations");e&&(this.translations=JSON.parse(e.textContent))}},mounted:function(){this.setTranslations()}};const Ve=z()(Ue,[["render",Ae]]);var $e=Ve,De={name:"map",components:{Map:Q,InfoBox:Oe,SideNav:$e}};const _e=z()(De,[["render",a]]);var Ye=_e;i("9607");d.a.defaults.baseURL="https://api.ourheritage.ch/v1",Object(r["a"])(Ye).mount("#heritage-map")},9607:function(e,t,i){}});
//# sourceMappingURL=app.c345b73a.js.map