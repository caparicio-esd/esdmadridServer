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
  /******/ return __webpack_require__((__webpack_require__.s = "./admin/reusable_blocks/src/notifications/notifications.js"));
  /******/
})(
  /************************************************************************/
  /******/ {
    /***/ "./admin/reusable_blocks/src/notifications/notifications.js":
      /*!******************************************************************!*\
  !*** ./admin/reusable_blocks/src/notifications/notifications.js ***!
  \******************************************************************/
      /*! no exports provided */
      /***/ function (module, __webpack_exports__, __webpack_require__) {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        /* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
          /*! @babel/runtime/helpers/slicedToArray */ "./node_modules/@babel/runtime/helpers/slicedToArray.js",
        );
        /* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0___default =
          /*#__PURE__*/ __webpack_require__.n(_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__);
        /* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
          /*! @wordpress/element */ "@wordpress/element",
        );
        /* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/ __webpack_require__.n(
          _wordpress_element__WEBPACK_IMPORTED_MODULE_1__,
        );
        /* harmony import */ var react__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react */ "react");
        /* harmony import */ var react__WEBPACK_IMPORTED_MODULE_2___default =
          /*#__PURE__*/ __webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_2__);
        /* harmony import */ var _notifications_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
          /*! ./notifications.scss */ "./admin/reusable_blocks/src/notifications/notifications.scss",
        );
        /* harmony import */ var _notifications_scss__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/ __webpack_require__.n(
          _notifications_scss__WEBPACK_IMPORTED_MODULE_3__,
        );

        var registerBlockType = wp.blocks.registerBlockType;
        var _wp$blockEditor = wp.blockEditor,
          RichText = _wp$blockEditor.RichText,
          InspectorControls = _wp$blockEditor.InspectorControls,
          InnerBlocks = _wp$blockEditor.InnerBlocks;
        var _wp$components = wp.components,
          PanelBody = _wp$components.PanelBody,
          SelectControl = _wp$components.SelectControl;

        var ALLOWED_BLOCKS = ["core/heading", "core/paragraph"];
        /**
         *
         * Editor React Component
         */

        var NotificationEditor = function NotificationEditor(_ref) {
          var attributes = _ref.attributes,
            setAttributes = _ref.setAttributes;

          var _useState = Object(react__WEBPACK_IMPORTED_MODULE_2__["useState"])(""),
            _useState2 = _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0___default()(_useState, 2),
            formattedType = _useState2[0],
            setFormattedType = _useState2[1];

          var _useState3 = Object(react__WEBPACK_IMPORTED_MODULE_2__["useState"])(""),
            _useState4 = _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0___default()(_useState3, 2),
            notificationType = _useState4[0],
            setNotificationType = _useState4[1];

          var contentChangeHandler = function contentChangeHandler(value) {
            setAttributes({
              content: value,
            });
          };

          var notificationTypeChangeHandler = function notificationTypeChangeHandler(value) {
            setAttributes({
              type: value,
            });
          };

          Object(react__WEBPACK_IMPORTED_MODULE_2__["useEffect"])(
            function () {
              var fType = attributes.type[0].toUpperCase() + attributes.type.slice(1);
              var nType = "notification_".concat(attributes.type);
              setFormattedType(fType);
              setNotificationType(nType);
            },
            [attributes.type],
          );
          return [
            Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(
              InspectorControls,
              {
                style: {
                  marginBottom: "2rem",
                },
                key: "inpector",
              },
              Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(
                PanelBody,
                {
                  title: "Font Color Settings",
                },
                Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(
                  "p",
                  null,
                  Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])("strong", null, "Select a title"),
                  ":",
                ),
                Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(SelectControl, {
                  label: "Selecciona un nivel de notificación:",
                  value: attributes.type, // e.g: value = [ 'a', 'c' ]
                  onChange: notificationTypeChangeHandler,
                  options: [
                    {
                      value: null,
                      label: "Selecciona un nivel de notificación",
                      disabled: true,
                    },
                    {
                      value: "normal",
                      label: "Nivel Normal",
                    },
                    {
                      value: "esd",
                      label: "Nivel ESD",
                    },
                    {
                      value: "info",
                      label: "Nivel Info",
                    },
                    {
                      value: "danger",
                      label: "Nivel Danger",
                    },
                    {
                      value: "warning",
                      label: "Nivel Warning",
                    },
                    {
                      value: "success",
                      label: "Nivel Success",
                    },
                  ],
                }),
              ),
            ),
            Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(
              "div",
              {
                className: ["notification", notificationType].join(" "),
                key: "edition",
              },
              Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])("h5", null, "Notificaci\xF3n nivel ", formattedType),
              Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(InnerBlocks, {
                allowedBlocks: ALLOWED_BLOCKS,
              }),
            ),
          ];
        };
        /**
         *
         * Saving React Component
         */

        var NotificationSave = function NotificationSave(_ref2) {
          var attributes = _ref2.attributes;
          return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(
            "div",
            {
              className: ["notification", "notification_".concat(attributes.type)].join(" "),
            },
            Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(InnerBlocks.Content, null),
          );
        };

        registerBlockType("esd/notification", {
          title: "Notification",
          description: "Block to generate a Notification in ESD",
          icon: "admin-comments",
          category: "text",
          attributes: {
            content: {
              type: "string",
              source: "html",
            },
            type: {
              type: "string",
              default: "normal",
            },
          },
          edit: function edit(props) {
            return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(NotificationEditor, props);
          },
          save: function save(props) {
            return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__["createElement"])(NotificationSave, props);
          },
        });

        /***/
      },

    /***/ "./admin/reusable_blocks/src/notifications/notifications.scss":
      /*!********************************************************************!*\
  !*** ./admin/reusable_blocks/src/notifications/notifications.scss ***!
  \********************************************************************/
      /*! no static exports found */
      /***/ function (module, exports, __webpack_require__) {
        // extracted by mini-css-extract-plugin
        /***/
      },

    /***/ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js":
      /*!*****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/arrayLikeToArray.js ***!
  \*****************************************************************/
      /*! no static exports found */
      /***/ function (module, exports) {
        function _arrayLikeToArray(arr, len) {
          if (len == null || len > arr.length) len = arr.length;

          for (var i = 0, arr2 = new Array(len); i < len; i++) {
            arr2[i] = arr[i];
          }

          return arr2;
        }

        module.exports = _arrayLikeToArray;

        /***/
      },

    /***/ "./node_modules/@babel/runtime/helpers/arrayWithHoles.js":
      /*!***************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/arrayWithHoles.js ***!
  \***************************************************************/
      /*! no static exports found */
      /***/ function (module, exports) {
        function _arrayWithHoles(arr) {
          if (Array.isArray(arr)) return arr;
        }

        module.exports = _arrayWithHoles;

        /***/
      },

    /***/ "./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js":
      /*!*********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js ***!
  \*********************************************************************/
      /*! no static exports found */
      /***/ function (module, exports) {
        function _iterableToArrayLimit(arr, i) {
          if (typeof Symbol === "undefined" || !(Symbol.iterator in Object(arr))) return;
          var _arr = [];
          var _n = true;
          var _d = false;
          var _e = undefined;

          try {
            for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) {
              _arr.push(_s.value);

              if (i && _arr.length === i) break;
            }
          } catch (err) {
            _d = true;
            _e = err;
          } finally {
            try {
              if (!_n && _i["return"] != null) _i["return"]();
            } finally {
              if (_d) throw _e;
            }
          }

          return _arr;
        }

        module.exports = _iterableToArrayLimit;

        /***/
      },

    /***/ "./node_modules/@babel/runtime/helpers/nonIterableRest.js":
      /*!****************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/nonIterableRest.js ***!
  \****************************************************************/
      /*! no static exports found */
      /***/ function (module, exports) {
        function _nonIterableRest() {
          throw new TypeError(
            "Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.",
          );
        }

        module.exports = _nonIterableRest;

        /***/
      },

    /***/ "./node_modules/@babel/runtime/helpers/slicedToArray.js":
      /*!**************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/slicedToArray.js ***!
  \**************************************************************/
      /*! no static exports found */
      /***/ function (module, exports, __webpack_require__) {
        var arrayWithHoles = __webpack_require__(/*! ./arrayWithHoles */ "./node_modules/@babel/runtime/helpers/arrayWithHoles.js");

        var iterableToArrayLimit = __webpack_require__(
          /*! ./iterableToArrayLimit */ "./node_modules/@babel/runtime/helpers/iterableToArrayLimit.js",
        );

        var unsupportedIterableToArray = __webpack_require__(
          /*! ./unsupportedIterableToArray */ "./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js",
        );

        var nonIterableRest = __webpack_require__(/*! ./nonIterableRest */ "./node_modules/@babel/runtime/helpers/nonIterableRest.js");

        function _slicedToArray(arr, i) {
          return arrayWithHoles(arr) || iterableToArrayLimit(arr, i) || unsupportedIterableToArray(arr, i) || nonIterableRest();
        }

        module.exports = _slicedToArray;

        /***/
      },

    /***/ "./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js":
      /*!***************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js ***!
  \***************************************************************************/
      /*! no static exports found */
      /***/ function (module, exports, __webpack_require__) {
        var arrayLikeToArray = __webpack_require__(/*! ./arrayLikeToArray */ "./node_modules/@babel/runtime/helpers/arrayLikeToArray.js");

        function _unsupportedIterableToArray(o, minLen) {
          if (!o) return;
          if (typeof o === "string") return arrayLikeToArray(o, minLen);
          var n = Object.prototype.toString.call(o).slice(8, -1);
          if (n === "Object" && o.constructor) n = o.constructor.name;
          if (n === "Map" || n === "Set") return Array.from(o);
          if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return arrayLikeToArray(o, minLen);
        }

        module.exports = _unsupportedIterableToArray;

        /***/
      },

    /***/ "@wordpress/element":
      /*!******************************************!*\
  !*** external {"this":["wp","element"]} ***!
  \******************************************/
      /*! no static exports found */
      /***/ function (module, exports) {
        (function () {
          module.exports = this["wp"]["element"];
        })();

        /***/
      },

    /***/ react:
      /*!*********************************!*\
  !*** external {"this":"React"} ***!
  \*********************************/
      /*! no static exports found */
      /***/ function (module, exports) {
        (function () {
          module.exports = this["React"];
        })();

        /***/
      },

    /******/
  },
);
//# sourceMappingURL=notifications.js.map
