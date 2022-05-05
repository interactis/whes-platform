(function(e){function t(t){for(var r,s,o=t[0],c=t[1],l=t[2],p=0,h=[];p<o.length;p++)s=o[p],Object.prototype.hasOwnProperty.call(n,s)&&n[s]&&h.push(n[s][0]),n[s]=0;for(r in c)Object.prototype.hasOwnProperty.call(c,r)&&(e[r]=c[r]);u&&u(t);while(h.length)h.shift()();return a.push.apply(a,l||[]),i()}function i(){for(var e,t=0;t<a.length;t++){for(var i=a[t],r=!0,o=1;o<i.length;o++){var c=i[o];0!==n[c]&&(r=!1)}r&&(a.splice(t--,1),e=s(s.s=i[0]))}return e}var r={},n={app:0},a=[];function s(t){if(r[t])return r[t].exports;var i=r[t]={i:t,l:!1,exports:{}};return e[t].call(i.exports,i,i.exports,s),i.l=!0,i.exports}s.m=e,s.c=r,s.d=function(e,t,i){s.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:i})},s.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},s.t=function(e,t){if(1&t&&(e=s(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var i=Object.create(null);if(s.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)s.d(i,r,function(t){return e[t]}.bind(null,r));return i},s.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return s.d(t,"a",t),t},s.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},s.p="/";var o=window["webpackJsonp"]=window["webpackJsonp"]||[],c=o.push.bind(o);o.push=t,o=o.slice();for(var l=0;l<o.length;l++)t(o[l]);var u=c;a.push([0,"chunk-vendors"]),i()})({0:function(e,t,i){e.exports=i("56d7")},"56d7":function(e,t,i){"use strict";i.r(t);i("e260"),i("e6cf"),i("cca6"),i("a79d");var r=i("7a23"),n={id:"app"};function a(e,t,i,a,s,o){var c=Object(r["h"])("Map"),l=Object(r["h"])("InfoBox"),u=Object(r["h"])("SideNav");return Object(r["g"])(),Object(r["b"])("div",n,[Object(r["e"])(c,{ref:"map"},null,512),Object(r["e"])(l,{ref:"infoBox"},null,512),Object(r["e"])(u,{ref:"sideNav"},null,512)])}var s={class:"map-container"},o={ref:"map",class:"map"},c=Object(r["c"])("div",{class:"credits small"},"©swisstopo",-1);function l(e,t,i,n,a,l){return Object(r["g"])(),Object(r["b"])("div",s,[Object(r["c"])("div",o,null,512),c])}i("d81d"),i("ac1f"),i("1276"),i("d3b7"),i("25f0"),i("a9e3");var u=i("bc3a"),p=i.n(u),h=(i("5bc0"),i("5eee")),f=i("f5dd"),d=i("480c"),g=i("3e6b"),m=i("f2f0"),b=i("a2c7"),y=i("256f"),v=i("6c77"),O=i("83a6"),w=i("6cbf"),j=i("ce2c"),k=i("8682"),I=i("8295"),x=i("5831"),M=i("55bd"),P=i("a2e1"),F=new f["a"]({code:"EPSG:21781",extent:[485869.5728,76443.1884,837076.5648,299941.7864],units:"m"});Object(y["c"])(F);var S={},C={primary:"#C90C0F",primaryOpacity:"rgba(201,12,15,0.65)"},T=new x["a"],L=new x["a"],E=new x["a"],H=new x["a"],R=new x["a"],B=new M["a"]({distance:24,minDistance:10,source:R}),N={props:{},data:function(){return{map:!1,active:"topo",q:null,showResults:!1,results:null,inputName:null,selected:null,initialItem:{type:null,id:null},initialItemSelected:!1,layers:{topo:null,ortho:null,hiking:null,poi:null,route:null,heritage:null,perimeter:null},defaultOpacity:{topo:1,ortho:1,hiking:.3,poi:1,route:1,heritage:1,perimeter:.12}}},methods:{hideLayer:function(e){this.layers[e].setOpacity(0),"route"==e&&this.layers["generalRoute"].setOpacity(0)},showLayer:function(e){this.layers[e].setOpacity(this.defaultOpacity[e]),"route"==e&&this.layers["generalRoute"].setOpacity(this.defaultOpacity[e])},switchLayer:function(e){"ortho"==e?(this.layers.topo.setOpacity(0),this.layers.ortho.setOpacity(1),this.active="ortho"):(this.layers.topo.setOpacity(1),this.layers.ortho.setOpacity(0),this.active="topo")},selectFeature:function(e){var t=this,i=this.map,r=i.getView();i.forEachFeatureAtPixel(e.pixel,(function(e){t.deselectFeature();var i=e.getProperties();if(i.features){var n=i.features;if(n.length>1){var a=e.getGeometry().getCoordinates(),s=r.getZoom();r.setCenter(a),r.setZoom(s+1)}else{var o=n[0],c=o.getProperties();t.selected=o,t.fetchFeatureInfo(c),o.set("highlighted",!0)}}else t.selected=e,t.fetchFeatureInfo(i),"heritage"==i.type&&t.selectedHeritage(e),"route"==i.type&&e.set("highlighted",!0);return!0}))},deselectFeature:function(){null!==this.selected&&(this.selected.set("highlighted",!1),this.selected=null,this.$parent.$refs.infoBox.close())},selectedHeritage:function(e){var t=this.map.getView(),i=e.getGeometry().getCoordinates();t.setCenter(i),t.setZoom(5)},onPointerMove:function(e){var t=this.map.getEventPixel(e.originalEvent),i=this.map.hasFeatureAtPixel(t,{layerFilter:function(e){return"perimeter-layer"!==e.get("id")}});this.map.getTarget().style.cursor=i?"pointer":""},fetchPerimeters:function(){p.a.get("heritage/perimeter").then((function(e){T.addFeatures((new P["a"]).readFeatures(e.data))}))},fetchPois:function(){var e=this;p.a.get("poi/list").then((function(t){R.addFeatures((new P["a"]).readFeatures(t.data)),e.selectInitialItem("poi",R)}))},fetchRoutes:function(){var e=this;p.a.get("route/list?type=detail").then((function(t){H.addFeatures((new P["a"]).readFeatures(t.data)),e.selectInitialItem("route",H)})),p.a.get("route/list?type=general").then((function(t){E.addFeatures((new P["a"]).readFeatures(t.data)),e.selectInitialItem("route",E)}))},fetchHeritages:function(){var e=this;p.a.get("heritage/list").then((function(t){L.addFeatures((new P["a"]).readFeatures(t.data)),e.selectInitialItem("heritage",L)}))},fetchFeatureInfo:function(e){var t=this,i=e.type+"/"+e.id;p.a.get(i).then((function(e){t.$parent.$refs.infoBox.setInfo(e.data)}))},selectInitialItem:function(e,t){if(!this.initialItemSelected&&this.initialItem.type==e)for(var i=this.map.getView(),r=t.getFeatures(),n=0,a=r.length;n<a;n++){var s=r[n],o=s.getProperties();if(o.id==this.initialItem.id){this.initialItemSelected=!0,this.selected=s,this.fetchFeatureInfo(o),"heritage"==e?this.selectedHeritage(s):(i.fit(s.getGeometry(),{padding:[60,60,60,60]}),"route"==o.type&&s.set("highlighted",!0),"poi"==o.type&&s.set("highlighted",!0));break}}},setInitalItem:function(){var e=document.getElementById("heritage-map"),t=e.getAttribute("show");if(t&&""!=t){var i=t.split("-");this.initialItem.type=i[0],this.initialItem.id=i[1]}}},mounted:function(){this.map=new h["a"]({target:this.$refs["map"],layers:[this.layers.ortho=new d["a"]({id:"ortho-layer",opacity:0,source:new m["a"]({url:"https://wms.geo.admin.ch/",params:{LAYERS:"ch.swisstopo.swissimage",FORMAT:"image/jpeg"},serverType:"mapserver"})}),this.layers.topo=new d["a"]({id:"topo-layer",opacity:1,source:new m["a"]({url:"https://wms.geo.admin.ch/",params:{LAYERS:"ch.swisstopo.pixelkarte-grau",FORMAT:"image/jpeg"},serverType:"mapserver"})}),this.layers.perimeter=new g["a"]({id:"perimeter-layer",minZoom:3,opacity:this.defaultOpacity.perimeter,source:T,style:function(){return new v["b"]({fill:new O["a"]({color:C.primaryOpacity})})}}),this.layers.hiking=new d["a"]({id:"hiking-layer",opacity:0,minZoom:3,source:new m["a"]({url:"https://wms.geo.admin.ch/",params:{LAYERS:"ch.swisstopo.swisstlm3d-wanderwege"}})}),this.layers.route=new g["a"]({id:"route-layer",minZoom:3,source:H,style:function(e){return Z(e)}}),this.layers.poi=new g["a"]({id:"poi-layer",minZoom:3,source:B,style:function(e){var t=e.get("features");if(t[0].get("highlighted")){var i=S["poiSelected"],r=t[0].getProperties();return i||(i=new v["b"]({image:new w["a"]({anchor:[20,58],anchorXUnits:"pixels",anchorYUnits:"pixels",src:r.marker})}),S["poiSelected"]=i),i}var n=t.length,a=S[n];if(!a){var s=n+11;n>20&&(s=.2*n+11),a=new v["b"]({image:new j["a"]({radius:s,stroke:new k["a"]({color:"#fff",width:2}),fill:new O["a"]({color:C.primary})}),text:new I["a"]({text:n.toString(),font:s+"px sans-serif",fill:new O["a"]({color:"#fff"})})}),S[n]=a}return a}}),this.layers.generalRoute=new g["a"]({id:"general-route-layer",source:E,style:function(e){return Z(e)}}),this.layers.heritage=new g["a"]({id:"heritage-layer",maxZoom:3,source:L,style:function(e){var t=e.getProperties();return new v["b"]({image:new w["a"]({anchor:[38,38],anchorXUnits:"pixels",anchorYUnits:"pixels",src:t.marker,opacity:.9})})}})],view:new b["a"]({projection:F,center:Object(y["r"])([8.4,46.7],"EPSG:4326","EPSG:21781"),zoom:3,minZoom:3,maxZoom:12})}),this.map.on("pointermove",this.onPointerMove),this.map.on("click",this.selectFeature),this.setInitalItem(),this.fetchPerimeters(),this.fetchPois(),this.fetchRoutes(),this.fetchHeritages()}};function Z(e){return e.get("highlighted")?new v["b"]({stroke:new k["a"]({color:C.primary,width:6,opacity:1})}):new v["b"]({stroke:new k["a"]({color:C.primaryOpacity,width:6})})}function U(e,t){e=D(e),t=D(t),e=G(e),t=G(t);var i=(e-169028.66)/1e4,r=(t-26782.5)/1e4,n=600072.37+211455.93*r-10938.51*r*i-.36*r*Math.pow(i,2)-44.54*Math.pow(r,3);return n}function $(e,t){e=D(e),t=D(t),e=G(e),t=G(t);var i=(e-169028.66)/1e4,r=(t-26782.5)/1e4,n=200147.07+308807.95*i+3745.25*Math.pow(r,2)+76.63*Math.pow(i,2)-194.56*Math.pow(r,2)*i+119.79*Math.pow(i,3);return n}function A(e,t){var i=(e-6e5)/1e6,r=(t-2e5)/1e6,n=16.9023892+3.238272*r-.270978*Math.pow(i,2)-.002528*Math.pow(r,2)-.0447*Math.pow(i,2)*r-.014*Math.pow(r,3);return n=100*n/36,n}function V(e,t){var i=(e-6e5)/1e6,r=(t-2e5)/1e6,n=2.6779094+4.728982*i+.791484*i*r+.1306*i*Math.pow(r,2)-.0436*Math.pow(i,3);return n=100*n/36,n}function D(e){var t=parseInt(e,10),i=parseInt(60*(e-t),10),r=60*(60*(e-t)-i);return t+i/100+r/1e4}function G(e){var t=parseInt(e,10),i=parseInt(100*(e-t),10),r=100*(100*(e-t)-i),n=String(e).split(".");return 2==n.length&&2==n[1].length&&(i=Number(n[1]),r=0),r+60*i+3600*t}Object(y["b"])("EPSG:4326",F,(function(e){return[U(e[1],e[0]),$(e[1],e[0])]}),(function(e){return[V(e[0],e[1]),A(e[0],e[1])]}));var _=i("6b0d"),Y=i.n(_);const J=Y()(N,[["render",l]]);var X=J,q=(i("a4d3"),i("e01a"),{class:"card preview-card map-preview fade-in"}),z=["title"],W=Object(r["c"])("i",{class:"fa fa-close"},null,-1),K=[W],Q={class:"row"},ee={class:"col-md-4 header-container"},te={class:"card-header img-header"},ie=["href"],re=["src"],ne={class:"col-md-8"},ae={class:"card-body small"},se=["innerHTML"],oe={class:"h3 card-title"},ce=["href","innerHTML"],le=["innerHTML"],ue=["href"],pe=Object(r["c"])("i",{class:"fa fa-chevron-right"},null,-1);function he(e,t,i,n,a,s){return Object(r["g"])(),Object(r["b"])("div",{id:"map-info-box",class:Object(r["f"])({active:a.active})},[Object(r["c"])("div",q,[Object(r["c"])("div",{class:"close close-preview",onClick:t[0]||(t[0]=function(){return s.close&&s.close.apply(s,arguments)}),title:this.translations.close},K,8,z),Object(r["c"])("div",Q,[Object(r["c"])("div",ee,[Object(r["c"])("div",te,[Object(r["c"])("a",{class:"img-link",href:this.url},[Object(r["c"])("img",{class:"card-img-top",src:this.info.img.url,alt:"this.info.img.alt"},null,8,re)],8,ie)])]),Object(r["c"])("div",ne,[Object(r["c"])("div",ae,[Object(r["c"])("div",{class:"label margin-bottom-sm",innerHTML:this.info.label},null,8,se),Object(r["c"])("div",oe,[Object(r["c"])("a",{href:this.url,innerHTML:this.info.title},null,8,ce)]),Object(r["c"])("div",{class:"card-text",innerHTML:this.info.description},null,8,le),Object(r["c"])("a",{href:this.url},[pe,Object(r["d"])(" "+Object(r["i"])(a.translations.learnMore),1)],8,ue)])])])])],2)}var fe={data:function(){return{active:!1,url:null,info:{id:null,type:null,slug:null,label:null,title:null,description:null,img:{url:null,alt:null}},translations:{close:"Close",learnMore:"Learn more"}}},methods:{setInfo:function(e){this.info=e,this.url="/"+this.info.type+"/"+this.info.slug,this.open()},open:function(){this.active=!0},close:function(){this.active=!1},setTranslations:function(){var e=document.getElementById("map-translations");e&&(this.translations=JSON.parse(e.textContent))}},mounted:function(){this.setTranslations()}};const de=Y()(fe,[["render",he]]);var ge=de,me={class:"side-nav"},be={class:"h3 margin-bottom"},ye={class:"list-unstyled margin-bottom-md"},ve={class:"list-item"},Oe={class:"form-check"},we={class:"form-check-label",for:"toggle-pois"},je={class:"list-item"},ke={class:"form-check"},Ie={class:"form-check-label",for:"toggle-routes"},xe={class:"list-item"},Me={class:"form-check"},Pe={class:"form-check-label",for:"toggle-perimeters"},Fe={class:"list-item"},Se={class:"form-check"},Ce={class:"form-check-label",for:"toggle-hiking"},Te={class:"h3 margin-bottom"},Le={class:"layer-switcher btn-group btn-group-sm"},Ee=Object(r["c"])("svg",{xmlns:"http://www.w3.org/2000/svg",width:"21.9",height:"38.143",viewBox:"0 0 21.9 38.143"},[Object(r["c"])("g",{transform:"translate(22.966 39.209) rotate(180)"},[Object(r["c"])("path",{d:"M2.48,2.48,20.137,20.137,2.48,37.794",fill:"none",stroke:"currentColor","stroke-miterlimit":"10","stroke-width":"4"})])],-1),He=[Ee];function Re(e,t,i,n,a,s){return Object(r["g"])(),Object(r["b"])("div",{class:Object(r["f"])(["side-nav-container",{active:a.active}])},[Object(r["c"])("div",me,[Object(r["c"])("div",be,Object(r["i"])(a.translations.display),1),Object(r["c"])("ul",ye,[Object(r["c"])("li",ve,[Object(r["c"])("div",Oe,[Object(r["k"])(Object(r["c"])("input",{type:"checkbox",class:"form-check-input",id:"toggle-pois","onUpdate:modelValue":t[0]||(t[0]=function(e){return a.display.pois=e}),onChange:t[1]||(t[1]=function(e){return s.toggleDisplay(e,"poi")})},null,544),[[r["j"],a.display.pois]]),Object(r["c"])("label",we,Object(r["i"])(a.translations.pointOfInterest),1)])]),Object(r["c"])("li",je,[Object(r["c"])("div",ke,[Object(r["k"])(Object(r["c"])("input",{type:"checkbox",class:"form-check-input",id:"toggle-routes","onUpdate:modelValue":t[2]||(t[2]=function(e){return a.display.routes=e}),onClick:t[3]||(t[3]=function(e){return s.toggleDisplay(e,"route")})},null,512),[[r["j"],a.display.routes]]),Object(r["c"])("label",Ie,Object(r["i"])(a.translations.routes),1)])]),Object(r["c"])("li",xe,[Object(r["c"])("div",Me,[Object(r["k"])(Object(r["c"])("input",{type:"checkbox",class:"form-check-input",id:"toggle-perimeters","onUpdate:modelValue":t[4]||(t[4]=function(e){return a.display.perimeters=e}),onClick:t[5]||(t[5]=function(e){return s.toggleDisplay(e,"perimeter")})},null,512),[[r["j"],a.display.perimeters]]),Object(r["c"])("label",Pe,Object(r["i"])(a.translations.perimeter),1)])]),Object(r["c"])("li",Fe,[Object(r["c"])("div",Se,[Object(r["k"])(Object(r["c"])("input",{type:"checkbox",class:"form-check-input",id:"toggle-hiking","onUpdate:modelValue":t[6]||(t[6]=function(e){return a.display.hiking=e}),onClick:t[7]||(t[7]=function(e){return s.toggleDisplay(e,"hiking")})},null,512),[[r["j"],a.display.hiking]]),Object(r["c"])("label",Ce,Object(r["i"])(a.translations.hikingTrailNetwork),1)])])]),Object(r["c"])("div",Te,Object(r["i"])(a.translations.view),1),Object(r["c"])("div",Le,[Object(r["c"])("button",{type:"button",class:Object(r["f"])(["btn",s.getButtonClass("topo")]),onClick:t[8]||(t[8]=Object(r["l"])((function(e){return s.switchLayer("topo")}),["prevent"]))},"Topo",2),Object(r["c"])("button",{type:"button",class:Object(r["f"])(["btn",s.getButtonClass("ortho")]),onClick:t[9]||(t[9]=Object(r["l"])((function(e){return s.switchLayer("ortho")}),["prevent"]))},"Ortho",2)])]),Object(r["c"])("div",{class:"handle",onClick:t[10]||(t[10]=Object(r["l"])((function(){return s.toggleNav&&s.toggleNav.apply(s,arguments)}),["prevent"]))},He)],2)}var Be={data:function(){return{active:!1,display:{pois:!0,routes:!0,perimeters:!0,hiking:!1},view:"topo",translations:{display:"Display",view:"View",pointOfInterest:"Point of interests",routes:"Routes",perimeter:"World Heritage perimeters",hikingTrailNetwork:"Hiking trail network"}}},methods:{toggleNav:function(){this.active?this.active=!1:this.active=!0},toggleDisplay:function(e,t){var i=this.$parent.$refs.map;e.target.checked?i.showLayer(t):i.hideLayer(t)},switchLayer:function(e){var t=this.$parent.$refs.map;"ortho"==e?(t.layers.topo.setOpacity(0),t.layers.ortho.setOpacity(1),this.view="ortho"):(t.layers.topo.setOpacity(1),t.layers.ortho.setOpacity(0),this.view="topo")},getButtonClass:function(e){return e==this.view?"btn-primary":"btn-outline-primary"},setTranslations:function(){var e=document.getElementById("map-translations");e&&(this.translations=JSON.parse(e.textContent))}},mounted:function(){this.setTranslations()}};const Ne=Y()(Be,[["render",Re]]);var Ze=Ne,Ue={name:"map",components:{Map:X,InfoBox:ge,SideNav:Ze}};const $e=Y()(Ue,[["render",a]]);var Ae=$e;i("9607");p.a.defaults.baseURL="https://api.ourheritage.ch/v1",Object(r["a"])(Ae).mount("#heritage-map")},9607:function(e,t,i){}});
//# sourceMappingURL=app.397d6d61.js.map