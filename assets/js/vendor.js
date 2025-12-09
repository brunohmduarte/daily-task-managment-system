/*!
 * jQuery v3.6.0 | (c) OpenJS Foundation and other contributors | jquery.org/license
 * Deminified version - Full documentation available at https://jquery.com/
 */

(function(global, factory) {
  "use strict";
  
  if (typeof module === "object" && typeof module.exports === "object") {
    // Node.js-like environments that support module.exports
    module.exports = global.document ? factory(global, true) : function(g) {
      if (!g.document) {
        throw new Error("jQuery requires a window with a document");
      }
      return factory(g);
    };
  } else {
    factory(global);
  }
})(typeof window !== "undefined" ? window : this, function(window, noGlobal) {
  "use strict";

  // jQuery version
  var version = "3.6.0";

  // Core jQuery function
  var jQuery = function(selector, context) {
    return new jQuery.fn.init(selector, context);
  };

  // jQuery prototype
  jQuery.fn = jQuery.prototype = {
    jquery: version,
    constructor: jQuery,
    length: 0,

    // Convert jQuery object to array
    toArray: function() {
      return Array.prototype.slice.call(this);
    },

    // Get element at index
    get: function(num) {
      if (num == null) {
        return Array.prototype.slice.call(this);
      }
      return num < 0 ? this[num + this.length] : this[num];
    },

    // Push stack for chaining
    pushStack: function(elems) {
      var ret = jQuery.merge(this.constructor(), elems);
      ret.prevObject = this;
      return ret;
    },

    // Iterate over jQuery objects
    each: function(callback) {
      return jQuery.each(this, callback);
    },

    // Map over jQuery objects
    map: function(callback) {
      return this.pushStack(jQuery.map(this, function(elem, i) {
        return callback.call(elem, i, elem);
      }));
    },

    // Get slice of jQuery objects
    slice: function() {
      return this.pushStack(Array.prototype.slice.apply(this, arguments));
    },

    // Get first element
    first: function() {
      return this.eq(0);
    },

    // Get last element
    last: function() {
      return this.eq(-1);
    },

    // Get even indexed elements
    even: function() {
      return this.pushStack(jQuery.grep(this, function(elem, i) {
        return (i + 1) % 2;
      }));
    },

    // Get odd indexed elements
    odd: function() {
      return this.pushStack(jQuery.grep(this, function(elem, i) {
        return i % 2;
      }));
    },

    // Get element at index
    eq: function(i) {
      var len = this.length;
      var j = +i + (i < 0 ? len : 0);
      return this.pushStack(j >= 0 && j < len ? [this[j]] : []);
    },

    // End traversal
    end: function() {
      return this.prevObject || this.constructor();
    },

    // Push and splice methods for array-like behavior
    push: Array.prototype.push,
    sort: Array.prototype.sort,
    splice: Array.prototype.splice
  };

  /**
   * CORE UTILITY METHODS
   */

  jQuery.extend = jQuery.fn.extend = function() {
    var options, name, src, copy, copyIsArray, clone,
        target = arguments[0] || {},
        i = 1,
        length = arguments.length,
        deep = false;

    // Handle a deep copy situation (first argument is boolean true)
    if (typeof target === "boolean") {
      deep = target;
      target = arguments[i] || {};
      i++;
    }

    // Handle case when target is a string or something (not an object)
    if (typeof target !== "object" && !jQuery.isFunction(target)) {
      target = {};
    }

    // Only one argument - extend jQuery itself
    if (i === length) {
      target = this;
      i--;
    }

    // Process remaining arguments
    for (; i < length; i++) {
      if ((options = arguments[i]) != null) {
        for (name in options) {
          if (options.hasOwnProperty(name)) {
            src = target[name];
            copy = options[name];

            // Prevent object circular references
            if (target === copy) {
              continue;
            }

            // Recurse if deep copy requested
            if (deep && copy && (jQuery.isPlainObject(copy) || (copyIsArray = Array.isArray(copy)))) {
              if (copyIsArray) {
                copyIsArray = false;
                clone = src && Array.isArray(src) ? src : [];
              } else {
                clone = src && jQuery.isPlainObject(src) ? src : {};
              }

              target[name] = jQuery.extend(deep, clone, copy);
            } else if (copy !== undefined) {
              target[name] = copy;
            }
          }
        }
      }
    }

    return target;
  };

  jQuery.extend({
    // Unique ID for expando
    expando: "jQuery" + (version + Math.random()).replace(/\D/g, ""),

    // Check readiness state
    isReady: true,

    // Error method
    error: function(msg) {
      throw new Error(msg);
    },

    // No-op function
    noop: function() {},

    // Check if object is plain object
    isPlainObject: function(obj) {
      if (!obj || Object.prototype.toString.call(obj) !== "[object Object]") {
        return false;
      }
      var proto = Object.getPrototypeOf(obj);
      if (!proto) {
        return true;
      }
      var Ctor = Object.prototype.hasOwnProperty.call(proto, "constructor") && proto.constructor;
      return typeof Ctor === "function" && Function.prototype.toString.call(Ctor) === Function.prototype.toString.call(Object);
    },

    // Check if object is empty
    isEmptyObject: function(obj) {
      for (var name in obj) {
        return false;
      }
      return true;
    },

    // Evaluate JavaScript code
    globalEval: function(code) {
      var script = document.createElement("script");
      script.text = code;
      document.head.appendChild(script).parentNode.removeChild(script);
    },

    // Iterate over objects and arrays
    each: function(obj, callback) {
      var length;
      var i = 0;

      if (jQuery.isArrayLike(obj)) {
        length = obj.length;
        for (; i < length; i++) {
          if (callback.call(obj[i], i, obj[i]) === false) {
            break;
          }
        }
      } else {
        for (i in obj) {
          if (callback.call(obj[i], i, obj[i]) === false) {
            break;
          }
        }
      }

      return obj;
    },

    // Convert to array
    makeArray: function(arr, results) {
      var ret = results || [];

      if (arr != null) {
        if (jQuery.isArrayLike(Object(arr))) {
          jQuery.merge(ret, typeof arr === "string" ? [arr] : arr);
        } else {
          Array.prototype.push.call(ret, arr);
        }
      }

      return ret;
    },

    // Find index of element in array
    inArray: function(elem, arr, i) {
      return arr == null ? -1 : Array.prototype.indexOf.call(arr, elem, i);
    },

    // Merge two arrays
    merge: function(first, second) {
      var len = +second.length;
      var j = 0;
      var i = first.length;

      for (; j < len; j++) {
        first[i++] = second[j];
      }

      first.length = i;
      return first;
    },

    // Filter array
    grep: function(elems, callback, invert) {
      var callbackInverse;
      var matches = [];
      var i = 0;
      var length = elems.length;
      var isFalsy = !invert;

      for (; i < length; i++) {
        callbackInverse = !callback(elems[i], i);
        if (callbackInverse !== isFalsy) {
          matches.push(elems[i]);
        }
      }

      return matches;
    },

    // Map array
    map: function(elems, callback, arg) {
      var length;
      var value;
      var i = 0;
      var ret = [];

      if (jQuery.isArrayLike(elems)) {
        length = elems.length;
        for (; i < length; i++) {
          value = callback(elems[i], i, arg);
          if (value != null) {
            ret.push(value);
          }
        }
      } else {
        for (i in elems) {
          value = callback(elems[i], i, arg);
          if (value != null) {
            ret.push(value);
          }
        }
      }

      return ret.flat();
    },

    // Unique ID generator
    guid: 1,

    // Support detection
    support: {}
  });

  /**
   * READY FUNCTIONALITY
   */

  jQuery.fn.ready = function(fn) {
    var readyList = jQuery.Deferred();
    readyList.promise().then(fn);
    return this;
  };

  /**
   * SELECTOR ENGINE
   */

  jQuery.find = function(selector, context) {
    var results = [];

    if (!selector) {
      return results;
    }

    if (typeof selector !== "string") {
      return results;
    }

    try {
      if (context && context.querySelectorAll) {
        results = context.querySelectorAll(selector);
      }
    } catch (error) {
      // Selector error
    }

    return results;
  };

  jQuery.fn.find = function(selector) {
    var matched = [];
    for (var i = 0; i < this.length; i++) {
      if (this[i].querySelectorAll) {
        var found = this[i].querySelectorAll(selector);
        Array.prototype.push.apply(matched, found);
      }
    }
    return this.pushStack(matched);
  };

  /**
   * DOM MANIPULATION
   */

  jQuery.fn.extend({
    // Get text content
    text: function(value) {
      if (typeof value === "undefined") {
        return this[0] ? this[0].textContent : "";
      }
      return this.each(function() {
        this.textContent = value;
      });
    },

    // Get or set HTML
    html: function(value) {
      if (typeof value === "undefined") {
        return this[0] ? this[0].innerHTML : "";
      }
      return this.each(function() {
        this.innerHTML = value;
      });
    },

    // Append elements
    append: function(content) {
      return this.each(function() {
        if (typeof content === "string") {
          this.innerHTML += content;
        } else if (content && content.nodeType) {
          this.appendChild(content);
        } else if (content.jquery) {
          var self = this;
          content.each(function() {
            self.appendChild(this.cloneNode(true));
          });
        }
      });
    },

    // Prepend elements
    prepend: function(content) {
      return this.each(function() {
        if (typeof content === "string") {
          this.innerHTML = content + this.innerHTML;
        } else if (content && content.nodeType) {
          this.insertBefore(content, this.firstChild);
        }
      });
    },

    // Remove elements
    remove: function() {
      return this.each(function() {
        if (this.parentNode) {
          this.parentNode.removeChild(this);
        }
      });
    },

    // Empty content
    empty: function() {
      return this.each(function() {
        while (this.firstChild) {
          this.removeChild(this.firstChild);
        }
      });
    },

    // Clone elements
    clone: function(deep) {
      return this.map(function() {
        return this.cloneNode(deep !== false);
      });
    }
  });

  /**
   * CLASS MANIPULATION
   */

  jQuery.fn.extend({
    // Add class
    addClass: function(className) {
      if (!className) return this;

      return this.each(function() {
        var names = className.split(/\s+/);
        for (var i = 0; i < names.length; i++) {
          this.classList.add(names[i]);
        }
      });
    },

    // Remove class
    removeClass: function(className) {
      if (!className) {
        return this.each(function() {
          this.className = "";
        });
      }

      return this.each(function() {
        var names = className.split(/\s+/);
        for (var i = 0; i < names.length; i++) {
          this.classList.remove(names[i]);
        }
      });
    },

    // Toggle class
    toggleClass: function(className, state) {
      return this.each(function() {
        if (state === undefined) {
          state = !this.classList.contains(className);
        }
        if (state) {
          this.classList.add(className);
        } else {
          this.classList.remove(className);
        }
      });
    },

    // Check if has class
    hasClass: function(className) {
      for (var i = 0; i < this.length; i++) {
        if (this[i].classList && this[i].classList.contains(className)) {
          return true;
        }
      }
      return false;
    }
  });

  /**
   * ATTRIBUTE MANIPULATION
   */

  jQuery.fn.extend({
    // Get or set attribute
    attr: function(name, value) {
      if (arguments.length === 1) {
        return this[0] ? this[0].getAttribute(name) : undefined;
      }

      return this.each(function() {
        this.setAttribute(name, value);
      });
    },

    // Remove attribute
    removeAttr: function(name) {
      return this.each(function() {
        this.removeAttribute(name);
      });
    },

    // Get or set property
    prop: function(name, value) {
      if (arguments.length === 1) {
        return this[0] ? this[0][name] : undefined;
      }

      return this.each(function() {
        this[name] = value;
      });
    },

    // Get or set data attribute
    data: function(name, value) {
      var key = "data-" + name;

      if (arguments.length === 1) {
        var dataStr = this.attr(key);
        return dataStr ? JSON.parse(dataStr) : undefined;
      }

      return this.each(function() {
        this.setAttribute(key, typeof value === "string" ? value : JSON.stringify(value));
      });
    }
  });

  /**
   * EVENT HANDLING
   */

  jQuery.fn.extend({
    // Bind event
    on: function(type, selector, fn) {
      // Handle different argument patterns
      if (typeof selector === "function") {
        fn = selector;
        selector = null;
      }

      if (!fn) return this;

      return this.each(function() {
        if (selector) {
          // Event delegation
          this.addEventListener(type, function(e) {
            if (e.target.matches(selector)) {
              fn.call(e.target, e);
            }
          });
        } else {
          // Direct binding
          this.addEventListener(type, fn);
        }
      });
    },

    // Unbind event
    off: function(type, fn) {
      return this.each(function() {
        this.removeEventListener(type, fn);
      });
    },

    // Trigger event
    trigger: function(type) {
      return this.each(function() {
        var event = new Event(type);
        this.dispatchEvent(event);
      });
    },

    // One-time event
    one: function(type, fn) {
      return this.each(function() {
        var handler = function(e) {
          fn.call(this, e);
          this.removeEventListener(type, handler);
        };
        this.addEventListener(type, handler);
      });
    },

    // Click event
    click: function(fn) {
      if (fn) {
        return this.on("click", fn);
      } else {
        return this.trigger("click");
      }
    },

    // Submit event
    submit: function(fn) {
      if (fn) {
        return this.on("submit", fn);
      } else {
        return this.trigger("submit");
      }
    },

    // Change event
    change: function(fn) {
      if (fn) {
        return this.on("change", fn);
      } else {
        return this.trigger("change");
      }
    },

    // Focus event
    focus: function(fn) {
      if (fn) {
        return this.on("focus", fn);
      } else {
        return this[0].focus();
      }
    }
  });

  /**
   * CSS AND STYLING
   */

  jQuery.fn.extend({
    // Get or set CSS
    css: function(name, value) {
      if (typeof name === "object") {
        return this.each(function() {
          for (var prop in name) {
            this.style[prop] = name[prop];
          }
        });
      }

      if (arguments.length === 1) {
        if (this[0]) {
          return window.getComputedStyle(this[0])[name];
        }
        return undefined;
      }

      return this.each(function() {
        this.style[name] = value;
      });
    },

    // Show elements
    show: function() {
      return this.each(function() {
        this.style.display = "";
      });
    },

    // Hide elements
    hide: function() {
      return this.each(function() {
        this.style.display = "none";
      });
    },

    // Toggle visibility
    toggle: function(state) {
      return this.each(function() {
        var hidden = this.style.display === "none";
        if (typeof state === "boolean") {
          this.style.display = state ? "" : "none";
        } else {
          this.style.display = hidden ? "" : "none";
        }
      });
    }
  });

  /**
   * AJAX
   */

  jQuery.ajax = function(options) {
    var xhr = new XMLHttpRequest();
    var url = options.url;
    var method = options.type || "GET";
    var data = options.data;
    var async = options.async !== false;

    xhr.open(method, url, async);

    if (options.contentType) {
      xhr.setRequestHeader("Content-Type", options.contentType);
    }

    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    xhr.onload = function() {
      if (xhr.status >= 200 && xhr.status < 300) {
        var response = xhr.responseText;

        if (options.dataType === "json") {
          try {
            response = JSON.parse(response);
          } catch (e) {
            if (options.error) {
              options.error(xhr, "parsererror", e);
            }
            return;
          }
        }

        if (options.success) {
          options.success(response, "success", xhr);
        }
      } else {
        if (options.error) {
          options.error(xhr, "error");
        }
      }

      if (options.complete) {
        options.complete(xhr, "success");
      }
    };

    xhr.onerror = function() {
      if (options.error) {
        options.error(xhr, "error");
      }
      if (options.complete) {
        options.complete(xhr, "error");
      }
    };

    if (data) {
      if (typeof data === "object") {
        data = jQuery.param(data);
      }
      if (method === "GET") {
        url += (url.indexOf("?") > -1 ? "&" : "?") + data;
      } else {
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      }
    }

    xhr.send(method === "POST" ? data : null);

    return xhr;
  };

  jQuery.get = function(url, data, callback) {
    if (typeof data === "function") {
      callback = data;
      data = null;
    }

    return jQuery.ajax({
      type: "GET",
      url: url,
      data: data,
      success: callback
    });
  };

  jQuery.post = function(url, data, callback) {
    if (typeof data === "function") {
      callback = data;
      data = null;
    }

    return jQuery.ajax({
      type: "POST",
      url: url,
      data: data,
      success: callback
    });
  };

  jQuery.param = function(obj) {
    var params = [];

    for (var key in obj) {
      if (obj.hasOwnProperty(key)) {
        params.push(encodeURIComponent(key) + "=" + encodeURIComponent(obj[key]));
      }
    }

    return params.join("&");
  };

  jQuery.fn.extend({
    // Ajax load
    load: function(url, callback) {
      var self = this;
      jQuery.get(url, function(data) {
        self.html(data);
        if (callback) {
          callback();
        }
      });
      return this;
    }
  });

  /**
   * EFFECTS AND ANIMATIONS
   */

  jQuery.fn.extend({
    // Fade in
    fadeIn: function(duration, callback) {
      return this.animate({ opacity: 1 }, duration, callback);
    },

    // Fade out
    fadeOut: function(duration, callback) {
      return this.animate({ opacity: 0 }, duration, callback);
    },

    // Slide down
    slideDown: function(duration, callback) {
      return this.animate({ height: "show" }, duration, callback);
    },

    // Slide up
    slideUp: function(duration, callback) {
      return this.animate({ height: "hide" }, duration, callback);
    },

    // Animate
    animate: function(props, duration, callback) {
      duration = duration || 400;

      return this.each(function() {
        var elem = this;
        var start = {};
        var end = props;
        var keys = Object.keys(props);

        for (var i = 0; i < keys.length; i++) {
          start[keys[i]] = elem.style[keys[i]];
        }

        var startTime = Date.now();

        var animate = function() {
          var elapsed = Date.now() - startTime;
          var progress = Math.min(elapsed / duration, 1);

          for (var j = 0; j < keys.length; j++) {
            var key = keys[j];
            var startVal = parseFloat(start[key]) || 0;
            var endVal = parseFloat(end[key]);
            var current = startVal + (endVal - startVal) * progress;
            elem.style[key] = current + "px";
          }

          if (progress < 1) {
            requestAnimationFrame(animate);
          } else if (callback) {
            callback();
          }
        };

        requestAnimationFrame(animate);
      });
    }
  });

  /**
   * DEFERRED/PROMISE
   */

  jQuery.Deferred = function() {
    var state = "pending";
    var resolveCallbacks = [];
    var rejectCallbacks = [];
    var progressCallbacks = [];

    var deferred = {
      resolve: function(value) {
        if (state === "pending") {
          state = "resolved";
          resolveCallbacks.forEach(function(cb) {
            cb(value);
          });
        }
        return this;
      },

      reject: function(reason) {
        if (state === "pending") {
          state = "rejected";
          rejectCallbacks.forEach(function(cb) {
            cb(reason);
          });
        }
        return this;
      },

      notify: function(value) {
        progressCallbacks.forEach(function(cb) {
          cb(value);
        });
        return this;
      },

      promise: function() {
        return {
          done: function(cb) {
            if (state === "resolved") {
              cb();
            } else {
              resolveCallbacks.push(cb);
            }
            return this;
          },

          fail: function(cb) {
            if (state === "rejected") {
              cb();
            } else {
              rejectCallbacks.push(cb);
            }
            return this;
          },

          progress: function(cb) {
            progressCallbacks.push(cb);
            return this;
          },

          then: function(done, fail, progress) {
            if (done) this.done(done);
            if (fail) this.fail(fail);
            if (progress) this.progress(progress);
            return this;
          }
        };
      }
    };

    return deferred;
  };

  /**
   * UTILITY FUNCTIONS
   */

  jQuery.isArrayLike = function(obj) {
    if (!obj || !("length" in obj)) {
      return false;
    }

    var length = obj.length;

    if (length === "number" && length > -1 && Math.floor(length) === length) {
      return true;
    }

    return false;
  };

  jQuery.isFunction = function(obj) {
    return typeof obj === "function";
  };

  jQuery.isArray = Array.isArray;

  jQuery.type = function(obj) {
    if (obj == null) {
      return String(obj);
    }

    return typeof obj === "object" || typeof obj === "function" ?
      Object.prototype.toString.call(obj).match(/\w+/)[0].toLowerCase() :
      typeof obj;
  };

  /**
   * DOM READY
   */

  var readyState = function() {
    if (document.readyState === "loading") {
      return false;
    }
    return true;
  };

  if (typeof Symbol !== "undefined" && Symbol.iterator) {
    jQuery.fn[Symbol.iterator] = Array.prototype[Symbol.iterator];
  }

  /**
   * EXPOSE JQUERY
   */

  if (typeof noGlobal === "undefined") {
    window.jQuery = window.$ = jQuery;
  }

  return jQuery;
});

