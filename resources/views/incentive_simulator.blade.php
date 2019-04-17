@extends('layouts.main')

@section('content')
<style type="text/css">
	
/******************Simulator css*****************/
.user-dashboard {
    background: #00adee;
    width: 100%;
    float: left;
    padding: 15px;
}
.user-dashboard img{
    width: 55px;
    height: 55px;
    float: left;
    border-radius: 50%;
    border: 2px solid #fff;
}
.details {
    width: 60%;
    float: left;
    margin-left: 15px;
}
.details h2 {
    margin-top: 0;
    font-size: 17px;
    font-weight: 600;
    color: #fff;
}
.details p {
    font-size: 10px;
    line-height: 8px;
    color: #fff;
}
.table-area {

    background: #fff;
    width: 98%;
    margin: 0 auto;
    box-shadow: 1px 1px 5px 2px #ccc;
    border-radius: 5px;

}
.user-data-main h2 {

    text-align: center;
    padding: 50px 0;
    margin-top: 0;
    color: #045059;
    font-weight: 700;
    text-transform: uppercase;

}
.total-tb {

    width: 100%;
    background: #00adee;
    border: none;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;

}
.total-tb > th, .total-tb > td {

    border: none !important;
    color: #fff !important;
    font-weight: 600 !important;
    font-size: 17px !important;

}
.table
{
    margin-bottom: 0 !important;
}
.user-data-main {
    width: 100%;
    float: left;
    padding: 0 0 30px;
}
.user-data-main .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
    border-bottom-width: 2px;
    color: #045059;
    font-size: 14px;
    text-transform: uppercase;
}
.user-data-main .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th{
    color: #045059;
    font-size: 12px;
}
.heading-tb > th {
    font-size: 16px !important;
    padding: 15px 9px !important;
}

/************range slider***********/
.rangeslider,
.rangeslider__fill {
    display:block;
    border-radius:10px;
}

.rangeslider {
    position:relative;
}
.rangeslider:after{
    top:50%;
    left:0;
    right:0;
    content:'';
    width:100%;
    height:5px;
    margin-top:-2.5px;
    border-radius:5px;
    position:absolute;
    background:#00adee66;
}

.rangeslider--horizontal{
    width:100%;
    height:28px;
}

.rangeslider--vertical{
    width:5px;
    min-height:150px;
    max-height:100%;
}
.rangeslider--disabled{
    filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=40);
    opacity:0.4;
}

.rangeslider__fill{
    position:absolute;
    background:#00adee;
}
.rangeslider--horizontal .rangeslider__fill{
    top:0;
    height:100%;
}
.rangeslider--vertical .rangeslider__fill{
    bottom:0;
    width:100%;
}

.rangeslider__handle{
    top:50%;
    width:28px;
    height:28px;
    cursor:pointer;
    margin-top:-14px;
    background:white;
    position:absolute;
    background:#00adee;
    border-radius:50%;
    display:inline-block;
}
.rangeslider__handle:active{
    background:#00adee;
}

.rangeslider__fill,
.rangeslider__handle{
    z-index:1;
}
.rangeslider--horizontal .rangeslider__fill{
    top:50%;
    height:5px;
    margin-top:-2.5px;
}

/* Budget */

.budget-wrap .header .title{
    color:#fff;
    font-size:18px;
    
}
.budget-wrap .header .title .pull-right{
     font-size: 14px;
    color: #045059;
    font-weight: 600;
}
.budget-wrap .footer{
    margin-top:30px;
}
.budget-wrap .footer .btn{
    color:inherit;
    padding:12px 24px;
    border-radius:50px;
    display:inline-block;
    text-decoration:none;
}
.budget-wrap .footer .btn.btn-def{
    color:#525263;
}
.budget-wrap .footer .btn.btn-pri{
    color:#eee;
    background:#ff5a84;
}
.budget img {
    width: 40px;
    height: 40px;
    float: left;
    border-radius: 50%;
    border: 2px solid #00adee;
}
.content {
    float: left;
    width: 100%;
    padding: 5px 0 5px;
}
.budget-wrap {
    width: 100%;
    display: inline-block;
    padding: 17px;
}
.budget-wrap .title.clearfix p {
    font-size: 14px;
    color: #045059;
    font-weight: 600;
    float: left;
}
.budget-wrap .header {
    float: left;
    width: 100%;
}
.budget-wrap .title.clearfix {
    float: right;
}
.title-brand {
    float: left;
    margin-left: 12px;
    padding: 11px 0;
}
.title-brand h3{
    margin-top: 0;
}
.left-value {
    float: left;
}
.left-value p {

    font-size: 14px;
    color: #045059;
    font-weight: 600;

}
.table-range {
    padding: 24px 0 0;
}
.rg-head-bg {

    width: 100%;
    padding: 16px 25px;
    background: #eee;

}
.range-head h3 {

    font-size: 20px;
    margin: 0;
    color: #045059;
    font-weight: 600;

}
.title-brand h3{
    font-size: 15px;
    margin: 0;
    color: #045059;
    font-weight: 600;

}
/**********rabge slider end**********/

