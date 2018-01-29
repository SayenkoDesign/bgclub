'use strict';

/**
 * This script adds the accessibility-ready responsive menus Genesis Framework child themes.
 *
 * @author StudioPress
 * @link https://github.com/copyblogger/responsive-menus
 * @version 1.1.3
 * @license GPL-2.0+
 */

(function (document, $, undefined) {

	'use strict';

	$('body').removeClass('no-js');

	var genesisMenuParams = typeof genesis_responsive_menu === 'undefined' ? '' : genesis_responsive_menu,
	    genesisMenusUnchecked = genesisMenuParams.menuClasses,
	    genesisMenus = {},
	    menusToCombine = [];

	/**
  * Validate the menus passed by the theme with what's being loaded on the page,
  * and pass the new and accurate information to our new data.
  * @param {genesisMenusUnchecked} Raw data from the localized script in the theme.
  * @return {array} genesisMenus array gets populated with updated data.
  * @return {array} menusToCombine array gets populated with relevant data.
  */
	$.each(genesisMenusUnchecked, function (group) {

		// Mirror our group object to populate.
		genesisMenus[group] = [];

		// Loop through each instance of the specified menu on the page.
		$.each(this, function (key, value) {

			var menuString = value,
			    $menu = $(value);

			// If there is more than one instance, append the index and update array.
			if ($menu.length > 1) {

				$.each($menu, function (key, value) {

					var newString = menuString + '-' + key;

					$(this).addClass(newString.replace('.', ''));

					genesisMenus[group].push(newString);

					if ('combine' === group) {
						menusToCombine.push(newString);
					}
				});
			} else if ($menu.length == 1) {

				genesisMenus[group].push(menuString);

				if ('combine' === group) {
					menusToCombine.push(menuString);
				}
			}
		});
	});

	// Make sure there is something to use for the 'others' array.
	if (typeof genesisMenus.others == 'undefined') {
		genesisMenus.others = [];
	}

	// If there's only one menu on the page for combining, push it to the 'others' array and nullify our 'combine' variable.
	if (menusToCombine.length == 1) {
		genesisMenus.others.push(menusToCombine[0]);
		genesisMenus.combine = null;
		menusToCombine = null;
	}

	var genesisMenu = {},
	    mainMenuButtonClass = 'menu-toggle',
	    subMenuButtonClass = 'sub-menu-toggle',
	    responsiveMenuClass = 'genesis-responsive-menu';

	// Initialize.
	genesisMenu.init = function () {

		// Exit early if there are no menus to do anything.
		if ($(_getAllMenusArray()).length == 0) {
			return;
		}

		var menuIconClass = typeof genesisMenuParams.menuIconClass !== 'undefined' ? genesisMenuParams.menuIconClass : 'dashicons-before dashicons-menu',
		    subMenuIconClass = typeof genesisMenuParams.subMenuIconClass !== 'undefined' ? genesisMenuParams.subMenuIconClass : 'dashicons-before dashicons-arrow-down-alt2',
		    toggleButtons = {
			menu: $('<button />', {
				'class': mainMenuButtonClass,
				'aria-expanded': false,
				'aria-pressed': false,
				'role': 'button'
			}).append($('<span />', {
				'class': 'screen-reader-text',
				'text': genesisMenuParams.mainMenu
			})),
			submenu: $('<button />', {
				'class': subMenuButtonClass,
				'aria-expanded': false,
				'aria-pressed': false,
				'text': ''
			}).append($('<span />', {
				'class': 'screen-reader-text',
				'text': genesisMenuParams.subMenu
			}))
		};

		// Add the responsive menu class to the active menus.
		_addResponsiveMenuClass();

		// Add the main nav button to the primary menu, or exit the plugin.
		_addMenuButtons(toggleButtons);

		// Setup additional classes.
		$('.' + mainMenuButtonClass).addClass(menuIconClass);
		$('.' + subMenuButtonClass).addClass(subMenuIconClass);
		$('.' + mainMenuButtonClass).on('click.genesisMenu-mainbutton', _mainmenuToggle).each(_addClassID);
		$('.' + subMenuButtonClass).on('click.genesisMenu-subbutton', _submenuToggle);
		$(window).on('resize.genesisMenu', _doResize).triggerHandler('resize.genesisMenu');
	};

	/**
  * Add menu toggle button to appropriate menus.
  * @param {toggleButtons} Object of menu buttons to use for toggles.
  */
	function _addMenuButtons(toggleButtons) {

		// Apply sub menu toggle to each sub-menu found in the menuList.
		$(_getMenuSelectorString(genesisMenus)).find('.sub-menu').before(toggleButtons.submenu);

		if (menusToCombine !== null) {

			var menusToToggle = genesisMenus.others.concat(menusToCombine[0]);

			// Only add menu button the primary menu and navs NOT in the combine variable.
			$(_getMenuSelectorString(menusToToggle)).before(toggleButtons.menu);
		} else {

			// Apply the main menu toggle to all menus in the list.
			$(_getMenuSelectorString(genesisMenus.others)).before(toggleButtons.menu);
		}
	}

	/**
  * Add the responsive menu class.
  */
	function _addResponsiveMenuClass() {
		$(_getMenuSelectorString(genesisMenus)).addClass(responsiveMenuClass);
	}

	/**
  * Execute our responsive menu functions on window resizing.
  */
	function _doResize() {
		var buttons = $('button[id^="genesis-mobile-"]').attr('id');
		if (typeof buttons === 'undefined') {
			return;
		}
		_maybeClose(buttons);
		_superfishToggle(buttons);
		_changeSkipLink(buttons);
		_combineMenus(buttons);
	}

	/**
  * Add the nav- class of the related navigation menu as
  * an ID to associated button (helps target specific buttons outside of context).
  */
	function _addClassID() {
		var $this = $(this),
		    nav = $this.next('nav'),
		    id = 'class';

		$this.attr('id', 'genesis-mobile-' + $(nav).attr(id).match(/nav-\w*\b/));
	}

	/**
  * Combine our menus if the mobile menu is visible.
  * @params buttons
  */
	function _combineMenus(buttons) {

		// Exit early if there are no menus to combine.
		if (menusToCombine == null) {
			return;
		}

		// Split up the menus to combine based on order of appearance in the array.
		var primaryMenu = menusToCombine[0],
		    combinedMenus = $(menusToCombine).filter(function (index) {
			if (index > 0) {
				return index;
			}
		});

		// If the responsive menu is active, append items in 'combinedMenus' object to the 'primaryMenu' object.
		if ('none' !== _getDisplayValue(buttons)) {

			$.each(combinedMenus, function (key, value) {
				$(value).find('.menu > li').addClass('moved-item-' + value.replace('.', '')).appendTo(primaryMenu + ' ul.genesis-nav-menu');
			});
			$(_getMenuSelectorString(combinedMenus)).hide();
		} else {

			$(_getMenuSelectorString(combinedMenus)).show();
			$.each(combinedMenus, function (key, value) {
				$('.moved-item-' + value.replace('.', '')).appendTo(value + ' ul.genesis-nav-menu').removeClass('moved-item-' + value.replace('.', ''));
			});
		}
	}

	/**
  * Action to happen when the main menu button is clicked.
  */
	function _mainmenuToggle() {
		var $this = $(this);
		_toggleAria($this, 'aria-pressed');
		_toggleAria($this, 'aria-expanded');
		$this.toggleClass('activated');
		$this.next('nav').slideToggle('fast');
	}

	/**
  * Action for submenu toggles.
  */
	function _submenuToggle() {

		var $this = $(this),
		    others = $this.closest('.menu-item').siblings();
		_toggleAria($this, 'aria-pressed');
		_toggleAria($this, 'aria-expanded');
		$this.toggleClass('activated');
		$this.next('.sub-menu').slideToggle('fast');

		others.find('.' + subMenuButtonClass).removeClass('activated').attr('aria-pressed', 'false');
		others.find('.sub-menu').slideUp('fast');
	}

	/**
  * Activate/deactivate superfish.
  * @params buttons
  */
	function _superfishToggle(buttons) {
		var _superfish = $('.' + responsiveMenuClass + ' .js-superfish'),
		    $args = 'destroy';
		if (typeof _superfish.superfish !== 'function') {
			return;
		}
		if ('none' === _getDisplayValue(buttons)) {
			$args = {
				'delay': 0,
				'animation': { 'opacity': 'show' },
				'speed': 300,
				'disableHI': true
			};
		}
		_superfish.superfish($args);
	}

	/**
  * Modify skip link to match mobile buttons.
  * @param buttons
  */
	function _changeSkipLink(buttons) {

		// Start with an empty array.
		var menuToggleList = _getAllMenusArray();

		// Exit out if there are no menu items to update.
		if (!$(menuToggleList).length > 0) {
			return;
		}

		$.each(menuToggleList, function (key, value) {

			var newValue = value.replace('.', ''),
			    startLink = 'genesis-' + newValue,
			    endLink = 'genesis-mobile-' + newValue;

			if ('none' == _getDisplayValue(buttons)) {
				startLink = 'genesis-mobile-' + newValue;
				endLink = 'genesis-' + newValue;
			}

			var $item = $('.genesis-skip-link a[href="#' + startLink + '"]');

			if (menusToCombine !== null && value !== menusToCombine[0]) {
				$item.toggleClass('skip-link-hidden');
			}

			if ($item.length > 0) {
				var link = $item.attr('href');
				link = link.replace(startLink, endLink);

				$item.attr('href', link);
			} else {
				return;
			}
		});
	}

	/**
  * Close all the menu toggles if buttons are hidden.
  * @param buttons
  */
	function _maybeClose(buttons) {
		if ('none' !== _getDisplayValue(buttons)) {
			return true;
		}

		$('.' + mainMenuButtonClass + ', .' + responsiveMenuClass + ' .sub-menu-toggle').removeClass('activated').attr('aria-expanded', false).attr('aria-pressed', false);

		$('.' + responsiveMenuClass + ', .' + responsiveMenuClass + ' .sub-menu').attr('style', '');
	}

	/**
  * Generic function to get the display value of an element.
  * @param  {id} $id ID to check
  * @return {string}     CSS value of display property
  */
	function _getDisplayValue($id) {
		var element = document.getElementById($id),
		    style = window.getComputedStyle(element);
		return style.getPropertyValue('display');
	}

	/**
  * Toggle aria attributes.
  * @param  {button} $this     passed through
  * @param  {aria-xx} attribute aria attribute to toggle
  * @return {bool}           from _ariaReturn
  */
	function _toggleAria($this, attribute) {
		$this.attr(attribute, function (index, value) {
			return 'false' === value;
		});
	}

	/**
  * Helper function to return a comma separated string of menu selectors.
  * @param {itemArray} Array of menu items to loop through.
  * @param {ignoreSecondary} boolean of whether to ignore the 'secondary' menu item.
  * @return {string} Comma-separated string.
  */
	function _getMenuSelectorString(itemArray) {

		var itemString = $.map(itemArray, function (value, key) {
			return value;
		});

		return itemString.join(',');
	}

	/**
  * Helper function to return a group array of all the menus in
  * both the 'others' and 'combine' arrays.
  * @return {array} Array of all menu items as class selectors.
  */
	function _getAllMenusArray() {

		// Start with an empty array.
		var menuList = [];

		// If there are menus in the 'menusToCombine' array, add them to 'menuList'.
		if (menusToCombine !== null) {

			$.each(menusToCombine, function (key, value) {
				menuList.push(value.valueOf());
			});
		}

		// Add menus in the 'others' array to 'menuList'.
		$.each(genesisMenus.others, function (key, value) {
			menuList.push(value.valueOf());
		});

		if (menuList.length > 0) {
			return menuList;
		} else {
			return null;
		}
	}

	$(document).ready(function () {

		if (_getAllMenusArray() !== null) {

			genesisMenu.init();
		}
	});
})(document, jQuery);
"use strict";

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/*!
 * jQuery Smooth Scroll - v2.1.2 - 2017-01-19
 * https://github.com/kswedberg/jquery-smooth-scroll
 * Copyright (c) 2017 Karl Swedberg
 * Licensed MIT
 */

