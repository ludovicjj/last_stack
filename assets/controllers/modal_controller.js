import { Controller } from '@hotwired/stimulus';


export default class extends Controller {
    static targets = ['dialog', 'dynamicContent', 'loadingContent', 'dialogClose'];
    observer = null;

    connect() {
        if (this.hasDynamicContentTarget) {
            // when the content changes, call this.open()
            this.observer = new MutationObserver(() => {
                const shouldOpen = this.dynamicContentTarget.innerHTML.trim().length > 0;
                if (shouldOpen && !this.dialogTarget.open) {
                    this.open();
                } else if (!shouldOpen && this.dialogTarget.open) {
                    this.close();
                }
            });
            this.observer.observe(this.dynamicContentTarget, {
                childList: true,
                characterData: true,
                subtree: true
            });
        }
    }

    disconnect() {
        if (this.observer) {
            this.observer.disconnect();
        }
        if (this.dialogTarget.open) {
            this.close();
        }
    }

    showLoading() {
        // do nothing if the dialog is already open
        if (this.dialogTarget.open) {
            return;
        }
        this.dynamicContentTarget.innerHTML = this.loadingContentTarget.innerHTML;
    }

    async beforeRender(event) {
        // prevent render frame content if modal already closed
        if (!this.dialogTarget.open) {
            event.preventDefault()
            this.close()
        }
    }

    submitStart() {
        this.dynamicContentTarget.classList.add('opacity-50')
    }

    submitEnd() {
        this.dynamicContentTarget.classList.remove('opacity-50')
    }

    open() {
        this.dialogTarget.showModal();
        document.body.classList.add('overflow-hidden');
    }

    clickOutside(event) {
        if (event.target === this.dialogTarget) {
            this.close()
        }
    }

    close() {
        this.dialogTarget.classList.add('fade-out');

        setTimeout(() => {
            this.dialogTarget.close();
            this.dialogTarget.classList.remove('fade-out'); // Réinitialiser la classe
            document.body.classList.remove('overflow-hidden');
        }, 250);
    }
}