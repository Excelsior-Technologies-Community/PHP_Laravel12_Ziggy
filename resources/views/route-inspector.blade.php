<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Ziggy Route Inspector</title>

    @routes
    @vite('resources/js/app.js')

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {

            background: #eef2ff;
            font-family: "Segoe UI", sans-serif;
            color: #1e293b;

        }

        .container-custom {

            max-width: 1300px;
            margin: 40px auto;

        }

        .hero {

            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .15);

        }

        .hero h1 {

            font-size: 38px;
            margin-bottom: 10px;

        }

        .hero p {

            opacity: .95;
            margin-bottom: 0;

        }

        .card-custom {

            margin-top: 25px;
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);

        }

        .card-header {

            background: #2563eb;
            color: white;
            font-weight: 600;

        }

        .stats-card {

            text-align: center;
            border: none;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
            transition: .3s;
            background: white;

        }

        .stats-card:hover {

            transform: translateY(-5px);

        }

        .stats-card h2 {

            font-size: 40px;
            color: #2563eb;
            margin-bottom: 10px;

        }

        .stats-card p {

            color: #6b7280;
            margin: 0;

        }

        .form-control {

            border-radius: 10px;

        }

        .table {

            margin-bottom: 0;

        }

        .table thead {

            background: #2563eb;
            color: white;

        }

        .table tbody tr:hover {

            background: #eef5ff;

        }

        .table td {

            vertical-align: middle;

        }

        .badge-route {

            background: #2563eb;
            color: white;

        }

        .btn-custom {

            border-radius: 10px;
            font-weight: 600;

        }

        .result-box {

            background: #111827;
            color: #22c55e;
            border-radius: 12px;
            padding: 18px;
            min-height: 80px;
            font-family: Consolas, monospace;
            word-break: break-word;

        }

        .footer {

            margin-top: 40px;
            text-align: center;
            color: #64748b;

        }

        @media(max-width:768px) {

            .hero h1 {

                font-size: 30px;

            }

            .container-custom {

                margin: 20px;

            }

        }
    </style>

</head>

