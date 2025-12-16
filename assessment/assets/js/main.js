import { fetchHtml } from './apiClient.js';
import { renderError, insertHtml } from './domModule.js';

function getCookie(name) {
    const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
    return match ? decodeURIComponent(match[2]) : null;
}

async function loadDynamic() {
    const $container = $('.dynamic-div').first();
    if (!$container.length) return;
    const moduleName = $container.data('module') || '';
    const scriptName = $container.data('script') || '';
    const clientName = getCookie('client') || '';
    if (!moduleName || !scriptName) return renderError($container, 'Missing data-module or data-script.');
    try {
        const html = await fetchHtml(moduleName, scriptName, clientName);
        insertHtml($container, html);
        attachCarClickHandlers($container, clientName);
    } catch (err) {
        renderError($container, err.message || 'Network error while loading dynamic content.');
    }
}

$(document).ready(loadDynamic);

window.loadDynamic = loadDynamic;

function attachCarClickHandlers($container, clientName) {
    if (!$container || !$container.length) return;
    if ($container.data('_carHandlerAttached')) return;
    $container.on('click', '.car-item', async function (ev) {
        const $el = $(this);
        const id = $el.data('car-id') || $el.attr('data-car-id');
        if (!id) return;
        try {
            const html = await fetchHtml('cars', 'edit', clientName, { id });
            insertHtml($container, html);
        } catch (err) {
            renderError($container, err.message || 'Network error while loading details.');
        }
    });
    $container.data('_carHandlerAttached', '1');
}