.total-range{
    width: 100%;
    float: left;
    background:#00adee;
    padding: 0px 25px;
}
.total-range h4{
    float: left;
    color: #fff;
    font-weight: 600;
    font-size: 20px;
}
.total-range h3{
    float: right;
    color: #fff;
    font-weight: 600;
    font-size: 20px;
    margin-top: 8px;
}
</style>

    <div class="row">
        <div class="user-dashboard">
            <div class="user-details">
                <img src="{{ asset('public/images/client.png') }}">
                <span class="details">
                    <h2> MR. PUSHPENDRA DUTT</h2>
                    <p>DESG: BE ,HQ TYPE: METRO , DIVISION: PHARMA ,ZONE: WEST</p>
                    <p>REGION: GWALIOR ,AREA: GUNA , TERRITORY: SHIVPURI</p>
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="user-data-main">
            <h2>Incentive Simulator </h2>
            <div class="table-area table-range">
                <div class="range-area">
                    <div class="budget-wrap">
                        <div class="budget">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                            <img src="{{ asset('public/images/medicine.png') }}">
                            <div class="title-brand">
                                <h3>Quarterly (QTR-1)</h3>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="content">
                                <input type="range" min="350" max="2500" value="1500" data-rangeslider>
                            </div>
                            <div class="header">
                                <span class="left-value">
                                    <p>Value 732000</p>
                                </span>
                                <div class="title clearfix"><p>Rs</p><span class="pull-right"></span></div>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="rg-head-bg">
                    <div class="row">
                       <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                           <div class="range-head">
                                <h3>Brand</h3>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                           <div class="range-head">
                                <h3>On Achievement of PMPT Units</h3>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="budget-wrap">
                        <div class="budget">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <img src="{{ asset('public/images/medicine.png') }}">
                            <div class="title-brand">
                                <h3>ACERA</h3>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="content">
                                <input type="range" min="350" max="2500" value="750" data-rangeslider>
                            </div>
                            <div class="header">
                                <span class="left-value">
                                    <p>Unit 250</p>
                                </span>
                                <div class="title clearfix"><p>Rs</p><span class="pull-right"></span></div>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>

                    <div class="budget-wrap">
                        <div class="budget">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                            <img src="{{ asset('public/images/medicine.png') }}">
                            <div class="title-brand">
                                <h3>AZIBACT</h3>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="content">
                                <input type="range" min="350" max="2500" value="900" data-rangeslider>
                            </div>
                            <div class="header">
                                <span class="left-value">
                                    <p>Unit 300</p>
                                </span>
                                <div class="title clearfix"><p>Rs</p><span class="pull-right"></span></div>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="budget-wrap">
                        <div class="budget">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                            <img src="{{ asset('public/images/medicine.png') }}">
                            <div class="title-brand">
                                <h3>ELECTROSIP</h3>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="content">
                                <input type="range" min="350" max="2500" value="600" data-rangeslider>
                            </div>
                            <div class="header">
                                <span class="left-value">
                                    <p>Unit 200</p>
                                </span>
                                <div class="title clearfix"><p>Rs</p><span class="pull-right"></span></div>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>
                   <div class="budget-wrap">
                        <div class="budget">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                            <img src="{{ asset('public/images/medicine.png') }}">
                            <div class="title-brand">
                                <h3>SOLVIN</h3>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="content">
                                <input type="range" min="350" max="2500" value="900" data-rangeslider>
                            </div>
                            <div class="header">
                                <span class="left-value">
                                    <p>Unit 300</p>
                                </span>
                                <div class="title clearfix"><p>Rs</p><span class="pull-right"></span></div>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="budget-wrap">
                        <div class="budget">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                            <img src="{{ asset('public/images/medicine.png') }}">
                            <div class="title-brand">
                                <h3>PERISET</h3>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="content">
                                <input type="range" min="350" max="2500" value="630" data-rangeslider>
                            </div>
                            <div class="header">
                                <span class="left-value">
                                    <p>Unit 210</p>
                                </span>
                                <div class="title clearfix"><p>Rs</p><span class="pull-right"></span></div>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="budget-wrap">
                        <div class="budget">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                            <img src="{{ asset('public/images/medicine.png') }}">
                            <div class="title-brand">
                                <h3>RXPLUS</h3>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="content">
                                <input type="range" min="350" max="2500" value="960" data-rangeslider>
                            </div>
                            <div class="header">
                                <span class="left-value">
                                    <p>Unit 320</p>
                                </span>
                                <div class="title clearfix"><p>Rs</p><span class="pull-right"></span></div>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="budget-wrap">
                        <div class="budget">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                            <img src="{{ asset('public/images/medicine.png') }}">
                            <div class="title-brand">
                                <h3>VINICOR</h3>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="content">
                                <input type="range" min="350" max="2500" value="300" data-rangeslider>
                            </div>
                            <div class="header">
                                <span class="left-value">
                                    <p>Unit 100</p>
                                </span>
                                <div class="title clearfix"><p>Rs</p><span class="pull-right"></span></div>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="budget-wrap">
                        <div class="budget">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                            <img src="{{ asset('public/images/medicine.png') }}">
                            <div class="title-brand">
                                <h3>ZERODOL</h3>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="content">
                                <input type="range" min="350" max="2500" value="540" data-rangeslider>
                            </div>
                            <div class="header">
                                <span class="left-value">
                                    <p>Unit 180</p>
                                </span>
                                <div class="title clearfix"><p>Rs</p><span class="pull-right"></span></div>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="budget-wrap">
                        <div class="budget">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4">
                            <img src="{{ asset('public/images/medicine.png') }}">
                            <div class="title-brand">
                                <h3>RAPICLAV</h3>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                            <div class="content">
                                <input type="range" min="350" max="2500" value="900" data-rangeslider>
                            </div>
                            <div class="header">
                                <span class="left-value">
                                    <p>Unit 300</p>
                                </span>
                                <div class="title clearfix"><p>Rs</p><span class="pull-right"></span></div>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="total-range">
                                <h4>Total</h4>
                                <h3>Rs 28440</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--RAnge slider js-->
    <script>
      /*! rangeslider.js - v2.1.1 | (c) 2016 @andreruffert | MIT license | https://github.com/andreruffert/rangeslider.js */