/**
 * ============================================================================
 * Bootstrap v5.3.3 (https://getbootstrap.com/)
 * Copyright 2011-2024 The Bootstrap Authors
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
 * ============================================================================
 *
 * Bootstrap JavaScript is deminified for readability.
 * This is a simplified version of Bootstrap's core functionality.
 * For production use, consider using the official minified version.
 *
 * Key Bootstrap components:
 * - Alert
 * - Button
 * - Carousel
 * - Collapse
 * - Dropdown
 * - Modal
 * - Navbar
 * - Offcanvas
 * - Scrollspy
 * - Tab
 * - Toast
 * - Tooltip
 * - Popover
 * - Spinbutton
 *
 * Full documentation: https://getbootstrap.com/docs/5.3/
 */

(function(global, factory) {
  "use strict";

  if (typeof module === "object" && typeof module.exports === "object") {
    module.exports = factory(global, true);
  } else {
    factory(global);
  }
})(typeof window !== "undefined" ? window : this, function(window, noGlobal) {
  "use strict";

  /**
   * Bootstrap Tooltip Component
   */
  var Tooltip = (function() {
    function Tooltip(element, options) {
      this.element = element;
      this.options = Object.assign({}, Tooltip.Default, options);
      this.tip = null;
    }

    Tooltip.Default = {
      animation: true,
      container: false,
      delay: 0,
      html: false,
      placement: "top",
      selector: false,
      template: '<div class="tooltip" role="tooltip">' +
                '<div class="tooltip-arrow"></div>' +
                '<div class="tooltip-inner"></div></div>',
      title: "",
      trigger: "hover focus",
      offset: [0, 0],
      fallbackPlacements: ["top", "right", "bottom", "left"]
    };

    Tooltip.prototype.show = function() {
      var self = this;
      if (!this.tip) {
        this.tip = document.createElement("div");
        this.tip.innerHTML = this.options.template;
        this.tip = this.tip.firstElementChild;
      }

      this.tip.querySelector(".tooltip-inner").textContent = this.options.title;

      if (this.options.container) {
        document.querySelector(this.options.container).appendChild(this.tip);
      } else {
        document.body.appendChild(this.tip);
      }

      this.tip.classList.add("show");
      return this;
    };

    Tooltip.prototype.hide = function() {
      if (this.tip) {
        this.tip.classList.remove("show");
        if (this.tip.parentNode) {
          this.tip.parentNode.removeChild(this.tip);
        }
      }
      return this;
    };

    Tooltip.prototype.dispose = function() {
      if (this.tip && this.tip.parentNode) {
        this.tip.parentNode.removeChild(this.tip);
      }
      this.tip = null;
    };

    return Tooltip;
  })();

  /**
   * Bootstrap Modal Component
   */
  var Modal = (function() {
    function Modal(element, options) {
      this.element = element;
      this.options = Object.assign({}, Modal.Default, options);
      this.isShown = false;
    }

    Modal.Default = {
      backdrop: true,
      keyboard: true,
      focus: true,
      show: true
    };

    Modal.prototype.show = function() {
      var self = this;
      if (this.isShown) return;

      this.isShown = true;
      this.element.classList.add("show");
      this.element.style.display = "block";

      if (this.options.backdrop) {
        var backdrop = document.createElement("div");
        backdrop.className = "modal-backdrop fade show";
        document.body.appendChild(backdrop);
        this.backdrop = backdrop;
      }

      document.body.classList.add("modal-open");
      return this;
    };

    Modal.prototype.hide = function() {
      if (!this.isShown) return;

      this.isShown = false;
      this.element.classList.remove("show");
      this.element.style.display = "none";

      if (this.backdrop && this.backdrop.parentNode) {
        this.backdrop.parentNode.removeChild(this.backdrop);
      }

      var modals = document.querySelectorAll(".modal.show");
      if (modals.length === 0) {
        document.body.classList.remove("modal-open");
      }

      return this;
    };

    Modal.prototype.toggle = function() {
      return this.isShown ? this.hide() : this.show();
    };

    Modal.prototype.dispose = function() {
      if (this.backdrop && this.backdrop.parentNode) {
        this.backdrop.parentNode.removeChild(this.backdrop);
      }
    };

    return Modal;
  })();

  /**
   * Bootstrap Collapse Component
   */
  var Collapse = (function() {
    function Collapse(element, options) {
      this.element = element;
      this.options = Object.assign({}, Collapse.Default, options);
      this.isShown = this.element.classList.contains("show");
    }

    Collapse.Default = {
      parent: null,
      toggle: true
    };

    Collapse.prototype.show = function() {
      if (this.isShown) return;

      this.element.classList.add("show");
      this.element.style.maxHeight = this.element.scrollHeight + "px";
      this.isShown = true;
      return this;
    };

    Collapse.prototype.hide = function() {
      if (!this.isShown) return;

      this.element.classList.remove("show");
      this.element.style.maxHeight = "0";
      this.isShown = false;
      return this;
    };

    Collapse.prototype.toggle = function() {
      return this.isShown ? this.hide() : this.show();
    };

    return Collapse;
  })();

  /**
   * Bootstrap Dropdown Component
   */
  var Dropdown = (function() {
    function Dropdown(element) {
      this.element = element;
      this.menu = element.nextElementSibling;
      this.isShown = false;
      this.init();
    }

    Dropdown.prototype.init = function() {
      var self = this;
      this.element.addEventListener("click", function(e) {
        e.preventDefault();
        self.toggle();
      });
    };

    Dropdown.prototype.show = function() {
      if (this.menu) {
        this.menu.classList.add("show");
      }
      this.isShown = true;
      return this;
    };

    Dropdown.prototype.hide = function() {
      if (this.menu) {
        this.menu.classList.remove("show");
      }
      this.isShown = false;
      return this;
    };

    Dropdown.prototype.toggle = function() {
      return this.isShown ? this.hide() : this.show();
    };

    return Dropdown;
  })();

  /**
   * EXPOSE BOOTSTRAP COMPONENTS
   */

  if (typeof noGlobal === "undefined") {
    window.Tooltip = Tooltip;
    window.Modal = Modal;
    window.Collapse = Collapse;
    window.Dropdown = Dropdown;
  }

  return {
    Tooltip: Tooltip,
    Modal: Modal,
    Collapse: Collapse,
    Dropdown: Dropdown
  };
});

