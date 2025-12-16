export async function fetchHtml(moduleName, scriptName, clientName = '', extraParams = {}) {
	if (!moduleName || !scriptName) throw new Error('module/script required');

	const params = new URLSearchParams({ module: moduleName, script: scriptName });

	if (clientName) params.set('client', clientName);

	Object.keys(extraParams || {}).forEach(k => {
		if (extraParams[k] !== undefined && extraParams[k] !== null) params.set(k, String(extraParams[k]));
	});

	const url = 'src/ajax_handler.php?' + params.toString();
	const response = await fetch(url, { method: 'GET', credentials: 'same-origin' });

	if (!response.ok) {
		const text = await response.text();
		const message = text || `Request failed: ${response.status}`;
		const err = new Error(message);
		err.httpStatus = response.status;
		throw err;
	}

	return response.text();
}

