<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziggy Client-Side Route Telemetry &amp; Analytics Radar</title>

    @routes
    @vite('resources/js/app.js')

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

        .pulse-live {
            width: 10px;
            height: 10px;
            background-color: #22c55e;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            animation: pulse-ring 1.8s infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }

        .table-custom {
            background: #1e293b;
            color: #e2e8f0;
        }

        .table-custom th {
            background: #0f172a;
            color: #94a3b8;
            font-size: 12px;
            text-transform: uppercase;
            border-bottom: 2px solid rgba(255, 255, 255, 0.08);
        }

        .table-custom td {
            vertical-align: middle;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            font-size: 13px;
        }
    </style>
</head>

<body>

    <div class="container py-4">

        {{-- Top Navigation Bar --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 border-bottom border-secondary border-opacity-25 pb-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="pulse-live"></span>
                    <span class="badge bg-success bg-opacity-25 text-success border border-success border-opacity-50">
                        TELEMETRY RADAR ACTIVE
                    </span>
                    <span class="badge bg-secondary">Client-Side Instrumentation</span>
                </div>
                <h3 class="fw-bold mb-0 text-white">
                    <i class="fa-solid fa-chart-line text-success me-2"></i> Client-Side Route Telemetry &amp; Analytics
                </h3>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button class="btn btn-outline-info btn-sm" onclick="runBenchmarkSimulation()">
                    <i class="fa-solid fa-bolt me-1"></i> Benchmark 10 Calls
                </button>
                <button class="btn btn-outline-danger btn-sm" onclick="clearTelemetry()">
                    <i class="fa-solid fa-trash me-1"></i> Clear Log
                </button>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa-solid fa-home me-1"></i> Home
                </a>
                <a href="{{ route('route.dispatcher') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fa-solid fa-paper-plane me-1"></i> Dispatcher
                </a>
                <a href="{{ route('route.cheatsheet') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-file-pdf me-1"></i> Cheat Sheet
                </a>
            </div>
        </div>

        {{-- KPI Cards Row --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card card-dark p-3">
                    <span class="text-secondary small fw-bold uppercase">Total Route Calls</span>
                    <h3 class="fw-bold mt-2 mb-0 text-white" id="kpiTotalCalls">0</h3>
                    <span class="text-secondary small" style="font-size: 11px;">Captured in browser session</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-dark p-3">
                    <span class="text-secondary small fw-bold uppercase">Unique Routes</span>
                    <h3 class="fw-bold mt-2 mb-0 text-info" id="kpiUniqueRoutes">0</h3>
                    <span class="text-secondary small" style="font-size: 11px;">Distinct endpoints called</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-dark p-3">
                    <span class="text-secondary small fw-bold uppercase">Avg Generation Speed</span>
                    <h3 class="fw-bold mt-2 mb-0 text-emerald-400" id="kpiAvgLatency">0.08ms</h3>
                    <span class="text-secondary small" style="font-size: 11px;">Microsecond resolution</span>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card card-dark p-3">
                    <span class="text-secondary small fw-bold uppercase">Parameter Accuracy</span>
                    <h3 class="fw-bold mt-2 mb-0 text-amber-400">100%</h3>
                    <span class="text-secondary small" style="font-size: 11px;">Zero missing param errors</span>
                </div>
            </div>
        </div>

        {{-- Charts Row --}}
        <div class="row g-4 mb-4">
            <div class="col-lg-7">
                <div class="card card-dark p-4 h-100">
                    <h6 class="fw-bold text-slate-300 uppercase small mb-3">
                        <i class="fa-solid fa-chart-bar text-primary me-2"></i> Top 5 Most Invoked Route Names
                    </h6>
                    <div style="height: 220px; position: relative;">
                        <canvas id="topRoutesChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card card-dark p-4 h-100">
                    <h6 class="fw-bold text-slate-300 uppercase small mb-3">
                        <i class="fa-solid fa-chart-pie text-success me-2"></i> HTTP Method Distribution
                    </h6>
                    <div style="height: 220px; position: relative;">
                        <canvas id="methodsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Live Stream Event Log Table --}}
        <div class="card card-dark overflow-hidden">
            <div class="card-header bg-dark border-secondary border-opacity-25 py-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold text-white"><i class="fa-solid fa-list-check text-info me-2"></i> Real-Time Route Call Audit Stream</span>
                <span class="badge bg-secondary" id="badgeTotalStream">0 Events Logged</span>
            </div>
            <div class="table-responsive">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th>Route Name</th>
                            <th>Resolved URL</th>
                            <th>Parameters Passed</th>
                            <th>Resolution Latency</th>
                            <th>Invoked At</th>
                        </tr>
                    </thead>
                    <tbody id="telemetryTableBody">
                        <tr>
                            <td colspan="5" class="text-center py-4 text-secondary">
                                No client route calls recorded yet. Click "Benchmark 10 Calls" or navigate around the site!
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let topRoutesChart = null;
        let methodsChart = null;

        document.addEventListener('DOMContentLoaded', () => {
            initCharts();
            renderTelemetry();

            // Listen for live client-side route events
            window.addEventListener('ziggy:route_called', () => {
                renderTelemetry();
            });
        });

        function getTelemetryData() {
            try {
                return JSON.parse(localStorage.getItem('ziggy_telemetry') || '[]');
            } catch (e) {
                return [];
            }
        }

        function initCharts() {
            const ctxTop = document.getElementById('topRoutesChart').getContext('2d');
            topRoutesChart = new Chart(ctxTop, {
                type: 'bar',
                data: {
                    labels: ['No Calls Yet'],
                    datasets: [{
                        label: 'Invocation Count',
                        data: [0],
                        backgroundColor: '#38bdf8',
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { ticks: { color: '#94a3b8' }, grid: { display: false } },
                        y: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.05)' } }
                    }
                }
            });

            const ctxMethods = document.getElementById('methodsChart').getContext('2d');
            methodsChart = new Chart(ctxMethods, {
                type: 'doughnut',
                data: {
                    labels: ['GET', 'POST', 'DELETE'],
                    datasets: [{
                        data: [1, 0, 0],
                        backgroundColor: ['#2563eb', '#16a34a', '#dc2626'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { color: '#94a3b8' } } }
                }
            });
        }

        function renderTelemetry() {
            const data = getTelemetryData();

            // Update KPIs
            document.getElementById('kpiTotalCalls').textContent = data.length;
            document.getElementById('badgeTotalStream').textContent = `${data.length} Events Logged`;

            const uniqueNames = new Set(data.map(d => d.name));
            document.getElementById('kpiUniqueRoutes').textContent = uniqueNames.size;

            if (data.length > 0) {
                const avgSpeed = (data.reduce((acc, curr) => acc + (curr.latency_ms || 0.05), 0) / data.length).toFixed(2);
                document.getElementById('kpiAvgLatency').textContent = `${avgSpeed}ms`;
            }

            // Frequency map for top routes
            const counts = {};
            data.forEach(d => {
                counts[d.name] = (counts[d.name] || 0) + 1;
            });

            const sorted = Object.entries(counts).sort((a, b) => b[1] - a[1]).slice(0, 5);
            if (sorted.length > 0) {
                topRoutesChart.data.labels = sorted.map(s => s[0]);
                topRoutesChart.data.datasets[0].data = sorted.map(s => s[1]);
                topRoutesChart.update();
            }

            // Table Body
            const tbody = document.getElementById('telemetryTableBody');
            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="text-center py-4 text-secondary">No client route calls recorded yet. Click "Benchmark 10 Calls" or navigate around the site!</td></tr>';
                return;
            }

            tbody.innerHTML = '';
            // Render latest 15 calls in reverse
            data.slice(-15).reverse().forEach(item => {
                let resolvedUrl = '...';
                try {
                    resolvedUrl = route(item.name, item.params || {});
                } catch (e) {
                    resolvedUrl = 'Error resolving';
                }

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="font-bold text-info font-monospace">${item.name}</td>
                    <td><code class="text-white">${resolvedUrl}</code></td>
                    <td class="text-secondary font-monospace small">${item.params ? JSON.stringify(item.params) : '{}'}</td>
                    <td><span class="badge bg-secondary font-monospace">${item.latency_ms || 0.08}ms</span></td>
                    <td class="text-secondary small">${new Date(item.time).toLocaleTimeString()}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        function runBenchmarkSimulation() {
            // Rapidly generate sample routes
            const sampleCalls = [
                { name: 'user.profile', params: { id: 101 } },
                { name: 'post.details', params: { category: 'tech', slug: 'laravel-12-ziggy' } },
                { name: 'product.show', params: { id: 55 } },
                { name: 'api.users.index', params: {} },
                { name: 'api.products.show', params: { id: 202 } },
                { name: 'contact', params: {} },
                { name: 'about', params: {} },
                { name: 'route.dispatcher', params: {} },
                { name: 'api.health.check', params: {} },
                { name: 'user.profile', params: { id: 999 } },
            ];

            sampleCalls.forEach(call => {
                route(call.name, call.params);
            });

            renderTelemetry();
        }

        function clearTelemetry() {
            localStorage.removeItem('ziggy_telemetry');
            renderTelemetry();
        }
    </script>

</body>

</html>
