/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/Resources/assets/admin/js/bitbag/bitbag-choose-collection-type.js":
/*!*******************************************************************************!*\
  !*** ./src/Resources/assets/admin/js/bitbag/bitbag-choose-collection-type.js ***!
  \*******************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   HandleChooseCollectionType: () => (/* binding */ HandleChooseCollectionType)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var HandleChooseCollectionType = /*#__PURE__*/function () {
  function HandleChooseCollectionType() {
    _classCallCheck(this, HandleChooseCollectionType);
  }
  return _createClass(HandleChooseCollectionType, [{
    key: "init",
    value: function init() {
      window.addEventListener('DOMContentLoaded', function () {
        var typeField = document.getElementById('sylius_cms_collection_type');
        var fields = {
          page: document.getElementById('collection-type-pages'),
          block: document.getElementById('collection-type-blocks'),
          media: document.getElementById('collection-type-media')
        };
        var hideAllFields = function hideAllFields() {
          Object.values(fields).forEach(function (field) {
            return field.style.display = 'none';
          });
        };
        var showField = function showField(type) {
          hideAllFields();
          if (fields[type]) {
            fields[type].style.display = 'block';
          }
        };
        showField(typeField.value);
        typeField.addEventListener('change', function (event) {
          showField(event.target.value);
        });
      });
    }
  }]);
}();

/***/ }),

/***/ "./src/Resources/assets/admin/js/bitbag/bitbag-cms-preview.js":
/*!********************************************************************!*\
  !*** ./src/Resources/assets/admin/js/bitbag/bitbag-cms-preview.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   HandlePreview: () => (/* binding */ HandlePreview),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../common/js/utilities/triggerCustomEvent */ "./src/Resources/assets/common/js/utilities/triggerCustomEvent.js");
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/


var HandlePreview = /*#__PURE__*/function () {
  function HandlePreview() {
    var config = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {
      previewButton: 'data-bb-cms-preview-btn',
      previewModal: 'data-bb-cms-preview-modal',
      channelSwitch: 'data-bb-cms-channel',
      localeSwitch: 'data-bb-cms-locale'
    };
    _classCallCheck(this, HandlePreview);
    this.config = config;
    this.button = document.querySelector("[".concat(config.previewButton, "]"));
    this.modal = document.querySelector("[".concat(config.previewModal, "]"));
    this.modalSelector = config.previewModal;
    this.channelSelector = config.channelSwitch;
    this.localeSelector = config.localeSwitch;
  }
  return _createClass(HandlePreview, [{
    key: "init",
    value: function init() {
      if (_typeof(this.config) !== 'object') {
        throw new Error('Bitbag CMS Plugin - HandlePreview class config is not a valid object');
      }
      if (typeof this.localeSelector !== 'string' || typeof this.channelSelector !== 'string' || typeof this.modalSelector !== 'string') {
        throw new Error('Bitbag CMS Plugin - HandlePreview class config key values are not valid strings');
      }
      this._resourcePreview();
    }
  }, {
    key: "_$_CKEDITOR_MODAL_SHOW",
    value: function _$_CKEDITOR_MODAL_SHOW() {
      var root = $("[".concat(this.modalSelector, "]"));
      return root.modal('show');
    }
  }, {
    key: "_$_CKEDITOR_UPDATE_INSTANCES",
    value: function _$_CKEDITOR_UPDATE_INSTANCES() {
      _toConsumableArray(CKEDITOR.instances).forEach(function (instance) {
        return instance.updateElement();
      });
    }
  }, {
    key: "_resourcePreview",
    value: function _resourcePreview() {
      var _this = this;
      this.button.addEventListener('click', function (e) {
        e.preventDefault();
        _this._$_CKEDITOR_UPDATE_INSTANCES;
        _this._createPreview();
        _this._$_CKEDITOR_MODAL_SHOW();
      });
      document.querySelector("[".concat(this.channelSelector, "]")).addEventListener('change', function (e) {
        e.preventDefault();
        _this._$_CKEDITOR_UPDATE_INSTANCES;
        _this._createPreview();
        _this._$_CKEDITOR_MODAL_SHOW();
      });
      document.querySelector("[".concat(this.localeSelector, "]")).addEventListener('change', function (e) {
        e.preventDefault();
        _this._$_CKEDITOR_UPDATE_INSTANCES;
        _this._createPreview();
        _this._$_CKEDITOR_MODAL_SHOW();
      });
    }
  }, {
    key: "_createPreview",
    value: function () {
      var _createPreview2 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee() {
        var channelCode, localeCode, path, form, settings, req, res, blob, blobUrl;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              this.modal.querySelector('.ui.loadable').classList.add('loading');
              this.modal.disabled = true;
              channelCode = document.querySelector("[".concat(this.channelSelector, "]")).value;
              localeCode = document.querySelector("[".concat(this.localeSelector, "]")).value;
              path = this.button.dataset.url;
              form = this.button.closest('form');
              settings = {
                method: 'POST',
                body: new FormData(form)
              };
              _context.prev = 7;
              (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(this.modal, 'cms.create.preview.start');
              _context.next = 11;
              return fetch("".concat(path, "?_channel_code=").concat(channelCode, "&_locale=").concat(localeCode), settings);
            case 11:
              req = _context.sent;
              _context.next = 14;
              return req.text();
            case 14:
              res = _context.sent;
              blob = new Blob([res], {
                type: 'text/html',
                charset: 'utf-8'
              });
              blobUrl = window.URL.createObjectURL(blob);
              this.modal.querySelector('iframe').src = blobUrl;
              (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(this.modal, 'cms.create.preview.completed', res);
              _context.next = 25;
              break;
            case 21:
              _context.prev = 21;
              _context.t0 = _context["catch"](7);
              console.error("BitBag CMS Plugin - HandlePreview class error : ".concat(_context.t0));
              (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(this.modal, 'cms.create.preview.error', _context.t0);
            case 25:
              _context.prev = 25;
              this.modal.querySelector('.ui.loadable').classList.remove('loading');
              this.modal.disabled = false;
              (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(this.modal, 'cms.create.preview.end');
              return _context.finish(25);
            case 30:
            case "end":
              return _context.stop();
          }
        }, _callee, this, [[7, 21, 25, 30]]);
      }));
      function _createPreview() {
        return _createPreview2.apply(this, arguments);
      }
      return _createPreview;
    }()
  }]);
}();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (HandlePreview);

