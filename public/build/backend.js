"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["backend"],{

/***/ "./assets/backend.js":
/*!***************************!*\
  !*** ./assets/backend.js ***!
  \***************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _bootstrap__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./bootstrap */ "./assets/bootstrap.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var pdfjs_dist_lib_pdf__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! pdfjs-dist/lib/pdf */ "./node_modules/pdfjs-dist/lib/pdf.js");
// Stimulus application
 // start PDF JS library



pdfjs_dist_lib_pdf__WEBPACK_IMPORTED_MODULE_2__.GlobalWorkerOptions.workerSrc = __webpack_require__(/*! pdfjs-dist/build/pdf.worker.entry.js */ "./node_modules/pdfjs-dist/build/pdf.worker.entry.js");
jquery__WEBPACK_IMPORTED_MODULE_1___default()(document).ready(function () {
  var pdfHolderNodes = jquery__WEBPACK_IMPORTED_MODULE_1___default()('[data-holder]');

  var _loop = function _loop(index) {
    var pdfHolderNode = pdfHolderNodes[index];
    var id = pdfHolderNode.id;
    var node = jquery__WEBPACK_IMPORTED_MODULE_1___default()('#' + id);
    var downloadPath = node.attr('data-download');
    var loadingTask = (0,pdfjs_dist_lib_pdf__WEBPACK_IMPORTED_MODULE_2__.getDocument)(downloadPath);
    loadingTask.promise.then(function (pdf) {
      pdf.getPage(1).then(function (page) {
        var scale = 1;
        var viewport = page.getViewport({
          scale: scale
        });
        var canvas = document.getElementById('canvas-pdf-' + id);
        var context = canvas.getContext('2d');
        canvas.height = viewport.height;
        canvas.width = viewport.width;
        var renderContext = {
          canvasContext: context,
          viewport: viewport
        };
        page.render(renderContext);
      }, function (errorGet) {
        console.error('Error during ' + downloadPath + ' loading first page:', errorGet);
      });
    }, function (errorGet) {
      console.error('Error during ' + downloadPath + ' loading document:', errorGet);
    });
  };

  for (var index = 0; index < pdfHolderNodes.length; index++) {
    _loop(index);
  }
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_symfony_stimulus-bridge_dist_index_js-node_modules_symfony_stimulus-brid-66c068","vendors-node_modules_jquery_dist_jquery_js","node_modules_symfony_stimulus-bridge_dist_webpack_loader_js_assets_controllers_json-assets_bo-c9ceb2"], () => (__webpack_exec__("./assets/backend.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYmFja2VuZC5qcyIsIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7OztBQUFBO0NBR0E7O0FBQ0E7QUFDQTtBQUNBRSw2RUFBQSxHQUFnQ0UsbUJBQU8sQ0FBQyxpR0FBRCxDQUF2QztBQUVBSiw2Q0FBTSxDQUFDSyxRQUFELENBQU4sQ0FBaUJDLEtBQWpCLENBQXVCLFlBQVc7QUFDOUIsTUFBSUMsY0FBYyxHQUFHUCw2Q0FBTSxDQUFDLGVBQUQsQ0FBM0I7O0FBRDhCLDZCQUVyQlEsS0FGcUI7QUFHMUIsUUFBSUMsYUFBYSxHQUFHRixjQUFjLENBQUNDLEtBQUQsQ0FBbEM7QUFDQSxRQUFJRSxFQUFFLEdBQUdELGFBQWEsQ0FBQ0MsRUFBdkI7QUFDQSxRQUFJQyxJQUFJLEdBQUdYLDZDQUFNLENBQUMsTUFBTVUsRUFBUCxDQUFqQjtBQUNBLFFBQUlFLFlBQVksR0FBR0QsSUFBSSxDQUFDRSxJQUFMLENBQVUsZUFBVixDQUFuQjtBQUNBLFFBQUlDLFdBQVcsR0FBR2IsK0RBQVcsQ0FBQ1csWUFBRCxDQUE3QjtBQUNBRSxJQUFBQSxXQUFXLENBQUNDLE9BQVosQ0FBb0JDLElBQXBCLENBQXlCLFVBQUNDLEdBQUQsRUFBUztBQUM5QkEsTUFBQUEsR0FBRyxDQUFDQyxPQUFKLENBQVksQ0FBWixFQUFlRixJQUFmLENBQW9CLFVBQUNHLElBQUQsRUFBVTtBQUMxQixZQUFJQyxLQUFLLEdBQUcsQ0FBWjtBQUNBLFlBQUlDLFFBQVEsR0FBR0YsSUFBSSxDQUFDRyxXQUFMLENBQWlCO0FBQUVGLFVBQUFBLEtBQUssRUFBRUE7QUFBVCxTQUFqQixDQUFmO0FBQ0EsWUFBSUcsTUFBTSxHQUFHbEIsUUFBUSxDQUFDbUIsY0FBVCxDQUF3QixnQkFBZ0JkLEVBQXhDLENBQWI7QUFDQSxZQUFJZSxPQUFPLEdBQUdGLE1BQU0sQ0FBQ0csVUFBUCxDQUFrQixJQUFsQixDQUFkO0FBQ0FILFFBQUFBLE1BQU0sQ0FBQ0ksTUFBUCxHQUFnQk4sUUFBUSxDQUFDTSxNQUF6QjtBQUNBSixRQUFBQSxNQUFNLENBQUNLLEtBQVAsR0FBZVAsUUFBUSxDQUFDTyxLQUF4QjtBQUNBLFlBQUlDLGFBQWEsR0FBRztBQUNoQkMsVUFBQUEsYUFBYSxFQUFFTCxPQURDO0FBRWhCSixVQUFBQSxRQUFRLEVBQUVBO0FBRk0sU0FBcEI7QUFJQUYsUUFBQUEsSUFBSSxDQUFDWSxNQUFMLENBQVlGLGFBQVo7QUFDSCxPQVpELEVBWUcsVUFBQ0csUUFBRCxFQUFjO0FBQ2JDLFFBQUFBLE9BQU8sQ0FBQ0MsS0FBUixDQUFjLGtCQUFrQnRCLFlBQWxCLEdBQWlDLHNCQUEvQyxFQUF1RW9CLFFBQXZFO0FBQ0gsT0FkRDtBQWVILEtBaEJELEVBZ0JHLFVBQUNBLFFBQUQsRUFBYztBQUNiQyxNQUFBQSxPQUFPLENBQUNDLEtBQVIsQ0FBYyxrQkFBa0J0QixZQUFsQixHQUFpQyxvQkFBL0MsRUFBcUVvQixRQUFyRTtBQUNILEtBbEJEO0FBUjBCOztBQUU5QixPQUFLLElBQUl4QixLQUFLLEdBQUcsQ0FBakIsRUFBb0JBLEtBQUssR0FBR0QsY0FBYyxDQUFDNEIsTUFBM0MsRUFBbUQzQixLQUFLLEVBQXhELEVBQTREO0FBQUEsVUFBbkRBLEtBQW1EO0FBeUIzRDtBQUNKLENBNUJEIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vYXNzZXRzL2JhY2tlbmQuanMiXSwic291cmNlc0NvbnRlbnQiOlsiLy8gU3RpbXVsdXMgYXBwbGljYXRpb25cbmltcG9ydCAnLi9ib290c3RyYXAnO1xuXG4vLyBzdGFydCBQREYgSlMgbGlicmFyeVxuaW1wb3J0IGpRdWVyeSBmcm9tICdqcXVlcnknO1xuaW1wb3J0IHsgZ2V0RG9jdW1lbnQsIEdsb2JhbFdvcmtlck9wdGlvbnMgfSBmcm9tICdwZGZqcy1kaXN0L2xpYi9wZGYnO1xuR2xvYmFsV29ya2VyT3B0aW9ucy53b3JrZXJTcmMgPSByZXF1aXJlKCdwZGZqcy1kaXN0L2J1aWxkL3BkZi53b3JrZXIuZW50cnkuanMnKTtcblxualF1ZXJ5KGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcbiAgICBsZXQgcGRmSG9sZGVyTm9kZXMgPSBqUXVlcnkoJ1tkYXRhLWhvbGRlcl0nKTtcbiAgICBmb3IgKGxldCBpbmRleCA9IDA7IGluZGV4IDwgcGRmSG9sZGVyTm9kZXMubGVuZ3RoOyBpbmRleCsrKSB7XG4gICAgICAgIGxldCBwZGZIb2xkZXJOb2RlID0gcGRmSG9sZGVyTm9kZXNbaW5kZXhdO1xuICAgICAgICBsZXQgaWQgPSBwZGZIb2xkZXJOb2RlLmlkO1xuICAgICAgICBsZXQgbm9kZSA9IGpRdWVyeSgnIycgKyBpZCk7XG4gICAgICAgIGxldCBkb3dubG9hZFBhdGggPSBub2RlLmF0dHIoJ2RhdGEtZG93bmxvYWQnKTtcbiAgICAgICAgbGV0IGxvYWRpbmdUYXNrID0gZ2V0RG9jdW1lbnQoZG93bmxvYWRQYXRoKTtcbiAgICAgICAgbG9hZGluZ1Rhc2sucHJvbWlzZS50aGVuKChwZGYpID0+IHtcbiAgICAgICAgICAgIHBkZi5nZXRQYWdlKDEpLnRoZW4oKHBhZ2UpID0+IHtcbiAgICAgICAgICAgICAgICBsZXQgc2NhbGUgPSAxO1xuICAgICAgICAgICAgICAgIGxldCB2aWV3cG9ydCA9IHBhZ2UuZ2V0Vmlld3BvcnQoeyBzY2FsZTogc2NhbGUsIH0pO1xuICAgICAgICAgICAgICAgIGxldCBjYW52YXMgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnY2FudmFzLXBkZi0nICsgaWQpO1xuICAgICAgICAgICAgICAgIGxldCBjb250ZXh0ID0gY2FudmFzLmdldENvbnRleHQoJzJkJyk7XG4gICAgICAgICAgICAgICAgY2FudmFzLmhlaWdodCA9IHZpZXdwb3J0LmhlaWdodDtcbiAgICAgICAgICAgICAgICBjYW52YXMud2lkdGggPSB2aWV3cG9ydC53aWR0aDtcbiAgICAgICAgICAgICAgICBsZXQgcmVuZGVyQ29udGV4dCA9IHtcbiAgICAgICAgICAgICAgICAgICAgY2FudmFzQ29udGV4dDogY29udGV4dCxcbiAgICAgICAgICAgICAgICAgICAgdmlld3BvcnQ6IHZpZXdwb3J0XG4gICAgICAgICAgICAgICAgfTtcbiAgICAgICAgICAgICAgICBwYWdlLnJlbmRlcihyZW5kZXJDb250ZXh0KTtcbiAgICAgICAgICAgIH0sIChlcnJvckdldCkgPT4ge1xuICAgICAgICAgICAgICAgIGNvbnNvbGUuZXJyb3IoJ0Vycm9yIGR1cmluZyAnICsgZG93bmxvYWRQYXRoICsgJyBsb2FkaW5nIGZpcnN0IHBhZ2U6JywgZXJyb3JHZXQpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0sIChlcnJvckdldCkgPT4ge1xuICAgICAgICAgICAgY29uc29sZS5lcnJvcignRXJyb3IgZHVyaW5nICcgKyBkb3dubG9hZFBhdGggKyAnIGxvYWRpbmcgZG9jdW1lbnQ6JywgZXJyb3JHZXQpO1xuICAgICAgICB9KTtcbiAgICB9XG59KTtcbiJdLCJuYW1lcyI6WyJqUXVlcnkiLCJnZXREb2N1bWVudCIsIkdsb2JhbFdvcmtlck9wdGlvbnMiLCJ3b3JrZXJTcmMiLCJyZXF1aXJlIiwiZG9jdW1lbnQiLCJyZWFkeSIsInBkZkhvbGRlck5vZGVzIiwiaW5kZXgiLCJwZGZIb2xkZXJOb2RlIiwiaWQiLCJub2RlIiwiZG93bmxvYWRQYXRoIiwiYXR0ciIsImxvYWRpbmdUYXNrIiwicHJvbWlzZSIsInRoZW4iLCJwZGYiLCJnZXRQYWdlIiwicGFnZSIsInNjYWxlIiwidmlld3BvcnQiLCJnZXRWaWV3cG9ydCIsImNhbnZhcyIsImdldEVsZW1lbnRCeUlkIiwiY29udGV4dCIsImdldENvbnRleHQiLCJoZWlnaHQiLCJ3aWR0aCIsInJlbmRlckNvbnRleHQiLCJjYW52YXNDb250ZXh0IiwicmVuZGVyIiwiZXJyb3JHZXQiLCJjb25zb2xlIiwiZXJyb3IiLCJsZW5ndGgiXSwic291cmNlUm9vdCI6IiJ9