import { Controller } from '@hotwired/stimulus';
import { useTransition } from 'stimulus-use';
export default class extends Controller {

    static values = {
        autoClose: Number,
    };
    static targets = ['timerbar']

    connect() {
        useTransition(this, {
            leaveActive: 'fade-leave-active',
            leaveFrom: 'fade-leave-from',
            leaveTo: 'fade-leave-to',
            hiddenClass: 'd-none',
            transitioned: true,
        });

        if (this.autoCloseValue) {
            if (this.hasTimerbarTarget) {
                setTimeout(() => {
                    this.timerbarTarget.style.width = '0%';
                }, 10);
            }
            setTimeout(() => {
                this.close();
            }, this.autoCloseValue);
        }
    }

    close() {
        this.leave();
    }
}