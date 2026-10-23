<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziggy Route Tree &amp; Fuzzy Search Map</title>

    @routes
    @vite('resources/js/app.js')

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

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

        .tree-node {
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 10px;
            margin-bottom: 12px;
            overflow: hidden;
            transition: all 0.2s;
        }

        .tree-node-header {
            padding: 12px 16px;
            cursor: pointer;
            background: rgba(30, 41, 59, 0.8);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tree-node-header:hover {
            background: #1e293b;
        }

        .tree-route-item {
            padding: 10px 16px;
            border-top: 1px solid #1e293b;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
        }

        .tree-route-item:hover {
            background: rgba(56, 189, 248, 0.06);
        }

        .badge-method-get { background: #2563eb; color: white; font-weight: bold; }
        .badge-method-post { background: #16a34a; color: white; font-weight: bold; }
        .badge-method-delete { background: #dc2626; color: white; font-weight: bold; }
        .badge-method-put { background: #d97706; color: white; font-weight: bold; }

        .search-input {
            background: #0f172a;
            border: 1px solid #334155;
            color: #f8fafc;
            padding: 12px 18px;
            border-radius: 10px;
        }

        .search-input:focus {
            background: #0f172a;
            color: #fff;
            border-color: #38bdf8;
            box-shadow: 0 0 0 0.25rem rgba(56, 189, 248, 0.25);
        }
    </style>
</head>

<body>

    <div class="container py-4">

        {{-- Top Navigation Bar --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 border-bottom border-secondary border-opacity-25 pb-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50">
                        🔍 ROUTE MAPPER
                    </span>
                    <span class="badge bg-secondary">Hierarchical Namespaces</span>
                </div>
                <h3 class="fw-bold mb-0 text-white">
                    <i class="fa-solid fa-sitemap text-warning me-2"></i> Real-Time Fuzzy Route Search &amp; Tree Map
                </h3>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa-solid fa-home me-1"></i> Home
                </a>
                <a href="{{ route('route.dispatcher') }}" class="btn btn-outline-info btn-sm">
                    <i class="fa-solid fa-paper-plane me-1"></i> Request Dispatcher
                </a>
                <a href="{{ route('route.snippets') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fa-solid fa-code me-1"></i> Code Snippets
                </a>
                <a href="{{ route('route.telemetry') }}" class="btn btn-outline-success btn-sm">
                    <i class="fa-solid fa-chart-line me-1"></i> Telemetry Radar
                </a>
                <a href="{{ route('route.cheatsheet') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-file-pdf me-1"></i> Cheat Sheet
                </a>
            </div>
        </div>

        {{-- Search & Filter Toolbar --}}
        <div class="card card-dark p-3 mb-4">
            <div class="row g-2 align-items-center">
                <div class="col-md-7">
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-secondary">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                        <input type="text" id="routeSearchInput" class="form-control search-input" placeholder="Search by route name, URI path, parameter (e.g. 'users', 'post', '{id}')..." oninput="filterRouteTree()">
                    </div>
                </div>
                <div class="col-md-5 d-flex gap-1.5 flex-wrap justify-content-md-end">
                    <button class="btn btn-sm btn-outline-secondary active" id="btnFilterAll" onclick="setMethodFilter('')">All</button>
                    <button class="btn btn-sm btn-outline-primary" id="btnFilterGet" onclick="setMethodFilter('GET')">GET</button>
                    <button class="btn btn-sm btn-outline-success" id="btnFilterPost" onclick="setMethodFilter('POST')">POST</button>
                    <button class="btn btn-sm btn-outline-danger" id="btnFilterDelete" onclick="setMethodFilter('DELETE')">DELETE</button>
                    <button class="btn btn-sm btn-outline-warning" id="btnFilterParams" onclick="toggleParamsOnly()">Has Params</button>
                </div>
            </div>
        </div>

        {{-- Visual Tree Map Container --}}
        <div class="row g-4">
            <div class="col-lg-8">
                <div id="treeContainer">
                    <!-- Populated dynamically via JS -->
                </div>
            </div>

            {{-- Right: Parameter & Route Inspector Drawer --}}
            <div class="col-lg-4">
                <div class="card card-dark p-4 sticky-top" style="top: 20px;">
                    <h5 class="fw-bold text-white mb-3 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-info text-info"></i> Parameter Inspector
                    </h5>

                    <div id="inspectorContent">
                        <div class="text-center py-4 text-secondary">
                            <i class="fa-solid fa-hand-pointer text-2xl mb-2 d-block"></i>
                            Select any route from the Tree Map to inspect its parameter signatures and Ziggy code.
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let currentMethodFilter = '';
        let filterParamsOnly = false;

        document.addEventListener('DOMContentLoaded', () => {
            renderRouteTree();
        });

        function setMethodFilter(method) {
            currentMethodFilter = method;
            document.querySelectorAll('#btnFilterAll, #btnFilterGet, #btnFilterPost, #btnFilterDelete').forEach(b => b.classList.remove('active'));
            if (method === '') document.getElementById('btnFilterAll').classList.add('active');
            if (method === 'GET') document.getElementById('btnFilterGet').classList.add('active');
            if (method === 'POST') document.getElementById('btnFilterPost').classList.add('active');
            if (method === 'DELETE') document.getElementById('btnFilterDelete').classList.add('active');
            filterRouteTree();
        }

        function toggleParamsOnly() {
            filterParamsOnly = !filterParamsOnly;
            document.getElementById('btnFilterParams').classList.toggle('active', filterParamsOnly);
            filterRouteTree();
        }

        function filterRouteTree() {
            renderRouteTree();
        }

        function renderRouteTree() {
            const query = (document.getElementById('routeSearchInput')?.value || '').toLowerCase();
            const container = document.getElementById('treeContainer');
            container.innerHTML = '';

            const routes = window.Ziggy && window.Ziggy.routes ? window.Ziggy.routes : {};
            
            // Group by namespace prefix
            const namespaces = {
                'Web Pages (Public)': [],
                'API Endpoints (/api/*)': [],
                'Developer Tools & Inspector': [],
                'Miscellaneous / Other': []
            };

            Object.keys(routes).forEach(name => {
                const r = routes[name];
                const methods = r.methods || ['GET'];
                const hasParams = r.uri.includes('{');

                // Filter logic
                if (currentMethodFilter && !methods.includes(currentMethodFilter)) return;
                if (filterParamsOnly && !hasParams) return;
                if (query && !name.toLowerCase().includes(query) && !r.uri.toLowerCase().includes(query)) return;

                if (name.startsWith('api.')) {
                    namespaces['API Endpoints (/api/*)'].push({ name, ...r });
                } else if (name.startsWith('route.') || name === 'favorites') {
                    namespaces['Developer Tools & Inspector'].push({ name, ...r });
                } else if (['home', 'about', 'contact', 'user.profile', 'product.show', 'post.details'].includes(name)) {
                    namespaces['Web Pages (Public)'].push({ name, ...r });
                } else {
                    namespaces['Miscellaneous / Other'].push({ name, ...r });
                }
            });

            let totalRendered = 0;

            Object.keys(namespaces).forEach(ns => {
                const list = namespaces[ns];
                if (list.length === 0) return;
                totalRendered += list.length;

                const nodeDiv = document.createElement('div');
                nodeDiv.className = 'tree-node';

                let icon = 'fa-folder';
                if (ns.includes('API')) icon = 'fa-satellite-dish text-info';
                if (ns.includes('Web')) icon = 'fa-globe text-primary';
                if (ns.includes('Developer')) icon = 'fa-wrench text-warning';

                nodeDiv.innerHTML = `
                    <div class="tree-node-header">
                        <span class="fw-bold text-white"><i class="fa-solid ${icon} me-2"></i> ${ns}</span>
                        <span class="badge bg-secondary">${list.length} routes</span>
                    </div>
                    <div class="tree-routes-list">
                        ${list.map(item => `
                            <div class="tree-route-item" onclick="inspectRoute('${item.name}')" style="cursor: pointer;">
                                <div>
                                    <span class="fw-bold text-white">${item.name}</span>
                                    <div class="text-secondary small font-monospace">/${item.uri}</div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    ${item.uri.includes('{') ? '<span class="badge bg-warning text-dark font-monospace text-xs">{param}</span>' : ''}
                                    <span class="badge badge-method-${(item.methods ? item.methods[0] : 'GET').toLowerCase()}">${(item.methods ? item.methods[0] : 'GET')}</span>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `;
                container.appendChild(nodeDiv);
            });

            if (totalRendered === 0) {
                container.innerHTML = `
                    <div class="card card-dark p-5 text-center text-secondary">
                        <i class="fa-solid fa-search text-3xl mb-2"></i>
                        <p class="mb-0">No routes found matching your search filter.</p>
                    </div>
                `;
            }
        }

        function inspectRoute(name) {
            const r = window.Ziggy.routes[name];
            if (!r) return;

            const params = r.uri.match(/\{([^}]+)\}/g) || [];
            const drawer = document.getElementById('inspectorContent');

            drawer.innerHTML = `
                <div class="mb-3">
                    <span class="text-xs uppercase text-slate-400 font-bold block mb-1">Route Name</span>
                    <h5 class="text-info font-bold mb-0 font-monospace">${name}</h5>
                </div>

                <div class="mb-3">
                    <span class="text-xs uppercase text-slate-400 font-bold block mb-1">URI Pattern</span>
                    <code class="text-white bg-dark p-2 rounded d-block font-monospace">/${r.uri}</code>
                </div>

                <div class="mb-3">
                    <span class="text-xs uppercase text-slate-400 font-bold block mb-1">HTTP Methods</span>
                    <div class="d-flex gap-1">
                        ${(r.methods || ['GET']).map(m => `<span class="badge badge-method-${m.toLowerCase()}">${m}</span>`).join('')}
                    </div>
                </div>

                <div class="mb-3">
                    <span class="text-xs uppercase text-slate-400 font-bold block mb-1">Parameters (${params.length})</span>
                    ${params.length > 0 ? `
                        <ul class="list-group list-group-flush bg-transparent">
                            ${params.map(p => `
                                <li class="list-group-item bg-transparent text-slate-200 px-0 py-1 d-flex justify-content-between align-items-center text-xs">
                                    <span class="font-monospace text-warning">${p}</span>
                                    <span class="badge ${p.includes('?') ? 'bg-secondary' : 'bg-primary'}">${p.includes('?') ? 'Optional' : 'Required'}</span>
                                </li>
                            `).join('')}
                        </ul>
                    ` : '<span class="text-secondary small italic">No parameters required.</span>'}
                </div>

                <div class="pt-3 border-top border-secondary border-opacity-25">
                    <span class="text-xs uppercase text-slate-400 font-bold block mb-1">Ziggy JavaScript Syntax</span>
                    <pre class="bg-black p-2.5 rounded text-info text-xs font-monospace mb-2">route('${name}'${params.length > 0 ? ', { ' + params.map(p => p.replace(/[\{\}\?]/g, '') + ": 1").join(', ') + ' }' : ''})</pre>
                    <a href="{{ route('route.dispatcher') }}" class="btn btn-primary btn-sm w-100">
                        <i class="fa-solid fa-paper-plane me-1"></i> Open in Request Dispatcher
                    </a>
                </div>
            `;
        }
    </script>

</body>

</html>