/***/ }),

/***/ "./src/Resources/assets/admin/js/bitbag/bitbag-content-configuration.js":
/*!******************************************************************************!*\
  !*** ./src/Resources/assets/admin/js/bitbag/bitbag-content-configuration.js ***!
  \******************************************************************************/
/***/ (() => {

$(document).ready(function () {
  $('.bitbag-media-autocomplete, .sylius-autocomplete').each(function (index, element) {
    $(element).autoComplete();
  });
  var pageElements = '#sylius_cms_page_contentElements';
  var blockElements = '#sylius_cms_block_contentElements';
  var collectionHolder = $(pageElements).length ? pageElements : blockElements;
  if (!$(collectionHolder).length) {
    return;
  }
  $(document).on('collection-form-add', function () {
    $('.bitbag-media-autocomplete, .sylius-autocomplete').each(function (index, element) {
      if ($._data($(element).get(0), 'events') === undefined) {
        $(element).autoComplete();
      }
    });
    $("".concat(collectionHolder, " [data-form-collection=\"item\"]")).each(function (index, element) {
      $(document).loadContentConfiguration(element);
    });
  });
  $.fn.extend({
    loadContentConfiguration: function loadContentConfiguration(target) {
      target.querySelector("".concat(collectionHolder, " select[name*=\"type\"]")).onchange = function () {
        var parent = this.parentElement;
        var newConfig = document.createElement('div');
        var selectedOption = this.selectedOptions[0];
        newConfig.innerHTML = selectedOption.getAttribute('data-configuration');
        var oldConfig = parent.nextElementSibling;
        parent.parentElement.replaceChild(newConfig, oldConfig);
        var oldConfigInput = oldConfig.querySelector('input');
        if (!oldConfigInput) {
          oldConfigInput = oldConfig.querySelector('textarea');
        }
        var oldConfigInputName = oldConfigInput.getAttribute('name');
        var newConfigInputs = newConfig.querySelectorAll('input');
        if (!newConfigInputs.length) {
          newConfigInputs = newConfig.querySelectorAll('textarea');
        }
        newConfigInputs.forEach(function (element) {
          var newConfigInputName = element.getAttribute('name');
          if (!newConfigInputName) {
            return;
          }
          newConfigInputName = oldConfigInputName.replace(oldConfigInputName.substring(oldConfigInputName.indexOf('[configuration]') + 15), newConfigInputName.substring(newConfigInputName.indexOf('configuration') + 13));
          $(element).attr('name', newConfigInputName);
          $(newConfig).find('.bitbag-media-autocomplete').autoComplete();
          $(newConfig).find('.sylius-autocomplete').autoComplete();
        });
      };
    }
  });
  $("".concat(collectionHolder, " [data-form-collection=\"item\"]")).each(function (index, element) {
    $(document).loadContentConfiguration(element);
  });
  $(document).loadContentConfiguration(document.querySelector("".concat(collectionHolder, " [data-form-collection=\"item\"]")));
});

/***/ }),

