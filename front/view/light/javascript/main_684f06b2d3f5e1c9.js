(function(e, t, n) {
	function i(n) {
		var i = t.console;
		if (!r[n]) {
			r[n] = !0;
			e.migrateWarnings.push(n);
			i && i.warn && !e.migrateMute && e.migrateTrace && i.trace
		}
	}
	function s(t, n, r, s) {
		if (Object.defineProperty) try {
			Object.defineProperty(t, n, {
				configurable: !0,
				enumerable: !0,
				get: function() {
					i(s);
					return r
				},
				set: function(e) {
					i(s);
					r = e
				}
			});
			return
		} catch(o) {}
		e._definePropertyBroken = !0;
		t[n] = r
	}
	var r = {};
	e.migrateWarnings = [];
	e.migrateTrace === n && (e.migrateTrace = !0);
	e.migrateReset = function() {
		r = {};
		e.migrateWarnings.length = 0
	};
	document.compatMode === "BackCompat" && i("jQuery is not compatible with Quirks Mode");
	var o = e("<input/>", {
		size: 1
	}).attr("size") && e.attrFn,
	u = e.attr,
	a = e.attrHooks.value && e.attrHooks.value.get ||
	function() {
		return null
	},
	f = e.attrHooks.value && e.attrHooks.value.set ||
	function() {
		return n
	},
	l = /^(?:input|button)$/i,
	c = /^[238]$/,
	h = /^(?:autofocus|autoplay|async|checked|controls|defer|disabled|hidden|loop|multiple|open|readonly|required|scoped|selected)$/i,
	p = /^(?:checked|selected)$/i;
	s(e, "attrFn", o || {},
	"jQuery.attrFn is deprecated");
	e.attr = function(t, r, s, a) {
		var f = r.toLowerCase(),
		d = t && t.nodeType;
		if (a) {
			u.length < 4 && i("jQuery.fn.attr( props, pass ) is deprecated");
			if (t && !c.test(d) && (o ? r in o: e.isFunction(e.fn[r]))) return e(t)[r](s)
		}
		r === "type" && s !== n && l.test(t.nodeName) && t.parentNode && i("Can't change the 'type' of an input or button in IE 6/7/8");
		if (!e.attrHooks[f] && h.test(f)) {
			e.attrHooks[f] = {
				get: function(t, r) {
					var i, s = e.prop(t, r);
					return s === !0 || typeof s != "boolean" && (i = t.getAttributeNode(r)) && i.nodeValue !== !1 ? r.toLowerCase() : n
				},
				set: function(t, n, r) {
					var i;
					if (n === !1) e.removeAttr(t, r);
					else {
						i = e.propFix[r] || r;
						i in t && (t[i] = !0);
						t.setAttribute(r, r.toLowerCase())
					}
					return r
				}
			};
			p.test(f) && i("jQuery.fn.attr('" + f + "') may use property instead of attribute")
		}
		return u.call(e, t, r, s)
	};
	e.attrHooks.value = {
		get: function(e, t) {
			var n = (e.nodeName || "").toLowerCase();
			if (n === "button") return a.apply(this, arguments);
			n !== "input" && n !== "option" && i("jQuery.fn.attr('value') no longer gets properties");
			return t in e ? e.value: null
		},
		set: function(e, t) {
			var n = (e.nodeName || "").toLowerCase();
			if (n === "button") return f.apply(this, arguments);
			n !== "input" && n !== "option" && i("jQuery.fn.attr('value', val) no longer sets properties");
			e.value = t
		}
	};
	var d, v, m = e.fn.init,
	g = e.parseJSON,
	y = /^([^<]*)(<[\w\W]+>)([^>]*)$/;
	e.fn.init = function(t, n, r) {
		var s;
		if (t && typeof t == "string" && !e.isPlainObject(n) && (s = y.exec(e.trim(t))) && s[0]) {
			t.charAt(0) !== "<" && i("$(html) HTML strings must start with '<' character");
			s[3] && i("$(html) HTML text after last tag is ignored");
			if (s[0].charAt(0) === "#") {
				i("HTML string cannot start with a '#' character");
				e.error("JQMIGRATE: Invalid selector string (XSS)")
			}
			n && n.context && (n = n.context);
			if (e.parseHTML) return m.call(this, e.parseHTML(s[2], n, !0), n, r)
		}
		return m.apply(this, arguments)
	};
	e.fn.init.prototype = e.fn;
	e.parseJSON = function(e) {
		if (!e && e !== null) {
			i("jQuery.parseJSON requires a valid JSON string");
			return null
		}
		return g.apply(this, arguments)
	};
	e.uaMatch = function(e) {
		e = e.toLowerCase();
		var t = /(chrome)[ \/]([\w.]+)/.exec(e) || /(webkit)[ \/]([\w.]+)/.exec(e) || /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(e) || /(msie) ([\w.]+)/.exec(e) || e.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(e) || [];
		return {
			browser: t[1] || "",
			version: t[2] || "0"
		}
	};
	if (!e.browser) {
		d = e.uaMatch(navigator.userAgent);
		v = {};
		if (d.browser) {
			v[d.browser] = !0;
			v.version = d.version
		}
		v.chrome ? v.webkit = !0 : v.webkit && (v.safari = !0);
		e.browser = v
	}
	s(e, "browser", e.browser, "jQuery.browser is deprecated");
	e.sub = function() {
		function t(e, n) {
			return new t.fn.init(e, n)
		}
		e.extend(!0, t, this);
		t.superclass = this;
		t.fn = t.prototype = this();
		t.fn.constructor = t;
		t.sub = this.sub;
		t.fn.init = function(i, s) {
			s && s instanceof e && !(s instanceof t) && (s = t(s));
			return e.fn.init.call(this, i, s, n)
		};
		t.fn.init.prototype = t.fn;
		var n = t(document);
		i("jQuery.sub() is deprecated");
		return t
	};
	e.ajaxSetup({
		converters: {
			"text json": e.parseJSON
		}
	});
	var b = e.fn.data;
	e.fn.data = function(t) {
		var r, s, o = this[0];
		if (o && t === "events" && arguments.length === 1) {
			r = e.data(o, t);
			s = e._data(o, t);
			if ((r === n || r === s) && s !== n) {
				i("Use of jQuery.fn.data('events') is deprecated");
				return s
			}
		}
		return b.apply(this, arguments)
	};
	var w = /\/(java|ecma)script/i,
	E = e.fn.andSelf || e.fn.addBack;
	e.fn.andSelf = function() {
		i("jQuery.fn.andSelf() replaced by jQuery.fn.addBack()");
		return E.apply(this, arguments)
	};
	e.clean || (e.clean = function(t, n, r, s) {
		n = n || document;
		n = !n.nodeType && n[0] || n;
		n = n.ownerDocument || n;
		i("jQuery.clean() is deprecated");
		var o, u, a, f, l = [];
		e.merge(l, e.buildFragment(t, n).childNodes);
		if (r) {
			a = function(e) {
				if (!e.type || w.test(e.type)) return s ? s.push(e.parentNode ? e.parentNode.removeChild(e) : e) : r.appendChild(e)
			};
			for (o = 0; (u = l[o]) != null; o++) if (!e.nodeName(u, "script") || !a(u)) {
				r.appendChild(u);
				if (typeof u.getElementsByTagName != "undefined") {
					f = e.grep(e.merge([], u.getElementsByTagName("script")), a);
					l.splice.apply(l, [o + 1, 0].concat(f));
					o += f.length
				}
			}
		}
		return l
	});
	var S = e.event.add,
	x = e.event.remove,
	T = e.event.trigger,
	N = e.fn.toggle,
	C = e.fn.live,
	k = e.fn.die,
	L = "ajaxStart|ajaxStop|ajaxSend|ajaxComplete|ajaxError|ajaxSuccess",
	A = new RegExp("\\b(?:" + L + ")\\b"),
	O = /(?:^|\s)hover(\.\S+|)\b/,
	M = function(t) {
		if (typeof t != "string" || e.event.special.hover) return t;
		O.test(t) && i("'hover' pseudo-event is deprecated, use 'mouseenter mouseleave'");
		return t && t.replace(O, "mouseenter$1 mouseleave$1")
	};
	e.event.props && e.event.props[0] !== "attrChange" && e.event.props.unshift("attrChange", "attrName", "relatedNode", "srcElement");
	e.event.dispatch && s(e.event, "handle", e.event.dispatch, "jQuery.event.handle is undocumented and deprecated");
	e.event.add = function(e, t, n, r, s) {
		e !== document && A.test(t) && i("AJAX events should be attached to document: " + t);
		S.call(this, e, M(t || ""), n, r, s)
	};
	e.event.remove = function(e, t, n, r, i) {
		x.call(this, e, M(t) || "", n, r, i)
	};
	e.fn.error = function() {
		var e = Array.prototype.slice.call(arguments, 0);
		i("jQuery.fn.error() is deprecated");
		e.splice(0, 0, "error");
		if (arguments.length) return this.bind.apply(this, e);
		this.triggerHandler.apply(this, e);
		return this
	};
	e.fn.toggle = function(t, n) {
		if (!e.isFunction(t) || !e.isFunction(n)) return N.apply(this, arguments);
		i("jQuery.fn.toggle(handler, handler...) is deprecated");
		var r = arguments,
		s = t.guid || e.guid++,
		o = 0,
		u = function(n) {
			var i = (e._data(this, "lastToggle" + t.guid) || 0) % o;
			e._data(this, "lastToggle" + t.guid, i + 1);
			n.preventDefault();
			return r[i].apply(this, arguments) || !1
		};
		u.guid = s;
		while (o < r.length) r[o++].guid = s;
		return this.click(u)
	};
	e.fn.live = function(t, n, r) {
		i("jQuery.fn.live() is deprecated");
		if (C) return C.apply(this, arguments);
		e(this.context).on(t, this.selector, n, r);
		return this
	};
	e.fn.die = function(t, n) {
		i("jQuery.fn.die() is deprecated");
		if (k) return k.apply(this, arguments);
		e(this.context).off(t, this.selector || "**", n);
		return this
	};
	e.event.trigger = function(e, t, n, r) { ! n && !A.test(e) && i("Global events are undocumented and deprecated");
		return T.call(this, e, t, n || document, r)
	};
	e.each(L.split("|"),
	function(t, n) {
		e.event.special[n] = {
			setup: function() {
				var t = this;
				if (t !== document) {
					e.event.add(document, n + "." + e.guid,
					function() {
						e.event.trigger(n, null, t, !0)
					});
					e._data(this, n, e.guid++)
				}
				return ! 1
			},
			teardown: function() {
				this !== document && e.event.remove(document, n + "." + e._data(this, n));
				return ! 1
			}
		}
	})
})(jQuery, window);
$.fn.topSlimeBanner = function() {
	var e = $(this),
	t = e.attr("endtime").replace(/\-/g, "/");
	if (!t) return;
	e.html("");
	var n = new Date(t) - new Date(litb.curDate);
	if (n <= 0) return;
	e.genTimer({
		beginTime: litb.curDate,
		day_label: litb.langs.countdown.day,
		days_label: litb.langs.countdown.days,
		targetTime: $(this).attr("endTime"),
		callback: function(e) {
			this.html(e)
		}
	});
	e.parent().show()
};
$.fn.genTimer = function(e) {
	function u(e) {
		var t = Math.floor(e / n),
		r = Math.floor((e - t * n) / 36e5),
		i = Math.floor((e - t * n - r * 1e3 * 60 * 60) / 6e4),
		s = Math.floor((e - t * n - r * 1e3 * 60 * 60 - i * 1e3 * 60) / 1e3);
		return {
			hours: ("0" + r).slice( - 2),
			minutes: ("0" + i).slice( - 2),
			seconds: ("0" + s).slice( - 2),
			dates: t
		}
	}
	if (this.data("handled")) return this;
	this.data("handled", !0);
	var t = {
		beginTime: new Date,
		day_label: litb.langs.discountCountDown.day,
		days_label: litb.langs.discountCountDown.days,
		unitWord: {
			hours: ":",
			minutes: ":",
			seconds: ""
		},
		type: "day",
		callbackOnlyDatas: !1
	},
	n = 864e5,
	r = $.extend({},
	t, e),
	i = this;
	r.targetTime = r.targetTime.replace(/\-/g, "/");
	var s = new Date(r.targetTime) - new Date(r.beginTime),
	o = function() {
		if (s < 0) {
			r.callback.call(i, r.callbackOnlyDatas ? {
				hours: "00",
				minutes: "00",
				seconds: "00",
				dates: 0
			}: "00" + r.unitWord.hours + "00" + r.unitWord.minutes + "00");
			clearInterval(i.interval)
		} else {
			var e = u(s);
			if (r.callbackOnlyDatas) r.callback.call(i, e);
			else if (r.type == "day") s >= n * 2 ? r.callback.call(i, '<span class="day_count">' + e.dates + '</span><span class="day">' + r.days_label + '</span><span class="day_seconds">' + e.hours + r.unitWord.hours + e.minutes + r.unitWord.minutes + e.seconds + r.unitWord.seconds + "</span>") : s >= n ? r.callback.call(i, '<span class="day_count">' + e.dates + '</span><span class="day">' + r.day_label + '</span><span class="day_seconds">' + e.hours + r.unitWord.hours + e.minutes + r.unitWord.minutes + e.seconds + r.unitWord.seconds + "</span>") : r.callback.call(i, '<span class="seconds">' + e.hours + r.unitWord.hours + e.minutes + r.unitWord.minutes + e.seconds + r.unitWord.seconds + "</span>");
			else if (r.type == "diffNoDay") {
				var t = e.hours;
				s >= n && (t = Number(e.dates * 24) + Number(e.hours));
				r.callback.call(i, '<span class="hours">' + t + '</span><span class="miniutes">' + r.unitWord.hours + e.minutes + '</span><span class="senconds">' + r.unitWord.minutes + e.seconds + r.unitWord.seconds + "</span>")
			} else {
				var t = e.hours;
				s >= n && (t = Number(e.dates * 24) + Number(e.hours));
				r.callback.call(i, '<span class="seconds">' + t + r.unitWord.hours + e.minutes + r.unitWord.minutes + e.seconds + r.unitWord.seconds + "</span>")
			}
		}
		s -= 1e3
	};
	i.interval = setInterval(o, 1e3);
	o();
	return this
};; !
function(e) {
	"use strict";
	function r() {
		e(t).each(function() {
			i(e(this)).removeClass("open")
		})
	}
	function i(t) {
		var n = t.attr("data-target"),
		r;
		if (!n) {
			n = t.attr("href");
			n = n && /#/.test(n) && n.replace(/.*(?=#[^\s]*$)/, "")
		}
		r = e(n);
		r.length || (r = t.parent());
		return r
	}
	var t = "[data-toggle=dropdown]",
	n = function(t) {
		var n = e(t).on("click.dropdown.data-api", this.toggle);
		e("html").on("click.dropdown.data-api",
		function() {
			n.parent().removeClass("open")
		})
	};
	n.prototype = {
		constructor: n,
		toggle: function(t) {
			var n = e(this),
			s,
			o;
			if (n.is(".disabled, :disabled")) return;
			s = i(n);
			o = s.hasClass("open");
			r();
			o || s.toggleClass("open");
			n.focus();
			return ! 1
		},
		keydown: function(t) {
			var n, r, s, o, u, a;
			if (!/(38|40|27)/.test(t.keyCode)) return;
			n = e(this);
			t.preventDefault();
			t.stopPropagation();
			if (n.is(".disabled, :disabled")) return;
			o = i(n);
			u = o.hasClass("open");
			if (!u || u && t.keyCode == 27) return n.click();
			r = e("[role=menu] li:not(.divider):visible a", o);
			if (!r.length) return;
			a = r.index(r.filter(":focus"));
			t.keyCode == 38 && a > 0 && a--;
			t.keyCode == 40 && a < r.length - 1 && a++;~a || (a = 0);
			r.eq(a).focus()
		}
	};
	var s = e.fn.dropdown;
	e.fn.dropdown = function(t) {
		return this.each(function() {
			var r = e(this),
			i = r.data("dropdown");
			i || r.data("dropdown", i = new n(this));
			typeof t == "string" && i[t].call(r)
		})
	};
	e.fn.dropdown.Constructor = n;
	e.fn.dropdown.noConflict = function() {
		e.fn.dropdown = s;
		return this
	};
	e(document).on("click.dropdown.data-api touchstart.dropdown.data-api", r).on("click.dropdown touchstart.dropdown.data-api", ".dropdown form",
	function(e) {
		e.stopPropagation()
	}).on("touchstart.dropdown.data-api", ".dropdown-menu",
	function(e) {
		e.stopPropagation()
	}).on("click.dropdown.data-api touchstart.dropdown.data-api", t, n.prototype.toggle).on("keydown.dropdown.data-api touchstart.dropdown.data-api", t + ", [role=menu]", n.prototype.keydown)
} (window.jQuery);
$.sandbox(function() {
	$(".live-chat .dropdown-menu").click(function(e) {
		e.stopPropagation()
	});
	$("#UAP-ciedit").each(function() {
		var e = $("dt", this).width() + 16,
		t = 0;
		$("dd", this).each(function() {
			t = Math.max($(this).width(), t)
		});
		t < e && $("dd", this).width(e)
	});
	$(".prod-info-rewards .iconQuestion").addClass("litb-icon-question-sign")
});
$.customEvents = {
	"widget-scroll": {
		event: "widget-scroll",
		data: {}
	},
	"widget-login-state": {
		event: "widget-scroll",
		data: {
			state: !1
		}
	},
	"widget-color-selected": {
		event: "widget-color-selected",
		data: {
			selectedColor: "",
			origColor: ""
		}
	},
	"widget-country-selected": {
		event: "widget-country-selected",
		data: {
			abbr: "en",
			country: ""
		}
	},
	"widget-size-selected": {
		event: "widget-size-selected",
		data: {
			selectedSize: ""
		}
	},
	"preference-form-submit": {
		event: "preference-form-submit",
		data: {
			urlEncoded: "/* form.serialize() */"
		}
	}
};
$.cookie = function(e, t, n) {
	if (typeof t == "undefined") {
		var a = null;
		if (document.cookie && document.cookie != "") {
			var f = document.cookie.split(";");
			for (var l = 0; l < f.length; l++) {
				var c = $.trim(f[l]);
				if (c.substring(0, e.length + 1) == e + "=") {
					a = decodeURIComponent(c.substring(e.length + 1));
					break
				}
			}
		}
		return a
	}
	n = n || {};
	if (t === null) {
		t = "";
		n.expires = -1
	}
	var r = "";
	if (n.expires && (typeof n.expires == "number" || n.expires.toUTCString)) {
		var i;
		if (typeof n.expires == "number") {
			i = new Date;
			i.setTime(i.getTime() + n.expires * 24 * 60 * 60 * 1e3)
		} else i = n.expires;
		r = "; expires=" + i.toUTCString()
	}
	var s = n.path ? "; path=" + n.path: "; path=/",
	o = n.domain ? "; domain=" + n.domain: "",
	u = n.secure ? "; secure": "";
	document.cookie = [e, "=", encodeURIComponent(t), r, s, o, u].join("")
};
var tracking = function() {}; (function($) {
	function recordLog(e) {
		var t = "",
		e = $.extend(e, litb.ctr),
		n = function() {
			for (var n in e) typeof n == "string" && n != "post" && (t += n + "=" + e[n] + "&");
			return t
		},
		r = function() {
			var e = new Image;
			e.src = litb.ctrPath + "?" + n() + "rk=" + Math.floor(Math.random() * 1e8 + 1)
		};
		r()
	}
	function ctrTracking(el, options, isMousedown) {
		var ctrInfo = eval("[" + (el.attr("ctr") || "") + "]"),
		ctrParent = el.parents(".ctr-info").eq(0),
		ctrParentInfo = [{}];
		ctrParent[0] && (ctrParentInfo = eval("[" + (ctrParent.attr("ctr") || "") + "]"));
		var options = $.extend({
			action: "SHOW",
			__cust: $.cookie("__cust"),
			lc: litb.lan,
			mp: litb.mainPage
		},
		ctrParentInfo[0], ctrInfo[0], options);
		litb.abTestType && (options.abTestType = litb.abTestType);
		isMousedown ? el.unbind("mousedown").mousedown(function() {
			recordLog(options)
		}) : recordLog(options)
	}
	$.fn.tracking = function(e, t) {
		this.each(function(n, r) {
			ctrTracking($(r), e, t)
		});
		return this
	};
	$.fn.trackingListener = function() {
		var el = $(this),
		ctrInfo = eval("[" + (el.attr("ctr") || "") + "]"),
		ctrParent = el.parents(".ctr-info").eq(0),
		ctrParentInfo = [{}];
		ctrParent[0] && (ctrParentInfo = eval("[" + (ctrParent.attr("ctr") || "") + "]"));
		var options = $.extend({
			action: "CLICK",
			__cust: $.cookie("__cust"),
			lc: litb.lan,
			mp: litb.mainPage
		},
		ctrParentInfo[0], ctrInfo[0], options);
		litb.abTestType && (options.abTestType = litb.abTestType);
		recordLog(options);
		return this
	};
	$(".ctr-track-a").on("mousedown", "a",
	function(e) { ! $(this).hasClass("no-ctr-track") && !$(this).hasClass("ctr-track") && $(this).trackingListener()
	});
	$(".ctr-track").on("mousedown",
	function(e) {
		$(this).trackingListener()
	});
	$(".ctr-track-show").tracking()
})($); (function(e) { (function(e, t) {
		typeof exports == "object" && exports ? module.exports = t: typeof define == "function" && define.amd ? define(t) : e.Mustache = t
	})(this,
	function() {
		function u(e, t) {
			return RegExp.prototype.test.call(e, t)
		}
		function a(e) {
			return ! u(r, e)
		}
		function l(e) {
			return e.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&")
		}
		function h(e) {
			return String(e).replace(/[&<>"'\/]/g,
			function(e) {
				return c[e]
			})
		}
		function p(e) {
			this.string = e;
			this.tail = e;
			this.pos = 0
		}
		function d(e, t) {
			this.view = e;
			this.parent = t;
			this._cache = {}
		}
		function v() {
			this.clearCache()
		}
		function m(t, n, r, i) {
			var s = "",
			o, u, a;
			for (var l = 0,
			c = t.length; l < c; ++l) {
				o = t[l];
				u = o[1];
				switch (o[0]) {
				case "#":
					a = r.lookup(u);
					if (typeof a == "object") if (f(a)) for (var h = 0,
					p = a.length; h < p; ++h) s += m(o[4], n, r.push(a[h]), i);
					else a && (s += m(o[4], n, r.push(a), i));
					else if (typeof a == "function") {
						var d = i == null ? null: i.slice(o[3], o[5]);
						a = a.call(r.view, d,
						function(e) {
							return n.render(e, r)
						});
						a != null && (s += a)
					} else a && (s += m(o[4], n, r, i));
					break;
				case "^":
					a = r.lookup(u);
					if (!a || f(a) && a.length === 0) s += m(o[4], n, r, i);
					break;
				case ">":
					a = n.getPartial(u);
					typeof a == "function" && (s += a(r));
					break;
				case "&":
					a = r.lookup(u);
					a != null && (s += a);
					break;
				case "name":
					a = r.lookup(u);
					a != null && (s += e.escape(a));
					break;
				case "text":
					s += u
				}
			}
			return s
		}
		function g(e) {
			var t = [],
			n = t,
			r = [],
			i;
			for (var s = 0,
			o = e.length; s < o; ++s) {
				i = e[s];
				switch (i[0]) {
				case "#":
				case "^":
					r.push(i);
					n.push(i);
					n = i[4] = [];
					break;
				case "/":
					var u = r.pop();
					u[5] = i[2];
					n = r.length > 0 ? r[r.length - 1][4] : t;
					break;
				default:
					n.push(i)
				}
			}
			return t
		}
		function y(e) {
			var t = [],
			n,
			r;
			for (var i = 0,
			s = e.length; i < s; ++i) {
				n = e[i];
				if (n) if (n[0] === "text" && r && r[0] === "text") {
					r[1] += n[1];
					r[3] = n[3]
				} else {
					r = n;
					t.push(n)
				}
			}
			return t
		}
		function b(e) {
			return [new RegExp(l(e[0]) + "\\s*"), new RegExp("\\s*" + l(e[1]))]
		}
		var e = {};
		e.name = "mustache.js";
		e.version = "0.7.2";
		e.tags = ["{{", "}}"];
		e.Scanner = p;
		e.Context = d;
		e.Writer = v;
		var t = /\s*/,
		n = /\s+/,
		r = /\S/,
		i = /\s*=/,
		s = /\s*\}/,
		o = /#|\^|\/|>|\{|&|=|!/,
		f = Array.isArray ||
		function(e) {
			return Object.prototype.toString.call(e) === "[object Array]"
		},
		c = {
			"&": "&amp;",
			"<": "&lt;",
			">": "&gt;",
			'"': "&quot;",
			"'": "&#39;",
			"/": "&#x2F;"
		};
		e.escape = h;
		p.prototype.eos = function() {
			return this.tail === ""
		};
		p.prototype.scan = function(e) {
			var t = this.tail.match(e);
			if (t && t.index === 0) {
				this.tail = this.tail.substring(t[0].length);
				this.pos += t[0].length;
				return t[0]
			}
			return ""
		};
		p.prototype.scanUntil = function(e) {
			var t, n = this.tail.search(e);
			switch (n) {
			case - 1 : t = this.tail;
				this.pos += this.tail.length;
				this.tail = "";
				break;
			case 0:
				t = "";
				break;
			default:
				t = this.tail.substring(0, n);
				this.tail = this.tail.substring(n);
				this.pos += n
			}
			return t
		};
		d.make = function(e) {
			return e instanceof d ? e: new d(e)
		};
		d.prototype.push = function(e) {
			return new d(e, this)
		};
		d.prototype.lookup = function(e) {
			var t = this._cache[e];
			if (!t) {
				if (e == ".") t = this.view;
				else {
					var n = this;
					while (n) {
						if (e.indexOf(".") > 0) {
							t = n.view;
							var r = e.split("."),
							i = 0;
							while (t && i < r.length) t = t[r[i++]]
						} else t = n.view[e];
						if (t != null) break;
						n = n.parent
					}
				}
				this._cache[e] = t
			}
			typeof t == "function" && (t = t.call(this.view));
			return t
		};
		v.prototype.clearCache = function() {
			this._cache = {};
			this._partialCache = {}
		};
		v.prototype.compile = function(t, n) {
			var r = this._cache[t];
			if (!r) {
				var i = e.parse(t, n);
				r = this._cache[t] = this.compileTokens(i, t)
			}
			return r
		};
		v.prototype.compilePartial = function(e, t, n) {
			var r = this.compile(t, n);
			this._partialCache[e] = r;
			return r
		};
		v.prototype.getPartial = function(e) { ! (e in this._partialCache) && this._loadPartial && this.compilePartial(e, this._loadPartial(e));
			return this._partialCache[e]
		};
		v.prototype.compileTokens = function(e, t) {
			var n = this;
			return function(r, i) {
				if (i) if (typeof i == "function") n._loadPartial = i;
				else for (var s in i) n.compilePartial(s, i[s]);
				return m(e, n, d.make(r), t)
			}
		};
		v.prototype.render = function(e, t, n) {
			return this.compile(e)(t, n)
		};
		e.parse = function(r, u) {
			function E() {
				if (m && !w) while (v.length) delete d[v.pop()];
				else v = [];
				m = !1;
				w = !1
			}
			r = r || "";
			u = u || e.tags;
			typeof u == "string" && (u = u.split(n));
			if (u.length !== 2) throw new Error("Invalid tags: " + u.join(", "));
			var f = b(u),
			c = new p(r),
			h = [],
			d = [],
			v = [],
			m = !1,
			w = !1,
			S,
			x,
			T,
			N,
			C;
			while (!c.eos()) {
				S = c.pos;
				T = c.scanUntil(f[0]);
				if (T) for (var k = 0,
				L = T.length; k < L; ++k) {
					N = T.charAt(k);
					a(N) ? v.push(d.length) : w = !0;
					d.push(["text", N, S, S + 1]);
					S += 1;
					N == "\n" && E()
				}
				if (!c.scan(f[0])) break;
				m = !0;
				x = c.scan(o) || "name";
				c.scan(t);
				if (x === "=") {
					T = c.scanUntil(i);
					c.scan(i);
					c.scanUntil(f[1])
				} else if (x === "{") {
					T = c.scanUntil(new RegExp("\\s*" + l("}" + u[1])));
					c.scan(s);
					c.scanUntil(f[1]);
					x = "&"
				} else T = c.scanUntil(f[1]);
				if (!c.scan(f[1])) throw new Error("Unclosed tag at " + c.pos);
				C = [x, T, S, c.pos];
				d.push(C);
				if (x === "#" || x === "^") h.push(C);
				else if (x === "/") {
					if (h.length === 0) throw new Error('Unopened section "' + T + '" at ' + S);
					var A = h.pop();
					if (A[1] !== T) throw new Error('Unclosed section "' + A[1] + '" at ' + S)
				} else if (x === "name" || x === "{" || x === "&") w = !0;
				else if (x === "=") {
					u = T.split(n);
					if (u.length !== 2) throw new Error("Invalid tags at " + S + ": " + u.join(", "));
					f = b(u)
				}
			}
			var A = h.pop();
			if (A) throw new Error('Unclosed section "' + A[1] + '" at ' + c.pos);
			d = y(d);
			return g(d)
		};
		var w = new v;
		e.clearCache = function() {
			return w.clearCache()
		};
		e.compile = function(e, t) {
			return w.compile(e, t)
		};
		e.compilePartial = function(e, t, n) {
			return w.compilePartial(e, t, n)
		};
		e.compileTokens = function(e, t) {
			return w.compileTokens(e, t)
		};
		e.render = function(e, t, n) {
			return w.render(e, t, n)
		};
		e.to_html = function(t, n, r, i) {
			var s = e.render(t, n, r);
			if (typeof i != "function") return s;
			i(s)
		};
		return e
	} ());
	e.mustache = function(e, t, n) {
		return Mustache.render(e, t, n)
	};
	e.fn.mustache = function(t, n) {
		return e(this).map(function(r, i) {
			var s = e.trim(e(i).html()),
			o = e.mustache(s, t, n);
			return e(o).get()
		})
	}
})(jQuery);
$.sandbox(function() {
	var e = function(e, t) {
		this.$element = $(e);
		this.settings = $.extend({},
		t || {});
		this.context = this.getContext(this.$element);
		this.bindEvent();
		var n = this;
		$(window).load(function() {
			n._fireCurrentCountry()
		});
		this.context.dropdownMenu.on("mousedown", "li a",
		function(e) {
			$(this).trackingListener()
		});
		this.context.dropdownMenu.on("click", "li a",
		function(e, t) {
			var n = litb.cid ? "&categories_id=" + litb.cid: "";
			$.ajax({
				type: "post",
				url: litb.baseURL + "index.php?main_page=info_check&action=change_country&country_code=" + $(this).find("span").data("abbr") + n,
				dataType: "json",
				complete: function() {},
				success: function(e) {
					if (e != "" && e == 1 && litb.productId && litb.productId != "") {
						$(window).trigger("widget-change-to-country", {});
						return
					}
					e.jump === !0 && (window.location.href = e.url)
				},
				error: function() {}
			})
		})
	};
	e.prototype = {
		getContext: function(e) {
			var t = e.find(".dropdown-menu"),
			n = e.find(".dropdown-toggle");
			return {
				$this: e,
				dropdownMenu: t,
				filterInput: t.find("input"),
				recoCountryList: t.find(".reco-country-list"),
				fullCountryList: t.find(".full-country-list"),
				listDivider: t.find(".divider"),
				dropdownToggle: n,
				curCountry: n.find(".curCountry"),
				noResult: e.find(".no-result")
			}
		},
		_fireCurrentCountry: function() {
			var e = this.$element.find(".curCountry"),
			t = e.data("country-name"),
			n = e.data("abbr");
			$(window).trigger("widget-country-selected", {
				abbr: n,
				country: t
			});
			litb && litb.ctr && (litb.ctr.country = n.toUpperCase())
		},
		buildList: function(e, t) {
			var n = '{{#countryList}}<li><a ctr=\'{"change_to_country":"{{{abbr}}}"}\' href="javascript:void(0);"><em class="litb-icon-flag {{{abbr}}}"></em><span data-abbr="{{{abbr}}}">{{countryName}}</span></a></li>{{/countryList}}',
			r = {
				countryList: e
			},
			i = $.mustache(n, r);
			t.html(i)
		},
		_clickCountry: function() {
			var e = $(this),
			t = e.find("span").html(),
			n = e.find("span").data("abbr");
			if (t == undefined) return;
			$(window).trigger("widget-country-selected", {
				abbr: n,
				country: t
			});
			litb && litb.ctr && (litb.ctr.country = n.toUpperCase())
		},
		bindEvent: function() {
			var e = this,
			t = function() {
				e.context.noResult.hide();
				e.buildList(litb.recoCountryList, e.context.recoCountryList);
				e.buildList(litb.countryList, e.context.fullCountryList);
				e.context.dropdownToggle.unbind("hover", t);
				e.context.dropdownToggle.unbind("click", t)
			};
			e.context.dropdownToggle.click(t);
			e.context.dropdownToggle.hover(t);
			e.context.dropdownMenu.click(function(e) {
				e.stopPropagation()
			});
			e.context.filterInput.keyup(function() {
				e.filter()
			});
			e.context.recoCountryList.on("click", "li",
			function() {
				e._clickCountry.apply(this)
			});
			e.context.fullCountryList.on("click", "li",
			function() {
				e._clickCountry.apply(this)
			});
			$(window).on("widget-country-selected",
			function(t, n) {
				e.selectCountry(n.country, n.abbr);
				e.context.$this.removeClass("open")
			});
			$("html").on("click.dropdown.data-api",
			function() {
				e.resetCountry()
			});
			e.context.curCountry.html(e.subTitles(e.context.curCountry.html()))
		},
		_isShowRecoCountry: !1,
		_isShowFullCountry: !1,
		_filterCountry: function(e, t, n) {
			$item = $(e);
			var r = $.trim($item.find("span").html()).toLowerCase();
			if (r.indexOf(t) === 0) {
				$item.show();
				this[n] = !0
			} else $item.hide()
		},
		filter: function() {
			var e = $.trim(this.context.filterInput.val()).toLowerCase(),
			t = this;
			t._isShowRecoCountry = !1;
			t._isShowFullCountry = !1;
			t.context.recoCountryList.children().each(function() {
				t._filterCountry(this, e, "_isShowRecoCountry")
			});
			t.context.fullCountryList.children().each(function() {
				t._filterCountry(this, e, "_isShowFullCountry")
			});
			if (!t._isShowRecoCountry && !t._isShowFullCountry) {
				this.context.listDivider.hide();
				this.context.noResult.show().html(litb.langs.noResultMatch + '"' + e + '"')
			} else if (!t._isShowRecoCountry) {
				this.context.listDivider.hide();
				this.context.noResult.hide()
			} else {
				this.context.listDivider.show();
				this.context.noResult.hide()
			}
		},
		resetCountry: function() {
			this.filter()
		},
		subTitles: function(e) {
			var t = e || "",
			n = t.substring(0, 15);
			t.length > 16 && (n += "...");
			return n
		},
		selectCountry: function(e, t) {
			this.context.curCountry.data("abbr", t);
			this.context.curCountry.data("country-name", e);
			this.context.curCountry.html(this.subTitles(e));
			this.context.dropdownToggle.find("em").removeClass().addClass("litb-icon-flag " + t)
		}
	};
	$.fn.countrySelector = function(t) {
		return this.each(function() {
			var n = $(this);
			if (n.data("countrySelector")) return;
			var r = new e(this, t);
			n.data("countrySelector", r)
		})
	};
	$(".widget.country-selector").countrySelector()
});
$.sandbox(function() {
	var e = function(e) {
		this.$elem = $(e);
		this.context = this.getContext(this.$elem);
		this.buildList();
		this.bindEvent()
	};
	e.prototype = {
		getContext: function(e) {
			var t = e.find(".dropdown-menu");
			return {
				$this: e,
				dropdownMenu: t,
				currencyList: t.find(".currency-list")
			}
		},
		buildList: function(e) {
			var t = this,
			n = t.getCurrencyList(e),
			r = "";
			$.each(n,
			function(e, t) {
				r += $.mustache('<li><a ctr=\'{"change_to_currency":"{{{cur}}}"}\' href="{{{url}}}"><em>{{{symbol}}}</em><span>{{{cur}}}</span></a></li>', t)
			});
			t.context.currencyList.html(r);
			t.context.currencyList.find("li a").tracking({
				action: "CLICK"
			},
			!0);
			return n
		},
		getCurrencyList: function(e) {
			if (e == undefined) return litb.currencyList;
			var t = litb.currencyList.concat();
			for (var n = 0,
			r = t.length; n < r; n++) {
				var i = t[n].country,
				s = $.inArray(e, i);
				if (s > -1) {
					t.splice(n, 1);
					t.splice(0, 0, litb.currencyList[n]);
					return t
				}
			}
			return t
		},
		bindEvent: function() {
			var e = this;
			e.context.dropdownMenu.click(function(e) {
				e.stopPropagation()
			});
			$(window).on("widget-country-selected",
			function(t, n) {
				var r = e.buildList(n.abbr);
				$(window).trigger("widget-currency-selected", {
					list: r
				})
			})
		}
	};
	$.fn.currencySelector = function(t) {
		return this.each(function() {
			var n = $(this);
			if (n.data("currencySelector")) return;
			var r = new e(this, t);
			n.data("currencySelector", r)
		})
	};
	$(".widget.currency-selector").currencySelector()
});
$.sandbox(function() {
	function e() {
		$(".reward-entrance").css("right", $(".nav-selectors").width() + 10).show()
	}
	e();
	$(window).on("widget-country-selected",
	function(t, n) {
		e()
	})
});;
litb.ieVersion = function() {
	var e = 100,
	t = function() {
		var e, t = 3,
		n = document.createElement("div"),
		r = n.getElementsByTagName("i");
		while (n.innerHTML = "<!--[if gt IE " + ++t + "]><i></i><![endif]-->", r[0]);
		return t > 4 ? t: e
	} ();
	t && (e = t);
	return e
};
litb.isWindows = function() {
	var e = navigator.platform,
	t = e == "Win32" || e == "Windows";
	return t
};
litb.isWebkit = function() {
	var e = !1;
	"WebkitTransform" in document.documentElement.style && (e = !0);
	return e
};
$.sandbox(function() {
	$.fn.carouselLanguage = function(e) {
		function u(e) {
			e < litb.dclientw || litb.dclientwTime > 10 ? r() : setTimeout(function() {
				u(document.documentElement.clientWidth)
			},
			300);
			litb.dclientwTime++
		}
		function f(e) {
			var t, n, r;
			$(window).load(function() {
				clearInterval(r)
			});
			r = setInterval(function() {
				var r = l();
				t = t || r.width;
				n = n || r.height;
				if (t != r.width || n != r.height) {
					e();
					t = r.width;
					n = r.height
				}
			},
			10)
		}
		function l() {
			var e, t;
			if (window.innerHeight) {
				e = window.innerWidth;
				t = window.innerHeight
			} else if (document.documentElement && document.documentElement.clientHeight) {
				e = document.documentElement.clientWidth;
				t = document.documentElement.clientHeight
			} else if (document.body) {
				e = document.body.clientWidth;
				t = document.body.clientHeight
			}
			return {
				width: e,
				height: t
			}
		}
		var t = this,
		n = $(this),
		e = $.extend({
			size: [0],
			now: 0,
			no: 0,
			width: 0,
			selected: 0
		},
		e),
		r = function(t) {
			$("td a", n).show();
			e.size = [0];
			e.now = 0;
			e.no = 0;
			e.width = 0;
			$("td a", n).each(function(t) {
				e.width += $(this).width() + 25;
				if (e.width >= n.width()) {
					e.size.push(t);
					e.width = 0
				}
				$(this).hasClass("selected") && (e.selected = t)
			});
			i(o())
		},
		i = function(t) {
			$("td a", n).each(function(n) {
				$(this).hide();
				n >= e.size[t] && $(this).show()
			});
			e.no = e.size[t];
			s()
		},
		s = function() {
			$(".litb-icon-lang-left-arraw", n).hide();
			$(".litb-icon-lang-right-arraw", n).hide();
			if (e.size.length > 1) {
				e.no > 0 && $(".litb-icon-lang-left-arraw", n).show();
				e.no != e.size[e.size.length - 1] && $(".litb-icon-lang-right-arraw", n).show();
				n.addClass("language-config-carousel");
				$("table", n).attr("align", "left")
			} else $("table", n).attr("align", "center")
		},
		o = function() {
			var t = 0;
			for (var n = 0; n < e.size.length; n++) e.selected >= e.size[n] && (t = n);
			e.now = t;
			e.no = e.size[t];
			return t
		};
		$(".litb-icon-lang-left-arraw", n).click(function() {
			e.now > 0 && e.now--;
			i(e.now);
			return ! 1
		});
		$(".litb-icon-lang-right-arraw", n).click(function() {
			e.now <= e.size.length - 1 && e.now++;
			i(e.now);
			return ! 1
		});
		$(window).resize(function() {
			r()
		});
		r();
		litb.dclientw = document.documentElement.clientWidth;
		litb.dclientwTime = 0;
		$(function() {
			litb.dclientwTime = 100
		});
		setTimeout(function() {
			u(document.documentElement.clientWidth)
		},
		300);
		var a = litb.ieVersion();
		a != 100 && f(function() {
			r()
		})
	};
	$("#language-config").carouselLanguage()
});
$.sandbox(function() {
	var e = ".top-language-select";
	$(e)[0] && $(e + " em").click(function() {
		$(this).parents(e).slideUp("slow")
	})
});
$.sandbox(function() {
	var e = ".top-language-select";
	$(e)[0] && $(e + " em").click(function() {
		$(this).parents(e).slideUp("slow")
	});
	$("#top-banner .discount_timer").each(function() {
		var e = $(this),
		t = new Image;
		t.onload = function() {
			e.topSlimeBanner()
		};
		t.src = $(this).parent().find("img").attr("src")
	})
});;
$.fn.autocomplete = function(e) {
	var t = {
		resultsClass: "searchInstant",
		overClass: "over",
		bottomClass: "ft",
		lineSeparator: ";",
		cellSeparator: "|",
		minChars: 1,
		delay: 50,
		matchCase: 0,
		cacheLength: 10,
		maxItemsToShow: 10,
		extraParams: {}
	},
	e = $.extend(t, e);
	this.each(function() {
		function p() {
			u = {};
			u.data = {};
			u.length = 0
		}
		function d() {
			if (l >= 33 && l <= 45 || l == 144 || l == 145 || l == 9 || l >= 112 && l <= 135) return;
			if (l == 27) return b();
			var n = t.val();
			if (n == s) {
				l != 46 && (l <= 8 || l >= 32) && g();
				return
			}
			s = n;
			n.length >= e.minChars ? x(++c, n, h = !1) : r.hide()
		}
		function v(r) {
			var i = $("li", n);
			if (!i || i.length == 0) return;
			o += r;
			o < 0 ? o = i.size() - 1 : o >= i.size() && (o = 0);
			i.removeClass(e.overClass);
			$(i[o]).addClass(e.overClass);
			t.val(i[o].selectValue)
		}
		function m(e) {
			var n = $.trim(e.selectValue ? e.selectValue: e.innerHTML);
			s = n;
			t.val(n);
			b();
			t.parents("form")[0].submit()
		}
		function g() {
			if (!t.val()) return;
			r.css({
				top: t.offset().top + t.outerHeight() - 3 + "px",
				left: t.parents("form").offset().left + "px"
			}).show()
		}
		function y() {
			i && clearTimeout(i);
			i = setTimeout(b, 200)
		}
		function b() {
			i && clearTimeout(i);
			r.is(":visible") && r.hide()
		}
		function w(t, r, i) {
			if (i == c || i < c && !h) {
				i == c && (h = !0);
				if (r) {
					n.innerHTML = "";
					if (!f || r.length == 0) return b();
					n.appendChild(S(t, r));
					var s = document.createElement("div");
					s.className = e.bottomClass;
					n.appendChild(s);
					g()
				} else {
					n.innerHTML = "";
					b()
				}
			}
		}
		function E(t) {
			if (!t) return null;
			var n = [],
			r = t.split(e.lineSeparator);
			for (var i = 0; i < r.length; i++) {
				var s = $.trim(r[i]);
				s && (n[n.length] = s.split(e.cellSeparator))
			}
			return n
		}
		function S(t, n) {
			var r = document.createElement("ul"),
			i = n.length;
			e.maxItemsToShow > 0 && e.maxItemsToShow < i && (i = e.maxItemsToShow);
			for (var s = 0; s < i; s++) {
				var u = n[s];
				if (!u) continue;
				var a = document.createElement("li");
				a.innerHTML = "<strong>" + t + "</strong>" + u[0].substring(t.length);
				a.selectValue = u[0];
				r.appendChild(a);
				$(a).hover(function() {
					$("li", r).removeClass(e.overClass);
					$(this).addClass(e.overClass);
					o = $("li", r).index(this)
				},
				function() {
					$(this).removeClass(e.overClass)
				}).click(function(e) {
					m(this);
					e.preventDefault();
					e.stopPropagation()
				})
			}
			return r
		}
		function x(t, n) {
			var r = e.cacheLength ? u.data[n] : null;
			r ? w(n, r, t) : typeof e.url == "string" && e.url.length > 0 && $.getJSON(T(n),
			function(e) {
				e = E(e);
				N(n, e);
				w(n, e, t)
			})
		}
		function T(t) {
			var n = e.matchCase ? t: t.toLowerCase(),
			r = e.url + "?callback=?&q=" + encodeURIComponent(n);
			for (var i in e.extraParams) r += "&" + i + "=" + encodeURIComponent(e.extraParams[i]);
			return r
		}
		function N(t, n) {
			if (!n || !t || !e.cacheLength) return;
			if (!u.length || u.length > e.cacheLength) {
				p();
				u.length++
			} else u.data[t] || u.length++;
			u.data[t] = n
		}
		e.url = $(this).attr("qs_url"),
		e.extraParams = {
			lang: $(this).attr("lang")
		};
		input = this;
		var t = $(input);
		t.parents("form").submit(function() {
			if ($.trim(t.val()) == "") return ! 1
		});
		var n = document.createElement("div"),
		r = $(n);
		r.css("z-index", "8900");
		r.hide().addClass(e.resultsClass).css({
			position: "absolute",
			width: t.outerWidth()
		});
		$("body").prepend(n);
		var i = null,
		s = "",
		o = -1,
		u = {},
		a = !1,
		f = !1,
		l = null,
		c = 0,
		h = !1;
		p();
		t.keyup(function(t) {
			f = !0;
			l = t.keyCode;
			if (l < 37 || l > 40) {
				o = -1;
				i && clearTimeout(i);
				i = setTimeout(function() {
					d()
				},
				e.delay)
			}
		}).keydown(function(e) {
			f = !0;
			l = e.keyCode;
			switch (e.keyCode) {
			case 13:
				t.val() == "" && t.val(t.attr("dValue"));
				break;
			case 38:
				e.preventDefault();
				r.is(":visible") && v( - 1);
				break;
			case 40:
				e.preventDefault();
				r.is(":visible") && v(1);
				break;
			default:
			}
		}).focus(function() {
			t.val() == t.attr("dValue") && t.val("");
			t.addClass("focus");
			f = !0
		}).blur(function() {
			t.val() == "" && t.val(t.attr("dValue")).removeClass("focus");
			f = !1;
			y()
		})
	})
}; (function($) {
	function errorLog(e, t) {
		window.console && window.console.error && window.console.error(e, t)
	}
	$.parseObject = function(text) {
		if (text) try {
			return eval("(" + text + ")")
		} catch(e) {
			errorLog("Error in $.parseObject: ", e);
			return null
		}
		return null
	};
	$.parseArray = function(text) {
		if (text) if (text.indexOf("[") === 0) try {
			return eval(text.replace(/,\s*]/g, "]"))
		} catch(e) {
			errorLog("Error in $.parseArray: ", e);
			return null
		} else try {
			return eval(("[" + text + "]").replace(/,\s*]/g, "]"))
		} catch(e) {
			errorLog("Error in $.parseArray: ", e);
			return null
		}
		return null
	}
})($);
$.sandbox(function() {
	function p() {
		$(".nav-categories li").unbind("mouseover", p); (function() {
			function n() {
				var t = $(".cate-menu-sub > dl", this),
				n = Math.ceil(t.size() / 2),
				r = $(".litb-cate-menu-specialoffer", this).size() > 0 ? e.specialOfferWidth: 0,
				i = $(".cate-menu-hero", this).size() > 0 ? e.heroWidth: 0,
				s = !1;
				if (t.size() == 0) {
					if ($(".cate-menu-hero", this).size() > 0) $(".cate-menu-hero", this).addClass("cate-menu-hero-left");
					else if ($(".litb-cate-menu-specialoffer", this).size() > 0) {
						$(".litb-cate-menu-specialoffer", this).addClass("specialoffer-single");
						s = !0
					}
				} else {
					t.eq(n).before('<br class="clear">').addClass("bottop");
					$(".cate-menu-sub > dl:gt(" + n + ")", this).addClass("bottop");
					$(".cate-menu-hero", this).size() > 0 && $(".litb-cate-menu-specialoffer", this).size() === 0 && (i += 4)
				}
				$(".cate-menu-hero", this).css({
					right: r
				});
				var o = e.colsWidth[n] + r + i;
				$(".nav-sub-categories", this).css({
					width: o,
					minHeight: $(".nav-categories").height()
				});
				var u = o === 0 ? 236 : o + 271;
				s && (u -= 30);
				$(this).css({
					width: u
				})
			}
			var e = {
				colsWidth: [0, 193, 369, 541, 717],
				specialOfferWidth: 176,
				heroWidth: 172,
				isFrist: !0
			},
			t = '<div class="{{className}}">{{#list}}<dl>{{#text}}{{#right}}<dt>{{text}}</dt>{{/right}}{{^right}}<dt><h3><a {{#nofollow}}rel="nofollow"{{/nofollow}} {{#tab_target}}target="_blank"{{/tab_target}} ctr="{seat:\'{{position}}\'}" {{#url}}href="{{{url}}}"{{/url}} {{#point}}class="hot"{{/point}}>{{text}}</a></h3></dt>{{/right}}{{/text}}{{#right}}{{#children}}<dd><h4><a {{#nofollow}}rel="nofollow"{{/nofollow}} {{#tab_target}}target="_blank"{{/tab_target}} ctr="{seat:\'{{position}}\'}" {{#url}}href="{{{url}}}"{{/url}} {{#point}}class="hot"{{/point}}>{{text}}</a></h4></dd>{{/children}}{{/right}}{{^right}}{{#children}}<dd><a {{#nofollow}}rel="nofollow"{{/nofollow}} {{#tab_target}}target="_blank"{{/tab_target}} ctr="{seat:\'{{position}}\'}" {{#url}}href="{{{url}}}"{{/url}} {{#point}}class="hot"{{/point}}>{{text}}</a></dd>{{/children}}{{/right}}</dl>{{/list}}</div>';
			$(".nav-categories li").each(function() {
				var e = {
					left: "cate-menu-sub",
					middle: "cate-menu-hero",
					right: "litb-cate-menu-specialoffer"
				},
				r = "",
				i = $(this);
				$.each(e,
				function(e, n) {
					var s = i.data(e),
					o = s.match(/(#quot#.*?#quot#)/g),
					u = 0;
					for (; o && u < o.length; u++) s = s.replace(o[u], o[u].replace(/'/g, "\\'").replace(/"/g, '\\"').replace(/#quot#/g, "'"));
					var a = {
						list: $.parseArray(s),
						className: n,
						right: e === "right"
					};
					a.list && a.list.length > 0 && (r += $.mustache(t, a))
				});
				$('<div class="nav-sub-categories"></div>').appendTo(this).html(r);
				n.call(this)
			})
		})();
		n = $(".nav-categories ul").offset();
		e = {
			x: n.left + $(".nav-categories ul").outerWidth() + o,
			y: n.top - s
		};
		t = {
			x: n.left + $(".nav-categories ul").outerWidth() + o,
			y: n.top + $(".nav-categories ul").outerHeight() + s
		}
	}
	function x(e) {
		var t = "";
		if (e.attributes) for (attrName in e.attributes) t += '<p class="pr-attr">' + attrName + ": " + e.attributes[attrName] + "</p>";
		var n = '<dl class="clearfix {{#attachment}}attachment{{/attachment}}"><dt><a title="{{{title}}}"  href="{{{href}}}"><img alt="{{{title}}}" width="50" height="50" src="{{{img}}}"></a></dt><dd><h4><a title="{{{title}}}" href="{{{href}}}">{{{name}}}</a></h4>' + t + "</dd></dl>";
		e.img = e.img || litb.resourceURL + "base-images/300x300.png";
		return $.mustache(n, e)
	}
	var e, t, n, r = [],
	i = null,
	s = 50,
	o = 5,
	u = 3,
	a = 300,
	f = null,
	l = null,
	c = function(e) {
		r.push({
			x: e.pageX,
			y: e.pageY
		});
		r.length > u && r.shift()
	},
	h = function() {
		function n(e, t) {
			return (t.y - e.y) / (t.x - e.x)
		}
		loc = r[r.length - 1],
		prevLoc = r[0];
		if (!loc) return 0;
		prevLoc || (prevLoc = loc);
		if (i && loc.x == i.x && loc.y == i.y) return 0;
		var s = n(loc, e),
		o = n(loc, t),
		u = n(prevLoc, e),
		f = n(prevLoc, t);
		if (s < u && o > f) {
			i = loc;
			return a
		}
		i = null;
		return 0
	};
	$(".nav-shop-all.hover-show").mouseover(function T() {
		var e = $(this);
		e.unbind("mouseover").children("dd").fadeIn({
			duration: "fast",
			complete: function() {
				$(document).on("click.hideCategories",
				function(t) {
					$(t.target).closest(".nav-shop-all.hover-show").size() === 0 && e.children("dd").fadeOut({
						duration: "fast",
						complete: function() {
							e.mouseover(T);
							$(document).off("click.hideCategories")
						}
					})
				})
			}
		})
	});
	$(".nav-categories li h2").find("a,strong").append('<em class="solid-color-arrow"></em>');
	var d = $(".nav-categories").height(),
	v = $(".nav-categories").width(),
	m,
	g,
	y,
	b,
	w;
	$(".nav-categories li").mouseover(p);
	var E = function(e) {
		clearTimeout(g);
		e.find(".solid-color-arrow").css("display", "block");
		var t = e.children(".nav-sub-categories").css("display", "block");
		if ($(".nav-categories").width() > v) {
			$(".nav-categories").stop("expand", !0).css("width", t.parents("li").width());
			t.height() > d ? $(".nav-categories").css("height", t.height()) : $(".nav-categories").css("height", d)
		} else m = setTimeout(function() {
			t.height() > d ? $(".nav-categories").css("height", t.height()) : $(".nav-categories").css("height", d);
			$(".nav-categories").animate({
				width: t.parents("li").width()
			},
			{
				duration: "fast",
				queue: "expand"
			}).dequeue("expand")
		},
		50)
	},
	S = function(e) {
		clearTimeout(m);
		e.find(".solid-color-arrow").css("display", "none");
		e.children(".nav-sub-categories").css("display", "none");
		g = setTimeout(function() {
			$(".nav-categories").stop("expand", !0).css({
				width: v,
				height: d
			})
		},
		50)
	};
	$(".nav-categories li").hover(function() {
		if (!b) {
			f = $(this);
			l != null && S(l);
			E(f)
		} else {
			f = $(this);
			w = setTimeout(function() {
				l != null && S(l);
				l = f;
				E(f)
			},
			500)
		}
	},
	function() {
		b ? clearTimeout(w) : l = f;
		b = h()
	});
	$(".nav-categories").mouseleave(function() {
		S(l);
		l = null;
		b = null
	});
	
	$(".nav-cart-with-list").hover(function() {
		var e = $(this),
		t = !1;
		if (!e.data("cartInfo")) {
			e.data("cartInfo", "loading");
			$("#navCartInfoNote").addClass("loading").html(litb.langs.loading).show();
			setTimeout(function() {
				if (!t) {
					e.data("cartInfo", null);
					$("#navCartInfoNote").html(litb.langs.networkErrorRetry).children(".retry").click(function() {
						e.trigger("mouseover")
					})
				}
			},
			3e4);
			$.getJSON(litb.baseURL + (litb.lan === "en" ? "": litb.lan + "/") + "index.php?main_page=info_check&action=ajax_shippingcart&callback=?",
			function(n) {
				t = !0;
				if (!n.items || n.items.length == 0) {
					$("#navCartInfoNote").removeClass("loading").html(litb.langs.emptyNavCart);
					e.data("cartInfo", "empty")
				} else {
					var r = n.items,
					i = "",
					s = 4,
					o = 0,
					u = 0;
					for (var a = 0; a < r.length; a++) {
						o += r[a].qty;
						r[a].attachment || --s;
						s < 0 ? u += r[a].qty: i += x(r[a], a == 0)
					}
					$("#navCartCount").text(o);
					$("#navCartProductList").html(i);
					$("#navCartTotal").text(litb.currSymbol + " " + n.addon.cartTotal);
					u > 0 && $("#navCartMoreItems").css("visibility", "visible").children("em").text(u);
					if ($("#navCartInfoNote").is(":visible")) {
						$("#navCartInfoNote").hide();
						$("#navCartQuickEntry").show()
					}
					e.data("cartInfo", "haveItems")
				}
			})
		} else switch (e.data("cartInfo")) {
		case "loading":
		case "empty":
			$("#navCartInfoNote").show();
			break;
		case "haveItems":
			$("#navCartQuickEntry").show()
		}
	},
	
	function() {
		$(this).children("dd").hide()
	});
	$(".checkout2Btn").click(function() {
		$(this).removeClass("checkout2Btn").addClass("processing2Btn")
	});
	$("#keywords").autocomplete();
	$(document).mousemove(c)
});
$.randomID = function() {
	var e = [];
	while (e.length < 4) e[e.length] = String.fromCharCode(Math.floor(Math.random() * 26) + 97);
	return e.join("") + (new Date).getTime()
};
$.fn.slimFlipCountdown = function() {
	var e = $(this),
	t = e.attr("endtime").replace(/\-/g, "/");
	if (!t) return;
	e.html("");
	e.attr("id", $.randomID());
	var n = new Date(t) - new Date(litb.curDate);
	if (n <= 0) return;
	var r = new $.flipCountdown(e.attr("id"), {
		value: n / 1e3,
		inc: 1,
		pace: 1e3,
		auto: !0
	});
	e.parent().show();
	return this
};
$.flipCountdown = function(e, t) {
	function y() {
		if ((p = r.value) == 0) return;
		var e = Math.floor(p / 86400),
		t = Math.floor(p / 3600) % 24,
		n = Math.floor(p / 60) % 60,
		i = Math.floor(p / 1) % 60;
		t = ("0" + t).slice( - 2);
		n = ("0" + n).slice( - 2);
		i = ("0" + i).slice( - 2);
		var s = e + t + n + i;
		h = Number(s);
		r.value -= r.inc;
		p = r.value;
		e = Math.floor(p / 86400);
		t = Math.floor(p / 3600) % 24;
		n = Math.floor(p / 60) % 60;
		i = Math.floor(p / 1) % 60;
		t = ("0" + t).slice( - 2);
		n = ("0" + n).slice( - 2);
		i = ("0" + i).slice( - 2);
		s = e + t + n + i;
		p = Number(s);
		b(h, p);
		r.auto === !0 && (d = setTimeout(y, r.pace))
	}
	function b(e, t) {
		a = E(e);
		f = E(t);
		var n, i = a.length,
		s = f.length;
		if (s < i) {
			n = i - s;
			if (n > 0 && s > 6) if (r.day_0n && s == 7) f[i - n] = 0;
			else {
				S(i - n);
				i--
			} else if (!r.day_0 && s == 6) {
				S(i - n);
				S(i - n + 1);
				x();
				i--
			} else f[i - n] = 0
		}
		for (var u = 0; u < i; u++) f[u] != a[u] && w(u, a[u], f[u]);
		if (u == 7 && f[u - 1] == 1) {
			var l = o.childNodes[1].childNodes[0].innerText;
			l == "DAYS" && (o.childNodes[1].childNodes[0].innerText = "DAY")
		}
	}
	function w(e, t, n) {
		function h() {
			if (u < 7) {
				a = u < 3 ? "t": "b";
				f = i.getElementById(s + "_" + a + "_d" + e);
				f && (e < 6 ? f.style.backgroundPosition = l[u] : f.style.backgroundPosition = c[u]);
				u++;
				u != 3 ? setTimeout(h, o) : h()
			}
		}
		var o, u = 0,
		a, f, l = ["-" + r.fW + "px -" + t * r.tFH + "px", r.fW * -2 + "px -" + t * r.tFH + "px", "0 -" + n * r.tFH + "px", "-" + r.fW + "px -" + (t * r.bFH + r.bOffset) + "px", r.fW * -2 + "px -" + (n * r.bFH + r.bOffset) + "px", r.fW * -3 + "px -" + (n * r.bFH + r.bOffset) + "px", "0 -" + (n * r.bFH + r.bOffset) + "px"],
		c = ["-" + (r.wOffset + r.fWD) + "px -" + t * r.tFH + "px", -r.wOffset + r.fWD * -2 + "px -" + t * r.tFH + "px", "-" + r.wOffset + "px -" + n * r.tFH + "px", "-" + (r.wOffset + r.fWD) + "px -" + (t * r.bFH + r.bOffset) + "px", -r.wOffset + r.fWD * -2 + "px -" + (n * r.bFH + r.bOffset) + "px", -r.wOffset + r.fWD * -3 + "px -" + (n * r.bFH + r.bOffset) + "px", "-" + r.wOffset + "px -" + (n * r.bFH + r.bOffset) + "px"];
		o = 80;
		h()
	}
	function E(e) {
		return e.toString().split("").reverse()
	}
	function S(e) {
		var t = i.getElementById(s + "_d" + e);
		o.removeChild(t)
	}
	function x() {
		var e = i.getElementById("group_timeLabels"),
		t = i.getElementById("group_dayLabel");
		e.removeChild(t)
	}
	function T(e) {
		var t = Math.floor(e / 86400),
		n = Math.floor(e / 3600) % 24,
		u = Math.floor(e / 60) % 60,
		a = Math.floor(e / 1) % 60;
		t < 10 && t >= 0 && r.day_0n && (t = ("0" + t).slice( - 2));
		t == 0 && !r.day_0 && (t = "");
		n = ("0" + n).slice( - 2);
		u = ("0" + u).slice( - 2);
		a = ("0" + a).slice( - 2);
		var f = t + n + u + a,
		l = f.length,
		c = 1,
		h;
		l == 6 && r.day_0 && (l = 7);
		l == 7 && (l = r.day_0n ? 8 : 7);
		for (h = 0; h < l; h++) {
			v = i.createElement("ul");
			v.className = "cd";
			v.id = s + "_d" + h;
			h > 5 ? v.innerHTML = '<li class="day_t" id="' + s + "_t_d" + h + '"></li><li class="day_b" id="' + s + "_b_d" + h + '"></li>': v.innerHTML = '<li class="t" id="' + s + "_t_d" + h + '"></li><li class="b" id="' + s + "_b_d" + h + '"></li>';
			o.insertBefore(v, o.firstChild);
			if (c != l && c % 2 == 0 && c < 7) {
				m = i.createElement("ul");
				m.className = "cd";
				c % 6 == 0 ? t <= 1 ? m.innerHTML = '<li class="days">' + litb.langs.countdown.day + "</li>": m.innerHTML = '<li class="days">' + litb.langs.countdown.days + "</li>": m.innerHTML = '<li class="s"></li>';
				o.insertBefore(m, o.firstChild)
			}
			c++
		}
		var p = E(f);
		if (f.length < l) {
			var g = l - f.length;
			while (g) {
				p[l - g] = 0;
				g--
			}
		}
		for (h = 0; h < l; h++) if (h < 6) {
			i.getElementById(s + "_t_d" + h).style.backgroundPosition = "0 -" + p[h] * r.tFH + "px";
			i.getElementById(s + "_b_d" + h).style.backgroundPosition = "0 -" + (p[h] * r.bFH + r.bOffset) + "px"
		} else {
			i.getElementById(s + "_t_d" + h).style.backgroundPosition = "-" + r.wOffset + "px -" + p[h] * r.tFH + "px";
			i.getElementById(s + "_b_d" + h).style.backgroundPosition = "-" + r.wOffset + "px -" + (p[h] * r.bFH + r.bOffset) + "px"
		}
		r.auto === !0 && (d = setTimeout(y, r.pace))
	}
	var n = {
		value: 0,
		inc: 1,
		pace: 1e3,
		auto: !0,
		tFH: 28,
		bFH: 28,
		fW: 23,
		fWD: 23,
		bOffset: 283,
		wOffset: 100,
		day_0n: !1,
		day_0: !0
	},
	r = t || {},
	i = window.document,
	s = typeof e != "undefined" && e !== "" ? e: "flip-counter",
	o = i.getElementById(s);
	for (var u in n) r[u] = u in r ? r[u] : n[u];
	var a = [],
	f = [],
	l,
	c,
	h,
	p,
	d = null,
	v,
	m,
	g = {
		q: null,
		pace: 0,
		inc: 0
	};
	T(r.value)
};
$.sandbox(function() {
	$(function() {
		$("#CATE_TOP_BANNER_new .count_down").each(function() {
			var e = $(this),
			t = new Image;
			t.onload = function() {
				e.slimFlipCountdown()
			};
			t.src = $(this).parent().find("img").attr("src")
		});
		$("#CATE_TOP_BANNER_new .discount_timer").each(function() {
			var e = $(this),
			t = new Image;
			t.onload = function() {
				e.topSlimeBanner()
			};
			t.src = $(this).parent().find("img").attr("src")
		})
	})
}); (function(e) {
	e.fn.imgHover = function(t) {
		t = e.extend({
			src: "http://litbimg.rightinthebox.com/resource_34bdc6c4b3eb489047c809e542844eb02cd89e85/dev_v2/themes/default/images/imageHover128.png"
		},
		t);
		var n = this.find("img[hover-img!='no']"),
		r = e("<img>");
		r.addClass("image-hover");
		r.attr("src", t.src);
		n.parent().addClass("img-box");
		navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/iPad/i) || n.hover(function(t) {
			r.attr("title", e(this).attr("title") || e(this).attr("alt") || "");
			this.parentNode.appendChild(r[0]);
			return ! 0
		},
		function(e) {});
		return this
	}
})($);
$.sandbox(function() {
	var e = 4,
	t = 76;
	$(".breadcrumb dl").each(function() {
		var n = $("dd", this).data("list"),
		r = "<ul>";
		if (n && n.length > 0) {
			for (var i = 0; i < n.length; i++) r += $.mustache('<li><a href="{{href}}" ctr=\'{"entity":"c_name_in_dropdown","ccid":"{{{ccid}}}"}\' >{{{text}}}</a></li>', n[i]);
			$("dd", this).html(r + "</ul>");
			$(this).hover(function() {
				$(this).css({
					width: $(this).width(),
					height: 1
				}).addClass("over");
				$("dt", this).css({
					width: $(this).width() + e
				});
				$("dd", this).css({
					width: $(this).width() + t
				})
			},
			function() {
				$(this).removeClass("over").css({
					width: "auto",
					height: "auto"
				});
				$("dt", this).css({
					width: "auto"
				});
				$("dd", this).css({
					width: "auto"
				})
			});
			$(this).removeClass("empty")
		}
	})
});
$.sandbox(function() {
	function r() {
		if (t) return;
		this.render = function(e, t, r) {
			e.prefix = r;
			$("dt a", t).attr({
				href: e.url,
				ctr: "{'entity':'" + e.prefix + "arrow'}"
			});
			$("dd", t).prepend($.mustache(n, e)).css("background", "none");
			t.attr({
				ctr: "{'area':'breadcrumb', 'type':'P', 'cpid':'" + e.id + "'}"
			});
			$("a").each(function() {
				$(this).tracking({
					action: "click"
				},
				!0)
			})
		};
		t = $.ajax({
			type: "post",
			url: litb.baseURL + "index.php?main_page=info_check&action=get_prev_next_products&pid=" + litb.pid + "&cid=" + litb.cid,
			dataType: "json",
			context: this
		});
		t.done(function(e) {
			e.prev && this.render(e.prev, $(".icon-prod").eq(0), "pre_p_");
			e.next && this.render(e.next, $(".icon-prod").eq(1), "next_p_");
			$(".icon-prod").imgHover({
				src: litb.resourceURL + "/themes/default/images/imageHover85.png"
			})
		});
		t.fail(function() {
			t = null
		})
	}
	var e, t;
	$(".icon-prod").hover(function() {
		r();
		$(this).siblings().removeClass("over");
		$(this).addClass("over");
		clearTimeout(e)
	},
	function() {
		var t = this;
		e = setTimeout(function() {
			$(t).removeClass("over")
		},
		100)
	});
	var n = '<a href="{{{url}}}" title="{{title}}" ctr="{\'entity\':\'{{prefix}}image\'}"><img border="0" width="85" height="85" src="{{{image}}}"/></a><p><a href="{{{url}}}" title="{{title}}" ctr="{\'entity\':\'{{prefix}}name\'}">{{name}}</a></p><p class="price">{{price}}</p>'
});
$.sandbox(function() {
	$(window).load(function() {
		var e = $(".litb-us-on-facebook");
		if (litb.lan == "ru" && e.data("vk")) {
			var t = e.data("vk");
			e.html('<div id="vk_groups"></div>');
			if (typeof VK == "undefined") $.getScript("//vk.com/js/api/openapi.js?98",
			function() {
				VK.Widgets.Group("vk_groups", t.info, t.group_id);
				e.fadeIn("slow")
			});
			else {
				VK.Widgets.Group("vk_groups", t.info, t.group_id);
				e.fadeIn("slow")
			}
		} else setTimeout(function() {
			e.html(e.attr("data-html"));
			$("#fb_likebox_iframe").load(function() {
				e.fadeIn("slow")
			})
		},
		3e3);
		var n = $("#ok_group_widget");
		litb.lan == "ru" && n.data("ok") && !
		function(e, t, n, r) {
			var i = e.createElement("script");
			i.src = "http://connect.ok.ru/connect.js";
			i.onload = i.onreadystatechange = function() {
				if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") if (!this.executed) {
					this.executed = !0;
					setTimeout(function() {
						OK.CONNECT.insertGroupWidget(t, n, r)
					},
					0)
				}
			};
			e.documentElement.appendChild(i)
		} (document, "ok_group_widget", n.data("ok"), "{width:208,height:283}")
	})
}); (function(e, t, n, r) {
	var i = e(t);
	e.fn.lazyload = function(s) {
		function f() {
			var t = 0;
			o.each(function() {
				var n = e(this);
				if (a.skip_invisible && !n.is(":visible")) return;
				if (!e.abovethetop(this, a) && !e.leftofbegin(this, a)) if (!e.belowthefold(this, a) && !e.rightoffold(this, a)) {
					n.trigger("appear");
					t = 0
				} else if (++t > a.failure_limit) return ! 1
			})
		}
		var o = this,
		u, a = {
			threshold: 0,
			failure_limit: 0,
			event: "scroll",
			container: t,
			data_attribute: "original",
			skip_invisible: !0,
			appear: null,
			load: null,
			timer: 30
		};
		if (s) {
			if (r !== s.failurelimit) {
				s.failure_limit = s.failurelimit;
				delete s.failurelimit
			}
			e.extend(a, s)
		}
		u = a.container === r || a.container === t ? i: e(a.container);
		var l;
		if (0 === a.event.indexOf("scroll")) {
			var c;
			l = function() {
				c && clearTimeout(c);
				c = setTimeout(function() {
					f()
				},
				a.timer)
			};
			u.bind(a.event, l)
		}
		this.each(function() {
			var t = this,
			n = e(t);
			t.loaded = !1;
			n.one("appear",
			function() {
				if (!t.loaded) {
					if (a.appear) {
						var r = o.length;
						a.appear.call(t, r, a)
					}
					var i = n.data(a.data_attribute);
					n.bind("load",
					function() {
						t.loaded = !0;
						n[0].removeAttribute("data-" + a.data_attribute);
						n.unbind("load");
						var r = e.grep(o,
						function(e) {
							return ! e.loaded
						});
						o = e(r);
						o.length === 0 && u.unbind("scroll", l);
						if (a.load) {
							var i = o.length;
							a.load.call(t, i, a)
						}
					}).bind("error",
					function() {
						n.unbind("error");
						e.imgOnError(n)
					}).attr("src", i)
				}
			})
		});
		i.bind("resize",
		function(e) {
			f()
		});
		i.bind("touchmove",
		function(e) {
			f()
		});
		/iphone|ipod|ipad.*os 5/gi.test(navigator.appVersion) && i.bind("pageshow",
		function(t) {
			t.originalEvent.persisted && o.each(function() {
				e(this).trigger("appear")
			})
		});
		f();
		e(n).ready(function() {
			f()
		});
		return this
	};
	e.belowthefold = function(n, s) {
		var o;
		s.container === r || s.container === t ? o = i.height() + i.scrollTop() : o = e(s.container).offset().top + e(s.container).height();
		return o <= e(n).offset().top - s.threshold
	};
	e.rightoffold = function(n, s) {
		var o;
		s.container === r || s.container === t ? o = i.width() + i.scrollLeft() : o = e(s.container).offset().left + e(s.container).width();
		return o <= e(n).offset().left - s.threshold
	};
	e.abovethetop = function(n, s) {
		var o;
		s.container === r || s.container === t ? o = i.scrollTop() : o = e(s.container).offset().top;
		return o >= e(n).offset().top + s.threshold + e(n).height()
	};
	e.leftofbegin = function(n, s) {
		var o;
		s.container === r || s.container === t ? o = i.scrollLeft() : o = e(s.container).offset().left;
		return o >= e(n).offset().left + s.threshold + e(n).width()
	};
	e.inviewport = function(t, n) {
		return ! e.rightoffold(t, n) && !e.leftofbegin(t, n) && !e.belowthefold(t, n) && !e.abovethetop(t, n)
	};
	e.extend(e.expr[":"], {
		"below-the-fold": function(t) {
			return e.belowthefold(t, {
				threshold: 0
			})
		},
		"above-the-top": function(t) {
			return ! e.belowthefold(t, {
				threshold: 0
			})
		},
		"right-of-screen": function(t) {
			return e.rightoffold(t, {
				threshold: 0
			})
		},
		"left-of-screen": function(t) {
			return ! e.rightoffold(t, {
				threshold: 0
			})
		},
		"in-viewport": function(t) {
			return e.inviewport(t, {
				threshold: 0
			})
		},
		"above-the-fold": function(t) {
			return ! e.belowthefold(t, {
				threshold: 0
			})
		},
		"right-of-fold": function(t) {
			return e.rightoffold(t, {
				threshold: 0
			})
		},
		"left-of-fold": function(t) {
			return ! e.rightoffold(t, {
				threshold: 0
			})
		}
	}); (function() {
		function t(t) {
			t = e(t);
			var n = new Image;
			n.onerror = function() {
				n.onerror = null;
				e.imgOnError(t)
			};
			n.src = t.attr("src")
		}
		e("img[data-lazy]").each(function(e, n) {
			n.src && t(n)
		})
	})();
	e("img[data-src]").lazyload({
		data_attribute: "src",
		skip_invisible: !1,
		threshold: 500,
		failure_limit: 999
	})
})(jQuery, window, document);;
$.sandbox(function() {
	$(".mini-recommended").imgHover({
		src: "http://litbimg.rightinthebox.com/resource_34bdc6c4b3eb489047c809e542844eb02cd89e85/dev_v2/themes/newblue/images/imageHover85.png"
	}).tracking()
});;
$.fn.slideBanner = function() {
	return this.each(function() {
		function i(n) {
			$(e).find("img").stop().animate({
				opacity: 0
			},
			800,
			function() {
				$(this).parent().hide()
			}).css("z-index", "").end().find("img").eq(n).stop().parent().show().children("img").css("z-index", t).animate({
				opacity: 1
			},
			800);
			$(e).parent().children("img.dfp_dot").css("opacity", .5).eq(n).css("opacity", 1)
		}
		var e = $(this).children("div").show(),
		t = e.size(),
		n = 0,
		r;
		if (t < 1) return;
		$(e).find("img").css({
			position: "absolute",
			opacity: 0
		}).parent().hide();
		$(e).find("img").eq(0).css({
			"z-index": t,
			opacity: 1
		}).parent().show();
		$(this).hover(function() {
			clearInterval(r)
		},
		function() {
			r = setInterval(function() {
				i(++n % t)
			},
			7e3)
		}).trigger("mouseleave");
		if (!$(this).hasClass("slide_dfp_l")) {
			$(this).append('<img title="' + litb.langs.pageBar.prev + '" style="left:0" src="' + litb.resourceURL + 'base-images/prev_arrow.png" /><img title="' + litb.langs.pageBar.next + '" src="' + litb.resourceURL + 'base-images/next_arrow.png" style="right:0" />');
			$(this).children("img").css({
				position: "absolute",
				"z-index": 1,
				top: ($(this).height() || parseInt($(this).css("height"))) / 2 - 10
			}).bind("click",
			function(e) {
				$(e.target).attr("title") == litb.langs.pageBar.prev ? n--:n++;
				n = (n + t) % t;
				i(n)
			})
		} else {
			$(this).append('<img title="' + litb.langs.pageBar.prev + '" style="right:' + (10 + 14 * (t + 1)) + 'px;" src="' + litb.resourceURL + 'base-images/prev_arr.jpg" /><img title="' + litb.langs.pageBar.next + '" src="' + litb.resourceURL + 'base-images/next_arr.jpg" style="right:10px;" />');
			for (var s = 0; s < t; s++) $(this).append('<img class="dfp_dot" title="' + (s + 1) + '" style="right:' + (10 + 14 * (t - s)) + 'px;" src="' + litb.resourceURL + 'base-images/dot.jpg" />');
			$(this).children("img").css({
				position: "absolute",
				cursor: "pointer",
				bottom: "7px",
				"z-index": 1
			}).bind("click",
			function(e) {
				$(e.target).attr("title") == litb.langs.pageBar.prev ? n--:$(e.target).attr("title") == litb.langs.pageBar.next ? n++:n = parseInt($(e.target).attr("title")) - 1;
				n = (n + t) % t;
				i(n)
			});
			$(this).children("img.dfp_dot").css("opacity", .5).eq(n).css("opacity", 1);
			$(this).css("direction") === "rtl" ? $(this).find(".clip-image").css({
				left: "auto",
				right: 0
			}) : $(this).find(".clip-image").css({
				left: 0,
				right: "auto"
			})
		}
	})
};
$.sandbox(function() {
	$(function() {
		$(".slide_dfp_l").slideBanner()
	});
	$(".banner-close").click(function() {
		$("#CATE_MAIN_BANNER_BIG_new").remove()
	})
});
$.sandbox(function() {
	$(".featured-categories").imgHover({
		src: litb.resourceURL + "/themes/default/images/imageHover176.png"
	}).removeClass("init");
	var e = 0,
	t = "paddingLeft",
	n = {
		padding: "0 0 0 7px"
	},
	r = "with-border";
	if (litb["lan"] == "ar" || litb["lan"] == "he") {
		t = "paddingRight";
		n = {
			padding: "0 7px 0 0"
		},
		r = ""
	}
	$(".featured-category").each(function(i) {
		e = Math.max(i % 4 === 0 ? $(this).height() : e, $(this).height());
		i % 4 === 0 ? i === 0 ? $(this).css(t, 0) : $(this).css(t, 0).before('<div class="clearfix separator"></div>') : i % 4 === 3 ? $(this).addClass(r).css(t, 0).css(n) : $(this).addClass("with-border");
		$(this).css("height", e)
	})
}); !
function(e) {
	"use strict";
	var t = function(e, t) {
		this.init("tooltip", e, t)
	};
	t.prototype = {
		constructor: t,
		init: function(t, n, r) {
			var i, s, o, u, a;
			this.type = t;
			this.$element = e(n);
			this.options = this.getOptions(r);
			this.enabled = !0;
			o = this.options.trigger.split(" ");
			for (a = o.length; a--;) {
				u = o[a];
				if (u == "click") this.$element.on("click." + this.type, this.options.selector, e.proxy(this.toggle, this));
				else if (u != "manual") {
					i = u == "hover" ? "mouseenter": "focus";
					s = u == "hover" ? "mouseleave": "blur";
					this.$element.on(i + "." + this.type, this.options.selector, e.proxy(this.enter, this));
					this.$element.on(s + "." + this.type, this.options.selector, e.proxy(this.leave, this))
				}
			}
			this.options.selector ? this._options = e.extend({},
			this.options, {
				trigger: "manual",
				selector: ""
			}) : this.fixTitle()
		},
		getOptions: function(t) {
			t = e.extend({},
			e.fn[this.type].defaults, this.$element.data(), t);
			t.delay && typeof t.delay == "number" && (t.delay = {
				show: t.delay,
				hide: t.delay
			});
			return t
		},
		enter: function(t) {
			var n = e.fn[this.type].defaults,
			r = {},
			i;
			this._options && e.each(this._options,
			function(e, t) {
				n[e] != t && (r[e] = t)
			},
			this);
			i = e(t.currentTarget)[this.type](r).data(this.type);
			if (!i.options.delay || !i.options.delay.show) return i.show();
			clearTimeout(this.timeout);
			i.hoverState = "in";
			this.timeout = setTimeout(function() {
				i.hoverState == "in" && i.show()
			},
			i.options.delay.show)
		},
		leave: function(t) {
			var n = e(t.currentTarget)[this.type](this._options).data(this.type);
			this.timeout && clearTimeout(this.timeout);
			if (!n.options.delay || !n.options.delay.hide) return n.hide();
			n.hoverState = "out";
			this.timeout = setTimeout(function() {
				n.hoverState == "out" && n.hide()
			},
			n.options.delay.hide)
		},
		show: function() {
			var t, n, r, i, s, o, u = e.Event("show");
			if (this.hasContent() && this.enabled) {
				this.$element.trigger(u);
				if (u.isDefaultPrevented()) return;
				t = this.tip();
				this.setContent();
				this.options.animation && t.addClass("fade");
				s = typeof this.options.placement == "function" ? this.options.placement.call(this, t[0], this.$element[0]) : this.options.placement;
				t.detach().css({
					top: 0,
					left: 0,
					display: "block"
				});
				this.options.container ? t.appendTo(this.options.container) : t.insertAfter(this.$element);
				n = this.getPosition();
				r = t[0].offsetWidth;
				i = t[0].offsetHeight;
				switch (s) {
				case "bottom":
					o = {
						top: n.top + n.height,
						left: n.left + n.width / 2 - r / 2
					};
					break;
				case "top":
					o = {
						top: n.top - i,
						left: n.left + n.width / 2 - r / 2
					};
					break;
				case "left":
					o = {
						top: n.top + n.height / 2 - i / 2,
						left: n.left - r
					};
					break;
				case "right":
					o = {
						top: n.top + n.height / 2 - i / 2,
						left: n.left + n.width
					}
				}
				this.applyPlacement(o, s);
				this.$element.trigger("shown")
			}
		},
		applyPlacement: function(e, t) {
			var n = this.tip(),
			r = n[0].offsetWidth,
			i = n[0].offsetHeight,
			s,
			o,
			u,
			a;
			n.offset(e).addClass(t).addClass("in");
			s = n[0].offsetWidth;
			o = n[0].offsetHeight;
			if (t == "top" && o != i) {
				e.top = e.top + i - o;
				a = !0
			}
			if (t == "bottom" || t == "top") {
				u = 0;
				if (e.left < 0) {
					u = e.left * -2;
					e.left = 0;
					n.offset(e);
					s = n[0].offsetWidth;
					o = n[0].offsetHeight
				}
				this.replaceArrow(u - r + s, s, "left")
			} else this.replaceArrow(o - i, o, "top");
			a && n.offset(e)
		},
		replaceArrow: function(e, t, n) {
			this.arrow().css(n, e ? 50 * (1 - e / t) + "%": "")
		},
		setContent: function() {
			var e = this.tip(),
			t = this.getTitle();
			e.find(".tooltip-inner")[this.options.html ? "html": "text"](t);
			e.removeClass("fade in top bottom left right")
		},
		hide: function() {
			function i() {
				var t = setTimeout(function() {
					n.off(e.support.transition.end).detach()
				},
				500);
				n.one(e.support.transition.end,
				function() {
					clearTimeout(t);
					n.detach()
				})
			}
			var t = this,
			n = this.tip(),
			r = e.Event("hide");
			this.$element.trigger(r);
			if (r.isDefaultPrevented()) return;
			n.removeClass("in");
			e.support.transition && this.$tip.hasClass("fade") ? i() : n.detach();
			this.$element.trigger("hidden");
			return this
		},
		fixTitle: function() {
			var e = this.$element; (e.attr("title") || typeof e.attr("data-original-title") != "string") && e.attr("data-original-title", e.attr("title") || "").attr("title", "")
		},
		hasContent: function() {
			return this.getTitle()
		},
		getPosition: function() {
			var t = this.$element[0];
			return e.extend({},
			typeof t.getBoundingClientRect == "function" ? t.getBoundingClientRect() : {
				width: t.offsetWidth,
				height: t.offsetHeight
			},
			this.$element.offset())
		},
		getTitle: function() {
			var e, t = this.$element,
			n = this.options;
			e = t.attr("data-original-title") || (typeof n.title == "function" ? n.title.call(t[0]) : n.title);
			return e
		},
		tip: function() {
			return this.$tip = this.$tip || e(this.options.template)
		},
		arrow: function() {
			return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow")
		},
		validate: function() {
			if (!this.$element[0].parentNode) {
				this.hide();
				this.$element = null;
				this.options = null
			}
		},
		enable: function() {
			this.enabled = !0
		},
		disable: function() {
			this.enabled = !1
		},
		toggleEnabled: function() {
			this.enabled = !this.enabled
		},
		toggle: function(t) {
			var n = t ? e(t.currentTarget)[this.type](this._options).data(this.type) : this;
			n.tip().hasClass("in") ? n.hide() : n.show()
		},
		destroy: function() {
			this.hide().$element.off("." + this.type).removeData(this.type)
		}
	};
	var n = e.fn.tooltip;
	e.fn.tooltip = function(n) {
		return this.each(function() {
			var r = e(this),
			i = r.data("tooltip"),
			s = typeof n == "object" && n;
			i || r.data("tooltip", i = new t(this, s));
			typeof n == "string" && i[n]()
		})
	};
	e.fn.tooltip.Constructor = t;
	e.fn.tooltip.defaults = {
		animation: !0,
		placement: "top",
		selector: !1,
		template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
		trigger: "hover focus",
		title: "",
		delay: 0,
		html: !1,
		container: !1
	};
	e.fn.tooltip.noConflict = function() {
		e.fn.tooltip = n;
		return this
	}
} (window.jQuery); !
function(e) {
	"use strict";
	var t = function(e, t) {
		this.init("popover", e, t)
	};
	t.prototype = e.extend({},
	e.fn.tooltip.Constructor.prototype, {
		constructor: t,
		setContent: function() {
			var e = this.tip(),
			t = this.getTitle(),
			n = this.getContent();
			e.find(".popover-title")[this.options.html ? "html": "text"](t);
			e.find(".popover-content")[this.options.html ? "html": "text"](n);
			e.removeClass("fade top bottom left right in")
		},
		hasContent: function() {
			return this.getTitle() || this.getContent()
		},
		getContent: function() {
			var e, t = this.$element,
			n = this.options;
			e = (typeof n.content == "function" ? n.content.call(t[0]) : n.content) || t.attr("data-content");
			return e
		},
		tip: function() {
			this.$tip || (this.$tip = e(this.options.template));
			return this.$tip
		},
		destroy: function() {
			this.hide().$element.off("." + this.type).removeData(this.type)
		}
	});
	var n = e.fn.popover;
	e.fn.popover = function(n) {
		return this.each(function() {
			var r = e(this),
			i = r.data("popover"),
			s = typeof n == "object" && n;
			i || r.data("popover", i = new t(this, s));
			typeof n == "string" && i[n]()
		})
	};
	e.fn.popover.Constructor = t;
	e.fn.popover.defaults = e.extend({},
	e.fn.tooltip.defaults, {
		placement: "right",
		trigger: "click",
		content: "",
		template: '<div class="popover"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
	});
	e.fn.popover.noConflict = function() {
		e.fn.popover = n;
		return this
	}
} (window.jQuery); (function(e) {
	e.fn.mask = function(t) {
		t = e.extend({
			maskOpacity: .5,
			picSize: "big"
		},
		t);
		e(this).each(function() {
			if (e(this).hasClass("masked")) return;
			var n = e(this);
			n.css("position") == "static" && n.addClass("masked-relative");
			var r = e('<div class="loadmask"></div>').css("opacity", t.maskOpacity);
			n.addClass("masked").append(r);
			var i = e('<div class="loadmask-msg loadmask-msg-' + t.picSize + '"></div>').appendTo(n);
			i.css({
				top: n.height() / 2 - (i.height() + parseInt(i.css("padding-top")) + parseInt(i.css("padding-bottom"))) / 2,
				left: n.width() / 2 - (i.width() + parseInt(i.css("padding-left")) + parseInt(i.css("padding-right"))) / 2
			})
		});
		return this
	};
	e.fn.unmask = function() {
		e(this).each(function() {
			var t = e(this);
			t.find(".loadmask-msg, .loadmask").remove();
			t.removeClass("masked masked-relative")
		});
		return this
	}
})($); (function(e) {
	e.fn.plusMontion = function(t) {
		t = e.extend({
			text: "<i class='plus-text helv-16-b'>+1</i>",
			interval: 600,
			length: 35,
			complete: function() {},
			isGlobal: !1
		},
		t);
		t.isGlobal ? e("<span class='plus-motion'>" + t.text + "</span>").appendTo(e("body")).css({
			top: this.offset().top - 20,
			left: this.offset().left
		}).animate({
			opacity: 0,
			top: "-=" + t.length
		},
		{
			complete: function() {
				t.complete();
				e(this).remove()
			},
			duration: t.interval
		}) : e("<span class='plus-motion'>" + t.text + "</span>").appendTo(this).animate({
			opacity: 0,
			top: "-=" + t.length
		},
		{
			complete: function() {
				t.complete();
				e(this).remove()
			},
			duration: t.interval
		});
		return this
	}
})($); (function(e) {
	var t = function(t, n) {
		var r = 0;
		e.trim(t.text()) != "" && (r = parseInt(t.text().replace(/\(|\)/g, ""), 10) || 0);
		if (r < n) {
			t.plusMontion({
				isGlobal: !0
			});
			r === 0 ? t.html(t.html() + "(" + n + ")") : t.html(t.html().replace(t.text(), "(" + n + ")"))
		}
		t.data("active", !0).find(".litb-icon-heart").addClass("litb-icon-heart-active").removeClass("litb-icon-heart")
	},
	n = function(e, t) {
		e.data("active", !1).find(".litb-icon-heart-active").removeClass("litb-icon-heart-active").addClass("litb-icon-heart")
	},
	r = function(e, t) {
		e.find("i").unmask();
		e.find("i").removeClass("snap");
		e.data("loading", !1);
		t && window.location.reload(!0)
	},
	i = function(e) {
		e.find("i").mask({
			maskOpacity: 0,
			picSize: "small"
		});
		e.find("i").addClass("snap")
	},
	s = litb.baseURL + "index.php",
	o = {
		add: {
			name: "add_to_wish_list",
			func: t
		},
		cancel: {
			name: "delete_from_wish_list",
			func: n
		}
	};
	e.fn.addFav = function(u) {
		u = e.extend({
			addSucc: t,
			cancelSucc: n,
			url: s,
			loadingFunc: i,
			favSelector: ""
		},
		u);
		var a = e(this);
		u.favSelector != "" && (a = e(this).find(u.favSelector));
		a.click(function(t) {
			t.preventDefault();
			var n = e(this),
			s = function(t, a) {
				if (a.success && a.success == 1 && n.data("loading") != 1) {
					n.data("loading", !0);
					i(n);
					var f = n.data("active") == 1 ? o.cancel: o.add;
					e.ajax({
						type: "POST",
						url: u.url + "?main_page=info_check&action=" + f.name + "&language=" + litb.lan,
						data: {
							products_id: n.data("id")
						},
						dataType: "json",
						success: function(t) {
							success = t.success;
							e(window).off("widget-login-state", s);
							success && f.func(n, t.addedTimes);
							r(n, a.submit != 0)
						},
						error: function() {
							e(window).off("widget-login-state", s);
							r(n, a.submit != 0)
						}
					})
				}
			};
			e(window).on("widget-login-state", s);
			e(window).trigger("widget-check-login-state")
		});
		return this
	}
})($);
$.sandbox(function() {
	$.fn.socialShow = function(e) {
		var t, n, r = !1,
		i = function(e, t) {
			var n = "vk_like_" + (new Date).getTime();
			$(e).find(".social-vkLike div")[0].id = n;
			typeof VK != "undefined" ? VK.Widgets.Like(n, {
				type: "mini",
				pageTitle: $(e).attr("title"),
				pageUrl: $(e).attr("href"),
				pageImage: $(e).find("img").attr("src"),
				height: 20
			}) : $.getScript("//vk.com/js/api/openapi.js?98",
			function() {
				VK.init({
					apiId: t,
					onlyWidgets: !0
				});
				VK.Widgets.Like(n, {
					type: "mini",
					pageTitle: $(e).attr("title"),
					pageUrl: $(e).attr("href"),
					pageImage: $(e).find("img").attr("src"),
					height: 20
				})
			})
		},
		s = function(e, t, n) {
			litb.lan == "he" && (t = "he_IL");
			litb.lan == "ar" && (t = "ar_AR");
			e.innerHTML = '<iframe src="//www.facebook.com/plugins/like.php?href=' + encodeURIComponent(n) + "&amp;width=80&amp;height=21&amp;colorscheme=light&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;send=false&amp;appId=&amp;locale=" + t + '" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:85px;height:21px;" allowTransparency="true"></iframe>'
		},
		o = function(e) {
			typeof pinterest != "undefined" ?
			function(e) {
				for (var t in e) if (t.indexOf("PIN_") == 0 && typeof e[t] != "boolean") return e[t];
				return null
			} (window).f.render.buttonPin(e) : $.getScript("//assets.pinterest.com/js/pinit.js",
			function() {
				pinterest = function(e) {
					for (var t in e) if (t.indexOf("PIN_") == 0 && typeof e[t] != "boolean") return e[t];
					return null
				} (window)
			})
		},
		u = function() {
			if (!t.data("snshandled")) {
				if (litb.lan == "ru") {
					t.find(".social-vkLike").append('<div style="width:80px"></div>').show();
					i(t, t.find(".social-vkLike").data("vklike"));
					t.find(".social-facebook").hide()
				} else {
					var e = t.find(".social-facebook"),
					n = $(document.createElement("fb:like"));
					n.attr("href", e.data("facebook"));
					n.attr("layout", "button_count");
					e.empty().append(n);
					s(e.get(0), e.data("language"), e.data("facebook"))
				}
				var r = t.find(".social-pinterest");
				r.append(r.data("pinterest")).show();
				o(r.find("a")[0]);
				t.data("snshandled", !0)
			}
		},
		a = function() {
			if (!t.find(".c-prod-social-share").length) return;
			r || (n = setTimeout(function() {
				r = !0;
				u();
				t.find(".c-prod-social-share").animate({
					bottom: "+=25"
				},
				100)
			},
			100))
		},
		f = function() {
			if (!t.find(".c-prod-social-share").length) return;
			clearTimeout(n);
			if (r) {
				r = !1;
				t.find(".c-prod-social-share").animate({
					bottom: "-=25"
				},
				100)
			}
		};
		$(this).hover(function() {
			t = $(this);
			a()
		},
		function() {
			f()
		})
	}
});
$.sandbox(function() {
	$(".prod-item").each(function(e, t) {
		if ($(t).data("width") === 176) {
			$(t).find(".iconStockOut").removeClass("iconStockOut").addClass("iconStockOutB");
			$(t).find(".iconWholesaleOnly").removeClass("iconWholesaleOnly").addClass("iconWholesaleOnlyB");
			$(t).find(".icons-new").removeClass("icons-new").addClass("icons-new-b")
		}
		if ($(t).data("width") === 236) {
			$(t).find(".iconStockOut").removeClass("iconStockOut").addClass("iconStockOutL");
			$(t).find(".iconWholesaleOnly").removeClass("iconWholesaleOnly").addClass("iconWholesaleOnlyL");
			$(t).find(".icons-new").removeClass("icons-new").addClass("icons-new-b")
		}
		$(t).find(".litb-icon-Mutiple-Colors").popover({
			trigger: "hover",
			placement: "bottom",
			template: '<div class="popover"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p></p></div></div></div>'
		});
		$(t).find(".tool-info").popover({
			trigger: "hover",
			placement: "bottom",
			content: function() {
				return $(this).data("active") ? litb.langs.myFav: litb.langs.addToMyFav
			},
			template: '<div class="popover"><div class="arrow"></div><div class="popover-inner"><div class="popover-content"><p></p></div></div></div>'
		})
	});
	$(".favorite-for-cate").addFav();
	$(".prod-item").find(".discount-timer").each(function() {
		$(this).genTimer({
			beginTime: litb.curDate,
			targetTime: $(this).attr("endTime"),
			callback: function(e) {
				this.html(e)
			},
			type: "diffNoDay"
		})
	})
}); (function(e) {
	var t = !1;
	e.bindScroll = function(n) {
		if (!t) {
			t = !0;
			var r;
			function i(t) {
				r && clearTimeout(r);
				r = setTimeout(function() {
					e(window).trigger("widget-scroll", t)
				},
				n || 50)
			}
			e(window).scroll(function(e) {
				i(e)
			})
		}
	};
	e.bindScroll()
})($);
$(function() {
	var $win = $(window),
	$elements = $(".ctr-track-viewed .prod-item .img-box"),
	belowthefold = function(e, t) {
		var n = $win.height() + $win.scrollTop();
		return n <= e.offset().top - t
	},
	update = function() {
		var ctrInfo = {},
		cciStr = [];
		$elements.each(function() {
			var appear = !belowthefold($(this), 100);
			if (appear && $(this).data("tracked") !== !0) {
				$(this).data("tracked", !0);
				ctrInfo = eval("(" + ($(this).attr("ctr") || "") + ")");
				cciStr.push(ctrInfo.cci)
			}
		});
		cciStr.length > 0 && $elements.eq(0).tracking({
			action: "VIEWED",
			cci: cciStr.join(",")
		})
	};
	$win.on("widget-scroll", update);
	update()
});
$.sandbox(function() {
	function n(e, t) {
		if (e.length <= 0) return;
		var r = e.slice(0, t),
		s = 0;
		for (i = 0; i < r.length; i++) s = Math.max(s, r.eq(i).height());
		r.height(s);
		n(e.slice(t), t)
	}
	var e = "http://litbimg.rightinthebox.com/resource_34bdc6c4b3eb489047c809e542844eb02cd89e85/dev_v2/themes/default/images/",
	t = {
		"240X386": e + "imageHover240X386.png",
		"128X128": e + "imageHover128.png",
		"176X176": e + "imageHover176.png",
		"176X284": e + "imageHover176X284.png"
	};
	$(".flat-list").imgHover();
	$(window).on("product-list-rendered",
	function(e, r) {
		var i = r.box;
		if (i && i.find(".prod-item").length === 0) return i.hide();
		if (i.hasClass("flat-list")) return;
		if (!r.notHr) {
			i.find(".prod-item:nth-child(" + r.columns + "n)").after('<div class="separator">');
			i.children(":last").removeClass("separator")
		} else {
			i.find(".prod-item:nth-child(" + r.columns + "n)").after('<div class="separator-blank">');
			i.children(":last").removeClass("separator-blank")
		}
		r.hoverImg == "128X128" ? i.imgHover({
			src: t[r.hoverImg]
		}) : i.find(".prod-item").find(".img-box").socialShow();
		n(i.find(".prod-item"), r.columns)
	})
});; !
function(e) {
	"use strict";
	e(function() {
		e.support.transition = function() {
			var e = function() {
				var e = document.createElement("bootstrap"),
				t = {
					WebkitTransition: "webkitTransitionEnd",
					MozTransition: "transitionend",
					OTransition: "oTransitionEnd otransitionend",
					transition: "transitionend"
				},
				n;
				for (n in t) if (e.style[n] !== undefined) return t[n]
			} ();
			return e && {
				end: e
			}
		} ()
	})
} (window.jQuery); !
function(e) {
	"use strict";
	var t = function(t, n) {
		this.options = n;
		this.$element = e(t).delegate('[data-dismiss="modal"]', "click.dismiss.modal", e.proxy(this.hide, this));
		this.options.remote && this.$element.find(".modal-body").load(this.options.remote)
	};

	t.prototype = {
		constructor: t,
		toggle: function() {
			return this[this.isShown ? "hide": "show"]()
		},
		show: function() {
			var t = this,
			n = e.Event("show");
			this.$element.trigger(n);
			if (this.isShown || n.isDefaultPrevented()) return;
			this.isShown = !0;
			this.escape();
			this.backdrop(function() {
				var n = e.support.transition && t.$element.hasClass("fade");
				t.$element.parent().length || t.$element.appendTo(document.body);
				t.$element.show();
				n && t.$element[0].offsetWidth;
				t.$element.addClass("in").attr("aria-hidden", !1);
				t.enforceFocus();
				n ? t.$element.one(e.support.transition.end,
				function() {
					t.$element.focus().trigger("shown")
				}) : t.$element.focus().trigger("shown")
			})
		},
		hide: function(t) {
			t && t.preventDefault();
			var n = this;
			t = e.Event("hide");
			this.$element.trigger(t);
			if (!this.isShown || t.isDefaultPrevented()) return;
			this.isShown = !1;
			this.escape();
			e(document).off("focusin.modal");
			this.$element.removeClass("in").attr("aria-hidden", !0);
			e.support.transition && this.$element.hasClass("fade") ? this.hideWithTransition() : this.hideModal()
		},
		enforceFocus: function() {
			var t = this;
			e(document).on("focusin.modal",
			function(e) {
				t.$element[0] !== e.target && !t.$element.has(e.target).length && t.$element.focus()
			})
		},
		escape: function() {
			var e = this;
			this.isShown && this.options.keyboard ? this.$element.on("keyup.dismiss.modal",
			function(t) {
				t.which == 27 && e.hide()
			}) : this.isShown || this.$element.off("keyup.dismiss.modal")
		},
		hideWithTransition: function() {
			var t = this,
			n = setTimeout(function() {
				t.$element.off(e.support.transition.end);
				t.hideModal()
			},
			500);
			this.$element.one(e.support.transition.end,
			function() {
				clearTimeout(n);
				t.hideModal()
			})
		},
		hideModal: function(e) {
			this.$element.hide().trigger("hidden");
			this.backdrop()
		},
		removeBackdrop: function() {
			this.$backdrop.remove();
			this.$backdrop = null
		},
		backdrop: function(t) {
			var n = this,
			r = this.$element.hasClass("fade") ? "fade": "";
			if (this.isShown && this.options.backdrop) {
				var i = e.support.transition && r;
				this.$backdrop = e('<div class="modal-backdrop ' + r + '" />').appendTo(document.body);
				this.$backdrop.click(this.options.backdrop == "static" ? e.proxy(this.$element[0].focus, this.$element[0]) : e.proxy(this.hide, this));
				i && this.$backdrop[0].offsetWidth;
				this.$backdrop.addClass("in");
				i ? this.$backdrop.one(e.support.transition.end, t) : t()
			} else if (!this.isShown && this.$backdrop) {
				this.$backdrop.removeClass("in");
				e.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one(e.support.transition.end, e.proxy(this.removeBackdrop, this)) : this.removeBackdrop()
			} else t && t()
		}
	};
	var n = e.fn.modal;
	e.fn.modal = function(n) {
		return this.each(function() {
			var r = e(this),
			i = r.data("modal"),
			s = e.extend({},
			e.fn.modal.defaults, r.data(), typeof n == "object" && n);
			i || r.data("modal", i = new t(this, s));
			typeof n == "string" ? i[n]() : s.show && i.show()
		})
	};
	e.fn.modal.defaults = {
		backdrop: !0,
		keyboard: !0,
		show: !0
	};
	e.fn.modal.Constructor = t;
	e.fn.modal.noConflict = function() {
		e.fn.modal = n;
		return this
	};
	e(document).on("click.modal.data-api", '[data-toggle="modal"]',
	function(t) {
		var n = e(this),
		r = n.attr("href"),
		i = e(n.attr("data-target") || r && r.replace(/.*(?=#[^\s]+$)/, "")),
		s = i.data("modal") ? "toggle": e.extend({
			remote: !/#/.test(r) && r
		},
		i.data(), n.data());
		t.preventDefault();
		i.modal(s).one("hide",
		function() {
			n.focus()
		})
	})
} (window.jQuery); (function(e) {
	function u(t) {
		r = e(window).width() - t.width();
		r = r >= 0 ? r: 0;
		s = t.offset() && t.offset().top || 0;
		t.css({
			"margin-left": 0,
			left: r / 2,
			top: o + s
		})
	}
	function a(t) {
		r = e(window).width() - t.width();
		r = r >= 0 ? r: 0;
		i = e(window).height() - t.height();
		i = i >= 0 ? i: 0;
		t.css({
			"margin-left": 0,
			left: r / 2,
			top: e(window).scrollTop() + i / 2
		})
	}
	var t = 0,
	n = function(n) {
		var r = "dialog_" + t++;
		n = e.extend({
			content: "",
			header: "",
			footer: "",
			className: "",
			id: r,
			backdrop: !0,
			keyboard: !0,
			show: !1,
			bodyCssText: ""
		},
		n);
		var i = e.mustache(['<div id="{{id}}" class="{{className}} modal hide fade" role="dialog" aria-hidden="true" tabindex="-1">', '<div class="modal-header">', '<button class="close" data-dismiss="modal" aria-hidden="true">×</button>', "{{header}}", "</div>", '<div class="modal-body" style="{{{bodyCssText}}}">{{{content}}}</div>', '<div class="modal-footer">{{{footer}}}</div>', "</div>"].join(""), n);
		e(i).appendTo(e(document.body));
		var s = new e.fn.modal.Constructor("#" + n.id, n);
		u(s.$element);
		navigator.userAgent.toUpperCase().indexOf("MSIE") !== -1 && e(window).on("load",
		function() {
			e(window).on("resize",
			function() {
				u(s.$element)
			})
		});
		s.reflow = function() {
			a(s.$element)
		};
		return s
	},
	r,
	i,
	s,
	o = 100;
	e.Modal = n
})($);
$.sandbox(function() {
	$(".attachments").each(function() {
		if (this.children.length === 0) return this.style.display = "none";
		var e = $(this);
		if (e.data("handled")) return;
		e.data("handled", !0);
		var t = e.find("img"),
		n = [];
		t.each(function(e, t) {
			n.push({
				src: $(t).attr("src") || $(t).data("src"),
				index: e,
				pos: e + 1
			})
		});
		var r = $.mustache(['<div class="slideshow" ctr="{area:\'product_images_popup\'}">', '<img class="big">', '<div class="{{cls}}">', '<a href="#" hidefocus="true" class="arrow-holder left" ctr="{pos:1,entity:\'pre_arrow\'}">', '<span class="left arrow-icon litb-icon-huge-left"></span>', "</a>", '<a href="#" hidefocus="true" class="arrow-holder right" ctr="{pos:1,entity:\'next_arrow\'}">', '<span class="right arrow-icon litb-icon-huge-right"></span>', "</a>", "</div>", "</div>", '<div class="thumbnail">', '<div class="thumbnail-content">', "{{#imgList}}", '<img class="ctrTrack" ctr="{entity:\'thumbs\',pos:{{pos}} }" src="{{{src}}}" data-index="{{index}}">', "{{/imgList}}", "</div>", "</div>"].join(""), {
			cls: t.length < 2 ? "hide": "show",
			imgList: n
		}),
		i,
		s,
		o,
		u,
		a,
		f,
		l,
		c,
		h;
		t.click(function(e) {
			if (!i) {
				i = new $.Modal({
					content: r,
					className: "attachments"
				});
				i.$element.css("width", "500px");
				s = i.$element.find(".thumbnail-content img"),
				u = i.$element.find(".big"),
				l = i.$element.find(".arrow-holder.left"),
				c = i.$element.find(".arrow-holder.right");
				s.click(function(e) {
					a && a.removeClass("current");
					a = $(this);
					a.addClass("current");
					h($(this).attr("src"))
				});
				function t(e) {
					f = a.data("index");
					e === "pre" ? f = f === 0 ? n.length - 1 : f - 1 : f = f === n.length - 1 ? 0 : f + 1;
					h(n[f].src);
					a && a.removeClass("current");
					a = $(s[f]);
					a.addClass("current")
				}
				var p = {},
				d = u.parent();
				h = function(e) {
					e = e.replace("/middle/", "/big/"); ! p[e] && d.mask();
					u.attr("src", e);
					u.load(function() { ! p[e] && d.unmask();
						p[e] = e
					})
				};
				l.click(function(e) {
					e.preventDefault();
					t("pre")
				});
				c.click(function(e) {
					e.preventDefault();
					t("next")
				})
			}
			o = $(this);
			i.show();
			h(o.attr("src"));
			a && a.removeClass("current");
			s.each(function() {
				if (this.src === o.attr("src")) {
					a = $(this);
					a.addClass("current")
				}
			})
		})
	})
});
$.sandbox(function() {
	$(".helpful-item .img-box").imgHover()
});
$.sandbox(function() {
	var e = $(".most-helpful-reviews");
	e.find("dl").length === 0 && e.hide()
});
$.buildCarouselHTML = function(e) {
	var t = ['<div class="item">', '<a href="{{{link}}}" ctr=\'{"pos":"{{pos}}","cpid":"{{cpid}}","entity":"p_image"}\' >', '<img width="{{imgWidth}}" height="{{imgHeight}}" src="{{{image}}}" alt="{{title}}" title="{{title}}">', "</a>", "</div>"];
	if (e.list) {
		$.each(e.list,
		function(e, t) {
			t.pos = e + 1;
			t.cpid = t.cpid || t.pid
		});
		t.unshift("{{#list}}");
		t.push("{{/list}}");
		return $.mustache(t.join(""), e)
	}
	var n = $($.mustache(t.join(""), e));
	e.cpid = e.cpid || e.pid;
	n.data("meta", e);
	return n
};
$.mobileUtils = {
	supportTransform3d: function() {
		var e = !1,
		t = $('<div style="position:relative;height:0;"></div>');
		$("body").append(t);
		t.css({
			transform: "translate3d(3px,0,0)",
			"-moz-transform": "translate3d(3px,0,0)",
			"-webkit-transform": "translate3d(3px,0,0)",
			"-o-transform": "translate3d(3px,0,0)",
			"-ms-transform": "translate3d(3px,0,0)"
		});
		e = t.offset().left - $(t[0].offsetParent).offset().left === 3;
		return e
	},
	swipeDirection: function(e, t, n, r) {
		var i = Math.abs(e - n),
		s = Math.abs(t - r);
		return i >= s ? e - n > 0 ? "left": "right": t - r > 0 ? "up": "down"
	},
	onTouchEvent: function(e, t) {
		function s(e) {
			r.start = (new Date).getTime();
			r.x1 = e.touches[0].pageX;
			r.y1 = e.touches[0].pageY
		}
		function o(e) {
			e.preventDefault();
			r.x2 = e.touches[0].pageX;
			r.y2 = e.touches[0].pageY
		}
		function u(e) {
			typeof r.x2 == "number" && e.preventDefault();
			r.end = (new Date).getTime();
			r.speed = n.speed(r.x1, r.y1, r.x2, r.y2, r.end - r.start);
			e.touch = r;
			if (r.x2 && Math.abs(r.x1 - r.x2) > 30 || r.y2 && Math.abs(r.y1 - r.y2) > 30) {
				clearTimeout(i);
				i = setTimeout(function() {
					var i = n.swipeDirection(r.x1, r.y1, r.x2, r.y2),
					s = i + "Callback";
					t[s] && t[s](e);
					e.touch = r = {}
				},
				0)
			}
		}
		function a(e) {
			e.preventDefault();
			clearTimeout(i);
			r = {}
		}
		var n = this,
		t = t || {},
		r = {},
		i;
		e.on("touchstart",
		function(e) {
			s(e.originalEvent)
		});
		e.on("touchmove",
		function(e) {
			o(e.originalEvent)
		});
		e.on("touchend",
		function(e) {
			u(e.originalEvent)
		});
		e.on("touchcancel",
		function(e) {
			a(e.originalEvent)
		})
	},
	translate: function(e, t, n) {
		var r = e[0].style;
		r.webkitTransitionDuration = r.MozTransitionDuration = r.msTransitionDuration = r.OTransitionDuration = r.transitionDuration = n + "ms";
		r.transform = r.MozTransform = r.webkitTransform = "translate3d(" + t + "px,0,0)";
		r.msTransform = r.OTransform = "translateX(" + t + "px)";
		r.transitionTimingFunction = r.webkitTransitionTimingFunction = r.mozTransitionTimingFunction = r.msTransitionTimingFunction = r.oTransitionTimingFunction = "ease-in-out"
	},
	transform: function(t, n, r, i, s, o) {
		t.off("transitionend webkitTransitionEnd msTransitionEnd oTransitionEnd");
		t.on("transitionend webkitTransitionEnd msTransitionEnd oTransitionEnd", s);
		o = typeof o == "number" ? o: n === "left" ? t.position().left + r: t.position().left - r;
		this.translate(t, o, i)
	},
	speed: function(e, t, n, r, i) {
		return Math.sqrt(Math.pow(Math.abs(n - e), 2) + Math.pow(Math.abs(r - t), 2)) / i
	}
}; (function(e) {
	var t = e.mobileUtils;
	e.fn.carousel = function(n) {
		n = e.extend({
			itemsPerMove: 1,
			itemWidth: 128,
			revise: 0,
			duration: 500,
			dx: -1,
			disabledClass: "",
			current: 0,
			viewport: {
				width: 930,
				height: 128
			}
		},
		n);
		var r = t.supportTransform3d();
		this.each(function(i, s) {
			function w() {
				y = !1;
				var e = u.position().left;
				if (e >= 0 || Math.round(e) === 0) {
					u.trigger("leftEnd");
					a.addClass("disabled" + p).removeClass(c)
				} else a.removeClass("disabled").removeClass(p).addClass(c);
				if (Math.abs(e) + (o.outerWidth() + n.revise) >= m) {
					f.addClass("disabled" + d).removeClass(h);
					u.trigger("rightEnd")
				} else f.removeClass("disabled").removeClass(d).addClass(h);
				S()
			}
			function E(e, i) {
				i && i.preventDefault();
				if (e === "left" && a.hasClass("disabled") || e === "right" && f.hasClass("disabled")) return ! 1;
				y = !0;
				r ? t.transform(u, e, g, n.duration, w) : u.animate({
					left: (e === "left" ? "+=": "-=") + g
				},
				n.duration, "swing", w)
			}
			function S() {
				var t = b - Math.ceil((u.position().left + m) / (o.outerWidth() + n.revise));
				l.html(n.current + 1 + "/" + b);
				e(window).trigger("widget-carousel-update", {
					total: b,
					current: n.current
				})
			}
			var o = e(s);
			o.css(n.viewport);
			var u = o.find(".list"),
			a = o.find("a.left"),
			f = o.find("a.right"),
			l = o.find(".page"),
			c = n.disabledClass ? " litb-icon-" + n.disabledClass + "-left-arraw": "",
			h = n.disabledClass ? " litb-icon-" + n.disabledClass + "-right-arraw": "",
			p = n.disabledClass ? c + "-disabled": "",
			d = n.disabledClass ? h + "-disabled": "",
			v = Math.max(n.itemWidth, u.children(":first").outerWidth(!0), u.children(":last").outerWidth(!0)),
			m = v * u.children().length - n.dx;
			u.css("width", m);
			u.position().left === 0 && a.addClass("disabled" + p).removeClass(c);
			m <= n.viewport.width && f.addClass("disabled" + d).removeClass(h);
			var g = v * n.itemsPerMove,
			y = !1,
			b = Math.ceil(m / (o.outerWidth() + n.revise));
			a.click(function(e) {
				e.preventDefault();
				if (!y) {
					E("left");
					n.current !== 0 && n.current--
				}
			});
			f.click(function(e) {
				e.preventDefault();
				if (!y) {
					E("right");
					n.current !== b - 1 && n.current++
				}
			});
			S();
			t.onTouchEvent(u, {
				leftCallback: function(e) {
					E("right", e)
				},
				rightCallback: function(e) {
					E("left", e)
				}
			})
		});
		return this
	}
})($);
$.sandbox(function() {
	function e(e) {
		var t = $(e.el);
		if (t.data("handled")) return;
		var n = e.list || t.data("list"),
		r = e.config || t.data("config");
		if (!n) return;
		t.html('<div class="list">' + $.buildCarouselHTML({
			list: n,
			imgWidth: r.imgWidth,
			imgHeight: r.imgHeight
		}) + "</div>");
		t.find("img").error(function() {
			$(window).trigger("image-load-fail", {
				el: $(this)
			})
		});
		t.find(".item").each(function(e, t) {
			$(t).data("meta", n[e])
		});
		t.parent().carousel($.extend({
			itemsPerMove: r.itemsPerMove || r.group,
			viewport: {
				width: r.width,
				height: r.height
			}
		},
		r)).imgHover({
			src: r.hover || t.parent().data("hover"),
			viewport: {
				width: r.imgWidth,
				height: r.imgHeight
			}
		});
		t.find(".item .img-box").tracking({
			action: "CLICK"
		},
		!0);
		t.data("handled", !0)
	}
	$(".carousel .viewport").each(function(t, n) {
		e({
			el: n
		})
	});
	$(window).on("widget-carousel-data-loaded",
	function(t, n) {
		e(n)
	})
});
$.sandbox(function() {
	function n() {
		if (e.offset() && e.offset().top - t.scrollTop() < t.height() + 500) {
			$(window).unbind("scroll", n);
			$.cookie("recently_view") !== "" && $.ajax({
				type: "get",
				dataType: "json",
				url: e.data("action"),
				success: function(e) {
					e && e.info && e.info.length > 0 && r(e)
				},
				error: function() {
					e.hide()
				}
			})
		}
	}
	function r(t) {
		e.attr({
			ctr: '{"pids":"' + t.ctrInfo.pids + '","area":"recent_history", "type":"P", "id":"' + t.ctrInfo.listId + '"}'
		});
		if (t.info && t.info.length > 0) {
			e.show();
			e.tracking()
		}
		var n = e.find(".viewport");
		n.parent().data("hover", "http://litbimg.rightinthebox.com/resource_34bdc6c4b3eb489047c809e542844eb02cd89e85/dev_v2/base-images/imageHover128.png");
		$(window).trigger("widget-carousel-data-loaded", {
			el: n,
			list: t.info,
			config: {
				width: 931,
				height: 160,
				group: 6,
				imgWidth: 128,
				imgHeight: 128,
				duration: 600,
				itemWidth: 158,
				dx: 30
			}
		});
		e.find(".item").each(function(e, t) {
			$(t).append($.mustache('<a class="bottom-descript ctr-track" ctr={"pos":{{pos}},"cpid":{{pid}},"entity":"p_name"} href="{{link}}" title="{{{title}}}">{{{name}}}</a>', $(t).data("meta")))
		});
		e.find(".bottom-descript").each(function() {
			$(this).tracking({
				action: "click"
			},
			!0)
		})
	}
	var e = $(".recent-history"),
	t = $(window);
	t.bind("scroll", n)
});
$.fn.autocompleteEmail = function(options) {
	function hidePP(e) {
		var t = e.keyCode ? e.keyCode: e.charCode;
		if (t == 27) {
			$("#" + options.resultsid).hide();
			options.esc = !0;
			$(document).unbind("keydown", hidePP)
		}
	}
	var me = this,
	$input = $(this),
	defaults = {
		resultsClass: "mailInstant",
		resultsid: "resultsEmail",
		overClass: "over",
		minChars: 1,
		zIndex: 9992,
		width: 2,
		delay: 50,
		esc: !1,
		data: []
	},
	options = $.extend(defaults, options),
	timeout = null,
	active = -1,
	hasFocus = !1,
	prev = "";
	litb.emailList = "";
	var lastKeyPressCode = null,
	_url = litb.baseURL + "index.php?main_page=info_check&action=get_email_domains&language=" + litb.lan;
	this.init = function() {
		var e = document.createElement("div"),
		t = $(e);
		t.css("z-index", options.zIndex);
		t.attr("id", options.resultsid);
		t.hide().addClass(options.resultsClass).css("position", "absolute");
		$("#" + options.resultsid)[0] || $("body").prepend(e)
	};
	$(document).ready(function() {
		litb.emailList == "" && $.ajax({
			type: "post",
			url: _url,
			success: function(data) {
				data = eval("[" + data + "]")[0];
				data != "" && (litb.emailList = data)
			}
		})
	});
	$(document).keydown(hidePP);
	this.showResult = function() {
		if (!$input.val()) return;
		me.requestData()
	};
	this.showHtml = function(e, t, n, r, i) {
		for (var s = 0; s < e.length; s++) {
			var o = document.createElement("li");
			o.innerHTML = "<span>" + r + "</span>@" + e[s];
			i.appendChild(o);
			t != -1 && e[s].indexOf(n) != 0 ? $(o).remove() : $(o).show()
		}
		$("h4", i).after("<li>" + $input.val() + "</li>");
		$("li", i).each(function(e) {
			e > 11 ? $(this).remove() : e > 0 && $(this).text() == $input.val() ? $(this).remove() : $(this).hover(function() {
				$(this).addClass(options.overClass);
				active = e
			},
			function() {
				$(this).removeClass(options.overClass)
			}).click(function(e) {
				me.selectItem(this);
				e.preventDefault();
				e.stopPropagation()
			});
			$(this).attr({
				title: $(this).text(),
				alt: $(this).text()
			})
		});
		$("#" + options.resultsid).css({
			top: $input.offset().top + $input.outerHeight() - 1 + "px",
			left: $input.offset().left + "px",
			width: $input.width() + options.width
		}).html(i).show()
	};
	this.requestData = function() {
		var ul = document.createElement("ul"),
		_title = document.createElement("h4");
		$(_title).html(litb.langs.selecteMailType);
		ul.appendChild(_title);
		var _val = $input.val(),
		__val = $input.val(),
		_len = _val.indexOf("@");
		if (_len != -1) {
			_val = _val.substring(_len + 1, _val.length);
			__val = $input.val().substring(0, _len)
		}
		litb.emailList == "" ? $.ajax({
			type: "post",
			url: _url,
			data: "",
			complete: function() {},
			success: function(data) {
				data = eval("[" + data + "]")[0];
				if (data != "") {
					me.showHtml(data, _len, _val, __val, ul);
					litb.emailList = data
				}
			},
			error: function() {}
		}) : me.showHtml(litb.emailList, _len, _val, __val, ul)
	};
	this.selectItem = function(e) {
		var t = $.trim($(e).text());
		$input.val(t);
		me.hideResultsNow()
	};
	this.hideResultsNow = function() {
		timeout && clearTimeout(timeout);
		timeout = setTimeout(function() {
			$("#" + options.resultsid).is(":visible") && $("#" + options.resultsid).hide()
		},
		200)
	};
	this.onChange = function() {
		if (lastKeyPressCode >= 33 && lastKeyPressCode <= 45 || lastKeyPressCode == 144 || lastKeyPressCode == 145 || lastKeyPressCode == 9 || lastKeyPressCode >= 112 && lastKeyPressCode <= 135) return;
		var e = $input.val();
		e.length >= options.minChars && !options.esc ? me.showResult() : $("#" + options.resultsid).hide();
		options.esc = !1
	};
	this.moveSelect = function(e) {
		var t = $("li", $("#" + options.resultsid));
		active += e;
		active < 0 ? active = t.size() - 1 : active >= t.size() && (active = 0);
		$(t).removeClass(options.overClass);
		$(t).eq(active).addClass(options.overClass);
		$input.val($(t).eq(active).text())
	};
	$input.keyup(function(e) {
		if (lastKeyPressCode == 13) return;
		hasFocus = !0;
		lastKeyPressCode = e.keyCode;
		if (lastKeyPressCode < 37 || lastKeyPressCode > 40) {
			active = -1;
			timeout && clearTimeout(timeout);
			timeout = setTimeout(function() {
				me.onChange()
			},
			options.delay)
		}
	}).keydown(function(e) {
		hasFocus = !0;
		lastKeyPressCode = e.keyCode;
		switch (e.keyCode) {
		case 13:
			$input.val() == "";
			me.hideResultsNow();
			if ($("#resultsEmail")[0].style.display == "block") {
				e.keyCode = 0;
				return ! 1
			}
			break;
		case 38:
			e.preventDefault();
			$("#" + options.resultsid).is(":visible") && me.moveSelect( - 1);
			break;
		case 40:
			e.preventDefault();
			$("#" + options.resultsid).is(":visible") && me.moveSelect(1);
			break;
		default:
		}
	}).blur(function() {
		hasFocus = !1;
		me.hideResultsNow()
	});
	this.init()
}; (function(e) {
	e.fn.hoverPop = function(t) {
		this.each(function() {
			if (typeof t == "string") switch (t) {
			case "destroy":
				e(this).parent().off("mouseleave mouseenter");
				e(this).off("hover").popover(t);
				break;
			default:
				e(this).popover(t)
			} else {
				var n = e.extend({
					delay: {
						show: 200,
						hide: 100
					}
				},
				t || {},
				{
					html: !0,
					trigger: "manual"
				}),
				r = e(this),
				i = 0;
				if (r.data("hoverPop")) return;
				r.data("hoverPop", !0);
				r.popover(n).hover(function() {
					clearTimeout(i);
					if (e(this).hasClass("popover-show")) return;
					var t = this;
					i = setTimeout(function() {
						e(t).popover("show").addClass("popover-show")
					},
					n.delay.show)
				},
				function(t) {
					clearTimeout(i);
					if (!e(this).hasClass("popover-show")) return;
					var r = this;
					i = setTimeout(function() {
						e(r).popover("hide").removeClass("popover-show")
					},
					n.delay.hide)
				}).parent().on("mouseenter", ".popover",
				function() {
					clearTimeout(i)
				}).on("mouseleave", ".popover",
				function() {
					i = setTimeout(function() {
						r.popover("hide").removeClass("popover-show")
					},
					n.delay.hide)
				})
			}
		})
	}
})(jQuery);
$.sandbox(function() {
	$(function() {
		$("#footerSubAddr").focus(function() {
			if (this.value == "Your Email Address") {
				this.value = "";
				$(this).addClass("valid");
				$(this).autocompleteEmail({
					width: 8
				})
			}
		}).blur(function() {
			if (this.value == "") {
				this.value = "Your Email Address";
				$(this).removeClass("valid")
			}
		});
		$("#newsletter_sub_form").submit(function() {
			if (!/^[\w.-]+\@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test($("#footerSubAddr").val())) {
				$("#footerSubAddr").focus();
				alert('Please check your email address.\nYour email addresses should look like "myname@gmail.com"');
				return ! 1
			}
		});
		$(".footer-sub .footer-email-btn").click(function() {
			$("#newsletter_sub_form").submit()
		});
		$(".paypal").click(function() {
			window.open("https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/Marketing/popup/OLCWhatIsPayPal-outside", "olcwhatispaypal", "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350");
			return ! 1
		});
		$(".paypal-verified").click(function() {
			window.open("https://www.paypal.com/verified/pal=order@litb-inc.com", "olcwhatispaypal", "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350");
			return ! 1
		});
		$(".popular-related-pages span").last().css("display", "none");
		$(".product-guide span").last().css("display", "none");
		$(".product-guide i").last().css("display", "none");
		if ($(".new-wechat").size() > 0) {
			var e = litb.baseURL.search("lightinthebox") >= 0 ? mainbox: minibox;
			$(".mini-wechat.new-wechat").hoverPop({
				placement: "top",
				content: e
			})
		}
	})
});
$.sandbox(function() {
	$(".related-categories a").length === 0 && $(".related-categories").remove()
}); (function() {
	$(window).trigger("product-list-rendered", {
		columns: 5,
		hoverImg: "128X128",
		box: $(".recommended-products")
	})
})();;