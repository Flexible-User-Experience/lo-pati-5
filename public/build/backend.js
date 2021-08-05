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



pdfjs_dist_lib_pdf__WEBPACK_IMPORTED_MODULE_2__.GlobalWorkerOptions.workerSrc = __webpack_require__(/*! pdfjs-dist/build/pdf.worker.entry.js */ "./node_modules/pdfjs-dist/build/pdf.worker.entry.js"); // import pdfjsWorker from 'pdfjs-dist/build/pdf.worker.entry';
// GlobalWorkerOptions.workerSrc = pdfjsWorker;

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
/******/ __webpack_require__.O(0, ["vendors-node_modules_symfony_stimulus-bridge_dist_index_js-node_modules_core-js_modules_es_da-a5f826","vendors-node_modules_jquery_dist_jquery_js","node_modules_symfony_stimulus-bridge_dist_webpack_loader_js_assets_controllers_json-assets_bo-c9ceb2"], () => (__webpack_exec__("./assets/backend.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYmFja2VuZC5qcyIsIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7OztBQUFBO0NBR0E7O0FBQ0E7QUFDQTtBQUNBRSw2RUFBQSxHQUFnQ0UsbUJBQU8sQ0FBQyxpR0FBRCxDQUF2QyxFQUNBO0FBQ0E7O0FBRUFKLDZDQUFNLENBQUNLLFFBQUQsQ0FBTixDQUFpQkMsS0FBakIsQ0FBdUIsWUFBVztBQUM5QixNQUFJQyxjQUFjLEdBQUdQLDZDQUFNLENBQUMsZUFBRCxDQUEzQjs7QUFEOEIsNkJBRXJCUSxLQUZxQjtBQUcxQixRQUFJQyxhQUFhLEdBQUdGLGNBQWMsQ0FBQ0MsS0FBRCxDQUFsQztBQUNBLFFBQUlFLEVBQUUsR0FBR0QsYUFBYSxDQUFDQyxFQUF2QjtBQUNBLFFBQUlDLElBQUksR0FBR1gsNkNBQU0sQ0FBQyxNQUFNVSxFQUFQLENBQWpCO0FBQ0EsUUFBSUUsWUFBWSxHQUFHRCxJQUFJLENBQUNFLElBQUwsQ0FBVSxlQUFWLENBQW5CO0FBQ0EsUUFBSUMsV0FBVyxHQUFHYiwrREFBVyxDQUFDVyxZQUFELENBQTdCO0FBQ0FFLElBQUFBLFdBQVcsQ0FBQ0MsT0FBWixDQUFvQkMsSUFBcEIsQ0FBeUIsVUFBQ0MsR0FBRCxFQUFTO0FBQzlCQSxNQUFBQSxHQUFHLENBQUNDLE9BQUosQ0FBWSxDQUFaLEVBQWVGLElBQWYsQ0FBb0IsVUFBQ0csSUFBRCxFQUFVO0FBQzFCLFlBQUlDLEtBQUssR0FBRyxDQUFaO0FBQ0EsWUFBSUMsUUFBUSxHQUFHRixJQUFJLENBQUNHLFdBQUwsQ0FBaUI7QUFBRUYsVUFBQUEsS0FBSyxFQUFFQTtBQUFULFNBQWpCLENBQWY7QUFDQSxZQUFJRyxNQUFNLEdBQUdsQixRQUFRLENBQUNtQixjQUFULENBQXdCLGdCQUFnQmQsRUFBeEMsQ0FBYjtBQUNBLFlBQUllLE9BQU8sR0FBR0YsTUFBTSxDQUFDRyxVQUFQLENBQWtCLElBQWxCLENBQWQ7QUFDQUgsUUFBQUEsTUFBTSxDQUFDSSxNQUFQLEdBQWdCTixRQUFRLENBQUNNLE1BQXpCO0FBQ0FKLFFBQUFBLE1BQU0sQ0FBQ0ssS0FBUCxHQUFlUCxRQUFRLENBQUNPLEtBQXhCO0FBQ0EsWUFBSUMsYUFBYSxHQUFHO0FBQ2hCQyxVQUFBQSxhQUFhLEVBQUVMLE9BREM7QUFFaEJKLFVBQUFBLFFBQVEsRUFBRUE7QUFGTSxTQUFwQjtBQUlBRixRQUFBQSxJQUFJLENBQUNZLE1BQUwsQ0FBWUYsYUFBWjtBQUNILE9BWkQsRUFZRyxVQUFDRyxRQUFELEVBQWM7QUFDYkMsUUFBQUEsT0FBTyxDQUFDQyxLQUFSLENBQWMsa0JBQWtCdEIsWUFBbEIsR0FBaUMsc0JBQS9DLEVBQXVFb0IsUUFBdkU7QUFDSCxPQWREO0FBZUgsS0FoQkQsRUFnQkcsVUFBQ0EsUUFBRCxFQUFjO0FBQ2JDLE1BQUFBLE9BQU8sQ0FBQ0MsS0FBUixDQUFjLGtCQUFrQnRCLFlBQWxCLEdBQWlDLG9CQUEvQyxFQUFxRW9CLFFBQXJFO0FBQ0gsS0FsQkQ7QUFSMEI7O0FBRTlCLE9BQUssSUFBSXhCLEtBQUssR0FBRyxDQUFqQixFQUFvQkEsS0FBSyxHQUFHRCxjQUFjLENBQUM0QixNQUEzQyxFQUFtRDNCLEtBQUssRUFBeEQsRUFBNEQ7QUFBQSxVQUFuREEsS0FBbUQ7QUF5QjNEO0FBQ0osQ0E1QkQiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvYmFja2VuZC5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyIvLyBTdGltdWx1cyBhcHBsaWNhdGlvblxuaW1wb3J0ICcuL2Jvb3RzdHJhcCc7XG5cbi8vIHN0YXJ0IFBERiBKUyBsaWJyYXJ5XG5pbXBvcnQgalF1ZXJ5IGZyb20gJ2pxdWVyeSc7XG5pbXBvcnQgeyBnZXREb2N1bWVudCwgR2xvYmFsV29ya2VyT3B0aW9ucyB9IGZyb20gJ3BkZmpzLWRpc3QvbGliL3BkZic7XG5HbG9iYWxXb3JrZXJPcHRpb25zLndvcmtlclNyYyA9IHJlcXVpcmUoJ3BkZmpzLWRpc3QvYnVpbGQvcGRmLndvcmtlci5lbnRyeS5qcycpO1xuLy8gaW1wb3J0IHBkZmpzV29ya2VyIGZyb20gJ3BkZmpzLWRpc3QvYnVpbGQvcGRmLndvcmtlci5lbnRyeSc7XG4vLyBHbG9iYWxXb3JrZXJPcHRpb25zLndvcmtlclNyYyA9IHBkZmpzV29ya2VyO1xuXG5qUXVlcnkoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCkge1xuICAgIGxldCBwZGZIb2xkZXJOb2RlcyA9IGpRdWVyeSgnW2RhdGEtaG9sZGVyXScpO1xuICAgIGZvciAobGV0IGluZGV4ID0gMDsgaW5kZXggPCBwZGZIb2xkZXJOb2Rlcy5sZW5ndGg7IGluZGV4KyspIHtcbiAgICAgICAgbGV0IHBkZkhvbGRlck5vZGUgPSBwZGZIb2xkZXJOb2Rlc1tpbmRleF07XG4gICAgICAgIGxldCBpZCA9IHBkZkhvbGRlck5vZGUuaWQ7XG4gICAgICAgIGxldCBub2RlID0galF1ZXJ5KCcjJyArIGlkKTtcbiAgICAgICAgbGV0IGRvd25sb2FkUGF0aCA9IG5vZGUuYXR0cignZGF0YS1kb3dubG9hZCcpO1xuICAgICAgICBsZXQgbG9hZGluZ1Rhc2sgPSBnZXREb2N1bWVudChkb3dubG9hZFBhdGgpO1xuICAgICAgICBsb2FkaW5nVGFzay5wcm9taXNlLnRoZW4oKHBkZikgPT4ge1xuICAgICAgICAgICAgcGRmLmdldFBhZ2UoMSkudGhlbigocGFnZSkgPT4ge1xuICAgICAgICAgICAgICAgIGxldCBzY2FsZSA9IDE7XG4gICAgICAgICAgICAgICAgbGV0IHZpZXdwb3J0ID0gcGFnZS5nZXRWaWV3cG9ydCh7IHNjYWxlOiBzY2FsZSwgfSk7XG4gICAgICAgICAgICAgICAgbGV0IGNhbnZhcyA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdjYW52YXMtcGRmLScgKyBpZCk7XG4gICAgICAgICAgICAgICAgbGV0IGNvbnRleHQgPSBjYW52YXMuZ2V0Q29udGV4dCgnMmQnKTtcbiAgICAgICAgICAgICAgICBjYW52YXMuaGVpZ2h0ID0gdmlld3BvcnQuaGVpZ2h0O1xuICAgICAgICAgICAgICAgIGNhbnZhcy53aWR0aCA9IHZpZXdwb3J0LndpZHRoO1xuICAgICAgICAgICAgICAgIGxldCByZW5kZXJDb250ZXh0ID0ge1xuICAgICAgICAgICAgICAgICAgICBjYW52YXNDb250ZXh0OiBjb250ZXh0LFxuICAgICAgICAgICAgICAgICAgICB2aWV3cG9ydDogdmlld3BvcnRcbiAgICAgICAgICAgICAgICB9O1xuICAgICAgICAgICAgICAgIHBhZ2UucmVuZGVyKHJlbmRlckNvbnRleHQpO1xuICAgICAgICAgICAgfSwgKGVycm9yR2V0KSA9PiB7XG4gICAgICAgICAgICAgICAgY29uc29sZS5lcnJvcignRXJyb3IgZHVyaW5nICcgKyBkb3dubG9hZFBhdGggKyAnIGxvYWRpbmcgZmlyc3QgcGFnZTonLCBlcnJvckdldCk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfSwgKGVycm9yR2V0KSA9PiB7XG4gICAgICAgICAgICBjb25zb2xlLmVycm9yKCdFcnJvciBkdXJpbmcgJyArIGRvd25sb2FkUGF0aCArICcgbG9hZGluZyBkb2N1bWVudDonLCBlcnJvckdldCk7XG4gICAgICAgIH0pO1xuICAgIH1cbn0pO1xuIl0sIm5hbWVzIjpbImpRdWVyeSIsImdldERvY3VtZW50IiwiR2xvYmFsV29ya2VyT3B0aW9ucyIsIndvcmtlclNyYyIsInJlcXVpcmUiLCJkb2N1bWVudCIsInJlYWR5IiwicGRmSG9sZGVyTm9kZXMiLCJpbmRleCIsInBkZkhvbGRlck5vZGUiLCJpZCIsIm5vZGUiLCJkb3dubG9hZFBhdGgiLCJhdHRyIiwibG9hZGluZ1Rhc2siLCJwcm9taXNlIiwidGhlbiIsInBkZiIsImdldFBhZ2UiLCJwYWdlIiwic2NhbGUiLCJ2aWV3cG9ydCIsImdldFZpZXdwb3J0IiwiY2FudmFzIiwiZ2V0RWxlbWVudEJ5SWQiLCJjb250ZXh0IiwiZ2V0Q29udGV4dCIsImhlaWdodCIsIndpZHRoIiwicmVuZGVyQ29udGV4dCIsImNhbnZhc0NvbnRleHQiLCJyZW5kZXIiLCJlcnJvckdldCIsImNvbnNvbGUiLCJlcnJvciIsImxlbmd0aCJdLCJzb3VyY2VSb290IjoiIn0=