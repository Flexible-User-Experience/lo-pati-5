import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [ 'carousel', 'indicators' ];

    connect() {
        this.carouselTarget.addEventListener('slide.bs.carousel', (event) => {
            let elementChildrens = this.indicatorsTarget.children;
            elementChildrens.item(event.from).classList.remove('active');
            elementChildrens.item(event.to).classList.add('active');
        });
    }
}
