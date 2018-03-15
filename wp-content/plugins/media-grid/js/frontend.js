/* Muuri v0.5.0-dev - CSS-animations version 
 * https://github.com/haltu/muuri
 * Copyright (c) 2015, Haltu Oy 
 */
!function(t,e){var i;if("object"==typeof module&&module.exports){try{i=require("hammerjs")}catch(t){}module.exports=e("Muuri",i)}else"function"==typeof define&&define.amd?define(["hammerjs"],function(t){return e("Muuri",t)}):t.Muuri=e("Muuri",t.Hammer)}("undefined"!=typeof window?window:this,function(t,e,i){"use strict";function n(t,e){var i,r,o,s=this;if(ot||(ot=document.body,St=G()),t=s._element=typeof t===at?nt.querySelector(t):t,!ot.contains(t))throw new et("Container element must be an existing DOM element");i=s._settings=V(n.defaultOptions,e),ct[s._id=++yt]=s,s._isDestroyed=!1,s._layout=null,s._emitter=new n.Emitter,s._setSortGroups(i.dragSortGroup),s._sortConnections=i.dragSortWith&&i.dragSortWith.length?[].concat(i.dragSortWith):null,s._itemShowHandler=typeof i.showAnimation===st?i.showAnimation(i.showDuration,i.showEasing,i.visibleStyles):N("show",i.showDuration,i.showEasing,i.visibleStyles),s._itemHideHandler=typeof i.hideAnimation===st?i.hideAnimation(i.hideDuration,i.hideEasing,i.hiddenStyles):N("hide",i.hideDuration,i.hideEasing,i.hiddenStyles),S(t,i.containerClass),s._items=[],typeof(r=i.items)===at?C(s._element.children).forEach(function(t){("*"===r||vt(t,r))&&s._items.push(new n.Item(s,t))}):($.isArray(r)||p(r))&&(s._items=C(r).map(function(t){return new n.Item(s,t)})),(o=!0===(o=i.layoutOnResize)?0:typeof o===lt?o:-1)>=0&&K.addEventListener("resize",s._resizeHandler=y(function(){s.refreshItems().layout()},o)),i.layoutOnInit&&s.layout(!0)}function r(t,e){var i,r=this,o=t._settings;r._id=++yt,pt[r._id]=r,r._isDestroyed=!1,e.parentNode!==t._element&&t._element.appendChild(e),S(e,o.itemClass),S(e,(i="none"===v(e,"display"))?o.itemHiddenClass:o.itemVisibleClass),r._gridId=t._id,r._element=e,r._child=e.children[0],r._animate=new n.ItemAnimate(r,e,"layout"),r._animateChild=new n.ItemAnimate(r,r._child,"visibility"),r._isActive=!i,r._isPositioning=!1,r._isHidden=i,r._isHiding=!1,r._isShowing=!1,r._visibilityQueue=[],r._layoutQueue=[],r._left=0,r._top=0,b(e,{left:"0",top:"0",transform:"translateX(0px) translateY(0px)",display:i?"none":"block"}),r._refreshDimensions()._refreshSortData(),i?t._itemHideHandler.start(r,!0):t._itemShowHandler.start(r,!0),r._migrate=new n.ItemMigrate(r),r._release=new n.ItemRelease(r),r._drag=o.dragEnabled?new n.ItemDrag(r):null}function o(){this._events={},this._isDestroyed=!1}function s(t,e,i){this._item=t,this._element=e,this._type=i,this._callback=null,this._callbackHandler=null,this._animateTo=null,this._isAnimating=!1,this._isDestroyed=!1}function a(t){var e=this;e._itemId=t._id,e._isDestroyed=!1,e.isActive=!1,e.container=!1,e.containerDiffX=0,e.containerDiffY=0}function l(t){var e=this;e._itemId=t._id,e._isDestroyed=!1,e.isActive=!1,e.isPositioningStarted=!1,e.containerDiffX=0,e.containerDiffY=0}function d(i){if(!e)throw new et("["+t+"] required dependency Hammer is not defined.");var n,r,o=this,s=i._element,a=i.getGrid(),l=a._settings,h=typeof l.dragStartPredicate===st?l.dragStartPredicate:d.defaultStartPredicate,f=ht;o._itemId=i._id,o._gridId=a._id,o._hammer=n=new e.Manager(s),o._isDestroyed=!1,o._isMigrating=!1,o._data={},o._resolveStartPredicate=function(t){o._isDestroyed||f!==ft||(f=ut,o.onStart(t))},o._scrollListener=function(t){o.onScroll(t)},o._checkSortOverlap=y(function(){o._data.isActive&&o.checkOverlap()},l.dragSortInterval),o._sortPredicate=typeof l.dragSortPredicate===st?l.dragSortPredicate:d.defaultSortPredicate,o.reset(),n.add(new e.Pan({event:"drag",pointers:1,threshold:0,direction:e.DIRECTION_ALL})),n.add(new e.Press({event:"draginit",pointers:1,threshold:1e3,time:0})),c(l.dragHammerSettings)&&n.set(l.dragHammerSettings),n.on("draginit dragstart dragmove",function(t){f===ht&&(f=ft),f===ft?!0===(r=h(o.getItem(),t))?(f=ut,o.onStart(t)):!1===r&&(f=_t):f===ut&&o._data.isActive&&o.onMove(t)}).on("dragend dragcancel draginitup",function(t){var e=f===ut;h(o.getItem(),t),f=ht,e&&o._data.isActive&&o.onEnd(t)}),s.addEventListener("dragstart",B,!1)}function h(t,e){var i=t.length,n=i-1;return e>n?n:e<0?tt.max(i+e,0):e}function f(t,e,i){if(!(t.length<2)){var n,r=h(t,e),o=h(t,i);r!==o&&(n=t[r],t[r]=t[o],t[o]=n)}}function u(t,e,i){if(!(t.length<2)){var n=h(t,e),r=h(t,i);n!==r&&t.splice(r,0,t.splice(n,1)[0])}}function _(t){var e,i=[],n=t.length;if(n)for(i[0]=t[0],e=1;e<n;e++)i.indexOf(t[e])<0&&i.push(t[e]);return i}function c(t){return"object"==typeof t&&"[object Object]"===Z.prototype.toString.call(t)}function p(t){var e=Z.prototype.toString.call(t);return"[object HTMLCollection]"===e||"[object NodeList]"===e}function g(t,e){return Z.keys(e).forEach(function(i){var n=c(e[i]);c(t[i])&&n?(t[i]=g({},t[i]),t[i]=g(t[i],e[i])):t[i]=n?g({},e[i]):$.isArray(e[i])?e[i].concat():e[i]}),t}function m(t,e,i){var n=typeof i===lt?i:-1;t.splice.apply(t,[n<0?t.length-n+1:n,0].concat(e))}function y(t,e){var n;return e>0?function(r){n!==i&&(n=K.clearTimeout(n),"finish"===r&&t()),"cancel"!==r&&"finish"!==r&&(n=K.setTimeout(function(){n=i,t()},e))}:function(e){"cancel"!==e&&t()}}function v(t,e){return K.getComputedStyle(t,null).getPropertyValue("transform"===e?wt.styleName||e:"transition"===e?Dt.styleName||e:e)}function w(t,e){return parseFloat(v(t,e))||0}function D(t,e){return parseFloat((v(t,"transform")||"").replace("matrix(","").split(",")["x"===e?4:5])||0}function b(t,e){var i,n,r,o=Z.keys(e);for(r=0;r<o.length;r++)n=e[i=o[r]],t.style["transform"===i&&wt?wt.propName:"transition"===i&&Dt?Dt.propName:i]=n}function S(t,e){t.classList?t.classList.add(e):vt(t,"."+e)||(t.className+=" "+e)}function I(t,e){t.classList?t.classList.remove(e):vt(t,"."+e)&&(t.className=(" "+t.className+" ").replace(" "+e+" "," ").trim())}function C(t){return[].slice.call(t)}function x(t){var e,n,r,o=t.charAt(0).toUpperCase()+t.slice(1),s=["","Webkit","Moz","O","ms"];for(r=0;r<s.length;r++)if(e=s[r],n=e?e+o:t,rt.style[n]!==i)return e=e.toLowerCase(),{prefix:e,propName:n,styleName:e?"-"+e+"-"+t:t};return null}function A(t,e,i){if(t===e)return{left:0,top:0};i&&(t=H(t,!0),e=H(e,!0));var n=R(t,!0),r=R(e,!0);return{left:r.left-n.left,top:r.top-n.top}}function R(t,e){var i,n={left:0,top:0};return t===nt?n:(n.left=K.pageXOffset||0,n.top=K.pageYOffset||0,t.self===K.self?n:(i=t.getBoundingClientRect(),n.left+=i.left,n.top+=i.top,e&&(n.left+=w(t,"border-left-width"),n.top+=w(t,"border-top-width")),n))}function H(t,e){for(var i=(e?t:t.parentElement)||nt;i&&i!==nt&&"static"===v(i,"position")&&!k(i);)i=i.parentElement||nt;return i}function E(t){var e=[],i=/(auto|scroll)/,n=t.parentNode;if(St){if("fixed"===v(t,"position"))return e;for(;n&&n!==nt&&n!==rt;)i.test(v(n,"overflow")+v(n,"overflow-y")+v(n,"overflow-x"))&&e.push(n),n="fixed"===v(n,"position")?null:n.parentNode;null!==n&&e.push(K)}else{for(;n&&n!==nt;)"fixed"!==v(t,"position")||k(n)?(i.test(v(n,"overflow")+v(n,"overflow-y")+v(n,"overflow-x"))&&e.push(n),t=n,n=n.parentNode):n=n.parentNode;e[e.length-1]===rt?e[e.length-1]=K:e.push(K)}return e}function G(){if(!wt)return!0;var t=[0,1].map(function(t,e){return t=nt.createElement("div"),b(t,{position:e?"fixed":"absolute",display:"block",visibility:"hidden",left:e?"0px":"1px",transform:"none"}),t}),e=ot.appendChild(t[0]),i=e.appendChild(t[1]),n=i.getBoundingClientRect().left;b(e,{transform:"scale(1)"});var r=n===i.getBoundingClientRect().left;return ot.removeChild(e),r}function k(t){var e=v(t,"transform"),i=v(t,"display");return"none"!==e&&"inline"!==i&&"none"!==i}function L(t,e){return q.doRectsOverlap(t,e)?(tt.min(t.left+t.width,e.left+e.width)-tt.max(t.left,e.left))*(tt.min(t.top+t.height,e.top+e.height)-tt.max(t.top,e.top))/(tt.min(t.width,e.width)*tt.min(t.height,e.height))*100:0}function M(t){var e,i={};for(e=0;e<t.length;e++)i[t[e]._id]=e;return i}function P(t,e,i,n){var r=n[t._id],o=n[e._id];return i?o-r:r-o}function X(t,e,i,n){var r,o,s,a,l,d=0;for(l=0;l<n.length;l++)if(r=n[l][0],o=n[l][1],s=(t._sortData?t:t._refreshSortData())._sortData[r],a=(e._sortData?e:e._refreshSortData())._sortData[r],0!==(d="desc"===o||!o&&i?a<s?-1:a>s?1:0:s<a?-1:s>a?1:0))return d;return d}function Y(t,e){var i,n,r,o=[],s=t.concat();for(r=0;r<e.length;r++)i=e[r],(n=s.indexOf(i))>-1&&(o.push(i),s.splice(n,1));return $.prototype.splice.apply(t,[0,t.length].concat(o).concat(s)),t}function O(t,e,i){return i.width&&i.height&&t>=i.left&&t<i.left+i.width&&e>=i.top&&e<i.top+i.height}function T(t,e,n,r){var o,s,a=t.getItems(n),l=r||{},d=!0===l.instant,h=l.onFinish,f=l.layout?l.layout:l.layout===i,u=a.length,_="show"===e,c=_?Ct:At,p=_?xt:Rt,g=!1,m=[],y=[];if(u){for(t._emit(c,a.concat()),s=0;s<a.length;s++)o=a[s],(_&&!o._isActive||!_&&o._isActive)&&(g=!0),_&&!o._isActive&&(o._skipNextLayoutAnimation=!0),_&&o._isHidden&&y.push(o),o["_"+e](d,function(e,i){e||m.push(i),--u<1&&(typeof h===st&&h(m.concat()),t._emit(p,m.concat()))});y.length&&t.refreshItems(y),g&&f&&t.layout("instant"===f,typeof f===st?f:i)}else typeof h===st&&h(a);return t}function N(t,e,i,n){e=parseInt(e)||0,i=i||"ease",n=c(n)?n:null;var r=e>0;return{start:function(t,o,s){t._visibilityRafModify&&(dt.remove(t._visibilityRafModify),t._visibilityRafModify=null),r&&n?o?(b(t._child,n),s&&s()):t._visibilityRafModify=dt.modify(function(){t._visibilityRafModify=null,t._animateChild.start(n,{duration:e,easing:i,onFinish:s})}):s&&s()},stop:function(t){t._visibilityRafModify&&(dt.remove(t._visibilityRafModify),t._visibilityRafModify=null),t._animateChild.stop()}}}function F(t,e,i){var n,r,o,s=null,a=e._getSortConnections(!0),l=-1;for(o=0;o<a.length;o++)(r=a[o])._refreshDimensions(),(n=L(t,{width:r._width,height:r._height,left:r._left,top:r._top}))>i&&n>l&&(l=n,s=r);return s}function z(t,e,i){var n,r=t.splice(0,t.length);for(n=0;n<r.length;n++)r[n](e,i)}function W(t,e){var i;return"inactive"===e?!t.isActive():"hidden"===e?!t.isVisible():(i="is"+e.charAt(0).toUpperCase()+e.slice(1),typeof t[i]===st&&t[i]())}function B(t){t.preventDefault&&t.preventDefault()}function V(t,e){var i=g({},t);return i=e?g(i,e):i,i.visibleStyles=(e||{}).visibleStyles||(t||{}).visibleStyles,i.hiddenStyles=(e||{}).hiddenStyles||(t||{}).hiddenStyles,i}function Q(t,e){var i,n=t._drag._startPredicateData;if(!(e.distance<n.distance||n.delay))return i=n.handleElement.getBoundingClientRect(),j(t),O(e.srcEvent.pageX,e.srcEvent.pageY,{width:i.width,height:i.height,left:i.left+(K.pageXOffset||0),top:i.top+(K.pageYOffset||0)})}function j(t){var e=t._drag._startPredicateData;e&&(e.delayTimer&&(e.delayTimer=K.clearTimeout(e.delayTimer)),t._drag._startPredicateData=null)}function q(t,e,i,n){var r,o,s,a,l,d,h,f=!!n.fillGaps,u=!!n.horizontal,_=!!n.alignRight,c=!!n.alignBottom,p=!!n.rounding,g={slots:{},width:u?0:p?tt.round(e):e,height:u?p?tt.round(i):i:0,setWidth:u,setHeight:!u},m=[];if(!t.length)return g;for(h=0;h<t.length;h++)l=(a=t[h])._width+a._margin.left+a._margin.right,d=a._height+a._margin.top+a._margin.bottom,p&&(l=tt.round(l),d=tt.round(d)),s=(o=q.getSlot(g,m,l,d,!u,f))[0],m=o[1],u?g.width=tt.max(g.width,s.left+s.width):g.height=tt.max(g.height,s.top+s.height),g.slots[a._id]=s;if(_||c)for(r=Z.keys(g.slots),h=0;h<r.length;h++)s=g.slots[r[h]],_&&(s.left=g.width-(s.left+s.width)),c&&(s.top=g.height-(s.top+s.height));return g}var U,J,K=window,Z=K.Object,$=K.Array,tt=K.Math,et=K.Error,it=K.Element,nt=K.document,rt=nt.documentElement,ot=nt.body,st="function",at="string",lt="number",dt=function(){function t(){if(i.length||n.length){var t,e=i.splice(0,i.length),r=n.splice(0,n.length);for(t=0;t<e.length;t++)e[t]();for(t=0;t<r.length;t++)r[t]()}}var e=(K.requestAnimationFrame||K.webkitRequestAnimationFrame||K.mozRequestAnimationFrame||K.msRequestAnimationFrame||function(t){return K.setTimeout(t,16)}).bind(K),i=[],n=[];return{modify:function(r){return n.push(r),1===n.length&&!i.length&&e(t),r},inspect:function(r){return i.push(r),1===i.length&&!n.length&&e(t),r},remove:function(t){[n,i].forEach(function(e){var i=e.indexOf(t);i>-1&&e.splice(i,1)})}}}(),ht=0,ft=1,ut=2,_t=3,ct={},pt={},gt={},mt=function(){},yt=0,vt=function(){var t=it.prototype,e=t.matches||t.matchesSelector||t.webkitMatchesSelector||t.mozMatchesSelector||t.msMatchesSelector||t.oMatchesSelector;return function(t,i){return e.call(t,i)}}(),wt=x("transform"),Dt=x("transition"),bt=Dt?{transition:"transitionend",OTransition:"oTransitionEnd",MozTransition:"transitionend",WebkitTransition:"webkitTransitionEnd",msTransition:"transitionend"}[Dt.propName]:null,St=ot?G():null,It="layoutEnd",Ct="showStart",xt="showEnd",At="hideStart",Rt="hideEnd";return n.Item=r,n.ItemDrag=d,n.ItemRelease=l,n.ItemMigrate=a,n.ItemAnimate=s,n.Layout=function(t,e){e=e.concat(),t._refreshDimensions();var i=this,n=t._settings.layout,r=t._width-t._border.left-t._border.right,o=t._height-t._border.top-t._border.bottom,s=typeof n===st?n(e,r,o):q(e,r,o,c(n)?n:{});i.slots=s.slots,i.setWidth=s.setWidth||!1,i.setHeight=s.setHeight||!1,i.width=s.width,i.height=s.height},n.Emitter=o,n.defaultOptions={items:"*",showDuration:300,showEasing:"ease",hideDuration:300,hideEasing:"ease",showAnimation:null,hideAnimation:null,visibleStyles:{opacity:"1",transform:"scale(1)"},hiddenStyles:{opacity:"0",transform:"scale(0.5)"},layout:{fillGaps:!1,horizontal:!1,alignRight:!1,alignBottom:!1,rounding:!0},layoutOnResize:100,layoutOnInit:!0,layoutDuration:300,layoutEasing:"ease",sortData:null,dragEnabled:!1,dragContainer:null,dragStartPredicate:{distance:0,delay:0,handle:!1},dragAxis:null,dragSort:!0,dragSortInterval:100,dragSortPredicate:{threshold:50,action:"move"},dragSortGroup:null,dragSortWith:null,dragReleaseDuration:300,dragReleaseEasing:"ease",dragHammerSettings:{touchAction:"none"},containerClass:"muuri",itemClass:"muuri-item",itemVisibleClass:"muuri-item-shown",itemHiddenClass:"muuri-item-hidden",itemPositioningClass:"muuri-item-positioning",itemDraggingClass:"muuri-item-dragging",itemReleasingClass:"muuri-item-releasing"},n.prototype.on=function(t,e){return this._isDestroyed||this._emitter.on(t,e),this},n.prototype.once=function(t,e){return this._isDestroyed||this._emitter.once(t,e),this},n.prototype.off=function(t,e){return this._isDestroyed||this._emitter.off(t,e),this},n.prototype.getElement=function(){return this._element},n.prototype.getItems=function(t,e){var i,n,r=this,o=0===t||t&&typeof t!==at,s=o?p(t)?C(t):[].concat(t):null,a=o?e:t,l=[];if(r._isDestroyed)return l;if((a=typeof a===at?a:null)||s){for(s=s||r._items,n=0;n<s.length;n++)!(i=o?r._getItem(s[n]):s[n])||a&&!W(i,a)||l.push(i);return l}return l.concat(r._items)},n.prototype.refreshItems=function(t){var e,i,n=this;if(!n._isDestroyed)for(e=n.getItems(t||"active"),i=0;i<e.length;i++)e[i]._refreshDimensions();return n},n.prototype.refreshSortData=function(t){var e,i,n=this;if(!n._isDestroyed)for(e=n.getItems(t),i=0;i<e.length;i++)e[i]._refreshSortData();return n},n.prototype.synchronize=function(){var t,e,i,n=this,r=n._element,o=n._items;if(n._isDestroyed)return n;if(o.length){for(i=0;i<o.length;i++)(e=o[i]._element).parentNode===r&&(t=t||nt.createDocumentFragment()).appendChild(e);t&&r.appendChild(t)}return n._emit("synchronize"),n},n.prototype.layout=function(t,e){function i(){--_<=0&&(typeof f===st&&f(h._layout!==r,o.concat()),h._layout===r&&h._emit(It,o.concat()))}var r,o,s,a,l,d,h=this,f=typeof t===st?t:e,u=!0===t,_=0;if(h._isDestroyed)return h;if(o=h.getItems("active"),r=h._layout=new n.Layout(h,o),_=o.length,(r.setWidth||r.setHeight)&&(s="border-box"===v(h._element,"box-sizing"),r.setHeight&&b(h._element,{height:(s?r.height+h._border.top+h._border.bottom:r.height)+"px"}),r.setWidth&&b(h._element,{width:(s?r.width+h._border.left+h._border.right:r.width)+"px"})),h._emit("layoutStart",o.concat()),!o.length)return i(),h;for(dt.inspect(function(){U=window.innerWidth,J=window.innerHeight}),d=0;d<o.length;d++)a=o[d],l=r.slots[a._id],a._left=l.left,a._top=l.top,a.isDragging()?i():a._layout(u,i);return h},n.prototype.add=function(t,e){var r,o,s,a=this,l=[].concat(t),d=e||{},h=d.layout?d.layout:d.layout===i,f=[],u=a._items,_=!1;if(a._isDestroyed)return[];for(s=0;s<u.length;s++)(r=l.indexOf(u[s]._element))>-1&&l.splice(r,1);if(!l.length)return f;for(s=0;s<l.length;s++)o=new n.Item(a,l[s]),f.push(o),o._isActive&&(_=!0,o._skipNextLayoutAnimation=!0);return m(u,f,d.index),a._emit("add",f.concat()),_&&h&&a.layout("instant"===h,typeof h===st?h:i),f},n.prototype.remove=function(t,e){var n,r,o,s=this,a=e||{},l=a.layout?a.layout:a.layout===i,d=!1;if(s._isDestroyed)return[];for(n=s.getItems(t),o=0;o<n.length;o++)(r=n[o])._isActive&&(d=!0),r._destroy(a.removeElements);return s._emit("remove",n.concat()),d&&l&&s.layout("instant"===l,typeof l===st?l:i),n},n.prototype.show=function(t,e){return this._isDestroyed?this:T(this,"show",t,e)},n.prototype.hide=function(t,e){return this._isDestroyed?this:T(this,"hide",t,e)},n.prototype.filter=function(t,e){var n,r,o,s=this,a=s._items,l=typeof t,d=l===at,h=l===st,f=e||{},u=!0===f.instant,_=f.layout?f.layout:f.layout===i,c=typeof f.onFinish===st?f.onFinish:null,p=[],g=[],m=-1;if(s._isDestroyed||!a.length)return s;if(n=c?function(){++m&&c(p.concat(),g.concat())}:mt,h||d)for(o=0;o<a.length;o++)r=a[o],(h?t(r):vt(r._element,t))?p.push(r):g.push(r);return p.length?s.show(p,{instant:u,onFinish:n,layout:!1}):n(),g.length?s.hide(g,{instant:u,onFinish:n,layout:!1}):n(),(p.length||g.length)&&(s._emit("filter",p.concat(),g.concat()),_&&s.layout("instant"===_,typeof _===st?_:i)),s},n.prototype.sort=function(t,e){var n,r,o=this,s=o._items,a=e||{},l=!!a.descending,d=a.layout?a.layout:a.layout===i;if(o._isDestroyed||s.length<2)return o;if(n=s.concat(),typeof t===st)s.sort(function(e,i){var o=t(e,i);return(l&&0!==o?-o:o)||P(e,i,l,r||(r=M(n)))});else if(typeof t===at)t=t.trim().split(" ").map(function(t){return t.split(":")}),s.sort(function(e,i){return X(e,i,l,t)||P(e,i,l,r||(r=M(n)))});else{if(!$.isArray(t))return o;Y(s,t),l&&s.reverse()}return o._emit("sort",s.concat(),n),d&&o.layout("instant"===d,typeof d===st?d:i),o},n.prototype.move=function(t,e,n){var r,o,s,a,l=this,d=l._items,h=n||{},_=h.layout?h.layout:h.layout===i,c="swap"===h.action,p=c?"swap":"move";return l._isDestroyed||d.length<2?l:(r=l._getItem(t),o=l._getItem(e),r&&o&&r!==o&&(s=d.indexOf(r),a=d.indexOf(o),(c?f:u)(d,s,a),l._emit("move",{item:r,fromIndex:s,toIndex:a,action:p}),_&&l.layout("instant"===_,typeof _===st?_:i)),l)},n.prototype.send=function(t,e,n,r){if(this._isDestroyed||e._isDestroyed||this===e)return this;var o=this,s=e,a=r||{},l=a.appendTo||ot,d=a.layoutSender?a.layoutSender:a.layoutSender===i,h=a.layoutReceiver?a.layoutReceiver:a.layoutReceiver===i;return(t=o._getItem(t))?(t._migrate.start(s,n,l),t._migrate.isActive&&t.isActive()&&(d&&o.layout("instant"===d,typeof d===st?d:i),h&&s.layout("instant"===h,typeof h===st?h:i)),o):o},n.prototype.destroy=function(t){var e,n=this,r=n._element,o=n._items.concat();if(n._isDestroyed)return n;for(n._resizeHandler&&K.removeEventListener("resize",n._resizeHandler),e=0;e<o.length;e++)o[e]._destroy(t);return n._unsetSortGroups(),I(r,n._settings.containerClass),b(r,{height:""}),n._emit("destroy"),n._emitter.destroy(),ct[n._id]=i,n._isDestroyed=!0,n},n.prototype._getItem=function(t){var e,i,n,o,s=this;if(s._isDestroyed||!t)return s._items[0]||null;if(t instanceof r)return t._gridId===s._id?t:null;if(typeof t===lt)return e=t>-1?t:s._items.length+t,s._items[e]||null;for(i=null,o=0;o<s._items.length;o++)if((n=s._items[o])._element===t){i=n;break}return i},n.prototype._emit=function(){return this._isDestroyed||this._emitter.emit.apply(this._emitter,arguments),this},n.prototype._refreshDimensions=function(){var t,e=this,i=e._element,n=i.getBoundingClientRect(),r=["left","right","top","bottom"];for(e._width=n.width,e._height=n.height,e._left=n.left,e._top=n.top,e._border={},t=0;t<r.length;t++)e._border[r[t]]=w(i,"border-"+r[t]+"-width");return e},n.prototype._setSortGroups=function(t){var e=this,i=[];return e._sortGroups=null,[].concat(t).forEach(function(t){"string"==typeof t&&i.indexOf(t)<0&&(i.push(t),gt[t]||(gt[t]=[]),gt[t].push(e._id))}),i.length&&(e._sortGroups=i),e},n.prototype._unsetSortGroups=function(){var t,e,i,n=this,r=n._sortGroups;if(r){for(e=0;e<r.length;e++)for(t=gt[r[e]],i=0;i<t.length;i++)if(t[i]===n._id){t.splice(i,1);break}n._sortGroups=null}return n},n.prototype._getSortConnections=function(t){var e,i,n,r,o=this,s=t?[o]:[],a=o._sortConnections;if(o._isDestroyed)return s;if(a&&a.length)for(r=0;r<a.length;r++)if((e=gt[a[r]])&&e.length)for(n=0;n<e.length;n++)(i=ct[e[n]])!==o&&s.indexOf(i)<0&&s.push(i);return s},r.prototype.getGrid=function(){return ct[this._gridId]},r.prototype.getElement=function(){return this._element},r.prototype.getWidth=function(){return this._width},r.prototype.getHeight=function(){return this._height},r.prototype.getMargin=function(){return{left:this._margin.left,right:this._margin.right,top:this._margin.top,bottom:this._margin.bottom}},r.prototype.getPosition=function(){return{left:this._left,top:this._top}},r.prototype.isActive=function(){return this._isActive},r.prototype.isVisible=function(){return!this._isHidden},r.prototype.isShowing=function(){return this._isShowing},r.prototype.isHiding=function(){return this._isHiding},r.prototype.isPositioning=function(){return this._isPositioning},r.prototype.isDragging=function(){return!!this._drag&&this._drag._data.isActive},r.prototype.isReleasing=function(){return this._release.isActive},r.prototype.isDestroyed=function(){return this._isDestroyed},r.prototype._refreshDimensions=function(){var t,e,i,n,r,o,s=this;if(s._isDestroyed||s._isHidden)return s;for(e=(t=s._element).getBoundingClientRect(),s._width=e.width,s._height=e.height,i=["left","right","top","bottom"],r=s._margin=s._margin||{},o=0;o<4;o++)n=w(t,"margin-"+i[o]),r[i[o]]=n>0?n:0;return s},r.prototype._refreshSortData=function(){var t,e,i=this;return i._isDestroyed||(t={},(e=i.getGrid()._settings.sortData)&&Z.keys(e).forEach(function(n){t[n]=e[n](i,i._element)}),i._sortData=t),i},r.prototype._layout=function(t,e){var i,n,r,o,s,a,l,d,h,f,u,_,c=this,p=c._element,g=c._isPositioning,m=c._migrate,y=c._release,v=y.isActive&&!1===y.isPositioningStarted;return c._isDestroyed?c:(i=c.getGrid(),n=i._settings,r=v?n.dragReleaseDuration:n.layoutDuration,o=v?n.dragReleaseEasing:n.layoutEasing,s=!t&&!c._skipNextLayoutAnimation&&r>0,c._layoutRafInspect&&(dt.remove(c._layoutRafInspect),c._layoutRafInspect=null),c._layoutRafModify&&(dt.remove(c._layoutRafModify),c._layoutRafModify=null),g&&z(c._layoutQueue,!0,c),v&&(y.isPositioningStarted=!0),typeof e===st&&c._layoutQueue.push(e),c._isPositioning=!0,a=y.isActive?y.containerDiffX:m.isActive?m.containerDiffX:0,l=y.isActive?y.containerDiffY:m.isActive?m.containerDiffY:0,d=c._left+a,h=c._top+l,_="translateX("+d+"px) translateY("+h+"px)",s?(c._layoutRafInspect=dt.inspect(function(){c._layoutRafInspect=null,f=D(p,"x")-a,u=D(p,"y")-l}),c._layoutRafModify=dt.modify(function(){c._layoutRafModify=null,c._left===f&&c._top===u?c._stopLayout()._finishLayout():(S(p,n.itemPositioningClass),c._animate.start({transform:_},{duration:r,easing:o,onFinish:function(){c._finishLayout()}}))})):c._layoutRafModify=dt.modify(function(){c._layoutRafModify=null,c._stopLayout(),c._skipNextLayoutAnimation=!1,b(p,{transform:_}),c._finishLayout()}),c)},r.prototype._finishLayout=function(){var t=this;return t._isDestroyed?t:(t._isPositioning&&(t._isPositioning=!1,I(t._element,t.getGrid()._settings.itemPositioningClass)),t._release.isActive&&t._release.stop(),t._migrate.isActive&&t._migrate.stop(),z(t._layoutQueue,!1,t),t)},r.prototype._stopLayout=function(t){var e=this;return e._isDestroyed||!e._isPositioning?e:(e._layoutRafInspect&&(dt.remove(e._layoutRafInspect),e._layoutRafInspect=null),e._layoutRafModify&&(dt.remove(e._layoutRafModify),e._layoutRafModify=null),e._animate.stop(),I(e._element,e.getGrid()._settings.itemPositioningClass),e._isPositioning=!1,t&&z(e._layoutQueue,!0,e),e)},r.prototype._show=function(t,e){var i,n,r=this,o=r._element,s=r._visibilityQueue,a=typeof e===st?e:null;return r._isDestroyed?r:r._isShowing||r._isHidden?(i=r.getGrid(),n=i._settings,r._isShowing?(a&&s.push(a),t&&i._itemShowHandler.stop(r)):(r._isHidden&&i._itemHideHandler.stop(r),z(s,!0,r),r._isActive=r._isShowing=!0,r._isHiding=r._isHidden=!1,a&&s.push(a),b(o,{display:"block"}),I(o,n.itemHiddenClass),S(o,n.itemVisibleClass)),i._itemShowHandler.start(r,t,function(){r._isShowing=!1,z(s,!1,r)}),r):(a&&a(!1,r),r)},r.prototype._hide=function(t,e){var i,n,r=this,o=r._element,s=r._visibilityQueue,a=typeof e===st?e:null;return r._isDestroyed?r:(i=r.getGrid(),n=i._settings,!r._isHiding&&r._isHidden?(a&&a(!1,r),r):(r._isHiding?(a&&s.push(a),t&&i._itemHideHandler.stop(r)):(r._isShowing&&i._itemShowHandler.stop(r),z(s,!0,r),r._isHidden=r._isHiding=!0,r._isActive=r._isShowing=!1,a&&s.push(a),S(o,n.itemHiddenClass),I(o,n.itemVisibleClass)),i._itemHideHandler.start(r,t,function(){r._isHiding=!1,r._stopLayout(!0),b(o,{display:"none"}),z(s,!1,r)}),r))},r.prototype._destroy=function(t){var e,n,r,o=this,s=o._element;return o._isDestroyed?o:(e=o.getGrid(),n=e._settings,r=e._items.indexOf(o),o._release.destroy(),o._migrate.destroy(),o._stopLayout(!0),e._itemShowHandler.stop(o),e._itemHideHandler.stop(o),o._drag&&o._drag.destroy(),o._animate.destroy(),o._animateChild.destroy(),s.removeAttribute("style"),o._child.removeAttribute("style"),z(o._visibilityQueue,!0,o),I(s,n.itemPositioningClass),I(s,n.itemDraggingClass),I(s,n.itemReleasingClass),I(s,n.itemClass),I(s,n.itemVisibleClass),I(s,n.itemHiddenClass),r>-1&&e._items.splice(r,1),t&&s.parentNode.removeChild(s),pt[o._id]=i,o._isActive=o._isPositioning=o._isHiding=o._isShowing=!1,o._isDestroyed=o._isHidden=!0,o)},o.prototype.on=function(t,e){if(this._isDestroyed)return this;var i=this._events[t]||[];return i.push(e),this._events[t]=i,this},o.prototype.once=function(t,e){var i=this;return this.on(t,function n(){i.off(t,n),e.apply(null,arguments)})},o.prototype.off=function(t,e){if(this._isDestroyed)return this;for(var i=this._events[t]||[],n=i.length;n--;)e===i[n]&&i.splice(n,1);return this},o.prototype.emit=function(t,e,i,n){if(this._isDestroyed)return this;var r,o=this._events[t]||[],s=o.length,a=arguments.length-1;if(s)for(o=o.concat(),r=0;r<s;r++)0===a?o[r]():1===a?o[r](e):2===a?o[r](e,i):o[r](e,i,n);return this},o.prototype.destroy=function(){if(this._isDestroyed)return this;var t,e=Z.keys(this._events);for(t=0;t<e.length;t++)this._events[e[t]]=null;return this._isDestroyed=!0,this},s.prototype.start=function(t,e){if(!this._isDestroyed){var i=e||{},n=typeof i.onFinish===st?i.onFinish:null;if(this._isAnimating){if(!this._shouldStop(t))return void(this._callback=n);this.stop()}this._isAnimating=!0,this._animateTo=t,this._callback=n,this._bindCallback(),this._startTransition(i)}},s.prototype.stop=function(){!this._isDestroyed&&this._isAnimating&&(this._isAnimating=!1,this._unbindCallback(),this._stopTransition(),this._callback=this._animateTo=null)},s.prototype.destroy=function(){this._isDestroyed||(this.stop(),this._item=this._element=null,this._isDestroyed=!0)},s.prototype._startTransition=function(t){var e,i=this._element,n={},r=Z.keys(this._animateTo),o="";for(e=0;e<r.length;e++)n[r[e]]=this._animateTo[r[e]],o+=r[e]+" "+(t.duration||"300")+"ms "+(t.easing||"ease"),e!==r.length-1&&(o+=",");n.transition=o,b(i,n)},s.prototype._stopTransition=function(){var t,e,i={};if(this._animateTo)for(t=Z.keys(this._animateTo),e=0;e<t.length;e++)i[t[e]]=v(this._element,t[e]);i.transition="none",b(this._element,i)},s.prototype._onFinish=function(){var t=this._callback;this._isAnimating=!1,this._callback=this._animateTo=null,this._unbindCallback(),b(this._element,{transition:"none"}),t&&t()},s.prototype._bindCallback=function(){var t=this;t._element.addEventListener(bt,t._callbackHandler=function(e){e.target===t._element&&t._onFinish()},!1)},s.prototype._unbindCallback=function(){this._callbackHandler&&(this._element.removeEventListener(bt,this._callbackHandler),this._callbackHandler=null)},s.prototype._shouldStop=function(t){var e,i=Z.keys(t);for(e=0;e<i.length;e++)if(t[i[e]]!==this._animateTo[i[e]])return!0;return!1},a.prototype.destroy=function(){var t=this;return t._isDestroyed||(t.stop(!0),t._isDestroyed=!0),t},a.prototype.getItem=function(){return pt[this._itemId]||null},a.prototype.start=function(t,e,i){var r,o,s,a,l,d,h,f,u,_,c,p,g=this;return g._isDestroyed?g:(r=g.getItem(),o=r._element,s=r.isVisible(),a=r.getGrid(),l=a._settings,d=t._settings,h=t._element,_=i||ot,f=a._items.indexOf(r),null===(u=typeof e===lt?e:t._items.indexOf(t._getItem(e)))?g:(r.isPositioning()&&r._stopLayout(!0),g.isActive&&g.stop(!0),r.isReleasing()&&r._release.stop(!0),a._itemShowHandler.stop(r),a._itemHideHandler.stop(r),r._drag&&r._drag.destroy(),r._animate.destroy(),r._animateChild.destroy(),z(r._visibilityQueue,!0,r),a._emit("beforeSend",{item:r,fromGrid:a,fromIndex:f,toGrid:t,toIndex:u}),t._emit("beforeReceive",{item:r,fromGrid:a,fromIndex:f,toGrid:t,toIndex:u}),I(o,l.itemClass),I(o,l.itemVisibleClass),I(o,l.itemHiddenClass),S(o,d.itemClass),S(o,s?d.itemVisibleClass:d.itemHiddenClass),a._items.splice(f,1),m(t._items,r,u),r._gridId=t._id,r._animate=new n.ItemAnimate(r,o,"layout"),r._animateChild=new n.ItemAnimate(r,r._child,"visibility"),c=o.parentNode,_!==c&&(_.appendChild(o),p=A(_,c,!0),b(o,{transform:"translateX("+(D(o,"x")+p.left)+"px) translateY("+(D(o,"y")+p.top)+"px)"})),b(o,{display:s?"block":"hidden"}),r._refreshDimensions()._refreshSortData(),r._child.removeAttribute("style"),s?t._itemShowHandler.start(r,!0):t._itemHideHandler.start(r,!0),r._drag=d.dragEnabled?new n.ItemDrag(r):null,p=A(_,h,!0),g.isActive=!0,g.container=_,g.containerDiffX=p.left,g.containerDiffY=p.top,a._emit("send",{item:r,fromGrid:a,fromIndex:f,toGrid:t,toIndex:u}),t._emit("receive",{item:r,fromGrid:a,fromIndex:f,toGrid:t,toIndex:u}),g))},a.prototype.stop=function(t){var e,i,n,r,o,s,a=this;return a._isDestroyed||!a.isActive?a:(e=a.getItem(),i=e._element,n=e.getGrid(),r=n._element,a.container!==r&&(o=t?D(i,"x")-a.containerDiffX:e._left,s=t?D(i,"y")-a.containerDiffY:e._top,r.appendChild(i),b(i,{transform:"translateX("+o+"px) translateY("+s+"px)"})),a.isActive=!1,a.container=null,a.containerDiffX=0,a.containerDiffY=0,a)},l.prototype.destroy=function(){var t=this;return t._isDestroyed||(t.stop(!0),t._isDestroyed=!0),t},l.prototype.getItem=function(){return pt[this._itemId]||null},l.prototype.reset=function(){var t,e=this;return e._isDestroyed||(t=e.getItem(),e.isActive=!1,e.isPositioningStarted=!1,e.containerDiffX=0,e.containerDiffY=0,I(t._element,t.getGrid()._settings.itemReleasingClass)),e},l.prototype.start=function(){var t,e,i=this;return i._isDestroyed||i.isActive?i:(t=i.getItem(),e=t.getGrid(),i.isActive=!0,S(t._element,e._settings.itemReleasingClass),e._emit("dragReleaseStart",t),t._layout(!1),i)},l.prototype.stop=function(t){var e,i,n,r,o,s,a,l,d=this;return d._isDestroyed||!d.isActive?d:(e=d.getItem(),i=e._element,n=e.getGrid(),r=n._element,o=d.containerDiffX,s=d.containerDiffY,d.reset(),i.parentNode!==r&&(a=t?D(i,"x")-o:e._left,l=t?D(i,"y")-s:e._top,r.appendChild(i),b(i,{transform:"translateX("+a+"px) translateY("+l+"px)"})),t||n._emit("dragReleaseEnd",e),d)},d.defaultStartPredicate=function(t,e,i){var n,r,o,s,a=t._element,l=t._drag._startPredicateData;if(l||(n=c(n=i||t._drag.getGrid()._settings.dragStartPredicate)?n:{},l=t._drag._startPredicateData={distance:tt.abs(n.distance)||0,delay:tt.max(n.delay,0)||0,handle:"string"==typeof n.handle&&n.handle}),e.isFinal)return r="a"===a.tagName.toLowerCase(),o=a.getAttribute("href"),s=a.getAttribute("target"),j(t),void(r&&o&&tt.abs(e.deltaX)<2&&tt.abs(e.deltaY)<2&&e.deltaTime<200&&(s&&"_self"!==s?K.open(o,s):K.location.href=o));if(!l.handleElement)if(l.handle){for(l.handleElement=e.srcEvent.target;l.handleElement&&!vt(l.handleElement,l.handle);)l.handleElement=l.handleElement!==a?l.handleElement.parentElement:null;if(!l.handleElement)return!1}else l.handleElement=a;return l.delay&&(l.event=e,l.delayTimer||(l.delayTimer=K.setTimeout(function(){l.delay=0,Q(t,l.event)&&(t._drag._resolveStartPredicate(l.event),j(t))},l.delay))),Q(t,e)},d.defaultSortPredicate=function(t){var e,i,n,r,o,s=t._drag,a=s._data,l=s.getGrid(),d=l._settings.dragSortPredicate||{},h=d.threshold||50,f=d.action||"move",u={width:t._width,height:t._height,left:a.elementClientX,top:a.elementClientY},_=F(u,l,h),c=0,p=0,g=-1;if(!_)return!1;for(_===l?(u.left=a.gridX+t._margin.left,u.top=a.gridY+t._margin.top):(c=_._left+_._border.left,p=_._top+_._border.top),o=0;o<_._items.length;o++)(n=_._items[o])._isActive&&n!==t&&(i=!0,(r=L(u,{width:n._width,height:n._height,left:n._left+n._margin.left+c,top:n._top+n._margin.top+p}))>g&&(e=o,g=r));return g<h&&t.getGrid()!==_&&(e=i?-1:0,g=1/0),g>=h&&{grid:_,index:e,action:f}},d.prototype.destroy=function(){var t=this;return t._isDestroyed||(t.stop(),t._hammer.destroy(),t.getItem()._element.removeEventListener("dragstart",B,!1),t._isDestroyed=!0),t},d.prototype.getItem=function(){return pt[this._itemId]||null},d.prototype.getGrid=function(){return ct[this._gridId]||null},d.prototype.reset=function(){var t=this,e=t._data;return e.isActive=!1,e.container=null,e.containingBlock=null,e.startEvent=null,e.currentEvent=null,e.scrollers=[],e.left=0,e.top=0,e.gridX=0,e.gridY=0,e.elementClientX=0,e.elementClientY=0,e.containerDiffX=0,e.containerDiffY=0,t},d.prototype.bindScrollListeners=function(){var t,e=this,i=e.getGrid()._element,n=e._data.container,r=E(e.getItem()._element);for(n!==i&&(r=_(r.concat(i).concat(E(i)))),t=0;t<r.length;t++)r[t].addEventListener("scroll",e._scrollListener);return e._data.scrollers=r,e},d.prototype.unbindScrollListeners=function(){var t,e=this,i=e._data,n=i.scrollers;for(t=0;t<n.length;t++)n[t].removeEventListener("scroll",e._scrollListener);return i.scrollers=[],e},d.prototype.checkOverlap=function(){var t,e,i,n,r,o=this,s=o.getItem(),a=o._sortPredicate(s,o._data.currentEvent);return c(a)&&typeof a.index===lt?(t=s.getGrid(),e=t._items.indexOf(s),i=a.grid||t,n=h(t._items,a.index),r="swap"===a.action?"swap":"move",t===i?e!==n&&(("swap"===r?f:u)(t._items,e,n),t._emit("move",{item:s,fromIndex:e,toIndex:n,action:r}),t.layout()):(t._emit("beforeSend",{item:s,fromGrid:t,fromIndex:e,toGrid:i,toIndex:n}),i._emit("beforeReceive",{item:s,fromGrid:t,fromIndex:e,toGrid:i,toIndex:n}),s._gridId=i._id,o._isMigrating=s._gridId!==o._gridId,t._items.splice(e,1),m(i._items,s,n),s._sortData=null,t._emit("send",{item:s,fromGrid:t,fromIndex:e,toGrid:i,toIndex:n}),i._emit("receive",{item:s,fromGrid:t,fromIndex:e,toGrid:i,toIndex:n}),t.layout(),i.layout()),o):o},d.prototype.finishMigration=function(){var t,e,i,r=this,o=r.getItem(),s=o._release,a=o._element,l=o.getGrid(),d=l._element,h=l._settings,f=h.dragContainer||d,u=r.getGrid()._settings,_=a.parentNode;return r._isMigrating=!1,r.destroy(),o._animate.destroy(),o._animateChild.destroy(),I(a,u.itemClass),I(a,u.itemVisibleClass),I(a,u.itemHiddenClass),S(a,h.itemClass),S(a,h.itemVisibleClass),o._animate=new n.ItemAnimate(o,a,"layout"),o._animateChild=new n.ItemAnimate(o,o._child,"visibility"),f!==_&&(f.appendChild(a),i=A(_,f,!0),t=D(a,"x")-i.left,e=D(a,"y")-i.top),o._refreshDimensions()._refreshSortData(),i=A(f,d,!0),s.containerDiffX=i.left,s.containerDiffY=i.top,o._drag=h.dragEnabled?new n.ItemDrag(o):null,f!==_&&b(a,{transform:"translateX("+t+"px) translateY("+e+"px)"}),o._child.removeAttribute("style"),l._itemShowHandler.start(o,!0),s.start(),r},d.prototype.stop=function(){var t,e,i=this,n=i._data;return n.isActive?i._isMigrating?i.finishMigration(n.currentEvent):(t=i.getItem()._element,e=i.getGrid(),i.unbindScrollListeners(),i._checkSortOverlap("cancel"),t.parentNode!==e._element&&(e._element.appendChild(t),b(t,{transform:"translateX("+n.gridX+"px) translateY("+n.gridY+"px)"})),I(t,e._settings.itemDraggingClass),i.reset(),i):i},d.prototype.onStart=function(t){var e,i,n,r,o,s,a,l,d,h,f,u,_=this,c=_.getItem();if(c._isActive)return e=c._element,i=_.getGrid(),n=i._settings,r=_._data,o=c._release,c.isPositioning()&&c._stopLayout(!0),c._migrate.isActive&&c._migrate.stop(!0),c.isReleasing()&&o.reset(),r.isActive=!0,r.startEvent=r.currentEvent=t,s=D(e,"x"),a=D(e,"y"),l=i._element,r.container=d=n.dragContainer||l,r.containingBlock=h=H(d,!0),r.left=r.gridX=s,r.top=r.gridY=a,i._emit("dragInit",c,t),d!==l&&(f=A(h,l),r.containerDiffX=f.left,r.containerDiffY=f.top,e.parentNode===d?(r.gridX=s-r.containerDiffX,r.gridY=a-r.containerDiffY):(r.left=s+r.containerDiffX,r.top=a+r.containerDiffY,d.appendChild(e),b(e,{transform:"translateX("+r.left+"px) translateY("+r.top+"px)"}))),S(e,n.itemDraggingClass),_.bindScrollListeners(),u=e.getBoundingClientRect(),r.elementClientX=u.left,r.elementClientY=u.top,i._emit("dragStart",c,t),_},d.prototype.onMove=function(t){var e,i,n,r,o,s,a,l=this,d=l.getItem();if(d._isActive)return e=d._element,i=l.getGrid(),n=i._settings,r=l._data,a=n.dragAxis,o=t.deltaX-r.currentEvent.deltaX,s=t.deltaY-r.currentEvent.deltaY,r.currentEvent=t,"y"!==a&&(r.left+=o,r.gridX+=o,r.elementClientX+=o),"x"!==a&&(r.top+=s,r.gridY+=s,r.elementClientY+=s),n.dragSort&&l._checkSortOverlap(),b(e,{transform:"translateX("+r.left+"px) translateY("+r.top+"px)"}),i._emit("dragMove",d,t),l;l.stop()},d.prototype.onScroll=function(t){var e,i=this,n=i.getItem(),r=n._element,o=i.getGrid(),s=o._settings,a=s.dragAxis,l=i._data,d=o._element,h=r.getBoundingClientRect(),f=l.elementClientX-h.left,u=l.elementClientY-h.top;return l.container!==d&&(e=A(l.containingBlock,d),l.containerDiffX=e.left,l.containerDiffY=e.top),"y"!==a&&(l.left+=f,l.gridX=l.left-l.containerDiffX),"x"!==a&&(l.top+=u,l.gridY=l.top-l.containerDiffY),s.dragSort&&i._checkSortOverlap(),b(r,{transform:"translateX("+l.left+"px) translateY("+l.top+"px)"}),o._emit("dragScroll",n,t),i},d.prototype.onEnd=function(t){var e=this,i=e.getItem(),n=i._element,r=e.getGrid(),o=r._settings,s=e._data,a=i._release;return i._isActive?(o.dragSort&&e._checkSortOverlap("finish"),e.unbindScrollListeners(),a.containerDiffX=s.containerDiffX,a.containerDiffY=s.containerDiffY,e.reset(),I(n,o.itemDraggingClass),r._emit("dragEnd",i,t),e._isMigrating?e.finishMigration():a.start(),e):e.stop()},q.getSlot=function(t,e,i,n,r,o){var s,a,l,d,h,f=[],u={left:null,top:null,width:i,height:n};for(d=0;d<e.length;d++)if(s=e[d],u.width<=s.width+.001&&u.height<=s.height+.001){u.left=s.left,u.top=s.top;break}for(null===u.left&&(u.left=r?0:t.width,u.top=r?t.height:0,o||(l=!0)),r&&u.top+u.height>t.height&&(u.left>0&&f.push({left:0,top:t.height,width:u.left,height:1/0}),u.left+u.width<t.width&&f.push({left:u.left+u.width,top:t.height,width:t.width-u.left-u.width,height:1/0}),t.height=u.top+u.height),!r&&u.left+u.width>t.width&&(u.top>0&&f.push({left:t.width,top:0,width:1/0,height:u.top}),u.top+u.height<t.height&&f.push({left:t.width,top:u.top+u.height,width:1/0,height:t.height-u.top-u.height}),t.width=u.left+u.width),d=o?0:l?e.length:d;d<e.length;d++)for(a=q.splitRect(e[d],u),h=0;h<a.length;h++)(s=a[h]).width>.49&&s.height>.49&&(r&&s.top<t.height||!r&&s.left<t.width)&&f.push(s);return f.length&&(f=q.purgeRects(f).sort(r?q.sortRectsTopLeft:q.sortRectsLeftTop)),[u,f]},q.splitRect=function(t,e){var i=[];return q.doRectsOverlap(t,e)?(t.left<e.left&&i.push({left:t.left,top:t.top,width:e.left-t.left,height:t.height}),t.left+t.width>e.left+e.width&&i.push({left:e.left+e.width,top:t.top,width:t.left+t.width-(e.left+e.width),height:t.height}),t.top<e.top&&i.push({left:t.left,top:t.top,width:t.width,height:e.top-t.top}),t.top+t.height>e.top+e.height&&i.push({left:t.left,top:e.top+e.height,width:t.width,height:t.top+t.height-(e.top+e.height)}),i):[{left:t.left,top:t.top,width:t.width,height:t.height}]},q.doRectsOverlap=function(t,e){return!(t.left+t.width<=e.left||e.left+e.width<=t.left||t.top+t.height<=e.top||e.top+e.height<=t.top)},q.isRectWithinRect=function(t,e){return t.left>=e.left&&t.top>=e.top&&t.left+t.width<=e.left+e.width&&t.top+t.height<=e.top+e.height},q.purgeRects=function(t){for(var e,i,n,r=t.length;r--;)for(i=t[r],e=t.length;e--;)if(n=t[e],r!==e&&q.isRectWithinRect(i,n)){t.splice(r,1);break}return t},q.sortRectsTopLeft=function(t,e){return t.top-e.top||t.left-e.left},q.sortRectsLeftTop=function(t,e){return t.left-e.left||t.top-e.top},n});