/***/ "./src/Resources/assets/admin/js/bitbag/bitbag-media-autocomplete.js":
/*!***************************************************************************!*\
  !*** ./src/Resources/assets/admin/js/bitbag/bitbag-media-autocomplete.js ***!
  \***************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   HandleAutoComplete: () => (/* binding */ HandleAutoComplete),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../common/js/utilities/triggerCustomEvent */ "./src/Resources/assets/common/js/utilities/triggerCustomEvent.js");
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function _createForOfIteratorHelper(r, e) { var t = "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (!t) { if (Array.isArray(r) || (t = _unsupportedIterableToArray(r)) || e && r && "number" == typeof r.length) { t && (r = t); var _n = 0, F = function F() {}; return { s: F, n: function n() { return _n >= r.length ? { done: !0 } : { done: !1, value: r[_n++] }; }, e: function e(r) { throw r; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var o, a = !0, u = !1; return { s: function s() { t = t.call(r); }, n: function n() { var r = t.next(); return a = r.done, r; }, e: function e(r) { u = !0, o = r; }, f: function f() { try { a || null == t["return"] || t["return"](); } finally { if (u) throw o; } } }; }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

var HandleAutoComplete = /*#__PURE__*/function () {
  function HandleAutoComplete() {
    var config = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {
      bbMediaContainer: 'data-bb-cms-autocomplete',
      choiceName: 'data-bb-cms-choice-name',
      choiceValue: 'data-bb-cms-choice-value',
      criteriaType: 'data-bb-cms-criteria-type',
      criteriaName: 'data-bb-cms-criteria-name',
      editUrl: 'data-bb-cms-load-edit-url',
      nameMessage: 'data-bb-cms-name-message',
      deleteButton: 'data-bb-cms-delete-selected',
      choosenPreview: 'data-bb-cms-selected-image',
      selectMenu: 'data-bb-cms-selection-menu',
      selectInput: 'data-bb-cms-image-select',
      placeholder: 'data-bb-cms-placeholder',
      limit: 30
    };
    _classCallCheck(this, HandleAutoComplete);
    this.config = config;
    this.mediaContainers = document.querySelectorAll("[".concat(config.bbMediaContainer, "]"));
    this.deleteButton = "[".concat(config.deleteButton, "]");
    this.selectMenu = "[".concat(config.selectMenu, "]");
    this.selectInput = "[".concat(config.selectInput, "]");
    this.placeholder = "[".concat(config.placeholder, "]");
  }
  return _createClass(HandleAutoComplete, [{
    key: "init",
    value: function init() {
      var _this = this;
      if (_typeof(this.config) !== 'object') {
        throw new Error('Bitbag CMS Plugin - HandleAutoComplete class config is not a valid object');
      }
      this.mediaContainers.forEach(function (mediaContainer) {
        _this._handleSavedValue(mediaContainer);
        _this._handleImageChoice(mediaContainer);
        _this._handleResetBtn(mediaContainer);
      });
    }
  }, {
    key: "_handleResetBtn",
    value: function _handleResetBtn(mediaContainer) {
      var _this2 = this;
      var deleteButton = mediaContainer.querySelector(this.deleteButton);
      if (mediaContainer.querySelector('input[type=hidden]').value === '') {
        deleteButton.classList.add('is-hidden');
        return;
      }
      deleteButton.classList.remove('is-hidden');
      deleteButton.addEventListener('click', function () {
        _this2._resetValues(mediaContainer);
      });
    }
  }, {
    key: "_handleImageChoice",
    value: function _handleImageChoice(mediaContainer) {
      var _this3 = this;
      var timeout;
      mediaContainer.querySelector(this.selectInput).addEventListener('click', function (e) {
        e.preventDefault();
        _this3._getMediaImages(mediaContainer);
      });
      mediaContainer.querySelector(this.selectInput).addEventListener('input', function (e) {
        e.preventDefault();
        clearTimeout(timeout);
        timeout = setTimeout(function () {
          _this3._getMediaImages(mediaContainer, e.target.value);
        }, 500);
      });
      mediaContainer.querySelector('input[type=hidden]').addEventListener('change', function (e) {
        e.preventDefault();
        _this3._handleResetBtn(mediaContainer);
      });
    }
  }, {
    key: "_handleSavedValue",
    value: function () {
      var _handleSavedValue2 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(mediaContainer) {
        var url, res, data, children, selectedContainer, _iterator, _step, child;
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              if (!(mediaContainer.querySelector('input[type=hidden]').value === '')) {
                _context.next = 2;
                break;
              }
              return _context.abrupt("return");
            case 2:
              url = "".concat(mediaContainer.dataset.bbCmsLoadEditUrl, "?").concat(mediaContainer.querySelector('input[type=hidden]').value.split(',').filter(String).map(function (value) {
                return "code[]=".concat(value);
              }).join('&'));
              _context.prev = 3;
              (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(mediaContainer, 'cms.media.saved.reload.start');
              mediaContainer.classList.add('loading');
              _context.next = 8;
              return fetch(url);
            case 8:
              res = _context.sent;
              _context.next = 11;
              return res.json();
            case 11:
              data = _context.sent;
              this._addToSelectMenu(data, mediaContainer);
              children = [];
              selectedContainer = mediaContainer.querySelector(this.selectMenu);
              if (selectedContainer !== null) {
                children = selectedContainer.children;
              }
              _iterator = _createForOfIteratorHelper(children);
              try {
                for (_iterator.s(); !(_step = _iterator.n()).done;) {
                  child = _step.value;
                  child.click();
                }
              } catch (err) {
                _iterator.e(err);
              } finally {
                _iterator.f();
              }
              (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(mediaContainer, 'cms.media.saved.reload.completed', data);
              _context.next = 25;
              break;
            case 21:
              _context.prev = 21;
              _context.t0 = _context["catch"](3);
              console.error("BitBag CMS Plugin - HandleAutoComplete class error : ".concat(_context.t0));
              (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(mediaContainer, 'cms.media.saved.reload.error', _context.t0);
            case 25:
              _context.prev = 25;
              mediaContainer.classList.remove('loading');
              (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(mediaContainer, 'cms.media.saved.reload.end');
              return _context.finish(25);
            case 29:
            case "end":
              return _context.stop();
          }
        }, _callee, this, [[3, 21, 25, 29]]);
      }));
      function _handleSavedValue(_x) {
        return _handleSavedValue2.apply(this, arguments);
      }
      return _handleSavedValue;
    }()
  }, {
    key: "_getMediaImages",
    value: function () {
      var _getMediaImages2 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2(mediaContainer) {
        var value,
          path,
          typeQuery,
          searchValue,
          url,
          res,
          data,
          items,
          _args2 = arguments;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              value = _args2.length > 1 && _args2[1] !== undefined ? _args2[1] : false;
              path = mediaContainer.dataset.bbCmsUrl;
              typeQuery = mediaContainer.dataset.bbCmsCriteriaType;
              searchValue = value ? "&criteria[search][value]=".concat(value) : '';
              url = "".concat(path, "&limit=").concat(this.config.limit, "&criteria[search][type]=").concat(typeQuery, "&criteria[search][value]=").concat(searchValue);
              _context2.prev = 5;
              (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(mediaContainer, 'cms.media.display.start');
              mediaContainer.classList.add('loading');
              _context2.next = 10;
              return fetch(url);
            case 10:
              res = _context2.sent;
              _context2.next = 13;
              return res.json();
            case 13:
              data = _context2.sent;
              items = data._embedded.items;
              this._addToSelectMenu(items, mediaContainer);
              (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(mediaContainer, 'cms.media.display.completed', data);
              _context2.next = 23;
              break;
            case 19:
              _context2.prev = 19;
              _context2.t0 = _context2["catch"](5);
              console.error("BitBag CMS Plugin - HandleAutoComplete class error : ".concat(_context2.t0));
              (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(mediaContainer, 'cms.media.display.error', _context2.t0);
            case 23:
              _context2.prev = 23;
              mediaContainer.classList.remove('loading');
              (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(mediaContainer, 'cms.media.display.end');
              return _context2.finish(23);
            case 27:
            case "end":
              return _context2.stop();
          }
        }, _callee2, this, [[5, 19, 23, 27]]);
      }));
      function _getMediaImages(_x2) {
        return _getMediaImages2.apply(this, arguments);
      }
      return _getMediaImages;
    }()
  }, {
    key: "_resetValues",
    value: function _resetValues(mediaContainer) {
      (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(mediaContainer, 'cms.media.reset.start');
      mediaContainer.querySelector('input[type=hidden]').value = '';
      mediaContainer.querySelector(this.selectMenu).innerHTML = '';
      mediaContainer.querySelector(this.placeholder).innerHTML = '';
      (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(mediaContainer, 'cms.media.reset.end');
    }
  }, {
    key: "_addToSelectMenu",
    value: function _addToSelectMenu(arr, mediaContainer) {
      var _this4 = this;
      (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(mediaContainer, 'cms.media.display.update.start');
      var selectMenu = mediaContainer.querySelector(this.selectMenu);
      selectMenu.innerHTML = '';
      if (arr !== null) {
        arr.forEach(function (item) {
          selectMenu.insertAdjacentHTML('beforeend', _this4._itemTemplate(item.path, item.code.trim()));
        });
      }
      (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(mediaContainer, 'cms.media.display.update.end');
    }
  }, {
    key: "_itemTemplate",
    value: function _itemTemplate(link, code) {
      return "<div class=\"item\" data-value=\"".concat(code, "\"><img src=\"").concat(link, "\"/><strong>").concat(code, "</strong></div>");
    }
  }]);
}();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (HandleAutoComplete);

/***/ }),

/***/ "./src/Resources/assets/admin/js/bitbag/bitbag-page-slug.js":
/*!******************************************************************!*\
  !*** ./src/Resources/assets/admin/js/bitbag/bitbag-page-slug.js ***!
  \******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   HandleSlugUpdate: () => (/* binding */ HandleSlugUpdate),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../../common/js/utilities/triggerCustomEvent */ "./src/Resources/assets/common/js/utilities/triggerCustomEvent.js");
