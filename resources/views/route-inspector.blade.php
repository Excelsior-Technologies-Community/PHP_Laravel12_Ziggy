<!DOCTYPE html>
<html>

<head>
    <title>Route Inspector</title>

    @routes
    @vite('resources/js/app.js')

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
            margin: 40px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        h1 {
            margin-bottom: 20px;
        }

        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            flex: 1;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
        }

        .card h2 {
            margin: 0;
            color: #2563eb;
        }

        .search {
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th {
            background: #2563eb;
            color: white;
            padding: 12px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        button {
            padding: 8px 12px;
            cursor: pointer;
        }
    </style>

</head>

<body>

    <div class="container">

        <h1>🚀 Ziggy Route Inspector</h1>

        <div class="stats">

            <div class="card">
                <h2 id="totalRoutes">0</h2>
                <p>Total Routes</p>
            </div>

            <div class="card">
                <h2 id="parameterRoutes">0</h2>
                <p>Parameterized</p>
            </div>

            <div class="card">
                <h2 id="simpleRoutes">0</h2>
                <p>Simple</p>
            </div>

        </div>

        <div class="search">

            <input
                id="search"
                placeholder="Search route...">

        </div>

        <table>

            <thead>

                <tr>

                    <th>Name</th>

                    <th>URL</th>

                    <th>Action</th>

                </tr>

            </thead>

            <tbody id="routesTable"></tbody>

        </table>

        <div style="margin-top:20px; display:flex; gap:10px;">
            <a href="{{ route('home') }}">
                <button>🏠 Home</button>
            </a>

            <a href="{{ route('route.playground') }}">
                <button>🎯 Playground</button>
            </a>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            if (!window.Ziggy) {
                console.error('Ziggy is not loaded.');
                return;
            }

            const routes = window.Ziggy.routes;
            const names = Object.keys(routes);

            document.getElementById('totalRoutes').textContent = names.length;

            let parameterCount = 0;

            names.forEach(name => {
                if (routes[name].uri.includes('{')) {
                    parameterCount++;
                }
            });

            document.getElementById('parameterRoutes').textContent = parameterCount;
            document.getElementById('simpleRoutes').textContent = names.length - parameterCount;

            function render(keyword = '') {

                const tbody = document.getElementById('routesTable');
                tbody.innerHTML = '';

                names.forEach(name => {

                    if (!name.toLowerCase().includes(keyword.toLowerCase())) {
                        return;
                    }

                    let url = '';

                    try {
                        url = route(name);
                    } catch (e) {

                        const params = {};

                        (routes[name].parameters || []).forEach(parameter => {
                            params[parameter] = `{${parameter}}`;
                        });

                        try {
                            url = decodeURIComponent(route(name, params));
                        } catch {
                            url = 'Requires Parameters';
                        }
                    }

                    tbody.innerHTML += `
                <tr>
                    <td>${name}</td>
                    <td>${url}</td>
                    <td>
<button onclick='copyUrl(${JSON.stringify(url)})'>
    📋 Copy
</button>
                    </td>
                </tr>
            `;
                });
            }

            window.copyUrl = function(url) {

                if (!navigator.clipboard) {
                    alert('Clipboard is not supported.');
                    return;
                }

                navigator.clipboard.writeText(url);

                alert('URL copied successfully.');

            };

            document.getElementById('search').addEventListener('input', function(e) {
                render(e.target.value);
            });

            render();

        });
    </script>

</body>

</html>