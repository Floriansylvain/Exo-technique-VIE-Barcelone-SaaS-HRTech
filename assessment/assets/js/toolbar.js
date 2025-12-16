class Toolbar {
    constructor(containerClass = 'toolbar') {
        this.$container = $('<div>').addClass(containerClass);
        this.clientMapping = [
            { label: 'Client A', value: 'clienta' },
            { label: 'Client B', value: 'clientb' },
            { label: 'Client C', value: 'clientc' }
        ];
        this.moduleMapping = [
            { label: 'Voitures', module: 'cars', script: 'ajax' },
            { label: 'Garages', module: 'garages', script: 'ajax', onlyFor: 'clientb' }
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
                this.updateModuleButtonsVisibility(mapping.value);
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

        const $moduleWrap = $('<div>').addClass('toolbar-modules');
        this.moduleMapping.forEach(mod => {
            const $mBtn = $('<button>').text(mod.label).attr('data-module', mod.module).attr('data-script', mod.script).addClass('module-button');
            $mBtn.on('click', () => {
                this.markActiveModuleButton($mBtn);
                const $dyn = $('.dynamic-div').first();
                if ($dyn && $dyn.length) {
                    $dyn.data('module', mod.module);
                    $dyn.data('script', mod.script);
                    if (window.loadDynamic && typeof window.loadDynamic === 'function') window.loadDynamic();
                }
            });
            $moduleWrap.append($mBtn);
        });
        this.$container.append($moduleWrap);

        $('body').prepend(this.$container);
    }

    markActiveModuleButton($button) {
        this.$container.find('.module-button').removeClass('active');
        if ($button && $button.length) $button.addClass('active');
    }

    updateModuleButtonsVisibility(clientValue) {
        this.$container.find('.module-button').each((i, el) => {
            const $el = $(el);
            const mod = $el.attr('data-module');
            const cfg = this.moduleMapping.find(m => m.module === mod);
            if (cfg && cfg.onlyFor) {
                if (cfg.onlyFor === clientValue) $el.show();
                else $el.hide();
            } else {
                $el.show();
            }
        });
        const $dyn = $('.dynamic-div').first();
        if ($dyn && $dyn.length) {
            const current = $dyn.data('module') || $dyn.attr('data-module');
            const visible = this.$container.find(`.module-button[data-module="${current}"]`).is(':visible');
            if (!visible) {
                const $carsBtn = this.$container.find('.module-button[data-module="cars"]');
                if ($carsBtn.length) {
                    $carsBtn.trigger('click');
                }
            }
        }
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
        this.updateModuleButtonsVisibility(existingClient);
        const $dyn = $('.dynamic-div').first();
        if ($dyn && $dyn.length) {
            const current = $dyn.data('module') || $dyn.attr('data-module');
            const $m = this.$container.find(`.module-button[data-module="${current}"]`);
            if ($m.length) this.markActiveModuleButton($m);
        }
    }
}

new Toolbar();

export default Toolbar;
