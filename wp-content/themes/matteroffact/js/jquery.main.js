;(function(root, factory) {
	'use strict';
	if (typeof define === 'function' && define.amd) {
		define(['jquery'], factory);
	} else if (typeof exports === 'object') {
		module.exports = factory(require('jquery'));
	} else {
		root.Factory = factory(jQuery);
	}
}(this, function($) {
	'use strict';
	var BurgerMenu = function(element, options) {
		this.options = $.extend({}, BurgerMenu.DEFAULTS, options);
		this.element = $(element);
		this.targetID = this.element.prop('id');

		this.element.data('BurgerMenu', this);

		if (this.options.show) {
			this.show(true);
		}
	};

	BurgerMenu.DEFAULTS = {
		openPrefix: 'open-',
		animatingClass: 'animating-burger-menu',
		outsideClick: false,
		duration: 300
	};

	BurgerMenu.prototype.toggle = function() {
		if ($html.hasClass(this.options.openPrefix + this.targetID)) {
			this.hide();
		} else {
			this.show();
		}
	};

	BurgerMenu.prototype.show = function(fast) {
		var self = this;
		self.element.trigger('burgerMenu.beforeShow');
		clearTimeout(self.timerHide);
		self.timerShow = setTimeout(function() {
			if (self.options.outsideClick) {
				self._outsideClickHandler = function(e) {
					var target = $(e.target);
					if (!target.closest(self.element).length && !target.closest('[data-burger-menu-id="' + self.targetID + '"]').length) {
						self.hide();
					}
				};
				$html.on('click touchstart pointerdown MSPointerDown', self._outsideClickHandler);
			}
			$html.removeClass(self.options.animatingClass);
			self.element.trigger('burgerMenu.afterShow');
		}, (!fast && getTransitionEndEvent()) ? self.options.duration : 0);
		if (!fast) {
			$html.addClass(this.options.animatingClass);
		}
		$html.addClass(this.options.openPrefix + this.targetID);
	};

	BurgerMenu.prototype.hide = function(fast) {
		var self = this;
		self.element.trigger('burgerMenu.beforeHide');
		clearTimeout(self.timerShow);
		if (self._outsideClickHandler) {
			$html.off('click touchstart pointerdown MSPointerDown', self._outsideClickHandler);
		}
		self.timerHide = setTimeout(function() {
			$html.removeClass(self.options.animatingClass);
			self.element.trigger('burgerMenu.afterHide');
		}, (!fast && getTransitionEndEvent()) ? self.options.duration : 0);
		if (!fast) {
			$html.addClass(self.options.animatingClass);
		}
		$html.removeClass(self.options.openPrefix + self.targetID);
	};

	var $html = $(document.documentElement);
	var $win = $(window);

	var activateResizeHandler = function() {
		var resizeClass = 'resize-active',
			flag, timer;
		var removeClassHandler = function() {
			flag = false;
			$html.removeClass(resizeClass);
		};
		var resizeHandler = function() {
			if (!flag) {
				flag = true;
				$html.addClass(resizeClass);
			}
			clearTimeout(timer);
			timer = setTimeout(removeClassHandler, 500);
		};
		$win.on('resize orientationchange', resizeHandler);
	};

	var getTransitionEndEvent = (function() {
		var eventName;

		function detectEvent() {
			var transEndEventNames = {
				WebkitTransition: 'webkitTransitionEnd',
				MozTransition: 'transitionend',
				OTransition: 'oTransitionEnd otransitionend',
				transition: 'transitionend'
			};
			for (var name in transEndEventNames) {
				if (document.documentElement.style[name] !== undefined) {
					return transEndEventNames[name];
				}
			}
			return null;
		}

		return function() {
			eventName = eventName === undefined ? detectEvent() : eventName;
			return eventName;
		};
	}());

	var extendOptions = function(target, object, prefixKey) {
		var optionKey;
		for (var key in object) {
			if (object.hasOwnProperty(key) && key.indexOf(prefixKey) === 0 && prefixKey.length < key.length && typeof object[key] !== 'undefined') {
				optionKey = key.replace(prefixKey, '');
				optionKey = optionKey.slice(0, 1).toLowerCase() + optionKey.slice(1);
				target[optionKey] = object[key];
			}
		}
	};

	var Plugin = function(option) {
		if (activateResizeHandler) {
			activateResizeHandler();
			activateResizeHandler = null;
		}
		return this.each(function() {
			var $target = $(this);
			var data = $target.data('BurgerMenu');

			if (!data) {
				var options = $.extend({}, BurgerMenu.DEFAULTS);
				extendOptions(options, $target.data(), 'burgerMenu');
				if (typeof option === 'object' && option) {
					$.extend(options, option);
				}
				data = new BurgerMenu($target, options);
			}

			if (typeof option === 'string') {
				data[option]();
			}
		});
	};

	$.fn.burgerMenu = Plugin;

	$(document).on('click.BurgerMenu', '[data-burger-menu-id]', function(e) {
		e.preventDefault();
		var $button = $(this);
		var $target = $('#' + $button.data('burgerMenuId'));

		if (!$target.data('BurgerMenu')) {
			var option = {};
			extendOptions(option, $target.data(), 'burgerMenu');
			extendOptions(option, $button.data(), 'burgerMenu');
			Plugin.call($target, option);
		}
		Plugin.call($target, 'toggle');
	});

	return BurgerMenu;
}));
