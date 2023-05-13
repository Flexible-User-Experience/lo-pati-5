// Stimulus application
import './stimulus_bootstrap';

// start PDF JS library
import jQuery from 'jquery';
import { getDocument, GlobalWorkerOptions } from 'pdfjs-dist/build/pdf';
GlobalWorkerOptions.workerSrc = require('pdfjs-dist/build/pdf.worker');

jQuery(document).ready(function() {
    let pdfHolderNodes = jQuery('[data-holder]');
    for (let index = 0; index < pdfHolderNodes.length; index++) {
        let pdfHolderNode = pdfHolderNodes[index];
        let id = pdfHolderNode.id;
        let node = jQuery('#' + id);
        let downloadPath = node.attr('data-download');
        let loadingTask = getDocument(downloadPath);
        loadingTask.promise.then((pdf) => {
            pdf.getPage(1).then((page) => {
                let scale = 1;
                let viewport = page.getViewport({ scale: scale, });
                let canvas = document.getElementById('canvas-pdf-' + id);
                let context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                let renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                page.render(renderContext);
            }, (errorGet) => {
                console.error('Error during ' + downloadPath + ' loading first page:', errorGet);
            });
        }, (errorGet) => {
            console.error('Error during ' + downloadPath + ' loading document:', errorGet);
        });
    }
});