/**
 * Galleria v1.5.7 2017-05-10
 * http://galleria.io
 *
 * Copyright (c) 2010 - 2016 worse is better UG
 * Licensed under the MIT license
 * https://raw.github.com/worseisbetter/galleria/master/LICENSE
 *
 */

if( typeof(Galleria) != 'function' ) {

(function(e,m,f,t){var n=m.document,M=e(n),y=e(m),N=Array.prototype,W=!0,R=!1,H=navigator.userAgent.toLowerCase(),X=m.location.hash.replace(/#\//,""),O="file:"==m.location.protocol?"http:":m.location.protocol,p=Math,z=function(){},ea=function(){return!1},fa=!(1279<m.screen.width&&1==m.devicePixelRatio||1E3<m.screen.width&&m.innerWidth<.9*m.screen.width),v=function(){var a=3,b=n.createElement("div"),d=b.getElementsByTagName("i");do b.innerHTML="\x3c!--[if gt IE "+ ++a+"]><i></i><![endif]--\x3e";while(d[0]);
return 4<a?a:n.documentMode||t}(),w=function(){return{html:n.documentElement,body:n.body,head:n.getElementsByTagName("head")[0],title:n.title}},Q=m.parent!==m.self,Y=function(){var a=[];e.each("data ready thumbnail loadstart loadfinish image play pause progress fullscreen_enter fullscreen_exit idle_enter idle_exit rescale lightbox_open lightbox_close lightbox_image".split(" "),function(b,d){a.push(d);/_/.test(d)&&a.push(d.replace(/_/g,""))});return a}(),Z=function(a){var b;if("object"!==typeof a)return a;
e.each(a,function(d,c){/^[a-z]+_/.test(d)&&(b="",e.each(d.split("_"),function(a,c){b+=0<a?c.substr(0,1).toUpperCase()+c.substr(1):c}),a[b]=c,delete a[d])});return a},S=function(a){return-1<e.inArray(a,Y)?f[a.toUpperCase()]:a},G={youtube:{reg:/https?:\/\/(?:[a-zA_Z]{2,3}.)?(?:youtube\.com\/watch\?)((?:[\w\d\-\_\=]+&amp;(?:amp;)?)*v(?:&lt;[A-Z]+&gt;)?=([0-9a-zA-Z\-\_]+))/i,embed:function(){return O+"//www.youtube.com/embed/"+this.id},get_thumb:function(a){return O+"//img.youtube.com/vi/"+this.id+"/default.jpg"},
get_image:function(a){return O+"//img.youtube.com/vi/"+this.id+"/hqdefault.jpg"}},vimeo:{reg:/https?:\/\/(?:www\.)?(vimeo\.com)\/(?:hd#)?([0-9]+)/i,embed:function(){return O+"//player.vimeo.com/video/"+this.id},getUrl:function(){return O+"//vimeo.com/api/v2/video/"+this.id+".json?callback=?"},get_thumb:function(a){return a[0].thumbnail_medium},get_image:function(a){return a[0].thumbnail_large}},dailymotion:{reg:/https?:\/\/(?:www\.)?(dailymotion\.com)\/video\/([^_]+)/,embed:function(){return O+"//www.dailymotion.com/embed/video/"+
this.id},getUrl:function(){return"https://api.dailymotion.com/video/"+this.id+"?fields=thumbnail_240_url,thumbnail_720_url&callback=?"},get_thumb:function(a){return a.thumbnail_240_url},get_image:function(a){return a.thumbnail_720_url}},_inst:[]},aa=function(a,b){for(var d=0;d<G._inst.length;d++)if(G._inst[d].id===b&&G._inst[d].type==a)return G._inst[d];this.type=a;this.id=b;this.readys=[];G._inst.push(this);var c=this;e.extend(this,G[a]);_videoThumbs=function(a){c.data=a;e.each(c.readys,function(a,
b){b(c.data)});c.readys=[]};this.hasOwnProperty("getUrl")?e.getJSON(this.getUrl(),_videoThumbs):m.setTimeout(_videoThumbs,400);this.getMedia=function(a,b,c){c=c||z;var d=this,e=function(c){b(d["get_"+a](c))};try{d.data?e(d.data):d.readys.push(e)}catch(r){c()}}},ba=function(a){var b,d;for(d in G)if((b=a&&G[d].reg&&a.match(G[d].reg))&&b.length)return{id:b[2],provider:d};return!1},A={support:function(){var a=w().html;return!Q&&(a.requestFullscreen||a.msRequestFullscreen||a.mozRequestFullScreen||a.webkitRequestFullScreen)}(),
callback:z,enter:function(a,b,d){this.instance=a;this.callback=b||z;d=d||w().html;d.requestFullscreen?d.requestFullscreen():d.msRequestFullscreen?d.msRequestFullscreen():d.mozRequestFullScreen?d.mozRequestFullScreen():d.webkitRequestFullScreen&&d.webkitRequestFullScreen()},exit:function(a){this.callback=a||z;n.exitFullscreen?n.exitFullscreen():n.msExitFullscreen?n.msExitFullscreen():n.mozCancelFullScreen?n.mozCancelFullScreen():n.webkitCancelFullScreen&&n.webkitCancelFullScreen()},instance:null,listen:function(){if(this.support){var a=
function(){if(A.instance){var a=A.instance._fullscreen;n.fullscreen||n.mozFullScreen||n.webkitIsFullScreen||n.msFullscreenElement&&null!==n.msFullscreenElement?a._enter(A.callback):a._exit(A.callback)}};n.addEventListener("fullscreenchange",a,!1);n.addEventListener("MSFullscreenChange",a,!1);n.addEventListener("mozfullscreenchange",a,!1);n.addEventListener("webkitfullscreenchange",a,!1)}}},T=[],K=[],ca=!1,B=!1,da=[],L=[],U=function(a){L.push(a);e.each(da,function(b,d){if(d._options.theme==a.name||
!d._initialized&&!d._options.theme)d.theme=a,d._init.call(d)})},h=function(){return{clearTimer:function(a){e.each(f.get(),function(){this.clearTimer(a)})},addTimer:function(a){e.each(f.get(),function(){this.addTimer(a)})},array:function(a){return N.slice.call(a,0)},create:function(a,b){var d=n.createElement(b||"div");d.className=a;return d},removeFromArray:function(a,b){e.each(a,function(d,c){if(c==b)return a.splice(d,1),!1});return a},getScriptPath:function(a){a=a||e("script:last").attr("src");a=
a.split("/");if(1==a.length)return"";a.pop();return a.join("/")+"/"},animate:function(){var a=function(a){var b=["transition","WebkitTransition","MozTransition","OTransition"],c;if(m.opera)return!1;for(c=0;b[c];c++)if("undefined"!==typeof a[b[c]])return b[c];return!1}((n.body||n.documentElement).style),b={MozTransition:"transitionend",OTransition:"oTransitionEnd",WebkitTransition:"webkitTransitionEnd",transition:"transitionend"}[a],d={_default:[.25,.1,.25,1],galleria:[.645,.045,.355,1],galleriaIn:[.55,
.085,.68,.53],galleriaOut:[.25,.46,.45,.94],ease:[.25,0,.25,1],linear:[.25,.25,.75,.75],"ease-in":[.42,0,1,1],"ease-out":[0,0,.58,1],"ease-in-out":[.42,0,.58,1]},c=function(a,b,c){var d={};c=c||"transition";e.each(["webkit","moz","ms","o"],function(){d["-"+this+"-"+c]=b});a.css(d)},g=function(a){c(a,"none","transition");f.WEBKIT&&f.TOUCH&&(c(a,"translate3d(0,0,0)","transform"),a.data("revert")&&(a.css(a.data("revert")),a.data("revert",null)))},k,q,l,P,r,E,I;return function(C,F,x){x=e.extend({duration:400,
complete:z,stop:!1},x);C=e(C);x.duration?a?(x.stop&&(C.off(b),g(C)),k=!1,e.each(F,function(a,b){I=C.css(a);h.parseValue(I)!=h.parseValue(b)&&(k=!0);C.css(a,I)}),k?(q=[],l=x.easing in d?d[x.easing]:d._default,P=" "+x.duration+"ms cubic-bezier("+l.join(",")+")",m.setTimeout(function(a,b,d,k){return function(){a.one(b,function(a){return function(){g(a);x.complete.call(a[0])}}(a));f.WEBKIT&&f.TOUCH&&(r={},E=[0,0,0],e.each(["left","top"],function(b,c){c in d&&(E[b]=h.parseValue(d[c])-h.parseValue(a.css(c))+
"px",r[c]=d[c],delete d[c])}),E[0]||E[1])&&(a.data("revert",r),q.push("-webkit-transform"+k),c(a,"translate3d("+E.join(",")+")","transform"));e.each(d,function(a,b){q.push(a+k)});c(a,q.join(","));a.css(d)}}(C,b,F,P),2)):m.setTimeout(function(){x.complete.call(C[0])},x.duration)):C.animate(F,x):(C.css(F),x.complete.call(C[0]))}}(),removeAlpha:function(a){a instanceof jQuery&&(a=a[0]);if(9>v&&a){var b=a.style;a=(a=a.currentStyle)&&a.filter||b.filter||"";/alpha/.test(a)&&(b.filter=a.replace(/alpha\([^)]*\)/i,
""))}},forceStyles:function(a,b){a=e(a);a.attr("style")&&a.data("styles",a.attr("style")).removeAttr("style");a.css(b)},revertStyles:function(){e.each(h.array(arguments),function(a,b){b=e(b);b.removeAttr("style");b.attr("style","");b.data("styles")&&b.attr("style",b.data("styles")).data("styles",null)})},moveOut:function(a){h.forceStyles(a,{position:"absolute",left:-1E4})},moveIn:function(){h.revertStyles.apply(h,h.array(arguments))},hide:function(a,b,d){d=d||z;var c=e(a);a=c[0];c.data("opacity")||
c.data("opacity",c.css("opacity"));var g={opacity:0};b?h.animate(a,g,{duration:b,complete:9>v&&a?function(){h.removeAlpha(a);a.style.visibility="hidden";d.call(a)}:d,stop:!0}):9>v&&a?(h.removeAlpha(a),a.style.visibility="hidden"):c.css(g)},show:function(a,b,d){d=d||z;var c=e(a);a=c[0];var g={opacity:parseFloat(c.data("opacity"))||1};b?(9>v&&(c.css("opacity",0),a.style.visibility="visible"),h.animate(a,g,{duration:b,complete:9>v&&a?function(){1==g.opacity&&h.removeAlpha(a);d.call(a)}:d,stop:!0})):
9>v&&1==g.opacity&&a?(h.removeAlpha(a),a.style.visibility="visible"):c.css(g)},wait:function(a){f._waiters=f._waiters||[];a=e.extend({until:ea,success:z,error:function(){f.raise("Could not complete wait function.")},timeout:3E3},a);var b=h.timestamp(),d,c,g,k=function(){c=h.timestamp();d=c-b;h.removeFromArray(f._waiters,g);if(a.until(d))return a.success(),!1;if("number"==typeof a.timeout&&c>=b+a.timeout)return a.error(),!1;f._waiters.push(g=m.setTimeout(k,10))};f._waiters.push(g=m.setTimeout(k,10))},
toggleQuality:function(a,b){7!==v&&8!==v||!a||"IMG"!=a.nodeName.toUpperCase()||("undefined"===typeof b&&(b="nearest-neighbor"===a.style.msInterpolationMode),a.style.msInterpolationMode=b?"bicubic":"nearest-neighbor")},insertStyleTag:function(a,b){if(!b||!e("#"+b).length){var d=n.createElement("style");b&&(d.id=b);w().head.appendChild(d);if(d.styleSheet)d.styleSheet.cssText=a;else{var c=n.createTextNode(a);d.appendChild(c)}}},loadScript:function(a,b){var d=!1,c=e("<script>").attr({src:a,async:!0}).get(0);
c.onload=c.onreadystatechange=function(){d||this.readyState&&"loaded"!==this.readyState&&"complete"!==this.readyState||(d=!0,c.onload=c.onreadystatechange=null,"function"===typeof b&&b.call(this,this))};w().head.appendChild(c)},parseValue:function(a){return"number"===typeof a?a:"string"===typeof a?(a=a.match(/\-?\d|\./g))&&a.constructor===Array?1*a.join(""):0:0},timestamp:function(){return(new Date).getTime()},loadCSS:function(a,b,d){e("link[rel=stylesheet]").each(function(){if((new RegExp(a)).test(this.href))return g=
this,!1});"function"===typeof b&&(d=b,b=t);d=d||z;if(g)return d.call(g,g),g;var c=n.styleSheets.length;if(e("#"+b).length)e("#"+b).attr("href",a),c--;else{var g=e("<link>").attr({rel:"stylesheet",href:a,id:b}).get(0);b=e('link[rel="stylesheet"], style');b.length?b.get(0).parentNode.insertBefore(g,b[0]):w().head.appendChild(g);if(v&&31<=c){f.raise("You have reached the browser stylesheet limit (31)",!0);return}}if("function"===typeof d){var k=e("<s>").attr("id","galleria-loader").hide().appendTo(w().body);
h.wait({until:function(){return 0<k.height()},success:function(){k.remove();d.call(g,g)},error:function(){k.remove();f.raise("Theme CSS could not load after 20 sec. "+(f.QUIRK?"Your browser is in Quirks Mode, please add a correct doctype.":"Please download the latest theme at http://galleria.io/customer/."),!0)},timeout:5E3})}return g}}}(),V=function(a){h.insertStyleTag(".galleria-videoicon{width:60px;height:60px;position:absolute;top:50%;left:50%;z-index:1;margin:-30px 0 0 -30px;cursor:pointer;background:#000;background:rgba(0,0,0,.8);border-radius:3px;-webkit-transition:all 150ms}.galleria-videoicon i{width:0px;height:0px;border-style:solid;border-width:10px 0 10px 16px;display:block;border-color:transparent transparent transparent #ffffff;margin:20px 0 0 22px}.galleria-image:hover .galleria-videoicon{background:#000}",
"galleria-videoicon");return e(h.create("galleria-videoicon")).html("<i></i>").appendTo(a).click(function(){e(this).siblings("img").mouseup()})},J=function(){var a=function(a,d,c,g){var b=this.getOptions("easing"),f=this.getStageWidth(),l={left:f*(a.rewind?-1:1)},m={left:0};c?(l.opacity=0,m.opacity=1):l.opacity=1;e(a.next).css(l);h.animate(a.next,m,{duration:a.speed,complete:function(a){return function(){d();a.css({left:0})}}(e(a.next).add(a.prev)),queue:!1,easing:b});g&&(a.rewind=!a.rewind);a.prev&&
(l={left:0},m={left:f*(a.rewind?1:-1)},c&&(l.opacity=1,m.opacity=0),e(a.prev).css(l),h.animate(a.prev,m,{duration:a.speed,queue:!1,easing:b,complete:function(){e(this).css("opacity",0)}}))};return{active:!1,init:function(a,d,c){J.effects.hasOwnProperty(a)&&J.effects[a].call(this,d,c)},effects:{fade:function(a,d){e(a.next).css({opacity:0,left:0});h.animate(a.next,{opacity:1},{duration:a.speed,complete:d});a.prev&&(e(a.prev).css("opacity",1).show(),h.animate(a.prev,{opacity:0},{duration:a.speed}))},
flash:function(a,d){e(a.next).css({opacity:0,left:0});a.prev?h.animate(a.prev,{opacity:0},{duration:a.speed/2,complete:function(){h.animate(a.next,{opacity:1},{duration:a.speed,complete:d})}}):h.animate(a.next,{opacity:1},{duration:a.speed,complete:d})},pulse:function(a,d){a.prev&&e(a.prev).hide();e(a.next).css({opacity:0,left:0}).show();h.animate(a.next,{opacity:1},{duration:a.speed,complete:d})},slide:function(b,d){a.apply(this,h.array(arguments))},fadeslide:function(b,d){a.apply(this,h.array(arguments).concat([!0]))},
doorslide:function(b,d){a.apply(this,h.array(arguments).concat([!1,!0]))}}}}();A.listen();e.event.special["click:fast"]={propagate:!0,add:function(a){var b=function(a){if(a.touches&&a.touches.length)return a=a.touches[0],{x:a.pageX,y:a.pageY}},d={touched:!1,touchdown:!1,coords:{x:0,y:0},evObj:{}};e(this).data({clickstate:d,timer:0}).on("touchstart.fast",function(a){m.clearTimeout(e(this).data("timer"));e(this).data("clickstate",{touched:!0,touchdown:!0,coords:b(a.originalEvent),evObj:a})}).on("touchmove.fast",
function(a){a=b(a.originalEvent);var c=e(this).data("clickstate");6<Math.max(Math.abs(c.coords.x-a.x),Math.abs(c.coords.y-a.y))&&e(this).data("clickstate",e.extend(c,{touchdown:!1}))}).on("touchend.fast",function(b){var c=e(this);c.data("clickstate").touchdown&&a.handler.call(this,b);c.data("timer",m.setTimeout(function(){c.data("clickstate",d)},400))}).on("click.fast",function(b){if(e(this).data("clickstate").touched)return!1;e(this).data("clickstate",d);a.handler.call(this,b)})},remove:function(){e(this).off("touchstart.fast touchmove.fast touchend.fast click.fast")}};
y.on("orientationchange",function(){e(this).resize()});f=function(){var a=this;this._options={};this._playing=!1;this._playtime=5E3;this._active=null;this._queue={length:0};this._data=[];this._dom={};this._thumbnails=[];this._layers=[];this._firstrun=this._initialized=!1;this._stageHeight=this._stageWidth=0;this._target=t;this._binds=[];this._id=parseInt(1E4*p.random(),10);e.each("container stage images image-nav image-nav-left image-nav-right info info-text info-title info-description thumbnails thumbnails-list thumbnails-container thumb-nav-left thumb-nav-right loader counter tooltip".split(" "),
function(b,c){a._dom[c]=h.create("galleria-"+c)});e.each(["current","total"],function(b,c){a._dom[c]=h.create("galleria-"+c,"span")});var b=this._keyboard={keys:{UP:38,DOWN:40,LEFT:37,RIGHT:39,RETURN:13,ESCAPE:27,BACKSPACE:8,SPACE:32},map:{},bound:!1,press:function(c){var d=c.keyCode||c.which;d in b.map&&"function"===typeof b.map[d]&&b.map[d].call(a,c)},attach:function(a){var c;for(c in a)if(a.hasOwnProperty(c)){var d=c.toUpperCase();d in b.keys?b.map[b.keys[d]]=a[c]:b.map[d]=a[c]}b.bound||(b.bound=
!0,M.on("keydown",b.press))},detach:function(){b.bound=!1;b.map={};M.off("keydown",b.press)}},d=this._controls={0:t,1:t,active:0,swap:function(){d.active=d.active?0:1},getActive:function(){return a._options.swipe?d.slides[a._active]:d[d.active]},getNext:function(){return a._options.swipe?d.slides[a.getNext(a._active)]:d[1-d.active]},slides:[],frames:[],layers:[]},c=this._carousel={next:a.$("thumb-nav-right"),prev:a.$("thumb-nav-left"),width:0,current:0,max:0,hooks:[],update:function(){var b=0,d=0,
g=[0];e.each(a._thumbnails,function(a,c){if(c.ready){b+=c.outerWidth||e(c.container).outerWidth(!0);var r=e(c.container).width();b+=r-p.floor(r);g[a+1]=b;d=p.max(d,c.outerHeight||e(c.container).outerHeight(!0))}});a.$("thumbnails").css({width:b,height:d});c.max=b;c.hooks=g;c.width=a.$("thumbnails-list").width();c.setClasses();a.$("thumbnails-container").toggleClass("galleria-carousel",b>c.width);c.width=a.$("thumbnails-list").width()},bindControls:function(){var b;c.next.on("click:fast",function(d){d.preventDefault();
if("auto"===a._options.carouselSteps)for(b=c.current;b<c.hooks.length;b++){if(c.hooks[b]-c.hooks[c.current]>c.width){c.set(b-2);break}}else c.set(c.current+a._options.carouselSteps)});c.prev.on("click:fast",function(d){d.preventDefault();if("auto"===a._options.carouselSteps)for(b=c.current;0<=b;b--)if(c.hooks[c.current]-c.hooks[b]>c.width){c.set(b+2);break}else{if(0===b){c.set(0);break}}else c.set(c.current-a._options.carouselSteps)})},set:function(a){for(a=p.max(a,0);c.hooks[a-1]+c.width>=c.max&&
0<=a;)a--;c.current=a;c.animate()},getLast:function(a){return(a||c.current)-1},follow:function(a){if(0===a||a===c.hooks.length-2)c.set(a);else{for(var b=c.current;c.hooks[b]-c.hooks[c.current]<c.width&&b<=c.hooks.length;)b++;a-1<c.current?c.set(a-1):a+2>b&&c.set(a-b+c.current+2)}},setClasses:function(){c.prev.toggleClass("disabled",!c.current);c.next.toggleClass("disabled",c.hooks[c.current]+c.width>=c.max)},animate:function(b){c.setClasses();b=-1*c.hooks[c.current];isNaN(b)||(a.$("thumbnails").css("left",
function(){return e(this).css("left")}),h.animate(a.get("thumbnails"),{left:b},{duration:a._options.carouselSpeed,easing:a._options.easing,queue:!1}))}},g=this._tooltip={initialized:!1,open:!1,timer:"tooltip"+a._id,swapTimer:"swap"+a._id,init:function(){g.initialized=!0;h.insertStyleTag(".galleria-tooltip{padding:3px 8px;max-width:50%;background:#ffe;color:#000;z-index:3;position:absolute;font-size:11px;line-height:1.3;opacity:0;box-shadow:0 0 2px rgba(0,0,0,.4);-moz-box-shadow:0 0 2px rgba(0,0,0,.4);-webkit-box-shadow:0 0 2px rgba(0,0,0,.4);}",
"galleria-tooltip");a.$("tooltip").css({opacity:.8,visibility:"visible",display:"none"})},move:function(b){var c=a.getMousePosition(b).x;b=a.getMousePosition(b).y;var d=a.$("tooltip"),e=b,g=d.outerHeight(!0)+1,k=d.outerWidth(!0),r=g+15;k=a.$("container").width()-k-2;var l=a.$("container").height()-g-2;isNaN(c)||isNaN(e)||(e-=g+8,c=p.max(0,p.min(k,c+10)),e=p.max(0,p.min(l,e)),b<r&&(e=r),d.css({left:c,top:e}))},bind:function(b,c){if(!f.TOUCH){g.initialized||g.init();var d=function(){a.$("container").off("mousemove",
g.move);a.clearTimer(g.timer);a.$("tooltip").stop().animate({opacity:0},200,function(){a.$("tooltip").hide();a.addTimer(g.swapTimer,function(){g.open=!1},1E3)})},k=function(b,c){g.define(b,c);e(b).hover(function(){a.clearTimer(g.swapTimer);a.$("container").off("mousemove",g.move).on("mousemove",g.move).trigger("mousemove");g.show(b);a.addTimer(g.timer,function(){a.$("tooltip").stop().show().animate({opacity:1});g.open=!0},g.open?0:500)},d).click(d)};"string"===typeof c?k(b in a._dom?a.get(b):b,c):
e.each(b,function(b,c){k(a.get(b),c)})}},show:function(b){b=e(b in a._dom?a.get(b):b);var c=b.data("tt"),d=function(a){m.setTimeout(function(a){return function(){g.move(a)}}(a),10);b.off("mouseup",d)};if(c="function"===typeof c?c():c)a.$("tooltip").html(c.replace(/\s/,"&#160;")),b.on("mouseup",d)},define:function(b,c){if("function"!==typeof c){var d=c;c=function(){return d}}b=e(b in a._dom?a.get(b):b).data("tt",c);g.show(b)}},k=this._fullscreen={scrolled:0,crop:t,active:!1,prev:e(),beforeEnter:function(a){a()},
beforeExit:function(a){a()},keymap:a._keyboard.map,parseCallback:function(b,c){return J.active?function(){"function"==typeof b&&b.call(a);var d=a._controls.getActive(),g=a._controls.getNext();a._scaleImage(g);a._scaleImage(d);c&&a._options.trueFullscreen&&e(d.container).add(g.container).trigger("transitionend")}:b},enter:function(b){k.beforeEnter(function(){b=k.parseCallback(b,!0);a._options.trueFullscreen&&A.support?(k.active=!0,h.forceStyles(a.get("container"),{width:"100%",height:"100%"}),a.rescale(),
f.MAC?f.SAFARI&&/version\/[1-5]/.test(H)?(a.$("stage").css("opacity",0),m.setTimeout(function(){k.scale();a.$("stage").css("opacity",1)},4)):(a.$("container").css("opacity",0).addClass("fullscreen"),m.setTimeout(function(){k.scale();a.$("container").css("opacity",1)},50)):a.$("container").addClass("fullscreen"),y.resize(k.scale),A.enter(a,b,a.get("container"))):(k.scrolled=y.scrollTop(),f.TOUCH||m.scrollTo(0,0),k._enter(b))})},_enter:function(b){k.active=!0;Q&&(k.iframe=function(){var a,b=n.referrer,
c=n.createElement("a"),d=m.location;c.href=b;if(c.protocol!=d.protocol||c.hostname!=d.hostname||c.port!=d.port)return f.raise("Parent fullscreen not available. Iframe protocol, domains and ports must match."),!1;k.pd=m.parent.document;e(k.pd).find("iframe").each(function(){if((this.contentDocument||this.contentWindow.document)===n)return a=this,!1});return a}());h.hide(a.getActiveImage());Q&&k.iframe&&(k.iframe.scrolled=e(m.parent).scrollTop(),m.parent.scrollTo(0,0));var c=a.getData(),d=a._options,
g=!a._options.trueFullscreen||!A.support,l={height:"100%",overflow:"hidden",margin:0,padding:0};g&&(a.$("container").addClass("fullscreen"),k.prev=a.$("container").prev(),k.prev.length||(k.parent=a.$("container").parent()),a.$("container").appendTo("body"),h.forceStyles(a.get("container"),{position:f.TOUCH?"absolute":"fixed",top:0,left:0,width:"100%",height:"100%",zIndex:1E4}),h.forceStyles(w().html,l),h.forceStyles(w().body,l));Q&&k.iframe&&(h.forceStyles(k.pd.documentElement,l),h.forceStyles(k.pd.body,
l),h.forceStyles(k.iframe,e.extend(l,{width:"100%",height:"100%",top:0,left:0,position:"fixed",zIndex:1E4,border:"none"})));k.keymap=e.extend({},a._keyboard.map);a.attachKeyboard({escape:a.exitFullscreen,right:a.next,left:a.prev});k.crop=d.imageCrop;d.fullscreenCrop!=t&&(d.imageCrop=d.fullscreenCrop);if(c&&c.big&&c.image!==c.big){d=new f.Picture;var r=d.isCached(c.big),q=a.getIndex(),u=a._thumbnails[q];a.trigger({type:f.LOADSTART,cached:r,rewind:!1,index:q,imageTarget:a.getActiveImage(),thumbTarget:u,
galleriaData:c});d.load(c.big,function(b){a._scaleImage(b,{complete:function(b){a.trigger({type:f.LOADFINISH,cached:r,index:q,rewind:!1,imageTarget:b.image,thumbTarget:u});var c=a._controls.getActive().image;c&&e(c).width(b.image.width).height(b.image.height).attr("style",e(b.image).attr("style")).attr("src",b.image.src)}})});d=a.getNext(q);c=new f.Picture;d=a.getData(d);c.preload(a.isFullscreen()&&d.big?d.big:d.image)}a.rescale(function(){a.addTimer(!1,function(){g&&h.show(a.getActiveImage());"function"===
typeof b&&b.call(a);a.rescale()},100);a.trigger(f.FULLSCREEN_ENTER)});g?y.resize(k.scale):h.show(a.getActiveImage())},scale:function(){a.rescale()},exit:function(b){k.beforeExit(function(){b=k.parseCallback(b);a._options.trueFullscreen&&A.support?A.exit(b):k._exit(b)})},_exit:function(b){k.active=!1;var c=!a._options.trueFullscreen||!A.support,d=a.$("container").removeClass("fullscreen");k.parent?k.parent.prepend(d):d.insertAfter(k.prev);c&&(h.hide(a.getActiveImage()),h.revertStyles(a.get("container"),
w().html,w().body),f.TOUCH||m.scrollTo(0,k.scrolled),(d=a._controls.frames[a._controls.active])&&d.image&&(d.image.src=d.image.src));Q&&k.iframe&&(h.revertStyles(k.pd.documentElement,k.pd.body,k.iframe),k.iframe.scrolled&&m.parent.scrollTo(0,k.iframe.scrolled));a.detachKeyboard();a.attachKeyboard(k.keymap);a._options.imageCrop=k.crop;d=a.getData().big;var e=a._controls.getActive().image;!a.getData().iframe&&e&&d&&d==e.src&&m.setTimeout(function(a){return function(){e.src=a}}(a.getData().image),1);
a.rescale(function(){a.addTimer(!1,function(){c&&h.show(a.getActiveImage());"function"===typeof b&&b.call(a);y.trigger("resize")},50);a.trigger(f.FULLSCREEN_EXIT)});y.off("resize",k.scale)}},q=this._idle={trunk:[],bound:!1,active:!1,add:function(a,b,c,d){if(a&&!f.TOUCH){q.bound||q.addEvent();a=e(a);"boolean"==typeof c&&(d=c,c={});c=c||{};var g={},k;for(k in b)b.hasOwnProperty(k)&&(g[k]=a.css(k));a.data("idle",{from:e.extend(g,c),to:b,complete:!0,busy:!1});d?a.css(b):q.addTimer();q.trunk.push(a)}},
remove:function(b){b=e(b);e.each(q.trunk,function(a,c){c&&c.length&&!c.not(b).length&&(b.css(b.data("idle").from),q.trunk.splice(a,1))});q.trunk.length||(q.removeEvent(),a.clearTimer(q.timer))},addEvent:function(){q.bound=!0;a.$("container").on("mousemove click",q.showAll);if("hover"==a._options.idleMode)a.$("container").on("mouseleave",q.hide)},removeEvent:function(){q.bound=!1;a.$("container").on("mousemove click",q.showAll);"hover"==a._options.idleMode&&a.$("container").off("mouseleave",q.hide)},
addTimer:function(){"hover"!=a._options.idleMode&&a.addTimer("idle",function(){q.hide()},a._options.idleTime)},hide:function(){if(a._options.idleMode&&!1!==a.getIndex()){a.trigger(f.IDLE_ENTER);var b=q.trunk.length;e.each(q.trunk,function(c,d){var e=d.data("idle");e&&(d.data("idle").complete=!1,h.animate(d,e.to,{duration:a._options.idleSpeed,complete:function(){c==b-1&&(q.active=!1)}}))})}},showAll:function(){a.clearTimer("idle");e.each(q.trunk,function(a,b){q.show(b)})},show:function(b){var c=b.data("idle");
q.active&&(c.busy||c.complete)||(c.busy=!0,a.trigger(f.IDLE_EXIT),a.clearTimer("idle"),h.animate(b,c.from,{duration:a._options.idleSpeed/2,complete:function(){q.active=!0;e(b).data("idle").busy=!1;e(b).data("idle").complete=!0}}));q.addTimer()}},l=this._lightbox={width:0,height:0,initialized:!1,active:null,image:null,elems:{},keymap:!1,init:function(){if(!l.initialized){l.initialized=!0;var b={},c=a._options,d="";c={overlay:"position:fixed;display:none;opacity:"+c.overlayOpacity+";filter:alpha(opacity="+
100*c.overlayOpacity+");top:0;left:0;width:100%;height:100%;background:"+c.overlayBackground+";z-index:99990",box:"position:fixed;display:none;width:400px;height:400px;top:50%;left:50%;margin-top:-200px;margin-left:-200px;z-index:99991",shadow:"position:absolute;background:#000;width:100%;height:100%;",content:"position:absolute;background-color:#fff;top:10px;left:10px;right:10px;bottom:10px;overflow:hidden",info:"position:absolute;bottom:10px;left:10px;right:10px;color:#444;font:11px/13px arial,sans-serif;height:13px",
close:"position:absolute;top:10px;right:10px;height:20px;width:20px;background:#fff;text-align:center;cursor:pointer;color:#444;font:16px/22px arial,sans-serif;z-index:99999",image:"position:absolute;top:10px;left:10px;right:10px;bottom:30px;overflow:hidden;display:block;",prevholder:"position:absolute;width:50%;top:0;bottom:40px;cursor:pointer;",nextholder:"position:absolute;width:50%;top:0;bottom:40px;right:-1px;cursor:pointer;",prev:"position:absolute;top:50%;margin-top:-20px;height:40px;width:30px;background:#fff;left:20px;display:none;text-align:center;color:#000;font:bold 16px/36px arial,sans-serif",
next:"position:absolute;top:50%;margin-top:-20px;height:40px;width:30px;background:#fff;right:20px;left:auto;display:none;font:bold 16px/36px arial,sans-serif;text-align:center;color:#000",title:"float:left",counter:"float:right;margin-left:8px;"};var g={},k="";k=7<v?9>v?"background:#000;filter:alpha(opacity=0);":"background:rgba(0,0,0,0);":"z-index:99999";c.nextholder+=k;c.prevholder+=k;e.each(c,function(a,b){d+=".galleria-lightbox-"+a+"{"+b+"}"});d+=".galleria-lightbox-box.iframe .galleria-lightbox-prevholder,.galleria-lightbox-box.iframe .galleria-lightbox-nextholder{width:100px;height:100px;top:50%;margin-top:-70px}";
h.insertStyleTag(d,"galleria-lightbox");e.each("overlay box content shadow title info close prevholder prev nextholder next counter image".split(" "),function(c,d){a.addElement("lightbox-"+d);b[d]=l.elems[d]=a.get("lightbox-"+d)});l.image=new f.Picture;e.each({box:"shadow content close prevholder nextholder",info:"title counter",content:"info image",prevholder:"prev",nextholder:"next"},function(a,b){var c=[];e.each(b.split(" "),function(a,b){c.push("lightbox-"+b)});g["lightbox-"+a]=c});a.append(g);
e(b.image).append(l.image.container);e(w().body).append(b.overlay,b.box);(function(a){return a.hover(function(){e(this).css("color","#bbb")},function(){e(this).css("color","#444")})})(e(b.close).on("click:fast",l.hide).html("&#215;"));e.each(["Prev","Next"],function(a,c){var d=e(b[c.toLowerCase()]).html(/v/.test(c)?"&#8249;&#160;":"&#160;&#8250;"),g=e(b[c.toLowerCase()+"holder"]);g.on("click:fast",function(){l["show"+c]()});8>v||f.TOUCH?d.show():g.hover(function(){d.show()},function(a){d.stop().fadeOut(200)})});
e(b.overlay).on("click:fast",l.hide);f.IPAD&&(a._options.lightboxTransitionSpeed=0)}},rescale:function(b){var c=p.min(y.width()-40,l.width),d=p.min(y.height()-60,l.height);d=p.min(c/l.width,d/l.height);c=p.round(l.width*d)+40;d=p.round(l.height*d)+60;c={width:c,height:d,"margin-top":-1*p.ceil(d/2),"margin-left":-1*p.ceil(c/2)};b?e(l.elems.box).css(c):e(l.elems.box).animate(c,{duration:a._options.lightboxTransitionSpeed,easing:a._options.easing,complete:function(){var b=l.image,c=a._options.lightboxFadeSpeed;
a.trigger({type:f.LIGHTBOX_IMAGE,imageTarget:b.image});e(b.container).show();e(b.image).animate({opacity:1},c);h.show(l.elems.info,c)}})},hide:function(){l.image.image=null;y.off("resize",l.rescale);e(l.elems.box).hide().find("iframe").remove();h.hide(l.elems.info);a.detachKeyboard();a.attachKeyboard(l.keymap);l.keymap=!1;h.hide(l.elems.overlay,200,function(){e(this).hide().css("opacity",a._options.overlayOpacity);a.trigger(f.LIGHTBOX_CLOSE)})},showNext:function(){l.show(a.getNext(l.active))},showPrev:function(){l.show(a.getPrev(l.active))},
show:function(b){l.active=b="number"===typeof b?b:a.getIndex()||0;l.initialized||l.init();a.trigger(f.LIGHTBOX_OPEN);l.keymap||(l.keymap=e.extend({},a._keyboard.map),a.attachKeyboard({escape:l.hide,right:l.showNext,left:l.showPrev}));y.off("resize",l.rescale);var c=a.getData(b),d=a.getDataLength(),g=a.getNext(b),k;h.hide(l.elems.info);try{for(k=a._options.preload;0<k;k--){var q=new f.Picture;var r=a.getData(g);q.preload(r.big?r.big:r.image);g=a.getNext(g)}}catch(u){}l.image.isIframe=c.iframe&&!c.image;
e(l.elems.box).toggleClass("iframe",l.image.isIframe);e(l.image.container).find(".galleria-videoicon").remove();l.image.load(c.big||c.image||c.iframe,function(g){if(g.isIframe){var k=e(m).width(),f=e(m).height();if(g.video&&a._options.maxVideoSize){var q=p.min(a._options.maxVideoSize/k,a._options.maxVideoSize/f);1>q&&(k*=q,f*=q)}l.width=k;l.height=f}else l.width=g.original.width,l.height=g.original.height;e(g.image).css({width:g.isIframe?"100%":"100.1%",height:g.isIframe?"100%":"100.1%",top:0,bottom:0,
zIndex:99998,opacity:0,visibility:"visible"}).parent().height("100%");l.elems.title.innerHTML=c.title||"";l.elems.counter.innerHTML=b+1+" / "+d;y.resize(l.rescale);l.rescale();if(c.image&&c.iframe){e(l.elems.box).addClass("iframe");if(c.video){var h=V(g.container).hide();m.setTimeout(function(){h.fadeIn(200)},200)}e(g.image).css("cursor","pointer").mouseup(function(a,b){return function(c){e(l.image.container).find(".galleria-videoicon").remove();c.preventDefault();b.isIframe=!0;b.load(a.iframe+(a.video?
"&autoplay=1":""),{width:"100%",height:8>v?e(l.image.container).height():"100%"})}}(c,g))}});e(l.elems.overlay).show().css("visibility","visible");e(l.elems.box).show()}},P=this._timer={trunk:{},add:function(a,b,c,d){a=a||(new Date).getTime();d=d||!1;this.clear(a);if(d){var e=b;b=function(){e();P.add(a,b,c)}}this.trunk[a]=m.setTimeout(b,c)},clear:function(a){var b;if(a&&a in this.trunk)m.clearTimeout(this.trunk[a]),delete this.trunk[a];else if("undefined"===typeof a)for(b in this.trunk)this.trunk.hasOwnProperty(b)&&
(a=b,m.clearTimeout(this.trunk[a]),delete this.trunk[a])}};return this};f.prototype={constructor:f,init:function(a,b){b=Z(b);this._original={target:a,options:b,data:null};this._target=this._dom.target=a.nodeName?a:e(a).get(0);this._original.html=this._target.innerHTML;K.push(this);if(this._target){this._options={autoplay:!1,carousel:!0,carouselFollow:!0,carouselSpeed:400,carouselSteps:"auto",clicknext:!1,dailymotion:{foreground:"%23EEEEEE",highlight:"%235BCEC5",background:"%23222222",logo:0,hideInfos:1},
dataConfig:function(a){return{}},dataSelector:"img",dataSort:!1,dataSource:this._target,debug:t,dummy:t,easing:"galleria",extend:function(a){},fullscreenCrop:t,fullscreenDoubleTap:!0,fullscreenTransition:t,height:0,idleMode:!0,idleTime:3E3,idleSpeed:200,imageCrop:!1,imageMargin:0,imagePan:!1,imagePanSmoothness:12,imagePosition:"50%",imageTimeout:t,initialTransition:t,keepSource:!1,layerFollow:!0,lightbox:!1,lightboxFadeSpeed:200,lightboxTransitionSpeed:200,linkSourceImages:!0,maxScaleRatio:t,maxVideoSize:t,
minScaleRatio:t,overlayOpacity:.85,overlayBackground:"#0b0b0b",pauseOnInteraction:!0,popupLinks:!1,preload:2,queue:!0,responsive:!0,show:0,showInfo:!0,showCounter:!0,showImagenav:!0,swipe:"auto",theme:null,thumbCrop:!0,thumbEventType:"click:fast",thumbMargin:0,thumbQuality:"auto",thumbDisplayOrder:!0,thumbPosition:"50%",thumbnails:!0,touchTransition:t,transition:"fade",transitionInitial:t,transitionSpeed:400,trueFullscreen:!0,useCanvas:!1,variation:"",videoPoster:!0,vimeo:{title:0,byline:0,portrait:0,
color:"aaaaaa"},wait:5E3,width:"auto",youtube:{modestbranding:1,autohide:1,color:"white",hd:1,rel:0,showinfo:0}};this._options.initialTransition=this._options.initialTransition||this._options.transitionInitial;b&&(!1===b.debug&&(W=!1),"string"===typeof b.dummy&&(R=b.dummy),"string"==typeof b.theme&&(this._options.theme=b.theme));e(this._target).children().hide();f.QUIRK&&f.raise("Your page is in Quirks mode, Galleria may not render correctly. Please validate your HTML and add a correct doctype.");
if(L.length)if(this._options.theme)for(var d=0;d<L.length;d++){if(this._options.theme===L[d].name){this.theme=L[d];break}}else this.theme=L[0];"object"==typeof this.theme?this._init():da.push(this);return this}f.raise("Target not found",!0)},_init:function(){var a=this,b=this._options;if(this._initialized)return f.raise("Init failed: Gallery instance already initialized."),this;this._initialized=!0;if(!this.theme)return f.raise("Init failed: No theme found.",!0),this;e.extend(!0,b,this.theme.defaults,
this._original.options,f.configure.options);b.swipe=function(a){return"enforced"==a?!0:!1===a||"disabled"==a?!1:!!f.TOUCH}(b.swipe);b.swipe&&(b.clicknext=!1,b.imagePan=!1);(function(a){"getContext"in a&&(B=B||{elem:a,context:a.getContext("2d"),cache:{},length:0})})(n.createElement("canvas"));this.bind(f.DATA,function(){m.screen&&m.screen.width&&Array.prototype.forEach&&this._data.forEach(function(a){var b="devicePixelRatio"in m?m.devicePixelRatio:1;1024>p.max(m.screen.width,m.screen.height)*b&&(a.big=
a.image)});this._original.data=this._data;this.get("total").innerHTML=this.getDataLength();var b=this.$("container");2>a._options.height&&(a._userRatio=a._ratio=a._options.height);var c={width:0,height:0},d=function(){return a.$("stage").height()};h.wait({until:function(){c=a._getWH();b.width(c.width).height(c.height);return d()&&c.width&&50<c.height},success:function(){a._width=c.width;a._height=c.height;a._ratio=a._ratio||c.height/c.width;f.WEBKIT?m.setTimeout(function(){a._run()},1):a._run()},
error:function(){d()?f.raise("Could not extract sufficient width/height of the gallery container. Traced measures: width:"+c.width+"px, height: "+c.height+"px.",!0):f.raise("Could not extract a stage height from the CSS. Traced height: "+d()+"px.",!0)},timeout:"number"==typeof this._options.wait?this._options.wait:!1})});this.append({"info-text":["info-title","info-description"],info:["info-text"],"image-nav":["image-nav-right","image-nav-left"],stage:["images","loader","counter","image-nav"],"thumbnails-list":["thumbnails"],
"thumbnails-container":["thumb-nav-left","thumbnails-list","thumb-nav-right"],container:["stage","thumbnails-container","info","tooltip"]});h.hide(this.$("counter").append(this.get("current"),n.createTextNode(" / "),this.get("total")));this.setCounter("&#8211;");h.hide(a.get("tooltip"));this.$("container").addClass([f.TOUCH?"touch":"notouch",this._options.variation,"galleria-theme-"+this.theme.name].join(" "));this._options.swipe||e.each(Array(2),function(b){var c=new f.Picture;e(c.container).css({position:"absolute",
top:0,left:0}).prepend(a._layers[b]=e(h.create("galleria-layer")).css({position:"absolute",top:0,left:0,right:0,bottom:0,zIndex:2})[0]);a.$("images").append(c.container);a._controls[b]=c;var d=new f.Picture;d.isIframe=!0;e(d.container).attr("class","galleria-frame").css({position:"absolute",top:0,left:0,zIndex:4,background:"#000",display:"none"}).appendTo(c.container);a._controls.frames[b]=d});this.$("images").css({position:"relative",top:0,left:0,width:"100%",height:"100%"});b.swipe&&(this.$("images").css({position:"absolute",
top:0,left:0,width:0,height:"100%"}),this.finger=new f.Finger(this.get("stage"),{onchange:function(b){a.pause().show(b)},oncomplete:function(b){b=p.max(0,p.min(parseInt(b,10),a.getDataLength()-1));var c=a.getData(b);e(a._thumbnails[b].container).addClass("active").siblings(".active").removeClass("active");c&&(a.$("images").find(".galleria-frame").css("opacity",0).hide().find("iframe").remove(),a._options.carousel&&a._options.carouselFollow&&a._carousel.follow(b))}}),this.bind(f.RESCALE,function(){this.finger.setup()}),
this.$("stage").on("click",function(b){var c=a.getData();if(c)if(c.iframe){a.isPlaying()&&a.pause();var d=a._controls.frames[a._active],g=a._stageWidth,f=a._stageHeight;e(d.container).find("iframe").length||(e(d.container).css({width:g,height:f,opacity:0}).show().animate({opacity:1},200),m.setTimeout(function(){d.load(c.iframe+(c.video?"&autoplay=1":""),{width:g,height:f},function(b){a.$("container").addClass("videoplay");b.scale({width:a._stageWidth,height:a._stageHeight,iframelimit:c.video?a._options.maxVideoSize:
t})})},100))}else c.link&&(a._options.popupLinks?m.open(c.link,"_blank"):m.location.href=c.link)}),this.bind(f.IMAGE,function(b){a.setCounter(b.index);a.setInfo(b.index);b=this.getNext();var c=this.getPrev(),d=[c,b];d.push(this.getNext(b),this.getPrev(c),a._controls.slides.length-1);var g=[];e.each(d,function(a,b){-1==e.inArray(b,g)&&g.push(b)});e.each(g,function(b,c){var d=a.getData(c),g=a._controls.slides[c],k=a.isFullscreen()&&d.big?d.big:d.image||d.iframe;d.iframe&&!d.image&&(g.isIframe=!0);g.ready||
a._controls.slides[c].load(k,function(b){b.isIframe||e(b.image).css("visibility","hidden");a._scaleImage(b,{complete:function(a){a.isIframe||e(a.image).css({opacity:0,visibility:"visible"}).animate({opacity:1},200)}})})})}));this.$("thumbnails, thumbnails-list").css({overflow:"hidden",position:"relative"});this.$("image-nav-right, image-nav-left").on("click:fast",function(c){b.pauseOnInteraction&&a.pause();c=/right/.test(this.className)?"next":"prev";a[c]()}).on("click",function(a){a.preventDefault();
(b.clicknext||b.swipe)&&a.stopPropagation()});e.each(["info","counter","image-nav"],function(c,d){!1===b["show"+d.substr(0,1).toUpperCase()+d.substr(1).replace(/-/,"")]&&h.moveOut(a.get(d.toLowerCase()))});this.load();b.keepSource||v||(this._target.innerHTML="");this.get("errors")&&this.appendChild("target","errors");this.appendChild("target","container");if(b.carousel){var d=0,c=b.show;this.bind(f.THUMBNAIL,function(){this.updateCarousel();++d==this.getDataLength()&&"number"==typeof c&&0<c&&this._carousel.follow(c)})}if(b.responsive)y.on("resize",
function(){a.isFullscreen()||a.resize()});if(b.fullscreenDoubleTap)this.$("stage").on("touchstart",function(){var b,c,d,e,f,m;a.$("stage").on("touchmove",function(){b=0});return function(g){/(-left|-right)/.test(g.target.className)||(m=h.timestamp(),c=(g.originalEvent.touches?g.originalEvent.touches[0]:g).pageX,d=(g.originalEvent.touches?g.originalEvent.touches[0]:g).pageY,2>g.originalEvent.touches.length&&300>m-b&&20>c-e&&20>d-f?(a.toggleFullscreen(),g.preventDefault()):(b=m,e=c,f=d))}}());e.each(f.on.binds,
function(b,c){-1==e.inArray(c.hash,a._binds)&&a.bind(c.type,c.callback)});return this},addTimer:function(){this._timer.add.apply(this._timer,h.array(arguments));return this},clearTimer:function(){this._timer.clear.apply(this._timer,h.array(arguments));return this},_getWH:function(){var a=this.$("container"),b=this.$("target"),d=this,c={},g;e.each(["width","height"],function(e,f){d._options[f]&&"number"===typeof d._options[f]?c[f]=d._options[f]:(g=[h.parseValue(a.css(f)),h.parseValue(b.css(f)),a[f](),
b[f]()],d["_"+f]||g.splice(g.length,h.parseValue(a.css("min-"+f)),h.parseValue(b.css("min-"+f))),c[f]=p.max.apply(p,g))});d._userRatio&&(c.height=c.width*d._userRatio);return c},_createThumbnails:function(a){this.get("total").innerHTML=this.getDataLength();var b=this,d=this._options,c=a?this._data.length-a.length:0,g=c,k=[],q=0,l=8>v?"http://upload.wikimedia.org/wikipedia/commons/c/c0/Blank.gif":"data:image/gif;base64,R0lGODlhAQABAPABAP///wAAACH5BAEKAAAALAAAAAABAAEAAAICRAEAOw%3D%3D",P=function(){var a=
b.$("thumbnails").find(".active");return a.length?a.find("img").attr("src"):!1}(),r="string"===typeof d.thumbnails?d.thumbnails.toLowerCase():null,E=function(a){return n.defaultView&&n.defaultView.getComputedStyle?n.defaultView.getComputedStyle(u.container,null)[a]:w.css(a)},I=function(a,c,d){return function(){e(d).append(a);b.trigger({type:f.THUMBNAIL,thumbTarget:a,index:c,galleriaData:b.getData(c)})}},p=function(a){d.pauseOnInteraction&&b.pause();var c=e(a.currentTarget).data("index");b.getIndex()!==
c&&b.show(c);a.preventDefault()},t=function(a,c){e(a.container).css("visibility","visible");b.trigger({type:f.THUMBNAIL,thumbTarget:a.image,index:a.data.order,galleriaData:b.getData(a.data.order)});"function"==typeof c&&c.call(b,a)},x=function(a,c){a.scale({width:a.data.width,height:a.data.height,crop:d.thumbCrop,margin:d.thumbMargin,canvas:d.useCanvas,position:d.thumbPosition,complete:function(a){var g=["left","top"],f,l;b.getData(a.index);e.each(["Width","Height"],function(b,c){f=c.toLowerCase();
if(!0!==d.thumbCrop||d.thumbCrop===f)l={},l[f]=a[f],e(a.container).css(l),l={},l[g[b]]=0,e(a.image).css(l);a["outer"+c]=e(a.container)["outer"+c](!0)});h.toggleQuality(a.image,!0===d.thumbQuality||"auto"===d.thumbQuality&&a.original.width<3*a.width);d.thumbDisplayOrder&&!a.lazy?e.each(k,function(a,b){a===q&&b.ready&&!b.displayed&&(q++,b.displayed=!0,t(b,c))}):t(a,c)}})};a||(this._thumbnails=[],this.$("thumbnails").empty());for(;this._data[c];c++){var D=this._data[c];a=D.thumb||D.image;if(!0!==d.thumbnails&&
"lazy"!=r||!D.thumb&&!D.image)if(D.iframe&&null!==r||"empty"===r||"numbers"===r){var u={container:h.create("galleria-image"),image:h.create("img","span"),ready:!0,data:{order:c}};"numbers"===r&&e(u.image).text(c+1);D.iframe&&e(u.image).addClass("iframe");this.$("thumbnails").append(u.container);m.setTimeout(I(u.image,c,u.container),50+20*c)}else u={container:null,image:null};else{u=new f.Picture(c);u.index=c;u.displayed=!1;u.lazy=!1;u.video=!1;this.$("thumbnails").append(u.container);var w=e(u.container);
w.css("visibility","hidden");u.data={width:h.parseValue(E("width")),height:h.parseValue(E("height")),order:c,src:a};!0!==d.thumbCrop?w.css({width:"auto",height:"auto"}):w.css({width:u.data.width,height:u.data.height});"lazy"==r?(w.addClass("lazy"),u.lazy=!0,u.load(l,{height:u.data.height,width:u.data.width})):u.load(a,x);"all"===d.preload&&u.preload(D.image)}e(u.container).add(d.keepSource&&d.linkSourceImages?D.original:null).data("index",c).on(d.thumbEventType,p).data("thumbload",x);P===a&&e(u.container).addClass("active");
this._thumbnails.push(u)}k=this._thumbnails.slice(g);return this},lazyLoad:function(a,b){var d=a.constructor==Array?a:[a],c=this,g=0;e.each(d,function(a,f){if(!(f>c._thumbnails.length-1)){var l=c._thumbnails[f],k=l.data,h=function(){++g==d.length&&"function"==typeof b&&b.call(c)},q=e(l.container).data("thumbload");q&&(l.video?q.call(c,l,h):l.load(k.src,function(a){q.call(c,a,h)}))}});return this},lazyLoadChunks:function(a,b){var d=this.getDataLength(),c=0,e=0,f=[],h=[],l=this;for(b=b||0;c<d;c++)if(h.push(c),
++e==a||c==d-1)f.push(h),e=0,h=[];var p=function(a){var c=f.shift();c&&m.setTimeout(function(){l.lazyLoad(c,function(){p(!0)})},b&&a?b:0)};p(!1);return this},_run:function(){var a=this;a._createThumbnails();h.wait({timeout:1E4,until:function(){f.OPERA&&a.$("stage").css("display","inline-block");a._stageWidth=a.$("stage").width();a._stageHeight=a.$("stage").height();return a._stageWidth&&50<a._stageHeight},success:function(){T.push(a);if(a._options.swipe){var b=a.$("images").width(a.getDataLength()*
a._stageWidth);e.each(Array(a.getDataLength()),function(d){var c=new f.Picture,g=a.getData(d);e(c.container).css({position:"absolute",top:0,left:a._stageWidth*d}).prepend(a._layers[d]=e(h.create("galleria-layer")).css({position:"absolute",top:0,left:0,right:0,bottom:0,zIndex:2})[0]).appendTo(b);g.video&&V(c.container);a._controls.slides.push(c);d=new f.Picture;d.isIframe=!0;e(d.container).attr("class","galleria-frame").css({position:"absolute",top:0,left:0,zIndex:4,background:"#000",display:"none"}).appendTo(c.container);
a._controls.frames.push(d)});a.finger.setup()}h.show(a.get("counter"));a._options.carousel&&a._carousel.bindControls();a._options.autoplay&&(a.pause(),"number"===typeof a._options.autoplay&&(a._playtime=a._options.autoplay),a._playing=!0);a._firstrun?(a._options.autoplay&&a.trigger(f.PLAY),"number"===typeof a._options.show&&a.show(a._options.show)):(a._firstrun=!0,f.History&&f.History.change(function(b){isNaN(b)?m.history.go(-1):a.show(b,t,!0)}),a.trigger(f.READY),a.theme.init.call(a,a._options),
e.each(f.ready.callbacks,function(b,c){"function"==typeof c&&c.call(a,a._options)}),a._options.extend.call(a,a._options),/^[0-9]{1,4}$/.test(X)&&f.History?a.show(X,t,!0):a._data[a._options.show]&&a.show(a._options.show),a._options.autoplay&&a.trigger(f.PLAY))},error:function(){f.raise("Stage width or height is too small to show the gallery. Traced measures: width:"+a._stageWidth+"px, height: "+a._stageHeight+"px.",!0)}})},load:function(a,b,d){var c=this,g=this._options;this._data=[];this._thumbnails=
[];this.$("thumbnails").empty();"function"===typeof b&&(d=b,b=null);a=a||g.dataSource;b=b||g.dataSelector;d=d||g.dataConfig;e.isPlainObject(a)&&(a=[a]);e.isArray(a)?this.validate(a)?this._data=a:f.raise("Load failed: JSON Array not valid."):(b+=",.video,.iframe",e(a).find(b).each(function(a,b){b=e(b);var g={},f=b.parent(),k=f.attr("href");f=f.attr("rel");k&&("IMG"==b[0].nodeName||b.hasClass("video"))&&ba(k)?g.video=k:k&&b.hasClass("iframe")?g.iframe=k:g.image=g.big=k;f&&(g.big=f);e.each("big title description link layer image".split(" "),
function(a,c){b.data(c)&&(g[c]=b.data(c).toString())});g.big||(g.big=g.image);c._data.push(e.extend({title:b.attr("title")||"",thumb:b.attr("src"),image:b.attr("src"),big:b.attr("src"),description:b.attr("alt")||"",link:b.attr("longdesc"),original:b.get(0)},g,d(b)))}));"function"==typeof g.dataSort?N.sort.call(this._data,g.dataSort):"random"==g.dataSort&&this._data.sort(function(){return p.round(p.random())-.5});this.getDataLength()&&this._parseData(function(){this.trigger(f.DATA)});return this},
_parseData:function(a){var b=this,d,c=!1,g=function(){var d=!0;e.each(b._data,function(a,b){if(b.loading)return d=!1});d&&!c&&(c=!0,a.call(b))};e.each(this._data,function(a,c){d=b._data[a];!1==="thumb"in c&&(d.thumb=c.image);c.big||(d.big=c.image);if("video"in c){var f=ba(c.video);f&&(d.iframe=(new aa(f.provider,f.id)).embed()+function(){if("object"==typeof b._options[f.provider]){var a=[];e.each(b._options[f.provider],function(b,c){a.push(b+"="+c)});"youtube"==f.provider&&(a=["wmode=opaque"].concat(a));
return"?"+a.join("&")}return""}(),d.thumb&&d.image||e.each(["thumb","image"],function(a,c){if("image"!=c||b._options.videoPoster){var e=new aa(f.provider,f.id);d[c]||(d.loading=!0,e.getMedia(c,function(a,b){return function(c){a[b]=c;"image"!=b||a.big||(a.big=a.image);delete a.loading;g()}}(d,c)))}else d.image=t}))}});g();return this},destroy:function(){this.$("target").data("galleria",null);this.$("container").off("galleria");this.get("target").innerHTML=this._original.html;this.clearTimer();h.removeFromArray(K,
this);h.removeFromArray(T,this);void 0!==f._waiters&&f._waiters.length&&e.each(f._waiters,function(a,b){b&&m.clearTimeout(b)});return this},splice:function(){var a=this,b=h.array(arguments);m.setTimeout(function(){N.splice.apply(a._data,b);a._parseData(function(){a._createThumbnails()})},2);return a},push:function(){var a=this,b=h.array(arguments);1==b.length&&b[0].constructor==Array&&(b=b[0]);m.setTimeout(function(){N.push.apply(a._data,b);a._parseData(function(){a._createThumbnails(b)})},2);return a},
_getActive:function(){return this._controls.getActive()},validate:function(a){return!0},bind:function(a,b){a=S(a);this.$("container").on(a,this.proxy(b));return this},unbind:function(a){a=S(a);this.$("container").off(a);return this},trigger:function(a){a="object"===typeof a?e.extend(a,{scope:this}):{type:S(a),scope:this};this.$("container").trigger(a);return this},addIdleState:function(a,b,d,c){this._idle.add.apply(this._idle,h.array(arguments));return this},removeIdleState:function(a){this._idle.remove.apply(this._idle,
h.array(arguments));return this},enterIdleMode:function(){this._idle.hide();return this},exitIdleMode:function(){this._idle.showAll();return this},enterFullscreen:function(a){this._fullscreen.enter.apply(this,h.array(arguments));return this},exitFullscreen:function(a){this._fullscreen.exit.apply(this,h.array(arguments));return this},toggleFullscreen:function(a){this._fullscreen[this.isFullscreen()?"exit":"enter"].apply(this,h.array(arguments));return this},bindTooltip:function(a,b){this._tooltip.bind.apply(this._tooltip,
h.array(arguments));return this},defineTooltip:function(a,b){this._tooltip.define.apply(this._tooltip,h.array(arguments));return this},refreshTooltip:function(a){this._tooltip.show.apply(this._tooltip,h.array(arguments));return this},openLightbox:function(){this._lightbox.show.apply(this._lightbox,h.array(arguments));return this},closeLightbox:function(){this._lightbox.hide.apply(this._lightbox,h.array(arguments));return this},hasVariation:function(a){return-1<e.inArray(a,this._options.variation.split(/\s+/))},
getActiveImage:function(){var a=this._getActive();return a?a.image:t},getActiveThumb:function(){return this._thumbnails[this._active].image||t},getMousePosition:function(a){return{x:a.pageX-this.$("container").offset().left,y:a.pageY-this.$("container").offset().top}},addPan:function(a){if(!1!==this._options.imageCrop){a=e(a||this.getActiveImage());var b=this,d=a.width()/2,c=a.height()/2,g=parseInt(a.css("left"),10),f=parseInt(a.css("top"),10),m=g||0,l=f||0,n=0,r=0,E=!1,I=h.timestamp(),t=0,F=0,x=
function(b,c,d){if(0<b&&(F=p.round(p.max(-1*b,p.min(0,c))),t!==F))if(t=F,8===v)a.parent()["scroll"+d](-1*F);else b={},b[d.toLowerCase()]=F,a.css(b)},D=function(a){50>h.timestamp()-I||(E=!0,d=b.getMousePosition(a).x,c=b.getMousePosition(a).y)};8===v&&(a.parent().scrollTop(-1*l).scrollLeft(-1*m),a.css({top:0,left:0}));this.$("stage").off("mousemove",D).on("mousemove",D);this.addTimer("pan"+b._id,function(e){E&&(n=a.width()-b._stageWidth,r=a.height()-b._stageHeight,g=d/b._stageWidth*n*-1,f=c/b._stageHeight*
r*-1,m+=(g-m)/b._options.imagePanSmoothness,l+=(f-l)/b._options.imagePanSmoothness,x(r,l,"Top"),x(n,m,"Left"))},50,!0);return this}},proxy:function(a,b){if("function"!==typeof a)return z;b=b||this;return function(){return a.apply(b,h.array(arguments))}},getThemeName:function(){return this.theme.name},removePan:function(){this.$("stage").off("mousemove");this.clearTimer("pan"+this._id);return this},addElement:function(a){var b=this._dom;e.each(h.array(arguments),function(a,c){b[c]=h.create("galleria-"+
c)});return this},attachKeyboard:function(a){this._keyboard.attach.apply(this._keyboard,h.array(arguments));return this},detachKeyboard:function(){this._keyboard.detach.apply(this._keyboard,h.array(arguments));return this},appendChild:function(a,b){this.$(a).append(this.get(b)||b);return this},prependChild:function(a,b){this.$(a).prepend(this.get(b)||b);return this},remove:function(a){this.$(h.array(arguments).join(",")).remove();return this},append:function(a){var b,d;for(b in a)if(a.hasOwnProperty(b))if(a[b].constructor===
Array)for(d=0;a[b][d];d++)this.appendChild(b,a[b][d]);else this.appendChild(b,a[b]);return this},_scaleImage:function(a,b){if(a=a||this._controls.getActive()){var d=function(a){e(a.container).children(":first").css({top:p.max(0,h.parseValue(a.image.style.top)),left:p.max(0,h.parseValue(a.image.style.left)),width:h.parseValue(a.image.width),height:h.parseValue(a.image.height)})};b=e.extend({width:this._stageWidth,height:this._stageHeight,crop:this._options.imageCrop,max:this._options.maxScaleRatio,
min:this._options.minScaleRatio,margin:this._options.imageMargin,position:this._options.imagePosition,iframelimit:this._options.maxVideoSize},b);if(this._options.layerFollow&&!0!==this._options.imageCrop)if("function"==typeof b.complete){var c=b.complete;b.complete=function(){c.call(a,a);d(a)}}else b.complete=d;else e(a.container).children(":first").css({top:0,left:0});a.scale(b);return this}},updateCarousel:function(){this._carousel.update();return this},resize:function(a,b){"function"==typeof a&&
(b=a,a=t);a=e.extend({width:0,height:0},a);var d=this,c=this.$("container");e.each(a,function(b,e){e||(c[b]("auto"),a[b]=d._getWH()[b])});e.each(a,function(a,b){c[a](b)});return this.rescale(b)},rescale:function(a,b,d){var c=this;"function"===typeof a&&(d=a,a=t);(function(){c._stageWidth=a||c.$("stage").width();c._stageHeight=b||c.$("stage").height();c._options.swipe?(e.each(c._controls.slides,function(a,b){c._scaleImage(b);e(b.container).css("left",c._stageWidth*a)}),c.$("images").css("width",c._stageWidth*
c.getDataLength())):c._scaleImage();c._options.carousel&&c.updateCarousel();c._controls.frames[c._controls.active]&&c._controls.frames[c._controls.active].scale({width:c._stageWidth,height:c._stageHeight,iframelimit:c._options.maxVideoSize});c.trigger(f.RESCALE);"function"===typeof d&&d.call(c)}).call(c);return this},refreshImage:function(){this._scaleImage();this._options.imagePan&&this.addPan();return this},_preload:function(){if(this._options.preload){var a,b=this.getNext();try{for(a=this._options.preload;0<
a;a--){var d=new f.Picture;var c=this.getData(b);d.preload(this.isFullscreen()&&c.big?c.big:c.image);b=this.getNext(b)}}catch(g){}}},show:function(a,b,d){var c=this._options.swipe;if(c||!(3<this._queue.length||!1===a||!this._options.queue&&this._queue.stalled))if(a=p.max(0,p.min(parseInt(a,10),this.getDataLength()-1)),b="undefined"!==typeof b?!!b:a<this.getIndex(),!d&&f.History)f.History.set(a.toString());else{this.finger&&a!==this._active&&(this.finger.to=-(a*this.finger.width),this.finger.index=
a);this._active=a;if(c){var g=this.getData(a),k=this;if(!g)return;var h=this.isFullscreen()&&g.big?g.big:g.image||g.iframe,l=this._controls.slides[a],n={cached:l.isCached(h),index:a,rewind:b,imageTarget:l.image,thumbTarget:this._thumbnails[a].image,galleriaData:g};this.trigger(e.extend(n,{type:f.LOADSTART}));k.$("container").removeClass("videoplay");var r=function(){k._layers[a].innerHTML=k.getData().layer||"";k.trigger(e.extend(n,{type:f.LOADFINISH}));k._playCheck()};k._preload();m.setTimeout(function(){l.ready&&
e(l.image).attr("src")==h?(k.trigger(e.extend(n,{type:f.IMAGE})),r()):(g.iframe&&!g.image&&(l.isIframe=!0),l.load(h,function(a){n.imageTarget=a.image;k._scaleImage(a,r).trigger(e.extend(n,{type:f.IMAGE}));r()}))},100)}else N.push.call(this._queue,{index:a,rewind:b}),this._queue.stalled||this._show();return this}},_show:function(){var a=this,b=this._queue[0],d=this.getData(b.index);if(d){var c=this.isFullscreen()&&d.big?d.big:d.image||d.iframe,g=this._controls.getActive(),k=this._controls.getNext(),
q=k.isCached(c),l=this._thumbnails[b.index],p=function(){e(k.image).trigger("mouseup")};a.$("container").toggleClass("iframe",!!d.isIframe).removeClass("videoplay");var n=function(b,c,d,g,k){return function(){J.active=!1;h.toggleQuality(c.image,a._options.imageQuality);a._layers[a._controls.active].innerHTML="";e(d.container).css({zIndex:0,opacity:0}).show();e(d.container).find("iframe, .galleria-videoicon").remove();e(a._controls.frames[a._controls.active].container).hide();e(c.container).css({zIndex:1,
left:0,top:0}).show();a._controls.swap();a._options.imagePan&&a.addPan(c.image);if(b.iframe&&b.image||b.link||a._options.lightbox||a._options.clicknext)e(c.image).css({cursor:"pointer"}).on("mouseup",function(c){if(!("number"==typeof c.which&&1<c.which))if(b.iframe){a.isPlaying()&&a.pause();var d=a._controls.frames[a._controls.active],g=a._stageWidth,k=a._stageHeight;e(d.container).css({width:g,height:k,opacity:0}).show().animate({opacity:1},200);m.setTimeout(function(){d.load(b.iframe+(b.video?"&autoplay=1":
""),{width:g,height:k},function(c){a.$("container").addClass("videoplay");c.scale({width:a._stageWidth,height:a._stageHeight,iframelimit:b.video?a._options.maxVideoSize:t})})},100)}else a._options.clicknext&&!f.TOUCH?(a._options.pauseOnInteraction&&a.pause(),a.next()):b.link?a._options.popupLinks?m.open(b.link,"_blank"):m.location.href=b.link:a._options.lightbox&&a.openLightbox()});a._playCheck();a.trigger({type:f.IMAGE,index:g.index,imageTarget:c.image,thumbTarget:k.image,galleriaData:b});N.shift.call(a._queue);
a._queue.stalled=!1;a._queue.length&&a._show()}}(d,k,g,b,l);this._options.carousel&&this._options.carouselFollow&&this._carousel.follow(b.index);a._preload();h.show(k.container);k.isIframe=d.iframe&&!d.image;e(a._thumbnails[b.index].container).addClass("active").siblings(".active").removeClass("active");a.trigger({type:f.LOADSTART,cached:q,index:b.index,rewind:b.rewind,imageTarget:k.image,thumbTarget:l.image,galleriaData:d});a._queue.stalled=!0;k.load(c,function(c){var k=e(a._layers[1-a._controls.active]).html(d.layer||
"").hide();a._scaleImage(c,{complete:function(c){"image"in g&&h.toggleQuality(g.image,!1);h.toggleQuality(c.image,!1);a.removePan();a.setInfo(b.index);a.setCounter(b.index);d.layer&&(k.show(),(d.iframe&&d.image||d.link||a._options.lightbox||a._options.clicknext)&&k.css("cursor","pointer").off("mouseup").mouseup(p));d.video&&d.image&&V(c.container);var l=a._options.transition;e.each({initial:null===g.image,touch:f.TOUCH,fullscreen:a.isFullscreen()},function(b,c){if(c&&a._options[b+"Transition"]!==
t)return l=a._options[b+"Transition"],!1});if(!1===l in J.effects)n();else{var m={prev:g.container,next:c.container,rewind:b.rewind,speed:a._options.transitionSpeed||400};J.active=!0;J.init.call(a,l,m,n)}a.trigger({type:f.LOADFINISH,cached:q,index:b.index,rewind:b.rewind,imageTarget:c.image,thumbTarget:a._thumbnails[b.index].image,galleriaData:a.getData(b.index)})}})})}},getNext:function(a){a="number"===typeof a?a:this.getIndex();return a===this.getDataLength()-1?0:a+1},getPrev:function(a){a="number"===
typeof a?a:this.getIndex();return 0===a?this.getDataLength()-1:a-1},next:function(){1<this.getDataLength()&&this.show(this.getNext(),!1);return this},prev:function(){1<this.getDataLength()&&this.show(this.getPrev(),!0);return this},get:function(a){return a in this._dom?this._dom[a]:null},getData:function(a){return a in this._data?this._data[a]:this._data[this._active]},getDataLength:function(){return this._data.length},getIndex:function(){return"number"===typeof this._active?this._active:!1},getStageHeight:function(){return this._stageHeight},
getStageWidth:function(){return this._stageWidth},getOptions:function(a){return"undefined"===typeof a?this._options:this._options[a]},setOptions:function(a,b){"object"===typeof a?e.extend(this._options,a):this._options[a]=b;return this},play:function(a){this._playing=!0;this._playtime=a||this._playtime;this._playCheck();this.trigger(f.PLAY);return this},pause:function(){this._playing=!1;this.trigger(f.PAUSE);return this},playToggle:function(a){return this._playing?this.pause():this.play(a)},isPlaying:function(){return this._playing},
isFullscreen:function(){return this._fullscreen.active},_playCheck:function(){var a=this,b=0,d=h.timestamp(),c="play"+this._id;if(this._playing){this.clearTimer(c);var e=function(){b=h.timestamp()-d;b>=a._playtime&&a._playing?(a.clearTimer(c),a.next()):a._playing&&(a.trigger({type:f.PROGRESS,percent:p.ceil(b/a._playtime*100),seconds:p.floor(b/1E3),milliseconds:b}),a.addTimer(c,e,20))};a.addTimer(c,e,20)}},setPlaytime:function(a){this._playtime=a;return this},setIndex:function(a){this._active=a;return this},
setCounter:function(a){"number"===typeof a?a++:"undefined"===typeof a&&(a=this.getIndex()+1);this.get("current").innerHTML=a;if(v){a=this.$("counter");var b=a.css("opacity");1===parseInt(b,10)?h.removeAlpha(a[0]):this.$("counter").css("opacity",b)}return this},setInfo:function(a){var b=this,d=this.getData(a);e.each(["title","description"],function(a,e){var c=b.$("info-"+e);d[e]?c[d[e].length?"show":"hide"]().html(d[e]):c.empty().hide()});return this},hasInfo:function(a){var b=["title","description"],
d;for(d=0;b[d];d++)if(this.getData(a)[b[d]])return!0;return!1},jQuery:function(a){var b=this,d=[];e.each(a.split(","),function(a,c){c=e.trim(c);b.get(c)&&d.push(c)});var c=e(b.get(d.shift()));e.each(d,function(a,d){c=c.add(b.get(d))});return c},$:function(a){return this.jQuery.apply(this,h.array(arguments))}};e.each(Y,function(a,b){var d=/_/.test(b)?b.replace(/_/g,""):b;f[b.toUpperCase()]="galleria."+d});e.extend(f,{IE9:9===v,IE8:8===v,IE7:7===v,IE6:6===v,IE:v,WEBKIT:/webkit/.test(H),CHROME:/chrome/.test(H),
SAFARI:/safari/.test(H)&&!/chrome/.test(H),QUIRK:v&&n.compatMode&&"BackCompat"===n.compatMode,MAC:/mac/.test(navigator.platform.toLowerCase()),OPERA:!!m.opera,IPHONE:/iphone/.test(H),IPAD:/ipad/.test(H),ANDROID:/android/.test(H),TOUCH:"ontouchstart"in n&&fa});f.addTheme=function(a){a.name||f.raise("No theme name specified");(!a.version||parseInt(10*f.version)>parseInt(10*a.version))&&f.raise("This version of Galleria requires "+a.name+" theme version "+parseInt(10*f.version)/10+" or later",!0);a.defaults=
"object"!==typeof a.defaults?{}:Z(a.defaults);var b=!1,d,c;"string"===typeof a.css?(e("link").each(function(c,e){d=new RegExp(a.css);if(d.test(e.href))return b=!0,U(a),!1}),b||e(function(){var g=0,k=function(){e("script").each(function(e,f){d=new RegExp("galleria\\."+a.name.toLowerCase()+"\\.");c=new RegExp("galleria\\.io\\/theme\\/"+a.name.toLowerCase()+"\\/(\\d*\\.*)?(\\d*\\.*)?(\\d*\\/)?js");if(d.test(f.src)||c.test(f.src))b=f.src.replace(/[^\/]*$/,"")+a.css,m.setTimeout(function(){h.loadCSS(b,
"galleria-theme-"+a.name,function(){U(a)})},1)});b||(5<g++?f.raise("No theme CSS loaded"):m.setTimeout(k,500))};k()})):U(a);return a};f.loadTheme=function(a,b){if(!e("script").filter(function(){return e(this).attr("src")==a}).length){var d=!1,c;e(m).on("load",function(){d||(c=m.setTimeout(function(){d||f.raise("Galleria had problems loading theme at "+a+". Please check theme path or load manually.",!0)},2E4))});h.loadScript(a,function(){d=!0;m.clearTimeout(c)});return f}};f.get=function(a){if(K[a])return K[a];
if("number"!==typeof a)return K;f.raise("Gallery index "+a+" not found")};f.configure=function(a,b){var d={};"string"==typeof a&&b?(d[a]=b,a=d):e.extend(d,a);f.configure.options=d;e.each(f.get(),function(a,b){b.setOptions(d)});return f};f.configure.options={};f.on=function(a,b){if(a){b=b||z;var d=a+b.toString().replace(/\s/g,"")+h.timestamp();e.each(f.get(),function(c,e){e._binds.push(d);e.bind(a,b)});f.on.binds.push({type:a,callback:b,hash:d});return f}};f.on.binds=[];f.run=function(a,b){e.isFunction(b)&&
(b={extend:b});e(a||"#galleria").galleria(b);return f};f.addTransition=function(a,b){J.effects[a]=b;return f};f.utils=h;f.log=function(){var a=h.array(arguments);if("console"in m&&"log"in m.console)try{return m.console.log.apply(m.console,a)}catch(b){e.each(a,function(){m.console.log(this)})}else return m.alert(a.join("<br>"))};f.ready=function(a){if("function"!=typeof a)return f;e.each(T,function(b,d){a.call(d,d._options)});f.ready.callbacks.push(a);return f};f.ready.callbacks=[];f.raise=function(a,
b){var d=b?"Fatal error":"Error",c={color:"#fff",position:"absolute",top:0,left:0,zIndex:1E5},f=function(a){var f='<div style="padding:4px;margin:0 0 2px;background:#'+(b?"811":"222")+';">'+(b?"<strong>"+d+": </strong>":"")+a+"</div>";e.each(K,function(){var a=this.$("errors"),b=this.$("target");a.length||(b.css("position","relative"),a=this.addElement("errors").appendChild("target","errors").$("errors").css(c));a.append(f)});K.length||e("<div>").css(e.extend(c,{position:"fixed"})).append(f).appendTo(w().body)};
if(W){if(f(a),b)throw Error(d+": "+a);}else b&&!ca&&(ca=!0,b=!1,f("Gallery could not load."))};f.version=1.57;f.getLoadedThemes=function(){return e.map(L,function(a){return a.name})};f.requires=function(a,b){f.version<a&&f.raise(b||"You need to upgrade Galleria to version "+a+" to use one or more components.",!0);return f};f.Picture=function(a){this.id=a||null;this.image=null;this.container=h.create("galleria-image");e(this.container).css({overflow:"hidden",position:"relative"});this.original={width:0,
height:0};this.isIframe=this.ready=!1};f.Picture.prototype={cache:{},show:function(){h.show(this.image)},hide:function(){h.moveOut(this.image)},clear:function(){this.image=null},isCached:function(a){return!!this.cache[a]},preload:function(a){e(new Image).on("load",function(a,d){return function(){d[a]=a}}(a,this.cache)).attr("src",a)},load:function(a,b,d){"function"==typeof b&&(d=b,b=null);if(this.isIframe){var c="if"+(new Date).getTime(),g=this.image=e("<iframe>",{src:a,frameborder:0,id:c,allowfullscreen:!0,
css:{visibility:"hidden"}})[0];b&&e(g).css(b);e(this.container).find("iframe,img").remove();this.container.appendChild(this.image);e("#"+c).on("load",function(a,b){return function(){m.setTimeout(function(){e(a.image).css("visibility","visible");"function"==typeof b&&b.call(a,a)},10)}}(this,d));return this.container}this.image=new Image;f.IE8&&e(this.image).css("filter","inherit");f.IE||f.CHROME||f.SAFARI||e(this.image).css("image-rendering","optimizequality");var k=!1,q=!1,l=e(this.container),p=e(this.image),
n=function(a,c,d){return function(){var g=function(){e(this).off("load");a.original=b||{height:this.height,width:this.width};f.HAS3D&&(this.style.MozTransform=this.style.webkitTransform="translate3d(0,0,0)");l.append(this);a.cache[d]=d;"function"==typeof c&&m.setTimeout(function(){c.call(a,a)},1)};this.width&&this.height?g.call(this):function(a){h.wait({until:function(){return a.width&&a.height},success:function(){g.call(a)},error:function(){q?f.raise("Could not extract width/height from image: "+
a.src+". Traced measures: width:"+a.width+"px, height: "+a.height+"px."):(e(new Image).on("load",n).attr("src",a.src),q=!0)},timeout:100})}(this)}}(this,d,a);l.find("iframe,img").remove();p.css("display","block");h.hide(this.image);e.each(["minWidth","minHeight","maxWidth","maxHeight"],function(a,b){p.css(b,/min/.test(b)?"0":"none")});p.on("load",n).on("error",function(){k?R?e(this).attr("src",R):f.raise("Image not found: "+a):(k=!0,m.setTimeout(function(a,b){return function(){a.attr("src",b+(-1<
b.indexOf("?")?"&":"?")+h.timestamp())}}(e(this),a),50))}).attr("src",a);return this.container},scale:function(a){var b=this;a=e.extend({width:0,height:0,min:t,max:t,margin:0,complete:z,position:"center",crop:!1,canvas:!1,iframelimit:t},a);if(this.isIframe){var d=a.width,c=a.height;if(a.iframelimit){var g=p.min(a.iframelimit/d,a.iframelimit/c);if(1>g){var k=d*g;var m=c*g;e(this.image).css({top:c/2-m/2,left:d/2-k/2,position:"absolute"})}else e(this.image).css({top:0,left:0})}e(this.image).width(k||
d).height(m||c).removeAttr("width").removeAttr("height");e(this.container).width(d).height(c);a.complete.call(b,b);try{this.image.contentWindow&&e(this.image.contentWindow).trigger("resize")}catch(I){}return this.container}if(!this.image)return this.container;var l,n,r=e(b.container),v;h.wait({until:function(){l=a.width||r.width()||h.parseValue(r.css("width"));n=a.height||r.height()||h.parseValue(r.css("height"));return l&&n},success:function(){var c=(l-2*a.margin)/b.original.width,d=(n-2*a.margin)/
b.original.height,f=p.min(c,d),g=p.max(c,d),k={"true":g,width:c,height:d,"false":f,landscape:b.original.width>b.original.height?g:f,portrait:b.original.width<b.original.height?g:f}[a.crop.toString()];c="";a.max&&(k=p.min(a.max,k));a.min&&(k=p.max(a.min,k));e.each(["width","height"],function(a,c){e(b.image)[c](b[c]=b.image[c]=p.round(b.original[c]*k))});e(b.container).width(l).height(n);a.canvas&&B&&(B.elem.width=b.width,B.elem.height=b.height,c=b.image.src+":"+b.width+"x"+b.height,b.image.src=B.cache[c]||
function(a){B.context.drawImage(b.image,0,0,b.original.width*k,b.original.height*k);try{return v=B.elem.toDataURL(),B.length+=v.length,B.cache[a]=v}catch(ha){return b.image.src}}(c));var m={},q={};c=function(a,c,d){/\%/.test(a)?(a=parseInt(a,10)/100,c=b.image[c]||e(b.image)[c](),d=p.ceil(-1*c*a+d*a)):d=h.parseValue(a);return d};var r={top:{top:0},left:{left:0},right:{left:"100%"},bottom:{top:"100%"}};e.each(a.position.toLowerCase().split(" "),function(a,b){"center"===b&&(b="50%");m[a?"top":"left"]=
b});e.each(m,function(a,b){r.hasOwnProperty(b)&&e.extend(q,r[b])});m=m.top?e.extend(m,q):q;m=e.extend({top:"50%",left:"50%"},m);e(b.image).css({position:"absolute",top:c(m.top,"height",n),left:c(m.left,"width",l)});b.show();b.ready=!0;a.complete.call(b,b)},error:function(){f.raise("Could not scale image: "+b.image.src)},timeout:1E3});return this}};e.extend(e.easing,{galleria:function(a,b,d,c,e){return 1>(b/=e/2)?c/2*b*b*b+d:c/2*((b-=2)*b*b+2)+d},galleriaIn:function(a,b,d,c,e){return c*(b/=e)*b+d},
galleriaOut:function(a,b,d,c,e){return-c*(b/=e)*(b-2)+d}});f.Finger=function(){var a=f.HAS3D=function(){var a=n.createElement("p"),b=["webkit","O","ms","Moz",""],d=0;for(w().html.insertBefore(a,null);b[d];d++){var f=b[d]?b[d]+"Transform":"transform";if(void 0!==a.style[f]){a.style[f]="translate3d(1px,1px,1px)";var l=e(a).css(b[d]?"-"+b[d].toLowerCase()+"-transform":"transform")}}w().html.removeChild(a);return void 0!==l&&0<l.length&&"none"!==l}(),b=function(){return m.requestAnimationFrame||m.webkitRequestAnimationFrame||
m.mozRequestAnimationFrame||m.oRequestAnimationFrame||m.msRequestAnimationFrame||function(a){m.setTimeout(a,1E3/60)}}(),d=function(c,d){this.config={start:0,duration:500,onchange:function(){},oncomplete:function(){},easing:function(a,b,c,d,e){return-d*((b=b/e-1)*b*b*b-1)+c}};this.easeout=function(a,b,c,d,e){return d*((b=b/e-1)*b*b*b*b+1)+c};if(c.children.length){var f=this;e.extend(this.config,d);this.elem=c;this.child=c.children[0];this.to=this.pos=0;this.touching=!1;this.start={};this.index=this.config.start;
this.anim=0;this.easing=this.config.easing;a||(this.child.style.position="absolute",this.elem.style.position="relative");e.each(["ontouchstart","ontouchmove","ontouchend","setup"],function(a,b){f[b]=function(a){return function(){a.apply(f,arguments)}}(f[b])});this.setX=function(){var b=f.child.style;a?b.MozTransform=b.webkitTransform=b.transform="translate3d("+f.pos+"px,0,0)":b.left=f.pos+"px"};e(c).on("touchstart",this.ontouchstart);e(m).on("resize",this.setup);e(m).on("orientationchange",this.setup);
this.setup();(function l(){b(l);f.loop.call(f)})()}};d.prototype={constructor:d,setup:function(){this.width=e(this.elem).width();this.length=p.ceil(e(this.child).width()/this.width);0!==this.index&&(this.index=p.max(0,p.min(this.index,this.length-1)),this.pos=this.to=-this.width*this.index)},setPosition:function(a){this.to=this.pos=a},ontouchstart:function(a){a=a.originalEvent.touches;this.start={pageX:a[0].pageX,pageY:a[0].pageY,time:+new Date};this.isScrolling=null;this.touching=!0;this.deltaX=
0;M.on("touchmove",this.ontouchmove);M.on("touchend",this.ontouchend)},ontouchmove:function(a){var b=a.originalEvent.touches;b&&1<b.length||a.scale&&1!==a.scale||(this.deltaX=b[0].pageX-this.start.pageX,null===this.isScrolling&&(this.isScrolling=!!(this.isScrolling||p.abs(this.deltaX)<p.abs(b[0].pageY-this.start.pageY))),this.isScrolling||(a.preventDefault(),this.deltaX/=!this.index&&0<this.deltaX||this.index==this.length-1&&0>this.deltaX?p.abs(this.deltaX)/this.width+1.8:1,this.to=this.deltaX-this.index*
this.width),a.stopPropagation())},ontouchend:function(a){this.touching=!1;a=250>+new Date-this.start.time&&40<p.abs(this.deltaX)||p.abs(this.deltaX)>this.width/2;var b=!this.index&&0<this.deltaX||this.index==this.length-1&&0>this.deltaX;this.isScrolling||this.show(this.index+(a&&!b?0>this.deltaX?1:-1:0));M.off("touchmove",this.ontouchmove);M.off("touchend",this.ontouchend)},show:function(a){a!=this.index?this.config.onchange.call(this,a):this.to=-(a*this.width)},moveTo:function(a){a!=this.index&&
(this.pos=this.to=-(a*this.width),this.index=a)},loop:function(){var a=this.to-this.pos,b=1;this.width&&a&&(b=p.max(.5,p.min(1.5,p.abs(a/this.width))));if(this.touching||1>=p.abs(a)){this.pos=this.to;if(this.anim&&!this.touching)this.config.oncomplete(this.index);this.anim=0;this.easing=this.config.easing}else{this.anim||(this.anim={start:this.pos,time:+new Date,distance:a,factor:b,destination:this.to});a=+new Date-this.anim.time;b=this.config.duration*this.anim.factor;if(a>b||this.anim.destination!=
this.to){this.anim=0;this.easing=this.easeout;return}this.pos=this.easing(null,a,this.anim.start,this.anim.distance,b)}this.setX()}};return d}();e.fn.galleria=function(a){var b=this.selector;return e(this).length?this.each(function(){e.data(this,"galleria")&&(e.data(this,"galleria").destroy(),e(this).find("*").hide());e.data(this,"galleria",(new f).init(this,a))}):(e(function(){e(b).length?e(b).galleria(a):f.utils.wait({until:function(){return e(b).length},success:function(){e(b).galleria(a)},error:function(){f.raise('Init failed: Galleria could not find the element "'+
b+'".')},timeout:5E3})}),this)};"object"===typeof module&&module&&"object"===typeof module.exports?module.exports=f:(m.Galleria=f,"function"===typeof define&&define.amd&&define("galleria",["jquery"],function(){return f}))})(jQuery,this);


} // end Galleria