function _regeneratorRuntime() { "use strict"; /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/facebook/regenerator/blob/main/LICENSE */ _regeneratorRuntime = function _regeneratorRuntime() { return e; }; var t, e = {}, r = Object.prototype, n = r.hasOwnProperty, o = Object.defineProperty || function (t, e, r) { t[e] = r.value; }, i = "function" == typeof Symbol ? Symbol : {}, a = i.iterator || "@@iterator", c = i.asyncIterator || "@@asyncIterator", u = i.toStringTag || "@@toStringTag"; function define(t, e, r) { return Object.defineProperty(t, e, { value: r, enumerable: !0, configurable: !0, writable: !0 }), t[e]; } try { define({}, ""); } catch (t) { define = function define(t, e, r) { return t[e] = r; }; } function wrap(t, e, r, n) { var i = e && e.prototype instanceof Generator ? e : Generator, a = Object.create(i.prototype), c = new Context(n || []); return o(a, "_invoke", { value: makeInvokeMethod(t, r, c) }), a; } function tryCatch(t, e, r) { try { return { type: "normal", arg: t.call(e, r) }; } catch (t) { return { type: "throw", arg: t }; } } e.wrap = wrap; var h = "suspendedStart", l = "suspendedYield", f = "executing", s = "completed", y = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} var p = {}; define(p, a, function () { return this; }); var d = Object.getPrototypeOf, v = d && d(d(values([]))); v && v !== r && n.call(v, a) && (p = v); var g = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(p); function defineIteratorMethods(t) { ["next", "throw", "return"].forEach(function (e) { define(t, e, function (t) { return this._invoke(e, t); }); }); } function AsyncIterator(t, e) { function invoke(r, o, i, a) { var c = tryCatch(t[r], t, o); if ("throw" !== c.type) { var u = c.arg, h = u.value; return h && "object" == _typeof(h) && n.call(h, "__await") ? e.resolve(h.__await).then(function (t) { invoke("next", t, i, a); }, function (t) { invoke("throw", t, i, a); }) : e.resolve(h).then(function (t) { u.value = t, i(u); }, function (t) { return invoke("throw", t, i, a); }); } a(c.arg); } var r; o(this, "_invoke", { value: function value(t, n) { function callInvokeWithMethodAndArg() { return new e(function (e, r) { invoke(t, n, e, r); }); } return r = r ? r.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg(); } }); } function makeInvokeMethod(e, r, n) { var o = h; return function (i, a) { if (o === f) throw Error("Generator is already running"); if (o === s) { if ("throw" === i) throw a; return { value: t, done: !0 }; } for (n.method = i, n.arg = a;;) { var c = n.delegate; if (c) { var u = maybeInvokeDelegate(c, n); if (u) { if (u === y) continue; return u; } } if ("next" === n.method) n.sent = n._sent = n.arg;else if ("throw" === n.method) { if (o === h) throw o = s, n.arg; n.dispatchException(n.arg); } else "return" === n.method && n.abrupt("return", n.arg); o = f; var p = tryCatch(e, r, n); if ("normal" === p.type) { if (o = n.done ? s : l, p.arg === y) continue; return { value: p.arg, done: n.done }; } "throw" === p.type && (o = s, n.method = "throw", n.arg = p.arg); } }; } function maybeInvokeDelegate(e, r) { var n = r.method, o = e.iterator[n]; if (o === t) return r.delegate = null, "throw" === n && e.iterator["return"] && (r.method = "return", r.arg = t, maybeInvokeDelegate(e, r), "throw" === r.method) || "return" !== n && (r.method = "throw", r.arg = new TypeError("The iterator does not provide a '" + n + "' method")), y; var i = tryCatch(o, e.iterator, r.arg); if ("throw" === i.type) return r.method = "throw", r.arg = i.arg, r.delegate = null, y; var a = i.arg; return a ? a.done ? (r[e.resultName] = a.value, r.next = e.nextLoc, "return" !== r.method && (r.method = "next", r.arg = t), r.delegate = null, y) : a : (r.method = "throw", r.arg = new TypeError("iterator result is not an object"), r.delegate = null, y); } function pushTryEntry(t) { var e = { tryLoc: t[0] }; 1 in t && (e.catchLoc = t[1]), 2 in t && (e.finallyLoc = t[2], e.afterLoc = t[3]), this.tryEntries.push(e); } function resetTryEntry(t) { var e = t.completion || {}; e.type = "normal", delete e.arg, t.completion = e; } function Context(t) { this.tryEntries = [{ tryLoc: "root" }], t.forEach(pushTryEntry, this), this.reset(!0); } function values(e) { if (e || "" === e) { var r = e[a]; if (r) return r.call(e); if ("function" == typeof e.next) return e; if (!isNaN(e.length)) { var o = -1, i = function next() { for (; ++o < e.length;) if (n.call(e, o)) return next.value = e[o], next.done = !1, next; return next.value = t, next.done = !0, next; }; return i.next = i; } } throw new TypeError(_typeof(e) + " is not iterable"); } return GeneratorFunction.prototype = GeneratorFunctionPrototype, o(g, "constructor", { value: GeneratorFunctionPrototype, configurable: !0 }), o(GeneratorFunctionPrototype, "constructor", { value: GeneratorFunction, configurable: !0 }), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, u, "GeneratorFunction"), e.isGeneratorFunction = function (t) { var e = "function" == typeof t && t.constructor; return !!e && (e === GeneratorFunction || "GeneratorFunction" === (e.displayName || e.name)); }, e.mark = function (t) { return Object.setPrototypeOf ? Object.setPrototypeOf(t, GeneratorFunctionPrototype) : (t.__proto__ = GeneratorFunctionPrototype, define(t, u, "GeneratorFunction")), t.prototype = Object.create(g), t; }, e.awrap = function (t) { return { __await: t }; }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, c, function () { return this; }), e.AsyncIterator = AsyncIterator, e.async = function (t, r, n, o, i) { void 0 === i && (i = Promise); var a = new AsyncIterator(wrap(t, r, n, o), i); return e.isGeneratorFunction(r) ? a : a.next().then(function (t) { return t.done ? t.value : a.next(); }); }, defineIteratorMethods(g), define(g, u, "Generator"), define(g, a, function () { return this; }), define(g, "toString", function () { return "[object Generator]"; }), e.keys = function (t) { var e = Object(t), r = []; for (var n in e) r.push(n); return r.reverse(), function next() { for (; r.length;) { var t = r.pop(); if (t in e) return next.value = t, next.done = !1, next; } return next.done = !0, next; }; }, e.values = values, Context.prototype = { constructor: Context, reset: function reset(e) { if (this.prev = 0, this.next = 0, this.sent = this._sent = t, this.done = !1, this.delegate = null, this.method = "next", this.arg = t, this.tryEntries.forEach(resetTryEntry), !e) for (var r in this) "t" === r.charAt(0) && n.call(this, r) && !isNaN(+r.slice(1)) && (this[r] = t); }, stop: function stop() { this.done = !0; var t = this.tryEntries[0].completion; if ("throw" === t.type) throw t.arg; return this.rval; }, dispatchException: function dispatchException(e) { if (this.done) throw e; var r = this; function handle(n, o) { return a.type = "throw", a.arg = e, r.next = n, o && (r.method = "next", r.arg = t), !!o; } for (var o = this.tryEntries.length - 1; o >= 0; --o) { var i = this.tryEntries[o], a = i.completion; if ("root" === i.tryLoc) return handle("end"); if (i.tryLoc <= this.prev) { var c = n.call(i, "catchLoc"), u = n.call(i, "finallyLoc"); if (c && u) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } else if (c) { if (this.prev < i.catchLoc) return handle(i.catchLoc, !0); } else { if (!u) throw Error("try statement without catch or finally"); if (this.prev < i.finallyLoc) return handle(i.finallyLoc); } } } }, abrupt: function abrupt(t, e) { for (var r = this.tryEntries.length - 1; r >= 0; --r) { var o = this.tryEntries[r]; if (o.tryLoc <= this.prev && n.call(o, "finallyLoc") && this.prev < o.finallyLoc) { var i = o; break; } } i && ("break" === t || "continue" === t) && i.tryLoc <= e && e <= i.finallyLoc && (i = null); var a = i ? i.completion : {}; return a.type = t, a.arg = e, i ? (this.method = "next", this.next = i.finallyLoc, y) : this.complete(a); }, complete: function complete(t, e) { if ("throw" === t.type) throw t.arg; return "break" === t.type || "continue" === t.type ? this.next = t.arg : "return" === t.type ? (this.rval = this.arg = t.arg, this.method = "return", this.next = "end") : "normal" === t.type && e && (this.next = e), y; }, finish: function finish(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.finallyLoc === t) return this.complete(r.completion, r.afterLoc), resetTryEntry(r), y; } }, "catch": function _catch(t) { for (var e = this.tryEntries.length - 1; e >= 0; --e) { var r = this.tryEntries[e]; if (r.tryLoc === t) { var n = r.completion; if ("throw" === n.type) { var o = n.arg; resetTryEntry(r); } return o; } } throw Error("illegal catch attempt"); }, delegateYield: function delegateYield(e, r, n) { return this.delegate = { iterator: values(e), resultName: r, nextLoc: n }, "next" === this.method && (this.arg = t), y; } }, e; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/


