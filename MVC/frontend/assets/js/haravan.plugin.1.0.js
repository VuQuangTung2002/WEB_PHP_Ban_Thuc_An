/*!
 * iCheck v1.0.2, http://git.io/arlzeA
 * ===================================
 * Powerful jQuery and Zepto plugin for checkboxes and radio buttons customization
 *
 * (c) 2013 Damir Sultanov, http://fronteed.com
 * MIT Licensed
 */

(function ($) {

    // Cached vars
    var _iCheck = 'iCheck',
        _iCheckHelper = _iCheck + '-helper',
        _checkbox = 'checkbox',
        _radio = 'radio',
        _checked = 'checked',
        _unchecked = 'un' + _checked,
        _disabled = 'disabled',
        _determinate = 'determinate',
        _indeterminate = 'in' + _determinate,
        _update = 'update',
        _type = 'type',
        _click = 'click',
        _touch = 'touchbegin.i touchend.i',
        _add = 'addClass',
        _remove = 'removeClass',
        _callback = 'trigger',
        _label = 'label',
        _cursor = 'cursor',
        _mobile = /ipad|iphone|ipod|android|blackberry|windows phone|opera mini|silk/i.test(navigator.userAgent);

    // Plugin init
    $.fn[_iCheck] = function (options, fire) {

        // Walker
        var handle = 'input[type="' + _checkbox + '"], input[type="' + _radio + '"]',
            stack = $(),
            walker = function (object) {
                object.each(function () {
                    var self = $(this);

                    if (self.is(handle)) {
                        stack = stack.add(self);
                    } else {
                        stack = stack.add(self.find(handle));
                    }
                });
            };

        // Check if we should operate with some method
        if (/^(check|uncheck|toggle|indeterminate|determinate|disable|enable|update|destroy)$/i.test(options)) {

            // Normalize method's name
            options = options.toLowerCase();

            // Find checkboxes and radio buttons
            walker(this);

            return stack.each(function () {
                var self = $(this);

                if (options == 'destroy') {
                    tidy(self, 'ifDestroyed');
                } else {
                    operate(self, true, options);
                }

                // Fire method's callback
                if ($.isFunction(fire)) {
                    fire();
                }
            });

            // Customization
        } else if (typeof options == 'object' || !options) {

            // Check if any options were passed
            var settings = $.extend({
                checkedClass: _checked,
                disabledClass: _disabled,
                indeterminateClass: _indeterminate,
                labelHover: true
            }, options),

                selector = settings.handle,
                hoverClass = settings.hoverClass || 'hover',
                focusClass = settings.focusClass || 'focus',
                activeClass = settings.activeClass || 'active',
                labelHover = !!settings.labelHover,
                labelHoverClass = settings.labelHoverClass || 'hover',

                // Setup clickable area
                area = ('' + settings.increaseArea).replace('%', '') | 0;

            // Selector limit
            if (selector == _checkbox || selector == _radio) {
                handle = 'input[type="' + selector + '"]';
            }

            // Clickable area limit
            if (area < -50) {
                area = -50;
            }

            // Walk around the selector
            walker(this);

            return stack.each(function () {
                var self = $(this);

                // If already customized
                tidy(self);

                var node = this,
                    id = node.id,

                    // Layer styles
                    offset = -area + '%',
                    size = 100 + (area * 2) + '%',
                    layer = {
                        position: 'absolute',
                        top: offset,
                        left: offset,
                        display: 'block',
                        width: size,
                        height: size,
                        margin: 0,
                        padding: 0,
                        background: '#fff',
                        border: 0,
                        opacity: 0
                    },

                    // Choose how to hide input
                    hide = _mobile ? {
                        position: 'absolute',
                        visibility: 'hidden'
                    } : area ? layer : {
                        position: 'absolute',
                        opacity: 0
                    },

                    // Get proper class
                    className = node[_type] == _checkbox ? settings.checkboxClass || 'i' + _checkbox : settings.radioClass || 'i' + _radio,

                    // Find assigned labels
                    label = $(_label + '[for="' + id + '"]').add(self.closest(_label)),

                    // Check ARIA option
                    aria = !!settings.aria,

                    // Set ARIA placeholder
                    ariaID = _iCheck + '-' + Math.random().toString(36).substr(2, 6),

                    // Parent & helper
                    parent = '<div class="' + className + '" ' + (aria ? 'role="' + node[_type] + '" ' : ''),
                    helper;

                // Set ARIA "labelledby"
                if (aria) {
                    label.each(function () {
                        parent += 'aria-labelledby="';

                        if (this.id) {
                            parent += this.id;
                        } else {
                            this.id = ariaID;
                            parent += ariaID;
                        }

                        parent += '"';
                    });
                }

                // Wrap input
                parent = self.wrap(parent + '/>')[_callback]('ifCreated').parent().append(settings.insert);

                // Layer addition
                helper = $('<ins class="' + _iCheckHelper + '"/>').css(layer).appendTo(parent);

                // Finalize customization
                self.data(_iCheck, {
                    o: settings,
                    s: self.attr('style')
                }).css(hide); !!settings.inheritClass && parent[_add](node.className || ''); !!settings.inheritID && id && parent.attr('id', _iCheck + '-' + id);
                parent.css('position') == 'static' && parent.css('position', 'relative');
                operate(self, true, _update);

                // Label events
                if (label.length) {
                    label.on(_click + '.i mouseover.i mouseout.i ' + _touch, function (event) {
                        var type = event[_type],
                            item = $(this);

                        // Do nothing if input is disabled
                        if (!node[_disabled]) {

                            // Click
                            if (type == _click) {
                                if ($(event.target).is('a')) {
                                    return;
                                }
                                operate(self, false, true);

                                // Hover state
                            } else if (labelHover) {

                                // mouseout|touchend
                                if (/ut|nd/.test(type)) {
                                    parent[_remove](hoverClass);
                                    item[_remove](labelHoverClass);
                                } else {
                                    parent[_add](hoverClass);
                                    item[_add](labelHoverClass);
                                }
                            }
                            debugger
                            if (_mobile) {
                                event.stopPropagation();
                            } else {
                                return false;
                            }
                        }
                    });
                }

                // Input events
                self.on(_click + '.i focus.i blur.i keyup.i keydown.i keypress.i', function (event) {
                    var type = event[_type],
                        key = event.keyCode;

                    // Click
                    if (type == _click) {
                        return false;

                        // Keydown
                    } else if (type == 'keydown' && key == 32) {
                        if (!(node[_type] == _radio && node[_checked])) {
                            if (node[_checked]) {
                                off(self, _checked);
                            } else {
                                on(self, _checked);
                            }
                        }

                        return false;

                        // Keyup
                    } else if (type == 'keyup' && node[_type] == _radio) {
                        !node[_checked] && on(self, _checked);

                        // Focus/blur
                    } else if (/us|ur/.test(type)) {
                        parent[type == 'blur' ? _remove : _add](focusClass);
                    }
                });

                // Helper events
                helper.on(_click + ' mousedown mouseup mouseover mouseout ' + _touch, function (event) {
                    var type = event[_type],

                        // mousedown|mouseup
                        toggle = /wn|up/.test(type) ? activeClass : hoverClass;

                    // Do nothing if input is disabled
                    if (!node[_disabled]) {

                        // Click
                        if (type == _click) {
                            operate(self, false, true);

                            // Active and hover states
                        } else {

                            // State is on
                            if (/wn|er|in/.test(type)) {

                                // mousedown|mouseover|touchbegin
                                parent[_add](toggle);

                                // State is off
                            } else {
                                parent[_remove](toggle + ' ' + activeClass);
                            }

                            // Label hover
                            if (label.length && labelHover && toggle == hoverClass) {

                                // mouseout|touchend
                                label[/ut|nd/.test(type) ? _remove : _add](labelHoverClass);
                            }
                        }

                        if (_mobile) {
                            event.stopPropagation();
                        } else {
                            return false;
                        }
                    }
                });
            });
        } else {
            return this;
        }
    };

    // Do something with inputs
    function operate(input, direct, method) {
        var node = input[0],
            state = /er/.test(method) ? _indeterminate : /bl/.test(method) ? _disabled : _checked,
            active = method == _update ? {
                checked: node[_checked],
                disabled: node[_disabled],
                indeterminate: input.attr(_indeterminate) == 'true' || input.attr(_determinate) == 'false'
            } : node[state];

        // Check, disable or indeterminate
        if (/^(ch|di|in)/.test(method) && !active) {
            on(input, state);

            // Uncheck, enable or determinate
        } else if (/^(un|en|de)/.test(method) && active) {
            off(input, state);

            // Update
        } else if (method == _update) {

            // Handle states
            for (var each in active) {
                if (active[each]) {
                    on(input, each, true);
                } else {
                    off(input, each, true);
                }
            }

        } else if (!direct || method == 'toggle') {

            // Helper or label was clicked
            if (!direct) {
                input[_callback]('ifClicked');
            }

            // Toggle checked state
            if (active) {
                if (node[_type] !== _radio) {
                    off(input, state);
                }
            } else {
                on(input, state);
            }
        }
    }

    // Add checked, disabled or indeterminate state
    function on(input, state, keep) {
        var node = input[0],
            parent = input.parent(),
            checked = state == _checked,
            indeterminate = state == _indeterminate,
            disabled = state == _disabled,
            callback = indeterminate ? _determinate : checked ? _unchecked : 'enabled',
            regular = option(input, callback + capitalize(node[_type])),
            specific = option(input, state + capitalize(node[_type]));

        // Prevent unnecessary actions
        if (node[state] !== true) {

            // Toggle assigned radio buttons
            if (!keep && state == _checked && node[_type] == _radio && node.name) {
                var form = input.closest('form'),
                    inputs = 'input[name="' + node.name + '"]';

                inputs = form.length ? form.find(inputs) : $(inputs);

                inputs.each(function () {
                    if (this !== node && $(this).data(_iCheck)) {
                        off($(this), state);
                    }
                });
            }

            // Indeterminate state
            if (indeterminate) {

                // Add indeterminate state
                node[state] = true;

                // Remove checked state
                if (node[_checked]) {
                    off(input, _checked, 'force');
                }

                // Checked or disabled state
            } else {

                // Add checked or disabled state
                if (!keep) {
                    node[state] = true;
                }

                // Remove indeterminate state
                if (checked && node[_indeterminate]) {
                    off(input, _indeterminate, false);
                }
            }

            // Trigger callbacks
            callbacks(input, checked, state, keep);
        }

        // Add proper cursor
        if (node[_disabled] && !!option(input, _cursor, true)) {
            parent.find('.' + _iCheckHelper).css(_cursor, 'default');
        }

        // Add state class
        parent[_add](specific || option(input, state) || '');

        // Set ARIA attribute
        if (!!parent.attr('role') && !indeterminate) {
            parent.attr('aria-' + (disabled ? _disabled : _checked), 'true');
        }

        // Remove regular state class
        parent[_remove](regular || option(input, callback) || '');
    }

    // Remove checked, disabled or indeterminate state
    function off(input, state, keep) {
        var node = input[0],
            parent = input.parent(),
            checked = state == _checked,
            indeterminate = state == _indeterminate,
            disabled = state == _disabled,
            callback = indeterminate ? _determinate : checked ? _unchecked : 'enabled',
            regular = option(input, callback + capitalize(node[_type])),
            specific = option(input, state + capitalize(node[_type]));

        // Prevent unnecessary actions
        if (node[state] !== false) {

            // Toggle state
            if (indeterminate || !keep || keep == 'force') {
                node[state] = false;
            }

            // Trigger callbacks
            callbacks(input, checked, callback, keep);
        }

        // Add proper cursor
        if (!node[_disabled] && !!option(input, _cursor, true)) {
            parent.find('.' + _iCheckHelper).css(_cursor, 'pointer');
        }

        // Remove state class
        parent[_remove](specific || option(input, state) || '');

        // Set ARIA attribute
        if (!!parent.attr('role') && !indeterminate) {
            parent.attr('aria-' + (disabled ? _disabled : _checked), 'false');
        }

        // Add regular state class
        parent[_add](regular || option(input, callback) || '');
    }

    // Remove all traces
    function tidy(input, callback) {
        if (input.data(_iCheck)) {

            // Remove everything except input
            input.parent().html(input.attr('style', input.data(_iCheck).s || ''));

            // Callback
            if (callback) {
                input[_callback](callback);
            }

            // Unbind events
            input.off('.i').unwrap();
            $(_label + '[for="' + input[0].id + '"]').add(input.closest(_label)).off('.i');
        }
    }

    // Get some option
    function option(input, state, regular) {
        if (input.data(_iCheck)) {
            return input.data(_iCheck).o[state + (regular ? '' : 'Class')];
        }
    }

    // Capitalize some string
    function capitalize(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    // Executable handlers
    function callbacks(input, checked, callback, keep) {
        if (!keep) {
            if (checked) {
                input[_callback]('ifToggled');
            }

            input[_callback]('ifChanged')[_callback]('if' + capitalize(callback));
        }
    }
})(window.jQuery || window.Zepto);



/*Select*/


/* 
 * Selecter v3.2.3 - 2014-10-24 
 * A jQuery plugin for replacing default select elements. Part of the Formstone Library. 
 * http://formstone.it/selecter/ 
 * 
 * Copyright 2014 Ben Plum; MIT Licensed 
 */

;
(function ($, window) {
    "use strict";

    var guid = 0,
        userAgent = (window.navigator.userAgent || window.navigator.vendor || window.opera),
        isFirefox = /Firefox/i.test(userAgent),
        isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(userAgent),
        isFirefoxMobile = (isFirefox && isMobile),
        $body = null;

    /**
     * @options
     * @param callback [function] <$.noop> "Select item callback"
     * @param cover [boolean] <false> "Cover handle with option set"
     * @param customClass [string] <''> "Class applied to instance"
     * @param label [string] <''> "Label displayed before selection"
     * @param external [boolean] <false> "Open options as links in new window"
     * @param links [boolean] <false> "Open options as links in same window"
     * @param mobile [boolean] <false> "Force desktop interaction on mobile"
     * @param trim [int] <0> "Trim options to specified length; 0 to disable”
     */
    var options = {
        callback: $.noop,
        cover: false,
        customClass: "",
        label: "",
        external: false,
        links: false,
        mobile: false,
        trim: 0
    };

    var pub = {

        /**
         * @method
         * @name defaults
         * @description Sets default plugin options
         * @param opts [object] <{}> "Options object"
         * @example $.selecter("defaults", opts);
         */
        defaults: function (opts) {
            options = $.extend(options, opts || {});
            return $(this);
        },

        /**
         * @method
         * @name disable
         * @description Disables target instance or option
         * @param option [string] <null> "Target option value"
         * @example $(".target").selecter("disable", "1");
         */
        disable: function (option) {
            return $(this).each(function (i, input) {
                var data = $(input).parent(".selecter").data("selecter");

                if (data) {
                    if (typeof option !== "undefined") {
                        var index = data.$items.index(data.$items.filter("[data-value=" + option + "]"));

                        data.$items.eq(index).addClass("disabled");
                        data.$options.eq(index).prop("disabled", true);
                    } else {
                        if (data.$selecter.hasClass("open")) {
                            data.$selecter.find(".selecter-selected").trigger("click.selecter");
                        }

                        data.$selecter.addClass("disabled");
                        data.$select.prop("disabled", true);
                    }
                }
            });
        },

        /**
         * @method
         * @name destroy
         * @description Removes instance of plugin
         * @example $(".target").selecter("destroy");
         */
        destroy: function () {
            return $(this).each(function (i, input) {
                var data = $(input).parent(".selecter").data("selecter");

                if (data) {
                    if (data.$selecter.hasClass("open")) {
                        data.$selecter.find(".selecter-selected").trigger("click.selecter");
                    }

                    // Scroller support
                    if ($.fn.scroller !== undefined) {
                        data.$selecter.find(".selecter-options").scroller("destroy");
                    }

                    data.$select[0].tabIndex = data.tabIndex;

                    data.$select.find(".selecter-placeholder").remove();
                    data.$selected.remove();
                    data.$itemsWrapper.remove();

                    data.$selecter.off(".selecter");

                    data.$select.off(".selecter")
                        .removeClass("selecter-element")
                        .show()
                        .unwrap();
                }
            });
        },

        /**
         * @method
         * @name enable
         * @description Enables target instance or option
         * @param option [string] <null> "Target option value"
         * @example $(".target").selecter("enable", "1");
         */
        enable: function (option) {
            return $(this).each(function (i, input) {
                var data = $(input).parent(".selecter").data("selecter");

                if (data) {
                    if (typeof option !== "undefined") {
                        var index = data.$items.index(data.$items.filter("[data-value=" + option + "]"));
                        data.$items.eq(index).removeClass("disabled");
                        data.$options.eq(index).prop("disabled", false);
                    } else {
                        data.$selecter.removeClass("disabled");
                        data.$select.prop("disabled", false);
                    }
                }
            });
        },


        /**
         * @method private
         * @name refresh
         * @description DEPRECATED - Updates instance base on target options
         * @example $(".target").selecter("refresh");
         */
        refresh: function () {
            return pub.update.apply($(this));
        },

        /**
         * @method
         * @name update
         * @description Updates instance base on target options
         * @example $(".target").selecter("update");
         */
        update: function () {
            return $(this).each(function (i, input) {
                var data = $(input).parent(".selecter").data("selecter");

                if (data) {
                    var index = data.index;

                    data.$allOptions = data.$select.find("option, optgroup");
                    data.$options = data.$allOptions.filter("option");
                    data.index = -1;

                    index = data.$options.index(data.$options.filter(":selected"));

                    _buildOptions(data);

                    if (!data.multiple) {
                        _update(index, data);
                    }
                }
            });
        }
    };

    /**
     * @method private
     * @name _init
     * @description Initializes plugin
     * @param opts [object] "Initialization options"
     */
    function _init(opts) {
        // Local options
        opts = $.extend({}, options, opts || {});

        // Check for Body
        if ($body === null) {
            $body = $("body");
        }

        // Apply to each element
        var $items = $(this);
        for (var i = 0, count = $items.length; i < count; i++) {
            _build($items.eq(i), opts);
        }
        return $items;
    }

    /**
     * @method private
     * @name _build
     * @description Builds each instance
     * @param $select [jQuery object] "Target jQuery object"
     * @param opts [object] <{}> "Options object"
     */
    function _build($select, opts) {
        if (!$select.hasClass("selecter-element")) {
            // EXTEND OPTIONS
            opts = $.extend({}, opts, $select.data("selecter-options"));

            opts.multiple = $select.prop("multiple");
            opts.disabled = $select.is(":disabled");

            if (opts.external) {
                opts.links = true;
            }

            // Grab true original index, only if selected attribute exits
            var $originalOption = $select.find("[selected]").not(":disabled"),
                originalOptionIndex = $select.find("option").index($originalOption);

            if (!opts.multiple && opts.label !== "") {
                $select.prepend('<option value="" class="selecter-placeholder" selected>' + opts.label + '</option>');
                if (originalOptionIndex > -1) {
                    originalOptionIndex++;
                }
            } else {
                opts.label = "";
            }

            // Build options array
            var $allOptions = $select.find("option, optgroup"),
                $options = $allOptions.filter("option");

            // If we didn't actually have a selected elemtn
            if (!$originalOption.length) {
                $originalOption = $options.eq(0);
            }

            // Determine original item
            var originalIndex = (originalOptionIndex > -1) ? originalOptionIndex : 0,
                originalLabel = (opts.label !== "") ? opts.label : $originalOption.text(),
                wrapperTag = "div";

            // Swap tab index, no more interacting with the actual select!
            opts.tabIndex = $select[0].tabIndex;
            $select[0].tabIndex = -1;

            // Build HTML
            var inner = "",
                wrapper = "";

            // Build wrapper
            wrapper += '<' + wrapperTag + ' class="selecter ' + opts.customClass;
            // Special case classes
            if (isMobile) {
                wrapper += ' mobile';
            } else if (opts.cover) {
                wrapper += ' cover';
            }
            if (opts.multiple) {
                wrapper += ' multiple';
            } else {
                wrapper += ' closed';
            }
            if (opts.disabled) {
                wrapper += ' disabled';
            }
            wrapper += '" tabindex="' + opts.tabIndex + '">';
            wrapper += '</' + wrapperTag + '>';

            // Build inner
            if (!opts.multiple) {
                inner += '<span class="selecter-selected">';
                inner += $('<span></span>').text(_trim(originalLabel, opts.trim)).html();
                inner += '</span>';
            }
            inner += '<div class="selecter-options">';
            inner += '</div>';

            // Modify DOM
            $select.addClass("selecter-element")
                .wrap(wrapper)
                .after(inner);

            // Store plugin data
            var $selecter = $select.parent(".selecter"),
                data = $.extend({
                    $select: $select,
                    $allOptions: $allOptions,
                    $options: $options,
                    $selecter: $selecter,
                    $selected: $selecter.find(".selecter-selected"),
                    $itemsWrapper: $selecter.find(".selecter-options"),
                    index: -1,
                    guid: guid++
                }, opts);

            _buildOptions(data);

            if (!data.multiple) {
                _update(originalIndex, data);
            }

            // Scroller support
            if ($.fn.scroller !== undefined) {
                data.$itemsWrapper.scroller();
            }

            // Bind click events
            data.$selecter.on("touchstart.selecter", ".selecter-selected", data, _onTouchStart)
                .on("click.selecter", ".selecter-selected", data, _onClick)
                .on("click.selecter", ".selecter-item", data, _onSelect)
                .on("close.selecter", data, _onClose)
                .data("selecter", data);

            // Change events
            data.$select.on("change.selecter", data, _onChange);

            // Focus/Blur events
            if (!isMobile) {
                data.$selecter.on("focusin.selecter", data, _onFocus)
                    .on("blur.selecter", data, _onBlur);

                // Handle clicks to associated labels
                data.$select.on("focusin.selecter", data, function (e) {
                    e.data.$selecter.trigger("focus");
                });
            }
        }
    }

    /**
     * @method private
     * @name _buildOptions
     * @description Builds instance's option set
     * @param data [object] "Instance data"
     */
    function _buildOptions(data) {
        var html = '',
            itemTag = (data.links) ? "a" : "span",
            j = 0;

        for (var i = 0, count = data.$allOptions.length; i < count; i++) {
            var $op = data.$allOptions.eq(i);

            // Option group
            if ($op[0].tagName === "OPTGROUP") {
                html += '<span class="selecter-group';
                // Disabled groups
                if ($op.is(":disabled")) {
                    html += ' disabled';
                }
                html += '">' + $op.attr("label") + '</span>';
            } else {
                var opVal = $op.val();

                if (!$op.attr("value")) {
                    $op.attr("value", opVal);
                }

                html += '<' + itemTag + ' class="selecter-item';
                if ($op.hasClass('selecter-placeholder')) {
                    html += ' placeholder';
                }
                // Default selected value - now handles multi's thanks to @kuilkoff
                if ($op.is(':selected')) {
                    html += ' selected';
                }
                // Disabled options
                if ($op.is(":disabled")) {
                    html += ' disabled';
                }
                html += '" ';
                if (data.links) {
                    html += 'href="' + opVal + '"';
                } else {
                    html += 'data-value="' + opVal + '"';
                }
                html += '>' + $("<span></span>").text(_trim($op.text(), data.trim)).html() + '</' + itemTag + '>';
                j++;
            }
        }

        data.$itemsWrapper.html(html);
        data.$items = data.$selecter.find(".selecter-item");
    }

    /**
     * @method private
     * @name _onTouchStart
     * @description Handles touchstart to selected item
     * @param e [object] "Event data"
     */
    function _onTouchStart(e) {
        e.stopPropagation();

        var data = e.data;

        data.touchStartEvent = e.originalEvent;

        data.touchStartX = data.touchStartEvent.touches[0].clientX;
        data.touchStartY = data.touchStartEvent.touches[0].clientY;

        data.$selecter.on("touchmove.selecter", ".selecter-selected", data, _onTouchMove)
            .on("touchend.selecter", ".selecter-selected", data, _onTouchEnd);
    }

    /**
     * @method private
     * @name _onTouchMove
     * @description Handles touchmove to selected item
     * @param e [object] "Event data"
     */
    function _onTouchMove(e) {
        var data = e.data,
            oe = e.originalEvent;

        if (Math.abs(oe.touches[0].clientX - data.touchStartX) > 10 || Math.abs(oe.touches[0].clientY - data.touchStartY) > 10) {
            data.$selecter.off("touchmove.selecter touchend.selecter");
        }
    }

    /**
     * @method private
     * @name _onTouchEnd
     * @description Handles touchend to selected item
     * @param e [object] "Event data"
     */
    function _onTouchEnd(e) {
        var data = e.data;

        data.touchStartEvent.preventDefault();

        data.$selecter.off("touchmove.selecter touchend.selecter");

        _onClick(e);
    }

    /**
     * @method private
     * @name _onClick
     * @description Handles click to selected item
     * @param e [object] "Event data"
     */
    function _onClick(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = e.data;

        if (!data.$select.is(":disabled")) {
            $(".selecter").not(data.$selecter).trigger("close.selecter", [data]);

            // Handle mobile, but not Firefox, unless desktop forced
            if (!data.mobile && isMobile && !isFirefoxMobile) {
                var el = data.$select[0];
                if (window.document.createEvent) { // All
                    var evt = window.document.createEvent("MouseEvents");
                    evt.initMouseEvent("mousedown", false, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
                    el.dispatchEvent(evt);
                } else if (el.fireEvent) { // IE
                    el.fireEvent("onmousedown");
                }
            } else {
                // Delegate intent
                if (data.$selecter.hasClass("closed")) {
                    _onOpen(e);
                } else if (data.$selecter.hasClass("open")) {
                    _onClose(e);
                }
            }
        }
    }

    /**
     * @method private
     * @name _onOpen
     * @description Opens option set
     * @param e [object] "Event data"
     */
    function _onOpen(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = e.data;

        // Make sure it's not alerady open
        if (!data.$selecter.hasClass("open")) {
            var offset = data.$selecter.offset(),
                bodyHeight = $body.outerHeight(),
                optionsHeight = data.$itemsWrapper.outerHeight(true),
                selectedOffset = (data.index >= 0) ? data.$items.eq(data.index).position() : {
                    left: 0,
                    top: 0
                };

            // Calculate bottom of document
            if (offset.top + optionsHeight > bodyHeight) {
                data.$selecter.addClass("bottom");
            }

            data.$itemsWrapper.show();

            // Bind Events
            data.$selecter.removeClass("closed")
                .addClass("open");
            $body.on("click.selecter-" + data.guid, ":not(.selecter-options)", data, _onCloseHelper);

            _scrollOptions(data);
        }
    }

    /**
     * @method private
     * @name _onCloseHelper
     * @description Determines if event target is outside instance before closing
     * @param e [object] "Event data"
     */
    function _onCloseHelper(e) {
        e.preventDefault();
        e.stopPropagation();

        if ($(e.currentTarget).parents(".selecter").length === 0) {
            _onClose(e);
        }
    }

    /**
     * @method private
     * @name _onClose
     * @description Closes option set
     * @param e [object] "Event data"
     */
    function _onClose(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = e.data;

        // Make sure it's actually open
        if (data.$selecter.hasClass("open")) {
            data.$itemsWrapper.hide();
            data.$selecter.removeClass("open bottom")
                .addClass("closed");

            $body.off(".selecter-" + data.guid);
        }
    }

    /**
     * @method private
     * @name _onSelect
     * @description Handles option select
     * @param e [object] "Event data"
     */
    function _onSelect(e) {
        e.preventDefault();
        e.stopPropagation();

        var $target = $(this),
            data = e.data;

        if (!data.$select.is(":disabled")) {
            if (data.$itemsWrapper.is(":visible")) {
                // Update
                var index = data.$items.index($target);

                if (index !== data.index) {
                    _update(index, data);
                    _handleChange(data);
                }
            }

            if (!data.multiple) {
                // Clean up
                _onClose(e);
            }
        }
    }

    /**
     * @method private
     * @name _onChange
     * @description Handles external changes
     * @param e [object] "Event data"
     */
    function _onChange(e, internal) {
        var $target = $(this),
            data = e.data;

        if (!internal && !data.multiple) {
            var index = data.$options.index(data.$options.filter("[value='" + _escape($target.val()) + "']"));

            _update(index, data);
            _handleChange(data);
        }
    }

    /**
     * @method private
     * @name _onFocus
     * @description Handles instance focus
     * @param e [object] "Event data"
     */
    function _onFocus(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = e.data;

        if (!data.$select.is(":disabled") && !data.multiple) {
            data.$selecter.addClass("focus")
                .on("keydown.selecter-" + data.guid, data, _onKeypress);

            $(".selecter").not(data.$selecter)
                .trigger("close.selecter", [data]);
        }
    }

    /**
     * @method private
     * @name _onBlur
     * @description Handles instance focus
     * @param e [object] "Event data"
     */
    function _onBlur(e, internal, two) {
        e.preventDefault();
        e.stopPropagation();

        var data = e.data;

        data.$selecter.removeClass("focus")
            .off("keydown.selecter-" + data.guid);

        $(".selecter").not(data.$selecter)
            .trigger("close.selecter", [data]);
    }

    /**
     * @method private
     * @name _onKeypress
     * @description Handles instance keypress, once focused
     * @param e [object] "Event data"
     */
    function _onKeypress(e) {
        var data = e.data;

        if (e.keyCode === 13) {
            if (data.$selecter.hasClass("open")) {
                _onClose(e);
                _update(data.index, data);
            }
            _handleChange(data);
        } else if (e.keyCode !== 9 && (!e.metaKey && !e.altKey && !e.ctrlKey && !e.shiftKey)) {
            // Ignore modifiers & tabs
            e.preventDefault();
            e.stopPropagation();

            var total = data.$items.length - 1,
                index = (data.index < 0) ? 0 : data.index;

            // Firefox left/right support thanks to Kylemade
            if ($.inArray(e.keyCode, (isFirefox) ? [38, 40, 37, 39] : [38, 40]) > -1) {
                // Increment / decrement using the arrow keys
                index = index + ((e.keyCode === 38 || (isFirefox && e.keyCode === 37)) ? -1 : 1);

                if (index < 0) {
                    index = 0;
                }
                if (index > total) {
                    index = total;
                }
            } else {
                var input = String.fromCharCode(e.keyCode).toUpperCase(),
                    letter,
                    i;

                // Search for input from original index
                for (i = data.index + 1; i <= total; i++) {
                    letter = data.$options.eq(i).text().charAt(0).toUpperCase();
                    if (letter === input) {
                        index = i;
                        break;
                    }
                }

                // If not, start from the beginning
                if (index < 0 || index === data.index) {
                    for (i = 0; i <= total; i++) {
                        letter = data.$options.eq(i).text().charAt(0).toUpperCase();
                        if (letter === input) {
                            index = i;
                            break;
                        }
                    }
                }
            }

            // Update
            if (index >= 0) {
                _update(index, data);
                _scrollOptions(data);
            }
        }
    }

    /**
     * @method private
     * @name _update
     * @description Updates instance based on new target index
     * @param index [int] "Selected option index"
     * @param data [object] "instance data"
     */
    function _update(index, data) {
        var $item = data.$items.eq(index),
            isSelected = $item.hasClass("selected"),
            isDisabled = $item.hasClass("disabled");

        // Check for disabled options
        if (!isDisabled) {
            if (data.multiple) {
                if (isSelected) {
                    data.$options.eq(index).prop("selected", null);
                    $item.removeClass("selected");
                } else {
                    data.$options.eq(index).prop("selected", true);
                    $item.addClass("selected");
                }
            } else if (index > -1 && index < data.$items.length) {
                var newLabel = $item.html(),
                    newValue = $item.data("value");

                data.$selected.html(newLabel)
                    .removeClass('placeholder');

                data.$items.filter(".selected")
                    .removeClass("selected");

                data.$select[0].selectedIndex = index;

                $item.addClass("selected");
                data.index = index;
            } else if (data.label !== "") {
                data.$selected.html(data.label);
            }
        }
    }

    /**
     * @method private
     * @name _scrollOptions
     * @description Scrolls options wrapper to specific option
     * @param data [object] "Instance data"
     */
    function _scrollOptions(data) {
        var $selected = data.$items.eq(data.index),
            selectedOffset = (data.index >= 0 && !$selected.hasClass("placeholder")) ? $selected.position() : {
                left: 0,
                top: 0
            };

        if ($.fn.scroller !== undefined) {
            data.$itemsWrapper.scroller("scroll", (data.$itemsWrapper.find(".scroller-content").scrollTop() + selectedOffset.top), 0)
                .scroller("reset");
        } else {
            data.$itemsWrapper.scrollTop(data.$itemsWrapper.scrollTop() + selectedOffset.top);
        }
    }

    /**
     * @method private
     * @name _handleChange
     * @description Handles change events
     * @param data [object] "Instance data"
     */
    function _handleChange(data) {
        if (data.links) {
            _launch(data);
        } else {
            data.callback.call(data.$selecter, data.$select.val(), data.index);
            data.$select.trigger("change", [true]);
        }
    }

    /**
     * @method private
     * @name _launch
     * @description Launches link
     * @param data [object] "Instance data"
     */
    function _launch(data) {
        //var url = (isMobile) ? data.$select.val() : data.$options.filter(":selected").attr("href");
        var url = data.$select.val();

        if (data.external) {
            // Open link in a new tab/window
            window.open(url);
        } else {
            // Open link in same tab/window
            window.location.href = url;
        }
    }

    /**
     * @method private
     * @name _trim
     * @description Trims text, if specified length is greater then 0
     * @param length [int] "Length to trim at"
     * @param text [string] "Text to trim"
     * @return [string] "Trimmed string"
     */
    function _trim(text, length) {
        if (length === 0) {
            return text;
        } else {
            if (text.length > length) {
                return text.substring(0, length) + "...";
            } else {
                return text;
            }
        }
    }

    /**
     * @method private
     * @name _escape
     * @description Escapes text
     * @param text [string] "Text to escape"
     */
    function _escape(text) {
        return (typeof text === "string") ? text.replace(/([;&,\.\+\*\~':"\!\^#$%@\[\]\(\)=>\|])/g, '\\$1') : text;
    }

    $.fn.selecter = function (method) {
        if (pub[method]) {
            return pub[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return _init.apply(this, arguments);
        }
        return this;
    };

    $.selecter = function (method) {
        if (method === "defaults") {
            pub.defaults.apply(this, Array.prototype.slice.call(arguments, 1));
        }
    };
})(jQuery, window);



/* 
 * Stepper v3.0.7 - 2014-05-07 
 * A jQuery plugin for cross browser number inputs. Part of the Formstone Library. 
 * http://formstone.it/stepper/ 
 * 
 * Copyright 2014 Ben Plum; MIT Licensed 
 */

;
(function ($, window) {
    "use strict";

    /**
     * @options
     * @param customClass [string] <''> "Class applied to instance"
     * @param lables.up [string] <'Up'> "Up arrow label"
     * @param lables.down [string] <'Down'> "Down arrow label"
     */
    var options = {
        customClass: "",
        labels: {
            up: "Up",
            down: "Down"
        }
    };

    var pub = {

        /**
         * @method
         * @name defaults
         * @description Sets default plugin options
         * @param opts [object] <{}> "Options object"
         * @example $.stepper("defaults", opts);
         */
        defaults: function (opts) {
            options = $.extend(options, opts || {});
            return $(this);
        },

        /**
         * @method
         * @name destroy
         * @description Removes instance of plugin
         * @example $(".target").stepper("destroy");
         */
        destroy: function () {
            return $(this).each(function (i) {
                var data = $(this).data("stepper");

                if (data) {
                    // Unbind click events
                    data.$stepper.off(".stepper")
                        .find(".stepper-arrow")
                        .remove();

                    // Restore DOM
                    data.$input.unwrap()
                        .removeClass("stepper-input");
                }
            });
        },

        /**
         * @method
         * @name disable
         * @description Disables target instance
         * @example $(".target").stepper("disable");
         */
        disable: function () {
            return $(this).each(function (i) {
                var data = $(this).data("stepper");

                if (data) {
                    data.$input.attr("disabled", "disabled");
                    data.$stepper.addClass("disabled");
                }
            });
        },

        /**
         * @method
         * @name enable
         * @description Enables target instance
         * @example $(".target").stepper("enable");
         */
        enable: function () {
            return $(this).each(function (i) {
                var data = $(this).data("stepper");

                if (data) {
                    data.$input.attr("disabled", null);
                    data.$stepper.removeClass("disabled");
                }
            });
        }
    };

    /**
     * @method private
     * @name _init
     * @description Initializes plugin
     * @param opts [object] "Initialization options"
     */
    function _init(opts) {
        // Local options
        opts = $.extend({}, options, opts || {});

        // Apply to each element
        var $items = $(this);
        for (var i = 0, count = $items.length; i < count; i++) {
            _build($items.eq(i), opts);
        }
        return $items;
    }

    /**
     * @method private
     * @name _build
     * @description Builds each instance
     * @param $select [jQuery object] "Target jQuery object"
     * @param opts [object] <{}> "Options object"
     */
    function _build($input, opts) {
        if (!$input.hasClass("stepper-input")) {
            // EXTEND OPTIONS
            opts = $.extend({}, opts, $input.data("stepper-options"));

            // HTML5 attributes
            var min = parseFloat($input.attr("min")),
                max = parseFloat($input.attr("max")),
                step = parseFloat($input.attr("step")) || 1;

            // Modify DOM
            $input.addClass("stepper-input")
                .wrap('<div class="stepper ' + opts.customClass + '" />')
                .after('<span class="stepper-arrow up">' + opts.labels.up + '</span><span class="stepper-arrow down">' + opts.labels.down + '</span>');

            // Store data
            var $stepper = $input.parent(".stepper"),
                data = $.extend({
                    $stepper: $stepper,
                    $input: $input,
                    $arrow: $stepper.find(".stepper-arrow"),
                    min: (typeof min !== undefined && !isNaN(min)) ? min : false,
                    max: (typeof max !== undefined && !isNaN(max)) ? max : false,
                    step: (typeof step !== undefined && !isNaN(step)) ? step : 1,
                    timer: null
                }, opts);

            data.digits = _digits(data.step);

            // Check disabled
            if ($input.is(":disabled")) {
                $stepper.addClass("disabled");
            }

            // Bind keyboard events
            $stepper.on("keypress", ".stepper-input", data, _onKeyup);

            // Bind click events
            $stepper.on("touchstart.stepper mousedown.stepper", ".stepper-arrow", data, _onMouseDown)
                .data("stepper", data);
        }
    }

    /**
     * @method private
     * @name _onKeyup
     * @description Handles keypress event on inputs
     * @param e [object] "Event data"
     */
    function _onKeyup(e) {
        var data = e.data;

        // If arrow keys
        if (e.keyCode === 38 || e.keyCode === 40) {
            e.preventDefault();

            _step(data, (e.keyCode === 38) ? data.step : -data.step);
        }
    }

    /**
     * @method private
     * @name _onMouseDown
     * @description Handles mousedown event on instance arrows
     * @param e [object] "Event data"
     */
    function _onMouseDown(e) {
        e.preventDefault();
        e.stopPropagation();

        // Make sure we reset the states
        _onMouseUp(e);

        var data = e.data;

        if (!data.$input.is(':disabled') && !data.$stepper.hasClass("disabled")) {
            var change = $(e.target).hasClass("up") ? data.step : -data.step;

            data.timer = _startTimer(data.timer, 125, function () {
                _step(data, change, false);
            });
            _step(data, change);

            $("body").on("touchend.stepper mouseup.stepper", data, _onMouseUp);
        }
    }

    /**
     * @method private
     * @name _onMouseUp
     * @description Handles mouseup event on instance arrows
     * @param e [object] "Event data"
     */
    function _onMouseUp(e) {
        e.preventDefault();
        e.stopPropagation();

        var data = e.data;

        _clearTimer(data.timer);

        $("body").off(".stepper");
    }

    /**
     * @method private
     * @name _step
     * @description Steps through values
     * @param e [object] "Event data"
     * @param change [string] "Change value"
     */
    function _step(data, change) {
        var originalValue = parseFloat(data.$input.val()),
            value = change;

        if (typeof originalValue === undefined || isNaN(originalValue)) {
            if (data.min !== false) {
                value = data.min;
            } else {
                value = 0;
            }
        } else if (data.min !== false && originalValue < data.min) {
            value = data.min;
        } else {
            value += originalValue;
        }

        var diff = (value - data.min) % data.step;
        if (diff !== 0) {
            value -= diff;
        }

        if (data.min !== false && value < data.min) {
            value = data.min;
        }
        if (data.max !== false && value > data.max) {
            value -= data.step;
        }

        if (value !== originalValue) {
            value = _round(value, data.digits);

            data.$input.val(value)
                .trigger("change");
        }
    }

    /**
     * @method private
     * @name _startTimer
     * @description Starts an internal timer
     * @param timer [int] "Timer ID"
     * @param time [int] "Time until execution"
     * @param callback [int] "Function to execute"
     */
    function _startTimer(timer, time, callback) {
        _clearTimer(timer);
        return setInterval(callback, time);
    }

    /**
     * @method private
     * @name _clearTimer
     * @description Clears an internal timer
     * @param timer [int] "Timer ID"
     */
    function _clearTimer(timer) {
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
    }

    /**
     * @method private
     * @name _digits
     * @description Analyzes and returns significant digit count
     * @param value [float] "Value to analyze"
     * @return [int] "Number of significant digits"
     */
    function _digits(value) {
        var test = String(value);
        if (test.indexOf(".") > -1) {
            return test.length - test.indexOf(".") - 1;
        } else {
            return 0;
        }
    }

    /**
     * @method private
     * @name _round
     * @description Rounds a number to a sepcific significant digit count
     * @param value [float] "Value to round"
     * @param digits [float] "Digits to round to"
     * @return [number] "Rounded number"
     */
    function _round(value, digits) {
        var exp = Math.pow(10, digits);
        return Math.round(value * exp) / exp;
    }

    $.fn.stepper = function (method) {
        if (pub[method]) {
            return pub[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return _init.apply(this, arguments);
        }
        return this;
    };

    $.stepper = function (method) {
        if (method === "defaults") {
            pub.defaults.apply(this, Array.prototype.slice.call(arguments, 1));
        }
    };
})(jQuery, this);

/*Menu*/

/*
 * SmartMenus jQuery v0.9.7
 * http://www.smartmenus.org/
 *
 * Copyright 2014 Vasil Dinkov, Vadikom Web Ltd.
 * http://vadikom.com/
 *
 * Released under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

(function ($) {

    var menuTrees = [],
        IE = !!window.createPopup, // detect it for the iframe shim
        mouse = false, // optimize for touch by default - we will detect for mouse input
        mouseDetectionEnabled = false;

    // Handle detection for mouse input (i.e. desktop browsers, tablets with a mouse, etc.)
    function initMouseDetection(disable) {
        var eNS = '.smartmenus_mouse';
        if (!mouseDetectionEnabled && !disable) {
            // if we get two consecutive mousemoves within 2 pixels from each other and within 300ms, we assume a real mouse/cursor is present
            // in practice, this seems like impossible to trick unintentianally with a real mouse and a pretty safe detection on touch devices (even with older browsers that do not support touch events)
            var firstTime = true,
                lastMove = null;
            $(document).bind(getEventsNS([
                ['mousemove', function (e) {
                    var thisMove = {
                        x: e.pageX,
                        y: e.pageY,
                        timeStamp: new Date().getTime()
                    };
                    if (lastMove) {
                        var deltaX = Math.abs(lastMove.x - thisMove.x),
                            deltaY = Math.abs(lastMove.y - thisMove.y);
                        if ((deltaX > 0 || deltaY > 0) && deltaX <= 2 && deltaY <= 2 && thisMove.timeStamp - lastMove.timeStamp <= 300) {
                            mouse = true;
                            // if this is the first check after page load, check if we are not over some item by chance and call the mouseenter handler if yes
                            if (firstTime) {
                                var $a = $(e.target).closest('a');
                                if ($a.is('a')) {
                                    $.each(menuTrees, function () {
                                        if ($.contains(this.$root[0], $a[0])) {
                                            this.itemEnter({
                                                currentTarget: $a[0]
                                            });
                                            return false;
                                        }
                                    });
                                }
                                firstTime = false;
                            }
                        }
                    }
                    lastMove = thisMove;
                }],
                [touchEvents() ? 'touchstart' : 'pointerover pointermove pointerout MSPointerOver MSPointerMove MSPointerOut', function (e) {
                    if (isTouchEvent(e.originalEvent)) {
                        mouse = false;
                    }
                }]
            ], eNS));
            mouseDetectionEnabled = true;
        } else if (mouseDetectionEnabled && disable) {
            $(document).unbind(eNS);
            mouseDetectionEnabled = false;
        }
    }

    function isTouchEvent(e) {
        return !/^(4|mouse)$/.test(e.pointerType);
    }

    // we use this just to choose between toucn and pointer events when we need to, not for touch screen detection
    function touchEvents() {
        return 'ontouchstart' in window;
    }

    // returns a jQuery bind() ready object
    function getEventsNS(defArr, eNS) {
        if (!eNS) {
            eNS = '';
        }
        var obj = {};
        $.each(defArr, function (index, value) {
            obj[value[0].split(' ').join(eNS + ' ') + eNS] = value[1];
        });
        return obj;
    }

    $.SmartMenus = function (elm, options) {
        this.$root = $(elm);
        this.opts = options;
        this.rootId = ''; // internal
        this.$subArrow = null;
        this.subMenus = []; // all sub menus in the tree (UL elms) in no particular order (only real - e.g. UL's in mega sub menus won't be counted)
        this.activatedItems = []; // stores last activated A's for each level
        this.visibleSubMenus = []; // stores visible sub menus UL's
        this.showTimeout = 0;
        this.hideTimeout = 0;
        this.scrollTimeout = 0;
        this.clickActivated = false;
        this.zIndexInc = 0;
        this.$firstLink = null; // we'll use these for some tests
        this.$firstSub = null; // at runtime so we'll cache them
        this.disabled = false;
        this.$disableOverlay = null;
        this.isTouchScrolling = false;
        this.init();
    };

    $.extend($.SmartMenus, {
        hideAll: function () {
            $.each(menuTrees, function () {
                this.menuHideAll();
            });
        },
        destroy: function () {
            while (menuTrees.length) {
                menuTrees[0].destroy();
            }
            initMouseDetection(true);
        },
        prototype: {
            init: function (refresh) {
                var self = this;

                if (!refresh) {
                    menuTrees.push(this);

                    this.rootId = (new Date().getTime() + Math.random() + '').replace(/\D/g, '');

                    if (this.$root.hasClass('sm-rtl')) {
                        this.opts.rightToLeftSubMenus = true;
                    }

                    // init root (main menu)
                    var eNS = '.smartmenus';
                    this.$root.data('smartmenus', this)
                        .attr('data-smartmenus-id', this.rootId)
                        .dataSM('level', 1)
                        .bind(getEventsNS([
                        ['mouseover focusin', $.proxy(this.rootOver, this)],
                        ['mouseout focusout', $.proxy(this.rootOut, this)]
                        ], eNS))
                        .delegate('a', getEventsNS([
                        ['mouseenter', $.proxy(this.itemEnter, this)],
                        ['mouseleave', $.proxy(this.itemLeave, this)],
                        ['mousedown', $.proxy(this.itemDown, this)],
                        ['focus', $.proxy(this.itemFocus, this)],
                        ['blur', $.proxy(this.itemBlur, this)],
                        ['click', $.proxy(this.itemClick, this)],
                        ['touchend', $.proxy(this.itemTouchEnd, this)]
                        ], eNS));

                    // hide menus on tap or click outside the root UL
                    eNS += this.rootId;
                    if (this.opts.hideOnClick) {
                        $(document).bind(getEventsNS([
                            ['touchstart', $.proxy(this.docTouchStart, this)],
                            ['touchmove', $.proxy(this.docTouchMove, this)],
                            ['touchend', $.proxy(this.docTouchEnd, this)],
                            // for Opera Mobile < 11.5, webOS browser, etc. we'll check click too
                            ['click', $.proxy(this.docClick, this)]
                        ], eNS));
                    }
                    // hide sub menus on resize
                    $(window).bind(getEventsNS([
                        ['resize orientationchange', $.proxy(this.winResize, this)]
                    ], eNS));

                    if (this.opts.subIndicators) {
                        this.$subArrow = $('<span/>').addClass('sub-arrow');
                        if (this.opts.subIndicatorsText) {
                            this.$subArrow.html(this.opts.subIndicatorsText);
                        }
                    }

                    // make sure mouse detection is enabled
                    initMouseDetection();
                }

                // init sub menus
                this.$firstSub = this.$root.find('ul').each(function () {
                    self.menuInit($(this));
                }).eq(0);

                this.$firstLink = this.$root.find('a').eq(0);

                // find current item
                if (this.opts.markCurrentItem) {
                    var reDefaultDoc = /(index|default)\.[^#\?\/]*/i,
                        reHash = /#.*/,
                        locHref = window.location.href.replace(reDefaultDoc, ''),
                        locHrefNoHash = locHref.replace(reHash, '');
                    this.$root.find('a').each(function () {
                        var href = this.href.replace(reDefaultDoc, ''),
                            $this = $(this);
                        if (href == locHref || href == locHrefNoHash) {
                            $this.addClass('current');
                            if (self.opts.markCurrentTree) {
                                $this.parent().parentsUntil('[data-smartmenus-id]', 'li').children('a').addClass('current');
                            }
                        }
                    });
                }
            },
            destroy: function () {
                this.menuHideAll();
                var eNS = '.smartmenus';
                this.$root.removeData('smartmenus')
                    .removeAttr('data-smartmenus-id')
                    .removeDataSM('level')
                    .unbind(eNS)
                    .undelegate(eNS);
                eNS += this.rootId;
                $(document).unbind(eNS);
                $(window).unbind(eNS);
                if (this.opts.subIndicators) {
                    this.$subArrow = null;
                }
                var self = this;
                $.each(this.subMenus, function () {
                    if (this.hasClass('mega-menu')) {
                        this.find('ul').removeDataSM('in-mega');
                    }
                    if (this.dataSM('shown-before')) {
                        if (self.opts.subMenusMinWidth || self.opts.subMenusMaxWidth) {
                            this.css({
                                width: '',
                                minWidth: '',
                                maxWidth: ''
                            }).removeClass('sm-nowrap');
                        }
                        if (this.dataSM('scroll-arrows')) {
                            this.dataSM('scroll-arrows').remove();
                        }
                        this.css({
                            zIndex: '',
                            top: '',
                            left: '',
                            marginLeft: '',
                            marginTop: '',
                            display: ''
                        });
                    }
                    if (self.opts.subIndicators) {
                        this.dataSM('parent-a').removeClass('has-submenu').children('span.sub-arrow').remove();
                    }
                    this.removeDataSM('shown-before')
                        .removeDataSM('ie-shim')
                        .removeDataSM('scroll-arrows')
                        .removeDataSM('parent-a')
                        .removeDataSM('level')
                        .removeDataSM('beforefirstshowfired')
                        .parent().removeDataSM('sub');
                });
                if (this.opts.markCurrentItem) {
                    this.$root.find('a.current').removeClass('current');
                }
                this.$root = null;
                this.$firstLink = null;
                this.$firstSub = null;
                if (this.$disableOverlay) {
                    this.$disableOverlay.remove();
                    this.$disableOverlay = null;
                }
                menuTrees.splice($.inArray(this, menuTrees), 1);
            },
            disable: function (noOverlay) {
                if (!this.disabled) {
                    this.menuHideAll();
                    // display overlay over the menu to prevent interaction
                    if (!noOverlay && !this.opts.isPopup && this.$root.is(':visible')) {
                        var pos = this.$root.offset();
                        this.$disableOverlay = $('<div class="sm-jquery-disable-overlay"/>').css({
                            position: 'absolute',
                            top: pos.top,
                            left: pos.left,
                            width: this.$root.outerWidth(),
                            height: this.$root.outerHeight(),
                            zIndex: this.getStartZIndex(true),
                            opacity: 0
                        }).appendTo(document.body);
                    }
                    this.disabled = true;
                }
            },
            docClick: function (e) {
                if (this.isTouchScrolling) {
                    this.isTouchScrolling = false;
                    return;
                }
                // hide on any click outside the menu or on a menu link
                if (this.visibleSubMenus.length && !$.contains(this.$root[0], e.target) || $(e.target).is('a')) {
                    this.menuHideAll();
                }
            },
            docTouchEnd: function (e) {
                if (!this.lastTouch) {
                    return;
                }
                if (this.visibleSubMenus.length && (this.lastTouch.x2 === undefined || this.lastTouch.x1 == this.lastTouch.x2) && (this.lastTouch.y2 === undefined || this.lastTouch.y1 == this.lastTouch.y2) && (!this.lastTouch.target || !$.contains(this.$root[0], this.lastTouch.target))) {
                    if (this.hideTimeout) {
                        clearTimeout(this.hideTimeout);
                        this.hideTimeout = 0;
                    }
                    // hide with a delay to prevent triggering accidental unwanted click on some page element
                    var self = this;
                    this.hideTimeout = setTimeout(function () {
                        self.menuHideAll();
                    }, 350);
                }
                this.lastTouch = null;
            },
            docTouchMove: function (e) {
                if (!this.lastTouch) {
                    return;
                }
                var touchPoint = e.originalEvent.touches[0];
                this.lastTouch.x2 = touchPoint.pageX;
                this.lastTouch.y2 = touchPoint.pageY;
            },
            docTouchStart: function (e) {
                var touchPoint = e.originalEvent.touches[0];
                this.lastTouch = {
                    x1: touchPoint.pageX,
                    y1: touchPoint.pageY,
                    target: touchPoint.target
                };
            },
            enable: function () {
                if (this.disabled) {
                    if (this.$disableOverlay) {
                        this.$disableOverlay.remove();
                        this.$disableOverlay = null;
                    }
                    this.disabled = false;
                }
            },
            getClosestMenu: function (elm) {
                var $closestMenu = $(elm).closest('ul');
                while ($closestMenu.dataSM('in-mega')) {
                    $closestMenu = $closestMenu.parent().closest('ul');
                }
                return $closestMenu[0] || null;
            },
            getHeight: function ($elm) {
                return this.getOffset($elm, true);
            },
            // returns precise width/height float values
            getOffset: function ($elm, height) {
                var old;
                if ($elm.css('display') == 'none') {
                    old = {
                        position: $elm[0].style.position,
                        visibility: $elm[0].style.visibility
                    };
                    $elm.css({
                        position: 'absolute',
                        visibility: 'hidden'
                    }).show();
                }
                var box = $elm[0].getBoundingClientRect && $elm[0].getBoundingClientRect(),
                    val = box && (height ? box.height || box.bottom - box.top : box.width || box.right - box.left);
                if (!val && val !== 0) {
                    val = height ? $elm[0].offsetHeight : $elm[0].offsetWidth;
                }
                if (old) {
                    $elm.hide().css(old);
                }
                return val;
            },
            getStartZIndex: function (root) {
                var zIndex = parseInt(this[root ? '$root' : '$firstSub'].css('z-index'));
                if (!root && isNaN(zIndex)) {
                    zIndex = parseInt(this.$root.css('z-index'));
                }
                return !isNaN(zIndex) ? zIndex : 1;
            },
            getTouchPoint: function (e) {
                return e.touches && e.touches[0] || e.changedTouches && e.changedTouches[0] || e;
            },
            getViewport: function (height) {
                var name = height ? 'Height' : 'Width',
                    val = document.documentElement['client' + name],
                    val2 = window['inner' + name];
                if (val2) {
                    val = Math.min(val, val2);
                }
                return val;
            },
            getViewportHeight: function () {
                return this.getViewport(true);
            },
            getViewportWidth: function () {
                return this.getViewport();
            },
            getWidth: function ($elm) {
                return this.getOffset($elm);
            },
            handleEvents: function () {
                return !this.disabled && this.isCSSOn();
            },
            handleItemEvents: function ($a) {
                return this.handleEvents() && !this.isLinkInMegaMenu($a);
            },
            isCollapsible: function () {
                return this.$firstSub.css('position') == 'static';
            },
            isCSSOn: function () {
                return this.$firstLink.css('display') == 'block';
            },
            isFixed: function () {
                var isFixed = this.$root.css('position') == 'fixed';
                if (!isFixed) {
                    this.$root.parentsUntil('body').each(function () {
                        if ($(this).css('position') == 'fixed') {
                            isFixed = true;
                            return false;
                        }
                    });
                }
                return isFixed;
            },
            isLinkInMegaMenu: function ($a) {
                return !$a.parent().parent().dataSM('level');
            },
            isTouchMode: function () {
                return !mouse || this.isCollapsible();
            },
            itemActivate: function ($a) {
                var $li = $a.parent(),
                    $ul = $li.parent(),
                    level = $ul.dataSM('level');
                // if for some reason the parent item is not activated (e.g. this is an API call to activate the item), activate all parent items first
                if (level > 1 && (!this.activatedItems[level - 2] || this.activatedItems[level - 2][0] != $ul.dataSM('parent-a')[0])) {
                    var self = this;
                    $($ul.parentsUntil('[data-smartmenus-id]', 'ul').get().reverse()).add($ul).each(function () {
                        self.itemActivate($(this).dataSM('parent-a'));
                    });
                }
                // hide any visible deeper level sub menus
                if (this.visibleSubMenus.length > level) {
                    this.menuHideSubMenus(!this.activatedItems[level - 1] || this.activatedItems[level - 1][0] != $a[0] ? level - 1 : level);
                }
                // save new active item and sub menu for this level
                this.activatedItems[level - 1] = $a;
                this.visibleSubMenus[level - 1] = $ul;
                if (this.$root.triggerHandler('activate.smapi', $a[0]) === false) {
                    return;
                }
                // show the sub menu if this item has one
                var $sub = $li.dataSM('sub');
                if ($sub && (this.isTouchMode() || (!this.opts.showOnClick || this.clickActivated))) {
                    this.menuShow($sub);
                }
            },
            itemBlur: function (e) {
                var $a = $(e.currentTarget);
                if (!this.handleItemEvents($a)) {
                    return;
                }
                this.$root.triggerHandler('blur.smapi', $a[0]);
            },
            itemClick: function (e) {
                if (this.isTouchScrolling) {
                    this.isTouchScrolling = false;
                    e.stopPropagation();
                    return false;
                }
                var $a = $(e.currentTarget);
                if (!this.handleItemEvents($a)) {
                    return;
                }
                $a.removeDataSM('mousedown');
                if (this.$root.triggerHandler('click.smapi', $a[0]) === false) {
                    return false;
                }
                var $sub = $a.parent().dataSM('sub');
                if (this.isTouchMode()) {
                    // undo fix: prevent the address bar on iPhone from sliding down when expanding a sub menu
                    if ($a.dataSM('href')) {
                        $a.attr('href', $a.dataSM('href')).removeDataSM('href');
                    }
                    // if the sub is not visible
                    if ($sub && (!$sub.dataSM('shown-before') || !$sub.is(':visible'))) {
                        // try to activate the item and show the sub
                        this.itemActivate($a);
                        // if "itemActivate" showed the sub, prevent the click so that the link is not loaded
                        // if it couldn't show it, then the sub menus are disabled with an !important declaration (e.g. via mobile styles) so let the link get loaded
                        if ($sub.is(':visible')) {
                            return false;
                        }
                    }
                } else if (this.opts.showOnClick && $a.parent().parent().dataSM('level') == 1 && $sub) {
                    this.clickActivated = true;
                    this.menuShow($sub);
                    return false;
                }
                if ($a.hasClass('disabled')) {
                    return false;
                }
                if (this.$root.triggerHandler('select.smapi', $a[0]) === false) {
                    return false;
                }
            },
            itemDown: function (e) {
                var $a = $(e.currentTarget);
                if (!this.handleItemEvents($a)) {
                    return;
                }
                $a.dataSM('mousedown', true);
            },
            itemEnter: function (e) {
                var $a = $(e.currentTarget);
                if (!this.handleItemEvents($a)) {
                    return;
                }
                if (!this.isTouchMode()) {
                    if (this.showTimeout) {
                        clearTimeout(this.showTimeout);
                        this.showTimeout = 0;
                    }
                    var self = this;
                    this.showTimeout = setTimeout(function () {
                        self.itemActivate($a);
                    }, this.opts.showOnClick && $a.parent().parent().dataSM('level') == 1 ? 1 : this.opts.showTimeout);
                }
                this.$root.triggerHandler('mouseenter.smapi', $a[0]);
            },
            itemFocus: function (e) {
                var $a = $(e.currentTarget);
                if (!this.handleItemEvents($a)) {
                    return;
                }
                // fix (the mousedown check): in some browsers a tap/click produces consecutive focus + click events so we don't need to activate the item on focus
                if ((!this.isTouchMode() || !$a.dataSM('mousedown')) && (!this.activatedItems.length || this.activatedItems[this.activatedItems.length - 1][0] != $a[0])) {
                    this.itemActivate($a);
                }
                this.$root.triggerHandler('focus.smapi', $a[0]);
            },
            itemLeave: function (e) {
                var $a = $(e.currentTarget);
                if (!this.handleItemEvents($a)) {
                    return;
                }
                if (!this.isTouchMode()) {
                    if ($a[0].blur) {
                        $a[0].blur();
                    }
                    if (this.showTimeout) {
                        clearTimeout(this.showTimeout);
                        this.showTimeout = 0;
                    }
                }
                $a.removeDataSM('mousedown');
                this.$root.triggerHandler('mouseleave.smapi', $a[0]);
            },
            itemTouchEnd: function (e) {
                var $a = $(e.currentTarget);
                if (!this.handleItemEvents($a)) {
                    return;
                }
                // prevent the address bar on iPhone from sliding down when expanding a sub menu
                var $sub = $a.parent().dataSM('sub');
                if ($a.attr('href').charAt(0) !== '#' && $sub && (!$sub.dataSM('shown-before') || !$sub.is(':visible'))) {
                    $a.dataSM('href', $a.attr('href'));
                    $a.attr('href', '#');
                }
            },
            menuFixLayout: function ($ul) {
                // fixes a menu that is being shown for the first time
                if (!$ul.dataSM('shown-before')) {
                    $ul.hide().dataSM('shown-before', true);
                }
            },
            menuHide: function ($sub) {
                if (this.$root.triggerHandler('beforehide.smapi', $sub[0]) === false) {
                    return;
                }
                $sub.stop(true, true);
                if ($sub.is(':visible')) {
                    var complete = function () {
                        // unset z-index
                        $sub.css('z-index', '');
                    };
                    // if sub is collapsible (mobile view)
                    if (this.isCollapsible()) {
                        if (this.opts.collapsibleHideFunction) {
                            this.opts.collapsibleHideFunction.call(this, $sub, complete);
                        } else {
                            $sub.hide(this.opts.collapsibleHideDuration, complete);
                        }
                    } else {
                        if (this.opts.hideFunction) {
                            this.opts.hideFunction.call(this, $sub, complete);
                        } else {
                            $sub.hide(this.opts.hideDuration, complete);
                        }
                    }
                    // remove IE iframe shim
                    if ($sub.dataSM('ie-shim')) {
                        $sub.dataSM('ie-shim').remove();
                    }
                    // deactivate scrolling if it is activated for this sub
                    if ($sub.dataSM('scroll')) {
                        this.menuScrollStop($sub);
                        $sub.css({
                            'touch-action': '',
                            '-ms-touch-action': ''
                        })
                            .unbind('.smartmenus_scroll').removeDataSM('scroll').dataSM('scroll-arrows').hide();
                    }
                    // unhighlight parent item
                    $sub.dataSM('parent-a').removeClass('highlighted');
                    var level = $sub.dataSM('level');
                    this.activatedItems.splice(level - 1, 1);
                    this.visibleSubMenus.splice(level - 1, 1);
                    this.$root.triggerHandler('hide.smapi', $sub[0]);
                }
            },
            menuHideAll: function () {
                if (this.showTimeout) {
                    clearTimeout(this.showTimeout);
                    this.showTimeout = 0;
                }
                // hide all subs
                this.menuHideSubMenus();
                // hide root if it's popup
                if (this.opts.isPopup) {
                    this.$root.stop(true, true);
                    if (this.$root.is(':visible')) {
                        if (this.opts.hideFunction) {
                            this.opts.hideFunction.call(this, this.$root);
                        } else {
                            this.$root.hide(this.opts.hideDuration);
                        }
                        // remove IE iframe shim
                        if (this.$root.dataSM('ie-shim')) {
                            this.$root.dataSM('ie-shim').remove();
                        }
                    }
                }
                this.activatedItems = [];
                this.visibleSubMenus = [];
                this.clickActivated = false;
                // reset z-index increment
                this.zIndexInc = 0;
            },
            menuHideSubMenus: function (level) {
                if (!level) level = 0;
                for (var i = this.visibleSubMenus.length - 1; i > level; i--) {
                    this.menuHide(this.visibleSubMenus[i]);
                }
            },
            menuIframeShim: function ($ul) {
                // create iframe shim for the menu
                if (IE && this.opts.overlapControlsInIE && !$ul.dataSM('ie-shim')) {
                    $ul.dataSM('ie-shim', $('<iframe/>').attr({
                        src: 'javascript:0',
                        tabindex: -9
                    })
                        .css({
                            position: 'absolute',
                            top: 'auto',
                            left: '0',
                            opacity: 0,
                            border: '0'
                        }));
                }
            },
            menuInit: function ($ul) {
                if (!$ul.dataSM('in-mega')) {
                    this.subMenus.push($ul);
                    // mark UL's in mega drop downs (if any) so we can neglect them
                    if ($ul.hasClass('mega-menu')) {
                        $ul.find('ul').dataSM('in-mega', true);
                    }
                    // get level (much faster than, for example, using parentsUntil)
                    var level = 2,
                        par = $ul[0];
                    while ((par = par.parentNode.parentNode) != this.$root[0]) {
                        level++;
                    }
                    // cache stuff
                    $ul.dataSM('parent-a', $ul.prevAll('a').eq(-1))
                        .dataSM('level', level)
                        .parent().dataSM('sub', $ul);
                    // add sub indicator to parent item
                    if (this.opts.subIndicators) {
                        $ul.dataSM('parent-a').addClass('has-submenu')[this.opts.subIndicatorsPos](this.$subArrow.clone());
                    }
                }
            },
            menuPosition: function ($sub) {
                var $a = $sub.dataSM('parent-a'),
                    $ul = $sub.parent().parent(),
                    level = $sub.dataSM('level'),
                    subW = this.getWidth($sub),
                    subH = this.getHeight($sub),
                    itemOffset = $a.offset(),
                    itemX = itemOffset.left,
                    itemY = itemOffset.top,
                    itemW = this.getWidth($a),
                    itemH = this.getHeight($a),
                    $win = $(window),
                    winX = $win.scrollLeft(),
                    winY = $win.scrollTop(),
                    winW = this.getViewportWidth(),
                    winH = this.getViewportHeight(),
                    horizontalParent = $ul.hasClass('sm') && !$ul.hasClass('sm-vertical'),
                    subOffsetX = level == 2 ? this.opts.mainMenuSubOffsetX : this.opts.subMenusSubOffsetX,
                    subOffsetY = level == 2 ? this.opts.mainMenuSubOffsetY : this.opts.subMenusSubOffsetY,
                    x, y;
                if (horizontalParent) {
                    x = this.opts.rightToLeftSubMenus ? itemW - subW - subOffsetX : subOffsetX;
                    y = this.opts.bottomToTopSubMenus ? -subH - subOffsetY : itemH + subOffsetY;
                } else {
                    x = this.opts.rightToLeftSubMenus ? subOffsetX - subW : itemW - subOffsetX;
                    y = this.opts.bottomToTopSubMenus ? itemH - subOffsetY - subH : subOffsetY;
                }
                if (this.opts.keepInViewport && !this.isCollapsible()) {
                    var absX = itemX + x,
                        absY = itemY + y;
                    if (this.opts.rightToLeftSubMenus && absX < winX) {
                        x = horizontalParent ? winX - absX + x : itemW - subOffsetX;
                    } else if (!this.opts.rightToLeftSubMenus && absX + subW > winX + winW) {
                        x = horizontalParent ? winX + winW - subW - absX + x : subOffsetX - subW;
                    }
                    if (!horizontalParent) {
                        if (subH < winH && absY + subH > winY + winH) {
                            y += winY + winH - subH - absY;
                        } else if (subH >= winH || absY < winY) {
                            y += winY - absY;
                        }
                    }
                    // do we need scrolling?
                    // 0.49 used for better precision when dealing with float values
                    if (horizontalParent && (absY + subH > winY + winH + 0.49 || absY < winY) || !horizontalParent && subH > winH + 0.49) {
                        var self = this;
                        if (!$sub.dataSM('scroll-arrows')) {
                            $sub.dataSM('scroll-arrows', $([$('<span class="scroll-up"><span class="scroll-up-arrow"></span></span>')[0], $('<span class="scroll-down"><span class="scroll-down-arrow"></span></span>')[0]])
                                .bind({
                                    mouseenter: function () {
                                        $sub.dataSM('scroll').up = $(this).hasClass('scroll-up');
                                        self.menuScroll($sub);
                                    },
                                    mouseleave: function (e) {
                                        self.menuScrollStop($sub);
                                        self.menuScrollOut($sub, e);
                                    },
                                    'mousewheel DOMMouseScroll': function (e) {
                                        e.preventDefault();
                                    }
                                })
                                .insertAfter($sub));
                        }
                        // bind scroll events and save scroll data for this sub
                        var eNS = '.smartmenus_scroll';
                        $sub.dataSM('scroll', {
                            step: 1,
                            // cache stuff for faster recalcs later
                            itemH: itemH,
                            subH: subH,
                            arrowDownH: this.getHeight($sub.dataSM('scroll-arrows').eq(1))
                        })
                            .bind(getEventsNS([
                            ['mouseover', function (e) {
                                self.menuScrollOver($sub, e);
                            }],
                            ['mouseout', function (e) {
                                self.menuScrollOut($sub, e);
                            }],
                            ['mousewheel DOMMouseScroll', function (e) {
                                self.menuScrollMousewheel($sub, e);
                            }]
                            ], eNS))
                            .dataSM('scroll-arrows').css({
                                top: 'auto',
                                left: '0',
                                marginLeft: x + (parseInt($sub.css('border-left-width')) || 0),
                                width: subW - (parseInt($sub.css('border-left-width')) || 0) - (parseInt($sub.css('border-right-width')) || 0),
                                zIndex: $sub.css('z-index')
                            })
                            .eq(horizontalParent && this.opts.bottomToTopSubMenus ? 0 : 1).show();
                        // when a menu tree is fixed positioned we allow scrolling via touch too
                        // since there is no other way to access such long sub menus if no mouse is present
                        if (this.isFixed()) {
                            $sub.css({
                                'touch-action': 'none',
                                '-ms-touch-action': 'none'
                            })
                                .bind(getEventsNS([
                                [touchEvents() ? 'touchstart touchmove touchend' : 'pointerdown pointermove pointerup MSPointerDown MSPointerMove MSPointerUp', function (e) {
                                    self.menuScrollTouch($sub, e);
                                }]
                                ], eNS));
                        }
                    }
                }
                $sub.css({
                    top: 'auto',
                    left: '0',
                    marginLeft: x,
                    marginTop: y - itemH
                });
                // IE iframe shim
                this.menuIframeShim($sub);
                if ($sub.dataSM('ie-shim')) {
                    $sub.dataSM('ie-shim').css({
                        zIndex: $sub.css('z-index'),
                        width: subW,
                        height: subH,
                        marginLeft: x,
                        marginTop: y - itemH
                    });
                }
            },
            menuScroll: function ($sub, once, step) {
                var data = $sub.dataSM('scroll'),
                    $arrows = $sub.dataSM('scroll-arrows'),
                    y = parseFloat($sub.css('margin-top')),
                    end = data.up ? data.upEnd : data.downEnd,
                    diff;
                if (!once && data.velocity) {
                    data.velocity *= 0.9;
                    diff = data.velocity;
                    if (diff < 0.5) {
                        this.menuScrollStop($sub);
                        return;
                    }
                } else {
                    diff = step || (once || !this.opts.scrollAccelerate ? this.opts.scrollStep : Math.floor(data.step));
                }
                // hide any visible deeper level sub menus
                var level = $sub.dataSM('level');
                if (this.visibleSubMenus.length > level) {
                    this.menuHideSubMenus(level - 1);
                }
                var newY = data.up && end <= y || !data.up && end >= y ? y : (Math.abs(end - y) > diff ? y + (data.up ? diff : -diff) : end);
                $sub.add($sub.dataSM('ie-shim')).css('margin-top', newY);
                // show opposite arrow if appropriate
                if (mouse && (data.up && newY > data.downEnd || !data.up && newY < data.upEnd)) {
                    $arrows.eq(data.up ? 1 : 0).show();
                }
                // if we've reached the end
                if (newY == end) {
                    if (mouse) {
                        $arrows.eq(data.up ? 0 : 1).hide();
                    }
                    this.menuScrollStop($sub);
                } else if (!once) {
                    if (this.opts.scrollAccelerate && data.step < this.opts.scrollStep) {
                        data.step += 0.5;
                    }
                    var self = this;
                    this.scrollTimeout = setTimeout(function () {
                        self.menuScroll($sub);
                    }, this.opts.scrollInterval);
                }
            },
            menuScrollMousewheel: function ($sub, e) {
                if (this.getClosestMenu(e.target) == $sub[0]) {
                    e = e.originalEvent;
                    var up = (e.wheelDelta || -e.detail) > 0;
                    if ($sub.dataSM('scroll-arrows').eq(up ? 0 : 1).is(':visible')) {
                        $sub.dataSM('scroll').up = up;
                        this.menuScroll($sub, true);
                    }
                }
                e.preventDefault();
            },
            menuScrollOut: function ($sub, e) {
                if (mouse) {
                    if (!/^scroll-(up|down)/.test((e.relatedTarget || '').className) && ($sub[0] != e.relatedTarget && !$.contains($sub[0], e.relatedTarget) || this.getClosestMenu(e.relatedTarget) != $sub[0])) {
                        $sub.dataSM('scroll-arrows').css('visibility', 'hidden');
                    }
                }
            },
            menuScrollOver: function ($sub, e) {
                if (mouse) {
                    if (!/^scroll-(up|down)/.test(e.target.className) && this.getClosestMenu(e.target) == $sub[0]) {
                        this.menuScrollRefreshData($sub);
                        var data = $sub.dataSM('scroll');
                        $sub.dataSM('scroll-arrows').eq(0).css('margin-top', data.upEnd).end()
                            .eq(1).css('margin-top', data.downEnd + data.subH - data.arrowDownH).end()
                            .css('visibility', 'visible');
                    }
                }
            },
            menuScrollRefreshData: function ($sub) {
                var data = $sub.dataSM('scroll'),
                    $win = $(window),
                    vportY = $win.scrollTop() - $sub.dataSM('parent-a').offset().top - data.itemH;
                $.extend(data, {
                    upEnd: vportY,
                    downEnd: vportY + this.getViewportHeight() - data.subH
                });
            },
            menuScrollStop: function ($sub) {
                if (this.scrollTimeout) {
                    clearTimeout(this.scrollTimeout);
                    this.scrollTimeout = 0;
                    $.extend($sub.dataSM('scroll'), {
                        step: 1,
                        velocity: 0
                    });
                    return true;
                }
            },
            menuScrollTouch: function ($sub, e) {
                e = e.originalEvent;
                if (isTouchEvent(e)) {
                    var touchPoint = this.getTouchPoint(e);
                    // neglect event if we touched a visible deeper level sub menu
                    if (this.getClosestMenu(touchPoint.target) == $sub[0]) {
                        var data = $sub.dataSM('scroll');
                        if (/(start|down)$/i.test(e.type)) {
                            if (this.menuScrollStop($sub)) {
                                // if we were scrolling, just stop and don't activate any link on the first touch
                                e.preventDefault();
                                this.isTouchScrolling = true;
                            } else {
                                this.isTouchScrolling = false;
                            }
                            // update scroll data since the user might have zoomed, etc.
                            this.menuScrollRefreshData($sub);
                            // extend it with the touch properties
                            $.extend(data, {
                                touchY: touchPoint.pageY,
                                touchTimestamp: e.timeStamp,
                                velocity: 0
                            });
                        } else if (/move$/i.test(e.type)) {
                            var prevY = data.touchY;
                            if (prevY !== undefined && prevY != touchPoint.pageY) {
                                this.isTouchScrolling = true;
                                $.extend(data, {
                                    up: prevY < touchPoint.pageY,
                                    touchY: touchPoint.pageY,
                                    touchTimestamp: e.timeStamp,
                                    velocity: data.velocity + Math.abs(touchPoint.pageY - prevY) * 0.5
                                });
                                this.menuScroll($sub, true, Math.abs(data.touchY - prevY));
                            }
                            e.preventDefault();
                        } else { // touchend/pointerup
                            if (data.touchY !== undefined) {
                                // check if we need to scroll
                                if (e.timeStamp - data.touchTimestamp < 120 && data.velocity > 0) {
                                    data.velocity *= 0.5;
                                    this.menuScrollStop($sub);
                                    this.menuScroll($sub);
                                    e.preventDefault();
                                }
                                delete data.touchY;
                            }
                        }
                    }
                }
            },
            menuShow: function ($sub) {
                if (!$sub.dataSM('beforefirstshowfired')) {
                    $sub.dataSM('beforefirstshowfired', true);
                    if (this.$root.triggerHandler('beforefirstshow.smapi', $sub[0]) === false) {
                        return;
                    }
                }
                if (this.$root.triggerHandler('beforeshow.smapi', $sub[0]) === false) {
                    return;
                }
                this.menuFixLayout($sub);
                $sub.stop(true, true);
                if (!$sub.is(':visible')) {
                    // set z-index
                    $sub.css('z-index', this.zIndexInc = (this.zIndexInc || this.getStartZIndex()) + 1);
                    // highlight parent item
                    if (this.opts.keepHighlighted || this.isCollapsible()) {
                        $sub.dataSM('parent-a').addClass('highlighted');
                    }
                    // min/max-width fix - no way to rely purely on CSS as all UL's are nested
                    if (this.opts.subMenusMinWidth || this.opts.subMenusMaxWidth) {
                        $sub.css({
                            width: 'auto',
                            minWidth: '',
                            maxWidth: ''
                        }).addClass('sm-nowrap');
                        if (this.opts.subMenusMinWidth) {
                            $sub.css('min-width', this.opts.subMenusMinWidth);
                        }
                        if (this.opts.subMenusMaxWidth) {
                            var noMaxWidth = this.getWidth($sub);
                            $sub.css('max-width', this.opts.subMenusMaxWidth);
                            if (noMaxWidth > this.getWidth($sub)) {
                                $sub.removeClass('sm-nowrap').css('width', this.opts.subMenusMaxWidth);
                            }
                        }
                    }
                    this.menuPosition($sub);
                    // insert IE iframe shim
                    if ($sub.dataSM('ie-shim')) {
                        $sub.dataSM('ie-shim').insertBefore($sub);
                    }
                    var complete = function () {
                        // fix: "overflow: hidden;" is not reset on animation complete in jQuery < 1.9.0 in Chrome when global "box-sizing: border-box;" is used
                        $sub.css('overflow', '');
                    };
                    // if sub is collapsible (mobile view)
                    if (this.isCollapsible()) {
                        if (this.opts.collapsibleShowFunction) {
                            this.opts.collapsibleShowFunction.call(this, $sub, complete);
                        } else {
                            $sub.show(this.opts.collapsibleShowDuration, complete);
                        }
                    } else {
                        if (this.opts.showFunction) {
                            this.opts.showFunction.call(this, $sub, complete);
                        } else {
                            $sub.show(this.opts.showDuration, complete);
                        }
                    }
                    // save new sub menu for this level
                    this.visibleSubMenus[$sub.dataSM('level') - 1] = $sub;
                    this.$root.triggerHandler('show.smapi', $sub[0]);
                }
            },
            popupHide: function (noHideTimeout) {
                if (this.hideTimeout) {
                    clearTimeout(this.hideTimeout);
                    this.hideTimeout = 0;
                }
                var self = this;
                this.hideTimeout = setTimeout(function () {
                    self.menuHideAll();
                }, noHideTimeout ? 1 : this.opts.hideTimeout);
            },
            popupShow: function (left, top) {
                if (!this.opts.isPopup) {
                    alert('SmartMenus jQuery Error:\n\nIf you want to show this menu via the "popupShow" method, set the isPopup:true option.');
                    return;
                }
                if (this.hideTimeout) {
                    clearTimeout(this.hideTimeout);
                    this.hideTimeout = 0;
                }
                this.menuFixLayout(this.$root);
                this.$root.stop(true, true);
                if (!this.$root.is(':visible')) {
                    this.$root.css({
                        left: left,
                        top: top
                    });
                    // IE iframe shim
                    this.menuIframeShim(this.$root);
                    if (this.$root.dataSM('ie-shim')) {
                        this.$root.dataSM('ie-shim').css({
                            zIndex: this.$root.css('z-index'),
                            width: this.getWidth(this.$root),
                            height: this.getHeight(this.$root),
                            left: left,
                            top: top
                        }).insertBefore(this.$root);
                    }
                    // show menu
                    var self = this,
                        complete = function () {
                            self.$root.css('overflow', '');
                        };
                    if (this.opts.showFunction) {
                        this.opts.showFunction.call(this, this.$root, complete);
                    } else {
                        this.$root.show(this.opts.showDuration, complete);
                    }
                    this.visibleSubMenus[0] = this.$root;
                }
            },
            refresh: function () {
                this.menuHideAll();
                this.$root.find('ul').each(function () {
                    var $this = $(this);
                    if ($this.dataSM('scroll-arrows')) {
                        $this.dataSM('scroll-arrows').remove();
                    }
                })
                    .removeDataSM('in-mega')
                    .removeDataSM('shown-before')
                    .removeDataSM('ie-shim')
                    .removeDataSM('scroll-arrows')
                    .removeDataSM('parent-a')
                    .removeDataSM('level')
                    .removeDataSM('beforefirstshowfired');
                this.$root.find('a.has-submenu').removeClass('has-submenu')
                    .parent().removeDataSM('sub');
                if (this.opts.subIndicators) {
                    this.$root.find('span.sub-arrow').remove();
                }
                if (this.opts.markCurrentItem) {
                    this.$root.find('a.current').removeClass('current');
                }
                this.subMenus = [];
                this.init(true);
            },
            rootOut: function (e) {
                if (!this.handleEvents() || this.isTouchMode() || e.target == this.$root[0]) {
                    return;
                }
                if (this.hideTimeout) {
                    clearTimeout(this.hideTimeout);
                    this.hideTimeout = 0;
                }
                if (!this.opts.showOnClick || !this.opts.hideOnClick) {
                    var self = this;
                    this.hideTimeout = setTimeout(function () {
                        self.menuHideAll();
                    }, this.opts.hideTimeout);
                }
            },
            rootOver: function (e) {
                if (!this.handleEvents() || this.isTouchMode() || e.target == this.$root[0]) {
                    return;
                }
                if (this.hideTimeout) {
                    clearTimeout(this.hideTimeout);
                    this.hideTimeout = 0;
                }
            },
            winResize: function (e) {
                if (!this.handleEvents()) {
                    // we still need to resize the disable overlay if it's visible
                    if (this.$disableOverlay) {
                        var pos = this.$root.offset();
                        this.$disableOverlay.css({
                            top: pos.top,
                            left: pos.left,
                            width: this.$root.outerWidth(),
                            height: this.$root.outerHeight()
                        });
                    }
                    return;
                }
                // hide sub menus on resize - on mobile do it only on orientation change
                if (!this.isCollapsible() && (!('onorientationchange' in window) || e.type == 'orientationchange')) {
                    if (this.activatedItems.length) {
                        this.activatedItems[this.activatedItems.length - 1][0].blur();
                    }
                    this.menuHideAll();
                }
            }
        }
    });

    $.fn.dataSM = function (key, val) {
        if (val) {
            return this.data(key + '_smartmenus', val);
        }
        return this.data(key + '_smartmenus');
    }

    $.fn.removeDataSM = function (key) {
        return this.removeData(key + '_smartmenus');
    }

    $.fn.smartmenus = function (options) {
        if (typeof options == 'string') {
            var args = arguments,
                method = options;
            Array.prototype.shift.call(args);
            return this.each(function () {
                var smartmenus = $(this).data('smartmenus');
                if (smartmenus && smartmenus[method]) {
                    smartmenus[method].apply(smartmenus, args);
                }
            });
        }
        var opts = $.extend({}, $.fn.smartmenus.defaults, options);
        return this.each(function () {
            new $.SmartMenus(this, opts);
        });
    }

    // default settings
    $.fn.smartmenus.defaults = {
        isPopup: false, // is this a popup menu (can be shown via the popupShow/popupHide methods) or a permanent menu bar
        mainMenuSubOffsetX: 0, // pixels offset from default position
        mainMenuSubOffsetY: 0, // pixels offset from default position
        subMenusSubOffsetX: 0, // pixels offset from default position
        subMenusSubOffsetY: 0, // pixels offset from default position
        subMenusMinWidth: '10em', // min-width for the sub menus (any CSS unit) - if set, the fixed width set in CSS will be ignored
        subMenusMaxWidth: '20em', // max-width for the sub menus (any CSS unit) - if set, the fixed width set in CSS will be ignored
        subIndicators: true, // create sub menu indicators - creates a SPAN and inserts it in the A
        subIndicatorsPos: 'prepend', // position of the SPAN relative to the menu item content ('prepend', 'append')
        subIndicatorsText: '+', // [optionally] add text in the SPAN (e.g. '+') (you may want to check the CSS for the sub indicators too)
        scrollStep: 30, // pixels step when scrolling long sub menus that do not fit in the viewport height
        scrollInterval: 30, // interval between each scrolling step
        scrollAccelerate: true, // accelerate scrolling or use a fixed step
        showTimeout: 250, // timeout before showing the sub menus
        hideTimeout: 500, // timeout before hiding the sub menus
        showDuration: 0, // duration for show animation - set to 0 for no animation - matters only if showFunction:null
        showFunction: null, // custom function to use when showing a sub menu (the default is the jQuery 'show')
        // don't forget to call complete() at the end of whatever you do
        // e.g.: function($ul, complete) { $ul.fadeIn(250, complete); }
        hideDuration: 0, // duration for hide animation - set to 0 for no animation - matters only if hideFunction:null
        hideFunction: function ($ul, complete) {
            $ul.fadeOut(200, complete);
        }, // custom function to use when hiding a sub menu (the default is the jQuery 'hide')
        // don't forget to call complete() at the end of whatever you do
        // e.g.: function($ul, complete) { $ul.fadeOut(250, complete); }
        collapsibleShowDuration: 0, // duration for show animation for collapsible sub menus - matters only if collapsibleShowFunction:null
        collapsibleShowFunction: function ($ul, complete) {
            $ul.slideDown(200, complete);
        }, // custom function to use when showing a collapsible sub menu
        // (i.e. when mobile styles are used to make the sub menus collapsible)
        collapsibleHideDuration: 0, // duration for hide animation for collapsible sub menus - matters only if collapsibleHideFunction:null
        collapsibleHideFunction: function ($ul, complete) {
            $ul.slideUp(200, complete);
        }, // custom function to use when hiding a collapsible sub menu
        // (i.e. when mobile styles are used to make the sub menus collapsible)
        showOnClick: false, // show the first-level sub menus onclick instead of onmouseover (matters only for mouse input)
        hideOnClick: true, // hide the sub menus on click/tap anywhere on the page
        keepInViewport: true, // reposition the sub menus if needed to make sure they always appear inside the viewport
        keepHighlighted: true, // keep all ancestor items of the current sub menu highlighted (adds the 'highlighted' class to the A's)
        markCurrentItem: false, // automatically add the 'current' class to the A element of the item linking to the current URL
        markCurrentTree: true, // add the 'current' class also to the A elements of all ancestor items of the current item
        rightToLeftSubMenus: false, // right to left display of the sub menus (check the CSS for the sub indicators' position)
        bottomToTopSubMenus: false, // bottom to top display of the sub menus
        overlapControlsInIE: true // make sure sub menus appear on top of special OS controls in IE (i.e. SELECT, OBJECT, EMBED, etc.)
    };

})(jQuery);


