class Toolbar {
    constructor(containerClass = 'toolbar') {
        this.$container = $('<div>').addClass(containerClass);
        this.clientMapping = [
            { label: 'Client A', value: 'clienta' },
            { label: 'Client B', value: 'clientb' },
            { label: 'Client C', value: 'clientc' }
        ];
        this.injectStylesheet('assets/css/toolbar.css');
        this.render();
        this.activateExistingClient();
    }

    injectStylesheet(href) {
        const $link = $('<link>', { rel: 'stylesheet', href });
        $('head').append($link);
    }

    setCookieValue(name, value, maxAgeSeconds = 86400) {
        document.cookie = `${name}=${encodeURIComponent(value)}; path=/; max-age=${maxAgeSeconds}; SameSite=Lax`;
    }

    markActiveButton($button) {
        this.$container.find('button').removeClass('active');
        if ($button && $button.length) $button.addClass('active');
    }

    render() {
        this.clientMapping.forEach(mapping => {
            const $button = $('<button>').text(`Simuler ${mapping.label}`).attr('data-client', mapping.value);
            $button.on('click', () => {
                this.setCookieValue('client', mapping.value);
                this.markActiveButton($button);
                if (window.loadDynamic && typeof window.loadDynamic === 'function') window.loadDynamic();
            });
            this.$container.append($button);
        });

        const $closeButton = $('<button>').text('Fermer').addClass('toolbar-close');
        $closeButton.on('click', () => {
            this.$container.remove();
            document.body.style.paddingTop = null;
        });
        this.$container.append($closeButton);

        $('body').prepend(this.$container);
    }

    getCookieValue(name) {
        const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        return match ? decodeURIComponent(match[2]) : null;
    }

    activateExistingClient() {
        const existingClient = this.getCookieValue('client');
        if (!existingClient) return;
        const $btn = this.$container.find(`button[data-client="${existingClient}"]`);
        if ($btn.length) this.markActiveButton($btn);
    }
}

new Toolbar();

export default Toolbar;