var HandleSlugUpdate = /*#__PURE__*/function () {
  function HandleSlugUpdate() {
    var config = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {
      wrappersIndicator: 'data-bb-cms-wrapper',
      lockFieldIndicator: 'data-bb-cms-toggle-slug',
      bbTarget: 'sylius_cms_page',
      nameField: 'sylius_cms_page_name'
    };
    _classCallCheck(this, HandleSlugUpdate);
    this.wrappers = document.querySelectorAll("[".concat(config.wrappersIndicator, "]"));
    this.lockFieldIndicator = "[".concat(config.lockFieldIndicator, "]");
    this.bbTarget = config.bbTarget;
    this.config = config;
    this.nameField = document.getElementById("".concat(config.nameField));
  }
  return _createClass(HandleSlugUpdate, [{
    key: "init",
    value: function init() {
      if (_typeof(this.config) !== 'object') {
        throw new Error('Bitbag CMS Plugin - HandleSlugUpdate class config is not a valid object');
      }
      if (typeof this.lockFieldIndicator !== 'string' || typeof this.bbTarget !== 'string') {
        throw new Error('Bitbag CMS Plugin - HandleSlugUpdate class config key values are not valid strings');
      }
      if (!this.nameField) {
        throw new Error('Bitbag CMS Plugin - HandleSlugUpdate name field not found');
      }
      this._handleFields();
    }
  }, {
    key: "_handleFields",
    value: function _handleFields() {
      var _this = this;
      this.wrappers.forEach(function (item) {
        var locale = item.dataset.locale;
        var slugField = item.querySelector("#".concat(_this.bbTarget, "_translations_").concat(locale, "_slug"));
        if (!slugField) {
          slugField = item.querySelector("#".concat(_this.bbTarget, "_slug"));
        }
        if (!slugField) {
          return;
        }
        var timeout;
        _this.nameField.addEventListener('input', function (e) {
          e.preventDefault();
          if (!slugField.readOnly) {
            clearTimeout(timeout);
            timeout = setTimeout(function () {
              _this._updateSlug(slugField, _this.nameField.value);
            }, 1000);
          }
        });
        var lockField = item.querySelector(_this.lockFieldIndicator);
        if (!lockField) {
          return;
        }
        lockField.addEventListener('click', function (e) {
          e.preventDefault();
          _this._toggleSlugModification(slugField, lockField);
        });
      });
    }
  }, {
    key: "_updateSlug",
    value: function () {
      var _updateSlug2 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee(slugField, value) {
        return _regeneratorRuntime().wrap(function _callee$(_context) {
          while (1) switch (_context.prev = _context.next) {
            case 0:
              (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(slugField, 'cms.slug.update.start');
              slugField.parentNode.classList.add('loading');
              _context.next = 4;
              return this._getValidSlug(slugField.dataset.url, value);
            case 4:
              slugField.value = _context.sent;
              slugField.parentNode.classList.remove('loading');
              (0,_common_js_utilities_triggerCustomEvent__WEBPACK_IMPORTED_MODULE_0__["default"])(slugField, 'cms.slug.update.end');
            case 7:
            case "end":
              return _context.stop();
          }
        }, _callee, this);
      }));
      function _updateSlug(_x, _x2) {
        return _updateSlug2.apply(this, arguments);
      }
      return _updateSlug;
    }()
  }, {
    key: "_getValidSlug",
    value: function () {
      var _getValidSlug2 = _asyncToGenerator( /*#__PURE__*/_regeneratorRuntime().mark(function _callee2(url, value) {
        var request, response;
        return _regeneratorRuntime().wrap(function _callee2$(_context2) {
          while (1) switch (_context2.prev = _context2.next) {
            case 0:
              _context2.prev = 0;
              _context2.next = 3;
              return fetch("".concat(url, "?name=").concat(encodeURIComponent(value)));
            case 3:
              request = _context2.sent;
              _context2.next = 6;
              return request.json();
            case 6:
              response = _context2.sent;
              return _context2.abrupt("return", response.slug);
            case 10:
              _context2.prev = 10;
              _context2.t0 = _context2["catch"](0);
              console.error("BitBag CMS Plugin - HandleSlugUpdate class error : ".concat(_context2.t0));
            case 13:
            case "end":
              return _context2.stop();
          }
        }, _callee2, null, [[0, 10]]);
      }));
      function _getValidSlug(_x3, _x4) {
        return _getValidSlug2.apply(this, arguments);
      }
      return _getValidSlug;
    }()
  }, {
    key: "_toggleSlugModification",
    value: function _toggleSlugModification(readOnlyEl, toggler) {
      readOnlyEl.readOnly = !readOnlyEl.readOnly;
      var icon = toggler.querySelector('i');
      icon.classList.toggle('lock');
      icon.classList.toggle('unlock');
    }
  }]);
}();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (HandleSlugUpdate);

