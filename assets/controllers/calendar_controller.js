import { Controller } from 'stimulus';

export default class extends Controller {
    static targets = [ 'agenda' ]

    connect() {
        console.log('[Calendar::connect] hit');
    }
    //
    // clicked() {
    //     const event = new CustomEvent('app-pdf-preview-button-clicked', {detail: {attachment: this.attachmentValue, path: this.pathValue}});
    //     window.dispatchEvent(event);
    // }
}