/**
 * Galleria LCweb Theme - for mediagrid
 * (c) LCweb - Montanari Luca aka LCweb
 */
(function(b){Galleria.addTheme({name:"mediagrid",version:"1.5.7",author:"Montanari Luca",defaults:{initialTransition:"flash",thumbCrop:!0,queue:!1,showCounter:!1,pauseOnInteraction:!0,_toggleInfo:!1},init:function(f){Galleria.requires(1.28,"LCweb theme requires Galleria 1.2.8 or later");this.addElement("mg-play","mg-toggle-thumb");this.append({info:["mg-play","mg-toggle-thumb","info-text"]});var e=this.$("info-text"),c=this.$("mg-play"),d=Galleria.TOUCH;d||(this.addIdleState(this.get("image-nav-left"),
{left:-50}),this.addIdleState(this.get("image-nav-right"),{right:-50}));this.bind("thumbnail",function(a){d?b(a.thumbTarget).css("opacity",this.getIndex()?1:.6):(b(a.thumbTarget).css("opacity",.6).parent().hover(function(){b(this).not(".active").children().stop().fadeTo(100,1)},function(){b(this).not(".active").children().stop().fadeTo(400,.6)}),a.index===this.getIndex()&&b(a.thumbTarget).css("opacity",1))});this.bind("loadstart",function(a){a.cached||this.$("loader").show().fadeTo(200,1);this.$("info").parent().find(".galleria-stage .galleria-info-text").remove();
this.hasInfo()?this.$("info").removeClass("has_no_data"):this.$("info").addClass("has_no_data");b(a.thumbTarget).css("opacity",1).parent().siblings().children().css("opacity",.6)});this.bind("loadfinish",function(a){this.$("loader").fadeOut(200);!this._playing&&c.hasClass("galleria-mg-pause")&&c.removeClass("galleria-mg-pause");e.hide();this.hasInfo()&&(a=this.$("info").find(".galleria-info-text").clone(),this.$("info").parents(".galleria-container").find(".galleria-stage").append(a),this.$("info").parents(".galleria-container").find(".galleria-stage .galleria-info-text").fadeTo(1,
mg_galleria_fx_time))})}})})(jQuery);