/*
 * SmartMenus jQuery Bootstrap Addon - v0.1.1
 * http://www.smartmenus.org/
 *
 * Copyright 2014 Vasil Dinkov, Vadikom Web Ltd.
 * http://vadikom.com/
 *
 * Released under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

(function ($) {

    // init ondomready
    $(function () {

        // init all menus
        $('ul.navbar-nav').each(function () {
            var $this = $(this);
            $this.addClass('sm').smartmenus({

                // these are some good default options that should work for all
                // you can, of course, tweak these as you like
                subMenusSubOffsetX: 2,
                subMenusSubOffsetY: -6,
                subIndicatorsPos: 'append',
                subIndicatorsText: '...',
                collapsibleShowFunction: null,
                collapsibleHideFunction: null,
                clickActivated:true,
                rightToLeftSubMenus: $this.hasClass('navbar-right'),
                bottomToTopSubMenus: $this.closest('.navbar').hasClass('navbar-fixed-bottom')
            })
            // set Bootstrap's "active" class to SmartMenus "current" items (should someone decide to enable markCurrentItem: true)
            .find('a.current').parent().addClass('active');
        })
            .bind({
                // set/unset proper Bootstrap classes for some menu elements
                'show.smapi': function (e, menu) {
                    var $menu = $(menu),
                        $scrollArrows = $menu.dataSM('scroll-arrows'),
                        obj = $(this).data('smartmenus');
                    if ($scrollArrows) {
                        // they inherit border-color from body, so we can use its background-color too
                        $scrollArrows.css('background-color', $(document.body).css('background-color'));
                    }
                    $menu.parent().addClass('open' + (obj.isCollapsible() ? ' collapsible' : ''));
                },
                'hide.smapi': function (e, menu) {
                    $(menu).parent().removeClass('open collapsible');
                },
                // click the parent item to toggle the sub menus (and reset deeper levels and other branches on click)
                'click.smapi': function (e, item) {
                    var obj = $(this).data('smartmenus');
                    if (obj.isCollapsible()) {
                        var $item = $(item),
                            $sub = $item.parent().dataSM('sub');
                        if ($sub && $sub.dataSM('shown-before') && $sub.is(':visible')) {
                            obj.itemActivate($item);
                            obj.menuHide($sub);
                            if ($item.attr("href") && $item.attr("href").trim() != "" && $item.attr("href").trim() != "#") {
                                window.location.href = $item.attr("href");
                            }
                            return false;
                        }
                    }
                }
            });

    });

    // fix collapsible menu detection for Bootstrap 3
    $.SmartMenus.prototype.isCollapsible = function () {
        return this.$firstLink.parent().css('float') != 'left';
    };

})(jQuery);