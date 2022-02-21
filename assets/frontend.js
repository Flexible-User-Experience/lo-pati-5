// styles
import './styles/fonts.scss';
import './styles/app.scss';

// BS import
require('bootstrap');

// Stimulus application
import './stimulus_bootstrap';

// Search engine autofocus
let searchOffcanvas = document.getElementById('offcanvasSearch');
searchOffcanvas.addEventListener('shown.bs.offcanvas', function () {
    document.getElementById('inputOffcanvasSearchField').focus();
});
searchOffcanvas.addEventListener('hidden.bs.offcanvas', function () {
    let inputNode = document.getElementById('inputOffcanvasSearchField');
    inputNode.value = '';
});