/* AlloyFinger v0.1.7
 * By dntzhang
 * Github: https://github.com/AlloyTeam/AlloyFinger
 */
if(typeof(AlloyFinger) != 'function') {

(function(){function h(a){return Math.sqrt(a.x*a.x+a.y*a.y)}function d(a,b){var c=new f(a);c.add(b);return c}var f=function(a){this.handlers=[];this.el=a};f.prototype.add=function(a){this.handlers.push(a)};f.prototype.del=function(a){a||(this.handlers=[]);for(var b=this.handlers.length;0<=b;b--)this.handlers[b]===a&&this.handlers.splice(b,1)};f.prototype.dispatch=function(){for(var a=0,b=this.handlers.length;a<b;a++){var c=this.handlers[a];"function"===typeof c&&c.apply(this.el,arguments)}};var k=
function(a,b){this.element="string"==typeof a?document.querySelector(a):a;this.start=this.start.bind(this);this.move=this.move.bind(this);this.end=this.end.bind(this);this.cancel=this.cancel.bind(this);this.element.addEventListener("touchstart",this.start,!1);this.element.addEventListener("touchmove",this.move,!1);this.element.addEventListener("touchend",this.end,!1);this.element.addEventListener("touchcancel",this.cancel,!1);this.preV={x:null,y:null};this.pinchStartLen=null;this.zoom=1;this.isDoubleTap=
!1;var c=function(){};this.rotate=d(this.element,b.rotate||c);this.touchStart=d(this.element,b.touchStart||c);this.multipointStart=d(this.element,b.multipointStart||c);this.multipointEnd=d(this.element,b.multipointEnd||c);this.pinch=d(this.element,b.pinch||c);this.swipe=d(this.element,b.swipe||c);this.tap=d(this.element,b.tap||c);this.doubleTap=d(this.element,b.doubleTap||c);this.longTap=d(this.element,b.longTap||c);this.singleTap=d(this.element,b.singleTap||c);this.pressMove=d(this.element,b.pressMove||
c);this.touchMove=d(this.element,b.touchMove||c);this.touchEnd=d(this.element,b.touchEnd||c);this.touchCancel=d(this.element,b.touchCancel||c);this.x1=this.x2=this.y1=this.y2=this.swipeTimeout=this.longTapTimeout=this.singleTapTimeout=this.tapTimeout=this.now=this.last=this.delta=null;this.preTapPosition={x:null,y:null}};k.prototype={start:function(a){if(a.touches){this.now=Date.now();this.x1=a.touches[0].pageX;this.y1=a.touches[0].pageY;this.delta=this.now-(this.last||this.now);this.touchStart.dispatch(a);
null!==this.preTapPosition.x&&(this.isDoubleTap=0<this.delta&&250>=this.delta&&30>Math.abs(this.preTapPosition.x-this.x1)&&30>Math.abs(this.preTapPosition.y-this.y1));this.preTapPosition.x=this.x1;this.preTapPosition.y=this.y1;this.last=this.now;var b=this.preV;if(1<a.touches.length){this._cancelLongTap();this._cancelSingleTap();var c=a.touches[1].pageY-this.y1;b.x=a.touches[1].pageX-this.x1;b.y=c;this.pinchStartLen=h(b);this.multipointStart.dispatch(a)}this.longTapTimeout=setTimeout(function(){this.longTap.dispatch(a)}.bind(this),
750)}},move:function(a){if(a.touches){var b=this.preV,c=a.touches.length,d=a.touches[0].pageX,f=a.touches[0].pageY;this.isDoubleTap=!1;if(1<c){var g={x:a.touches[1].pageX-d,y:a.touches[1].pageY-f};if(null!==b.x){0<this.pinchStartLen&&(a.zoom=h(g)/this.pinchStartLen,this.pinch.dispatch(a));var e=h(g)*h(b);0===e?e=0:(e=(g.x*b.x+g.y*b.y)/e,1<e&&(e=1),e=Math.acos(e));0<g.x*b.y-b.x*g.y&&(e*=-1);a.angle=180*e/Math.PI;this.rotate.dispatch(a)}b.x=g.x;b.y=g.y}else null!==this.x2?(a.deltaX=d-this.x2,a.deltaY=
f-this.y2):(a.deltaX=0,a.deltaY=0),this.pressMove.dispatch(a);this.touchMove.dispatch(a);this._cancelLongTap();this.x2=d;this.y2=f;1<c&&a.preventDefault()}},end:function(a){if(a.changedTouches){this._cancelLongTap();var b=this;2>a.touches.length&&this.multipointEnd.dispatch(a);this.x2&&30<Math.abs(this.x1-this.x2)||this.y2&&30<Math.abs(this.y1-this.y2)?(a.direction=this._swipeDirection(this.x1,this.x2,this.y1,this.y2),this.swipeTimeout=setTimeout(function(){b.swipe.dispatch(a)},0)):(this.tapTimeout=
setTimeout(function(){b.tap.dispatch(a);b.isDoubleTap&&(b.doubleTap.dispatch(a),clearTimeout(b.singleTapTimeout),b.isDoubleTap=!1)},0),b.isDoubleTap||(b.singleTapTimeout=setTimeout(function(){b.singleTap.dispatch(a)},250)));this.touchEnd.dispatch(a);this.preV.x=0;this.preV.y=0;this.zoom=1;this.x1=this.x2=this.y1=this.y2=this.pinchStartLen=null}},cancel:function(a){clearTimeout(this.singleTapTimeout);clearTimeout(this.tapTimeout);clearTimeout(this.longTapTimeout);clearTimeout(this.swipeTimeout);this.touchCancel.dispatch(a)},
_cancelLongTap:function(){clearTimeout(this.longTapTimeout)},_cancelSingleTap:function(){clearTimeout(this.singleTapTimeout)},_swipeDirection:function(a,b,c,d){return Math.abs(a-b)>=Math.abs(c-d)?0<a-b?"Left":"Right":0<c-d?"Up":"Down"},on:function(a,b){this[a]&&this[a].add(b)},off:function(a,b){this[a]&&this[a].del(b)},destroy:function(){this.singleTapTimeout&&clearTimeout(this.singleTapTimeout);this.tapTimeout&&clearTimeout(this.tapTimeout);this.longTapTimeout&&clearTimeout(this.longTapTimeout);
this.swipeTimeout&&clearTimeout(this.swipeTimeout);this.element.removeEventListener("touchstart",this.start);this.element.removeEventListener("touchmove",this.move);this.element.removeEventListener("touchend",this.end);this.element.removeEventListener("touchcancel",this.cancel);this.rotate.del();this.touchStart.del();this.multipointStart.del();this.multipointEnd.del();this.pinch.del();this.swipe.del();this.tap.del();this.doubleTap.del();this.longTap.del();this.singleTap.del();this.pressMove.del();
this.touchMove.del();this.touchEnd.del();this.touchCancel.del();return this.preV=this.pinchStartLen=this.zoom=this.isDoubleTap=this.delta=this.last=this.now=this.tapTimeout=this.singleTapTimeout=this.longTapTimeout=this.swipeTimeout=this.x1=this.x2=this.y1=this.y2=this.preTapPosition=this.rotate=this.touchStart=this.multipointStart=this.multipointEnd=this.pinch=this.swipe=this.tap=this.doubleTap=this.longTap=this.singleTap=this.pressMove=this.touchMove=this.touchEnd=this.touchCancel=null}};"undefined"!==
typeof module&&"object"===typeof exports?module.exports=k:window.AlloyFinger=k})();

} // end touchswipe


