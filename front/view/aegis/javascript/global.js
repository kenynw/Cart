/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright � 2008 George McGinley Smith
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
*/

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
  def: 'easeOutQuad',
  swing: function (x, t, b, c, d) {
    //alert(jQuery.easing.default);
    return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
  },
  easeInQuad: function (x, t, b, c, d) {
    return c*(t/=d)*t + b;
  },
  easeOutQuad: function (x, t, b, c, d) {
    return -c *(t/=d)*(t-2) + b;
  },
  easeInOutQuad: function (x, t, b, c, d) {
    if ((t/=d/2) < 1) return c/2*t*t + b;
    return -c/2 * ((--t)*(t-2) - 1) + b;
  },
  easeInCubic: function (x, t, b, c, d) {
    return c*(t/=d)*t*t + b;
  },
  easeOutCubic: function (x, t, b, c, d) {
    return c*((t=t/d-1)*t*t + 1) + b;
  },
  easeInOutCubic: function (x, t, b, c, d) {
    if ((t/=d/2) < 1) return c/2*t*t*t + b;
    return c/2*((t-=2)*t*t + 2) + b;
  },
  easeInQuart: function (x, t, b, c, d) {
    return c*(t/=d)*t*t*t + b;
  },
  easeOutQuart: function (x, t, b, c, d) {
    return -c * ((t=t/d-1)*t*t*t - 1) + b;
  },
  easeInOutQuart: function (x, t, b, c, d) {
    if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
    return -c/2 * ((t-=2)*t*t*t - 2) + b;
  },
  easeInQuint: function (x, t, b, c, d) {
    return c*(t/=d)*t*t*t*t + b;
  },
  easeOutQuint: function (x, t, b, c, d) {
    return c*((t=t/d-1)*t*t*t*t + 1) + b;
  },
  easeInOutQuint: function (x, t, b, c, d) {
    if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
    return c/2*((t-=2)*t*t*t*t + 2) + b;
  },
  easeInSine: function (x, t, b, c, d) {
    return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
  },
  easeOutSine: function (x, t, b, c, d) {
    return c * Math.sin(t/d * (Math.PI/2)) + b;
  },
  easeInOutSine: function (x, t, b, c, d) {
    return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
  },
  easeInExpo: function (x, t, b, c, d) {
    return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
  },
  easeOutExpo: function (x, t, b, c, d) {
    return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
  },
  easeInOutExpo: function (x, t, b, c, d) {
    if (t==0) return b;
    if (t==d) return b+c;
    if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
    return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
  },
  easeInCirc: function (x, t, b, c, d) {
    return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
  },
  easeOutCirc: function (x, t, b, c, d) {
    return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
  },
  easeInOutCirc: function (x, t, b, c, d) {
    if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
    return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
  },
  easeInElastic: function (x, t, b, c, d) {
    var s=1.70158;var p=0;var a=c;
    if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
    if (a < Math.abs(c)) { a=c; var s=p/4; }
    else var s = p/(2*Math.PI) * Math.asin (c/a);
    return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
  },
  easeOutElastic: function (x, t, b, c, d) {
    var s=1.70158;var p=0;var a=c;
    if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
    if (a < Math.abs(c)) { a=c; var s=p/4; }
    else var s = p/(2*Math.PI) * Math.asin (c/a);
    return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
  },
  easeInOutElastic: function (x, t, b, c, d) {
    var s=1.70158;var p=0;var a=c;
    if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
    if (a < Math.abs(c)) { a=c; var s=p/4; }
    else var s = p/(2*Math.PI) * Math.asin (c/a);
    if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
    return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
  },
  easeInBack: function (x, t, b, c, d, s) {
    if (s == undefined) s = 1.70158;
    return c*(t/=d)*t*((s+1)*t - s) + b;
  },
  easeOutBack: function (x, t, b, c, d, s) {
    if (s == undefined) s = 1.70158;
    return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
  },
  easeInOutBack: function (x, t, b, c, d, s) {
    if (s == undefined) s = 1.70158; 
    if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
    return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
  },
  easeInBounce: function (x, t, b, c, d) {
    return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
  },
  easeOutBounce: function (x, t, b, c, d) {
    if ((t/=d) < (1/2.75)) {
      return c*(7.5625*t*t) + b;
    } else if (t < (2/2.75)) {
      return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
    } else if (t < (2.5/2.75)) {
      return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
    } else {
      return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
    }
  },
  easeInOutBounce: function (x, t, b, c, d) {
    if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
    return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
  }
});

/*
 *
 * TERMS OF USE - EASING EQUATIONS
 * 
 * Open source under the BSD License. 
 * 
 * Copyright � 2001 Robert Penner
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
 */
 
 
 
 /*
 * jQuery Cookie plugin
 *
 * Copyright (c) 2010 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 * Create a cookie with the given key and value and other optional parameters.
 *
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Set the value of a cookie.
 * @example $.cookie('the_cookie', 'the_value', { expires: 7, path: '/', domain: 'jquery.com', secure: true });
 * @desc Create a cookie with all available options.
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Create a session cookie.
 * @example $.cookie('the_cookie', null);
 * @desc Delete a cookie by passing null as value. Keep in mind that you have to use the same path and domain
 *       used when the cookie was set.
 *
 * @param String key The key of the cookie.
 * @param String value The value of the cookie.
 * @param Object options An object literal containing key/value pairs to provide optional cookie attributes.
 * @option Number|Date expires Either an integer specifying the expiration date from now on in days or a Date object.
 *                             If a negative value is specified (e.g. a date in the past), the cookie will be deleted.
 *                             If set to null or omitted, the cookie will be a session cookie and will not be retained
 *                             when the the browser exits.
 * @option String path The value of the path atribute of the cookie (default: path of page that created the cookie).
 * @option String domain The value of the domain attribute of the cookie (default: domain of page that created the cookie).
 * @option Boolean secure If true, the secure attribute of the cookie will be set and the cookie transmission will
 *                        require a secure protocol (like HTTPS).
 * @type undefined
 *
 * @name $.cookie
 * @cat Plugins/Cookie
 * @author Klaus Hartl/klaus.hartl@stilbuero.de
 *
 * Get the value of a cookie with the given key.
 *
 * @example $.cookie('the_cookie');
 * @desc Get the value of a cookie.
 *
 * @param String key The key of the cookie.
 * @return The value of the cookie.
 * @type String
 *
 * @name $.cookie
 * @cat Plugins/Cookie
 * @author Klaus Hartl/klaus.hartl@stilbuero.de
 */
jQuery.cookie = function (key, value, options) {
    
    // key and at least value given, set cookie...
    if (arguments.length > 1 && String(value) !== "[object Object]") {
        options = jQuery.extend({}, options);

        if (value === null || value === undefined) {
            options.expires = -1;
        }

        if (typeof options.expires === 'number') {
            var days = options.expires, t = options.expires = new Date();
            t.setDate(t.getDate() + days);
        }
        
        value = String(value);
        
        return (document.cookie = [
            encodeURIComponent(key), '=',
            options.raw ? value : encodeURIComponent(value),
            options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
            options.path ? '; path=' + options.path : '',
            options.domain ? '; domain=' + options.domain : '',
            options.secure ? '; secure' : ''
        ].join(''));
    }

    // key and possibly options given, get cookie...
    options = value || {};
    var result, decode = options.raw ? function (s) { return s; } : decodeURIComponent;
    return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
};
 
 
 /**
 * jQuery.ScrollTo
 * Copyright (c) 2007-2009 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * Date: 5/25/2009
 *
 * @projectDescription Easy element scrolling using jQuery.
 * http://flesler.blogspot.com/2007/10/jqueryscrollto.html
 * Works with jQuery +1.2.6. Tested on FF 2/3, IE 6/7/8, Opera 9.5/6, Safari 3, Chrome 1 on WinXP.
 *
 * @author Ariel Flesler
 * @version 1.4.2
 *
 * @id jQuery.scrollTo
 * @id jQuery.fn.scrollTo
 * @param {String, Number, DOMElement, jQuery, Object} target Where to scroll the matched elements.
 *	  The different options for target are:
 *		- A number position (will be applied to all axes).
 *		- A string position ('44', '100px', '+=90', etc ) will be applied to all axes
 *		- A jQuery/DOM element ( logically, child of the element to scroll )
 *		- A string selector, that will be relative to the element to scroll ( 'li:eq(2)', etc )
 *		- A hash { top:x, left:y }, x and y can be any kind of number/string like above.
*		- A percentage of the container's dimension/s, for example: 50% to go to the middle.
 *		- The string 'max' for go-to-end. 
 * @param {Number} duration The OVERALL length of the animation, this argument can be the settings object instead.
 * @param {Object,Function} settings Optional set of settings or the onAfter callback.
 *	 @option {String} axis Which axis must be scrolled, use 'x', 'y', 'xy' or 'yx'.
 *	 @option {Number} duration The OVERALL length of the animation.
 *	 @option {String} easing The easing method for the animation.
 *	 @option {Boolean} margin If true, the margin of the target element will be deducted from the final position.
 *	 @option {Object, Number} offset Add/deduct from the end position. One number for both axes or { top:x, left:y }.
 *	 @option {Object, Number} over Add/deduct the height/width multiplied by 'over', can be { top:x, left:y } when using both axes.
 *	 @option {Boolean} queue If true, and both axis are given, the 2nd axis will only be animated after the first one ends.
 *	 @option {Function} onAfter Function to be called after the scrolling ends. 
 *	 @option {Function} onAfterFirst If queuing is activated, this function will be called after the first scrolling ends.
 * @return {jQuery} Returns the same jQuery object, for chaining.
 *
 * @desc Scroll to a fixed position
 * @example $('div').scrollTo( 340 );
 *
 * @desc Scroll relatively to the actual position
 * @example $('div').scrollTo( '+=340px', { axis:'y' } );
 *
 * @dec Scroll using a selector (relative to the scrolled element)
 * @example $('div').scrollTo( 'p.paragraph:eq(2)', 500, { easing:'swing', queue:true, axis:'xy' } );
 *
 * @ Scroll to a DOM element (same for jQuery object)
 * @example var second_child = document.getElementById('container').firstChild.nextSibling;
 *			$('#container').scrollTo( second_child, { duration:500, axis:'x', onAfter:function(){
 *				alert('scrolled!!');																   
 *			}});
 *
 * @desc Scroll on both axes, to different values
 * @example $('div').scrollTo( { top: 300, left:'+=200' }, { axis:'xy', offset:-20 } );
 */
;(function( $ ){
	
	var $scrollTo = $.scrollTo = function( target, duration, settings ){
		$(window).scrollTo( target, duration, settings );
	};

	$scrollTo.defaults = {
		axis:'xy',
		duration: parseFloat($.fn.jquery) >= 1.3 ? 0 : 1
	};

	// Returns the element that needs to be animated to scroll the window.
	// Kept for backwards compatibility (specially for localScroll & serialScroll)
	$scrollTo.window = function( scope ){
		return $(window)._scrollable();
	};

	// Hack, hack, hack :)
	// Returns the real elements to scroll (supports window/iframes, documents and regular nodes)
	$.fn._scrollable = function(){
		return this.map(function(){
			var elem = this,
				isWin = !elem.nodeName || $.inArray( elem.nodeName.toLowerCase(), ['iframe','#document','html','body'] ) != -1;

				if( !isWin )
					return elem;

			var doc = (elem.contentWindow || elem).document || elem.ownerDocument || elem;
			
			return $.browser.safari || doc.compatMode == 'BackCompat' ?
				doc.body : 
				doc.documentElement;
		});
	};

	$.fn.scrollTo = function( target, duration, settings ){
		if( typeof duration == 'object' ){
			settings = duration;
			duration = 0;
		}
		if( typeof settings == 'function' )
			settings = { onAfter:settings };
			
		if( target == 'max' )
			target = 9e9;
			
		settings = $.extend( {}, $scrollTo.defaults, settings );
		// Speed is still recognized for backwards compatibility
		duration = duration || settings.speed || settings.duration;
		// Make sure the settings are given right
		settings.queue = settings.queue && settings.axis.length > 1;
		
		if( settings.queue )
			// Let's keep the overall duration
			duration /= 2;
		settings.offset = both( settings.offset );
		settings.over = both( settings.over );

		return this._scrollable().each(function(){
			var elem = this,
				$elem = $(elem),
				targ = target, toff, attr = {},
				win = $elem.is('html,body');

			switch( typeof targ ){
				// A number will pass the regex
				case 'number':
				case 'string':
					if( /^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(targ) ){
						targ = both( targ );
						// We are done
						break;
					}
					// Relative selector, no break!
					targ = $(targ,this);
				case 'object':
					// DOMElement / jQuery
					if( targ.is || targ.style )
						// Get the real position of the target 
						toff = (targ = $(targ)).offset();
			}
			$.each( settings.axis.split(''), function( i, axis ){
				var Pos	= axis == 'x' ? 'Left' : 'Top',
					pos = Pos.toLowerCase(),
					key = 'scroll' + Pos,
					old = elem[key],
					max = $scrollTo.max(elem, axis);

				if( toff ){// jQuery / DOMElement
					attr[key] = toff[pos] + ( win ? 0 : old - $elem.offset()[pos] );

					// If it's a dom element, reduce the margin
					if( settings.margin ){
						attr[key] -= parseInt(targ.css('margin'+Pos)) || 0;
						attr[key] -= parseInt(targ.css('border'+Pos+'Width')) || 0;
					}
					
					attr[key] += settings.offset[pos] || 0;
					
					if( settings.over[pos] )
						// Scroll to a fraction of its width/height
						attr[key] += targ[axis=='x'?'width':'height']() * settings.over[pos];
				}else{ 
					var val = targ[pos];
					// Handle percentage values
					attr[key] = val.slice && val.slice(-1) == '%' ? 
						parseFloat(val) / 100 * max
						: val;
				}

				// Number or 'number'
				if( /^\d+$/.test(attr[key]) )
					// Check the limits
					attr[key] = attr[key] <= 0 ? 0 : Math.min( attr[key], max );

				// Queueing axes
				if( !i && settings.queue ){
					// Don't waste time animating, if there's no need.
					if( old != attr[key] )
						// Intermediate animation
						animate( settings.onAfterFirst );
					// Don't animate this axis again in the next iteration.
					delete attr[key];
				}
			});

			animate( settings.onAfter );			

			function animate( callback ){
				$elem.animate( attr, duration, settings.easing, callback && function(){
					callback.call(this, target, settings);
				});
			};

		}).end();
	};
	
	// Max scrolling position, works on quirks mode
	// It only fails (not too badly) on IE, quirks mode.
	$scrollTo.max = function( elem, axis ){
		var Dim = axis == 'x' ? 'Width' : 'Height',
			scroll = 'scroll'+Dim;
		
		if( !$(elem).is('html,body') )
			return elem[scroll] - $(elem)[Dim.toLowerCase()]();
		
		var size = 'client' + Dim,
			html = elem.ownerDocument.documentElement,
			body = elem.ownerDocument.body;

		return Math.max( html[scroll], body[scroll] ) 
			 - Math.min( html[size]  , body[size]   );
			
	};

	function both( val ){
		return typeof val == 'object' ? val : { top:val, left:val };
	};

})( jQuery );
 

