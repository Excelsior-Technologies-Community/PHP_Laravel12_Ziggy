<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziggy Live API Request Dispatcher</title>

    @routes
    @vite('resources/js/app.js')

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        body {
            background: #0f172a;
            color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card-dark {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .form-control, .form-select {
            background-color: #0f172a;
            border: 1px solid #334155;
            color: #f8fafc;
        }

        .form-control:focus, .form-select:focus {
            background-color: #0f172a;
            border-color: #38bdf8;
            color: #f8fafc;
            box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.25);
        }

        .code-preview {
            background: #020617;
            border: 1px solid #1e293b;
            border-radius: 8px;
            color: #38bdf8;
            font-family: 'Consolas', 'Courier New', monospace;
            padding: 12px;
            font-size: 13px;
            white-space: pre-wrap;
            word-break: break-all;
        }

        .json-response {
            background: #020617;
            border: 1px solid #334155;
            border-radius: 10px;
            color: #a7f3d0;
            font-family: 'Consolas', 'Courier New', monospace;
            padding: 15px;
            font-size: 12.5px;
            max-height: 420px;
            overflow-y: auto;
            white-space: pre-wrap;
            word-break: break-all;
        }

        .nav-pills .nav-link {
            color: #94a3b8;
            font-size: 13px;
            font-weight: 600;
        }

        .nav-pills .nav-link.active {
            background: #2563eb;
            color: white;
        }
    </style>
</head>

<body>

    <div class="container py-4">

        {{-- Top Navigation Bar --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 border-bottom border-secondary border-opacity-25 pb-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-primary bg-opacity-25 text-info border border-info border-opacity-50">
                        ⚡ LIVE DISPATCHER
                    </span>
                    <span class="badge bg-secondary">Ziggy + Axios Client</span>
                </div>
                <h3 class="fw-bold mb-0 text-white">
                    <i class="fa-solid fa-paper-plane text-info me-2"></i> Live API Request Dispatcher &amp; Studio
                </h3>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa-solid fa-home me-1"></i> Home
                </a>
                <a href="{{ route('route.snippets') }}" class="btn btn-outline-info btn-sm">
                    <i class="fa-solid fa-code me-1"></i> Code Snippets
                </a>
                <a href="{{ route('route.tree') }}" class="btn btn-outline-warning btn-sm">
                    <i class="fa-solid fa-sitemap me-1"></i> Route Tree
                </a>
                <a href="{{ route('route.telemetry') }}" class="btn btn-outline-success btn-sm">
                    <i class="fa-solid fa-chart-line me-1"></i> Telemetry Radar
                </a>
                <a href="{{ route('route.cheatsheet') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-file-pdf me-1"></i> Cheat Sheet
                </a>
            </div>
        </div>

        {{-- Main Workspace --}}
        <div class="row g-4">

            {{-- Left Column: Request Configuration Form --}}
            <div class="col-lg-6">
                <div class="card card-dark p-4 h-100">
                    <h5 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-sliders text-primary"></i> 1. Configure Request
                    </h5>

                    {{-- Route Selector --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-slate-300">Select Ziggy Named Route</label>
                        <select id="routeSelect" class="form-select" onchange="onRouteSelected()">
                            <!-- Populated dynamically via Ziggy JS -->
                        </select>
                        <div class="form-text text-secondary small" id="routeUriPreview">URI: ...</div>
                    </div>

                    {{-- HTTP Method & Route Call Preview --}}
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-slate-300">HTTP Method</label>
                            <select id="httpMethod" class="form-select" onchange="updateGeneratedUrl()">
                                <option value="GET">GET</option>
                                <option value="POST">POST</option>
                                <option value="PUT">PUT</option>
                                <option value="PATCH">PATCH</option>
                                <option value="DELETE">DELETE</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-slate-300">Ziggy Call Syntax</label>
                            <div class="code-preview py-2" id="ziggyCallSyntax">route(...)</div>
                        </div>
                    </div>

                    {{-- Dynamic Route Parameters Fields --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-slate-300 d-flex justify-content-between">
                            <span>Route Parameters</span>
                            <span class="badge bg-secondary small" id="paramCountBadge">0 params</span>
                        </label>
                        <div id="dynamicParamsContainer" class="p-3 bg-dark rounded border border-secondary border-opacity-25">
                            <span class="text-secondary small italic">No parameters required for this route.</span>
                        </div>
                    </div>

                    {{-- Request Tabs: Query Params, Headers, JSON Body --}}
                    <ul class="nav nav-pills mb-2" id="requestConfigTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active py-1 px-3" id="tab-headers" data-bs-toggle="pill" data-bs-target="#pane-headers">
                                Custom Headers
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link py-1 px-3" id="tab-body" data-bs-toggle="pill" data-bs-target="#pane-body">
                                Request Body (JSON)
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content mb-4" id="requestConfigTabContent">
                        {{-- Headers Pane --}}
                        <div class="tab-pane fade show active" id="pane-headers">
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <input type="text" id="headerKey" class="form-control form-control-sm" placeholder="X-Requested-With" value="XMLHttpRequest">
                                </div>
                                <div class="col-6">
                                    <input type="text" id="headerVal" class="form-control form-control-sm" placeholder="value" value="XMLHttpRequest">
                                </div>
                            </div>
                            <div class="small text-secondary" style="font-size: 11px;">Standard CSRF and Accept application/json headers included automatically.</div>
                        </div>

                        {{-- Body Pane --}}
                        <div class="tab-pane fade" id="pane-body">
                            <textarea id="requestBodyJson" rows="3" class="form-control font-monospace small" placeholder='{"name": "Jane Doe", "email": "jane@example.com"}'>{}</textarea>
                        </div>
                    </div>

                    {{-- Dispatch Button --}}
                    <button type="button" id="btnDispatch" class="btn btn-primary fw-bold py-2.5 w-100 shadow" onclick="dispatchRequest()">
                        <i class="fa-solid fa-bolt me-2"></i> Dispatch via Ziggy &amp; Axios
                    </button>
                </div>
            </div>

            {{-- Right Column: Live Response Studio --}}
            <div class="col-lg-6">
                <div class="card card-dark p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-white mb-0 d-flex align-items-center gap-2">
                            <i class="fa-solid fa-terminal text-success"></i> 2. Live HTTP Response Studio
                        </h5>
                        <div id="responseMetrics" class="d-none d-flex gap-2">
                            <span class="badge bg-success" id="resStatusBadge">200 OK</span>
                            <span class="badge bg-secondary" id="resLatencyBadge">14ms</span>
                        </div>
                    </div>

                    {{-- URL Dispatched Preview --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-slate-400">Target Dispatched URL</label>
                        <div class="input-group">
                            <input type="text" id="finalDispatchedUrl" class="form-control font-monospace text-info small" readonly value="...">
                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="copyFinalUrl()" title="Copy URL">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    {{-- JSON Response Display --}}
                    <div class="mb-3 position-relative">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-slate-400 mb-0">Formatted JSON Payload</label>
                            <button class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size: 11px;" onclick="copyResponseJson()">
                                <i class="fa-solid fa-copy me-1"></i> Copy JSON
                            </button>
                        </div>
                        <pre class="json-response" id="responseViewer">// Ready. Click "Dispatch via Ziggy &amp; Axios" to send request.</pre>
                    </div>

                    {{-- cURL Snippet Preview --}}
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="form-label small fw-bold text-slate-400 mb-0">Equivalent cURL Command</label>
                            <button class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size: 11px;" onclick="copyCurlSnippet()">
                                <i class="fa-solid fa-copy me-1"></i> Copy cURL
                            </button>
                        </div>
                        <div class="code-preview text-slate-400" style="font-size: 11px;" id="curlSnippetPreview">curl -X GET "..."</div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let currentRouteData = null;
        let routeParams = {};

        // 1. Initialize Route Selector from Ziggy
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('routeSelect');
            select.innerHTML = '';

            const routesObj = window.Ziggy && window.Ziggy.routes ? window.Ziggy.routes : {};
            const routeNames = Object.keys(routesObj).sort();

            routeNames.forEach(name => {
                const opt = document.createElement('option');
                opt.value = name;
                opt.textContent = `${name} (${routesObj[name].uri})`;
                select.appendChild(opt);
            });

            // Default selection
            if (select.querySelector('option[value="api.users.index"]')) {
                select.value = 'api.users.index';
            } else if (routeNames.length > 0) {
                select.value = routeNames[0];
            }

            onRouteSelected();
        });

        // 2. Handle Route Selection
        function onRouteSelected() {
            const name = document.getElementById('routeSelect').value;
            const routeDef = window.Ziggy.routes[name];
            if (!routeDef) return;

            currentRouteData = routeDef;
            document.getElementById('routeUriPreview').textContent = `URI: ${routeDef.uri} | Allowed Methods: ${(routeDef.methods || ['GET']).join(', ')}`;

            // Auto-select primary HTTP method
            const methodSelect = document.getElementById('httpMethod');
            if (routeDef.methods && routeDef.methods.length > 0) {
                methodSelect.value = routeDef.methods[0];
            } else {
                methodSelect.value = 'GET';
            }

            // Parse Route Parameters e.g. {id}, {category}, {slug}
            const paramMatches = routeDef.uri.match(/\{([^}]+)\}/g) || [];
            const container = document.getElementById('dynamicParamsContainer');
            container.innerHTML = '';
            routeParams = {};

            document.getElementById('paramCountBadge').textContent = `${paramMatches.length} parameter${paramMatches.length === 1 ? '' : 's'}`;

            if (paramMatches.length === 0) {
                container.innerHTML = '<span class="text-secondary small italic">No parameters required for this route.</span>';
            } else {
                paramMatches.forEach(p => {
                    const rawName = p.replace(/[\{\}\?]/g, '');
                    const isOptional = p.includes('?');
                    routeParams[rawName] = isOptional ? '' : (rawName === 'id' ? '1' : (rawName === 'category' ? 'tech' : 'sample-slug'));

                    const div = document.createElement('div');
                    div.className = 'mb-2';
                    div.innerHTML = `
                        <label class="form-label small fw-bold text-slate-300 d-flex justify-content-between mb-1">
                            <span>${rawName} ${isOptional ? '<span class="text-secondary fw-normal">(Optional)</span>' : '<span class="text-danger">*</span>'}</span>
                        </label>
                        <input type="text" class="form-control form-control-sm" id="param_${rawName}" value="${routeParams[rawName]}" oninput="onParamChanged('${rawName}', this.value)">
                    `;
                    container.appendChild(div);
                });
            }

            updateGeneratedUrl();
        }

        function onParamChanged(key, val) {
            routeParams[key] = val;
            updateGeneratedUrl();
        }

        // 3. Update Generated URL & Ziggy Call Syntax
        function updateGeneratedUrl() {
            const name = document.getElementById('routeSelect').value;
            const method = document.getElementById('httpMethod').value;

            try {
                // Filter empty optional params
                const cleanParams = {};
                Object.keys(routeParams).forEach(k => {
                    if (routeParams[k] !== '') {
                        cleanParams[k] = routeParams[k];
                    }
                });

                const url = route(name, cleanParams);
                document.getElementById('finalDispatchedUrl').value = url;

                const paramsString = Object.keys(cleanParams).length > 0 ? JSON.stringify(cleanParams) : '';
                document.getElementById('ziggyCallSyntax').textContent = `route('${name}'${paramsString ? ', ' + paramsString : ''})`;

                document.getElementById('curlSnippetPreview').textContent = `curl -X ${method} "${url}" -H "Accept: application/json"`;
            } catch (err) {
                document.getElementById('finalDispatchedUrl').value = 'Error resolving route parameters';
            }
        }

        // 4. Dispatch Request via Axios
        async function dispatchRequest() {
            const url = document.getElementById('finalDispatchedUrl').value;
            const method = document.getElementById('httpMethod').value.toLowerCase();
            const btn = document.getElementById('btnDispatch');
            const viewer = document.getElementById('responseViewer');

            if (!url || url.includes('Error')) {
                alert('Please resolve all required route parameters first.');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Dispatching...';
            viewer.textContent = '// Transmitting request...';

            const startTime = performance.now();

            let payload = null;
            if (['post', 'put', 'patch'].includes(method)) {
                try {
                    payload = JSON.parse(document.getElementById('requestBodyJson').value || '{}');
                } catch (e) {
                    alert('Invalid JSON in request body');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-bolt me-2"></i> Dispatch via Ziggy & Axios';
                    return;
                }
            }

            const customHeaders = {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            };

            const hKey = document.getElementById('headerKey').value.trim();
            const hVal = document.getElementById('headerVal').value.trim();
            if (hKey && hVal) customHeaders[hKey] = hVal;

            try {
                const response = await axios({
                    method: method,
                    url: url,
                    data: payload,
                    headers: customHeaders,
                });

                const latency = Math.round(performance.now() - startTime);
                renderResponse(response.status, response.statusText, latency, response.data);
            } catch (error) {
                const latency = Math.round(performance.now() - startTime);
                if (error.response) {
                    renderResponse(error.response.status, error.response.statusText, latency, error.response.data);
                } else {
                    renderResponse(0, 'Network Error', latency, { error: error.message });
                }
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-solid fa-bolt me-2"></i> Dispatch via Ziggy & Axios';
            }
        }

        function renderResponse(status, statusText, latency, data) {
            const metricsDiv = document.getElementById('responseMetrics');
            const statusBadge = document.getElementById('resStatusBadge');
            const latencyBadge = document.getElementById('resLatencyBadge');
            const viewer = document.getElementById('responseViewer');

            metricsDiv.classList.remove('d-none');
            statusBadge.textContent = `${status} ${statusText || ''}`;
            statusBadge.className = status >= 200 && status < 300 ? 'badge bg-success' : 'badge bg-danger';

            latencyBadge.textContent = `${latency}ms`;
            viewer.textContent = JSON.stringify(data, null, 2);
        }

        function copyFinalUrl() {
            navigator.clipboard.writeText(document.getElementById('finalDispatchedUrl').value);
            alert('URL copied to clipboard!');
        }

        function copyResponseJson() {
            navigator.clipboard.writeText(document.getElementById('responseViewer').textContent);
            alert('JSON response copied to clipboard!');
        }

        function copyCurlSnippet() {
            navigator.clipboard.writeText(document.getElementById('curlSnippetPreview').textContent);
            alert('cURL snippet copied to clipboard!');
        }
    </script>

</body>

</html>