/**
 * lc_micro_slider.js - lightweight responsive slider with jquery.touchSwipe.js (or AlloyFinger) integration
 * Version: 1.3.2
 * Author: Luca Montanari aka LCweb
 * Website: http://www.lcweb.it
 * Licensed under the MIT license
 */

if( typeof(lc_micro_slider) != 'function' ) {

(function(c){var p=function(n,g){var e=c.extend({slide_fx:"fadeslide",slide_easing:"ease",nav_arrows:!0,nav_dots:!0,slideshow_cmd:!0,carousel:!0,touchswipe:!0,autoplay:!1,animation_time:700,slideshow_time:5E3,pause_on_hover:!0,loader_code:'<span class="lcms_loader"></span>'},g),k=c(n);k.data("lcms_vars",{slides:[],shown_slide:0,cached_img:[],uniqid:"",is_sliding:!1,is_playing:!1,paused_on_hover:!1});k.data("lcms_settings",e);var q=function(b,f,d){var l=b.data("lcms_vars"),g=b.data("lcms_settings"),
m=l.slides[d],h=m.img?"lcms_preload":"";g=m.img?g.loader_code:"";switch(f){case "init":var e="lcms_active_slide";break;case "fade":e="lcms_fadein";break;case "prev":e="lcms_before";break;case "next":e="lcms_after"}b.find(".lcms_nav_dots span").removeClass("lcms_sel_dot");b.find(".lcms_nav_dots span").eq(d).addClass("lcms_sel_dot");f=m.img?'<div class="lcms_bg" style="background-image: url('+m.img+');"></div>':"";var k=c.trim(m.content)?'<div class="lcms_content">'+m.content+"</div>":"";h='<div class="lcms_slide '+
e+" "+h+'" rel="'+d+'"><div class="lcms_inner '+m.classes+'">'+f+k+"</div>"+g+"</div>";b.find(".lcms_container").append(h);m.img&&(-1===c.inArray(m.img,l.cached_img)?c("<img/>").bind("load",function(){l.cached_img.push(this.src);c(".lcms_slide[rel="+d+"]").removeClass("lcms_preload");c(".lcms_slide[rel="+d+"]").find("> *").not(".lcms_inner").fadeOut(300,function(){c(this).remove()});b.trigger("lcms_slide_shown",[d,m]);c(".lcms_slide[rel="+d+"]").hasClass("lcms_active_slide")&&b.trigger("lcms_initial_slide_shown",
[d,m])}).attr("src",m.img):(c(".lcms_slide[rel="+d+"]").removeClass("lcms_preload").addClass("lcms_cached"),c(".lcms_slide[rel="+d+"]").find("> *").not(".lcms_inner").remove(),b.trigger("lcms_slide_shown",[d,m])));1<l.slides.length&&(h=d<l.slides.length-1?d+1:0,-1===c.inArray(l.slides[h].img,l.cached_img)&&c("<img/>").bind("load",function(){l.cached_img.push(this.src)}).attr("src",l.slides[h].img));2<l.slides.length&&(h=d?d-1:l.slides.length-1,-1===c.inArray(l.slides[h].img,l.cached_img)&&c("<img/>").bind("load",
function(){l.cached_img.push(this.src)}).attr("src",l.slides[h].img))};lcms_slide=function(b,c){var d=b.data("lcms_vars"),f=b.data("lcms_settings");if("undefined"==typeof d)return!0;var g=f.animation_time,e=d.shown_slide;if(!f.carousel&&("prev"==c&&!d.shown_slide||"next"==c&&d.shown_slide==d.slides.length-1)||d.lcms_is_sliding||1==d.slides.length||"number"==typeof c&&(0>c||c>d.slides.length-1))return!1;if("prev"==c)var h=0===e?d.slides.length-1:e-1;else"next"==c?h=e==d.slides.length-1?0:e+1:(h=c,
c=h>e?"next":"prev");d.lcms_is_sliding=!0;b.addClass("lcms_is_sliding lcms_moving_"+c);b.find(".lcms_active_slide").addClass("lcms_prepare_for_"+c);q(b,"fade"==f.slide_fx?"fade":c,h);d.shown_slide=h;b.trigger("lcms_changing_slide",[h,d.slides[h],e]);f.carousel||(b.find(".lcms_prev, .lcms_next, .lcms_play > span").removeClass("lcms_disabled_btn"),h?h==d.slides.length-1&&b.find(".lcms_next, .lcms_play > span").addClass("lcms_disabled_btn"):b.find(".lcms_prev").addClass("lcms_disabled_btn"));setTimeout(function(){b.find(".lcms_active_slide").remove();
d.lcms_is_sliding=!1;b.removeClass("lcms_is_sliding lcms_moving_"+c);b.find(".lcms_slide").removeClass("lcms_fadein lcms_before lcms_after").addClass("lcms_active_slide");b.trigger("lcms_new_active_slide",[h,d.slides[h]])},g)};c(".lcms_prev").unbind("click");k.delegate(".lcms_play","click",function(){var b=c(this).parents(".lcms_wrap").parent(),f=b.data("lcms_vars");jQuery(this).hasClass("lcms_pause")?(f.paused_on_hover&&(f.paused_on_hover=!1),b.lcms_stop_slideshow()):b.lcms_start_slideshow()});c(".lcms_prev").unbind("click");
k.delegate(".lcms_prev:not(.lcms_disabled)","click",function(){var b=c(this).parents(".lcms_wrap").parent();"undefined"!=typeof lcms_one_click&&clearTimeout(lcms_one_click);lcms_one_click=setTimeout(function(){b.lcms_stop_slideshow();lcms_slide(b,"prev")},5)});c(".lcms_next").unbind("click");k.delegate(".lcms_next:not(.lcms_disabled)","click",function(){var b=c(this).parents(".lcms_wrap").parent();"undefined"!=typeof lcms_one_click&&clearTimeout(lcms_one_click);lcms_one_click=setTimeout(function(){b.lcms_stop_slideshow();
lcms_slide(b,"next")},5)});c(".lcms_next").unbind("click");k.delegate(".lcms_nav_dots span:not(.lcms_sel_dot)","click",function(){var b=c(this).parents(".lcms_wrap").parent(),f=parseInt(jQuery(this).attr("rel"));"undefined"!=typeof lcms_one_click&&clearTimeout(lcms_one_click);lcms_one_click=setTimeout(function(){b.lcms_stop_slideshow();lcms_slide(b,f)},5)});var p=function(){"function"==typeof c.fn.swipe?k.find(".lcms_wrap").swipe({swipeRight:function(){var b=jQuery(this).parent();b.lcms_stop_slideshow();
lcms_slide(b,"prev")},swipeLeft:function(){var b=jQuery(this).parent();b.lcms_stop_slideshow();lcms_slide(b,"next")},threshold:40,allowPageScroll:"vertical"}):"function"==typeof AlloyFinger&&new AlloyFinger(k.find(".lcms_wrap")[0],{swipe:function(b){var c=jQuery(this).parent();c.lcms_stop_slideshow();"Right"===b.direction?lcms_slide(c,"prev"):"Left"===b.direction&&lcms_slide(c,"next")}})};e.pause_on_hover&&k.delegate(".lcms_wrap","mouseenter",function(){var b=c(this).parent(),f=b.data("lcms_vars");
b.data("lcms_settings");f.is_playing&&(f.paused_on_hover=!0,b.lcms_stop_slideshow())}).delegate(".lcms_wrap","mouseleave",function(){var b=c(this).parent(),f=b.data("lcms_vars");b.data("lcms_settings");f.paused_on_hover&&(b.lcms_start_slideshow(),f.paused_on_hover=!1)});(function(b){var f=b.data("lcms_vars"),d=b.data("lcms_settings");b.find("li").each(function(b,d){c(this).find("noscript").remove();var e={content:c(this).html(),img:c(this).attr("lcms_img"),classes:"undefined"==typeof c(this).attr("class")?
"":c(this).attr("class")};f.slides.push(e)});f.uniqid="lcms_"+Math.floor(1E6*Math.random())+(new Date).getMilliseconds();b.html('<div class="lcms_wrap '+f.uniqid+'"><div class="lcms_container"></div></div>');f.shown_slide=0;q(b,"init",0);if(d.nav_arrows&&1<f.slides.length){var e=d.carousel?"":"lcms_disabled_btn";b.find(".lcms_wrap").addClass("lcms_has_nav_arr").prepend('<div class="lcms_nav"><span class="lcms_prev '+e+'"></span><span class="lcms_next"></span></div>')}d.slideshow_cmd&&1<f.slides.length&&
b.find(".lcms_wrap").addClass("lcms_has_ss_cmd").prepend('<div class="lcms_play"><span></span></div>');if(d.nav_dots&&1<f.slides.length){e='<div class="lcms_nav_dots">';for(a=0;a<f.slides.length;a++)e+='<span rel="'+a+'"></span>';b.find(".lcms_wrap").addClass("lcms_has_nav_dots").prepend(e+"</div>");b.find(".lcms_nav_dots span").first().addClass("lcms_sel_dot")}d.slide_fx&&"none"!=d.slide_fx&&(e=d.slide_easing&&"ease"!=d.slide_easing?"-webkit-animation-timing-function: "+d.slide_easing+" !important;animation-timing-function: "+
d.slide_easing+" !important;":"",c("head").append('<style type="text/css">.'+f.uniqid+" .lcms_before,."+f.uniqid+" .lcms_after,."+f.uniqid+" .lcms_prepare_for_prev,."+f.uniqid+" .lcms_prepare_for_next {-webkit-animation-duration: "+d.animation_time+"ms !important;animation-duration: "+d.animation_time+"ms !important;"+e+"}</style>"),b.find(".lcms_wrap").addClass("lcms_"+d.slide_fx+"_fx"));d.autoplay&&b.lcms_start_slideshow();b.trigger("lcms_ready");c(document).ready(function(b){"function"!=typeof c.fn.swipe&&
"function"!=typeof AlloyFinger||p()})})(k);return this};c.fn.lc_micro_slider=function(n){c.fn.lcms_destroy=function(){var g=c(this);g.find(".lcms_wrap").remove();var e=g.data("lcms_vars");e.is_playing&&clearInterval(e.is_playing);g.find(".lcms_next, .lcms_prev").undelegate("click");g.removeData("lcms_vars");g.removeData("lcms_settings");g.removeData("lc_micro_slider");return!0};c.fn.lcms_paginate=function(g){var e=c(this),k=e.data("lcms_vars");e.data("lcms_settings");if("undefined"==typeof k)return console.error("cannot paginate - element not initialized"),
!0;e.lcms_stop_slideshow();lcms_slide(e,g);return!0};c.fn.lcms_start_slideshow=function(){var g=c(this),e=g.data("lcms_vars"),k=g.data("lcms_settings");if("undefined"==typeof e)return console.error("cannot start slideshow - element not initialized"),!0;e.is_playing=setInterval(function(){lcms_slide(g,"next")},k.slideshow_time+k.animation_time);g.find(".lcms_play").addClass("lcms_pause");g.trigger("lcms_play_slideshow");return!0};c.fn.lcms_stop_slideshow=function(){var g=c(this),e=g.data("lcms_vars");
g.data("lcms_settings");if("undefined"==typeof e)return console.error("cannot stop slideshow - element not initialized"),!0;clearInterval(e.is_playing);e.is_playing=null;e.paused_on_hover||g.find(".lcms_play").removeClass("lcms_pause");g.trigger("lcms_stop_slideshow");return!0};return this.each(function(){if(c(this).data("lc_micro_slider"))return c(this).data("lc_micro_slider");var g=new p(this,n);c(this).data("lc_micro_slider",g)})}})(jQuery);

} // end lc-micro-slider