/*!
jQuery ColorBox v1.3.34 - 2013-02-04
(c) 2013 Jack Moore - jacklmoore.com/colorbox
license: http://www.opensource.org/licenses/mit-license.php
*/
(function ($, document, window) {
	var
	  // Default settings object.
	  // See http://jacklmoore.com/colorbox for details.
	  defaults = {
	    transition: "elastic",
	    speed: 300,
	    width: false,
	    initialWidth: "600",
	    innerWidth: false,
	    maxWidth: false,
	    height: false,
	    initialHeight: "450",
	    innerHeight: false,
	    maxHeight: false,
	    scalePhotos: true,
	    scrolling: true,
	    inline: false,
	    html: false,
	    iframe: false,
	    fastIframe: true,
	    photo: false,
	    href: false,
	    title: false,
	    rel: false,
	    opacity: 0.9,
	    preloading: true,
	    className: false,
	    
	    // alternate image paths for high-res displays
	    retinaImage: false,
	    retinaUrl: false,
	    retinaSuffix: '@2x.$1',

	    // internationalization
	    current: "image {current} of {total}",
	    previous: "previous",
	    next: "next",
	    close: "",
	    xhrError: "This content failed to load.",
	    imgError: "This image failed to load.",

	    open: false,
	    returnFocus: true,
	    reposition: true,
	    loop: true,
	    slideshow: false,
	    slideshowAuto: true,
	    slideshowSpeed: 2500,
	    slideshowStart: "start slideshow",
	    slideshowStop: "stop slideshow",
	    photoRegex: /\.(gif|png|jp(e|g|eg)|bmp|ico)((#|\?).*)?$/i,

	    onOpen: false,
	    onLoad: false,
	    onComplete: false,
	    onCleanup: false,
	    onClosed: false,
	    overlayClose: true,
	    escKey: true,
	    arrowKey: true,
	    top: false,
	    bottom: false,
	    left: false,
	    right: false,
	    fixed: false,
	    data: undefined
	  },
	  
	  // Abstracting the HTML and event identifiers for easy rebranding
	  colorbox = 'colorbox',
	  prefix = 'cbox',
	  boxElement = prefix + 'Element',
	  
	  // Events
	  event_open = prefix + '_open',
	  event_load = prefix + '_load',
	  event_complete = prefix + '_complete',
	  event_cleanup = prefix + '_cleanup',
	  event_closed = prefix + '_closed',
	  event_purge = prefix + '_purge',
	  
	  // Special Handling for IE
	  isIE = !$.support.leadingWhitespace, // IE6 to IE8
	  isIE6 = isIE && !window.XMLHttpRequest, // IE6
	  event_ie6 = prefix + '_IE6',

	  // Cached jQuery Object Variables
	  $overlay,
	  $box,
	  $wrap,
	  $content,
	  $topBorder,
	  $leftBorder,
	  $rightBorder,
	  $bottomBorder,
	  $related,
	  $window,
	  $loaded,
	  $loadingBay,
	  $loadingOverlay,
	  $title,
	  $current,
	  $slideshow,
	  $next,
	  $prev,
	  $close,
	  $groupControls,
	  $events = $({}),
	  
	  // Variables for cached values or use across multiple functions
	  settings,
	  interfaceHeight,
	  interfaceWidth,
	  loadedHeight,
	  loadedWidth,
	  element,
	  index,
	  photo,
	  open,
	  active,
	  closing,
	  loadingTimer,
	  publicMethod,
	  div = "div",
	  className,
	  init;

	  // ****************
	  // HELPER FUNCTIONS
	  // ****************
	  
	  // Convience function for creating new jQuery objects
	  function $tag(tag, id, css) {
	    var element = document.createElement(tag);

	    if (id) {
	      element.id = prefix + id;
	    }

	    if (css) {
	      element.style.cssText = css;
	    }

	    return $(element);
	  }

	  // Determine the next and previous members in a group.
	  function getIndex(increment) {
	    var
	    max = $related.length,
	    newIndex = (index + increment) % max;
	    
	    return (newIndex < 0) ? max + newIndex : newIndex;
	  }

	  // Convert '%' and 'px' values to integers
	  function setSize(size, dimension) {
	    return Math.round((/%/.test(size) ? ((dimension === 'x' ? $window.width() : $window.height()) / 100) : 1) * parseInt(size, 10));
	  }
	  
	  // Checks an href to see if it is a photo.
	  // There is a force photo option (photo: true) for hrefs that cannot be matched by the regex.
	  function isImage(url) {
	    return settings.photo || settings.photoRegex.test(url);
	  }

	  function retinaUrl(url) {
	    return settings.retinaUrl && window.devicePixelRatio > 1 ? url.replace(settings.photoRegex, settings.retinaSuffix) : url;
	  }

	  // Assigns function results to their respective properties
	  function makeSettings() {
	    var i,
	      data = $.data(element, colorbox);
	    
	    if (data == null) {
	      settings = $.extend({}, defaults);
	      if (console && console.log) {
	        console.log('Error: cboxElement missing settings object');
	      }
	    } else {
	      settings = $.extend({}, data);
	    }
	    
	    for (i in settings) {
	      if ($.isFunction(settings[i]) && i.slice(0, 2) !== 'on') { // checks to make sure the function isn't one of the callbacks, they will be handled at the appropriate time.
	        settings[i] = settings[i].call(element);
	      }
	    }
	    
	    settings.rel = settings.rel || element.rel || $(element).data('rel') || 'nofollow';
	    settings.href = settings.href || $(element).attr('href');
	    settings.title = settings.title || element.title;
	    
	    if (typeof settings.href === "string") {
	      settings.href = $.trim(settings.href);
	    }
	  }

	  function trigger(event, callback) {
	    // for external use
	    $(document).trigger(event);

	    // for internal use
	    $events.trigger(event);

	    if ($.isFunction(callback)) {
	      callback.call(element);
	    }
	  }

	  // Slideshow functionality
	  function slideshow() {
	    var
	    timeOut,
	    className = prefix + "Slideshow_",
	    click = "click." + prefix,
	    clear,
	    set,
	    start,
	    stop;
	    
	    if (settings.slideshow && $related[1]) {
	      clear = function () {
	        clearTimeout(timeOut);
	      };

	      set = function () {
	        if (settings.loop || $related[index + 1]) {
	          timeOut = setTimeout(publicMethod.next, settings.slideshowSpeed);
	        }
	      };

	      start = function () {
	        $slideshow
	          .html(settings.slideshowStop)
	          .unbind(click)
	          .one(click, stop);

	        $events
	          .bind(event_complete, set)
	          .bind(event_load, clear)
	          .bind(event_cleanup, stop);

	        $box.removeClass(className + "off").addClass(className + "on");
	      };
	      
	      stop = function () {
	        clear();
	        
	        $events
	          .unbind(event_complete, set)
	          .unbind(event_load, clear)
	          .unbind(event_cleanup, stop);
	        
	        $slideshow
	          .html(settings.slideshowStart)
	          .unbind(click)
	          .one(click, function () {
	            publicMethod.next();
	            start();
	          });

	        $box.removeClass(className + "on").addClass(className + "off");
	      };
	      
	      if (settings.slideshowAuto) {
	        start();
	      } else {
	        stop();
	      }
	    } else {
	      $box.removeClass(className + "off " + className + "on");
	    }
	  }
	  function launch(target) {
		    if (!closing) {
		      
		      element = target;
		      
		      makeSettings();
		      
		      $related = $(element);
		      
		      index = 0;
		      
		      if (settings.rel !== 'nofollow') {
		        $related = $('.' + boxElement).filter(function () {
		          var data = $.data(this, colorbox),
		            relRelated;

		          if (data) {
		            relRelated =  $(this).data('rel') || data.rel || this.rel;
		          }
		          
		          return (relRelated === settings.rel);
		        });
		        index = $related.index(element);
		        
		        // Check direct calls to ColorBox.
		        if (index === -1) {
		          $related = $related.add(element);
		          index = $related.length - 1;
		        }
		      }
		      
		      if (!open) {
		        open = active = true; // Prevents the page-change action from queuing up if the visitor holds down the left or right keys.
		        
		        // Show colorbox so the sizes can be calculated in older versions of jQuery
		        $box.css({visibility:'hidden', display:'block'});
		        
		        $loaded = $tag(div, 'LoadedContent', 'width:0; height:0; overflow:hidden').appendTo($content);

		        // Cache values needed for size calculations
		        interfaceHeight = $topBorder.height() + $bottomBorder.height() + $content.outerHeight(true) - $content.height();//Subtraction needed for IE6
		        interfaceWidth = $leftBorder.width() + $rightBorder.width() + $content.outerWidth(true) - $content.width();
		        loadedHeight = $loaded.outerHeight(true);
		        loadedWidth = $loaded.outerWidth(true);

		        if (settings.returnFocus) {
		          $(element).blur();
		          $events.one(event_closed, function () {
		            $(element).focus();
		          });
		        }
		        
		        $overlay.css({
		          opacity: parseFloat(settings.opacity),
		          cursor: settings.overlayClose ? "pointer" : "auto",
		          visibility: 'visible'
		        }).show();
		        
		        // Opens inital empty ColorBox prior to content being loaded.
		        settings.w = setSize(settings.initialWidth, 'x');
		        settings.h = setSize(settings.initialHeight, 'y');
		        publicMethod.position();

		        if (isIE6) {
		          $window.bind('resize.' + event_ie6 + ' scroll.' + event_ie6, function () {
		            $overlay.css({width: $window.width(), height: $window.height(), top: $window.scrollTop(), left: $window.scrollLeft()});
		          }).trigger('resize.' + event_ie6);
		        }
		        
		        slideshow();    
		        trigger(event_open, settings.onOpen);
		        
		        $groupControls.add($title).hide();
		        
		        $close.html(settings.close).show();
		      }
		      
		      publicMethod.load(true);
		    }
		  }
	// ColorBox's markup needs to be added to the DOM prior to being called
	  // so that the browser will go ahead and load the CSS background images.
	  function appendHTML() {
	    if (!$box && document.body) {
	      init = false;

	      $window = $(window);
	      $box = $tag(div).attr({id: colorbox, 'class': isIE ? prefix + (isIE6 ? 'IE6' : 'IE') : ''}).hide();
	      $overlay = $tag(div, "Overlay", isIE6 ? 'position:absolute' : '').hide();
	      $loadingOverlay = $tag(div, "LoadingOverlay").add($tag(div, "LoadingGraphic"));
	      $wrap = $tag(div, "Wrapper");
	      $content = $tag(div, "Content").append(
	        $title = $tag(div, "Title"),
	        $current = $tag(div, "Current"),
	        $next = $tag(div, "Next"),
	        $prev = $tag(div, "Previous"),
	        $slideshow = $tag(div, "Slideshow"),
	        $close = $tag(div, "Close")
	      );
	      
	      $wrap.append( // The 3x3 Grid that makes up ColorBox
	        $tag(div).append(
	          $tag(div, "TopLeft"),
	          $topBorder = $tag(div, "TopCenter"),
	          $tag(div, "TopRight")
	        ),
	        $tag(div, false, 'clear:left').append(
	          $leftBorder = $tag(div, "MiddleLeft"),
	          $content,
	          $rightBorder = $tag(div, "MiddleRight")
	        ),
	        $tag(div, false, 'clear:left').append(
	          $tag(div, "BottomLeft"),
	          $bottomBorder = $tag(div, "BottomCenter"),
	          $tag(div, "BottomRight")
	        )
	      ).find('div div').css({'float': 'left'});
	      
	      $loadingBay = $tag(div, false, 'position:absolute; width:9999px; visibility:hidden; display:none');
	      
	      $groupControls = $next.add($prev).add($current).add($slideshow);

	      $(document.body).append($overlay, $box.append($wrap, $loadingBay));
	    }
	  }

	  // Add ColorBox's event bindings
	  function addBindings() {
	    function clickHandler(e) {
	      // ignore non-left-mouse-clicks and clicks modified with ctrl / command, shift, or alt.
	      // See: http://jacklmoore.com/notes/click-events/
	      if (!(e.which > 1 || e.shiftKey || e.altKey || e.metaKey)) {
	        e.preventDefault();
	        launch(this);
	      }
	    }

	    if ($box) {
	        if (!init) {
	          init = true;
	
	       // Anonymous functions here keep the public method from being cached, thereby allowing them to be redefined on the fly.
	          $next.click(function () {
	            publicMethod.next();
	          });
	          $prev.click(function () {
	            publicMethod.prev();
	          });
	          $close.click(function () {
	            publicMethod.close();
	          });
	          $overlay.click(function () {
	            if (settings.overlayClose) {
	              publicMethod.close();
	            }
	          });
	          
	          // Key Bindings
	          $(document).bind('keydown.' + prefix, function (e) {
	            var key = e.keyCode;
	            if (open && settings.escKey && key === 27) {
	              e.preventDefault();
	              publicMethod.close();
	            }
	            if (open && settings.arrowKey && $related[1]) {
	              if (key === 37) {
	                e.preventDefault();
	                $prev.click();
	              } else if (key === 39) {
	                e.preventDefault();
	                $next.click();
	              }
	            }
	          });
	
	          if ($.isFunction($.fn.on)) {
	              $(document).on('click.'+prefix, '.'+boxElement, clickHandler);
	            } else { // For jQuery 1.3.x -> 1.6.x
	              $('.'+boxElement).live('click.'+prefix, clickHandler);
	            }
	          }
	          return true;
	        }
	        return false;
	      }
		// Don't do anything if ColorBox already exists.
		if ($.colorbox) {
			return;
		}
		// Append the HTML when the DOM loads
	    $(appendHTML);

	
	 // ****************
	    // PUBLIC FUNCTIONS
	    // Usage format: $.fn.colorbox.close();
	    // Usage from within an iframe: parent.$.fn.colorbox.close();
	    // ****************
	    
	    publicMethod = $.fn[colorbox] = $[colorbox] = function (options, callback) {
	      var $this = this;
	      
	      options = options || {};
	      
	      appendHTML();

	      if (addBindings()) {
	        if ($.isFunction($this)) { // assume a call to $.colorbox
	          $this = $('<a/>');
	          options.open = true;
	        } else if (!$this[0]) { // colorbox being applied to empty collection
	          return $this;
	        }
	        
	        if (callback) {
	          options.onComplete = callback;
	        }
	        
	        $this.each(function () {
	          $.data(this, colorbox, $.extend({}, $.data(this, colorbox) || defaults, options));
	        }).addClass(boxElement);
	        
	        if (($.isFunction(options.open) && options.open.call($this)) || options.open) {
	          launch($this[0]);
	        }
	      }
	      
	      return $this;
	    };

	    publicMethod.position = function (speed, loadedCallback) {
	      var
	      css,
	      top = 0,
	      left = 0,
	      offset = $box.offset(),
	      scrollTop,
	      scrollLeft;
	      
	      $window.unbind('resize.' + prefix);

	      // remove the modal so that it doesn't influence the document width/height
	      $box.css({top: -9e4, left: -9e4});

	      scrollTop = $window.scrollTop();
	      scrollLeft = $window.scrollLeft();

	      if (settings.fixed && !isIE6) {
	        offset.top -= scrollTop;
	        offset.left -= scrollLeft;
	        $box.css({position: 'fixed'});
	      } else {
	        top = scrollTop;
	        left = scrollLeft;
	        $box.css({position: 'absolute'});
	      }

	      // keeps the top and left positions within the browser's viewport.
	      if (settings.right !== false) {
	        left += Math.max($window.width() - settings.w - loadedWidth - interfaceWidth - setSize(settings.right, 'x'), 0);
	      } else if (settings.left !== false) {
	        left += setSize(settings.left, 'x');
	      } else {
	        left += Math.round(Math.max($window.width() - settings.w - loadedWidth - interfaceWidth, 0) / 2);
	      }
	      
	      if (settings.bottom !== false) {
	        top += Math.max($window.height() - settings.h - loadedHeight - interfaceHeight - setSize(settings.bottom, 'y'), 0);
	      } else if (settings.top !== false) {
	        top += setSize(settings.top, 'y');
	      } else {
	        top += Math.round(Math.max($window.height() - settings.h - loadedHeight - interfaceHeight, 0) / 2);
	      }

	      $box.css({top: offset.top, left: offset.left, visibility:'visible'});

	      // setting the speed to 0 to reduce the delay between same-sized content.
	      speed = ($box.width() === settings.w + loadedWidth && $box.height() === settings.h + loadedHeight) ? 0 : speed || 0;
	      
	      // this gives the wrapper plenty of breathing room so it's floated contents can move around smoothly,
	      // but it has to be shrank down around the size of div#colorbox when it's done.  If not,
	      // it can invoke an obscure IE bug when using iframes.
	      $wrap[0].style.width = $wrap[0].style.height = "9999px";
	      
	      function modalDimensions(that) {
	        $topBorder[0].style.width = $bottomBorder[0].style.width = $content[0].style.width = (parseInt(that.style.width,10) - interfaceWidth)+'px';
	        $content[0].style.height = $leftBorder[0].style.height = $rightBorder[0].style.height = (parseInt(that.style.height,10) - interfaceHeight)+'px';
	      }

	      css = {width: settings.w + loadedWidth + interfaceWidth, height: settings.h + loadedHeight + interfaceHeight, top: top, left: left};

	      if(speed===0){ // temporary workaround to side-step jQuery-UI 1.8 bug (http://bugs.jquery.com/ticket/12273)
	        $box.css(css);
	      }
	      $box.dequeue().animate(css, {
	        duration: speed,
	        complete: function () {
	          modalDimensions(this);
	          active = false;
	          
	          // shrink the wrapper down to exactly the size of colorbox to avoid a bug in IE's iframe implementation.
	          $wrap[0].style.width = (settings.w + loadedWidth + interfaceWidth) + "px";
	          $wrap[0].style.height = (settings.h + loadedHeight + interfaceHeight) + "px";
	          
	          if (settings.reposition) {
	            setTimeout(function () {  // small delay before binding onresize due to an IE8 bug.
	              $window.bind('resize.' + prefix, publicMethod.position);
	            }, 1);
	          }
	          if (loadedCallback) {
	              loadedCallback();
	            }
	          },
	          step: function () {
	            modalDimensions(this);
	          }
	        });
	      };   

	      publicMethod.resize = function (options) {
	    	    if (open) {
	    	      options = options || {};
	    	      
	    	      if (options.width) {
	    	        settings.w = setSize(options.width, 'x') - loadedWidth - interfaceWidth;
	    	      }
	    	      if (options.innerWidth) {
	    	        settings.w = setSize(options.innerWidth, 'x');
	    	      }
	    	      $loaded.css({width: settings.w});
	    	      
	    	      if (options.height) {
	    	        settings.h = setSize(options.height, 'y') - loadedHeight - interfaceHeight;
	    	      }
	    	      if (options.innerHeight) {
	    	        settings.h = setSize(options.innerHeight, 'y');
	    	      }
	    	      if (!options.innerHeight && !options.height) {
	    	        $loaded.css({height: "auto"});
	    	        settings.h = $loaded.height();
	    	      }
	    	      $loaded.css({height: settings.h});
	    	      
	    	      publicMethod.position(settings.transition === "none" ? 0 : settings.speed);
	    	    }
	    	  };

	    	  publicMethod.prep = function (object) {
	    	    if (!open) {
	    	      return;
	    	    }
	    	    
	    	    var callback, speed = settings.transition === "none" ? 0 : settings.speed;
	    	    
	    	    $loaded.empty().remove(); // Using empty first may prevent some IE7 issues.

	    	    $loaded = $tag(div, 'LoadedContent').append(object);
	    	    
	    	    function getWidth() {
	    	      settings.w = settings.w || $loaded.width();
	    	      settings.w = settings.mw && settings.mw < settings.w ? settings.mw : settings.w;
	    	      return settings.w;
	    	    }
	    	    function getHeight() {
	    	      settings.h = settings.h || $loaded.height();
	    	      settings.h = settings.mh && settings.mh < settings.h ? settings.mh : settings.h;
	    	      return settings.h;
	    	    }
	    	    
	    	    $loaded.hide()
	    	    .appendTo($loadingBay.show())// content has to be appended to the DOM for accurate size calculations.
	    	    .css({width: getWidth(), overflow: settings.scrolling ? 'auto' : 'hidden'})
	    	    .css({height: getHeight()})// sets the height independently from the width in case the new width influences the value of height.
	    	    .prependTo($content);
	    	    
	    	    $loadingBay.hide();
	    	    
	    	    // floating the IMG removes the bottom line-height and fixed a problem where IE miscalculates the width of the parent element as 100% of the document width.
	    	    
	    	    $(photo).css({'float': 'none'});

	    	    callback = function () {
	    	      var total = $related.length,
	    	        iframe,
	    	        frameBorder = 'frameBorder',
	    	        allowTransparency = 'allowTransparency',
	    	        complete;
	    	      
	    	      if (!open) {
	    	        return;
	    	      }
	    	      
	    	      function removeFilter() {
	    	        if (isIE) {
	    	          $box[0].style.removeAttribute('filter');
	    	        }
	    	      }
	    	      
	    	      complete = function () {
	    	        clearTimeout(loadingTimer);
	    	        $loadingOverlay.remove();
	    	        trigger(event_complete, settings.onComplete);
	    	      };
	    	      
	    	      if (isIE) {
	    	        //This fadeIn helps the bicubic resampling to kick-in.
	    	        if (photo) {
	    	          $loaded.fadeIn(100);
	    	        }
	    	      }
	    	      
	    	      $title.html(settings.title).add($loaded).show();
	    	      
	    	      if (total > 1) { // handle grouping
	    	        if (typeof settings.current === "string") {
	    	          $current.html(settings.current.replace('{current}', index + 1).replace('{total}', total)).show();
	    	        }
	    	        
	    	        $next[(settings.loop || index < total - 1) ? "show" : "hide"]().html(settings.next);
	    	        $prev[(settings.loop || index) ? "show" : "hide"]().html(settings.previous);
	    	        
	    	        if (settings.slideshow) {
	    	          $slideshow.show();
	    	        }
	    	        
	    	        // Preloads images within a rel group
	    	        if (settings.preloading) {
	    	          $.each([getIndex(-1), getIndex(1)], function(){
	    	            var src,
	    	              img,
	    	              i = $related[this],
	    	              data = $.data(i, colorbox);

	    	            if (data && data.href) {
	    	              src = data.href;
	    	              if ($.isFunction(src)) {
	    	                src = src.call(i);
	    	              }
	    	            } else {
	    	              src = $(i).attr('href');
	    	            }

	    	            if (src && (isImage(src) || data.photo)) {
	    	              img = new Image();
	    	              img.src = src;
	    	            }
	    	          });
	    	        }
	    	      } else {
	    	        $groupControls.hide();
	    	      }
	    	      
	    	      if (settings.iframe) {
	    	        iframe = $tag('iframe')[0];
	    	        
	    	        if (frameBorder in iframe) {
	    	          iframe[frameBorder] = 0;
	    	        }
	    	        
	    	        if (allowTransparency in iframe) {
	    	          iframe[allowTransparency] = "true";
	    	        }

	    	        if (!settings.scrolling) {
	    	          iframe.scrolling = "no";
	    	        }
	    	        
	    	        $(iframe)
	    	          .attr({
	    	            src: settings.href,
	    	            name: (new Date()).getTime(), // give the iframe a unique name to prevent caching
	    	            'class': prefix + 'Iframe',
	    	            allowFullScreen : true, // allow HTML5 video to go fullscreen
	    	            webkitAllowFullScreen : true,
	    	            mozallowfullscreen : true
	    	          })
	    	          .one('load', complete)
	    	          .appendTo($loaded);
	    	        
	    	        $events.one(event_purge, function () {
	    	          iframe.src = "//about:blank";
	    	        });

	    	        if (settings.fastIframe) {
	    	          $(iframe).trigger('load');
	    	        }
	    	      } else {
	    	        complete();
	    	      }
	    	      
	    	      if (settings.transition === 'fade') {
	    	        $box.fadeTo(speed, 1, removeFilter);
	    	      } else {
	    	        removeFilter();
	    	      }
	    	    };
	    	    
	    	    if (settings.transition === 'fade') {
	    	      $box.fadeTo(speed, 0, function () {
	    	        publicMethod.position(0, callback);
	    	      });
	    	    } else {
	    	      publicMethod.position(speed, callback);
	    	    }
	    	  };

	    	  publicMethod.load = function (launched) {
	    	    var href, setResize, prep = publicMethod.prep, $inline;
	    	    
	    	    active = true;
	    	    
	    	    photo = false;
	    	    
	    	    element = $related[index];
	    	    
	    	    if (!launched) {
	    	      makeSettings();
	    	    }

	    	    if (className) {
	    	      $box.add($overlay).removeClass(className);
	    	    }
	    	    if (settings.className) {
	    	      $box.add($overlay).addClass(settings.className);
	    	    }
	    	    className = settings.className;
	    	    
	    	    trigger(event_purge);
	    	    
	    	    trigger(event_load, settings.onLoad);
	    	    
	    	    settings.h = settings.height ?
	    	        setSize(settings.height, 'y') - loadedHeight - interfaceHeight :
	    	        settings.innerHeight && setSize(settings.innerHeight, 'y');
	    	    
	    	    settings.w = settings.width ?
	    	        setSize(settings.width, 'x') - loadedWidth - interfaceWidth :
	    	        settings.innerWidth && setSize(settings.innerWidth, 'x');
	    	    
	    	    // Sets the minimum dimensions for use in image scaling
	    	    settings.mw = settings.w;
	    	    settings.mh = settings.h;
	    	    
	    	    // Re-evaluate the minimum width and height based on maxWidth and maxHeight values.
	    	    // If the width or height exceed the maxWidth or maxHeight, use the maximum values instead.
	    	    if (settings.maxWidth) {
	    	      settings.mw = setSize(settings.maxWidth, 'x') - loadedWidth - interfaceWidth;
	    	      settings.mw = settings.w && settings.w < settings.mw ? settings.w : settings.mw;
	    	    }
	    	    if (settings.maxHeight) {
	    	      settings.mh = setSize(settings.maxHeight, 'y') - loadedHeight - interfaceHeight;
	    	      settings.mh = settings.h && settings.h < settings.mh ? settings.h : settings.mh;
	    	    }
	    	    
	    	    href = settings.href;
	    	    
	    	    loadingTimer = setTimeout(function () {
	    	      $loadingOverlay.appendTo($content);
	    	    }, 100);
	    	    
	    	    if (settings.inline) {
	    	      // Inserts an empty placeholder where inline content is being pulled from.
	    	      // An event is bound to put inline content back when ColorBox closes or loads new content.
	    	      $inline = $tag(div).hide().insertBefore($(href)[0]);

	    	      $events.one(event_purge, function () {
	    	        $inline.replaceWith($loaded.children());
	    	      });

	    	      prep($(href));
	    	    } else if (settings.iframe) {
	    	      // IFrame element won't be added to the DOM until it is ready to be displayed,
	    	      // to avoid problems with DOM-ready JS that might be trying to run in that iframe.
	    	      prep(" ");
	    	    } else if (settings.html) {
	    	      prep(settings.html);
	    	    } else if (isImage(href)) {

	    	      href = retinaUrl(href);

	    	      $(photo = new Image())
	    	      .addClass(prefix + 'Photo')
	    	      .bind('error',function () {
	    	        settings.title = false;
	    	        prep($tag(div, 'Error').html(settings.imgError));
	    	      })
	    	      .one('load', function () {
	    	        var percent;

	    	        if (settings.retinaImage && window.devicePixelRatio > 1) {
	    	          photo.height = photo.height / window.devicePixelRatio;
	    	          photo.width = photo.width / window.devicePixelRatio;
	    	        }

	    	        if (settings.scalePhotos) {
	    	          setResize = function () {
	    	            photo.height -= photo.height * percent;
	    	            photo.width -= photo.width * percent;
	    	          };
	    	          if (settings.mw && photo.width > settings.mw) {
	    	            percent = (photo.width - settings.mw) / photo.width;
	    	            setResize();
	    	          }
	    	          if (settings.mh && photo.height > settings.mh) {
	    	            percent = (photo.height - settings.mh) / photo.height;
	    	            setResize();
	    	          }
	    	        }
	    	        
	    	        if (settings.h) {
	    	          photo.style.marginTop = Math.max(settings.mh - photo.height, 0) / 2 + 'px';
	    	        }
	    	        
	    	        if ($related[1] && (settings.loop || $related[index + 1])) {
	    	          photo.style.cursor = 'pointer';
	    	          photo.onclick = function () {
	    	            publicMethod.next();
	    	          };
	    	        }
	    	        
	    	        if (isIE) {
	    	          photo.style.msInterpolationMode = 'bicubic';
	    	        }
	    	        
	    	        setTimeout(function () { // A pause because Chrome will sometimes report a 0 by 0 size otherwise.
	    	          prep(photo);
	    	        }, 1);
	    	      });
	    	      
	    	      setTimeout(function () { // A pause because Opera 10.6+ will sometimes not run the onload function otherwise.
	    	        photo.src = href;
	    	      }, 1);
	    	    } else if (href) {
	    	      $loadingBay.load(href, settings.data, function (data, status) {
	    	        prep(status === 'error' ? $tag(div, 'Error').html(settings.xhrError) : $(this).contents());
	    	      });
	    	    }
	    	  };
	    	    
	    	  // Navigates to the next page/image in a set.
	    	  publicMethod.next = function () {
	    	    if (!active && $related[1] && (settings.loop || $related[index + 1])) {
	    	      index = getIndex(1);
	    	      publicMethod.load();
	    	    }
	    	  };
	    	  
	    	  publicMethod.prev = function () {
	    	    if (!active && $related[1] && (settings.loop || index)) {
	    	      index = getIndex(-1);
	    	      publicMethod.load();
	    	    }
	    	  };

	    	  // Note: to use this within an iframe use the following format: parent.$.fn.colorbox.close();
	    	  publicMethod.close = function () {
	    	    if (open && !closing) {
	    	      
	    	      closing = true;
	    	      
	    	      open = false;
	    	      
	    	      trigger(event_cleanup, settings.onCleanup);
	    	      
	    	      $window.unbind('.' + prefix + ' .' + event_ie6);
	    	      
	    	      $overlay.fadeTo(200, 0);
	    	      
	    	      $box.stop().fadeTo(300, 0, function () {
	    	      
	    	        $box.add($overlay).css({'opacity': 1, cursor: 'auto'}).hide();
	    	        
	    	        trigger(event_purge);
	    	        
	    	        $loaded.empty().remove(); // Using empty first may prevent some IE7 issues.
	    	        
	    	        setTimeout(function () {
	    	          closing = false;
	    	          trigger(event_closed, settings.onClosed);
	    	        }, 1);
	    	      });
	    	    }
	    	  };

	    	  // Removes changes ColorBox made to the document, but does not remove the plugin
	    	  // from jQuery.
	    	  publicMethod.remove = function () {
	    	    $([]).add($box).add($overlay).remove();
	    	    $box = null;
	    	    $('.' + boxElement)
	    	      .removeData(colorbox)
	    	      .removeClass(boxElement);

	    	    $(document).unbind('click.'+prefix);
	    	  };

	    	  // A method for fetching the current element ColorBox is referencing.
	    	  // returns a jQuery object.
	    	  publicMethod.element = function () {
	    	    return $(element);
	    	  };
	    	  publicMethod.settings = defaults;
}(jQuery, document, window));


/*!
 * jQuery UI 1.8.11
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI
 */
(function( $, undefined ) {

// prevent duplicate loading
// this is only a problem because we proxy existing functions
// and we don't want to double proxy them
$.ui = $.ui || {};
if ( $.ui.version ) {
	return;
}

$.extend( $.ui, {
	version: "@VERSION",

	keyCode: {
		ALT: 18,
		BACKSPACE: 8,
		CAPS_LOCK: 20,
		COMMA: 188,
		COMMAND: 91,
		COMMAND_LEFT: 91, // COMMAND
		COMMAND_RIGHT: 93,
		CONTROL: 17,
		DELETE: 46,
		DOWN: 40,
		END: 35,
		ENTER: 13,
		ESCAPE: 27,
		HOME: 36,
		INSERT: 45,
		LEFT: 37,
		MENU: 93, // COMMAND_RIGHT
		NUMPAD_ADD: 107,
		NUMPAD_DECIMAL: 110,
		NUMPAD_DIVIDE: 111,
		NUMPAD_ENTER: 108,
		NUMPAD_MULTIPLY: 106,
		NUMPAD_SUBTRACT: 109,
		PAGE_DOWN: 34,
		PAGE_UP: 33,
		PERIOD: 190,
		RIGHT: 39,
		SHIFT: 16,
		SPACE: 32,
		TAB: 9,
		UP: 38,
		WINDOWS: 91 // COMMAND
	}
});

// plugins
$.fn.extend({
	_focus: $.fn.focus,
	focus: function( delay, fn ) {
		return typeof delay === "number" ?
			this.each(function() {
				var elem = this;
				setTimeout(function() {
					$( elem ).focus();
					if ( fn ) {
						fn.call( elem );
					}
				}, delay );
			}) :
			this._focus.apply( this, arguments );
	},

	scrollParent: function() {
		var scrollParent;
		if (($.browser.msie && (/(static|relative)/).test(this.css('position'))) || (/absolute/).test(this.css('position'))) {
			scrollParent = this.parents().filter(function() {
				return (/(relative|absolute|fixed)/).test($.curCSS(this,'position',1)) && (/(auto|scroll)/).test($.curCSS(this,'overflow',1)+$.curCSS(this,'overflow-y',1)+$.curCSS(this,'overflow-x',1));
			}).eq(0);
		} else {
			scrollParent = this.parents().filter(function() {
				return (/(auto|scroll)/).test($.curCSS(this,'overflow',1)+$.curCSS(this,'overflow-y',1)+$.curCSS(this,'overflow-x',1));
			}).eq(0);
		}

		return (/fixed/).test(this.css('position')) || !scrollParent.length ? $(document) : scrollParent;
	},

	zIndex: function( zIndex ) {
		if ( zIndex !== undefined ) {
			return this.css( "zIndex", zIndex );
		}

		if ( this.length ) {
			var elem = $( this[ 0 ] ), position, value;
			while ( elem.length && elem[ 0 ] !== document ) {
				// Ignore z-index if position is set to a value where z-index is ignored by the browser
				// This makes behavior of this function consistent across browsers
				// WebKit always returns auto if the element is positioned
				position = elem.css( "position" );
				if ( position === "absolute" || position === "relative" || position === "fixed" ) {
					// IE returns 0 when zIndex is not specified
					// other browsers return a string
					// we ignore the case of nested elements with an explicit value of 0
					// <div style="z-index: -10;"><div style="z-index: 0;"></div></div>
					value = parseInt( elem.css( "zIndex" ), 10 );
					if ( !isNaN( value ) && value !== 0 ) {
						return value;
					}
				}
				elem = elem.parent();
			}
		}

		return 0;
	},

	disableSelection: function() {
		return this.bind( ( $.support.selectstart ? "selectstart" : "mousedown" ) +
			".ui-disableSelection", function( event ) {
				event.preventDefault();
			});
	},

	enableSelection: function() {
		return this.unbind( ".ui-disableSelection" );
	}
});

$.each( [ "Width", "Height" ], function( i, name ) {
	var side = name === "Width" ? [ "Left", "Right" ] : [ "Top", "Bottom" ],
		type = name.toLowerCase(),
		orig = {
			innerWidth: $.fn.innerWidth,
			innerHeight: $.fn.innerHeight,
			outerWidth: $.fn.outerWidth,
			outerHeight: $.fn.outerHeight
		};

	function reduce( elem, size, border, margin ) {
		$.each( side, function() {
			size -= parseFloat( $.curCSS( elem, "padding" + this, true) ) || 0;
			if ( border ) {
				size -= parseFloat( $.curCSS( elem, "border" + this + "Width", true) ) || 0;
			}
			if ( margin ) {
				size -= parseFloat( $.curCSS( elem, "margin" + this, true) ) || 0;
			}
		});
		return size;
	}

	$.fn[ "inner" + name ] = function( size ) {
		if ( size === undefined ) {
			return orig[ "inner" + name ].call( this );
		}

		return this.each(function() {
			$( this ).css( type, reduce( this, size ) + "px" );
		});
	};

	$.fn[ "outer" + name] = function( size, margin ) {
		if ( typeof size !== "number" ) {
			return orig[ "outer" + name ].call( this, size );
		}

		return this.each(function() {
			$( this).css( type, reduce( this, size, true, margin ) + "px" );
		});
	};
});

// selectors
function visible( element ) {
	return !$( element ).parents().andSelf().filter(function() {
		return $.curCSS( this, "visibility" ) === "hidden" ||
			$.expr.filters.hidden( this );
	}).length;
}

$.extend( $.expr[ ":" ], {
	data: function( elem, i, match ) {
		return !!$.data( elem, match[ 3 ] );
	},

	focusable: function( element ) {
		var nodeName = element.nodeName.toLowerCase(),
			tabIndex = $.attr( element, "tabindex" );
		if ( "area" === nodeName ) {
			var map = element.parentNode,
				mapName = map.name,
				img;
			if ( !element.href || !mapName || map.nodeName.toLowerCase() !== "map" ) {
				return false;
			}
			img = $( "img[usemap=#" + mapName + "]" )[0];
			return !!img && visible( img );
		}
		return ( /input|select|textarea|button|object/.test( nodeName )
			? !element.disabled
			: "a" == nodeName
				? element.href || !isNaN( tabIndex )
				: !isNaN( tabIndex ))
			// the element and all of its ancestors must be visible
			&& visible( element );
	},

	tabbable: function( element ) {
		var tabIndex = $.attr( element, "tabindex" );
		return ( isNaN( tabIndex ) || tabIndex >= 0 ) && $( element ).is( ":focusable" );
	}
});

// support
$(function() {
	var body = document.body,
		div = body.appendChild( div = document.createElement( "div" ) );

	$.extend( div.style, {
		minHeight: "100px",
		height: "auto",
		padding: 0,
		borderWidth: 0
	});

	$.support.minHeight = div.offsetHeight === 100;
	$.support.selectstart = "onselectstart" in div;

	// set display to none to avoid a layout bug in IE
	// http://dev.jquery.com/ticket/4014
	body.removeChild( div ).style.display = "none";
});





// deprecated
$.extend( $.ui, {
	// $.ui.plugin is deprecated.  Use the proxy pattern instead.
	plugin: {
		add: function( module, option, set ) {
			var proto = $.ui[ module ].prototype;
			for ( var i in set ) {
				proto.plugins[ i ] = proto.plugins[ i ] || [];
				proto.plugins[ i ].push( [ option, set[ i ] ] );
			}
		},
		call: function( instance, name, args ) {
			var set = instance.plugins[ name ];
			if ( !set || !instance.element[ 0 ].parentNode ) {
				return;
			}
	
			for ( var i = 0; i < set.length; i++ ) {
				if ( instance.options[ set[ i ][ 0 ] ] ) {
					set[ i ][ 1 ].apply( instance.element, args );
				}
			}
		}
	},
	
	// will be deprecated when we switch to jQuery 1.4 - use jQuery.contains()
	contains: function( a, b ) {
		return document.compareDocumentPosition ?
			a.compareDocumentPosition( b ) & 16 :
			a !== b && a.contains( b );
	},
	
	// only used by resizable
	hasScroll: function( el, a ) {
	
		//If overflow is hidden, the element might have extra content, but the user wants to hide it
		if ( $( el ).css( "overflow" ) === "hidden") {
			return false;
		}
	
		var scroll = ( a && a === "left" ) ? "scrollLeft" : "scrollTop",
			has = false;
	
		if ( el[ scroll ] > 0 ) {
			return true;
		}
	
		// TODO: determine which cases actually cause this to happen
		// if the element doesn't have the scroll set, see if it's possible to
		// set the scroll
		el[ scroll ] = 1;
		has = ( el[ scroll ] > 0 );
		el[ scroll ] = 0;
		return has;
	},
	
	// these are odd functions, fix the API or move into individual plugins
	isOverAxis: function( x, reference, size ) {
		//Determines when x coordinate is over "b" element axis
		return ( x > reference ) && ( x < ( reference + size ) );
	},
	isOver: function( y, x, top, left, height, width ) {
		//Determines when x, y coordinates is over "b" element
		return $.ui.isOverAxis( y, top, height ) && $.ui.isOverAxis( x, left, width );
	}
});

})( jQuery );
 
/*!
 * jQuery UI Widget 1.8.11
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Widget
 */
(function( $, undefined ) {

// jQuery 1.4+
if ( $.cleanData ) {
	var _cleanData = $.cleanData;
	$.cleanData = function( elems ) {
		for ( var i = 0, elem; (elem = elems[i]) != null; i++ ) {
			$( elem ).triggerHandler( "remove" );
		}
		_cleanData( elems );
	};
} else {
	var _remove = $.fn.remove;
	$.fn.remove = function( selector, keepData ) {
		return this.each(function() {
			if ( !keepData ) {
				if ( !selector || $.filter( selector, [ this ] ).length ) {
					$( "*", this ).add( [ this ] ).each(function() {
						$( this ).triggerHandler( "remove" );
					});
				}
			}
			return _remove.call( $(this), selector, keepData );
		});
	};
}

$.widget = function( name, base, prototype ) {
	var namespace = name.split( "." )[ 0 ],
		fullName;
	name = name.split( "." )[ 1 ];
	fullName = namespace + "-" + name;

	if ( !prototype ) {
		prototype = base;
		base = $.Widget;
	}

	// create selector for plugin
	$.expr[ ":" ][ fullName ] = function( elem ) {
		return !!$.data( elem, name );
	};

	$[ namespace ] = $[ namespace ] || {};
	$[ namespace ][ name ] = function( options, element ) {
		// allow instantiation without initializing for simple inheritance
		if ( arguments.length ) {
			this._createWidget( options, element );
		}
	};

	var basePrototype = new base();
	// we need to make the options hash a property directly on the new instance
	// otherwise we'll modify the options hash on the prototype that we're
	// inheriting from
//	$.each( basePrototype, function( key, val ) {
//		if ( $.isPlainObject(val) ) {
//			basePrototype[ key ] = $.extend( {}, val );
//		}
//	});
	basePrototype.options = $.extend( true, {}, basePrototype.options );
	$[ namespace ][ name ].prototype = $.extend( true, basePrototype, {
		namespace: namespace,
		widgetName: name,
		widgetEventPrefix: $[ namespace ][ name ].prototype.widgetEventPrefix || name,
		widgetBaseClass: fullName
	}, prototype );

	$.widget.bridge( name, $[ namespace ][ name ] );
};

$.widget.bridge = function( name, object ) {
	$.fn[ name ] = function( options ) {
		var isMethodCall = typeof options === "string",
			args = Array.prototype.slice.call( arguments, 1 ),
			returnValue = this;

		// allow multiple hashes to be passed on init
		options = !isMethodCall && args.length ?
			$.extend.apply( null, [ true, options ].concat(args) ) :
			options;

		// prevent calls to internal methods
		if ( isMethodCall && options.charAt( 0 ) === "_" ) {
			return returnValue;
		}

		if ( isMethodCall ) {
			this.each(function() {
				var instance = $.data( this, name ),
					methodValue = instance && $.isFunction( instance[options] ) ?
						instance[ options ].apply( instance, args ) :
						instance;
				// TODO: add this back in 1.9 and use $.error() (see #5972)
//				if ( !instance ) {
//					throw "cannot call methods on " + name + " prior to initialization; " +
//						"attempted to call method '" + options + "'";
//				}
//				if ( !$.isFunction( instance[options] ) ) {
//					throw "no such method '" + options + "' for " + name + " widget instance";
//				}
//				var methodValue = instance[ options ].apply( instance, args );
				if ( methodValue !== instance && methodValue !== undefined ) {
					returnValue = methodValue;
					return false;
				}
			});
		} else {
			this.each(function() {
				var instance = $.data( this, name );
				if ( instance ) {
					instance.option( options || {} )._init();
				} else {
					$.data( this, name, new object( options, this ) );
				}
			});
		}

		return returnValue;
	};
};

$.Widget = function( options, element ) {
	// allow instantiation without initializing for simple inheritance
	if ( arguments.length ) {
		this._createWidget( options, element );
	}
};

$.Widget.prototype = {
	widgetName: "widget",
	widgetEventPrefix: "",
	options: {
		disabled: false
	},
	_createWidget: function( options, element ) {
		// $.widget.bridge stores the plugin instance, but we do it anyway
		// so that it's stored even before the _create function runs
		$.data( element, this.widgetName, this );
		this.element = $( element );
		this.options = $.extend( true, {},
			this.options,
			this._getCreateOptions(),
			options );

		var self = this;
		this.element.bind( "remove." + this.widgetName, function() {
			self.destroy();
		});

		this._create();
		this._trigger( "create" );
		this._init();
	},
	_getCreateOptions: function() {
		return $.metadata && $.metadata.get( this.element[0] )[ this.widgetName ];
	},
	_create: function() {},
	_init: function() {},

	destroy: function() {
		this.element
			.unbind( "." + this.widgetName )
			.removeData( this.widgetName );
		this.widget()
			.unbind( "." + this.widgetName )
			.removeAttr( "aria-disabled" )
			.removeClass(
				this.widgetBaseClass + "-disabled " +
				"ui-state-disabled" );
	},

	widget: function() {
		return this.element;
	},

	option: function( key, value ) {
		var options = key;

		if ( arguments.length === 0 ) {
			// don't return a reference to the internal hash
			return $.extend( {}, this.options );
		}

		if  (typeof key === "string" ) {
			if ( value === undefined ) {
				return this.options[ key ];
			}
			options = {};
			options[ key ] = value;
		}

		this._setOptions( options );

		return this;
	},
	_setOptions: function( options ) {
		var self = this;
		$.each( options, function( key, value ) {
			self._setOption( key, value );
		});

		return this;
	},
	_setOption: function( key, value ) {
		this.options[ key ] = value;

		if ( key === "disabled" ) {
			this.widget()
				[ value ? "addClass" : "removeClass"](
					this.widgetBaseClass + "-disabled" + " " +
					"ui-state-disabled" )
				.attr( "aria-disabled", value );
		}

		return this;
	},

	enable: function() {
		return this._setOption( "disabled", false );
	},
	disable: function() {
		return this._setOption( "disabled", true );
	},

	_trigger: function( type, event, data ) {
		var callback = this.options[ type ];

		event = $.Event( event );
		event.type = ( type === this.widgetEventPrefix ?
			type :
			this.widgetEventPrefix + type ).toLowerCase();
		data = data || {};

		// copy original event properties over to the new event
		// this would happen if we could call $.event.fix instead of $.Event
		// but we don't have a way to force an event to be fixed multiple times
		if ( event.originalEvent ) {
			for ( var i = $.event.props.length, prop; i; ) {
				prop = $.event.props[ --i ];
				event[ prop ] = event.originalEvent[ prop ];
			}
		}

		this.element.trigger( event, data );

		return !( $.isFunction(callback) &&
			callback.call( this.element[0], event, data ) === false ||
			event.isDefaultPrevented() );
	}
};

})( jQuery );

/*
 * jQuery UI Position 1.8.11
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Position
 */
(function( $, undefined ) {

$.ui = $.ui || {};

var horizontalPositions = /left|center|right/,
	verticalPositions = /top|center|bottom/,
	center = "center",
	_position = $.fn.position,
	_offset = $.fn.offset;

$.fn.position = function( options ) {
	if ( !options || !options.of ) {
		return _position.apply( this, arguments );
	}

	// make a copy, we don't want to modify arguments
	options = $.extend( {}, options );

	var target = $( options.of ),
		targetElem = target[0],
		collision = ( options.collision || "flip" ).split( " " ),
		offset = options.offset ? options.offset.split( " " ) : [ 0, 0 ],
		targetWidth,
		targetHeight,
		basePosition;

	if ( targetElem.nodeType === 9 ) {
		targetWidth = target.width();
		targetHeight = target.height();
		basePosition = { top: 0, left: 0 };
	// TODO: use $.isWindow() in 1.9
	} else if ( targetElem.setTimeout ) {
		targetWidth = target.width();
		targetHeight = target.height();
		basePosition = { top: target.scrollTop(), left: target.scrollLeft() };
	} else if ( targetElem.preventDefault ) {
		// force left top to allow flipping
		options.at = "left top";
		targetWidth = targetHeight = 0;
		basePosition = { top: options.of.pageY, left: options.of.pageX };
	} else {
		targetWidth = target.outerWidth();
		targetHeight = target.outerHeight();
		basePosition = target.offset();
	}

	// force my and at to have valid horizontal and veritcal positions
	// if a value is missing or invalid, it will be converted to center 
	$.each( [ "my", "at" ], function() {
		var pos = ( options[this] || "" ).split( " " );
		if ( pos.length === 1) {
			pos = horizontalPositions.test( pos[0] ) ?
				pos.concat( [center] ) :
				verticalPositions.test( pos[0] ) ?
					[ center ].concat( pos ) :
					[ center, center ];
		}
		pos[ 0 ] = horizontalPositions.test( pos[0] ) ? pos[ 0 ] : center;
		pos[ 1 ] = verticalPositions.test( pos[1] ) ? pos[ 1 ] : center;
		options[ this ] = pos;
	});

	// normalize collision option
	if ( collision.length === 1 ) {
		collision[ 1 ] = collision[ 0 ];
	}

	// normalize offset option
	offset[ 0 ] = parseInt( offset[0], 10 ) || 0;
	if ( offset.length === 1 ) {
		offset[ 1 ] = offset[ 0 ];
	}
	offset[ 1 ] = parseInt( offset[1], 10 ) || 0;

	if ( options.at[0] === "right" ) {
		basePosition.left += targetWidth;
	} else if ( options.at[0] === center ) {
		basePosition.left += targetWidth / 2;
	}

	if ( options.at[1] === "bottom" ) {
		basePosition.top += targetHeight;
	} else if ( options.at[1] === center ) {
		basePosition.top += targetHeight / 2;
	}

	basePosition.left += offset[ 0 ];
	basePosition.top += offset[ 1 ];

	return this.each(function() {
		var elem = $( this ),
			elemWidth = elem.outerWidth(),
			elemHeight = elem.outerHeight(),
			marginLeft = parseInt( $.curCSS( this, "marginLeft", true ) ) || 0,
			marginTop = parseInt( $.curCSS( this, "marginTop", true ) ) || 0,
			collisionWidth = elemWidth + marginLeft +
				( parseInt( $.curCSS( this, "marginRight", true ) ) || 0 ),
			collisionHeight = elemHeight + marginTop +
				( parseInt( $.curCSS( this, "marginBottom", true ) ) || 0 ),
			position = $.extend( {}, basePosition ),
			collisionPosition;

		if ( options.my[0] === "right" ) {
			position.left -= elemWidth;
		} else if ( options.my[0] === center ) {
			position.left -= elemWidth / 2;
		}

		if ( options.my[1] === "bottom" ) {
			position.top -= elemHeight;
		} else if ( options.my[1] === center ) {
			position.top -= elemHeight / 2;
		}

		// prevent fractions (see #5280)
		position.left = Math.round( position.left );
		position.top = Math.round( position.top );

		collisionPosition = {
			left: position.left - marginLeft,
			top: position.top - marginTop
		};

		$.each( [ "left", "top" ], function( i, dir ) {
			if ( $.ui.position[ collision[i] ] ) {
				$.ui.position[ collision[i] ][ dir ]( position, {
					targetWidth: targetWidth,
					targetHeight: targetHeight,
					elemWidth: elemWidth,
					elemHeight: elemHeight,
					collisionPosition: collisionPosition,
					collisionWidth: collisionWidth,
					collisionHeight: collisionHeight,
					offset: offset,
					my: options.my,
					at: options.at
				});
			}
		});

		if ( $.fn.bgiframe ) {
			elem.bgiframe();
		}
		elem.offset( $.extend( position, { using: options.using } ) );
	});
};

$.ui.position = {
	fit: {
		left: function( position, data ) {
			var win = $( window ),
				over = data.collisionPosition.left + data.collisionWidth - win.width() - win.scrollLeft();
			position.left = over > 0 ? position.left - over : Math.max( position.left - data.collisionPosition.left, position.left );
		},
		top: function( position, data ) {
			var win = $( window ),
				over = data.collisionPosition.top + data.collisionHeight - win.height() - win.scrollTop();
			position.top = over > 0 ? position.top - over : Math.max( position.top - data.collisionPosition.top, position.top );
		}
	},

	flip: {
		left: function( position, data ) {
			if ( data.at[0] === center ) {
				return;
			}
			var win = $( window ),
				over = data.collisionPosition.left + data.collisionWidth - win.width() - win.scrollLeft(),
				myOffset = data.my[ 0 ] === "left" ?
					-data.elemWidth :
					data.my[ 0 ] === "right" ?
						data.elemWidth :
						0,
				atOffset = data.at[ 0 ] === "left" ?
					data.targetWidth :
					-data.targetWidth,
				offset = -2 * data.offset[ 0 ];
			position.left += data.collisionPosition.left < 0 ?
				myOffset + atOffset + offset :
				over > 0 ?
					myOffset + atOffset + offset :
					0;
		},
		top: function( position, data ) {
			if ( data.at[1] === center ) {
				return;
			}
			var win = $( window ),
				over = data.collisionPosition.top + data.collisionHeight - win.height() - win.scrollTop(),
				myOffset = data.my[ 1 ] === "top" ?
					-data.elemHeight :
					data.my[ 1 ] === "bottom" ?
						data.elemHeight :
						0,
				atOffset = data.at[ 1 ] === "top" ?
					data.targetHeight :
					-data.targetHeight,
				offset = -2 * data.offset[ 1 ];
			position.top += data.collisionPosition.top < 0 ?
				myOffset + atOffset + offset :
				over > 0 ?
					myOffset + atOffset + offset :
					0;
		}
	}
};

// offset setter from jQuery 1.4
if ( !$.offset.setOffset ) {
	$.offset.setOffset = function( elem, options ) {
		// set position first, in-case top/left are set even on static elem
		if ( /static/.test( $.curCSS( elem, "position" ) ) ) {
			elem.style.position = "relative";
		}
		var curElem   = $( elem ),
			curOffset = curElem.offset(),
			curTop    = parseInt( $.curCSS( elem, "top",  true ), 10 ) || 0,
			curLeft   = parseInt( $.curCSS( elem, "left", true ), 10)  || 0,
			props     = {
				top:  (options.top  - curOffset.top)  + curTop,
				left: (options.left - curOffset.left) + curLeft
			};
		
		if ( 'using' in options ) {
			options.using.call( elem, props );
		} else {
			curElem.css( props );
		}
	};

	$.fn.offset = function( options ) {
		var elem = this[ 0 ];
		if ( !elem || !elem.ownerDocument ) { return null; }
		if ( options ) { 
			return this.each(function() {
				$.offset.setOffset( this, options );
			});
		}
		return _offset.call( this );
	};
}

}( jQuery ));

/*
 * jQuery UI Autocomplete 1.8.11
 *
 * Copyright 2011, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Autocomplete
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 *	jquery.ui.position.js
 */
(function( $, undefined ) {

// used to prevent race conditions with remote data sources
var requestIndex = 0;

$.widget( "ui.autocomplete", {
	options: {
		appendTo: "body",
		autoFocus: false,
		delay: 300,
		minLength: 1,
		position: {
			my: "left top",
			at: "left bottom",
			collision: "none"
		},
		source: null
	},

	pending: 0,

	_create: function() {
		var self = this,
			doc = this.element[ 0 ].ownerDocument,
			suppressKeyPress;

		this.element
			.addClass( "ui-autocomplete-input" )
			.attr( "autocomplete", "off" )
			// TODO verify these actually work as intended
			.attr({
				role: "textbox",
				"aria-autocomplete": "list",
				"aria-haspopup": "true"
			})
			.bind( "keydown.autocomplete", function( event ) {
				if ( self.options.disabled || self.element.attr( "readonly" ) ) {
					return;
				}

				suppressKeyPress = false;
				var keyCode = $.ui.keyCode;
				switch( event.keyCode ) {
				case keyCode.PAGE_UP:
					self._move( "previousPage", event );
					break;
				case keyCode.PAGE_DOWN:
					self._move( "nextPage", event );
					break;
				case keyCode.UP:
					self._move( "previous", event );
					// prevent moving cursor to beginning of text field in some browsers
					event.preventDefault();
					break;
				case keyCode.DOWN:
					self._move( "next", event );
					// prevent moving cursor to end of text field in some browsers
					event.preventDefault();
					break;
				case keyCode.ENTER:
				case keyCode.NUMPAD_ENTER:
					// when menu is open and has focus
					if ( self.menu.active ) {
						// #6055 - Opera still allows the keypress to occur
						// which causes forms to submit
						suppressKeyPress = true;
						event.preventDefault();
					}
					//passthrough - ENTER and TAB both select the current element
				case keyCode.TAB:
					if ( !self.menu.active ) {
						return;
					}
					self.menu.select( event );
					break;
				case keyCode.ESCAPE:
					self.element.val( self.term );
					self.close( event );
					break;
				default:
					// keypress is triggered before the input value is changed
					clearTimeout( self.searching );
					self.searching = setTimeout(function() {
						// only search if the value has changed
						if ( self.term != self.element.val() ) {
							self.selectedItem = null;
							self.search( null, event );
						}
					}, self.options.delay );
					break;
				}
			})
			.bind( "keypress.autocomplete", function( event ) {
				if ( suppressKeyPress ) {
					suppressKeyPress = false;
					event.preventDefault();
				}
			})
			.bind( "focus.autocomplete", function() {
				if ( self.options.disabled ) {
					return;
				}

				self.selectedItem = null;
				self.previous = self.element.val();
			})
			.bind( "blur.autocomplete", function( event ) {
				if ( self.options.disabled ) {
					return;
				}

				clearTimeout( self.searching );
				// clicks on the menu (or a button to trigger a search) will cause a blur event
				self.closing = setTimeout(function() {
					self.close( event );
					self._change( event );
				}, 150 );
			});
		this._initSource();
		this.response = function() {
			return self._response.apply( self, arguments );
		};
		this.menu = $( "<ul></ul>" )
			.addClass( "ui-autocomplete" )
			.appendTo( $( this.options.appendTo || "body", doc )[0] )
			// prevent the close-on-blur in case of a "slow" click on the menu (long mousedown)
			.mousedown(function( event ) {
				// clicking on the scrollbar causes focus to shift to the body
				// but we can't detect a mouseup or a click immediately afterward
				// so we have to track the next mousedown and close the menu if
				// the user clicks somewhere outside of the autocomplete
				var menuElement = self.menu.element[ 0 ];
				if ( !$( event.target ).closest( ".ui-menu-item" ).length ) {
					setTimeout(function() {
						$( document ).one( 'mousedown', function( event ) {
							if ( event.target !== self.element[ 0 ] &&
								event.target !== menuElement &&
								!$.ui.contains( menuElement, event.target ) ) {
								self.close();
							}
						});
					}, 1 );
				}

				// use another timeout to make sure the blur-event-handler on the input was already triggered
				setTimeout(function() {
					clearTimeout( self.closing );
				}, 13);
			})
			.menu({
				focus: function( event, ui ) {
					var item = ui.item.data( "item.autocomplete" );
					if ( false !== self._trigger( "focus", event, { item: item } ) ) {
						// use value to match what will end up in the input, if it was a key event
						if ( /^key/.test(event.originalEvent.type) ) {
							self.element.val( item.value );
						}
					}
				},
				selected: function( event, ui ) {
					var item = ui.item.data( "item.autocomplete" ),
						previous = self.previous;

					// only trigger when focus was lost (click on menu)
					if ( self.element[0] !== doc.activeElement ) {
						self.element.focus();
						self.previous = previous;
						// #6109 - IE triggers two focus events and the second
						// is asynchronous, so we need to reset the previous
						// term synchronously and asynchronously :-(
						setTimeout(function() {
							self.previous = previous;
							self.selectedItem = item;
						}, 1);
					}

					if ( false !== self._trigger( "select", event, { item: item } ) ) {
						self.element.val( $('<span />').html( item.value ).text() );
					}
					// reset the term after the select event
					// this allows custom select handling to work properly
					self.term = self.element.val();

					self.close( event );
					self.selectedItem = item;
				},
				blur: function( event, ui ) {
					// don't set the value of the text field if it's already correct
					// this prevents moving the cursor unnecessarily
					if ( self.menu.element.is(":visible") &&
						( self.element.val() !== self.term ) ) {
						self.element.val( self.term );
					}
				}
			})
			.zIndex( this.element.zIndex() + 1 )
			// workaround for jQuery bug #5781 http://dev.jquery.com/ticket/5781
			.css({ top: 0, left: 0 })
			.hide()
			.data( "menu" );
		if ( $.fn.bgiframe ) {
			 this.menu.element.bgiframe();
		}
	},

	destroy: function() {
		this.element
			.removeClass( "ui-autocomplete-input" )
			.removeAttr( "autocomplete" )
			.removeAttr( "role" )
			.removeAttr( "aria-autocomplete" )
			.removeAttr( "aria-haspopup" );
		this.menu.element.remove();
		$.Widget.prototype.destroy.call( this );
	},

	_setOption: function( key, value ) {
		$.Widget.prototype._setOption.apply( this, arguments );
		if ( key === "source" ) {
			this._initSource();
		}
		if ( key === "appendTo" ) {
			this.menu.element.appendTo( $( value || "body", this.element[0].ownerDocument )[0] )
		}
		if ( key === "disabled" && value && this.xhr ) {
			this.xhr.abort();
		}
	},

	_initSource: function() {
		var self = this,
			array,
			url;
		if ( $.isArray(this.options.source) ) {
			array = this.options.source;
			this.source = function( request, response ) {
				response( $.ui.autocomplete.filter(array, request.term) );
			};
		} else if ( typeof this.options.source === "string" ) {
			url = this.options.source;
			this.source = function( request, response ) {
				if ( self.xhr ) {
					self.xhr.abort();
				}
				self.xhr = $.ajax({
					url: url,
					data: request,
					dataType: "json",
					autocompleteRequest: ++requestIndex,
					success: function( data, status ) {
						if ( this.autocompleteRequest === requestIndex ) {
							response( data );
						}
					},
					error: function() {
						if ( this.autocompleteRequest === requestIndex ) {
							response( [] );
						}
					}
				});
			};
		} else {
			this.source = this.options.source;
		}
	},

	search: function( value, event ) {
		value = value != null ? value : this.element.val();

		// always save the actual value, not the one passed as an argument
		this.term = this.element.val();

		if ( value.length < this.options.minLength ) {
			return this.close( event );
		}

		clearTimeout( this.closing );
		if ( this._trigger( "search", event ) === false ) {
			return;
		}

		return this._search( value );
	},

	_search: function( value ) {
		this.pending++;
		this.element.addClass( "ui-autocomplete-loading" );

		this.source( { term: value }, this.response );
	},

	_response: function( content ) {
		if ( !this.options.disabled && content && content.length ) {
			content = this._normalize( content );
			this._suggest( content );
			this._trigger( "open" );
		} else {
			this.close();
		}
		this.pending--;
		if ( !this.pending ) {
			this.element.removeClass( "ui-autocomplete-loading" );
		}
	},

	close: function( event ) {
		clearTimeout( this.closing );
		if ( this.menu.element.is(":visible") ) {
			this.menu.element.hide();
			this.menu.deactivate();
			this._trigger( "close", event );
		}
	},
	
	_change: function( event ) {
		if ( this.previous !== this.element.val() ) {
			this._trigger( "change", event, { item: this.selectedItem } );
		}
	},

	_normalize: function( items ) {
		// assume all items have the right format when the first item is complete
		if ( items.length && items[0].label && items[0].value ) {
			return items;
		}
		return $.map( items, function(item) {
			if ( typeof item === "string" ) {
				return {
					label: item,
					value: item
				};
			}
			return $.extend({
				label: item.label || item.value,
				value: item.value || item.label
			}, item );
		});
	},

	_suggest: function( items ) {
		var ul = this.menu.element
			.empty()
			.zIndex( this.element.zIndex() + 1 );
		this._renderMenu( ul, items );
		// TODO refresh should check if the active item is still in the dom, removing the need for a manual deactivate
		this.menu.deactivate();
		this.menu.refresh();

		// size and position menu
		ul.show();
		this._resizeMenu();
		ul.position( $.extend({
			of: this.element
		}, this.options.position ));

		if ( this.options.autoFocus ) {
			this.menu.next( new $.Event("mouseover") );
		}
	},

	_resizeMenu: function() {
		var ul = this.menu.element;
		ul.outerWidth( Math.max(
			ul.width( "" ).outerWidth(),
			this.element.outerWidth()
		) );
	},

	_renderMenu: function( ul, items ) {
		var self = this;
		$.each( items, function( index, item ) {
			self._renderItem( ul, item );
		});
	},

	_renderItem: function( ul, item) {
		return $( "<li></li>" )
			.data( "item.autocomplete", item )
			.append( $( "<a></a>" ).text( item.label ) )
			.appendTo( ul );
	},

	_move: function( direction, event ) {
		if ( !this.menu.element.is(":visible") ) {
			this.search( null, event );
			return;
		}
		if ( this.menu.first() && /^previous/.test(direction) ||
				this.menu.last() && /^next/.test(direction) ) {
			this.element.val( this.term );
			this.menu.deactivate();
			return;
		}
		this.menu[ direction ]( event );
	},

	widget: function() {
		return this.menu.element;
	}
});

$.extend( $.ui.autocomplete, {
	escapeRegex: function( value ) {
		return value.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
	},
	filter: function(array, term) {
		var matcher = new RegExp( $.ui.autocomplete.escapeRegex(term), "i" );
		return $.grep( array, function(value) {
			return matcher.test( value.label || value.value || value );
		});
	}
});

}( jQuery ));

/*
 * jQuery UI Menu (not officially released - included with ui.autocomplete)
 * 
 * This widget isn't yet finished and the API is subject to change. We plan to finish
 * it for the next release. You're welcome to give it a try anyway and give us feedback,
 * as long as you're okay with migrating your code later on. We can help with that, too.
 *
 * Copyright 2010, AUTHORS.txt (http://jqueryui.com/about)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * http://docs.jquery.com/UI/Menu
 *
 * Depends:
 *	jquery.ui.core.js
 *  jquery.ui.widget.js
 */
(function($) {

$.widget("ui.menu", {
	_create: function() {
		var self = this;
		this.element
			.addClass("ui-menu ui-widget ui-widget-content ui-corner-all")
			.attr({
				role: "listbox",
				"aria-activedescendant": "ui-active-menuitem"
			})
			.click(function( event ) {
				if ( !$( event.target ).closest( ".ui-menu-item a" ).length ) {
					return;
				}
				// temporary
				event.preventDefault();
				self.select( event );
			});
		this.refresh();
	},
	
	refresh: function() {
		var self = this;

		// don't refresh list items that are already adapted
		var items = this.element.children("li:not(.ui-menu-item):has(a)")
			.addClass("ui-menu-item")
			.attr("role", "menuitem");
		
		items.children("a")
			.addClass("ui-corner-all")
			.attr("tabindex", -1)
			// mouseenter doesn't work with event delegation
			.mouseenter(function( event ) {
				self.activate( event, $(this).parent() );
			})
			.mouseleave(function() {
				self.deactivate();
			});
	},

	activate: function( event, item ) {
		this.deactivate();
		if (this.hasScroll()) {
			var offset = item.offset().top - this.element.offset().top,
				scroll = this.element.attr("scrollTop"),
				elementHeight = this.element.height();
			if (offset < 0) {
				this.element.attr("scrollTop", scroll + offset);
			} else if (offset >= elementHeight) {
				this.element.attr("scrollTop", scroll + offset - elementHeight + item.height());
			}
		}
		this.active = item.eq(0)
			.children("a")
				.addClass("ui-state-hover")
				.attr("id", "ui-active-menuitem")
			.end();
		this._trigger("focus", event, { item: item });
	},

	deactivate: function() {
		if (!this.active) { return; }

		this.active.children("a")
			.removeClass("ui-state-hover")
			.removeAttr("id");
		this._trigger("blur");
		this.active = null;
	},

	next: function(event) {
		this.move("next", ".ui-menu-item:first", event);
	},

	previous: function(event) {
		this.move("prev", ".ui-menu-item:last", event);
	},

	first: function() {
		return this.active && !this.active.prevAll(".ui-menu-item").length;
	},

	last: function() {
		return this.active && !this.active.nextAll(".ui-menu-item").length;
	},

	move: function(direction, edge, event) {
		if (!this.active) {
			this.activate(event, this.element.children(edge));
			return;
		}
		var next = this.active[direction + "All"](".ui-menu-item").eq(0);
		if (next.length) {
			this.activate(event, next);
		} else {
			this.activate(event, this.element.children(edge));
		}
	},

	// TODO merge with previousPage
	nextPage: function(event) {
		if (this.hasScroll()) {
			// TODO merge with no-scroll-else
			if (!this.active || this.last()) {
				this.activate(event, this.element.children(".ui-menu-item:first"));
				return;
			}
			var base = this.active.offset().top,
				height = this.element.height(),
				result = this.element.children(".ui-menu-item").filter(function() {
					var close = $(this).offset().top - base - height + $(this).height();
					// TODO improve approximation
					return close < 10 && close > -10;
				});

			// TODO try to catch this earlier when scrollTop indicates the last page anyway
			if (!result.length) {
				result = this.element.children(".ui-menu-item:last");
			}
			this.activate(event, result);
		} else {
			this.activate(event, this.element.children(".ui-menu-item")
				.filter(!this.active || this.last() ? ":first" : ":last"));
		}
	},

	// TODO merge with nextPage
	previousPage: function(event) {
		if (this.hasScroll()) {
			// TODO merge with no-scroll-else
			if (!this.active || this.first()) {
				this.activate(event, this.element.children(".ui-menu-item:last"));
				return;
			}

			var base = this.active.offset().top,
				height = this.element.height();
				result = this.element.children(".ui-menu-item").filter(function() {
					var close = $(this).offset().top - base + height - $(this).height();
					// TODO improve approximation
					return close < 10 && close > -10;
				});

			// TODO try to catch this earlier when scrollTop indicates the last page anyway
			if (!result.length) {
				result = this.element.children(".ui-menu-item:first");
			}
			this.activate(event, result);
		} else {
			this.activate(event, this.element.children(".ui-menu-item")
				.filter(!this.active || this.first() ? ":last" : ":first"));
		}
	},

	hasScroll: function() {
		return this.element.height() < this.element.attr("scrollHeight");
	},

	select: function( event ) {
		this._trigger("selected", event, { item: this.active });
	}
});

}(jQuery));


/*
 * TNF Assisted Search
 * jQuery UI Autocomplete Extension
 *
 * this plugin allows for the two column product/group response
 * and prepares the html snippets for TNF product searches
 */
(function( $ ) {

var uiacprototype = $.ui.autocomplete.prototype,
	ui_renderMenu = uiacprototype._renderMenu,
	ui_renderItem = uiacprototype._renderItem;

$.extend( uiacprototype, {
	_search: function( value ) {
		this.pending++;
		this.element.addClass( "ui-autocomplete-loading" );
		if (this.options.asearch) {
			var searchBtn = this.element.siblings('.search-submit');
			searchBtn.attr('src',searchBtn.data('loading'));
		}
		this.source( { term: value }, this.response );
	},
	_response: function( content ) {
		if ( !this.options.disabled && content && content.length ) {
			content = this._normalize( content );
			this._suggest( content );
			this._trigger( "open" );
		} else {
			this.close();
		}
		this.pending--;
		if ( !this.pending ) {
			this.element.removeClass( "ui-autocomplete-loading" );
			if (this.options.asearch) {
			var searchBtn = this.element.siblings('.search-submit');
			searchBtn.attr('src',searchBtn.data('button'));
			}
		}
	},
	_renderMenu: function( ul, items ) {
		if (this.options.asearch) {
			var self = this;
			var isProducts = false;			
			var displayClass = 'none';
			
			if (items[0].type === 'product') {
				isProducts = true;
				displayClass = 'strong';
			}
			
			if (isProducts) { 
				displayClass = 'complete';
			}
			
			$(ul).html('<li><div class="panel-carrot"></div><div id="asearch-results" class="panel-wrap '+displayClass+'"><div class="asearch-inner"></div></div></li>');
			
			var resultsProducts = '';			
			var resultsBottom = '<div class="clr"></div><div class="asearch-bottom">'+TNF.assisted_search._widget.data('result_link')+'</div>';
			
			var ulProducts = $('<ul></ul>');			
			var num = -1;
			
			$.each( items, function( index, item ) {
				self._renderItem( ulProducts, item ); 
			});
			
			if ( isProducts ) {
				resultsProducts = $('<div class="asearch-products"></div>');
				resultsProducts.append('<h2>'+TNF.lang.AUTOCOMPLETE.get('PRODUCTS')+'</h2>').append(ulProducts);
			}
			
			$('.asearch-inner',ul).append(resultsProducts).append(resultsBottom); 
		} else {
			ui_renderMenu.call(this, ul, items);
		}
	},

	_renderItem: function( ul, item) {
		if (this.options.asearch) {
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( $( "<a></a>" ).attr('href',item.url).html( item.label ) )
				.appendTo( ul );
		} else {
			ui_renderItem.call(this, ul, item);
		}
	}
});

var uimenuprototype = $.ui.menu.prototype,
	ui_refresh = uimenuprototype.refresh;

$.extend( uimenuprototype, {
	refresh: function() {
		if (this.element.parent().hasClass('asearch-results-wrap')) {
			var self = this;
			// items are not simply children
			var items = this.element.find(".asearch-products li") 
				.not('.ui-menu-item')
				.addClass("ui-menu-item")
				.attr("role", "menuitem");
			
			items.children("a")
				.attr("tabindex", -1)
				.mouseenter(function( event ) {
					self.activate( event, $(this).parent() );
				})
				.mouseleave(function() {
					self.deactivate();
				});
		} else {
			ui_refresh.call(this);
		}
	},
	first: function() {
		return this.active && this.active.html()==this.element.find('.ui-menu-item:first').html();
	},
	last: function() {
		return this.active && this.active.html()==this.element.find('.ui-menu-item:last').html();
	},
	move: function(direction, edge, event) {
		if (!this.active) {
			this.activate(event, this.element.find(edge));
			return;
		}
		var items = this.element.find('.ui-menu-item');
		var active = this.active;
		$.each( items, function(index, item) {
			if (active.html() == $(item).html()) {
				var inc = +1;
				if (direction == 'prev') {
					inc = -1;
				}
				next = items.eq(index+inc);
			}
		});
		if (next.length) {
			this.activate(event, next);
		} else {
			this.activate(event, this.element.find(edge));
		}
	}
});


})( jQuery );


/*! Copyright (c) 2011 Brandon Aaron (http://brandonaaron.net)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Thanks to: http://adomas.org/javascript-mouse-wheel/ for some pointers.
 * Thanks to: Mathias Bank(http://www.mathias-bank.de) for a scope bug fix.
 * Thanks to: Seamus Leahy for adding deltaX and deltaY
 *
 * Version: 3.0.6
 * 
 * Requires: 1.2.2+
 */

(function($) {

var types = ['DOMMouseScroll', 'mousewheel'];

if ($.event.fixHooks) {
    for ( var i=types.length; i; ) {
        $.event.fixHooks[ types[--i] ] = $.event.mouseHooks;
    }
}

$.event.special.mousewheel = {
    setup: function() {
        if ( this.addEventListener ) {
            for ( var i=types.length; i; ) {
                this.addEventListener( types[--i], handler, false );
            }
        } else {
            this.onmousewheel = handler;
        }
    },
    
    teardown: function() {
        if ( this.removeEventListener ) {
            for ( var i=types.length; i; ) {
                this.removeEventListener( types[--i], handler, false );
            }
        } else {
            this.onmousewheel = null;
        }
    }
};

$.fn.extend({
    mousewheel: function(fn) {
        return fn ? this.bind("mousewheel", fn) : this.trigger("mousewheel");
    },
    
    unmousewheel: function(fn) {
        return this.unbind("mousewheel", fn);
    }
});


function handler(event) {
    var orgEvent = event || window.event, args = [].slice.call( arguments, 1 ), delta = 0, returnValue = true, deltaX = 0, deltaY = 0;
    event = $.event.fix(orgEvent);
    event.type = "mousewheel";
    
    // Old school scrollwheel delta
    if ( orgEvent.wheelDelta ) { delta = orgEvent.wheelDelta/120; }
    if ( orgEvent.detail     ) { delta = -orgEvent.detail/3; }
    
    // New school multidimensional scroll (touchpads) deltas
    deltaY = delta;
    
    // Gecko
    if ( orgEvent.axis !== undefined && orgEvent.axis === orgEvent.HORIZONTAL_AXIS ) {
        deltaY = 0;
        deltaX = -1*delta;
    }
    
    // Webkit
    if ( orgEvent.wheelDeltaY !== undefined ) { deltaY = orgEvent.wheelDeltaY/120; }
    if ( orgEvent.wheelDeltaX !== undefined ) { deltaX = -1*orgEvent.wheelDeltaX/120; }
    
    // Add event and delta to the front of the arguments
    args.unshift(event, delta, deltaX, deltaY);
    
    return ($.event.dispatch || $.event.handle).apply(this, args);
}

})(jQuery);


/*
 * jScrollPane - v2.0.0beta12 - 2012-05-14
 * http://jscrollpane.kelvinluck.com/
 *
 * Copyright (c) 2010 Kelvin Luck
 * Dual licensed under the MIT and GPL licenses.
 */
(function(b,a,c){b.fn.jScrollPane=function(e){function d(D,O){var ay,Q=this,Y,aj,v,al,T,Z,y,q,az,aE,au,i,I,h,j,aa,U,ap,X,t,A,aq,af,am,G,l,at,ax,x,av,aH,f,L,ai=true,P=true,aG=false,k=false,ao=D.clone(false,false).empty(),ac=b.fn.mwheelIntent?"mwheelIntent.jsp":"mousewheel.jsp";aH=D.css("paddingTop")+" "+D.css("paddingRight")+" "+D.css("paddingBottom")+" "+D.css("paddingLeft");f=(parseInt(D.css("paddingLeft"),10)||0)+(parseInt(D.css("paddingRight"),10)||0);function ar(aQ){var aL,aN,aM,aJ,aI,aP,aO=false,aK=false;ay=aQ;if(Y===c){aI=D.scrollTop();aP=D.scrollLeft();D.css({overflow:"hidden",padding:0});aj=D.innerWidth()+f;v=D.innerHeight();D.width(aj);Y=b('<div class="jspPane" />').css("padding",aH).append(D.children());al=b('<div class="jspContainer" />').css({width:aj+"px",height:v+"px"}).append(Y).appendTo(D)}else{D.css("width","");aO=ay.stickToBottom&&K();aK=ay.stickToRight&&B();aJ=D.innerWidth()+f!=aj||D.outerHeight()!=v;if(aJ){aj=D.innerWidth()+f;v=D.innerHeight();al.css({width:aj+"px",height:v+"px"})}if(!aJ&&L==T&&Y.outerHeight()==Z){D.width(aj);return}L=T;Y.css("width","");D.width(aj);al.find(">.jspVerticalBar,>.jspHorizontalBar").remove().end()}Y.css("overflow","auto");if(aQ.contentWidth){T=aQ.contentWidth}else{T=Y[0].scrollWidth}Z=Y[0].scrollHeight;Y.css("overflow","");y=T/aj;q=Z/v;az=q>1;aE=y>1;if(!(aE||az)){D.removeClass("jspScrollable");Y.css({top:0,width:al.width()-f});n();E();R();w()}else{D.addClass("jspScrollable");aL=ay.maintainPosition&&(I||aa);if(aL){aN=aC();aM=aA()}aF();z();F();if(aL){N(aK?(T-aj):aN,false);M(aO?(Z-v):aM,false)}J();ag();an();if(ay.enableKeyboardNavigation){S()}if(ay.clickOnTrack){p()}C();if(ay.hijackInternalLinks){m()}}if(ay.autoReinitialise&&!av){av=setInterval(function(){ar(ay)},ay.autoReinitialiseDelay)}else{if(!ay.autoReinitialise&&av){clearInterval(av)}}aI&&D.scrollTop(0)&&M(aI,false);aP&&D.scrollLeft(0)&&N(aP,false);D.trigger("jsp-initialised",[aE||az])}function aF(){if(az){al.append(b('<div class="jspVerticalBar" />').append(b('<div class="jspCap jspCapTop" />'),b('<div class="jspTrack" />').append(b('<div class="jspDrag" />').append(b('<div class="jspDragTop" />'),b('<div class="jspDragBottom" />'))),b('<div class="jspCap jspCapBottom" />')));U=al.find(">.jspVerticalBar");ap=U.find(">.jspTrack");au=ap.find(">.jspDrag");if(ay.showArrows){aq=b('<a class="jspArrow jspArrowUp" />').bind("mousedown.jsp",aD(0,-1)).bind("click.jsp",aB);af=b('<a class="jspArrow jspArrowDown" />').bind("mousedown.jsp",aD(0,1)).bind("click.jsp",aB);if(ay.arrowScrollOnHover){aq.bind("mouseover.jsp",aD(0,-1,aq));af.bind("mouseover.jsp",aD(0,1,af))}ak(ap,ay.verticalArrowPositions,aq,af)}t=v;al.find(">.jspVerticalBar>.jspCap:visible,>.jspVerticalBar>.jspArrow").each(function(){t-=b(this).outerHeight()});au.hover(function(){au.addClass("jspHover")},function(){au.removeClass("jspHover")}).bind("mousedown.jsp",function(aI){b("html").bind("dragstart.jsp selectstart.jsp",aB);au.addClass("jspActive");var s=aI.pageY-au.position().top;b("html").bind("mousemove.jsp",function(aJ){V(aJ.pageY-s,false)}).bind("mouseup.jsp mouseleave.jsp",aw);return false});o()}}function o(){ap.height(t+"px");I=0;X=ay.verticalGutter+ap.outerWidth();Y.width(aj-X-f);try{if(U.position().left===0){Y.css("margin-left",X+"px")}}catch(s){}}function z(){if(aE){al.append(b('<div class="jspHorizontalBar" />').append(b('<div class="jspCap jspCapLeft" />'),b('<div class="jspTrack" />').append(b('<div class="jspDrag" />').append(b('<div class="jspDragLeft" />'),b('<div class="jspDragRight" />'))),b('<div class="jspCap jspCapRight" />')));am=al.find(">.jspHorizontalBar");G=am.find(">.jspTrack");h=G.find(">.jspDrag");if(ay.showArrows){ax=b('<a class="jspArrow jspArrowLeft" />').bind("mousedown.jsp",aD(-1,0)).bind("click.jsp",aB);x=b('<a class="jspArrow jspArrowRight" />').bind("mousedown.jsp",aD(1,0)).bind("click.jsp",aB);
if(ay.arrowScrollOnHover){ax.bind("mouseover.jsp",aD(-1,0,ax));x.bind("mouseover.jsp",aD(1,0,x))}ak(G,ay.horizontalArrowPositions,ax,x)}h.hover(function(){h.addClass("jspHover")},function(){h.removeClass("jspHover")}).bind("mousedown.jsp",function(aI){b("html").bind("dragstart.jsp selectstart.jsp",aB);h.addClass("jspActive");var s=aI.pageX-h.position().left;b("html").bind("mousemove.jsp",function(aJ){W(aJ.pageX-s,false)}).bind("mouseup.jsp mouseleave.jsp",aw);return false});l=al.innerWidth();ah()}}function ah(){al.find(">.jspHorizontalBar>.jspCap:visible,>.jspHorizontalBar>.jspArrow").each(function(){l-=b(this).outerWidth()});G.width(l+"px");aa=0}function F(){if(aE&&az){var aI=G.outerHeight(),s=ap.outerWidth();t-=aI;b(am).find(">.jspCap:visible,>.jspArrow").each(function(){l+=b(this).outerWidth()});l-=s;v-=s;aj-=aI;G.parent().append(b('<div class="jspCorner" />').css("width",aI+"px"));o();ah()}if(aE){Y.width((al.outerWidth()-f)+"px")}Z=Y.outerHeight();q=Z/v;if(aE){at=Math.ceil(1/y*l);if(at>ay.horizontalDragMaxWidth){at=ay.horizontalDragMaxWidth}else{if(at<ay.horizontalDragMinWidth){at=ay.horizontalDragMinWidth}}h.width(at+"px");j=l-at;ae(aa)}if(az){A=Math.ceil(1/q*t);if(A>ay.verticalDragMaxHeight){A=ay.verticalDragMaxHeight}else{if(A<ay.verticalDragMinHeight){A=ay.verticalDragMinHeight}}au.height(A+"px");i=t-A;ad(I)}}function ak(aJ,aL,aI,s){var aN="before",aK="after",aM;if(aL=="os"){aL=/Mac/.test(navigator.platform)?"after":"split"}if(aL==aN){aK=aL}else{if(aL==aK){aN=aL;aM=aI;aI=s;s=aM}}aJ[aN](aI)[aK](s)}function aD(aI,s,aJ){return function(){H(aI,s,this,aJ);this.blur();return false}}function H(aL,aK,aO,aN){aO=b(aO).addClass("jspActive");var aM,aJ,aI=true,s=function(){if(aL!==0){Q.scrollByX(aL*ay.arrowButtonSpeed)}if(aK!==0){Q.scrollByY(aK*ay.arrowButtonSpeed)}aJ=setTimeout(s,aI?ay.initialDelay:ay.arrowRepeatFreq);aI=false};s();aM=aN?"mouseout.jsp":"mouseup.jsp";aN=aN||b("html");aN.bind(aM,function(){aO.removeClass("jspActive");aJ&&clearTimeout(aJ);aJ=null;aN.unbind(aM)})}function p(){w();if(az){ap.bind("mousedown.jsp",function(aN){if(aN.originalTarget===c||aN.originalTarget==aN.currentTarget){var aL=b(this),aO=aL.offset(),aM=aN.pageY-aO.top-I,aJ,aI=true,s=function(){var aR=aL.offset(),aS=aN.pageY-aR.top-A/2,aP=v*ay.scrollPagePercent,aQ=i*aP/(Z-v);if(aM<0){if(I-aQ>aS){Q.scrollByY(-aP)}else{V(aS)}}else{if(aM>0){if(I+aQ<aS){Q.scrollByY(aP)}else{V(aS)}}else{aK();return}}aJ=setTimeout(s,aI?ay.initialDelay:ay.trackClickRepeatFreq);aI=false},aK=function(){aJ&&clearTimeout(aJ);aJ=null;b(document).unbind("mouseup.jsp",aK)};s();b(document).bind("mouseup.jsp",aK);return false}})}if(aE){G.bind("mousedown.jsp",function(aN){if(aN.originalTarget===c||aN.originalTarget==aN.currentTarget){var aL=b(this),aO=aL.offset(),aM=aN.pageX-aO.left-aa,aJ,aI=true,s=function(){var aR=aL.offset(),aS=aN.pageX-aR.left-at/2,aP=aj*ay.scrollPagePercent,aQ=j*aP/(T-aj);if(aM<0){if(aa-aQ>aS){Q.scrollByX(-aP)}else{W(aS)}}else{if(aM>0){if(aa+aQ<aS){Q.scrollByX(aP)}else{W(aS)}}else{aK();return}}aJ=setTimeout(s,aI?ay.initialDelay:ay.trackClickRepeatFreq);aI=false},aK=function(){aJ&&clearTimeout(aJ);aJ=null;b(document).unbind("mouseup.jsp",aK)};s();b(document).bind("mouseup.jsp",aK);return false}})}}function w(){if(G){G.unbind("mousedown.jsp")}if(ap){ap.unbind("mousedown.jsp")}}function aw(){b("html").unbind("dragstart.jsp selectstart.jsp mousemove.jsp mouseup.jsp mouseleave.jsp");if(au){au.removeClass("jspActive")}if(h){h.removeClass("jspActive")}}function V(s,aI){if(!az){return}if(s<0){s=0}else{if(s>i){s=i}}if(aI===c){aI=ay.animateScroll}if(aI){Q.animate(au,"top",s,ad)}else{au.css("top",s);ad(s)}}function ad(aI){if(aI===c){aI=au.position().top}al.scrollTop(0);I=aI;var aL=I===0,aJ=I==i,aK=aI/i,s=-aK*(Z-v);if(ai!=aL||aG!=aJ){ai=aL;aG=aJ;D.trigger("jsp-arrow-change",[ai,aG,P,k])}u(aL,aJ);Y.css("top",s);D.trigger("jsp-scroll-y",[-s,aL,aJ]).trigger("scroll")}function W(aI,s){if(!aE){return}if(aI<0){aI=0}else{if(aI>j){aI=j}}if(s===c){s=ay.animateScroll}if(s){Q.animate(h,"left",aI,ae)
}else{h.css("left",aI);ae(aI)}}function ae(aI){if(aI===c){aI=h.position().left}al.scrollTop(0);aa=aI;var aL=aa===0,aK=aa==j,aJ=aI/j,s=-aJ*(T-aj);if(P!=aL||k!=aK){P=aL;k=aK;D.trigger("jsp-arrow-change",[ai,aG,P,k])}r(aL,aK);Y.css("left",s);D.trigger("jsp-scroll-x",[-s,aL,aK]).trigger("scroll")}function u(aI,s){if(ay.showArrows){aq[aI?"addClass":"removeClass"]("jspDisabled");af[s?"addClass":"removeClass"]("jspDisabled")}}function r(aI,s){if(ay.showArrows){ax[aI?"addClass":"removeClass"]("jspDisabled");x[s?"addClass":"removeClass"]("jspDisabled")}}function M(s,aI){var aJ=s/(Z-v);V(aJ*i,aI)}function N(aI,s){var aJ=aI/(T-aj);W(aJ*j,s)}function ab(aV,aQ,aJ){var aN,aK,aL,s=0,aU=0,aI,aP,aO,aS,aR,aT;try{aN=b(aV)}catch(aM){return}aK=aN.outerHeight();aL=aN.outerWidth();al.scrollTop(0);al.scrollLeft(0);while(!aN.is(".jspPane")){s+=aN.position().top;aU+=aN.position().left;aN=aN.offsetParent();if(/^body|html$/i.test(aN[0].nodeName)){return}}aI=aA();aO=aI+v;if(s<aI||aQ){aR=s-ay.verticalGutter}else{if(s+aK>aO){aR=s-v+aK+ay.verticalGutter}}if(aR){M(aR,aJ)}aP=aC();aS=aP+aj;if(aU<aP||aQ){aT=aU-ay.horizontalGutter}else{if(aU+aL>aS){aT=aU-aj+aL+ay.horizontalGutter}}if(aT){N(aT,aJ)}}function aC(){return -Y.position().left}function aA(){return -Y.position().top}function K(){var s=Z-v;return(s>20)&&(s-aA()<10)}function B(){var s=T-aj;return(s>20)&&(s-aC()<10)}function ag(){al.unbind(ac).bind(ac,function(aL,aM,aK,aI){var aJ=aa,s=I;Q.scrollBy(aK*ay.mouseWheelSpeed,-aI*ay.mouseWheelSpeed,false);return aJ==aa&&s==I})}function n(){al.unbind(ac)}function aB(){return false}function J(){Y.find(":input,a").unbind("focus.jsp").bind("focus.jsp",function(s){ab(s.target,false)})}function E(){Y.find(":input,a").unbind("focus.jsp")}function S(){var s,aI,aK=[];aE&&aK.push(am[0]);az&&aK.push(U[0]);Y.focus(function(){D.focus()});D.attr("tabindex",0).unbind("keydown.jsp keypress.jsp").bind("keydown.jsp",function(aN){if(aN.target!==this&&!(aK.length&&b(aN.target).closest(aK).length)){return}var aM=aa,aL=I;switch(aN.keyCode){case 40:case 38:case 34:case 32:case 33:case 39:case 37:s=aN.keyCode;aJ();break;case 35:M(Z-v);s=null;break;case 36:M(0);s=null;break}aI=aN.keyCode==s&&aM!=aa||aL!=I;return !aI}).bind("keypress.jsp",function(aL){if(aL.keyCode==s){aJ()}return !aI});if(ay.hideFocus){D.css("outline","none");if("hideFocus" in al[0]){D.attr("hideFocus",true)}}else{D.css("outline","");if("hideFocus" in al[0]){D.attr("hideFocus",false)}}function aJ(){var aM=aa,aL=I;switch(s){case 40:Q.scrollByY(ay.keyboardSpeed,false);break;case 38:Q.scrollByY(-ay.keyboardSpeed,false);break;case 34:case 32:Q.scrollByY(v*ay.scrollPagePercent,false);break;case 33:Q.scrollByY(-v*ay.scrollPagePercent,false);break;case 39:Q.scrollByX(ay.keyboardSpeed,false);break;case 37:Q.scrollByX(-ay.keyboardSpeed,false);break}aI=aM!=aa||aL!=I;return aI}}function R(){D.attr("tabindex","-1").removeAttr("tabindex").unbind("keydown.jsp keypress.jsp")}function C(){if(location.hash&&location.hash.length>1){var aK,aI,aJ=escape(location.hash.substr(1));try{aK=b("#"+aJ+', a[name="'+aJ+'"]')}catch(s){return}if(aK.length&&Y.find(aJ)){if(al.scrollTop()===0){aI=setInterval(function(){if(al.scrollTop()>0){ab(aK,true);b(document).scrollTop(al.position().top);clearInterval(aI)}},50)}else{ab(aK,true);b(document).scrollTop(al.position().top)}}}}function m(){if(b(document.body).data("jspHijack")){return}b(document.body).data("jspHijack",true);b(document.body).delegate("a[href*=#]","click",function(s){var aI=this.href.substr(0,this.href.indexOf("#")),aK=location.href,aO,aP,aJ,aM,aL,aN;if(location.href.indexOf("#")!==-1){aK=location.href.substr(0,location.href.indexOf("#"))}if(aI!==aK){return}aO=escape(this.href.substr(this.href.indexOf("#")+1));aP;try{aP=b("#"+aO+', a[name="'+aO+'"]')}catch(aQ){return}if(!aP.length){return}aJ=aP.closest(".jspScrollable");aM=aJ.data("jsp");aM.scrollToElement(aP,true);if(aJ[0].scrollIntoView){aL=b(a).scrollTop();aN=aP.offset().top;if(aN<aL||aN>aL+b(a).height()){aJ[0].scrollIntoView()}}s.preventDefault()
})}function an(){var aJ,aI,aL,aK,aM,s=false;al.unbind("touchstart.jsp touchmove.jsp touchend.jsp click.jsp-touchclick").bind("touchstart.jsp",function(aN){var aO=aN.originalEvent.touches[0];aJ=aC();aI=aA();aL=aO.pageX;aK=aO.pageY;aM=false;s=true}).bind("touchmove.jsp",function(aQ){if(!s){return}var aP=aQ.originalEvent.touches[0],aO=aa,aN=I;Q.scrollTo(aJ+aL-aP.pageX,aI+aK-aP.pageY);aM=aM||Math.abs(aL-aP.pageX)>5||Math.abs(aK-aP.pageY)>5;return aO==aa&&aN==I}).bind("touchend.jsp",function(aN){s=false}).bind("click.jsp-touchclick",function(aN){if(aM){aM=false;return false}})}function g(){var s=aA(),aI=aC();D.removeClass("jspScrollable").unbind(".jsp");D.replaceWith(ao.append(Y.children()));ao.scrollTop(s);ao.scrollLeft(aI);if(av){clearInterval(av)}}b.extend(Q,{reinitialise:function(aI){aI=b.extend({},ay,aI);ar(aI)},scrollToElement:function(aJ,aI,s){ab(aJ,aI,s)},scrollTo:function(aJ,s,aI){N(aJ,aI);M(s,aI)},scrollToX:function(aI,s){N(aI,s)},scrollToY:function(s,aI){M(s,aI)},scrollToPercentX:function(aI,s){N(aI*(T-aj),s)},scrollToPercentY:function(aI,s){M(aI*(Z-v),s)},scrollBy:function(aI,s,aJ){Q.scrollByX(aI,aJ);Q.scrollByY(s,aJ)},scrollByX:function(s,aJ){var aI=aC()+Math[s<0?"floor":"ceil"](s),aK=aI/(T-aj);W(aK*j,aJ)},scrollByY:function(s,aJ){var aI=aA()+Math[s<0?"floor":"ceil"](s),aK=aI/(Z-v);V(aK*i,aJ)},positionDragX:function(s,aI){W(s,aI)},positionDragY:function(aI,s){V(aI,s)},animate:function(aI,aL,s,aK){var aJ={};aJ[aL]=s;aI.animate(aJ,{duration:ay.animateDuration,easing:ay.animateEase,queue:false,step:aK})},getContentPositionX:function(){return aC()},getContentPositionY:function(){return aA()},getContentWidth:function(){return T},getContentHeight:function(){return Z},getPercentScrolledX:function(){return aC()/(T-aj)},getPercentScrolledY:function(){return aA()/(Z-v)},getIsScrollableH:function(){return aE},getIsScrollableV:function(){return az},getContentPane:function(){return Y},scrollToBottom:function(s){V(i,s)},hijackInternalLinks:b.noop,destroy:function(){g()}});ar(O)}e=b.extend({},b.fn.jScrollPane.defaults,e);b.each(["mouseWheelSpeed","arrowButtonSpeed","trackClickSpeed","keyboardSpeed"],function(){e[this]=e[this]||e.speed});return this.each(function(){var f=b(this),g=f.data("jsp");if(g){g.reinitialise(e)}else{g=new d(f,e);f.data("jsp",g)}})};b.fn.jScrollPane.defaults={showArrows:false,maintainPosition:true,stickToBottom:false,stickToRight:false,clickOnTrack:true,autoReinitialise:false,autoReinitialiseDelay:500,verticalDragMinHeight:0,verticalDragMaxHeight:99999,horizontalDragMinWidth:0,horizontalDragMaxWidth:99999,contentWidth:c,animateScroll:false,animateDuration:300,animateEase:"linear",hijackInternalLinks:false,verticalGutter:4,horizontalGutter:4,mouseWheelSpeed:0,arrowButtonSpeed:0,arrowRepeatFreq:50,arrowScrollOnHover:false,trackClickSpeed:0,trackClickRepeatFreq:70,verticalArrowPositions:"split",horizontalArrowPositions:"split",enableKeyboardNavigation:true,hideFocus:false,keyboardSpeed:0,initialDelay:300,speed:30,scrollPagePercent:0.8}})(jQuery,this);


/*
 *
 * global TNF
 *
 */
(function (global) {
  var TNF = {
    BRAND: {},
    ECOM: {},
    VERSION: '0.0.1'
  };

  TNF.models = TNF.models || {};
  TNF.models.settings = function(config) {
    var data = config || {};

    this.set = function(key,value) {
      data[key] = value;
    }

    this.get = function(key) {
      if (data[key] === undefined) {
        throw 'Undefined key ' + key;
      }
      return data[key];
    }

    this.setData = function(config) {
      data = config;
    }

    this.getData = function() {
      return data;
    }
  };

  TNF.env = new TNF.models.settings({
    compare_url: '/webapp/wcs/stores/servlet/TNFCompareDisplay',
    compare_add_url: '/webapp/wcs/stores/servlet/TNFCompareItemAdd',
    compare_remove_url: '/webapp/wcs/stores/servlet/TNFCompareItemDelete',
    s7_url: 'http://images.thenorthface.com/',
    store_id: '207',
    category_id: null,
    master_cat_id: null,
    master_cat_id_override: null,
    currency: 'USD',
    trigger_on_hover: false, // Turn on minicart activation via hover 
    desc_limit: 100 // Assisted Search Description Limit
  });

  TNF.env.S7 = new TNF.models.settings({
    company: "TheNorthFace/",
    contentRoot: TNF.env.get('s7_url'),
    isViewerRoot: TNF.env.get('s7_url') + "is-viewers-4.1/",
    isRoot: TNF.env.get('s7_url') + "is/image/",
    skinsRoot: TNF.env.get('s7_url') + "skins/",
    staticRoot: TNF.env.get('s7_url') + "is/content/",
    videoRoot: TNF.env.get('s7_url') + "e2/",
    isIeWin: $.browser.msie ? true : false,
    isFsCommand: true
  });

  TNF.env.URL = new TNF.models.settings({
    STORE_LOCATOR_URL: '/webapp/wcs/stores/servlet/RetailStoreInformation?langId=-1&catalogId=10001&storeId=',
	SEARCH_REQUEST: '/webapp/wcs/stores/servlet/TNFSearchResult',
    ASSISTED_SEARCH: '/webapp/wcs/stores/servlet/TNFSuggestedSearchV2',
    ADD_TO_CART: '/webapp/wcs/stores/servlet/OrderItemAdd?URL=OrderCalculate?URL=/webapp/wcs/stores/servlet/TNFMiniCartBlock&updatePrices=1&calculationUsageId=-1&calculationUsageId=-2&calculationUsageId=-7',
    ADD_TO_WISHLIST: '/webapp/wcs/stores/servlet/InterestItemAdd?URL=/webapp/wcs/stores/servlet/TNFWishListBlock&listIdName=listId',
    COMPARE_PREFIX: '/webapp/wcs/stores/servlet/TNFCompareItemAdd?URL=/webapp/wcs/stores/servlet/TNFCompareDOMWindow&',
    COMPARE_SUFFIX: '&KeepThis=true&startDOMWindow&iframeDOMWindow=true&height=390&width=344',
    GET_MINICART: '/webapp/wcs/stores/servlet/TNFMiniCartBlock',
    COMPARE: '/webapp/wcs/stores/servlet/TNFCompareDisplay', //'/compare/compareDomWindow.html?KeepThis=true&startDOMWindow&iframeDOMWindow=true&height=390&width=344'
    EMAIL_PREFS: '/webapp/wcs/stores/servlet/TNFEmailSubscribe?URL=/webapp/wcs/stores/servlet/TNFEmailPreferencesHopUp&errorView=TNFEmailPreferencesHopUp',
    MERCHANDISER_BASE: '?partNumber=<productId>&variation=<variation>',
    MERCHANDISER_IMG: TNF.env.S7.get('isRoot') + 'TheNorthFace/130x130/Product-<productId>_<variation>_hero.jpg',
    MERCHANDISER_HOPUP: '/webapp/wcs/stores/servlet/TNFQuickView?partNumber=<productId>&iframe=true&height=352&width=819',
	COMPARE_MERCHANDISER_JSON: '/webapp/wcs/stores/servlet/TNFCompareScrollerJson',
	EMAIL_SIGNUP: '/webapp/wcs/stores/servlet/TNFEmailSubscribe?URL=/webapp/wcs/stores/servlet/TNFEmailPreferencesHopUp&errorView=TNFEmailPreferencesHopUp',
    // DEV NOTE: The value below should be updated to be the hopups expected host name.
    // The format is: protocol + host of the hopup
    SIGNIN_HOPUP_URL: 'http://' + window.location.host 
  });

  TNF.lang = new TNF.models.settings({});
  TNF.lang.MSG = new TNF.models.settings({
    DEFAULT_FOOTER_FIND_STORE_ZIP: "Zip Code",
    DEFAULT_FOOTER_EMAIL_UPDATES: "Email Address",
    STORE_LOCATOR_ERROR1: "Enter your zip code to find a store near you.",
    STORE_LOCATOR_ERROR2: ""
  });
  TNF.lang.AUTOCOMPLETE = new TNF.models.settings({
	PRODUCTS: "Products",
	RESULTS: "Results for ",
	VIEW_ALL: "View All "
  });
 TNF.lang.MINICART = new TNF.models.settings({
    EMPTYCART_MSG: "There are no more items in your cart.",
    REMAINING_ITEMS_MSG: "There are %n more items in your cart.",
    SHOPPING_CART: "Edit Cart",
    ITEM_PRICE: "Item Price",
    COLOR: 'Color',
    SIZE: 'Size',
    QTY: 'Qty',
    CLOSE: 'Close',
    REMAINING_ITEMS: 'Remaining items',
    SUBTOTAL: 'Subtotal',
    CHECKOUT: 'Checkout',
    RECENTLY_ADDED: 'Your Cart',
    REMOVE: 'Remove'
  });
  TNF.lang.EMAIL = new TNF.models.settings({
    EMAIL_UPDATES: 'Email Updates',
    ENTER_VALID_EMAIL: 'Please submit a valid email address'
  });
  TNF.vars = new TNF.models.settings({
    STORE_LOCATOR_PARAMS: "",
    ADD_TO_CART_PARAMS: "",
    EMAIL_PREFS_PARAMS:"PARAMS=go_here"
  });

  if (global.TNF) {
    throw new Error('The TNF namespace has already been defined');
  } else {
    global.TNF = TNF;
  }

}(window));

/** Minicart

 Summary:
 - Generate the Minicart HTML
 - Control UI behaviors (show/hide, close, ...)
 - Get JSON obj of product items and total cost
 - Update Minicart HTML with JSON items
 - Remove item and push updated JSON obj
 - Update total product items on invoking element
 - 'no items in cart' case
 - Generic message area
 
 Usage:
 Call TNF.minicart.init() after page load

 To refresh and show Minicart (to not show, add {'refresh':true}
 TNF.minicart.response($('#minicart'))

 */
TNF.minicart = {

	vars: {
		html: {
			header: '<div class="header"><h5></h5><a href="#" class="edit_cart"></a></div>',
			footer: '<div class="footer"><a href="#" id="checkout_trigger" class="flat-button subtotal-checkout"><span class="checkout"></span><span class="subtotal"></span></a></div>',
			promo: '<div class="promo"></div>',
			body: '<div class="body"></div>',
			remove_button: '<a href="#" class="remove_trigger"><span class="lbl"></span><img src="/global/images/ui/blank.gif" class="icon_spr close"></a>'
		},
		url: {
			response: '/webapp/wcs/stores/servlet/TNFMiniCartBlock',
			checkout: '/webapp/wcs/stores/servlet/OrderItemDisplay',
			remove: '/webapp/wcs/stores/servlet/TNFExtendOrderItemDelete' /** ZCG: Support dynamic delete */
		},
        activity: false
	},
	
	dropdown: {
	
		/** show/hide - toggle
		 * @param {Object} options
		 * @param {Object|String} options.trigger_element The element that triggers the event
		 * @param {Object|String} options.element The target element
		 */
		show: function(options) {
			// ensure elements are dom objects
			var $tr_el = (typeof options.trigger_element === 'object') ? options.trigger_element : $('#' + options.trigger_element),
				$el = (typeof options.element === 'object') ? options.element : $('#' + options.element),
				top_pos = $('#minicart').outerHeight();

			var pellet = function(state){
				// Retain hover state on trigger click
				$tr_el.parents('li')[(state === 'on' ? 'add':'remove') + 'Class']('active'); 
			};
							
			// show/hide dropdown
			if ($el.is(':visible')) {
				pellet('off');
				// Hide / Ease out
				$el.animate({top: [-top_pos, 'easeOutCirc']}, 500, function(){
					$(this).hide();
				});
			} else {
				// Show / Ease in
				$el.css({top:-top_pos}).show().animate({top: [58, 'easeInQuad']}, 500, function(){
					pellet('on');
				});
			}
		},
		
		hide: function(options) {
			// ensure elements are dom objects
			var $tr_el = (typeof options.trigger_element === 'object') ? options.trigger_element : $('#' + options.trigger_element),
				$el = (typeof options.element === 'object') ? options.element : $('#' + options.element),
				top_pos = $('#minicart').outerHeight();

			var pellet = function(state){
				// Retain hover state on trigger click
				$tr_el.parents('li')[(state === 'on' ? 'add':'remove') + 'Class']('active');
			};
			
				pellet('off');
				// Hide / Ease out
				$el.animate({top: [-top_pos, 'easeOutCirc']}, 500, function(){
					$(this).hide();
				});
		},
		
		/** position controls
		 * @description The position calculation here is wrong (an arbitrary number makes up for this)
		 * @param {Object} options
		 * @param {Object|String} options.element The triggered element
		 * @param {Object|String} options.target_element The targeted element to be positioned=
		 */
		position: function(options) {
			// ensure elements are objects & set vars
			var $trigger_el = (typeof options.element === 'object') ? options.element : $('#' + options.element),
				$target_el = (typeof options.element === 'object') ? options.target_element : $('#' + options.target_element);
				
			return $target_el.css({ left: $trigger_el.position().left - $target_el.outerWidth() + $trigger_el.outerWidth() + 8 });
		},

		/** loading img ui
		 * @description Sets, positions and show/hides a loader img
		 * @param {Object|String} invoking_element The triggered element
		 * @param {Object} options
		 * @param {String} options.status Switch to show/hide the loader
		 * @param {String} options.status.on
		 * @param {String} options.status.off
		 * @param {Object|String} options.target The target element to append the loader img to
		 */
		loading: function(invoking_element, options) {
		
			// ensure elements are objects
			var	o = options,
				src = {
					white: '/global/images/ui/ajax-loader.gif',
					black: '/global/images/ui/ajax-loader-black.gif'
				},
				pos = {},
				$el = (typeof invoking_element === 'object') ? invoking_element : $('#' + invoking_element),
				$trgt = (typeof o.target === 'object') ? o.target : $('#' + o.target),
				$img = $('<img/>', {'src':src.white, 'class':'loader'}),
				toolbar_height = $('#toolbar').height(),
				loader_width = 25;
			
			var get_position = function() {
				pos.left = $el.offset().left  - ($el.width() / 2) + 10;
				pos.top = $el.offset().top + $el.height() - loader_width;
			};

			var set_position = function(el) {
				$('.loader').css({ left:  pos.left, top: pos.top });
			};
			
			var append = function() {
				if (!$('.loader').is()) {
					if (o.target) {
						$trgt.append($img);
					} else {
						$el.append($img);
					}
				}
			};
				
			// Append, position and show/destroy loader image
			if (o.status === 'on') {
				append();
				get_position();
				$('.loader').attr('src', (toolbar_height > pos.top) ? src.black : src.white );
				set_position($('.loader'));
				$('.loader').fadeIn(150);
				$(window).resize(function(){
					set_position($('.loader'));
				});
			} else if (o.status === 'off') {
				$('.loader').fadeOut(250);
			}
			
			
		}
	},

	/** Generate minicart container
	 */
	generate: function() {
		$('#toolbar .row').append('<div id="minicart">' + TNF.minicart.vars.html.header + TNF.minicart.vars.html.body + TNF.minicart.vars.html.footer + TNF.minicart.vars.html.promo +'</div>');

		$('#minicart').find('.close_trigger .lbl').text(TNF.lang.MINICART.get('CLOSE'))
			.end().find('.subtotal').text(TNF.lang.MINICART.get('SUBTOTAL') + ':') 
			.end().find('.total_items dt a').text(TNF.lang.MINICART.get('SHOPPING_CART') + ':')
			.end().find('.footer .checkout').text(TNF.lang.MINICART.get('CHECKOUT'))
			.end().find('.header h5').text(TNF.lang.MINICART.get('RECENTLY_ADDED'))
			.end().find('.edit_cart').text(TNF.lang.MINICART.get('SHOPPING_CART'));

		// Add checkout url to DOM
		$('#minicart').find('#checkout_trigger,.total_items a,.edit_cart').attr('href',TNF.minicart.vars.url.checkout);
	},
	
	/** set total shopping cart items, and num additional items (if necessary)
	 */
	total_items: function(data) {
		var total_items = 0; 	
		
		$.each(data.products, function(key, item) {
			total_items += item.quantity;
		});
		$('#minicart').find('.header h5').text(TNF.lang.MINICART.get('RECENTLY_ADDED') + ((total_items >= 1) ? ' ('+total_items+')' : ''));
		
    	$('#minicart_trigger').append("<span id='cart-items'>"+total_items+"</span>" );
		$('#minicart .footer')
			.find('.total_items dd').text( total_items + ' item' + ((total_items > 1) || (total_items === 0) ? 's':'') )
				.parent().find('dt a').text(TNF.lang.MINICART.get('SHOPPING_CART') + ':');
		
	},
	
	/** Append subtotal (calculation done on server)
	 * @param {String} amount The calculated subtotal amount
	 */
	subtotal: function(amount) {
		$('#minicart .footer .subtotal').text(amount);
	},
	
	/** Append messages
	 * @param {Object[]} messages_data Array of messages
	 */
	messages: function(messages_data) {

		var messages = [],
			$t = $('#minicart .footer .messages');
		
		// Redraw messages if DOM objs exist
		if ( $t.length > 0 ) {
			$t.remove();
		}
		
		// Write out messages
		$.each(messages_data, function(key, item) {
			messages.push('<li class="message" title="' + key + '">' + item + '</li>')
		});
		$('<ul/>', { 'class': 'messages', html: messages.join('') }).insertAfter('#minicart .footer .subtotal-checkout');
	},
	/** load up promo slot
	*  @description adds the promo image to the minicar
	*  @param {Object[]} url and alt for the promo
	*/
	  promo: function(promo_data) {
	    var promo = $('#minicart .promo')[0], // setup in the init
	        url = promo_data.imgUrl,
	        alt = promo_data.description;
	    promo.innerHTML ='<img src="'+url+'" alt="'+alt+'" />';
	  },
	
	/** Empty Cart Message
	 * @description Appends an empty cart message if no shopping cart items, and return show/hide
	 * @param {Object[]} lang_data Array of language data
	 */
	emptycart_msg: function() {

		// Append empty cart message HTML if none exists (display:none by default);
		if ( $('#minicart .body .message').length <= 0 ) {
			 $('#minicart .body').append('<div class="message">' + TNF.lang.MINICART.get('EMPTYCART_MSG') + '</div>');
		}

		// Show/hide
		$('#minicart .body .message')['fade' + ($('#minicart ul.products li.item').length <= 0 ? 'In':'Out')](250);
		
	},
	
	/** truncate string
	 * @description Truncate text
	 * @param {Object|String} DOM obj to truncate
	 * @param {Object} o
	 * @param {String} o.text The text string to parse
	 * @param {String} o.txt The text string to parse
	 * @param {Integer} o.len The requested string length on output
	 * @param {Object|String} [o.marker] Substitute the default &hellip;
	 */
	truncate: function(el, o) {
		var $el = (typeof el === 'object') ? el : $('#' + el),
			marker = (o.marker) ? o.marker : '<span class="truncate marker">&hellip;</span>';
		return $el.each( function() {
			var options = {};
			options.len = Math.floor(o.len);
			var $this = $(this), 
				txt = $this.text(), 
				txt_trunc = txt.slice(0, options.len);
			
			if (txt.length > options.len) {
				$this.html(txt_trunc).append(marker);
			}
		});
	},
	
	/** AJAX handler
	 * @description Handles all AJAX response
	 * @param {String} [invoking_element] The invoking element - defaults to #minicart
	 * @param {Object[]} options
	 * @param {Boolean} [options.refresh] Flag to refresh Minicart DOM elements from JSON response without showing minicart
	 * @param {Array} [options.data] Use this JSON data src instead instead of requesting it
	 */
	response: function(invoking_element, options) {
		var o = options || {},
			invoking_element = (invoking_element) ? invoking_element : $('#minicart'),
			$in_el = (typeof invoking_element === 'object') ? invoking_element : $('"#' + invoking_element),
			products = [];
			
		var success_response = function(data, status, callback){
			var rewrite = (data.products.length <=0) ? true:false,
				$mc = $('#minicart').length > 0 ? $('#minicart') : $('#minicart', parent.document),
				$mcBody = $('.body', $mc);
                
			// destroy loading image
			TNF.minicart.dropdown.loading($in_el, {status:'off'});
			
			// Append subtotal
			TNF.minicart.subtotal(data.subtotal);
			
			// Append messages
			TNF.minicart.messages(data.lang.msg);
			
			// Add Promo slot 
			TNF.minicart.promo(data.promo); 
			
			if (o.refresh === true) {
				// remove existing product DOM elements
				$mcBody.find('ul.products, div.message').remove();
			}
			TNF.minicart.total_items(data);
			
			// Set timer for monitoring minicart activity
			if (TNF.env.get('hide_mini_cart_after') > 0) {
				var timer = setTimeout(TNF.minicart.checkForActivity, TNF.env.get('hide_mini_cart_after'));
				// Set event to monitor for click
				$('body').delegate('#minicart', 'click mouseenter mouseleave', function(e) {
					if (e.type === 'mouseleave') {
			            TNF.minicart.vars.activity = false;
			            timer = setTimeout(TNF.minicart.checkForActivity, TNF.env.get('hide_mini_cart_after'));
			         } else {
			            if (timer && timer > 0) {
			              clearTimeout(timer);
			            }
			            TNF.minicart.vars.activity = true;
			         }
				});
			}

			// Build Product List
			if (data.products.length <=0) {
				
				// Append emptycart message if no product data
				TNF.minicart.emptycart_msg();
				
			} else {
			
				// Append product HTML
				//TNF.minicart.emptycart_msg(data.lang, {reset:true});
				
				TNF.minicart.orderId = data.orderId; /** ZCG: Support dynamic delete */
			
				$productItems = $('.body ul.products li.item', $mc);
				
				// Checks if DOM elements exist on rewrite
				if ( $productItems.length <= 0 || ($productItems.length !== data.products.length) ) {
				
					if ($productItems.length !== data.products.length) {
						// Clear these elements to refresh minicart items
						$mcBody.find('ul.products, div.message').remove();
						$mc.undelegate('.body .remove_trigger', 'click');
					}
				
					$.each(data.products, function(key, item) {
						var anchor = function(content) {
							return (item.URL_productDetails) ? '<a href="' + item.URL_productDetails + '">' + content + '</a>' : content;
						};
						var op = '';
						op += '<span></span><div class="menu">' + TNF.minicart.vars.html.remove_button + '</div>'; op += (item.imgUrl) ? anchor('<img class="product" src="'+item.imgUrl+'">') : '';
						op += (item.name) ? '<h6>'+anchor('<span class="lbl">'+item.name+'</span>')+'</h6>' : '';
						op += (item.price) ? '<dl class="price"><dt>' + TNF.lang.MINICART.get('ITEM_PRICE') + ':</dt><dd>'+item.price+'</dd></dl>' : '';
						op += (item.color) ? '<dl class="color" id="' + item.color.variationId + '"><dt>' + TNF.lang.MINICART.get('COLOR') + ': <img src="/global/images/ui/blank.gif" class="swatch" style="background-color: ' + item.color.color1 + ';"></dt><dd class="name">' + item.color.colorName + '</dd></dl>' : '';
						op += (item.size) ? '<dl class="size"><dt>' + TNF.lang.MINICART.get('SIZE') + ':</dt><dd>'+item.size+'</dd></dl>' : '';
						op += (item.quantity) ? '<dl class="quantity"><dt>' + TNF.lang.MINICART.get('QTY') + ':</dt><dd>'+item.quantity+'</dd></dl>' : '';
						/** ZCG: append orderId into the element as there can be items belong to different orders*/
						products.push('<li id="product_' + item.productId + '" name='+ item.orderId + ' class="item">' + op + '</li>');
					});
					
					var $oldProductsWrapper = $('.productsWrapper:first');
					if ($oldProductsWrapper.length > 0) $oldProductsWrapper.remove();
					
					var $productsWrapper = $('<div />').addClass('productsWrapper');
					$('<ul/>', {'class': 'products', html: products.join('') }).appendTo($productsWrapper).find('.remove_trigger .lbl').text(TNF.lang.MINICART.get('REMOVE'));
					$productsWrapper.appendTo($mcBody);
					
					// truncate long titles
					TNF.minicart.truncate($('.body ul h6 .lbl', $mc), { len: 32 });
					
					// Remove Product Item
					$mc.delegate('.body .remove_trigger', 'click', function(ev){
						var self = $(this),
							$item = self.parents('li.item');
						
						ev.preventDefault(ev);
						
						// loading image
						TNF.minicart.dropdown.loading(self, {status:'on'});
						
						$.ajax({
							type: 'POST',
							url: TNF.minicart.vars.url.remove, /** ZCG: Support dynamic delete and use specific orderId as there can be multiple pending orders*/
							data: { fromOrderItemId: $(this).parents('.item').attr('id').substring(8), fromOrderId: $(this).parents('.item').attr('name')},
							dataType: 'json',
							success: function(success_data, status){
								if (status) {
									// remove loading image
									TNF.minicart.dropdown.loading(self, {status:'off'});
								}
								if (status === 'success')
								
									// set total product items on topnav, minicart
									TNF.minicart.total_items(success_data);
		
									// Append subtotal
									TNF.minicart.subtotal(success_data.subtotal);
		
									// Append messages
									TNF.minicart.messages(success_data.lang.msg);
		
									// Remove scroll bar if under four
									if (success_data.products.length <= 3) {
										if ($productsWrapper.data().jsp) {
											$productsWrapper.data().jsp.destroy();

											// Have to call seperate since DOM element is rebuilt 
											$('.productsWrapper:first', $mc).addClass('auto');
										}
									}
		
									// hide & remove product item from DOM
									$item.find('a, *').children().fadeOut(250, function(){
										$item.slideUp(750, function(){ 
											$(this).remove();
											
											// check for items and output empty cart msg
											TNF.minicart.emptycart_msg();
		
										});
									});
									
								}
						});
						
					});
					
					// Scroll minicart
					if (data.products.length > 3) {
						$mc.addClass('scroll'); // Add scroll class to make it wider
						$productsWrapper.bind('jsp-scroll-y', function(e) {
							TNF.minicart.vars.activity = true;
							}).jScrollPane({
								autoReinitialise: true
							});
					}else{
						// Sometimes IE8 doesn't like to remove this class
						// when you reload the minicart and there are fewer products
						// so we manually remove it here.
						$mc.removeClass('scroll');
					}
				}
				
			}
			
			// show minicart
			if (o.refresh !== true) {
                // we need to determine whether we're looking for minicart on the page we're on, or on the parent (in the case of the QV hopup)
                var $tr_el = $('#minicart_trigger').length > 0 ? $('#minicart_trigger') : $('#minicart_trigger', parent.document );
                    
				TNF.minicart.dropdown.show({ 'trigger_element': $tr_el, 'element': $mc });
			}
            
            // call callback
            if (typeof callback == 'function') {
                callback();
            }

            // call coremetrics
            $(data.products).each(function() {
            	/* ZCG: 1) Use this.categoryId instead of TNF.env.get('category_id'), since the product category is not global across products.
            			2) Do not set shop5 explore attributes for gift card, since it does not have color or size. */
            	if (this.color) {
    				cmCreateShopAction5Tag(this.styleNumber, cmCleanParam(this.name), this.quantity, this.price.replace(/\$/gi, ''), this.categoryId, TNF.env.get('store_id'), TNF.env.get("currency"), TNF.env.get('master_cat_id'), this.categoryId, this.color.colorName + '-_-' + this.size);		        		
            	} else {
	            	cmCreateShopAction5Tag(this.styleNumber, cmCleanParam(this.name), this.quantity, this.price.replace(/\$/gi, ''), this.categoryId, TNF.env.get('store_id'), TNF.env.get("currency"), TNF.env.get('master_cat_id'), this.categoryId);
            	}
            });
            cmDisplayShop5s();
		};
        
		if (o.data) {
			success_response(o.data, 'success', o.callback);
		} else {
			$.ajax({
				type: 'POST',
				url: TNF.minicart.vars.url.response,
				dataType: 'json',
				success: success_response
			});
		}
	},
		
	/** Activity on minicart
	* @description Checks for activity on minicart; if none, close minicart
	*/
	checkForActivity: function() {
		if (TNF.minicart.vars.activity === false) {
			// Close minicart
			TNF.minicart.dropdown.hide({ 'trigger_element': $('#minicart_trigger'), 'element':$('#minicart')});
		}else{
			// Reset activity variable
			TNF.minicart.vars.activity = false;
			// Set a new timer so we can continue to monitor
			setTimeout(TNF.minicart.checkForActivity, TNF.env.get('hide_mini_cart_after'));
		}
	},
		
	/** Initialize Minicart
	 * @description Initializes Minicart events
	 */
	init: function() {
	
		// Generate base minicart html and bind close events
		if ($('#minicart').length <= 0 && $('#minicart_trigger').length > 0) {
			
			// Generate
			TNF.minicart.generate();

			// Close Minicart if click away from Minicart
			$('body').bind('mousedown', function(ev){
				if ($('#minicart').is(':visible')) {
					if ( ($(ev.target).parents('#minicart').is(':visible') === false) ) {
						
						// Hide minicart
						TNF.minicart.dropdown.show({ 'trigger_element': $('#minicart_trigger'), 'element':$('#minicart')});
					}
				}
			});
			
			// Close Minicart
			$('#minicart').find('.close_trigger').live('click', function(ev){
				// Stop default event
				ev.preventDefault(ev);
				// Hide minicart
				TNF.minicart.dropdown.show({ 'trigger_element': $('#minicart_trigger'), 'element':$('#minicart')});
			});
					
			
		}
		
		// bind the element to trigger minicart
		// Check if we are to open the minicart by hover
		var eventName = (TNF.env.get('trigger_on_hover') === true) ? 'mouseenter': 'click';
		$('#minicart_trigger').bind(eventName, function(ev){
			ev.preventDefault(ev);
			
			// Allow only if minicart isn't already visible, otherwise let body.click handle the close
			if ($(ev.target).parent().is('.pellet.active') === false) {

				var self = $(this);
				
				// just force trigger element to have .active state (also handled in TNF.minicart.dropdown)
				self.parents('.pellet').addClass('active');
				
				// activate loading image
				TNF.minicart.dropdown.loading(self, { target:$('body'), status:'on' } );
	
				// Get initial ajax json and set up internal minicart functions
				TNF.minicart.response();

			}
		});
	
	}
	
};

/*
 * jQuery postMessage - v0.5 - 9/11/2009
 * http://benalman.com/projects/jquery-postmessage-plugin/
 * 
 * Copyright (c) 2009 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function($){var g,d,j=1,a,b=this,f=!1,h="postMessage",e="addEventListener",c,i=b[h]&&!$.browser.opera;$[h]=function(k,l,m){if(!l){return}k=typeof k==="string"?k:$.param(k);m=m||parent;if(i){m[h](k,l.replace(/([^:]+:\/\/[^\/]+).*/,"$1"))}else{if(l){m.location=l.replace(/#.*$/,"")+"#"+(+new Date)+(j++)+"&"+k}}};$.receiveMessage=c=function(l,m,k){if(i){if(l){a&&c();a=function(n){if((typeof m==="string"&&n.origin!==m)||($.isFunction(m)&&m(n.origin)===f)){return f}l(n)}}if(b[e]){b[l?e:"removeEventListener"]("message",a,f)}else{b[l?"attachEvent":"detachEvent"]("onmessage",a)}}else{g&&clearInterval(g);g=null;if(l){k=typeof m==="number"?m:typeof k==="number"?k:100;g=setInterval(function(){var o=document.location.hash,n=/^#?\d+&/;if(o!==d&&n.test(o)){d=o;l({data:o.replace(n,"")})}},k)}}}})(jQuery);

TNF.assisted_search = {
	_widget: false,
	_emptyValue : $.trim($('#toolbar .search-input').val()),
	lastSelectedUrl: '',
	init: function() {
		var searchBtn = $('#toolbar .search-submit');
		var self = this; 
		searchBtn.data('button',searchBtn.attr('src'));
		searchBtn.data('loading','/global/images/ui/ajax-search.gif');
		$('#toolbar .search-box').append('<div class="asearch-results-wrap"></div>'); 
		TNF.assisted_search._widget = $("#toolbar .search-input").not(".off").autocomplete({ 
			asearch:true, // use assisted search extension to ui.autocomplete
			minLength: 2, // # of characters required to auto search
			delay: 200, // miliseconds between typing and auto search
			position: { my:'left top', at:'left bottom', of: '.search-box', offset: '1 3' }, // see http://jqueryui.com/demos/autocomplete/
			appendTo: '#toolbar .asearch-results-wrap', // selector for results
			open: function() { // on event open
				$('.ui-autocomplete').removeClass('ui-corner-all').removeClass('ui-widget-content');
			},
			select: function(event, ui) { // on event select
				window.location = ui.item.url;
			},
			source: function(request, response) { // on autocomplete search time
				$.ajax({
					url: TNF.env.URL.get('ASSISTED_SEARCH'),
					dataType: 'json',
					data: {
						q: request.term
					},
					success: function(data) {
						if (!data || (data.product_amt_result === 0)) { 
							response([]);
							return;
						}
						
						TNF.assisted_search._widget.data('result_count', '<div class="asearch-number">'+TNF.lang.AUTOCOMPLETE.get('RESULTS')+data.product_amt_result+'</div>');
						/** ZCG: Ticket #15761253: Remove search result count from guided search drop-down */
						//TNF.assisted_search._widget.data('result_link', '<a href="'+data.search_term_link+'">' + TNF.lang.AUTOCOMPLETE.get('VIEW_ALL') + data.product_amt_result + TNF.lang.AUTOCOMPLETE.get('RESULTS') + '<span>"' + data.search_term + '"</span><span class="arrow"></span></a>');
						TNF.assisted_search._widget.data('result_link', '<a href="'+data.search_term_link+'">' + TNF.lang.AUTOCOMPLETE.get('VIEW_ALL') + TNF.lang.AUTOCOMPLETE.get('RESULTS') + '<span>"' + data.search_term + '"</span><span class="arrow"></span></a>');

						var productArray = [];
						
						if ( typeof data.product_name !== "undefined" ) {
							productArray = $.map( data.product_name, function( name, i ) {
								return {
									label: '<span class="asearch-image"><img src="'+data.product_image_url[i]+'" alt="'+name+'" style="width:56px;height:56px"></span><span class="asearch-description"><strong>'+emTerm(name,data.search_term)+'</strong><br />'+emTerm(self.truncate(data.product_description[i], TNF.env.get('desc_limit')),data.search_term)+'</span><span class="arrow"></span>',
									value: name,
									type: 'product',
									url:  data.product_url[i]
								}
							});
						}
						response(productArray);
					},
					error: function () {
						searchBtn.removeClass( "ui-autocomplete-loading" ).attr('src',searchBtn.data('button'));
					}
				});
				function emTerm(value,term){
					return value.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + term.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi, "\\$1") + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<em>$1</em>");
				}
			}
		});
		
		if (!TNF.assisted_search._emptyValue || TNF.assisted_search._emptyValue === '') {
			TNF.assisted_search._emptyValue = $.trim($('#toolbar .search-input').val());
		}

		$('#toolbar .search-input').bind('focus', function(event){ 
			if( $.trim($(this).val()) == TNF.assisted_search._emptyValue ) {
				$(this).val('');
			}
		}).bind('blur', function(event){
			var searchVal = $.trim($(this).val());

			if( searchVal === '' || searchVal === TNF.assisted_search._emptyValue.toLowerCase() ) {
				$(this).val(TNF.assisted_search._emptyValue);
			}
		});
		
		// To make asearch box close when user touches outside of box on ios
		if (TNF.ipad) {
			$('html').bind('click', function (event) {
				self._widget.autocomplete('close');
			});
			$('.search-box').bind('click', function (event) {
				event.stopPropagation();
			});
		}
		
		// Add the handler for pressing 'enter key' to submit input
		$('#toolbar .search-input').bind('keydown.autocomplete', function(event){ 
			var key = event.keyCode;
			var keyCode = $.ui.keyCode;
			
			/** ZCG: Link to last selected link rather than search page */
			if (key == keyCode.ENTER) { 
				 TNF.assisted_search.validate(); 
			}else{
				lastSelectedUrl = $('a.ui-state-hover').attr("href");
			}
			
		});
		
		// Add the handler for clicking 'search button'
		$('#toolbar .search-submit').bind('click', function(event){ 
			TNF.assisted_search.validate();
		});
		
		// Add the handler for clicking 'clear query'
		$('#toolbar .search-clear').live('click',function(event) {
			event.preventDefault();
			TNF.assisted_search._widget.autocomplete( "close" )
								   .val('')
								   .focus();
		});
	},
			
	validate: function () {
		var search = $.trim(this._widget.val());
		var defaultTxt = this._emptyValue;

		if (search === '' || search.toLowerCase() === defaultTxt.toLowerCase()) {
			this._widget.val('').focus();
		} else {
			/** ZCG: Link to last selected link rather than search page */
			if (lastSelectedUrl != undefined) {
				window.location = lastSelectedUrl;
			} else{
				this.gotoSearchPage();
			}
		}
	},
	truncate: function (text, limit) {
		var newText = text.length > limit ? text.substring(0, limit) + '...' : text;

		return newText;
	},
	gotoSearchPage: function() {
		/** ZCG: encode search term to prevent truncation when special characters like & are included */
		var url = TNF.env.URL.get('SEARCH_REQUEST')+'&searchTerm='+encodeURIComponent($.trim(this._widget.val()));
		window.location = url;
	}
};

TNF.email_updates = function(selector) {
	this.form = $(selector);
  	this.input = $('.email', this.form);

  	if (!this.input.length) return;

  	this.empty = $.trim(this.input.val());
    this.error = this.form.find('.error-message');
    this.error.text(TNF.lang.EMAIL.get('ENTER_VALID_EMAIL')); // Can override markup with this setting
  	this.form.submit($.proxy(this.submit, this));
  	
  	this.bindActions(); 
};

TNF.email_updates.regex = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;

TNF.email_updates.prototype.bindActions = function() {
  var self = this;

  this.input.bind('focus blur', function (e) {
    var targetVal = $.trim(self.input.val());

    if (targetVal === self.empty) {
      self.input.val('');
    } else if (targetVal === '') {
      self.input.val(self.empty);
    }
  });
};

TNF.email_updates.prototype.submit = function(event) {
  	event.preventDefault();
  	if (this.input.val().match(TNF.email_updates.regex) && this.input.val() != this.empty) {
    	this.error.hide();
    	
    	$.colorbox({
      		transition: 'none',
      		title: '&nbsp;&nbsp;' + TNF.lang.EMAIL.get('EMAIL_UPDATES'),
      		href: TNF.env.URL.get('EMAIL_SIGNUP') + '&email=' + this.input.val(), /**ZCG: use & instead of ? */
      		width: 720,
      		height: 720,
      		iframe: true,
      		reposition: TNF.ipad === false 
    	});
  	} else {
    	this.error.show();
    	if ($.trim(this.input.val()) === this.empty) {
	      this.input.val('');
	    }
    	this.input.focus();
  	}
};

TNF.store_locator = {

  init: function(el, options) {
    this.input = $('#locate input.zip-code');
    this.inputVal = this.input.val();
    this.$el = $(el);
    this.options = $.extend({}, options);
    this.generateJQuerySelectors();
    if ($.cookie('closest-store')) {
      this.loadFromCookie();
    } else {
      this.fetchNearest();
    }
    var that = this;
    this.input.bind('focus', function(){
      if( that.input.val() === that.inputVal ) {
        that.input.val('');
      }
    });
    this.input.bind('blur', function(){
      if( that.input.val() === '' ) {
        that.input.val(that.inputVal);
      }
    });
  },

  generateJQuerySelectors: function() {
    for (var key in this.options.selectors) {
      this['$' + key] = this.$el.find(this.options.selectors[key]);
    }
  },

  loadFromCookie: function() {
    json = eval('({' + $.cookie('closest-store') + '})');
    this.updateAddressWith(json);
  },

  setCookie: function(data) {
    var array = [];
    $.each(data, function(key, val) {
      if (val != null) {
        array.push(key + ':' + '\'' + val + '\'');
      }
    });
    var string = array.join(',');

    var expiresOn = new Date();
    expiresOn.setHours(expiresOn.getHours() + 1);
    $.cookie('closest-store', string, { expires: expiresOn, path: '/' });
  },

  fetchNearest: function() {
  	/** ZCG: Remove AJAX to offload W2GI request to client-side */
    var response = {
       name: TNF.lang.MSG.get('STORE_LOCATOR_ERROR1'),
       address1: TNF.lang.MSG.get('STORE_LOCATOR_ERROR2')
    };
    this.updateAddressWith(response);
  },

  updateAddressWith: function(data) {
    var html = '<strong>' + data.name + '</strong>';
    html += '<br />' + data.address1;
    if (data.city) {
      html += '<br />' + data.city + ', ' + data.state + ' ' + data.zip;
    }
    if (data.phone) {
      html += '<br />' + data.phone;
    }

    this.$address.html(html);
  }
};


$(function(){
  /* Grab important elements */
  TNF.store_locator_element = $('#locate');
  TNF.toolbar = $('#toolbar');
  TNF.main_nav = $('#nav');
  TNF.nav_shadow = $('#nav-shadow', TNF.main_nav);
  TNF.dropdowns = $('#nav-dropdowns');

  /* If global.js included on a page without the nav, break this init function */
  if( !(TNF.toolbar.length && TNF.main_nav.length && TNF.dropdowns.length) ) return;
  TNF.ipad = false;

  if (navigator.userAgent.match(/iPad/i)){
    TNF.ipad = true;
  }
  if (TNF.ipad) {
    $('body').addClass('touch-device');
    $('.locale-selector .country', TNF.toolbar).click(function(e){
 	  e.preventDefault();
 	  $('ul.countries', TNF.toolbar).show()
    });
    
    $('ul.countries > li > a', TNF.toolbar).click(function(e){
      if ($(this).parent().children().length > 1 ){
        e.preventDefault();
        $('ul', this).show();
      }	
    });
    TNF.toolbar.find('.my-account').children('a').bind('click', function (e) {
        e.preventDefault();
        
        var $acctPanel = $('#account-panel');

        if ($acctPanel.is(':visible')) {
          $acctPanel.hide();
        } else {
          $acctPanel.show();
        }
    });
  }

  /* Main menu dropdown functionality */
  TNF.dropdownDelay = 200;
  TNF.openDropdownTimeout;
  TNF.closeDropdownTimeout;
  TNF.dropdownListeners = function(navItem, dropdown){
    var self = this;
    this.openDropdown = function(){
      if(TNF.closeDropdownTimeout) clearTimeout(TNF.closeDropdownTimeout);

      if (!navItem.hasClass('hover')) {
        $(".dropdown", TNF.dropdowns).removeClass('show');
        $(".main-menu li a", TNF.main_nav).removeClass('hover');

        TNF.openDropdownTimeout = setTimeout(function(){
          $(dropdown).addClass('show');
          navItem.addClass('hover');
        }, TNF.dropdownDelay);
      }
    };

    this.closeDropdown = function(){
      if(TNF.openDropdownTimeout) clearTimeout(TNF.openDropdownTimeout);

      TNF.closeDropdownTimeout = setTimeout(function(){
        navItem.removeClass('hover');
        $(dropdown).removeClass('show');
      }, 5);
    };
    if (TNF.ipad){
      navItem.click(function(e){
        if (!$(dropdown).is(":visible")){
          e.preventDefault();
          self.openDropdown();
        }
      });
      navItem.parent().click( this.openDropdown, this.closeDropdown);
    } else {
      navItem.parent().hover( this.openDropdown, this.closeDropdown);
    }
    TNF.nav_shadow.hover(
      function() { if(TNF.closeDropdownTimeout) clearTimeout(TNF.closeDropdownTimeout); }
    );
    dropdown.hover(
      function() { if(TNF.closeDropdownTimeout) clearTimeout(TNF.closeDropdownTimeout); },
      this.closeDropdown
    );
  };

  TNF.setupToggleDropdowns = function() {
	 $(".main-menu li", TNF.main_nav).each(function(){ 
      var anchor = $('a', this),
      	  dropdownClass = anchor.attr("data-dropdown"),
          dropdown = $('.' + dropdownClass, TNF.dropdowns );
      if (dropdown.length){
        new TNF.dropdownListeners(anchor, dropdown);
      } else {
        $(this).hover(function(){
          anchor.addClass('hover');
        },function(){
          anchor.removeClass('hover');
        });
      }
    });
  };
  
    // Setup hopup for header sign-in
  $('.sign-in > a').each(function(i, e) { 
        var self = $(e),
            signInHref = self.attr('href');
  
        self.colorbox({
            iframe: true, 
            title: '&nbsp;&nbsp;' + self.attr('title'),
            height: self.data('height'), 
            width: self.data('width'),
            transition: 'none',
            reposition: TNF.ipad === false 
        });

        if(signInHref.indexOf("?") >= 0 ) {
            self.attr('href', signInHref + "&hopupParent=" + encodeURIComponent(window.location));
        }else{
            self.attr('href', signInHref + "?hopupParent=" + encodeURIComponent(window.location));
        }
    });

  new TNF.setupToggleDropdowns();

  TNF.store_locator.init(TNF.store_locator_element, {url: TNF.env.URL.get('STORE_LOCATOR_URL') + TNF.env.get('store_id'), selectors:{address:'.store-address'}});
	
  TNF.minicart.init();
  TNF.assisted_search.init();
  
  new TNF.email_updates('#subscribe form');
  new TNF.email_updates('#account-email');

    // Receive message for postMessage for sign-in hopup
    // Only needed for https hopup
    $.receiveMessage(
        function(e){
            // Get data from the sender and parse
            var data = $.parseJSON(e.data);
			
            // Execute the action requested by the sender
            switch(data.action) {
                // Close the hopup
                case 'close':
                    parent.$.colorbox.close();
                    break;

                // Resize the hopup
                case 'resize':
                    parent.$.colorbox.resize({
                        innerWidth: data.width,
                        innerHeight: data.height 
					});
                    break;
                // Refresh the parent window
                case 'refresh':
                    parent.window.location.href = parent.window.location.href;
                    break;

                // Redirect the parent window
                case 'redirect':
                    parent.window.location = data.url;
                    break;

                // Change the title of the hopup
                case 'changeTitle':
                    $('#cboxTitle').html('&nbsp;&nbsp;' + data.title);
                    break;
            }
        },
        TNF.env.URL.get('SIGNIN_HOPUP_URL')
    );
    $('#footer .nav > li:has(ul)').doubleTapToGo(); 
});

//
//AUTHOR: Osvaldas Valutis, www.osvaldas.info
//

$.fn.doubleTapToGo = function(params) {
if (!('ontouchstart' in window) &&
 !navigator.msMaxTouchPoints &&
 !navigator.userAgent.toLowerCase().match(/windows phone os 7/i)) {
 return false; 
}

if (TNF.ipad) {
	return false; 
}
 
this.each(function() {
 var curItem = false;

 $(this).click(function(e) {
   var item = $(this);
   if (item[0] != curItem[0]) {
     e.preventDefault();
     curItem = item;
   }
 });

 $(document).bind('click touchstart MSPointerDown', function(e) {
   var resetItem = true,
     parents = $(e.target).parents();

   for (var i = 0; i < parents.length; i++) {
     if (parents[i] == curItem[0]) {
       resetItem = false;
     }
   }

   if (resetItem) {
     curItem = false;
   }
 });
});
return this;
};