!function (a) {
  "function" == typeof define && define.amd ? define(["jquery"], a) : a("object" == (typeof module === "undefined" ? "undefined" : _typeof(module)) && module.exports ? require("jquery") : jQuery);
}(function (a) {
  var b = "2.1.2",
      c = {},
      d = { exclude: [], excludeWithin: [], offset: 0, direction: "top", delegateSelector: null, scrollElement: null, scrollTarget: null, beforeScroll: function beforeScroll() {}, afterScroll: function afterScroll() {}, easing: "swing", speed: 400, autoCoefficient: 2, preventDefault: !0 },
      e = function e(b) {
    var c = [],
        d = !1,
        e = b.dir && "left" === b.dir ? "scrollLeft" : "scrollTop";return this.each(function () {
      var b = a(this);if (this !== document && this !== window) return !document.scrollingElement || this !== document.documentElement && this !== document.body ? void (b[e]() > 0 ? c.push(this) : (b[e](1), d = b[e]() > 0, d && c.push(this), b[e](0))) : (c.push(document.scrollingElement), !1);
    }), c.length || this.each(function () {
      this === document.documentElement && "smooth" === a(this).css("scrollBehavior") && (c = [this]), c.length || "BODY" !== this.nodeName || (c = [this]);
    }), "first" === b.el && c.length > 1 && (c = [c[0]]), c;
  },
      f = /^([\-\+]=)(\d+)/;a.fn.extend({ scrollable: function scrollable(a) {
      var b = e.call(this, { dir: a });return this.pushStack(b);
    }, firstScrollable: function firstScrollable(a) {
      var b = e.call(this, { el: "first", dir: a });return this.pushStack(b);
    }, smoothScroll: function smoothScroll(b, c) {
      if (b = b || {}, "options" === b) return c ? this.each(function () {
        var b = a(this),
            d = a.extend(b.data("ssOpts") || {}, c);a(this).data("ssOpts", d);
      }) : this.first().data("ssOpts");var d = a.extend({}, a.fn.smoothScroll.defaults, b),
          e = function e(b) {
        var c = function c(a) {
          return a.replace(/(:|\.|\/)/g, "\\$1");
        },
            e = this,
            f = a(this),
            g = a.extend({}, d, f.data("ssOpts") || {}),
            h = d.exclude,
            i = g.excludeWithin,
            j = 0,
            k = 0,
            l = !0,
            m = {},
            n = a.smoothScroll.filterPath(location.pathname),
            o = a.smoothScroll.filterPath(e.pathname),
            p = location.hostname === e.hostname || !e.hostname,
            q = g.scrollTarget || o === n,
            r = c(e.hash);if (r && !a(r).length && (l = !1), g.scrollTarget || p && q && r) {
          for (; l && j < h.length;) {
            f.is(c(h[j++])) && (l = !1);
          }for (; l && k < i.length;) {
            f.closest(i[k++]).length && (l = !1);
          }
        } else l = !1;l && (g.preventDefault && b.preventDefault(), a.extend(m, g, { scrollTarget: g.scrollTarget || r, link: e }), a.smoothScroll(m));
      };return null !== b.delegateSelector ? this.off("click.smoothscroll", b.delegateSelector).on("click.smoothscroll", b.delegateSelector, e) : this.off("click.smoothscroll").on("click.smoothscroll", e), this;
    } });var g = function g(a) {
    var b = { relative: "" },
        c = "string" == typeof a && f.exec(a);return "number" == typeof a ? b.px = a : c && (b.relative = c[1], b.px = parseFloat(c[2]) || 0), b;
  };a.smoothScroll = function (b, d) {
    if ("options" === b && "object" == (typeof d === "undefined" ? "undefined" : _typeof(d))) return a.extend(c, d);var e,
        f,
        h,
        i,
        j = g(b),
        k = {},
        l = 0,
        m = "offset",
        n = "scrollTop",
        o = {},
        p = {};j.px ? e = a.extend({ link: null }, a.fn.smoothScroll.defaults, c) : (e = a.extend({ link: null }, a.fn.smoothScroll.defaults, b || {}, c), e.scrollElement && (m = "position", "static" === e.scrollElement.css("position") && e.scrollElement.css("position", "relative")), d && (j = g(d))), n = "left" === e.direction ? "scrollLeft" : n, e.scrollElement ? (f = e.scrollElement, j.px || /^(?:HTML|BODY)$/.test(f[0].nodeName) || (l = f[n]())) : f = a("html, body").firstScrollable(e.direction), e.beforeScroll.call(f, e), k = j.px ? j : { relative: "", px: a(e.scrollTarget)[m]() && a(e.scrollTarget)[m]()[e.direction] || 0 }, o[n] = k.relative + (k.px + l + e.offset), h = e.speed, "auto" === h && (i = Math.abs(o[n] - f[n]()), h = i / e.autoCoefficient), p = { duration: h, easing: e.easing, complete: function complete() {
        e.afterScroll.call(e.link, e);
      } }, e.step && (p.step = e.step), f.length ? f.stop().animate(o, p) : e.afterScroll.call(e.link, e);
  }, a.smoothScroll.version = b, a.smoothScroll.filterPath = function (a) {
    return a = a || "", a.replace(/^\//, "").replace(/(?:index|default).[a-zA-Z]{3,4}$/, "").replace(/\/$/, "");
  }, a.fn.smoothScroll.defaults = d;
});
"use strict";

var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/*! modernizr 3.5.0 (Custom Build) | MIT *
 * https://modernizr.com/download/?-dataset-flexbox-flexboxlegacy-touchevents-setclasses !*/
!function (e, t, n) {
  function r(e, t) {
    return (typeof e === "undefined" ? "undefined" : _typeof(e)) === t;
  }function o() {
    var e, t, n, o, s, i, a;for (var l in x) {
      if (x.hasOwnProperty(l)) {
        if (e = [], t = x[l], t.name && (e.push(t.name.toLowerCase()), t.options && t.options.aliases && t.options.aliases.length)) for (n = 0; n < t.options.aliases.length; n++) {
          e.push(t.options.aliases[n].toLowerCase());
        }for (o = r(t.fn, "function") ? t.fn() : t.fn, s = 0; s < e.length; s++) {
          i = e[s], a = i.split("."), 1 === a.length ? Modernizr[a[0]] = o : (!Modernizr[a[0]] || Modernizr[a[0]] instanceof Boolean || (Modernizr[a[0]] = new Boolean(Modernizr[a[0]])), Modernizr[a[0]][a[1]] = o), C.push((o ? "" : "no-") + a.join("-"));
        }
      }
    }
  }function s(e) {
    var t = S.className,
        n = Modernizr._config.classPrefix || "";if (w && (t = t.baseVal), Modernizr._config.enableJSClass) {
      var r = new RegExp("(^|\\s)" + n + "no-js(\\s|$)");t = t.replace(r, "$1" + n + "js$2");
    }Modernizr._config.enableClasses && (t += " " + n + e.join(" " + n), w ? S.className.baseVal = t : S.className = t);
  }function i() {
    return "function" != typeof t.createElement ? t.createElement(arguments[0]) : w ? t.createElementNS.call(t, "http://www.w3.org/2000/svg", arguments[0]) : t.createElement.apply(t, arguments);
  }function a(e, t) {
    return !!~("" + e).indexOf(t);
  }function l(e) {
    return e.replace(/([a-z])-([a-z])/g, function (e, t, n) {
      return t + n.toUpperCase();
    }).replace(/^-/, "");
  }function u(e, t) {
    return function () {
      return e.apply(t, arguments);
    };
  }function f(e, t, n) {
    var o;for (var s in e) {
      if (e[s] in t) return n === !1 ? e[s] : (o = t[e[s]], r(o, "function") ? u(o, n || t) : o);
    }return !1;
  }function c(e) {
    return e.replace(/([A-Z])/g, function (e, t) {
      return "-" + t.toLowerCase();
    }).replace(/^ms-/, "-ms-");
  }function d(t, n, r) {
    var o;if ("getComputedStyle" in e) {
      o = getComputedStyle.call(e, t, n);var s = e.console;if (null !== o) r && (o = o.getPropertyValue(r));else if (s) {
        var i = s.error ? "error" : "log";s[i].call(s, "getComputedStyle returning null, its possible modernizr test results are inaccurate");
      }
    } else o = !n && t.currentStyle && t.currentStyle[r];return o;
  }function p() {
    var e = t.body;return e || (e = i(w ? "svg" : "body"), e.fake = !0), e;
  }function m(e, n, r, o) {
    var s,
        a,
        l,
        u,
        f = "modernizr",
        c = i("div"),
        d = p();if (parseInt(r, 10)) for (; r--;) {
      l = i("div"), l.id = o ? o[r] : f + (r + 1), c.appendChild(l);
    }return s = i("style"), s.type = "text/css", s.id = "s" + f, (d.fake ? d : c).appendChild(s), d.appendChild(c), s.styleSheet ? s.styleSheet.cssText = e : s.appendChild(t.createTextNode(e)), c.id = f, d.fake && (d.style.background = "", d.style.overflow = "hidden", u = S.style.overflow, S.style.overflow = "hidden", S.appendChild(d)), a = n(c, e), d.fake ? (d.parentNode.removeChild(d), S.style.overflow = u, S.offsetHeight) : c.parentNode.removeChild(c), !!a;
  }function v(t, r) {
    var o = t.length;if ("CSS" in e && "supports" in e.CSS) {
      for (; o--;) {
        if (e.CSS.supports(c(t[o]), r)) return !0;
      }return !1;
    }if ("CSSSupportsRule" in e) {
      for (var s = []; o--;) {
        s.push("(" + c(t[o]) + ":" + r + ")");
      }return s = s.join(" or "), m("@supports (" + s + ") { #modernizr { position: absolute; } }", function (e) {
        return "absolute" == d(e, null, "position");
      });
    }return n;
  }function h(e, t, o, s) {
    function u() {
      c && (delete j.style, delete j.modElem);
    }if (s = r(s, "undefined") ? !1 : s, !r(o, "undefined")) {
      var f = v(e, o);if (!r(f, "undefined")) return f;
    }for (var c, d, p, m, h, y = ["modernizr", "tspan", "samp"]; !j.style && y.length;) {
      c = !0, j.modElem = i(y.shift()), j.style = j.modElem.style;
    }for (p = e.length, d = 0; p > d; d++) {
      if (m = e[d], h = j.style[m], a(m, "-") && (m = l(m)), j.style[m] !== n) {
        if (s || r(o, "undefined")) return u(), "pfx" == t ? m : !0;try {
          j.style[m] = o;
        } catch (g) {}if (j.style[m] != h) return u(), "pfx" == t ? m : !0;
      }
    }return u(), !1;
  }function y(e, t, n, o, s) {
    var i = e.charAt(0).toUpperCase() + e.slice(1),
        a = (e + " " + z.join(i + " ") + i).split(" ");return r(t, "string") || r(t, "undefined") ? h(a, t, o, s) : (a = (e + " " + P.join(i + " ") + i).split(" "), f(a, t, n));
  }function g(e, t, r) {
    return y(e, n, n, t, r);
  }var C = [],
      x = [],
      b = { _version: "3.5.0", _config: { classPrefix: "", enableClasses: !0, enableJSClass: !0, usePrefixes: !0 }, _q: [], on: function on(e, t) {
      var n = this;setTimeout(function () {
        t(n[e]);
      }, 0);
    }, addTest: function addTest(e, t, n) {
      x.push({ name: e, fn: t, options: n });
    }, addAsyncTest: function addAsyncTest(e) {
      x.push({ name: null, fn: e });
    } },
      Modernizr = function Modernizr() {};Modernizr.prototype = b, Modernizr = new Modernizr();var S = t.documentElement,
      w = "svg" === S.nodeName.toLowerCase();Modernizr.addTest("dataset", function () {
    var e = i("div");return e.setAttribute("data-a-b", "c"), !(!e.dataset || "c" !== e.dataset.aB);
  });var _ = b._config.usePrefixes ? " -webkit- -moz- -o- -ms- ".split(" ") : ["", ""];b._prefixes = _;var T = "Moz O ms Webkit",
      z = b._config.usePrefixes ? T.split(" ") : [];b._cssomPrefixes = z;var P = b._config.usePrefixes ? T.toLowerCase().split(" ") : [];b._domPrefixes = P;var E = { elem: i("modernizr") };Modernizr._q.push(function () {
    delete E.elem;
  });var j = { style: E.elem.style };Modernizr._q.unshift(function () {
    delete j.style;
  });var N = b.testStyles = m;Modernizr.addTest("touchevents", function () {
    var n;if ("ontouchstart" in e || e.DocumentTouch && t instanceof DocumentTouch) n = !0;else {
      var r = ["@media (", _.join("touch-enabled),("), "heartz", ")", "{#modernizr{top:9px;position:absolute}}"].join("");N(r, function (e) {
        n = 9 === e.offsetTop;
      });
    }return n;
  }), b.testAllProps = y, b.testAllProps = g, Modernizr.addTest("flexbox", g("flexBasis", "1px", !0)), Modernizr.addTest("flexboxlegacy", g("boxDirection", "reverse", !0)), o(), s(C), delete b.addTest, delete b.addAsyncTest;for (var k = 0; k < Modernizr._q.length; k++) {
    Modernizr._q[k]();
  }e.Modernizr = Modernizr;
}(window, document);
'use strict';

(function (document, window, $) {

	'use strict';

	// Open external links in new window (exclue scv image maps, email, tel and foobox)

	$('a').not('svg a, [href*="mailto:"], [href*="tel:"], [class*="foobox"]').each(function () {
		var isInternalLink = new RegExp('/' + window.location.host + '/');
		if (!isInternalLink.test(this.href)) {
			$(this).attr('target', '_blank');
		}
	});
})(document, window, jQuery);
'use strict';

(function (document, window, $) {

	'use strict';

	// Scroll up show header

	var $site_header = $('.site-header');

	// clone header
	var $sticky = $site_header.clone().prop('id', 'masthead-fixed').attr('aria-hidden', 'true').addClass('fixed').insertBefore('#masthead');

	var header_height = $site_header.height();
	var lastScrollTop = 0;
	var wait = 25; // distance in pixels to wait before showing

	$(window).scroll(function () {

		var scroll = $(window).scrollTop();

		if (scroll < 400) {
			$sticky.removeClass("show");
			return;
		}

		var st = $(this).scrollTop();

		console.log('st: ' + st);
		console.log('lastScrollTop: ' + lastScrollTop);

		if (st > lastScrollTop) {
			// downscroll code
			$sticky.removeClass("show");
		} else {
			// upscroll code

			if (lastScrollTop - st >= wait) {
				$sticky.addClass("show");
			}
		}
		lastScrollTop = st;
	});
})(document, window, jQuery);
'use strict';

(function (document, window, $) {

   'use strict';

   // Load Foundation

   $(document).foundation();
})(document, window, jQuery);
'use strict';

(function (document, window, $) {

	'use strict';

	// Replace all SVG images with inline SVG (use as needed so you can set hover fills)

	$('img.svg').each(function () {
		var $img = jQuery(this);
		var imgID = $img.attr('id');
		var imgClass = $img.attr('class');
		var imgURL = $img.attr('src');

		$.get(imgURL, function (data) {
			// Get the SVG tag, ignore the rest
			var $svg = jQuery(data).find('svg');

			// Add replaced image's ID to the new SVG
			if (typeof imgID !== 'undefined') {
				$svg = $svg.attr('id', imgID);
			}
			// Add replaced image's classes to the new SVG
			if (typeof imgClass !== 'undefined') {
				$svg = $svg.attr('class', imgClass + ' replaced-svg');
			}

			// Remove any invalid XML tags as per http://validator.w3.org
			$svg = $svg.removeAttr('xmlns:a');

			// Replace image with new SVG
			$img.replaceWith($svg);
		}, 'xml');
	});
})(document, window, jQuery);
'use strict';

(function (document, window, $) {

	'use strict';

	// Responsive video embeds

	var $all_oembed_videos = $("iframe[src*='youtube'], iframe[src*='vimeo']");

	$all_oembed_videos.each(function () {

		var _this = $(this);

		if (_this.parent('.embed-container').length === 0) {
			_this.wrap('<div class="embed-container"></div>');
		}

		_this.removeAttr('height').removeAttr('width');
	});
})(document, window, jQuery);
//# sourceMappingURL=project.js.map