/**
 * objectFitPolyfill 2.0.3 - by Constance Chen
 * Released under the MIT license
 * https://github.com/constancecchen/object-fit-polyfill
 */
!function(){"use strict";if("undefined"!=typeof window){if("objectFit"in document.documentElement.style!=!1)return void(window.objectFitPolyfill=function(){return!1});var t=function(t){var e=window.getComputedStyle(t,null),i=e.getPropertyValue("position"),o=e.getPropertyValue("overflow"),n=e.getPropertyValue("display");i&&"static"!==i||(t.style.position="relative"),"hidden"!==o&&(t.style.overflow="hidden"),n&&"inline"!==n||(t.style.display="block"),0===t.clientHeight&&(t.style.height="100%"),-1===t.className.indexOf("object-fit-polyfill")&&(t.className=t.className+" object-fit-polyfill")},e=function(t){var e=window.getComputedStyle(t,null),i={"max-width":"none","max-height":"none","min-width":"0px","min-height":"0px",top:"auto",right:"auto",bottom:"auto",left:"auto","margin-top":"0px","margin-right":"0px","margin-bottom":"0px","margin-left":"0px"};for(var o in i){e.getPropertyValue(o)!==i[o]&&(t.style[o]=i[o])}},i=function(i){var o=i.parentNode;t(o),e(i),i.style.position="absolute",i.style.height="100%",i.style.width="auto",i.clientWidth>o.clientWidth?(i.style.top="0",i.style.marginTop="0",i.style.left="50%",i.style.marginLeft=i.clientWidth/-2+"px"):(i.style.width="100%",i.style.height="auto",i.style.left="0",i.style.marginLeft="0",i.style.top="50%",i.style.marginTop=i.clientHeight/-2+"px")},o=function(t){if(void 0===t)t=document.querySelectorAll("[data-object-fit]");else if(t&&t.nodeName)t=[t];else{if("object"!=typeof t||!t.length||!t[0].nodeName)return!1;t=t}for(var e=0;e<t.length;e++)if(t[e].nodeName){var o=t[e].nodeName.toLowerCase();"img"===o?t[e].complete?i(t[e]):t[e].addEventListener("load",function(){i(this)}):"video"===o&&(t[e].readyState>0?i(t[e]):t[e].addEventListener("loadedmetadata",function(){i(this)}))}return!0};document.addEventListener("DOMContentLoaded",function(){o()}),window.addEventListener("resize",function(){o()}),window.objectFitPolyfill=o}}();	


/* LCweb's image preloader v1.1.2 - 07-09-2017 */
(function(a){if("function"==typeof a.fn.lcweb_lazyload)return!0;lc_lzl_cache={};a.fn.lcweb_lazyload=function(c){c=a.extend({allLoaded:function(){}},c);var e=a(this),g=[],d=[],f=[],h=function(){e.length==d.length&&c.allLoaded.call(this,g,d,f)};return function(){e.each(function(c,e){var b=a.trim(a(this).prop("src"));b?(g.push(b),lc_lzl_cache.hasOwnProperty(b)?(d.push(lc_lzl_cache[b].w),f.push(lc_lzl_cache[b].h),h()):a("<img />").bind("load.lcweb_lazyload",function(){lc_lzl_cache[b]={w:this.width,h:this.height};
d.push(this.width);f.push(this.height);h()}).attr("src",b)):console.log("Empty img url - "+(c+1))})}()}})(jQuery);



