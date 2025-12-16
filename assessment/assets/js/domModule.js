export function renderError(container, message) {
    if (!container) return;
    try {
        const $c = (container.jquery) ? container : (typeof container === 'string' ? $(container) : $(container));
        $c.html(`<div class="error-message">${String(message)}</div>`);
    } catch (e) {
        if (container instanceof Element) container.innerHTML = `<div class="error-message">${String(message)}</div>`;
    }
}

export function insertHtml(container, html) {
    if (!container) return;
    try {
        const $c = (container.jquery) ? container : (typeof container === 'string' ? $(container) : $(container));
        $c.html(html);
    } catch (e) {
        if (container instanceof Element) container.innerHTML = html;
    }
}