!function(a){"use strict";"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?module.exports=a(require("jquery")):a(jQuery)}(function(a){"use strict";function b(){var a=document.createElement("input");return a.setAttribute("type","range"),"text"!==a.type}function c(a,b){var c=Array.prototype.slice.call(arguments,2);return setTimeout(function(){return a.apply(null,c)},b)}function d(a,b){return b=b||100,function(){if(!a.debouncing){var c=Array.prototype.slice.apply(arguments);a.lastReturnVal=a.apply(window,c),a.debouncing=!0}return clearTimeout(a.debounceTimeout),a.debounceTimeout=setTimeout(function(){a.debouncing=!1},b),a.lastReturnVal}}function e(a){return a&&(0===a.offsetWidth||0===a.offsetHeight||a.open===!1)}function f(a){for(var b=[],c=a.parentNode;e(c);)b.push(c),c=c.parentNode;return b}function g(a,b){function c(a){"undefined"!=typeof a.open&&(a.open=a.open?!1:!0)}var d=f(a),e=d.length,g=[],h=a[b];if(e){for(var i=0;e>i;i++)g[i]=d[i].style.cssText,d[i].style.setProperty?d[i].style.setProperty("display","block","important"):d[i].style.cssText+=";display: block !important",d[i].style.height="0",d[i].style.overflow="hidden",d[i].style.visibility="hidden",c(d[i]);h=a[b];for(var j=0;e>j;j++)d[j].style.cssText=g[j],c(d[j])}return h}function h(a,b){var c=parseFloat(a);return Number.isNaN(c)?b:c}function i(a){return a.charAt(0).toUpperCase()+a.substr(1)}function j(b,e){if(this.$window=a(window),this.$document=a(document),this.$element=a(b),this.options=a.extend({},n,e),this.polyfill=this.options.polyfill,this.orientation=this.$element[0].getAttribute("data-orientation")||this.options.orientation,this.onInit=this.options.onInit,this.onSlide=this.options.onSlide,this.onSlideEnd=this.options.onSlideEnd,this.DIMENSION=o.orientation[this.orientation].dimension,this.DIRECTION=o.orientation[this.orientation].direction,this.DIRECTION_STYLE=o.orientation[this.orientation].directionStyle,this.COORDINATE=o.orientation[this.orientation].coordinate,this.polyfill&&m)return!1;this.identifier="js-"+k+"-"+l++,this.startEvent=this.options.startEvent.join("."+this.identifier+" ")+"."+this.identifier,this.moveEvent=this.options.moveEvent.join("."+this.identifier+" ")+"."+this.identifier,this.endEvent=this.options.endEvent.join("."+this.identifier+" ")+"."+this.identifier,this.toFixed=(this.step+"").replace(".","").length-1,this.$fill=a('<div class="'+this.options.fillClass+'" />'),this.$handle=a('<div class="'+this.options.handleClass+'" />'),this.$range=a('<div class="'+this.options.rangeClass+" "+this.options[this.orientation+"Class"]+'" id="'+this.identifier+'" />').insertAfter(this.$element).prepend(this.$fill,this.$handle),this.$element.css({position:"absolute",width:"1px",height:"1px",overflow:"hidden",opacity:"0"}),this.handleDown=a.proxy(this.handleDown,this),this.handleMove=a.proxy(this.handleMove,this),this.handleEnd=a.proxy(this.handleEnd,this),this.init();var f=this;this.$window.on("resize."+this.identifier,d(function(){c(function(){f.update(!1,!1)},300)},20)),this.$document.on(this.startEvent,"#"+this.identifier+":not(."+this.options.disabledClass+")",this.handleDown),this.$element.on("change."+this.identifier,function(a,b){if(!b||b.origin!==f.identifier){var c=a.target.value,d=f.getPositionFromValue(c);f.setPosition(d)}})}Number.isNaN=Number.isNaN||function(a){return"number"==typeof a&&a!==a};var k="rangeslider",l=0,m=b(),n={polyfill:!0,orientation:"horizontal",rangeClass:"rangeslider",disabledClass:"rangeslider--disabled",horizontalClass:"rangeslider--horizontal",verticalClass:"rangeslider--vertical",fillClass:"rangeslider__fill",handleClass:"rangeslider__handle",startEvent:["mousedown","touchstart","pointerdown"],moveEvent:["mousemove","touchmove","pointermove"],endEvent:["mouseup","touchend","pointerup"]},o={orientation:{horizontal:{dimension:"width",direction:"left",directionStyle:"left",coordinate:"x"},vertical:{dimension:"height",direction:"top",directionStyle:"bottom",coordinate:"y"}}};return j.prototype.init=function(){this.update(!0,!1),this.onInit&&"function"==typeof this.onInit&&this.onInit()},j.prototype.update=function(a,b){a=a||!1,a&&(this.min=h(this.$element[0].getAttribute("min"),0),this.max=h(this.$element[0].getAttribute("max"),100),this.value=h(this.$element[0].value,Math.round(this.min+(this.max-this.min)/2)),this.step=h(this.$element[0].getAttribute("step"),1)),this.handleDimension=g(this.$handle[0],"offset"+i(this.DIMENSION)),this.rangeDimension=g(this.$range[0],"offset"+i(this.DIMENSION)),this.maxHandlePos=this.rangeDimension-this.handleDimension,this.grabPos=this.handleDimension/2,this.position=this.getPositionFromValue(this.value),this.$element[0].disabled?this.$range.addClass(this.options.disabledClass):this.$range.removeClass(this.options.disabledClass),this.setPosition(this.position,b)},j.prototype.handleDown=function(a){if(this.$document.on(this.moveEvent,this.handleMove),this.$document.on(this.endEvent,this.handleEnd),!((" "+a.target.className+" ").replace(/[\n\t]/g," ").indexOf(this.options.handleClass)>-1)){var b=this.getRelativePosition(a),c=this.$range[0].getBoundingClientRect()[this.DIRECTION],d=this.getPositionFromNode(this.$handle[0])-c,e="vertical"===this.orientation?this.maxHandlePos-(b-this.grabPos):b-this.grabPos;this.setPosition(e),b>=d&&b<d+this.handleDimension&&(this.grabPos=b-d)}},j.prototype.handleMove=function(a){a.preventDefault();var b=this.getRelativePosition(a),c="vertical"===this.orientation?this.maxHandlePos-(b-this.grabPos):b-this.grabPos;this.setPosition(c)},j.prototype.handleEnd=function(a){a.preventDefault(),this.$document.off(this.moveEvent,this.handleMove),this.$document.off(this.endEvent,this.handleEnd),this.$element.trigger("change",{origin:this.identifier}),this.onSlideEnd&&"function"==typeof this.onSlideEnd&&this.onSlideEnd(this.position,this.value)},j.prototype.cap=function(a,b,c){return b>a?b:a>c?c:a},j.prototype.setPosition=function(a,b){var c,d;void 0===b&&(b=!0),c=this.getValueFromPosition(this.cap(a,0,this.maxHandlePos)),d=this.getPositionFromValue(c),this.$fill[0].style[this.DIMENSION]=d+this.grabPos+"px",this.$handle[0].style[this.DIRECTION_STYLE]=d+"px",this.setValue(c),this.position=d,this.value=c,b&&this.onSlide&&"function"==typeof this.onSlide&&this.onSlide(d,c)},j.prototype.getPositionFromNode=function(a){for(var b=0;null!==a;)b+=a.offsetLeft,a=a.offsetParent;return b},j.prototype.getRelativePosition=function(a){var b=i(this.COORDINATE),c=this.$range[0].getBoundingClientRect()[this.DIRECTION],d=0;return"undefined"!=typeof a["page"+b]?d=a["client"+b]:"undefined"!=typeof a.originalEvent["client"+b]?d=a.originalEvent["client"+b]:a.originalEvent.touches&&a.originalEvent.touches[0]&&"undefined"!=typeof a.originalEvent.touches[0]["client"+b]?d=a.originalEvent.touches[0]["client"+b]:a.currentPoint&&"undefined"!=typeof a.currentPoint[this.COORDINATE]&&(d=a.currentPoint[this.COORDINATE]),d-c},j.prototype.getPositionFromValue=function(a){var b,c;return b=(a-this.min)/(this.max-this.min),c=Number.isNaN(b)?0:b*this.maxHandlePos},j.prototype.getValueFromPosition=function(a){var b,c;return b=a/(this.maxHandlePos||1),c=this.step*Math.round(b*(this.max-this.min)/this.step)+this.min,Number(c.toFixed(this.toFixed))},j.prototype.setValue=function(a){(a!==this.value||""===this.$element[0].value)&&this.$element.val(a).trigger("input",{origin:this.identifier})},j.prototype.destroy=function(){this.$document.off("."+this.identifier),this.$window.off("."+this.identifier),this.$element.off("."+this.identifier).removeAttr("style").removeData("plugin_"+k),this.$range&&this.$range.length&&this.$range[0].parentNode.removeChild(this.$range[0])},a.fn[k]=function(b){var c=Array.prototype.slice.call(arguments,1);return this.each(function(){var d=a(this),e=d.data("plugin_"+k);e||d.data("plugin_"+k,e=new j(this,b)),"string"==typeof b&&e[b].apply(e,c)})},"rangeslider.js is available in jQuery context e.g $(selector).rangeslider(options);"});
$(function(){
  $('input[type="range"]').rangeslider({
    polyfill:false,
    onInit:function(){
      $('.header .pull-right').text($('input[type="range"]').val()+'');
    },
    onSlide:function(position, value){
      //console.log('onSlide');
      //console.log('position: ' + position, 'value: ' + value);
      $('.header .pull-right').text(value+'');
    },
    onSlideEnd:function(position, value){
      //console.log('onSlideEnd');
      //console.log('position: ' + position, 'value: ' + value);
    }
  });
});
    </script>
@endsection