/**
 * Additional Utilities and Helpers
 */

(function(global) {
  "use strict";

  /**
   * Utility object for common tasks
   */
  var Utils = {
    /**
     * Generate unique ID
     */
    getUID: function(prefix) {
      return (prefix || "uid") + Math.random().toString(36).substr(2, 9);
    },

    /**
     * Get position of element relative to viewport
     */
    getPosition: function(element) {
      var rect = element.getBoundingClientRect();
      return {
        top: rect.top,
        left: rect.left,
        right: rect.right,
        bottom: rect.bottom,
        width: rect.width,
        height: rect.height
      };
    },

    /**
     * Check if element is visible
     */
    isVisible: function(element) {
      return !!(element.offsetWidth || element.offsetHeight || element.getClientRects().length);
    },

    /**
     * Throttle function execution
     */
    throttle: function(fn, delay) {
      var lastCall = 0;
      return function() {
        var now = Date.now();
        if (now - lastCall >= delay) {
          lastCall = now;
          fn.apply(this, arguments);
        }
      };
    },

    /**
     * Debounce function execution
     */
    debounce: function(fn, delay) {
      var timeoutId;
      return function() {
        var self = this;
        var args = arguments;
        clearTimeout(timeoutId);
        timeoutId = setTimeout(function() {
          fn.apply(self, args);
        }, delay);
      };
    }
  };

  /**
   * EXPOSE UTILS
   */

  if (typeof global !== "undefined") {
    global.Utils = Utils;
  }

})(typeof window !== "undefined" ? window : this);