/* Media Grid scripts (v6.05) */
(function($) {
	mg_muuri_objs 		= []; // associative array (grid_id => obj) containing muuri objects to perform operations
	$mg_sel_grid 		= false; // set displayed item's grid id
	mg_mobile_mode 		= []; // associative array (grid_id => bool) to know which grid is in mobile mode
	
	var lb_is_shown 	= false; // lightbox shown flag
	var lb_switch_dir 	= false; // which sense lightbox is switching (prev/next)
	var video_h_ratio 	= 0.562; // video aspect ratio
	
	var grid_true_ids	= []; // to avoid useless codes - store IDs related to temp ones 
	var grid_is_shown	= []; // associative array (grid_id => bool) to know which grid is shown (first items be shown are so)
	var grids_width		= []; // array used to register grid size changes
	var mg_grid_pag 	= []; // associative array (grid_id => int) to know which page the grid is currently displays
	
	mg_grid_filters 	= []; /* multidimensional array containing applied filters. NB: filter key is the first class part to use (eg. mg_pag_ or mgc_) 
								(grid_id => array(
									'filter_key' => {
										condition 	: AND / OR (string) - use OR if value is an array 
										val			: the filter value (array) - eg. use [5] to filter category 5 (.mgc_5)
									}
								) 
							   */
	
	var txt_under_h		= []; // associative array (item_id => val) used to store text under items height for persistent check 
	var items_cache		= []; // avoid fetching again same item
	
	mg_slider_autoplay 	= []; // array (slider_id => bool) used to know which sliders needs to be autoplayed
	mg_player_objects 	= []; // player objects array
	mg_audio_tracklists = []; // array of tracklists
	mg_audio_is_playing = []; // which track is playing for each player
	
	var mg_deeplinked	= false; // flag to know whether to use history.replaceState
	var mg_hashless_url	= false; // page URL without eventual hashes
	var mg_url_hash		= ''; // URL hashtag
	
	// body/html style vars
	var mg_html_style = ''; 
	var mg_body_style = '';
	mg_fullpage_w = 0;

	// CSS3 loader code
	mg_loader =
	'<div class="mg_loader">'+
		'<div class="mgl_1"></div><div class="mgl_2"></div><div class="mgl_3"></div><div class="mgl_4"></div>'+
	'</div>';

	// event for touch devices that are not webkit
	var mg_generic_touch_event = (!("ontouchstart" in document.documentElement) /*|| navigator.userAgent.match(/(iPad|iPhone|iPod)/g)*/) ? '' : ' touchstart';
	


	// doc ready - append lightbox codes, manage deeplinks
	$(document).ready(function($) {
		mg_append_lightbox();
		mg_apply_deeplinks(true);
	});
	
	
	
	// dynamic grid initialization
	mg_init_grid = function(temp_grid_id, pag) {
		if(!$('#'+temp_grid_id).length) {return false;}
		
		grid_true_ids[temp_grid_id] = $('#'+temp_grid_id).data('grid-id');
		grid_is_shown[temp_grid_id] = false;
		
		// if doesn't exist - append lightbox code
		if(!$('#mg_lb_wrap').length) {
			mg_append_lightbox();
		}
		
		// inline txt items with video bg - use polyfill
		objectFitPolyfill(document.querySelectorAll('.mg_inl_txt_video_bg'));
		
		mg_grid_pag[temp_grid_id] = pag;
		grid_setup(temp_grid_id);
	};
	mg_async_init = function(grid_id, pag) {mg_init_grid(grid_id, pag);}; // retrocompatibility



	// layout and execute grid
	var grid_setup = function(grid_id) {
		evenize_grid_w(grid_id, true);
		mg_pagenum_btn_vis(grid_id);
		mg_txt_under_sizer(grid_id);
		
		item_img_switch(grid_id);
		
		// hook to perform actions right before items showing
		$(window).trigger('mg_pre_grid_init', [grid_id]);	
		
		// initialize muuri and the rest
		chitemmuuri(grid_id);
	};



	// always keep grids to have even width to reduce sizing problems  - ignore grid_id to evenize all
	var evenize_grid_w = function(grid_id, on_init) {
		var $grid = (typeof(grid_id) == 'undefined') ? jQuery('.mg_items_container') : jQuery('#'+grid_id+' .mg_items_container');
		if(!$grid.length) {return false;}
		
		if($grid.length == 1) {
			
			if(!$grid.outerWidth() || $grid.outerWidth() % 2 === 0) {
				return true;
			}
			else {
				// toggle mg_not_even_w class?	
				$grid.toggleClass('mg_not_even_w');
				
				if(typeof(on_init) == 'undefined') {
					mg_relayout_grid(grid_id);
				}
			}	
		}
		else {
			$grid.each(function() { 
				evenize_grid_w( $(this).parents('.mg_grid_wrap').attr('id') );
            });
		}
	};


	// switches images URL between desktop and mobile mode - must be used also to set the initial image
	var item_img_switch = function(grid_id, $forced_items) {
		var $grid 			= $('#'+grid_id); 
		var first_init 		= ($('#'+grid_id+'.mg_muurified').length) ? false : true;
		var has_forced_items= (typeof($forced_items) == 'undefined') ? false : true;
		var trigger_action 	= (first_init || has_forced_items) ? false : true;
		
		// get mobile treshold
		var safe_mg_mobile 	= (typeof(mg_mobile) == 'undefined') ? 800 : mg_mobile;
		if(typeof($('#'+grid_id).attr('data-mobile-treshold')) != 'undefined') {
			safe_mg_mobile = parseInt($('#'+grid_id).data('mobile-treshold'), 10);	
		}

		// find items
		var $items = (has_forced_items) ? $forced_items.find('.mgi_main_thumb') : $('#'+ grid_id +' .mg_box').not('.mg_pag_hide, .mg_cat_hide, .mg_search_hide').find('.mgi_main_thumb');
		
		// get wrapper's width
		var grid_wrap_width = $('#'+grid_id).parent().width();
		
		// zero width - return false
		if(!grid_wrap_width) {return false;} 
		
		// no mobile mode flag? set it to false by deafult
		if(typeof(mg_mobile_mode[grid_id]) == 'undefined') {mg_mobile_mode[grid_id] = false;}	


		// mobile
		if(grid_wrap_width < safe_mg_mobile && (!mg_mobile_mode[grid_id] || first_init || has_forced_items)) {
			$items.each(function() {
                $(this).css('background-image', "url('"+ $(this).data('mobileurl') +"')");
            });

			mg_mobile_mode[grid_id] = true;
			$grid.addClass('mg_mobile_mode');
			
			if(trigger_action) {
				$(window).trigger('mg_mobile_mode_switch', [grid_id]);
			}
			return true;
		}

		// desktop
		if(grid_wrap_width >= safe_mg_mobile && (mg_mobile_mode[grid_id] || first_init || has_forced_items)) {
			$items.each(function() {
                $(this).css('background-image', "url('"+ $(this).data('fullurl') +"')");
            });
			
			mg_mobile_mode[grid_id] = false;
			$grid.removeClass('mg_mobile_mode');
			
			if(trigger_action) {
				$(window).trigger('mg_mobile_mode_switch', [grid_id]);
			}
			return true;
		}
	};
	
	
	// "read" texts under height and manage items to be properly arranged
	mg_txt_under_sizer = function(grid_id, relayout) {
		$('#'+ grid_id +' .mg_grid_title_under .mg_has_txt_under').each(function() {
			var $item = $(this);
			var iid = $item.attr('id'); 
			
			var old_val = (typeof( txt_under_h[iid] ) == 'undefined') ? false : txt_under_h[iid];
			var new_val = $item.find('.mgi_txt_under').outerHeight(true);
			
			if(old_val === false || old_val != new_val) {
				txt_under_h[iid] = new_val;
				$item.css('margin-bottom', new_val);
			}
		});
		
		if(typeof(relayout) != 'undefined') {
			mg_relayout_grid(grid_id);	
		}
	};
	

	
	////////////////////////////////////////////////////
	
	
	
	var hide_grid_loader = function(grid_id) {
		$('#'+ grid_id +' .mg_items_container').stop().fadeTo(300, 1);
		$('#'+grid_id).find('.mg_loader').stop().fadeOut(300);
	};
	
	
	var show_grid_loader = function(grid_id) {
		$('#'+ grid_id +' .mg_items_container').stop().fadeTo(300, 0.25);
		$('#'+grid_id).find('.mg_loader').stop().fadeIn(300);
	};
	
	
	
	// God bless Muuri
	var chitemmuuri = function(grid_id) {

		mg_muuri_objs[grid_id] = new Muuri( jQuery('#'+ grid_id +' .mg_items_container')[0] , {
			items					: jQuery('#'+ grid_id +' .mg_items_container')[0].getElementsByClassName('mg_box'),
			containerClass			: 'mg-muuri',
			itemClass				: 'mg-muuri-item',
			itemVisibleClass		: 'mg-muuri-shown',
			itemHiddenClass			: 'mg-muuri-hidden',
			layoutOnResize			: false,
			layout					: {
				fillGaps : true,
				alignRight : mg_rtl,
			},
							
			showAnimation: function(showDuration, showEasing, visibleStyles) {
				return {
					start: function() {},
					stop: function() {},
				};
			},
    		hideAnimation: function(hideDuration, hideEasing, hiddenStyles) {
				return {
					start: function() {},
					stop: function() {},
				};
			},
		});
		
		jQuery('#'+ grid_id).addClass('mg_muurified');
		
		// run filters - second parameter allows preload and show items
		mg_exec_filters(grid_id, true);
	};
	
	
	// recall muuri to layout again grid elements - ignore grid_id  to relayout all  
	mg_relayout_grid = function(grid_id) {

		// layout everything or just one?
		if(typeof(grid_id) == 'undefined') {
			$('.mg_muurified').each(function() { 
				mg_relayout_grid( $(this).attr('id') );
            });
		} 
		else {
			if(typeof(mg_muuri_objs[grid_id]) != 'undefined') {
				mg_muuri_objs[grid_id].refreshItems();
				mg_muuri_objs[grid_id].layout(true);	
			}
			else {
				console.error('Grid #'+grid_id+' not found or not initialized');	
			}
		}
	};
	
	
	
	// track grids width size change - persistent interval
	$(document).ready(function() {
		setInterval(function() {
			$('.mg_grid_wrap').each(function() {
                var gid = $(this).attr('id');
				var new_w = Math.round($(this).width());
				
				if(typeof(grids_width[gid]) == 'undefined') {
					grids_width[gid] = new_w;	
					return true;
				}
				
				// trigger only if size is different
				if(grids_width[gid] != new_w) {
					grids_width[gid] = new_w;
					
					if(new_w) {
						$(window).trigger('mg_resize_grid', [gid]);		
					}
				}
            });
		}, 200);
	});
	
	// standard MG operations on resize
	$(window).on('mg_resize_grid', function(e, grid_id) {
		
		// if not initialized (eg. tabbed grids) - init now
		if(!$('#'+grid_id+'.mg_muurified').length) {
			grid_setup(grid_id);	
		}
		else {
			mg_relayout_grid(grid_id);
			item_img_switch(grid_id);
			evenize_grid_w(grid_id);
			mg_pagenum_btn_vis(grid_id);
			
			mg_txt_under_sizer(grid_id);
			mg_responsive_txt(grid_id);				
		
			// inline players - resize to adjust tools size
			setTimeout(function() {
				mg_adjust_inl_player_size();
			}, 800);
		}
	});
	
	
	
	////////////////////////////////////////////////////
	
	

	// loads only necessary items (passed via $items) and triggers mg_display_boxes()
	mg_maybe_preload = function(grid_id, $items, callback) {
		mg_responsive_txt(grid_id);
		
		// hide "no items" message
		$('#'+grid_id +'.mg_no_results').removeClass('mg_no_results');
		var $subj = $items;
		
		
		// if no items have a featured image or everything is ready - show directly
		if(!$subj.not('.mgi_ready, .mg_inl_slider, .mg_inl_text').find('.mgi_main_thumb').length) {
			$subj.mg_display_boxes(grid_id);
			
			if(typeof(callback) == 'function') {
				callback.call();	
			}
		}
		
		// otherwise preload images first
		else {
			if($('#'+grid_id +' .mg_loader').is(':hidden')) {
				show_grid_loader(grid_id);	
			}
			
			// trick to use preloader without tweaks - simulate img tags
			var $preload_wrap = jQuery('<div></div>');
			$subj.not('.mgi_ready').find('.mgi_main_thumb').each(function() {
            	var src = (mg_mobile_mode[grid_id]) ? $(this).attr('data-mobileurl') : $(this).attr('data-fullurl');
				$preload_wrap.append('<img src="'+ src +'" />');  
            });
			
			$preload_wrap.find('img').lcweb_lazyload({
				allLoaded: function(url_arr, width_arr, height_arr) {
					$subj.mg_display_boxes(grid_id);
					
					if(typeof(callback) == 'function') {
						callback.call();	
					}
				}
			});
		}
	};
	
	
	
	// show boxes, initializing players and sliders
	$.fn.mg_display_boxes = function(grid_id) {
		var $boxes = this;
		var grid_initiated = (grid_is_shown[grid_id]) ? true : false;
		
		hide_grid_loader(grid_id);
		
		var a = 0;
		var delay = (mg_delayed_fx && !grid_is_shown[grid_id]) ? 170 : 0; // no delay if grid is already shown
		var total_delay = this.length * delay;
		
		$boxes.each(function(i, v) {
			var $subj = $(this);
			var true_delay = delay * a;
			
			// mark items as managed
			$subj.addClass('mgi_ready');
			
			// show
			setTimeout(function() {
				$subj.addClass('mgi_shown');

				// keburns effects - init
				$subj.mg_item_img_to_kenburns();

				// inline slider - init
				if( $subj.hasClass('mg_inl_slider') ) {
					var sid = $subj.find('.mg_inl_slider_wrap').attr('id');
					mg_inl_slider_init(sid);
				}
				
				// inline video - init and eventually autoplay
				if($subj.find('.mg_self-hosted-video').length) {
					var pid = '#' + $subj.find('.mg_sh_inl_video').attr('id');
					mg_video_player(pid, true);
					
					var inl_player = true; 
				}

				// webkit fix for inline vimeo/youtube fullscreen mode + avoid bounce back on self-hosted fullscreen mode
				if( $subj.hasClass('mg_inl_video') && !$subj.find('.mg_sh_inl_video').length) {
					if(navigator.userAgent.indexOf('Chrome/') != -1 || navigator.appVersion.indexOf("Safari/") != -1) {
						setTimeout(function() {
							$subj.find('.mg_shadow_div').css('transform', 'none').css('animation', 'none').css('-webkit-transform', 'none').css('-webkit-animation', 'none').css('opacity', 1);				
						}, 350);
					}	
				}

				// inline audio - init and show
				if( $subj.hasClass('mg_inl_audio') && $subj.find('.mg_inl_audio_player').length ) {
					setTimeout(function() {
						var pid = '#' + $subj.find('.mg_inl_audio_player').attr('id');
						init_inl_audio(pid);
					}, 350);
						
					var inl_player = true; 
				}
				
				// fix inline player's progressbar when everything has been shown
				if(typeof(inl_player) != 'undefined') {
					setTimeout(function() {
						var player_id = '#' + $subj.find('.mg_inl_audio_player, .mg_sh_inl_video').attr('id');
						mg_adjust_inl_player_size(player_id);
					}, 400);
				}
				
				// inline text with video bg - init
				if( $subj.find('.mg_inl_txt_video_bg').length ) {
					var video = $subj.find('.mg_inl_txt_video_bg')[0];
					video.currentTime = 0;
					video.play();
				}
				
			}, true_delay);
			
			a++;
		});
		
		
		// actions after grid is fully shown
		setTimeout(function() {
			
			// actions on very first grid showing
			if(!grid_initiated) {
				grid_is_shown[grid_id] = true;
				$('#'+ grid_id +' .mg_no_init_loader').removeClass('mg_no_init_loader');
				
				// remove initial classes and manage everything with muuri
				$('#'+ grid_id).addClass('mgi_shown');

				// add an hook for custom actions
				$(window).trigger('mg_grid_shown', [grid_id]);
			}	
			
			// fix fucking webkit rendering bug
			webkit_blurred_elems_fix(grid_id);		
		}, total_delay);
		
		
		// boxes are ready - trigger action passing grid id, managed items and grid_initiated boolean
		$(window).trigger('mg_items_ready', [grid_id, $boxes, grid_initiated]);
		return true;
	};
	
	
	
	//////////////////////////////////////////////////////////////////////////

	
	
	// EXECUTE FILTERS
	//// elaborates filters and applied the "mg_filtered" class to be used by muuri - reads values from mg_grid_filter 
	mg_exec_filters = function(grid_id, on_init) {
		var $grid = $('#'+grid_id);
		
		if(typeof(mg_grid_filters[grid_id]) != 'object' || $grid.hasClass('mg_is_filtering')) {
			return false;
		}
		var mgf = mg_grid_filters[grid_id];
		
		// reset
		$grid.addClass('mg_is_filtering');
		$grid.find('.mg_no_results').removeClass('mg_no_results');
		$grid.find('.mg_box').removeClass('mg_filtered mg_hidden_pag');
		
		// find items to be shown
		var $all_items = $('#'+grid_id +' .mg_box');
		var $items = $all_items;
		
		
		// ignore pagination?
		if(Object.keys(mgf).length > 1 && typeof(mgf['mg_pag_']) != 'undefined' && !mg_monopage_filter) {
			$grid.find('.mg_pag_wrap').fadeOut(400); // hide pagination wrap	
			var ignore_pag = true;
		} else {
			$grid.find('.mg_pag_wrap').fadeIn(400); // hide pagination wrap	
			var ignore_pag = false;
		}
		
		
		// filter style (reduce opacity only on 1-page grids or if calculating pagination)
		var behav = 'standard';
		if(mg_filters_behav != 'standard') {
			if(!$grid.find('.mg_pag_wrap').length || mg_monopage_filter) {
				behav = mg_filters_behav;	

			}

		}
			

		// filter
		for(var key in mg_grid_filters[grid_id]) {
			var data = mg_grid_filters[grid_id][key];
			if(typeof(data.val) != 'object' || !data.val.length || typeof(data.condition) == 'undefined') {continue;}

			// trick to filter on every page
			if(ignore_pag && key == 'mg_pag_') {continue;}


			// AND condition
			if(data.condition == 'AND') {
				var selector = ''; 	
				$.each(data.val, function(i,v) {
					selector += '.'+ key + v;
				});
			}
			
			// OR condition
			else {
				var selector = []; 	
				$.each(data.val, function(i,v) {
					selector.push( '.'+ key + v);
				});
				selector = selector.join(' , ');
			}
			
			//console.log(selector); // debug 
			$items = $items.filter(selector);
			
			
			// if filtering by page - add another class for excluded ones
			if(key == 'mg_pag_') {
				$all_items.not(selector).addClass('mg_hidden_pag');	
			}
		}
		
		// class flagging remaining items 
		$items.addClass('mg_filtered');
		var $shown_items = (behav == 'standard') ? $items : $all_items.not('.mg_hidden_pag');
		
		// which class to use with muuri?
		var muuri_filter = (behav == 'standard') ? '.mg_filtered' : '*:not(.mg_hidden_pag)';

		// switch image for shown items
		item_img_switch(grid_id, $shown_items);
		
		
		////
		// opacity filters - use JS
		if(behav != 'standard') {
			var opacity_val = (behav == '0_opacity') ? 0 : 0.4;
			$all_items.not('.mg_filtered').addClass('mgi_low_opacity_f').fadeTo(450, opacity_val);
			$items.removeClass('mgi_low_opacity_f').fadeTo(450, 1);
		}
		////
		

		// on grid init - just set classes and trigger preload
		if(typeof(on_init) != 'undefined') {
			$grid.find('.mg_items_container').removeClass('mgic_pre_show');
			
			mg_maybe_preload(grid_id, $shown_items);	
			mg_muuri_objs[grid_id].filter(muuri_filter);	
			
			mg_filter_no_results(grid_id);
			$grid.removeClass('mg_is_filtering');
		}
		
		
		// otherwise be sure items are ready before filtering
		else {
			mg_maybe_preload(grid_id, $shown_items, function() {
				mg_muuri_objs[grid_id].filter(muuri_filter);
				
				mg_filter_no_results(grid_id);
				$grid.removeClass('mg_is_filtering');
				
				// trigger action to inform that items are filtered (and new ones could be shown)
				$(window).trigger('mg_filtered_grid', [grid_id]);
			});
			
			// pause hidden players and sliders (be sure to use it after maybe_preload() )
			mg_pause_inl_players(grid_id);
		}
	};
	
	
	// shown items count - toggle "no results" box
	var mg_filter_no_results = function(grid_id) {
		
		if($('#'+ grid_id +' .mg-muuri-shown').length) {
			$('#'+ grid_id +' .mg_items_container').removeClass('mg_no_results');
		} else {
			$('#'+ grid_id +' .mg_items_container').addClass('mg_no_results');
		}
	};
	
	
	// dropdown filters management
	$(document).delegate('.mg_mobile_mode .mg_dd_mobile_filters .mgf_inner', 'click', function(e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		
		var $this = $(this);
		if(typeof(mg_dd_toggle_timeout) != 'undefined') {clearTimeout(mg_dd_toggle_timeout)}
		
		mg_dd_toggle_timeout = setTimeout(function() {
			$this.toggleClass('mgf_dd_expanded');
		}, 50);
	});
	
	
	
	//////////////////////////////////////////////////////////////////////////
	
	
	
	// PAGINATE ITEMS
	$(document).ready(function() {
		
		// prev/next buttons
		$(document).delegate('.mg_next_page:not(.mg_pag_disabled), .mg_prev_page:not(.mg_pag_disabled)', 'click'+mg_generic_touch_event, function() {
			var cmd = ($(this).hasClass('mg_next_page')) ? 'next' : 'prev';
			mg_paginate(cmd, $(this).parents('.mg_grid_wrap').attr('id') );
		});
		
		
		// page buttos and dots
		$(document).delegate('.mg_pag_btn_nums > div:not(.mg_sel_pag), .mg_pag_btn_dots > div:not(.mg_sel_pag)', 'click'+mg_generic_touch_event, function() {
			var pag = $(this).data('pag');
			var grid_id = $(this).parents('.mg_grid_wrap').attr('id'); 
			
			jQuery(this).parents('.mg_pag_wrap').find('> div').removeClass('mg_sel_pag');
			jQuery(this).addClass('mg_sel_pag');
			
			
			mg_pagenum_btn_vis(grid_id);
			mg_paginate(pag, grid_id);
		});
	});
	
	
	// perform pagination - direction accepts "next" / "prev" or the page number

	mg_paginate = function(direction, grid_id) {
		if($('#'+grid_id).hasClass('mg_is_filtering')) {
			return false;	
		}
		
		var temp_gid = grid_id;
		var gid = $('#'+temp_gid).data('grid-id');
		
		var tot_pags = parseInt($('#mgp_'+temp_gid).data('tot-pag'));
		var curr_pag =  parseInt(mg_grid_pag[temp_gid]);

		
		// next/prev case
		if($.inArray(direction, ['next', 'prev']) !== -1) {
			if( // ignore in these cases
				(direction == 'next' && curr_pag >= tot_pags) ||
				(direction == 'prev' && curr_pag <= 1)
			) {
				return false;	
			}
			
			// update pag vars
			var new_pag = (direction == 'next') ? curr_pag + 1 : curr_pag - 1;	
		}

		// direct pagenum submission
		else {
			var new_pag = parseInt(direction);
			if(new_pag < 1 || new_pag > tot_pags || new_pag == curr_pag) {
				return false;	
			}
		}

		
		// set class
		mg_grid_pag[temp_gid] = new_pag;	
		
		// set/remove deeplink
		if(new_pag == 1) {
			mg_remove_deeplink('page' ,'mgp_'+gid);
		} else {
			mg_set_deeplink('page', 'mgp_'+gid, new_pag);
		}
		
		// manage disabled class
		if(new_pag == 1) {
			$('#mgp_'+temp_gid+' .mg_prev_page').addClass('mg_pag_disabled');
		} else {
			$('#mgp_'+temp_gid+' .mg_prev_page').removeClass('mg_pag_disabled');
		}
		
		if(new_pag == tot_pags) {
			$('#mgp_'+temp_gid+' .mg_next_page').addClass('mg_pag_disabled');
		} else {
			$('#mgp_'+temp_gid+' .mg_next_page').removeClass('mg_pag_disabled');
		}
		
		// manage current pag number if displayed
		if($('#mgp_'+temp_gid+' .mg_nav_mid span').length) {
			$('#mgp_'+temp_gid+' .mg_nav_mid span').text(new_pag);	
		}
		
		
		// update filter
		mg_grid_filters[ temp_gid ]['mg_pag_'] = {
			condition 	: 'AND',
			val			: [new_pag]
		};
		mg_exec_filters(temp_gid);
		
		
		// move to grids top
		jQuery('html, body').animate({'scrollTop': jQuery('#'+temp_gid).offset().top - 15}, 300);
	};
	
	
	// track grid's width and avoid pagenum and dots to go on two lines
	var mg_pagenum_btn_vis = function(grid_id) {
		if(!$('#'+grid_id).find('.mg_pag_btn_nums, .mg_pag_btn_dots').length) {
			return false;	
		}

		var $pag_wrap = $('#'+grid_id).find('.mg_pag_wrap'); 
		var $btns = $('#'+grid_id).find('.mg_pag_btn_nums, .mg_pag_btn_dots').find('> div');
		
		// reset
		$pag_wrap.removeClass('mg_hpb_after mg_hpb_before');
		$btns.removeClass('mg_hidden_pb');
		
		// there must be at least 5 buttons
		if($btns.length <= 5) {return false;}
		
		
		// calculate overall btns width
		var btns_width = 0;
		$btns.each(function() {
            btns_width += jQuery(this).outerWidth(true) + 1; // add 1px to avoid any issue
        });  
		

		// act if is wider
		if(btns_width > $pag_wrap.outerWidth()) {
			var $sel_btn = $('#'+grid_id+' .mg_sel_pag');
			var curr_pag = parseInt($sel_btn.data('pag'));
			var tot_pages = parseInt($btns.last().data('pag'));
			
			// count dots width
			var dots_w = (curr_pag <= 2 || curr_pag >= (tot_pages - 1)) ? 26 : 52; // width = 16px + add 10px margin
			
			var diff = btns_width + dots_w - $pag_wrap.outerWidth() ;
			var last_btn_w = $btns.last().outerWidth(true);
			var to_hide = Math.ceil( diff / last_btn_w );

			// manage pag btn visibility
			if(curr_pag <= 2 || curr_pag >= (tot_pages - 1)) {
			var to_hide_sel = [];
			
				if(curr_pag <= 2) {
					$pag_wrap.addClass('mg_hpb_after');		
					
					for(a=0; a < to_hide; a++) {
						to_hide_sel.push('[data-pag='+ (tot_pages - a) +']');	
					}
				}
				else if( curr_pag >= (tot_pages - 1)) {
					$pag_wrap.addClass('mg_hpb_before');	
					
					for(a=0; a < to_hide; a++) {
						to_hide_sel.push('[data-pag='+ (1 + a) +']');	
					}
				}
				
				$btns.filter( to_hide_sel.join(',') ).addClass('mg_hidden_pb');
			}
			
			else {
				$pag_wrap.addClass('mg_hpb_before mg_hpb_after');	
				var to_keep_sel = ['[data-pag='+ curr_pag +']'];
				
				// use opposite system: selected is the center and count how to keep 
				var to_keep = (tot_pages - 1) - to_hide;

				var to_keep_pre = Math.floor( to_keep / 2 );
				var to_keep_post = Math.ceil( to_keep / 2 );
				
				// if pre/post already reaches the edge, sum remaining ones on the other side
				var reach_pre = curr_pag - to_keep_pre;
				var reach_post = curr_pag + to_keep_post;
				
				if(reach_pre <= 1) {
					$pag_wrap.removeClass('mg_hpb_before');	
					to_keep_post = to_keep_post + (reach_pre * -1 + 1);	
				}
				else if(reach_post >= tot_pages) {
					$pag_wrap.removeClass('mg_hpb_after');	
					to_keep_pre = to_keep_pre + (reach_post - (tot_pages - 1));	
				}
				
				for(a=1; a <= to_keep_pre; a++) {
					to_keep_sel.push('[data-pag='+ (curr_pag - a) +']');	
				}
				for(a=1; a <= to_keep_post; a++) {
					to_keep_sel.push('[data-pag='+ (curr_pag + a) +']');	
				}
				
				$btns.not( to_keep_sel.join(',') ).addClass('mg_hidden_pb');
			}	
		}
	};
	
	
	//////
	
	
	// Infinite Scroll
	$(document).ready(function() {
		$(document).delegate('.mg_load_more_btn', 'click'+mg_generic_touch_event, function() {
			var $pwrap = $(this).parents('.mg_pag_wrap');
			var grid_id = $(this).parents('.mg_grid_wrap').attr('id');
			
			var curr_pag = parseInt($pwrap.attr('data-init-pag'));
			var tot_pags = parseInt($pwrap.attr('data-tot-pag'));
			
			if($('#'+grid_id).hasClass('mg_is_filtering') || curr_pag >= tot_pags) {
				return false;	
			}
			
			var newpag = curr_pag + 1;
			$pwrap.attr('data-init-pag', newpag);

			// filter showing every page until now
			var filter_val = [];
			for(a = 1; a <= newpag ; a++) {filter_val.push(a);}
			
			mg_grid_filters[ grid_id ]['mg_pag_'] = {
				condition 	: 'OR',
				val			: filter_val
			};
			mg_exec_filters(grid_id);
			
			// reached final page? hide button
			if(newpag >= tot_pags) {
				$pwrap.fadeOut(300, function() {
					$('#'+grid_id).animate({paddingBottom : 0}, 400);		
				});
			}
		});
	});
	
	
	///////////////////////////////////////////////
	


	// items category filter
	$(document).ready(function() {
		$(document).delegate('.mgf:not(.mgf_selected)', 'click', function(e) {
			e.preventDefault();

			var $grid = $(this).parents('.mg_grid_wrap');
			var temp_gid = $grid.attr('id'); 
			var gid = $grid.data('grid-id');
			var sel = $(this).data('filter-id');
			var txt = $(this).text();
			
			// already filtering? stop
			if($grid.hasClass('mg_is_filtering') ) {return false;}

			// button selection manag
			$grid.find('.mgf').removeClass('mgf_selected');
			$(this).addClass('mgf_selected');
			
			// no filter - clear filtering db and deeplink
			if(!sel || sel == '*') {
				delete mg_grid_filters[ temp_gid ]['mgc_'];
				mg_remove_deeplink('category', 'mgc_'+gid);
			}
			
			// filter selected - update db and deeplink
			else {
				mg_grid_filters[ temp_gid ]['mgc_'] = {
					condition 	: 'AND',
					val			: [sel]
				};
				mg_set_deeplink('category', 'mgc_'+gid, sel, txt);
			}
				
			mg_exec_filters(temp_gid);
			
			
			// mgf_noall_placeh removal
			if($grid.find('.mgf_noall_placeh').length) {
				$grid.find('.mgf_noall_placeh').remove();	
			}
		});
	});



	///////////////////////////////////////////////
	


	// items search 
	$(document).delegate('.mgf_search_form input', 'keyup', function() {
		
		if(typeof(mg_search_defer) != 'undefined') {clearTimeout(mg_search_defer);}
		var $this = $(this); 
		
		mg_search_defer = setTimeout(function() { 
			var $grid = $this.parents('.mg_grid_wrap');
			var temp_gid = $grid.attr('id'); 
			var gid = $grid.data('grid-id');
			var val = $.trim( $this.val() );
			
			// reset class
			$grid.find('.mg_box').removeClass('mg_search_res');
			

			// is searching
			if(val && val.length > 2) {
				$grid.find('.mgf_search_form').addClass('mgs_has_txt');	
				
				// elaborate search string to match items
				var src_arr = val.toLowerCase().split(' ');
				var matching = [];
	
				// cyle and check each searched term 
				$grid.find('.mg_box:not(.mg_spacer)').each(function() {
					var src_attr = $(this).data('mg-search').toLowerCase();
					var rel = $(this).data('item-id');
					
					$.each(src_arr, function(i, word) {						
						if( src_attr.indexOf(word) !== -1 ) {
							matching.push( rel );
							return false;	
						}
					});
				});
	
				// add class to matched elements
				$.each(matching, function(i, v) {
					$grid.find('.mg_box[data-item-id='+ v +']').addClass('mg_search_res');
				});
				
				
				// set filter engine to match mg_search_res
				mg_grid_filters[ temp_gid ]['mg_search_res'] = {
					condition 	: 'AND',
					val			: ['']
				};
				
				mg_set_deeplink('search', 'mgs_'+gid, val);
			} 
			
			
			// deleting research
			else {
				$grid.find('.mgf_search_form').removeClass('mgs_has_txt');		
				delete mg_grid_filters[ temp_gid ]['mg_search_res']; 
				mg_remove_deeplink('search', 'mgs_'+gid);
			}
			
			
			// filter to show results
			mg_exec_filters(temp_gid);
		}, 300);
	});


	// reset search
	$(document).delegate('.mgf_search_form.mgs_has_txt i', 'click'+mg_generic_touch_event, function() {
		var $grid = $(this).parents('.mg_grid_wrap');
		var $input = $grid.find('.mgf_search_form input'); 
		
		if($grid.hasClass('mg_is_filtering')) {return false;}
		
		if($.trim( $input.val() ) && $input.val().length > 2) {
			$input.val('');
			$input.trigger('keyup');	
		}
	});
	

	// disable enter key
	jQuery(document).on("keypress", ".mgf_search_form input", function(e) { 
		return e.keyCode != 13;
	});
	


	// custom filtering behavior
	$.fn.mg_custom_iso_filter = function( options ) {
		options = $.extend({
			filter: '*',
			hiddenStyle: { opacity: 0.2 },
			visibleStyle: { opacity: 1 }
		}, options );

		this.each( function() {
			var $items = $(this).children();
			var $visible = $items.filter( options.filter );
			var $hidden = $items.not( options.filter );

			$visible.clearQueue().animate( options.visibleStyle, 300 ).removeClass('mg_disabled');
			$hidden.clearQueue().animate( options.hiddenStyle, 300 ).addClass('mg_disabled');
		});
	};
	
	
	
	
	////////////////////////////////////////////
	
	

	// video poster - handle click
	$(document).ready(function() {
		// grid item
		$(document).delegate('.mg_inl_video:not(.mgi_iv_shown)', 'click'+mg_generic_touch_event, function(e){
			var $this = $(this);
			$this.addClass('mgi_iv_shown');
			
			// video iframe
			if($this.find('.mg_video_iframe').length) {
				var autop = $this.find('.mg_video_iframe').data('autoplay-url');
				$this.find('.mg_video_iframe').attr('src', autop).show();
	
				setTimeout(function() { // wait a bit to let iframe populate
					$this.find('.mgi_thumb_wrap, .mgi_overlays').fadeTo(350, 0, function() {
						$this.parents('.mg_video_iframe').css('z-index', 100);
						$(this).remove();
					});
				}, 50);
			}
			
			// self-hosted
			else {
				$this.find('.mgi_thumb_wrap, .mgi_overlays').fadeTo(350, 0, function() {
					$(this).remove();
					
					var pid = '#' + $this.find('.mg_sh_inl_video').attr('id');
					var player_obj = mg_player_objects[pid];
					player_obj.play();
				});
			}
		});

		// lightbox
		$(document).delegate('#mg_lb_video_poster, #mg_ifp_ol', 'click'+mg_generic_touch_event, function(e){
			var autop = $('#mg_lb_video_poster').data('autoplay-url');
			if(typeof(autop) != 'undefined') {
				$('#mg_lb_video_wrap').find('iframe').attr('src', autop);
			}

			$('#mg_ifp_ol').fadeOut(120);
			$('#mg_lb_video_poster').fadeOut(400);
		});
	});


	// show&play inline audio on overlay click
	$(document).ready(function(e) {
        $('body').delegate('.mg_box.mg_inl_audio:not(.mgi_ia_shown)', 'click'+mg_generic_touch_event, function() {
			var $this = jQuery(this);
			$this.addClass('mgi_ia_shown');
			
			// soundCloud
			if($this.find('.mg_soundcloud_embed').length) {
				var sc_url = $this.find('.mg_soundcloud_embed').data('lazy-src');
				$this.find('.mg_soundcloud_embed').attr('src', sc_url).removeData('lazy-src');
				
				setTimeout(function() { // wait a bit to let iframe populate
					$this.find('.mgi_thumb_wrap, .mgi_overlays').fadeTo(350, 0, function() {
						$this.find('.mg_soundcloud_embed').css('z-index', 100);
						$(this).remove();
					});
				}, 50);
			}
			
			// self-hosted 
			else {
				var player_id = '#' + $this.find('.mg_inl_audio_player').attr('id');
				init_inl_audio(player_id, true);	
				
				$this.find('.mgi_overlays').fadeOut(350, function() {
					$(this).remove();
				});
			}
		});
	});



	// touch devices hover effects
	if( mg_is_touch_device() ) {
		$('.mg_box').bind('touchstart', function() { $(this).addClass('mg_touch_on'); });
		$('.mg_box').bind('touchend', function() { $(this).removeClass('mg_touch_on'); });
	}
	
	
	

	//////////////////////////////////////////////////////////////////////////




	/***************************************
	************** LIGHTBOX ****************
	***************************************/


	// append the lightbox code to the website
	mg_append_lightbox = function() {
		if(typeof(mg_lightbox_mode) != 'undefined') {

			// deeplinked lightbox - stop here
			if($('#mg_deeplinked_lb').length) {
				$mg_lb_contents = $('#mg_lb_contents');
				$('html').addClass('mg_lb_shown');
				lb_is_shown = true;
				return true;
			}


			/// remove existing one
			if($('#mg_lb_wrap').length) {
				$('#mg_lb_wrap, #mg_lb_background').remove();
			}

			// touchswipe class
			var ts_class = (mg_lb_touchswipe) ? 'class="mg_touchswipe"' : '';

			$('body').append(''+
			'<div id="mg_lb_wrap" '+ts_class+'>'+
				'<div id="mg_lb_loader">'+ mg_loader + '</div>' +
				'<div id="mg_lb_contents" class="mg_lb_pre_show_next"></div>'+
				'<div id="mg_lb_scroll_helper" class="'+ mg_lightbox_mode +'"></div>'+
			'</div>'+
			'<div id="mg_lb_background" class="'+ mg_lightbox_mode +'"></div>');

			$mg_lb_contents = $('#mg_lb_contents');
		}
	};


	// open item trigger
	$(document).ready(function() {
		$(document).delegate('.mgi_has_lb:not(.mg-muuri-hidden, .mgi_low_opacity_f)', 'click', function(e){
			// elements to ignore -> mgom socials
			var $e = $(e.target);
			if(!lb_is_shown && !$e.hasClass('mgom_fb') && !$e.hasClass('mgom_tw') && !$e.hasClass('mgom_pt') && !$e.hasClass('mgom_gp') && !$e.hasClass('mg_quick_edit_btn')) {
				var $subj = $(this);
				
				var pid = $subj.data('item-id');
				$mg_sel_grid = $subj.parents('.mg_grid_wrap');

				// open
				mg_open_item(pid);
			}
		});
	});

	
	// remove site scrollbar when lightbox is on
	mg_remove_scrollbar = function() {
		mg_html_style = (typeof($('html').attr('style')) != 'undefined') ? $('html').attr('style') : '';
		mg_body_style = (typeof($('body').attr('style')) != 'undefined') ? $('body').attr('style') : '';
		
		// avoid page scrolling and maintain contents position
		var orig_page_w = $(window).width();
		$('html').css({
			'overflow' 		: 'hidden',
			'touch-action'	: 'none'
		});

		$('body').css({
			'overflow' 		: 'visible',
			'touch-action'	: 'none'	
		});	
		
		mg_fullpage_w = $(window).width();
		$('html').css('margin-right', ($(window).width() - orig_page_w));
	};



	// OPEN ITEM
	mg_open_item = function(item_id, deeplinked_lb) {
		mg_remove_scrollbar();
		$('#mg_lb_wrap').show();

		// mobile trick to focus lightbox contents
		if($(window).width() < 1000) { 
			$mg_lb_contents.delay(20).trigger('click');
		}

		// open only if is not deeplinked
		if(typeof(deeplinked_lb) == 'undefined') {
			setTimeout(function() {
				$('#mg_lb_loader, #mg_lb_background').addClass('mg_lb_shown');
				mg_get_item_content(item_id);
			}, 50);
		}
	};


	// get item's content
	mg_get_item_content = function(pid, on_item_switch) {
		$mg_lb_contents.removeClass('mg_lb_shown');
		var gid = $mg_sel_grid.attr('id');
		var true_gid = $mg_sel_grid.data('grid-id');

		// set attributes to know related grid and item ID
		$('#mg_lb_wrap').data('item-id', pid).data('grid-id', gid);

		// set deeplink
		var item_title = $('.mgi_'+pid+' .mgi_main_thumb').data('item-title');
		mg_set_deeplink('item', 'mgi_'+true_gid, pid, item_title);

		// get prev and next items ID to compose nav arrows
		var nav_arr = [];
		var curr_pos = 0;

		$mg_sel_grid.find('.mgi_has_lb').not('.mg-muuri-hidden').each(function(i, el) {
			var item_id = $(this).data('item-id');

			nav_arr.push(item_id);
			if(item_id == pid) {curr_pos = i;}
		});
		
		// prev/next switch 
		if(mg_lb_carousel) {
			// nav - prev item
			var prev_id = (curr_pos !== 0) ? nav_arr[(curr_pos - 1)] : nav_arr[(nav_arr.length - 1)];
			
			// nav - next item
			var next_id = (curr_pos != (nav_arr.length - 1)) ? nav_arr[(curr_pos + 1)] : nav_arr[0];
		}
		else {
			// nav - prev item
			var prev_id = (curr_pos !== 0) ? nav_arr[(curr_pos - 1)] : 0;
			
			// nav - next item
			var next_id = (curr_pos != (nav_arr.length - 1)) ? nav_arr[(curr_pos + 1)] : 0;
		}
	
		
		// create a static cache id to avoid doubled ajax calls
		var static_cache_id = ''+ prev_id + pid + next_id;
	

		// check in static cache
		if(typeof(items_cache[static_cache_id]) != 'undefined') {
			var delay = (typeof(on_item_switch) == 'undefined') ? 320 : 0; // avoid lightbox to be faster than background on initial load
			
			setTimeout(function() {
				fill_lightbox( items_cache[static_cache_id] );	
			}, delay);
		}
		
		// perform ajax call
		else {
			var cur_url = location.href;
			var data = {
				mg_lb	: 'mg_lb_content',
				pid		: pid,
				prev_id : prev_id,
				next_id : next_id
			};
			mg_get_item_ajax = $.post(cur_url, data, function(response) {
				
				if(static_cache_id) {
					items_cache[static_cache_id] = response;
				}
				
				fill_lightbox(response);
			});
		}

		return true;
	};
	
	
	// POPULATE LIGHTBOX AND SHOW BOX
	var fill_lightbox = function(lb_contents) {
		if(!lb_switch_dir) {lb_switch_dir = 'next';}
		$mg_lb_contents.html(lb_contents).attr('class', 'mg_lb_pre_show_'+lb_switch_dir);

		// older IE iframe bg fix
		if(mg_is_old_IE() && $('#mg_lb_contents .mg_item_featured iframe').length) {
			$('#mg_lb_contents .mg_item_featured iframe').attr('allowTransparency', 'true');
		}

		// init self-hosted videos without poster
		if($('.mg_item_featured .mg_me_player_wrap.mg_self-hosted-video').length && !$('.mg_item_featured .mg_me_player_wrap.mg_self-hosted-video > img').length) {
			mg_video_player('#mg_lb_video_wrap');
		}
		
		// show with a little delay to be smoother
		setTimeout(function() {
			$('#mg_lb_loader').removeClass('mg_lb_shown');
			$mg_lb_contents.attr('class', 'mg_lb_shown').focus();
			$('html').addClass('mg_lb_shown');
			
			lb_is_shown = true;
			lb_switch_dir = false;
		}, 50);
	};
	

	// switch item - arrow click
	$(document).ready(function() {
		$(document).delegate('.mg_nav_active > *', 'click'+mg_generic_touch_event, function(){
			lb_switch_dir = ($(this).parents('.mg_nav_active').hasClass('mg_nav_next')) ? 'next' : 'prev';
			
			var pid = $(this).parents('.mg_nav_active').attr('rel');
			mg_switch_item_act(pid);
		});
	});

	// switch item - keyboards events
	$(document).keydown(function(e){
		if(lb_is_shown) {

			// prev
			if (e.keyCode == 37 && $('.mg_nav_prev.mg_nav_active').length) {
				var pid = $('.mg_nav_prev.mg_nav_active').attr('rel');
				lb_switch_dir = 'prev';
				mg_switch_item_act(pid);
			}

			// next
			if (e.keyCode == 39 && $('.mg_nav_next.mg_nav_active').length) {
				var pid = $('.mg_nav_next.mg_nav_active').attr('rel');
				lb_switch_dir = 'next';
				mg_switch_item_act(pid);
			}
		}
	});


	// switch item - touchSwipe events
	$(document).ready(function() {
		if(typeof(mg_lb_touchswipe) != 'undefined' && mg_lb_touchswipe) {
			
			var swipe_subj = document.getElementById("mg_lb_contents");
			
			new AlloyFinger(swipe_subj, {
				swipe:function(evt){
					if(evt.direction === "Left"){
						if ($('.mg_nav_next.mg_nav_active').length) {
							var pid = $('.mg_nav_next.mg_nav_active').attr('rel');
							mg_switch_item_act(pid);
						}
					}
					else if(evt.direction === "Right"){
						if ($('.mg_nav_prev.mg_nav_active').length) {
							var pid = $('.mg_nav_prev.mg_nav_active').attr('rel');
							mg_switch_item_act(pid);
						}
					}
				}
			});
		}
	});


	// SWITCH ITEM IN LIGHTBOX
	mg_switch_item_act = function(pid) {
		$('#mg_lb_loader').addClass('mg_lb_shown');
		$mg_lb_contents.attr('class', 'mg_lb_switching_'+lb_switch_dir);
		
		$('#mg_lb_top_nav, .mg_side_nav, .mg_lb_nav_side_basic, #mg_top_close').fadeOut(350, function() {
			$(this).remove();
		});

		// wait CSS3 transitions
		setTimeout(function() {
			mg_unload_lb_scripts();
			$mg_lb_contents.empty();
			mg_get_item_content(pid);
			
			lb_is_shown = false;
		}, 500);


	};


	// CLOSE LIGHTBOX
	mg_close_lightbox = function() {
		mg_unload_lb_scripts();
		if(typeof(mg_get_item_ajax) != 'undefined') {mg_get_item_ajax.abort();}
		
		if(typeof(mg_lb_realtime_actions_intval) != 'undefined') {
			clearInterval(mg_lb_realtime_actions_intval);	
		}

		$('#mg_lb_loader').removeClass('mg_lb_shown');
		$mg_lb_contents.attr('class', 'mg_closing_lb');
		
		$('#mg_lb_background').delay(120).removeClass('mg_lb_shown');
		$('#mg_lb_top_nav, .mg_side_nav, #mg_top_close').fadeOut(350, function() {
			$(this).remove();
		});
		
		setTimeout(function() {
			$('#mg_lb_wrap').hide();
			$mg_lb_contents.empty();
			$('#mg_lb_background.google_crawler').fadeOut();

			// restore html/body inline CSS
			if(typeof(mg_html_style) != 'undefined') {$('html').attr('style', mg_html_style);}
			else {$('html').removeAttr('style');}

			if(typeof(mg_body_style) != 'undefined') {$('body').attr('style', mg_body_style);}
			else {$('body').removeAttr('style');}

			if(typeof(mg_scroll_helper_h) != 'undefined') {
				clearTimeout(mg_scroll_helper_h);
			}
			$('#mg_lb_scroll_helper').removeAttr('style');
			
			$mg_lb_contents.attr('class', 'mg_lb_pre_show_next');
			$('html').removeClass('mg_lb_shown');
			
			lb_is_shown = false;
		}, 500); // wait for CSS transitions

		mg_remove_deeplink('item', 'mgi_'+ $mg_sel_grid.data('grid-id') );
	};

	$(document).ready(function() {
		
		$(document).delegate('#mg_lb_background.mg_classic_lb, #mg_lb_scroll_helper.mg_classic_lb, .mg_close_lb', 'click'+mg_generic_touch_event, function(){
			mg_close_lightbox();
		});
	});


	$(document).keydown(function(e){
		if( $('#mg_lb_contents .mg_close_lb').length && e.keyCode == 27 ) { // escape key pressed
			mg_close_lightbox();
		}
	});


	// unload lightbox scripts
	var mg_unload_lb_scripts = function() {
		
		// stop persistent actions
		if(typeof(mg_lb_realtime_actions_intval) != 'undefined') {
			clearInterval(mg_lb_realtime_actions_intval);	
			jQuery('#mg_lb_scroll_helper').css('margin-top', 0);
		}
	};


	// lightbox images lazyload
	mg_lb_lazyload = function() {
		$ll_img = $('.mg_item_featured > div > img, #mg_lb_video_wrap img');
		if( $ll_img.length ) {
			mg_lb_lazyloaded = false;
			$ll_img.fadeTo(0, 0);
			
			$ll_img.lcweb_lazyload({
				allLoaded: function(url_arr, width_arr, height_arr) {
					mg_lb_lazyloaded = {
						urls 	: url_arr,
						widths	: width_arr,
						heights : height_arr	
					};
					
					$ll_img.fadeTo(300, 1);
					$('.mg_item_featured .mg_loader').fadeOut('fast');
					$('.mg_item_featured').mg_item_img_to_kenburns();
					
					if($('#mg_lb_feat_img_wrap').length) {
						$('#mg_lb_feat_img_wrap').fadeTo(300, 1);	
					}
					
					// for video poster
					if( $('#mg_ifp_ol').length )  {
						$('#mg_ifp_ol').delay(300).fadeIn(300);
						setInterval(function() {
							$('#mg_lb_video_wrap > img').css('display', 'block'); // fix for poster image click
						}, 200);
					}

					// for self-hosted video
					if( $('.mg_item_featured .mg_self-hosted-video').length )  {
						$('#mg_lb_video_wrap').fadeTo(0, 0);
						mg_video_player('#mg_lb_video_wrap');
						$('#mg_lb_video_wrap').fadeTo(300, 1);
					}

					// for mp3 player
					if( $('.mg_item_featured .mg_lb_audio_player').length )  {

						var player_id = '#' + $('.mg_lb_audio_player').attr('id');
						mg_audio_player(player_id);

						$('.mg_item_featured .mg_lb_audio_player').fadeIn();
					}
				}
			});
		}
	};


	// lightbox persistent interval actions
	mg_lb_realtime_actions = function() {
		if(typeof(mg_lb_realtime_actions_intval) != 'undefined') {
			clearInterval(mg_lb_realtime_actions_intval);	
		}
		mg_lb_realtime_actions_intval = setInterval(function() {
			var $feat = $('.mg_item_featured');
			
			
			// keep scrollhelper visible
			jQuery('#mg_lb_scroll_helper').css('margin-top', jQuery('#mg_lb_wrap').scrollTop());
			
			
			// if scroller is shown - manage HTML margin and external buttons position
			if($('#mg_lb_contents').outerHeight(true) > $(window).height()) {
				$('#mg_lb_wrap').addClass('mg_lb_has_scroll');
				
				var diff = mg_fullpage_w - $('#mg_lb_scroll_helper').outerWidth(true);
				$('#mg_top_close, .mg_side_nav_next').css('right', diff);
			}
			else {
				$('#mg_lb_wrap').removeClass('mg_lb_has_scroll');
				$('#mg_top_close, .mg_side_nav_next').css('right', 0);
			}
			
			
			// video - prior checks and height calculation
			if($('.mg_lb_video').length) {
				if( $('.mg_item_featured .mg_video_iframe').length ) {	// iframe
					var $video_subj = $('#mg_lb_video_wrap, #mg_lb_video_wrap .mg_video_iframe');
				}
				else { // self-hosted
					var $video_subj = $('.mg_item_featured .mg_self-hosted-video .mejs-container, .mg_item_featured .mg_self-hosted-video video');
				}
				
				var new_video_h = Math.ceil($feat.width() * video_h_ratio);
			}
			
			/////////

			// fill side-layout space if lightbox is smaller than screen's height 
			if($('.mg_lb_feat_match_txt').length && $('#mg_lb_contents').outerHeight(true) < $(window).height() && $(window).width() > 860) {
				var txt_h = $('.mg_item_content').outerHeight();
				
				// remove comments height to avoid bad results
				/*if($('#mb_lb_comments_wrap').length) {
					txt_h = txt_h - $('#mb_lb_comments_wrap').outerHeight('true');	
				}*/
					
					
				// single image and audio
				if(typeof(mg_lb_lazyloaded) != 'undefined' && mg_lb_lazyloaded && !$('.mg_galleria_slider_wrap').length) {
					var player_h = ($('.mg_lb_audio').length) ? $('.mg_lb_audio_player').outerHeight(true) : 0;	
				  
					// calculate what would be original height
					var real_img_h = Math.round((mg_lb_lazyloaded.heights[0] * $feat.width()) / mg_lb_lazyloaded.widths[0]);

					if((real_img_h + player_h) < txt_h && $feat.height() != txt_h) {
						$feat.addClass('mg_lb_feat_matched');
						$feat.find('img').css('height', (txt_h - player_h)).addClass('mg_lb_img_fill');	
					} 
					else if(real_img_h > txt_h) {
						$feat.removeClass('mg_lb_feat_matched');
						$feat.find('img').removeAttr('style').removeClass('mg_lb_img_fill');
					}
				}
			
				// video
				if($('.mg_lb_video').length) {
					if(new_video_h < txt_h) {new_video_h = txt_h;}
					
					if($video_subj.height() != new_video_h) {
						if($('.mg_item_featured .mg_video_iframe').length) {
							$video_subj.attr('height', new_video_h);
						} else {
							$video_subj.css('height', new_video_h).css('max-height', new_video_h).css('min-height', new_video_h);


						}	
					}
				}
				
				// slider 
				if($('.mg_galleria_slider_wrap').length) {
					var new_slider_h = txt_h - parseInt( $('.mg_galleria_slider_wrap').css('padding-bottom'));
				}
				
			}
				
			// normal sizing
			else {
				
				// single image and audio
				if(typeof(mg_lb_lazyloaded) != 'undefined' && mg_lb_lazyloaded && $feat.hasClass('mg_lb_feat_matched')) {
					$feat.removeClass('mg_lb_feat_matched');
					$feat.find('img').removeAttr('style').removeClass('mg_lb_img_fill');	
				}
				
				// video
				if($('.mg_lb_video').length) {
					if($video_subj.height() != new_video_h) {
						if($video_subj.is('div')) {
							$video_subj.css('height', new_video_h).css('max-height', new_video_h).css('min-height', new_video_h);
						} else {
							$video_subj.attr('height', new_video_h);
						}
					}
				}
				
				// slider 
				if($('.mg_galleria_slider_wrap').length) {
					var slider_id = '#'+ $('.mg_galleria_slider_wrap').attr('id');
					var new_slider_h = ($('.mg_galleria_responsive').length) ? Math.ceil($('.mg_galleria_responsive').width() * mg_galleria_height(slider_id)) : mg_galleria_height(slider_id); 
				}
			}
			
			//////////
			
			// slider resizing
			if(typeof(mg_lb_slider) != 'undefined' && typeof(new_slider_h) != 'undefined') {
				if(
					typeof(mg_galleria_h) == 'undefined' ||
					mg_galleria_h != new_slider_h || 
					$('.mg_galleria_slider_wrap').width() != $('.galleria-stage').width()
				) { 
					if(typeof(mg_slider_is_resizing) == 'undefined' || !mg_slider_is_resizing)  {
						mg_galleria_h = new_slider_h; 
						resize_galleria(new_slider_h);
					}
				}
			}
			
			// hook for customizations
			$(window).trigger('mg_lb_realtime_actions');
		}, 20);
	};



	////////////////////////////////////////////////



	// get URL query vars and returns them into an associative array
	var get_url_qvars = function() {
		mg_hashless_url = decodeURIComponent(window.location.href);
		
		if(mg_hashless_url.indexOf('#') !== -1) {
			var hash_arr = mg_hashless_url.split('#');
			mg_hashless_url = hash_arr[0];
			mg_url_hash = '#' + hash_arr[1];
		}
		
		// detect
		var qvars = {};
		var raw = mg_hashless_url.slice(mg_hashless_url.indexOf('?') + 1).split('&');
		
		$.each(raw, function(i, v) {
			var arr = v.split('=');
			qvars[arr[0]] = arr[1];
		});	
		
		return qvars;
	};
	
	
	// create slug from a string - for better deeplinked urls
	var string_to_slug = function(str) {
		str = str.replace(/^\s+|\s+$/g, ''); // trim
		str = str.toLowerCase();
		
		// remove accents, swap ñ for n, etc
		var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
		var to   = "aaaaeeeeiiiioooouuuunc------";
		for (var i=0, l=from.length ; i<l ; i++) {
		  str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
		}
		
		str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
		  .replace(/\s+/g, '-') // collapse whitespace and replace by -
		  .replace(/-+/g, '-'); // collapse dashes
		
		return str;
	}


	/*
	 * Global function to set media grid deeplinks
	 *
	 * key (string) - the subject - to know if it has to be deeplinked (item, category, search, page)
	 * subj (string) - attribute name
	 * val (int) - deeplink value (cat ID - item ID - etc)
	 * txt (string) - optional value to attach a text to value 
	 */
	mg_set_deeplink = function(key, subj, val, txt) {
		if(!mg_deeplinked_elems.length || $.inArray(key, mg_deeplinked_elems) === -1) {return false;}
		
		var qvars = get_url_qvars(); // get query vars and set clean URL + eventual hash 

		// setup deeplink part
		var true_val = (typeof(txt) != 'undefined' && txt) ? val +'/'+ string_to_slug(txt) : val;
		var dl_part = subj +'='+ true_val + mg_url_hash;
		
		
		// if URL doesn't have attributes
		if(mg_hashless_url.indexOf('?') === -1) {
			history.pushState(null, null, mg_hashless_url +'?'+ dl_part);
		}
		else {

			// if new deeplink already exists

			if(typeof(qvars[subj]) != 'undefined' && qvars[subj] == true_val) {
				return true;	
			}
			
			// re-compose URL
			var new_url = mg_hashless_url.slice(0, mg_hashless_url.indexOf('?') + 1);

			// (if found) discard attribute to be set
			var a = 0;
			var has_other_qvars = false;
			var this_attr_exists = false;
			
			$.each(qvars, function(i, v) {
				if(typeof(i) == 'undefined') {return;}
				if(a > 0) {new_url += '&';}
				
				if(i != subj) {
					new_url += (v) ? i+'='+v : i; 
					
					has_other_qvars = true;
					a++;	

				}
				else {
					this_attr_exists = true;	
				}
			});
				
			if(has_other_qvars) {new_url += '&';}		
			new_url += dl_part;


			if(mg_deeplinked && this_attr_exists && !mg_full_deeplinking) { 
				history.replaceState(null, null, new_url);
			} else {
				history.pushState(null, null, new_url);	
				mg_deeplinked = true;
			}
		}
	};


	// apply deeplink to page grids
	mg_apply_deeplinks = function(on_init) {
		var qvars = get_url_qvars();
		
		$.each(qvars, function(subj, val) {
			if(typeof(val) == 'undefined') {return;}
			var gid = subj.substr(4);
			
			// clean texts from deeplinked val
			var raw_val = val.split('/');
			val = raw_val[0]; 
			
			
			
			// at the moment - no actions on init except search
			if(!on_init) {
			
				// item deeplink - not on first init
				if(subj.indexOf('mgi_') !== -1) {
					
					// check item existence
					if(!$('#mg_grid_'+ gid +' .mg_closed.mgi_'+ val).length) {return;}
					
					// if lightbox is already opened
					if($('.mg_item_content').length) {
	
						// grid item is already shown?
						if($('#mg_lb_wrap').data('item-id') == val && $('#mg_lb_wrap').data('grid-id') == gid) {return;}
	
						// unload lightbox
						$mg_sel_grid = $('#mg_grid_'+gid);
						$('#mg_lb_loader').addClass('mg_lb_shown');
						mg_get_item_content(val);
					}
					
					else {
						// simulate click on item
						$('#mg_grid_'+ gid +' .mgi_'+ val).trigger('click');
					}
				}
				
				// category deeplink - not on first init
				if(subj.indexOf('mgc_') !== -1) {
					var $f_subj = (val == '*') ? $('#mgf_'+ gid +' .mgf_all') : $('#mgf_'+ gid +' .mgf_id_'+ val);
					
					// check filter existence
					if(!$f_subj.not('.mg_cats_selected').length) {return;}
					$f_subj.trigger('click');
				}
				
				// pagination deeplink - not on first init
				if(subj.indexOf('mgp_') !== -1 && $('#mgp_'+gid).length) {
					if(typeof(mg_grid_pag['mg_grid_' + gid ]) == 'undefined' || mg_grid_pag['mg_grid_' + gid ] == val) {return;}
					
					var subj = (mg_grid_pag['mg_grid_' + gid ] > val) ? '.mg_prev_page' : '.mg_next_page'; 
					$('#mgp_'+gid+' '+subj).not('.mg_pag_disabled').trigger('click');
				}
				
			}
				
			
			// search deeplink
			if(subj.indexOf('mgs_') !== -1) {
				if(typeof(on_init) == 'undefined') {
					$('#mgs_'+ gid+' input').val(decodeURIComponent(val)).submit();
				} else {
					setTimeout(function() {
						$('#mgs_'+ gid+' input').submit();
					}, 20);	
				}
			}
		});
		
				
		// step back from opened lightbox
		if(mg_hashless_url.indexOf('mgi_') === -1 && $('.mg_item_content').length) {
			$('.mg_close_lb').trigger('click');	
		}	
		
		// step back for each grid
		$('.mg_grid_wrap').each(function() {
			var gid = $(this).attr('id').substr(8);

			// from category deeplink
			var $mgc = $(this).find('.mg_cats_selected');
			if(mg_hashless_url.indexOf('mgc_'+gid) === -1 && $mgc.length && !$mgc.hasClass('mg_def_filter')) {
				$(this).find('.mg_def_filter').trigger('click');	
			}
			
			// from pagination
			if(mg_hashless_url.indexOf('mgp_'+gid) === -1 && $('#mgp_'+gid).length && $('#mgs_'+ gid+' input').val()) {
				mavo_to_pag_1(gid, $('#mgp_'+gid+' .mg_prev_page'));
			}
			
			// from search
			if(mg_hashless_url.indexOf('mgs_'+gid) === -1 && $('#mgs_'+gid).length && $('#mgs_'+ gid+' input').val()) {
				$('#mgs_'+ gid+' input').val('').submit();
			}
		});
	};
	
	
	// remove deeplink - check mg_set_deeplink() legend to know more about params
	mg_remove_deeplink = function(key, subj) {
		if(!mg_deeplinked_elems.length || $.inArray(key, mg_deeplinked_elems) === -1) {return false;}
		
		var qvars = get_url_qvars();
		if(typeof(qvars[subj]) == 'undefined') {return false;}
		
		// discard attribute to be removed
		var parts = [];
		$.each(qvars, function(i, v) {
			if(typeof(i) != 'undefined' && i && i != subj) {
				var val = (v) ? i+'='+v : i;
				parts.push(val);	
			}
		});
		
		var qm = (parts.length) ? '?' : '';	
		var new_url = mg_hashless_url.slice(0, mg_hashless_url.indexOf('?')) + qm + parts.join('&') + mg_url_hash;

		history.pushState(null, null, new_url);	
		
		if(mg_hashless_url.indexOf('mgi_') === -1 && mg_hashless_url.indexOf('mgc_') === -1 && mg_hashless_url.indexOf('mgp_') === -1 && mg_hashless_url.indexOf('mgs_') === -1) {
			mg_deeplinked = false;
		}	
	};
	
	
	// detect URL changes
	window.onpopstate = function(e) {
		mg_apply_deeplinks();
		
		if(mg_hashless_url.indexOf('mgi_') === -1 && mg_hashless_url.indexOf('mgc_') === -1 && mg_hashless_url.indexOf('mgp_') === -1 && mg_hashless_url.indexOf('mgs_') === -1) {
			mg_deeplinked = false;
		}
	};
	
	
	
	////////////////////////////////////////////////////////////////
	// initialize inline sliders 
	mg_inl_slider_init = function(sid) {
		$('#'+sid).lc_micro_slider({
			slide_fx 		: mg_inl_slider_fx,
			slide_easing	: mg_inl_slider_easing,
			touchswipe		: mg_inl_slider_touch,
			slideshow_cmd	: mg_inl_slider_play_btn,
			autoplay		: false,
			animation_time	: mg_inl_slider_fx_time,
			slideshow_time	: mg_inl_slider_intval,
			pause_on_hover	: mg_inl_slider_pause_on_h,
			loader_code		: mg_loader,
			nav_dots		: false,
			debug			: false
		});
		
		// autoplay here - to be run also on filters
		if( $('#'+sid).hasClass('mg_autoplay_slider') ) {
			$('#'+sid).lcms_start_slideshow();
		}
    };
	
	
	// turns item's image into a ken burns slider
	$.fn.mg_item_img_to_kenburns = function() {
		this.find('.mg_kenburnsed_item').lc_micro_slider({
			slideshow_time	: mg_kenburns_timing,
			pause_on_hover	: false,
			slideshow_cmd	: false,
			nav_dots		: false,
			nav_arrows		: false,
			loader_code		: mg_loader,
			debug			: false
		});
	};

	
	//// ken burns effect
	// catch event	
	$(document).ready(function() {
		$('body').delegate('.mg_kenburns_slider', 'lcms_initial_slide_shown lcms_new_active_slide', function(e, slide_index) {	
			var $subj = $(this).find('.lcms_slide[rel='+slide_index+'] .lcms_bg');
			var time = $(this).data('lcms_settings').slideshow_time;

			$subj.css('transition-duration', (time / 1000)+'s');	
			mg_lcms_apply_kenburns_css($subj, time);
		});
	});
	
	
	// apply css for kenburns
	var mg_lcms_apply_kenburns_css = function($subj, time) {
		if(!$subj.length) {return false;}
		
		vert_prop = mg_lcms_kenburns_size_prop('vert');
		horiz_prop = mg_lcms_kenburns_size_prop('horiz');
		var props = {};	
			
		if($subj.hasClass('mg_lcms_kb_zoomed')) {
			props['top']	= '0';
			props['right'] 	= '0';
			props['bottom'] = '0';
			props['left'] 	= '0';
				
			$subj.removeClass('mg_lcms_kb_zoomed');
		}
		else {
			props[ vert_prop ] 	= '-25%';
			props[ horiz_prop ] = '-25%';

			$subj.addClass('mg_lcms_kb_zoomed');
		}
		
		props['background-position'] = mg_lcms_kenburns_bgpos_prop() +' '+ mg_lcms_kenburns_bgpos_prop();
		$subj.css(props);
		
		setTimeout(function() {
			mg_lcms_apply_kenburns_css($subj, time, vert_prop, horiz_prop);
		}, time);
	};
	
	// get random value for random direction
	var mg_lcms_kenburns_size_prop = function(direction) {
	   var vals = (direction == 'horiz') ? ["left", "right"] : ["top", "bottom"];
	   return vals[Math.floor(Math.random() * vals.length)];
	};
	
	var mg_lcms_kenburns_bgpos_prop = function() {
	   var vals = ['0%', '100%'];
	   return vals[Math.floor(Math.random() * vals.length)];
	};
	
	


	///////////////////////////////////////////////////////////////////////////
	// galleria slider functions

	// manage slider initial appearance
	mg_galleria_show = function(sid) {
		setTimeout(function() {
			if( $(sid+' .galleria-stage').length) {
				$(sid).removeClass('mg_show_loader');
				$(sid+' .galleria-container').fadeTo(400, 1);
			} else {
				mg_galleria_show(sid);
			}
		}, 50);
	};


	// manage the slider proportions on resize
	mg_galleria_height = function(sid) {
		if( $(sid).hasClass('mg_galleria_responsive')) {
			return parseFloat( $(sid).data('asp-ratio') );
		} else {
			return parseInt($(sid).data('slider-h'));
		}
	};


	var resize_galleria = function(new_h) {
		mg_slider_is_resizing = setTimeout(function() {
			$('.mg_galleria_slider_wrap, .galleria-container').css('min-height', new_h);
			
			setTimeout(function() {
				mg_lb_slider.resize();	
			}, 500);
			
			mg_slider_is_resizing = false;
		}, 20);

	};



	// Initialize Galleria
	mg_galleria_init = function(sid, inline_slider) {
		Galleria.run(sid, {
			theme				: 'mediagrid',
			height				: ($('.mg_lb_feat_match_txt').length && $(window).width() > 860) ? $('.mg_item_content').outerHeight() : mg_galleria_height(sid),
			swipe				: true,
			thumbnails			: true,
			transition			: mg_galleria_fx,
			fullscreenDoubleTap	: false,
			responsive			: false,
			wait				: true,

			initialTransition	: 'flash',
			transitionSpeed		: mg_galleria_fx_time,
			imageCrop			: mg_galleria_img_crop,
			extend				: function() {
				mg_lb_slider = this;
				$(sid+' .galleria-loader').append(mg_loader);

				if(typeof(mg_slider_autoplay[sid]) != 'undefined' && mg_slider_autoplay[sid]) {
					$(sid+' .galleria-mg-play').addClass('galleria-mg-pause');
					mg_lb_slider.play(mg_galleria_interval);
				}

				// play-pause
				$(sid+' .galleria-mg-play').click(function() {
					$(this).toggleClass('galleria-mg-pause');
					mg_lb_slider.playToggle(mg_galleria_interval);
				});

				// thumbs navigator toggle
				$(sid+' .galleria-mg-toggle-thumb').click(function() {
					var $mg_slider_wrap = $(this).parents('.mg_galleria_slider_wrap');


					if( $mg_slider_wrap.hasClass('galleria-mg-show-thumbs') || $mg_slider_wrap.hasClass('mg_galleria_slider_show_thumbs') ) {
						$mg_slider_wrap.stop().animate({'padding-bottom' : '0px'}, 400);
						$mg_slider_wrap.find('.galleria-thumbnails-container').stop().animate({'bottom' : '10px', 'opacity' : 0}, 400);

						$mg_slider_wrap.removeClass('galleria-mg-show-thumbs');
						if( $mg_slider_wrap.hasClass('mg_galleria_slider_show_thumbs') ) {
							$mg_slider_wrap.removeClass('mg_galleria_slider_show_thumbs');
						}
					}
					else {
						$mg_slider_wrap.stop().animate({'padding-bottom' : '56px'}, 400);
						$mg_slider_wrap.find('.galleria-thumbnails-container').stop().animate({'bottom' : '-60px', 'opacity' : 1}, 400);

						$mg_slider_wrap.addClass('galleria-mg-show-thumbs');
					}
				});
			}
		});
	};
	
	
	// hide caption if play a slider video
	$(document).ready(function() {
		$('body').delegate('.mg_galleria_slider_wrap .galleria-images', 'click', function(e) {
			setTimeout(function() {
				if( $('.mg_galleria_slider_wrap .galleria-image:first-child .galleria-frame').length) {
					$('.mg_galleria_slider_wrap .galleria-stage .galleria-info-text').slideUp();	
				}
			}, 500);
		});
	});



	//////////////////////////////////////////////////////////////////
	// mediaelement audio/video player functions

	// init video player
	mg_video_player = function(player_id, is_inline) {
		if(!$(player_id).length) {return false;}
		
		// wait until mediaelement script is loaded
		if(typeof(MediaElementPlayer) != 'function') {
			setTimeout(function() {
				mg_video_player(player_id, is_inline);
			}, 50);
			return false;
		}

		if(typeof(is_inline) == 'undefined') {
			var features = ['playpause','current','progress','duration','volume','fullscreen'];
		} else {
			var features = ['playpause','current','progress','volume','fullscreen'];
		}
		
		var player_obj = new MediaElementPlayer(player_id+' video',{
			audioVolume: 'vertical',
			startVolume: 1,
			features: features
		});
		
		mg_player_objects[player_id] = player_obj;
		
		// autoplay
		if($(player_id).hasClass('mg_video_autoplay')) {
			if(typeof(is_inline) == 'undefined') {
				player_obj.play();
			} 
			else {
				setTimeout(function() {
					if(!$(player_id).parents('.mg_box').hasClass('isotope-hidden')) {
						var delay = setInterval(function() {
							if($(player_id).parents('.mg_box').hasClass('mg_shown')) {
								player_obj.play();	
								clearInterval(delay);
							}
						}, 50);
					}
				}, 100);
			}
		}
	};


	// store player playlist and the currently played track - init player
	mg_audio_player = function(player_id, is_inline) {
		
		// wait until mediaelement script is loaded
		if(typeof(MediaElementPlayer) != 'function') {
			setTimeout(function() {
				mg_audio_player(player_id, is_inline);
			}, 50);
			return false;
		}
		
		// if has multiple tracks
		if($(player_id).find('source').length > 1) {

			mg_audio_tracklists[player_id] = [];
			$(player_id).find('source').each(function(i, v) {
                mg_audio_tracklists[player_id].push( $(this).attr('src') );
            });

			if(typeof(is_inline) == 'undefined') {
				var features = ['mg_prev','playpause','mg_next','current','progress','duration','mg_loop','volume','mg_tracklist'];
			} else {
				var features = ['mg_prev','playpause','mg_next','current','progress','mg_loop','volume','mg_tracklist'];
			}

			var success_function = function (player, domObject) {
				player.addEventListener('ended', function (e) {
					var player_id = '#' + $(this).parents('.mg_me_player_wrap').attr('id');
					mg_audio_go_to(player_id, 'next', true);
				}, false);
			};
		}

		else {
			var features = ['playpause','current','progress','duration','mg_loop','volume'];
			var success_function = function() {};
		}


		// init
		var player_obj = new MediaElementPlayer(player_id+' audio',{
			audioVolume: 'vertical',
			startVolume: 1,
			features: features,
			loop: mg_audio_loop,
			success: success_function,
			alwaysShowControls: true
		});

		mg_player_objects[player_id] = player_obj;
		mg_audio_is_playing[player_id] = 0;

		// autoplay
		if($(player_id).hasClass('mg_audio_autoplay')) {
			player_obj.play();
		}
	};


	// go to track - prev / next / track_num
	mg_audio_go_to = function(player_id, direction, autonext) {
		var t_list = mg_audio_tracklists[player_id];
		var curr = mg_audio_is_playing[player_id];


		if(direction == 'prev') {
			var track_num = (!curr) ? (t_list.length - 1) : (curr - 1);
			var track_url = t_list[track_num];
			mg_audio_is_playing[player_id] = track_num;
		}
		else if(direction == 'next') {
			// if hasn't tracklist and loop is disabled, stop
			if(typeof(autonext) != 'undefined' && !$(player_id+' .mejs-mg-loop-on').length) {
				return false;
			}

			var track_num = (curr == (t_list.length - 1)) ? 0 : (curr + 1);
			var track_url = t_list[track_num];
			mg_audio_is_playing[player_id] = track_num;
		}
		else {
			var track_url = t_list[(direction - 1)];
			mg_audio_is_playing[player_id] = (direction - 1);
		}

		// set player to that url
		var $subj = mg_player_objects[player_id];
		$subj.pause();
		$subj.setSrc(track_url);
		$subj.play();

		// set tracklist current track
		$(player_id +'-tl li').removeClass('mg_current_track');
		$(player_id +'-tl li[rel='+ (mg_audio_is_playing[player_id] + 1) +']').addClass('mg_current_track');
	};
	
	
	// initialize inline audio player
	var init_inl_audio = function(player_id, autoplay) {
		mg_audio_player(player_id, true);
		
		$(player_id).addClass('mg_inl_audio_shown');
		
		// enable playlist
		if($(player_id+'-tl').length) {
			$(player_id+'-tl').show();	
		}
		
		// autoplay
		setTimeout(function() {
			mg_check_inl_audio_icons_vis();
			
			if(typeof(autoplay) != 'undefined') {
				var player_obj = mg_player_objects[player_id];
				player_obj.play();		
			}
		}, 300);
	};
	

	// add custom mediaelement buttons
	$(document).ready(function(e) {
		mg_mediael_add_custom_functions();
	});
	
	var mg_mediael_add_custom_functions = function() {
		
		// wait until mediaelement script is loaded
		if(typeof(MediaElementPlayer) != 'function') {
			setTimeout(function() {
				mg_mediael_add_custom_functions();
			}, 50);
			return false;
		}
		
		
		// prev
		MediaElementPlayer.prototype.buildmg_prev = function(player, controls, layers, media) {
			var prev = $('<div class="mejs-button mejs-mg-prev" title="previous track"><button type="button"></button></div>')
			// append it to the toolbar
			.appendTo(controls)
			// add a click toggle event
			.click(function() {
				var player_id = '#' + $('#'+player.id).parent().attr('id');
				mg_audio_go_to(player_id, 'prev');
			});
		}

		// next
		MediaElementPlayer.prototype.buildmg_next = function(player, controls, layers, media) {
			var prev = $('<div class="mejs-button mejs-mg-next" title="previous track"><button type="button"></button></div>')
			// append it to the toolbar
			.appendTo(controls)
			// add a click toggle event
			.click(function() {
				var player_id = '#' + $('#'+player.id).parent().attr('id');
				mg_audio_go_to(player_id, 'next');
			});
		}

		// tracklist toggle
		MediaElementPlayer.prototype.buildmg_tracklist = function(player, controls, layers, media) {
			var tracklist =
			$('<div class="mejs-button mejs-mg-tracklist-button ' +
				(($('#'+player.id).parent().hasClass('mg_show_tracklist')) ? 'mejs-mg-tracklist-on' : 'mejs-mg-tracklist-off') + '" title="'+
				(($('#'+player.id).parent().hasClass('mg_show_tracklist')) ? 'hide' : 'show') +' tracklist"><button type="button"></button></div>')
			// append it to the toolbar
			.appendTo(controls)
			// add a click toggle event
			.click(function() {
				if ($('#'+player.id).find('.mejs-mg-tracklist-on').length) {
					$('#'+player.id).parents('.mg_media_wrap').find('.mg_audio_tracklist').removeClass('mg_iat_shown');
					tracklist.removeClass('mejs-mg-tracklist-on').addClass('mejs-mg-tracklist-off').attr('title', 'show tracklist');
				} 
				else {
					$('#'+player.id).parents('.mg_media_wrap').find('.mg_audio_tracklist').addClass('mg_iat_shown');
					tracklist.removeClass('mejs-mg-tracklist-off').addClass('mejs-mg-tracklist-on').attr('title', 'hide tracklist');
				}
			});
		}

		// loop toggle
		MediaElementPlayer.prototype.buildmg_loop = function(player, controls, layers, media) {
			var loop =
			$('<div class="mejs-button mejs-mg-loop-button ' +
				((player.options.loop) ? 'mejs-mg-loop-on' : 'mejs-mg-loop-off') + '" title="'+
				((player.options.loop) ? 'disable' : 'enable') +' loop"><button type="button"></button></div>')
			// append it to the toolbar
			.appendTo(controls)
			// add a click toggle event
			.click(function() {
				player.options.loop = !player.options.loop;
				if (player.options.loop) {
					loop.removeClass('mejs-mg-loop-off').addClass('mejs-mg-loop-on').attr('title', 'disable loop');
				} else {
					loop.removeClass('mejs-mg-loop-on').addClass('mejs-mg-loop-off').attr('title', 'enable loop');
				}
			});
		}
	};


	// change track clicking on tracklist
	$(document).ready(function(e) {
        $(document).delegate('.mg_audio_tracklist li:not(.mg_current_track)', 'click'+mg_generic_touch_event, function() {
			var player_id = '#' + $(this).parents('ol').attr('id').replace('-tl', '');
			var num = $(this).attr('rel');

			mg_audio_go_to(player_id, num);
		});
    });

	
	// pause inline players and inl text's video bg and sliders
	mg_pause_inl_players = function(grid_id) {
		var $subj = $('#'+ grid_id+' .mg-muuri-hidden, #'+ grid_id+' .mgi_low_opacity_f');
		
		// audio/video player
		$subj.find('.mg_sh_inl_video, .mg_inl_audio_player').each(function() {
			if( typeof(mg_player_objects) != 'undefined' && typeof( mg_player_objects[ '#' + this.id ] ) != 'undefined') {
				var $subj = mg_player_objects[ '#' + this.id ];
				$subj.pause();
			}
		});	
		
		// inline text's video bg
		$subj.find('.mg_inl_txt_video_bg').each(function() {
			var video = jQuery(this)[0];
			video.pause();
		});	
		
		// inline slider
		$subj.find('.mg_inl_slider_wrap').each(function() { 
		   $('#'+ $(this).attr('id') ).lcms_stop_slideshow();
        });
	};

	
	// adjust players size
	var mg_adjust_inl_player_size = function(item_id) {
		var $subj = (typeof(item_id) != 'undefined') ? $(item_id) : $('.mg_inl_audio_player, .mg_sh_inl_video');
		mg_check_inl_audio_icons_vis();
		
		$subj.each(function() {
			if(typeof(mg_player_objects) != 'undefined' && typeof(mg_player_objects[ '#' + this.id ]) != 'undefined') {
				
				var player = mg_player_objects[ '#' + this.id ];
				player.setControlsSize();
			}
		});	
	};
	
	
	// hide audio player commands in tiny items
	var mg_check_inl_audio_icons_vis = function() {
		$('.mg_inl_audio').not('.mg-muuri-hidden').each(function() {
			if( $(this).find('.img_wrap').width() >= 195) {
				$(this).find('.img_wrap > div').css('overflow', 'visible');	
			} else {
				$(this).find('.img_wrap > div').css('overflow', 'hidden');	
			}
		});
	};
	



	/////////////////////////////////////////////////////////////
	// UTILITIES

	function mg_responsive_txt(gid) {
		var $subj = $('#'+gid+ ' .mg_inl_txt_rb_txt_resize .mg_inl_txt_contents').find('p, b, div, span, strong, em, i, h6, h5, h4, h3, h2, h1');

		// setup original text sizes and reset
		$('#'+gid+' .mg_inl_txt_wrap').removeClass('mg_it_resized');
		$subj.each(function() {
			if(typeof( $(this).data('orig-size') ) == 'undefined') {
				$(this).data('orig-size', $(this).css('font-size'));
				$(this).data('orig-lheight', $(this).css('line-height'));
			}

			// reset
			$(this).removeClass('mg_min_reached mg_inl_txt_top_margin_fix mg_inl_txt_btm_margin_fix mg_inl_txt_top_padding_fix mg_inl_txt_btm_padding_fix');
			$(this).css('font-size', $(this).data('orig-size'));
			$(this).css('line-height', $(this).data('orig-lheight'));
        });

		$('#'+gid+ ' .mg_inl_txt_contents').each(function() {

			// not for auto-height
			if(
				(!mg_mobile_mode[gid] && !$(this).parents('.mg_box').hasClass('mgis_h_auto')) ||
				(mg_mobile_mode[gid] && !$(this).parents('.mg_box').hasClass('mgis_m_h_auto'))
			) {
				var max_height = $(this).parents('.mg_media_wrap').height();

				if(max_height < $(this).outerHeight()) {
					$('#'+gid+' .mg_inl_txt_wrap').addClass('mg_it_resized');
					
					var a = 0;
					while( max_height < $(this).outerHeight()) {
						if(a == 0) {
							// check and eventually reduce big margins and paddings at first
							$subj.each(function(i, v) {
								if( parseInt($(this).css('margin-top')) > 10 ) {$(this).addClass('mg_inl_txt_top_margin_fix');}
								if( parseInt($(this).css('margin-bottom')) > 10 ) {$(this).addClass('mg_inl_txt_btm_margin_fix');}

								if( parseInt($(this).css('padding-top')) > 10 ) {$(this).addClass('mg_inl_txt_top_padding_fix');}
								if( parseInt($(this).css('padding-bottom')) > 10 ) {$(this).addClass('mg_inl_txt_btm_padding_fix');}
							});
						}
						else {
							$subj.each(function(i, v) {
								var new_size = parseFloat( $(this).css('font-size')) - 1;
								if(new_size < 11) {new_size = 11;}

								var new_lheight = parseInt( $(this).css('line-height')) - 1;
								if(new_lheight < 14) {new_lheight = 14;}

								$(this).css('font-size', new_size).css('line-height', new_lheight+'px');

								if(new_size == 11 && new_lheight == 14) { // resizing limits
									$(this).addClass('mg_min_reached');
								}
							});

							// if any element has reached min size
							if( $('#'+gid+ ' .mg_inl_txt_contents .mg_min_reached').length ==  $subj.length) {
								return false;
							}
						}

						a++;
					}
				}
			}
        });
	};


	// webkit transformed items rendering fix
	var webkit_blurred_elems_fix = function(grid_id) {
		if('WebkitAppearance' in document.documentElement.style) {
			$('#mg_wbe_fix_'+grid_id).remove();
	
			setTimeout(function() {
				$('head').append('<style type="text/css" id="mg_wbe_fix_'+ grid_id +'">.mg_'+grid_id+' .mg_box_inner {-webkit-font-smoothing: subpixel-antialiased;}</style>');
			}, 600);
		}
	};


	// check for touch device
	function mg_is_touch_device() {
		return !!('ontouchstart' in window);
	};


	// check if the browser is IE8 or older
	function mg_is_old_IE() {
		if( navigator.appVersion.indexOf("MSIE 8.") != -1 ) {return true;}
		else {return false;}
	};
	
	
	// facebook direct contents share
	mg_fb_direct_share = function(url, title, txt, img) {
		FB.ui({
			method: 'share_open_graph',
			action_type: 'og.shares',
			action_properties: JSON.stringify({
				object: {
					'og:url'		: url,
					'og:title'		: title,
					'og:description': txt,
					'og:image'		: img,
				}
			})
		},
		function (response) {
			window.close();
		});			
	};

})(jQuery);