/***/ }),

/***/ "./src/Resources/assets/admin/js/bitbag/bitbag-template.js":
/*!*****************************************************************!*\
  !*** ./src/Resources/assets/admin/js/bitbag/bitbag-template.js ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   HandleTemplate: () => (/* binding */ HandleTemplate),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
var HandleTemplate = /*#__PURE__*/function () {
  function HandleTemplate() {
    _classCallCheck(this, HandleTemplate);
  }
  return _createClass(HandleTemplate, [{
    key: "init",
    value: function init() {
      $(document).ready(function () {
        var cmsLoadTemplate = $('[data-bb-cms-load-template]');
        var cmsPageTemplate = $('#sylius_cms_page_template');
        var cmsBlockTemplate = $('#sylius_cms_block_template');
        cmsLoadTemplate.on('click', function (e) {
          e.preventDefault();
          if (!cmsPageTemplate.val() && !cmsBlockTemplate.val()) {
            return;
          }
          $('#load-template-confirmation-modal').modal('show');
        });
        $('#load-template-confirmation-button').on('click', function () {
          var _cmsPageTemplate$val;
          var templateId = (_cmsPageTemplate$val = cmsPageTemplate.val()) !== null && _cmsPageTemplate$val !== void 0 ? _cmsPageTemplate$val : cmsBlockTemplate.val();
          if (!templateId) {
            return;
          }
          var endpointUrl = cmsLoadTemplate.data('bb-cms-load-template').replace('REPLACE_ID', templateId);
          if (!endpointUrl) {
            return;
          }
          $.ajax({
            url: endpointUrl,
            type: 'GET',
            success: function success(data) {
              if (data.status === 'success') {
                $('[id^="sylius_cms_"][id$="contentElements"]').children('[data-form-collection="list"]').html('');
                $.each(data.content, function () {
                  $('[data-form-collection="add"]').trigger('click');
                });
                var elements = $('[id^="sylius_cms_"][id*="_contentElements_"][id$="_type"]').filter(function () {
                  return /_page_|_block_/.test(this.id);
                });
                $.each(data.content, function (index, element) {
                  elements.eq(index).val(element.type);
                  elements.eq(index).change();
                });
              } else {
                console.error(data.message);
              }
            },
            error: function error(jqXHR, textStatus, errorThrown) {
              console.error('Error:', textStatus, errorThrown);
            }
          });
        });
      });
    }
  }]);
}();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (HandleTemplate);

