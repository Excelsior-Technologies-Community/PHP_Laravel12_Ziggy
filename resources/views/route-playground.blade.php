<!DOCTYPE html>
<html>

<head>

    <title>Route Playground</title>

    @routes
    @vite('resources/js/app.js')

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 40px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
        }

        h1 {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 20px;
            font-weight: bold;
        }

        select,
        input {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #params {
            margin-top: 20px;
        }

        #urlOutput {
            margin-top: 25px;
            padding: 15px;
            background: #eef5ff;
            border-radius: 5px;
            word-break: break-all;
        }

        .btn {
            margin-top: 20px;
            padding: 10px 18px;
            border: none;
            background: #2563eb;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        a {
            text-decoration: none;
        }
    </style>

</head>

<body>

    <div class="container">

        <h1>🎯 Ziggy Route Playground</h1>

        <p>Generate Laravel URLs dynamically.</p>

        <label>Select Route</label>

        <select id="routeSelect"></select>

        <div id="params"></div>

        <h3>Generated URL</h3>

        <div id="urlOutput">
            Select a route...
        </div>

        <button class="btn" onclick="copyUrl()">
            📋 Copy URL
        </button>

        <button class="btn" onclick="openUrl()">
            🌐 Open URL
        </button>

        <br><br>

        <a href="{{ route('home') }}" class="btn">
            Home
        </a>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const routeSelect = document.getElementById('routeSelect');
            const paramsDiv = document.getElementById('params');
            const output = document.getElementById('urlOutput');

            if (!window.Ziggy) {
                output.innerHTML = "Ziggy is not loaded.";
                return;
            }

            const routes = window.Ziggy.routes;

            // Populate route dropdown
            const options = Object.keys(routes)
                .map(name => `<option value="${name}">${name}</option>`)
                .join("");

            routeSelect.innerHTML = options;

            function buildInputs() {

                paramsDiv.innerHTML = "";

                const selected = routeSelect.value;

                const parameters = routes[selected].parameters || [];

                parameters.forEach(parameter => {

                    paramsDiv.innerHTML += `
                <label>${parameter}</label>

                <input
                    class="route-param"
                    data-name="${parameter}"
                    placeholder="Enter ${parameter}"
                >
            `;

                });

                document.querySelectorAll(".route-param").forEach(input => {
                    input.addEventListener("input", generateUrl);
                });

                generateUrl();
            }

            function generateUrl() {

                const selected = routeSelect.value;

                let values = {};

                document.querySelectorAll(".route-param").forEach(input => {

                    values[input.dataset.name] =
                        input.value.trim() || `{${input.dataset.name}}`;

                });

                try {

                    output.textContent =
                        decodeURIComponent(route(selected, values));

                } catch (e) {

                    output.textContent = "Unable to generate URL.";

                }

            }

            routeSelect.addEventListener("change", buildInputs);

            buildInputs();

            window.copyUrl = function() {

                if (!output.innerText) {
                    alert("No URL available.");
                    return;
                }

                navigator.clipboard.writeText(output.textContent);

                alert("URL copied successfully.");

            };

            window.openUrl = function() {

                if (
                    output.textContent.startsWith("http") &&
                    !output.textContent.includes("{")
                ) {

                    window.open(output.textContent, "_blank");

                } else {

                    alert("Please fill all required parameters first.");

                }

            };

        });
    </script>

</body>

</html>