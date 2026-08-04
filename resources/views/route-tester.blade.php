<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Ziggy Route Tester</title>

    @routes
    @vite('resources/js/app.js')

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {

            background: #eef2ff;
            font-family: "Segoe UI", sans-serif;

        }

        .container-custom {

            max-width: 1200px;
            margin: 40px auto;

        }

        .hero {

            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: #fff;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 12px 25px rgba(0, 0, 0, .12);

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
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .08);

        }

        .card-header {

            background: #2563eb;
            color: #fff;
            border-radius: 16px 16px 0 0 !important;

        }

        .form-control,
        .form-select {

            border-radius: 10px;

        }

        .result-box {

            margin-top: 20px;
            background: #111827;
            color: #22c55e;
            border-radius: 12px;
            min-height: 100px;
            padding: 20px;
            font-family: Consolas, monospace;
            word-break: break-all;

        }

        .history-box {

            max-height: 300px;
            overflow: auto;

        }

        .history-item {

            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            cursor: pointer;
            transition: .3s;

        }

        .history-item:hover {

            background: #eef5ff;

        }

        .badge-status {

            font-size: 13px;
            padding: 7px 12px;

        }

        .btn-custom {

            border-radius: 10px;
            font-weight: 600;

        }

        .table td {

            vertical-align: middle;

        }

        .footer {

            margin-top: 40px;
            text-align: center;
            color: #6b7280;

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
                🚀 Ziggy Route Tester
            </h1>

            <p>

                Test Laravel named routes, generate dynamic URLs,
                validate parameters and preview routes using Ziggy.

            </p>

        </div>

        <!-- Route Generator -->

        <div class="card card-custom">

            <div class="card-header">

                <h4 class="mb-0">

                    Route Generator

                </h4>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">

                        <label class="form-label">

                            Select Route

                        </label>

                        <select
                            id="routeSelect"
                            class="form-select">

                        </select>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">

                            Route Status

                        </label>

                        <br>

                        <span
                            id="statusBadge"
                            class="badge bg-success badge-status">

                            Ready

                        </span>

                    </div>

                </div>

                <hr>

                <div
                    id="parameterContainer">

                    <!-- Dynamic Inputs -->

                </div>

                <div class="row mt-4">

                    <div class="col-md-3 d-grid">

                        <button
                            class="btn btn-primary btn-custom"
                            onclick="generateRoute()">

                            ⚡ Generate URL

                        </button>

                    </div>

                    <div class="col-md-3 d-grid">

                        <button
                            class="btn btn-success btn-custom"
                            onclick="copyUrl()">

                            📋 Copy URL

                        </button>

                    </div>

                    <div class="col-md-3 d-grid">

                        <button
                            class="btn btn-warning btn-custom"
                            onclick="openRoute()">

                            🌍 Open Route

                        </button>

                    </div>

                    <div class="col-md-3 d-grid">

                        <button
                            class="btn btn-danger btn-custom"
                            onclick="clearInputs()">

                            🗑 Clear

                        </button>

                    </div>

                </div>

            </div>

        </div>

        <!-- Generated URL -->

        <div class="card card-custom">

            <div class="card-header">

                <h5 class="mb-0">

                    Generated URL

                </h5>

            </div>

            <div class="card-body">

                <div
                    id="resultBox"
                    class="result-box">

                    Waiting for Route...

                </div>

            </div>

        </div>

        <!-- Route History -->

        <div class="card card-custom">

            <div class="card-header d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    📜 Route History
                </h5>

                <button
                    class="btn btn-light btn-sm"
                    onclick="clearHistory()">

                    🗑 Clear History

                </button>

            </div>

            <div class="card-body history-box">

                <div
                    id="historyContainer">

                    <div class="text-center text-muted py-5">

                        No routes generated yet.

                    </div>

                </div>

            </div>

        </div>

        <!-- Statistics -->

        <div class="row mt-4">

            <div class="col-md-4">

                <div class="card card-custom text-center">

                    <div class="card-body">

                        <h2
                            id="totalGenerated"
                            class="text-primary">

                            0

                        </h2>

                        <p class="mb-0">

                            URLs Generated

                        </p>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card card-custom text-center">

                    <div class="card-body">

                        <h2
                            id="copiedCount"
                            class="text-success">

                            0

                        </h2>

                        <p class="mb-0">

                            URLs Copied

                        </p>

                    </div>

                </div>

            </div>

            <div class="col-md-4">

                <div class="card card-custom text-center">

                    <div class="card-body">

                        <h2
                            id="openedCount"
                            class="text-warning">

                            0

                        </h2>

                        <p class="mb-0">

                            URLs Opened

                        </p>

                    </div>

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
                href="{{ route('route.inspector') }}"
                class="btn btn-success btn-custom me-2">

                🔍 Route Inspector

            </a>

            <a
                href="{{ route('route.playground') }}"
                class="btn btn-warning btn-custom">

                🎯 Route Playground

            </a>

        </div>

        <!-- Footer -->

        <div class="footer">

            <hr>

            <p>

                Laravel 12 • Ziggy Route Tester • JavaScript

            </p>

            <small>

                Generate, validate and test Laravel named routes using Ziggy.

            </small>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const ziggyRoutes = window.Ziggy.routes;

        let generatedUrl = "";
        let totalGenerated = Number(localStorage.getItem("ziggy_total_generated") || 0);
        let copiedCount = Number(localStorage.getItem("ziggy_copied_count") || 0);
        let openedCount = Number(localStorage.getItem("ziggy_opened_count") || 0);

        document.addEventListener("DOMContentLoaded", () => {

            updateStatistics();

            loadRoutes();

            document
                .getElementById("routeSelect")
                .addEventListener("change", renderParameterInputs);

        });


        function loadRoutes() {

            const select = document.getElementById("routeSelect");

            select.innerHTML = "";

            Object.keys(ziggyRoutes).forEach(routeName => {

                select.innerHTML += `
            <option value="${routeName}">
                ${routeName}
            </option>
        `;

            });

            renderParameterInputs();

        }


        function renderParameterInputs() {

            const selectedRoute = document.getElementById("routeSelect").value;

            const container = document.getElementById("parameterContainer");

            container.innerHTML = "";

            const parameters = ziggyRoutes[selectedRoute].parameters || [];

            if (parameters.length === 0) {

                container.innerHTML = `

            <div class="alert alert-success">

                This route does not require parameters.

            </div>

        `;

                document.getElementById("statusBadge").className =
                    "badge bg-success badge-status";

                document.getElementById("statusBadge").innerHTML =
                    "Ready";

                return;

            }

            let html = `<div class="row">`;

            parameters.forEach(parameter => {

                html += `

        <div class="col-md-6 mb-3">

            <label class="form-label">

                ${parameter}

            </label>

            <input
                type="text"
                class="form-control route-param"
                data-name="${parameter}"
                placeholder="Enter ${parameter}">

        </div>

        `;

            });

            html += `</div>`;

            container.innerHTML = html;

            document.querySelectorAll(".route-param").forEach(input => {

                input.addEventListener("keyup", validateInputs);

            });

            validateInputs();

        }


        function validateInputs() {

            const inputs = document.querySelectorAll(".route-param");

            let valid = true;

            inputs.forEach(input => {

                if (input.value.trim() === "") {

                    valid = false;

                }

            });

            const badge = document.getElementById("statusBadge");

            if (inputs.length === 0) {

                badge.className = "badge bg-success badge-status";
                badge.innerHTML = "Ready";
                return;

            }

            if (valid) {

                badge.className = "badge bg-success badge-status";
                badge.innerHTML = "Valid";

            } else {

                badge.className = "badge bg-warning text-dark badge-status";
                badge.innerHTML = "Waiting Parameters";

            }

        }

        /* ==========================================================
           Generate Route + Copy + Open + Clear Inputs
           ========================================================== */

        function generateRoute() {

            const selectedRoute = document.getElementById("routeSelect").value;

            let params = {};

            document.querySelectorAll(".route-param").forEach(input => {

                const value = input.value.trim();

                if (value !== "") {

                    params[input.dataset.name] = value;

                }

            });

            try {

                generatedUrl = route(selectedRoute, params);

                document.getElementById("resultBox").innerHTML = `
            <strong>Generated URL</strong>
            <hr>
            ${generatedUrl}
        `;

                totalGenerated++;

                localStorage.setItem(
                    "ziggy_total_generated",
                    totalGenerated
                );

                updateStatistics();

                saveHistory(selectedRoute, generatedUrl);

                document.getElementById("statusBadge").className =
                    "badge bg-success badge-status";

                document.getElementById("statusBadge").innerHTML =
                    "Generated";

            } catch (error) {

                generatedUrl = "";

                document.getElementById("resultBox").innerHTML = `
            <span class="text-danger">
                Unable to generate URL.
                <br>
                Please fill all required parameters.
            </span>
        `;

                document.getElementById("statusBadge").className =
                    "badge bg-danger badge-status";

                document.getElementById("statusBadge").innerHTML =
                    "Invalid";

            }

        }



        function copyUrl() {

            if (generatedUrl === "") {

                alert("Generate a URL first.");

                return;

            }

            navigator.clipboard.writeText(generatedUrl);

            copiedCount++;

            localStorage.setItem(
                "ziggy_copied_count",
                copiedCount
            );

            updateStatistics();

            alert("URL copied successfully.");

        }



        function openRoute() {

            if (generatedUrl === "") {

                alert("Generate a URL first.");

                return;

            }

            if (generatedUrl.includes("{")) {

                alert("Please enter all parameters.");

                return;

            }

            openedCount++;

            localStorage.setItem(
                "ziggy_opened_count",
                openedCount
            );

            updateStatistics();

            window.open(generatedUrl, "_blank");

        }



        function clearInputs() {

            document.querySelectorAll(".route-param").forEach(input => {

                input.value = "";

            });

            generatedUrl = "";

            document.getElementById("resultBox").innerHTML =
                "Waiting for Route...";

            validateInputs();

        }

        /* ==========================================================
           History + LocalStorage + Statistics + Initialization
           ========================================================== */

        const HISTORY_KEY = "ziggy_route_history";

        /*
        |--------------------------------------------------------------------------
        | Save History
        |--------------------------------------------------------------------------
        */

        function saveHistory(routeName, url) {

            let history = JSON.parse(localStorage.getItem(HISTORY_KEY)) || [];

            history.unshift({
                name: routeName,
                url: url,
                time: new Date().toLocaleString()
            });

            // Keep only latest 10 records
            history = history.slice(0, 10);

            localStorage.setItem(HISTORY_KEY, JSON.stringify(history));

            loadHistory();

        }

        /*
        |--------------------------------------------------------------------------
        | Load History
        |--------------------------------------------------------------------------
        */

        function loadHistory() {

            const container = document.getElementById("historyContainer");

            let history = JSON.parse(localStorage.getItem(HISTORY_KEY)) || [];

            if (history.length === 0) {

                container.innerHTML = `
            <div class="text-center text-muted py-5">
                No routes generated yet.
            </div>
        `;

                return;
            }

            container.innerHTML = "";

            history.forEach(item => {

                container.innerHTML += `

        <div class="history-item">

            <div class="fw-bold">

                ${item.name}

            </div>

            <div class="small text-primary">

                ${item.url}

            </div>

            <div class="text-muted small">

                ${item.time}

            </div>

        </div>

        `;

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Clear History
        |--------------------------------------------------------------------------
        */

        function clearHistory() {

            if (!confirm("Clear route history?")) {
                return;
            }

            localStorage.removeItem(HISTORY_KEY);

            loadHistory();

        }

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        function updateStatistics() {

            document.getElementById("totalGenerated").innerHTML = totalGenerated;

            document.getElementById("copiedCount").innerHTML = copiedCount;

            document.getElementById("openedCount").innerHTML = openedCount;

        }

        /*
        |--------------------------------------------------------------------------
        | Auto Load
        |--------------------------------------------------------------------------
        */

        loadHistory();

        updateStatistics();

        /*
        |--------------------------------------------------------------------------
        | Expose Functions
        |--------------------------------------------------------------------------
        */

        window.generateRoute = generateRoute;
        window.copyUrl = copyUrl;
        window.openRoute = openRoute;
        window.clearInputs = clearInputs;
        window.clearHistory = clearHistory;
    </script>

</body>

</html>