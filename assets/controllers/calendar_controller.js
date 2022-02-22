import { Controller } from '@hotwired/stimulus';
import axios from 'axios';
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';

const routes = require('../../public/js/fos_js_routes.json');

export default class extends Controller {
    static targets = [ 'agenda' ]
    static values = {
        month: Number,
        year: Number,
    }

    connect() {
        Routing.setRoutingData(routes);
        this.postCalendar();
    }

    previous() {
        this.agendaTarget.innerHTML = '<i class="fas fa-spin fa-circle-notch fa-5x"></i>';
        this.monthValue--;
        if (this.monthValue === 0) {
            this.monthValue = 12;
            this.yearValue--;
        }
        this.postCalendar();
    }

    next() {
        this.agendaTarget.innerHTML = '<i class="fas fa-spin fa-circle-notch fa-5x"></i>';
        this.monthValue++;
        if (this.monthValue === 13) {
            this.monthValue = 1;
            this.yearValue++;
        }
        this.postCalendar();
    }

    postCalendar() {
        let self = this;
        axios.post(Routing.generate('front_app_calendar'), {month: this.monthValue, year: this.yearValue})
            .then(function (response) {
                if (response.hasOwnProperty('data') && response.hasOwnProperty('status') && response.status === 200) {
                    self.agendaTarget.innerHTML = response.data;
                } else {
                    self.agendaTarget.innerHTML = '<i class="fas fa-exclamation-triangle lp-c-light-grey"></i>';
                    console.error('[Calendar::connect] axios get response error');
                }
            })
            .catch(function (error) {
                self.agendaTarget.innerHTML = '<i class="fas fa-exclamation-triangle lp-c-light-grey"></i>';
                console.error('[Calendar::connect] axios get error response', error);
            })
        ;
    }
}