<body>

    <div class="container container-custom">

        <!-- Hero Section -->

        <div class="hero">

            <h1>
                🔍 Ziggy Route Inspector
            </h1>

            <p>

                Inspect Laravel named routes, view route details,
                generate URLs dynamically and manage your Ziggy routes.

            </p>

        </div>


        <!-- Statistics -->

        <div class="row mt-4">


            <div class="col-md-3 mb-3">

                <div class="stats-card">

                    <h2 id="totalRoutes">
                        0
                    </h2>

                    <p>
                        Total Routes
                    </p>

                </div>

            </div>


            <div class="col-md-3 mb-3">

                <div class="stats-card">

                    <h2 id="parameterRoutes">
                        0
                    </h2>

                    <p>
                        Parameter Routes
                    </p>

                </div>

            </div>


            <div class="col-md-3 mb-3">

                <div class="stats-card">

                    <h2 id="simpleRoutes">
                        0
                    </h2>

                    <p>
                        Simple Routes
                    </p>

                </div>

            </div>


            <div class="col-md-3 mb-3">

                <div class="stats-card">

                    <h2 id="favoriteRoutes">
                        0
                    </h2>

                    <p>
                        Favorite Routes
                    </p>

                </div>

            </div>


        </div>



        <!-- Route Tools -->

        <div class="card card-custom">


            <div class="card-header">

                <h5 class="mb-0">

                    ⚡ Route Tools

                </h5>

            </div>


            <div class="card-body">


                <div class="row align-items-center">


                    <div class="col-md-6">


                        <input
                            type="text"
                            id="search"
                            class="form-control"
                            placeholder="Search route name...">


                    </div>


                    <div class="col-md-6 text-end mt-3 mt-md-0">


                        <button
                            class="btn btn-success btn-custom me-2"
                            onclick="exportRoutes()">

                            📥 Export JSON

                        </button>


                        <button
                            class="btn btn-primary btn-custom"
                            onclick="refreshRoutes()">

                            🔄 Refresh

                        </button>


                    </div>


                </div>


            </div>


        </div>

        <!-- Route Table -->

        <div class="card card-custom">


            <div class="card-header">

                <h5 class="mb-0">

                    🛣 Available Laravel Routes

                </h5>

            </div>


            <div class="card-body">


                <div class="table-responsive">


                    <table class="table table-hover align-middle">


                        <thead>


                            <tr>


                                <th>
                                    #
                                </th>


                                <th>
                                    Route Name
                                </th>


                                <th>
                                    Method
                                </th>


                                <th>
                                    URL
                                </th>


                                <th>
                                    Parameters
                                </th>


                                <th>
                                    Action
                                </th>


                            </tr>


                        </thead>


                        <tbody id="routesTable">


                            <!-- JavaScript Generated -->


                        </tbody>


                    </table>


                </div>


            </div>


        </div>



        <!-- Selected Route Details -->


        <div class="card card-custom">


            <div class="card-header">


                <h5 class="mb-0">

                    📌 Route Details

                </h5>


            </div>


            <div class="card-body">


                <div
                    id="routeDetails"
                    class="result-box">


                    Select any route to see details...


                </div>


            </div>


        </div>




        <!-- Navigation -->


        <div class="text-center mt-4">


            <a
                href="{{ route('home') }}"
                class="btn btn-primary btn-custom me-2">


                🏠 Home


            </a>



            <a
                href="{{ route('route.playground') }}"
                class="btn btn-warning btn-custom me-2">


                🎯 Playground


            </a>



            <a
                href="{{ route('route.tester') }}"
                class="btn btn-success btn-custom">


                🚀 Route Tester


            </a>


        </div>




        <!-- Footer -->


        <div class="footer">


            <hr>


            <p>

                Laravel 12 • Ziggy Route Inspector • Vite

            </p>


            <small>

                Developer tool for inspecting and testing Laravel named routes.

            </small>


        </div>


    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        const ziggyRoutes = Ziggy.routes;
        const routeNames = Object.keys(ziggyRoutes);

        document.addEventListener("DOMContentLoaded", () => {

            loadStatistics();
            renderRoutes();

            document.getElementById("search")
                .addEventListener("keyup", function() {
                    renderRoutes(this.value);
                });

        });

        function loadStatistics() {

            const total = routeNames.length;

            let parameterCount = 0;

            routeNames.forEach(name => {

                if (ziggyRoutes[name].uri.includes("{")) {
                    parameterCount++;
                }

            });

            document.getElementById("totalRoutes").innerHTML = total;
            document.getElementById("parameterRoutes").innerHTML = parameterCount;
            document.getElementById("simpleRoutes").innerHTML = total - parameterCount;

            const favorites = JSON.parse(localStorage.getItem("ziggyFavorites")) || [];

            document.getElementById("favoriteRoutes").innerHTML = favorites.length;
        }

        function renderRoutes(keyword = "") {

            const tbody = document.getElementById("routesTable");

            tbody.innerHTML = "";

            let index = 1;

            routeNames.forEach(name => {

                if (!name.toLowerCase().includes(keyword.toLowerCase())) return;

                const routeData = ziggyRoutes[name];

                let url = "";

                try {

                    url = route(name);

                } catch {

                    let params = {};

                    (routeData.parameters || []).forEach(p => {
                        params[p] = `{${p}}`;
                    });

                    try {
                        url = decodeURIComponent(route(name, params));
                    } catch {
                        url = "Requires Parameters";
                    }
                }

                tbody.innerHTML += `
        <tr>
            <td>${index++}</td>
            <td><span class="badge bg-primary">${name}</span></td>
            <td>${(routeData.methods || ["GET"]).join(", ")}</td>
            <td><code>${url}</code></td>
            <td>${(routeData.parameters || []).join(", ") || "-"}</td>
            <td>
                <button class="btn btn-sm btn-primary me-1"
                    onclick="showDetails('${name}')">
                    Details
                </button>

                <button class="btn btn-sm btn-success"
                    onclick="copyRoute('${url}')">
                    Copy
                </button>
            </td>
        </tr>`;
            });

        }

        function showDetails(routeName) {

            const routeData = ziggyRoutes[routeName];

            let url = "";

            try {

                url = route(routeName);

            } catch {

                let params = {};

                (routeData.parameters || []).forEach(p => {
                    params[p] = `{${p}}`;
                });

                try {
                    url = decodeURIComponent(route(routeName, params));
                } catch {
                    url = "Requires Parameters";
                }

            }

            document.getElementById("routeDetails").innerHTML = `
        <strong>Route Name:</strong> ${routeName}<hr>

        <strong>URL:</strong><br>${url}<hr>

        <strong>URI:</strong><br>${routeData.uri}<hr>

        <strong>Methods:</strong><br>${(routeData.methods || ["GET"]).join(", ")}<hr>

        <strong>Parameters:</strong><br>
        ${(routeData.parameters || []).join(", ") || "No Parameters"}

        <hr>

        <button class="btn btn-success btn-sm me-2"
            onclick="copyRoute('${url}')">

            📋 Copy URL

        </button>

    `;
        }

        function copyRoute(url) {

            if (url === "Requires Parameters") {

                alert("Cannot copy this route.");
                return;

            }

            navigator.clipboard.writeText(url);

            alert("Copied Successfully");
        }



        function refreshRoutes() {

            loadStatistics();

            renderRoutes(document.getElementById("search").value);

            document.getElementById("routeDetails").innerHTML =
                "Select any route to see details...";
        }

        function exportRoutes() {

            const blob = new Blob(
                [JSON.stringify(ziggyRoutes, null, 4)], {
                    type: "application/json"
                }
            );

            const url = URL.createObjectURL(blob);

            const a = document.createElement("a");

            a.href = url;
            a.download = "ziggy-routes.json";

            a.click();

            URL.revokeObjectURL(url);
        }

        window.showDetails = showDetails;
        window.copyRoute = copyRoute;
        window.refreshRoutes = refreshRoutes;
        window.exportRoutes = exportRoutes;
    </script>


</body>

</html>