/******/ (function (modules) {
  // webpackBootstrap
  /******/ // The module cache
  /******/ var installedModules = {};
  /******/
  /******/ // The require function
  /******/ function __webpack_require__(moduleId) {
    /******/
    /******/ // Check if module is in cache
    /******/ if (installedModules[moduleId]) {
      /******/ return installedModules[moduleId].exports;
      /******/
    }
    /******/ // Create a new module (and put it into the cache)
    /******/ var module = (installedModules[moduleId] = {
      /******/ i: moduleId,
      /******/ l: false,
      /******/ exports: {},
      /******/
    });
    /******/
    /******/ // Execute the module function
    /******/ modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
    /******/
    /******/ // Flag the module as loaded
    /******/ module.l = true;
    /******/
    /******/ // Return the exports of the module
    /******/ return module.exports;
    /******/
  }
  /******/
  /******/
  /******/ // expose the modules object (__webpack_modules__)
  /******/ __webpack_require__.m = modules;
  /******/
  /******/ // expose the module cache
  /******/ __webpack_require__.c = installedModules;
  /******/
  /******/ // define getter function for harmony exports
  /******/ __webpack_require__.d = function (exports, name, getter) {
    /******/ if (!__webpack_require__.o(exports, name)) {
      /******/ Object.defineProperty(exports, name, {
        enumerable: true,
        get: getter,
      });
      /******/
    }
    /******/
  };
  /******/
  /******/ // define __esModule on exports
  /******/ __webpack_require__.r = function (exports) {
    /******/ if (typeof Symbol !== "undefined" && Symbol.toStringTag) {
      /******/ Object.defineProperty(exports, Symbol.toStringTag, {
        value: "Module",
      });
      /******/
    }
    /******/ Object.defineProperty(exports, "__esModule", { value: true });
    /******/
  };
  /******/
  /******/ // create a fake namespace object
  /******/ // mode & 1: value is a module id, require it
  /******/ // mode & 2: merge all properties of value into the ns
  /******/ // mode & 4: return value when already ns object
  /******/ // mode & 8|1: behave like require
  /******/ __webpack_require__.t = function (value, mode) {
    /******/ if (mode & 1) value = __webpack_require__(value);
    /******/ if (mode & 8) return value;
    /******/ if (mode & 4 && typeof value === "object" && value && value.__esModule) return value;
    /******/ var ns = Object.create(null);
    /******/ __webpack_require__.r(ns);
    /******/ Object.defineProperty(ns, "default", {
      enumerable: true,
      value: value,
    });
    /******/ if (mode & 2 && typeof value != "string")
      for (var key in value)
        __webpack_require__.d(
          ns,
          key,
          function (key) {
            return value[key];
          }.bind(null, key),
        );
    /******/ return ns;
    /******/
  };
  /******/
  /******/ // getDefaultExport function for compatibility with non-harmony modules
  /******/ __webpack_require__.n = function (module) {
    /******/ var getter =
      module && module.__esModule
        ? /******/ function getDefault() {
            return module["default"];
          }
        : /******/ function getModuleExports() {
            return module;
          };
    /******/ __webpack_require__.d(getter, "a", getter);
    /******/ return getter;
    /******/
  };
  /******/
  /******/ // Object.prototype.hasOwnProperty.call
  /******/ __webpack_require__.o = function (object, property) {
    return Object.prototype.hasOwnProperty.call(object, property);
  };
  /******/
  /******/ // __webpack_public_path__
  /******/ __webpack_require__.p = "/";
  /******/
  /******/
  /******/ // Load entry module and return exports
  /******/ return __webpack_require__((__webpack_require__.s = "./admin/reusable_blocks/dist/single_link/single_link.js"));
  /******/
})(
  /************************************************************************/
  /******/ {
    /***/ "./admin/reusable_blocks/dist/single_link/single_link.js":
      /*!***************************************************************!*\
  !*** ./admin/reusable_blocks/dist/single_link/single_link.js ***!
  \***************************************************************/
      /*! no exports provided */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _babel_runtime_helpers_typeof__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
          /*! @babel/runtime/helpers/typeof */ "./node_modules/@babel/runtime/helpers/typeof.js",
        );
        /* harmony import */ var _babel_runtime_helpers_typeof__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/ __webpack_require__.n(
          _babel_runtime_helpers_typeof__WEBPACK_IMPORTED_MODULE_0__,
        );

        /******/
        (function (modules) {
          // webpackBootstrap

          /******/
          // The module cache

          /******/
          var installedModules = {};
          /******/

          /******/
          // The require function

          /******/

          function __webpack_require__(moduleId) {
            /******/

            /******/
            // Check if module is in cache

            /******/
            if (installedModules[moduleId]) {
              /******/
              return installedModules[moduleId].exports;
              /******/
            }
            /******/
            // Create a new module (and put it into the cache)

            /******/

            var module = (installedModules[moduleId] = {
              /******/
              i: moduleId,

              /******/
              l: false,

              /******/
              exports: {},
              /******/
            });
            /******/

            /******/
            // Execute the module function

            /******/

            modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
            /******/

            /******/
            // Flag the module as loaded

            /******/

            module.l = true;
            /******/

            /******/
            // Return the exports of the module

            /******/

            return module.exports;
            /******/
          }
          /******/

          /******/

          /******/
          // expose the modules object (__webpack_modules__)

          /******/

          __webpack_require__.m = modules;
          /******/

          /******/
          // expose the module cache

          /******/

          __webpack_require__.c = installedModules;
          /******/

          /******/
          // define getter function for harmony exports

          /******/

          __webpack_require__.d = function (exports, name, getter) {
            /******/
            if (!__webpack_require__.o(exports, name)) {
              /******/
              Object.defineProperty(exports, name, {
                enumerable: true,
                get: getter,
              });
              /******/
            }
            /******/
          };
          /******/

          /******/
          // define __esModule on exports

          /******/

          __webpack_require__.r = function (exports) {
            /******/
            if (typeof Symbol !== "undefined" && Symbol.toStringTag) {
              /******/
              Object.defineProperty(exports, Symbol.toStringTag, {
                value: "Module",
              });
              /******/
            }
            /******/

            Object.defineProperty(exports, "__esModule", {
              value: true,
            });
            /******/
          };
          /******/

          /******/
          // create a fake namespace object

          /******/
          // mode & 1: value is a module id, require it

          /******/
          // mode & 2: merge all properties of value into the ns

          /******/
          // mode & 4: return value when already ns object

          /******/
          // mode & 8|1: behave like require

          /******/

          __webpack_require__.t = function (value, mode) {
            /******/
            if (mode & 1) value = __webpack_require__(value);
            /******/

            if (mode & 8) return value;
            /******/

            if (
              mode & 4 &&
              _babel_runtime_helpers_typeof__WEBPACK_IMPORTED_MODULE_0___default()(value) === "object" &&
              value &&
              value.__esModule
            )
              return value;
            /******/

            var ns = Object.create(null);
            /******/

            __webpack_require__.r(ns);
            /******/

            Object.defineProperty(ns, "default", {
              enumerable: true,
              value: value,
            });
            /******/

            if (mode & 2 && typeof value != "string")
              for (var key in value) {
                __webpack_require__.d(
                  ns,
                  key,
                  function (key) {
                    return value[key];
                  }.bind(null, key),
                );
              }
            /******/

            return ns;
            /******/
          };
          /******/

          /******/
          // getDefaultExport function for compatibility with non-harmony modules

          /******/

          __webpack_require__.n = function (module) {
            /******/
            var getter =
              module && module.__esModule
                ? /******/
                  function getDefault() {
                    return module["default"];
                  }
                : /******/
                  function getModuleExports() {
                    return module;
                  };
            /******/

            __webpack_require__.d(getter, "a", getter);
            /******/

            return getter;
            /******/
          };
          /******/

          /******/
          // Object.prototype.hasOwnProperty.call

          /******/

          __webpack_require__.o = function (object, property) {
            return Object.prototype.hasOwnProperty.call(object, property);
          };
          /******/

          /******/
          // __webpack_public_path__

          /******/

          __webpack_require__.p = "/";
          /******/

          /******/

          /******/
          // Load entry module and return exports

          /******/

          return __webpack_require__((__webpack_require__.s = "./admin/reusable_blocks/src/single_link/single_link.js"));
          /******/
        })(
          /************************************************************************/

          /******/
          {
            /***/
            "./admin/reusable_blocks/src/single_link/single_link.js":
              /*!**************************************************************!*\
    !*** ./admin/reusable_blocks/src/single_link/single_link.js ***!
    \**************************************************************/

              /*! no exports provided */

              /***/
              function adminReusable_blocksSrcSingle_linkSingle_linkJs(module, __webpack_exports__, __webpack_require__) {
                "use strict";

                __webpack_require__.r(__webpack_exports__);
                /* harmony import */

                var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
                  /*! @wordpress/element */
                  "@wordpress/element",
                );
                /* harmony import */

                var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/ __webpack_require__.n(
                  _wordpress_element__WEBPACK_IMPORTED_MODULE_0__,
                );
                /* harmony import */

                var _single_link_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
                  /*! ./single_link.scss */
                  "./admin/reusable_blocks/src/single_link/single_link.scss",
                );
                /* harmony import */

                var _single_link_scss__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/ __webpack_require__.n(
                  _single_link_scss__WEBPACK_IMPORTED_MODULE_1__,
                );

                var registerBlockType = wp.blocks.registerBlockType;
                var RichText = wp.blockEditor.RichText;
                /**
                 *
                 * Editor React Component
                 */

                var SingleLinkEditor = function SingleLinkEditor(_ref) {
                  var attributes = _ref.attributes,
                    setAttributes = _ref.setAttributes;

                  var changeTitleHandler = function changeTitleHandler(value) {
                    setAttributes({
                      title: value,
                    });
                  };

                  var changeLinkHandler = function changeLinkHandler(value) {
                    setAttributes({
                      link: value,
                    });
                  };

                  return [
                    Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(
                      "div",
                      {
                        className: "single_link",
                      },
                      Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("label", null, "Link de descarga"),
                      Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(RichText, {
                        placeholder: "Escribe el title",
                        value: attributes.title,
                        onChange: changeTitleHandler,
                      }),
                      Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(RichText, {
                        placeholder: "Escribe el link",
                        value: attributes.link,
                        onChange: changeLinkHandler,
                      }),
                      Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(
                        "p",
                        null,
                        Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(
                          "small",
                          null,
                          "Este link se meter\xE1 en el set de links de descargas al final de cada secci\xF3n.",
                        ),
                      ),
                    ),
                  ];
                };
                /**
                 *
                 * Saving React Component
                 *
                 * Sigo intentado...
                 */

                var SingleLinkSave = function SingleLinkSave(_ref2) {
                  var attributes = _ref2.attributes;
                  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(
                    "div",
                    {
                      className: "single_link",
                    },
                    Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(
                      "a",
                      {
                        href: attributes.link,
                      },
                      attributes.title,
                    ),
                  );
                };

                registerBlockType("esd/single-link", {
                  title: "Single Link",
                  description: "Block to generate a single link",
                  icon: "format-image",
                  category: "text",
                  attributes: {
                    title: {
                      type: "string",
                    },
                    link: {
                      type: "string",
                    },
                  },
                  edit: function edit(props) {
                    return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(SingleLinkEditor, props);
                  },
                  save: function save(props) {
                    return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(SingleLinkSave, props);
                  },
                });
                /***/
              },

            /***/
            "./admin/reusable_blocks/src/single_link/single_link.scss":
              /*!****************************************************************!*\
    !*** ./admin/reusable_blocks/src/single_link/single_link.scss ***!
    \****************************************************************/

              /*! no static exports found */

              /***/
              function adminReusable_blocksSrcSingle_linkSingle_linkScss(module, exports, __webpack_require__) {
                // extracted by mini-css-extract-plugin
                /***/
              },

            /***/
            "@wordpress/element":
              /*!******************************************!*\
    !*** external {"this":["wp","element"]} ***!
    \******************************************/

              /*! no static exports found */

              /***/
              function wordpressElement(module, exports) {
                (function () {
                  module.exports = this["wp"]["element"];
                })();
                /***/
              },
            /******/
          },
        );

        /***/
      },

    /***/ "./node_modules/@babel/runtime/helpers/typeof.js":
      /*!*******************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/typeof.js ***!
  \*******************************************************/
      /*! no static exports found */
      /***/ function (module, exports) {
        function _typeof(obj) {
          "@babel/helpers - typeof";

          if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
            module.exports = _typeof = function _typeof(obj) {
              return typeof obj;
            };
          } else {
            module.exports = _typeof = function _typeof(obj) {
              return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
            };
          }

          return _typeof(obj);
        }

        module.exports = _typeof;

        /***/
      },

    /******/
  },
);
//# sourceMappingURL=single_link.js.map