/***/ }),

/***/ "./src/Resources/assets/admin/js/bitbag/bitbag-upload-csv.js":
/*!*******************************************************************!*\
  !*** ./src/Resources/assets/admin/js/bitbag/bitbag-upload-csv.js ***!
  \*******************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   HandleCsvUpload: () => (/* binding */ HandleCsvUpload),
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
/*
 This file was created by developers working at BitBag
 Do you need more information about us and what we do? Visit our https://bitbag.io website!
 We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

var HandleCsvUpload = /*#__PURE__*/function () {
  function HandleCsvUpload() {
    var config = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {
      textField: 'data-bb-cms-text',
      fileField: 'data-bb-cms-file'
    };
    _classCallCheck(this, HandleCsvUpload);
    this.config = config;
    this.textField = document.querySelector("[".concat(config.textField, "]"));
    this.fileField = document.querySelector("[".concat(config.fileField, "]"));
  }
  return _createClass(HandleCsvUpload, [{
    key: "init",
    value: function init() {
      if (_typeof(this.config) !== 'object') {
        throw new Error('Bitbag CMS Plugin - HandleCsvUpload class config is not a valid object');
      }
      this._handleFields();
    }
  }, {
    key: "_handleFields",
    value: function _handleFields() {
      this._handleTextField();
      this._handleFileField();
    }
  }, {
    key: "_handleTextField",
    value: function _handleTextField() {
      var _this = this;
      this.textField.addEventListener('click', function () {
        _this.fileField.click();
      });
    }
  }, {
    key: "_handleFileField",
    value: function _handleFileField() {
      var _this2 = this;
      this.fileField.addEventListener('change', function (e) {
        _this2.textField.value = e.target.files[0].name;
      });
    }
  }]);
}();
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (HandleCsvUpload);

