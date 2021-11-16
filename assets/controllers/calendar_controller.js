import { Controller } from 'stimulus';
import axios from 'axios';
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

const routes = require('../../public/js/fos_js_routes.json');

export default class extends Controller {
    static targets = [ 'agenda' ]

    connect() {
        let self = this;
        Routing.setRoutingData(routes);
        console.log('[Calendar::connect] hit', Routing.generate('front_app_calendar'));
        axios.get(Routing.generate('front_app_calendar'))
            .then(function (response) {
                console.log('[Calendar::connect] axios get response', response);
                if (response.hasOwnProperty('data') && response.hasOwnProperty('status') && response.status === 200) {
                    // draw calendar
                    self.agendaTarget.innerHTML = response.data;
                } else {
                    // draw error
                    console.error('[Calendar::connect] axios get response error');
                }

            })
            .catch(function (error) {
                console.error('[Calendar::connect] axios get error response', error);
            })
        ;
    }

    previous() {
        console.log('[Calendar::previous] clicked');
    }

    next() {
        console.log('[Calendar::next] clicked');
    }
}