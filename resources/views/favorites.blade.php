<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Favorite Routes</title>

    @routes
    @vite('resources/js/app.js')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        body {

            background: #f4f7fb;
            font-family: "Segoe UI", sans-serif;

        }

        .page-title {

            font-size: 35px;
            font-weight: bold;
            color: #2563eb;

        }

        .subtitle {

            color: #6b7280;

        }

        .card-custom {

            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);

        }

        .table thead {

            background: #2563eb;
            color: white;

        }

        .table tbody tr:hover {

            background: #eef5ff;

        }

        .btn-custom {

            border-radius: 8px;

        }

        .empty-box {

            padding: 60px;
            text-align: center;
            color: gray;

        }

        .search-box {

            max-width: 400px;

        }

        .badge-route {

            background: #0d6efd;

        }

        .header-card {

            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: white;
            border-radius: 20px;
            padding: 35px;

        }

        .stat-card {

            border: none;
            border-radius: 15px;
            text-align: center;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);

        }

        .stat-card h2 {

            font-size: 40px;
            color: #2563eb;

        }

        .footer {

            text-align: center;
            color: #6b7280;
            margin-top: 40px;

        }
    </style>

</head>

<body>

    <div class="container py-5">

        <div class="header-card">

            <h1>
                ⭐ Favorite Routes
            </h1>

            <p class="mb-0">

                Save your frequently used Laravel Ziggy routes and access them quickly.

            </p>

        </div>

        <br>

        <div class="row">

            <div class="col-md-4">

                <div class="stat-card">

                    <h2 id="favoriteCount">
                        0
                    </h2>

                    <p>Total Favorites</p>

                </div>

            </div>

            <div class="col-md-8">

                <div class="card card-custom">

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-8">

                                <input
                                    type="text"
                                    id="search"
                                    class="form-control search-box"
                                    placeholder="Search favorite route...">

                            </div>

                            <div class="col-md-4 text-end">

                                <button
                                    class="btn btn-danger btn-custom"
                                    onclick="clearFavorites()">

                                    🗑 Clear All

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <br>

        <div class="card card-custom">

            <div class="card-header bg-primary text-white">

                <h5 class="mb-0">

                    Saved Favorite Routes

                </h5>

            </div>

            <div class="card-body">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th width="25%">
                                Route Name
                            </th>

                            <th width="45%">
                                URL
                            </th>

                            <th width="30%">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody id="favoriteTable">

                        <!-- JavaScript will load data here -->

                    </tbody>

                </table>

                <div
                    id="emptyState"
                    class="empty-box">

                    ⭐ No favorite routes found.

                </div>

            </div>

        </div>

        <br>

        <div class="row">

            <div class="col-md-12 text-center">

                <a href="{{ route('home') }}" class="btn btn-primary btn-custom me-2">
                    🏠 Home
                </a>

                <a href="{{ route('route.inspector') }}" class="btn btn-success btn-custom me-2">
                    🔍 Route Inspector
                </a>

                <a href="{{ route('route.playground') }}" class="btn btn-warning btn-custom me-2">
                    🎯 Route Playground
                </a>

                <button
                    class="btn btn-info btn-custom text-white"
                    onclick="loadRoutes()">

                    🔄 Refresh

                </button>

            </div>

        </div>

        <div class="footer">

            <hr>

            <p class="mb-1">
                Laravel 12 • Ziggy Favorites
            </p>

            <small>
                Store your favorite named routes using Local Storage.
            </small>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        const STORAGE_KEY = "ziggyFavorites";

        document.addEventListener("DOMContentLoaded", () => {

            loadRoutes();

            document.getElementById("search").addEventListener("keyup", function() {
                loadRoutes(this.value);
            });

        });


        function getFavorites() {

            return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];

        }


        function setFavorites(data) {

            localStorage.setItem(STORAGE_KEY, JSON.stringify(data));

        }


        function loadRoutes(keyword = "") {

            const tbody = document.getElementById("favoriteTable");
            const empty = document.getElementById("emptyState");

            tbody.innerHTML = "";

            let favorites = getFavorites();

            favorites = favorites.filter(route =>
                route.name.toLowerCase().includes(keyword.toLowerCase())
            );

            document.getElementById("favoriteCount").innerText = favorites.length;

            if (favorites.length === 0) {

                empty.style.display = "block";
                return;

            }

            empty.style.display = "none";

            favorites.forEach((route, index) => {

                tbody.innerHTML += `

        <tr>

            <td>

                <span class="badge badge-route">

                    ${route.name}

                </span>

            </td>

            <td>

                <code>${route.url}</code>

            </td>

            <td>

                <button
                    class="btn btn-success btn-sm me-1"
                    onclick="openRoute('${route.url}')">

                    🌐 Open

                </button>

                <button
                    class="btn btn-primary btn-sm me-1"
                    onclick="copyUrl('${route.url}')">

                    📋 Copy

                </button>

                <button
                    class="btn btn-danger btn-sm"
                    onclick="deleteFavorite(${index})">

                    🗑 Delete

                </button>

            </td>

        </tr>

        `;

            });

        }


        function saveFavorite(name, url) {

            let favorites = getFavorites();

            const exists = favorites.find(route => route.name === name);

            if (exists) {

                alert("Route already exists.");
                return;

            }

            favorites.push({

                name: name,
                url: url

            });

            setFavorites(favorites);

            loadRoutes();

            alert("Favorite route saved.");

        }


        function deleteFavorite(index) {

            if (!confirm("Delete this favorite route?")) {
                return;
            }

            let favorites = getFavorites();

            favorites.splice(index, 1);

            setFavorites(favorites);

            loadRoutes();

        }


        function clearFavorites() {

            if (!confirm("Clear all favorite routes?")) {
                return;
            }

            localStorage.removeItem(STORAGE_KEY);

            loadRoutes();

        }


        function copyUrl(url) {

            navigator.clipboard.writeText(url);

            alert("URL copied successfully.");

        }


        function openRoute(url) {

            if (url.includes("{")) {

                alert("This route requires parameters.");
                return;

            }

            window.open(url, "_blank");

        }


        window.saveFavorite = saveFavorite;
        window.deleteFavorite = deleteFavorite;
        window.copyUrl = copyUrl;
        window.openRoute = openRoute;
        window.clearFavorites = clearFavorites;
        window.loadRoutes = loadRoutes;
    </script>


</body>

</html>