/***/ }),

/***/ "./src/Resources/assets/admin/js/bitbag/index.js":
/*!*******************************************************!*\
  !*** ./src/Resources/assets/admin/js/bitbag/index.js ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   HandleAutoComplete: () => (/* reexport safe */ _bitbag_media_autocomplete__WEBPACK_IMPORTED_MODULE_4__.HandleAutoComplete),
/* harmony export */   HandleChooseCollectionType: () => (/* reexport safe */ _bitbag_choose_collection_type__WEBPACK_IMPORTED_MODULE_5__.HandleChooseCollectionType),
/* harmony export */   HandleCsvUpload: () => (/* reexport safe */ _bitbag_upload_csv__WEBPACK_IMPORTED_MODULE_1__.HandleCsvUpload),
/* harmony export */   HandlePreview: () => (/* reexport safe */ _bitbag_cms_preview__WEBPACK_IMPORTED_MODULE_3__.HandlePreview),
/* harmony export */   HandleSlugUpdate: () => (/* reexport safe */ _bitbag_page_slug__WEBPACK_IMPORTED_MODULE_2__.HandleSlugUpdate),
/* harmony export */   HandleTemplate: () => (/* reexport safe */ _bitbag_template__WEBPACK_IMPORTED_MODULE_6__.HandleTemplate)
/* harmony export */ });
/* harmony import */ var _bitbag_content_configuration__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./bitbag-content-configuration */ "./src/Resources/assets/admin/js/bitbag/bitbag-content-configuration.js");
/* harmony import */ var _bitbag_content_configuration__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_bitbag_content_configuration__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _bitbag_upload_csv__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./bitbag-upload-csv */ "./src/Resources/assets/admin/js/bitbag/bitbag-upload-csv.js");
/* harmony import */ var _bitbag_page_slug__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./bitbag-page-slug */ "./src/Resources/assets/admin/js/bitbag/bitbag-page-slug.js");
/* harmony import */ var _bitbag_cms_preview__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./bitbag-cms-preview */ "./src/Resources/assets/admin/js/bitbag/bitbag-cms-preview.js");
/* harmony import */ var _bitbag_media_autocomplete__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./bitbag-media-autocomplete */ "./src/Resources/assets/admin/js/bitbag/bitbag-media-autocomplete.js");
/* harmony import */ var _bitbag_choose_collection_type__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./bitbag-choose-collection-type */ "./src/Resources/assets/admin/js/bitbag/bitbag-choose-collection-type.js");
/* harmony import */ var _bitbag_template__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./bitbag-template */ "./src/Resources/assets/admin/js/bitbag/bitbag-template.js");








/***/ }),

/***/ "./src/Resources/assets/admin/js/index.js":
/*!************************************************!*\
  !*** ./src/Resources/assets/admin/js/index.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _bitbag__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./bitbag */ "./src/Resources/assets/admin/js/bitbag/index.js");

if (document.querySelector('[data-bb-target="cms-import"]')) {
  new _bitbag__WEBPACK_IMPORTED_MODULE_0__.HandleCsvUpload().init();
}
if (document.querySelectorAll('[data-bb-target="cms-slug-update"]').length > 0) {
  new _bitbag__WEBPACK_IMPORTED_MODULE_0__.HandleSlugUpdate().init();
}
if (document.querySelectorAll('[data-bb-cms-preview-btn]').length > 0) {
  new _bitbag__WEBPACK_IMPORTED_MODULE_0__.HandlePreview().init();
}
if (document.querySelector('[data-bb-target="cms-handle-autocomplete"]')) {
  new _bitbag__WEBPACK_IMPORTED_MODULE_0__.HandleAutoComplete().init();
}
if (document.querySelector('.collection-type-items')) {
  new _bitbag__WEBPACK_IMPORTED_MODULE_0__.HandleChooseCollectionType().init();
}
if (document.querySelector('[data-bb-cms-load-template]')) {
  new _bitbag__WEBPACK_IMPORTED_MODULE_0__.HandleTemplate().init();
}

/***/ }),

/***/ "./src/Resources/assets/common/js/utilities/triggerCustomEvent.js":
/*!************************************************************************!*\
  !*** ./src/Resources/assets/common/js/utilities/triggerCustomEvent.js ***!
  \************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
var triggerCustomEvent = function triggerCustomEvent(node, eventName, data) {
  var eventPrefix = 'bb';
  var customEvent = new CustomEvent("".concat(eventPrefix, ".").concat(eventName), {
    detail: data
  });
  node.dispatchEvent(customEvent);
  return node;
};
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (triggerCustomEvent);

/***/ }),

/***/ "./src/Resources/assets/admin/scss/main.scss":
/*!***************************************************!*\
  !*** ./src/Resources/assets/admin/scss/main.scss ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!*********************************************!*\
  !*** ./src/Resources/assets/admin/entry.js ***!
  \*********************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./js */ "./src/Resources/assets/admin/js/index.js");
/* harmony import */ var _scss_main_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./scss/main.scss */ "./src/Resources/assets/admin/scss/main.scss");


})();

/******/ })()
;