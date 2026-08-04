<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laravel Ziggy Demo</title>

    @routes
    @vite('resources/js/app.js')

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {

            font-family: "Segoe UI", Arial, sans-serif;
            background: #eef2ff;
            color: #1e293b;

        }


        .container {

            width: 95%;
            max-width: 1200px;
            margin: 25px auto;

        }


        /* Hero */

        .hero {

            background: linear-gradient(135deg, #2563eb, #4f46e5);
            color: white;
            border-radius: 18px;
            padding: 35px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(37, 99, 235, .25);

        }


        .hero h1 {

            font-size: 38px;
            margin-bottom: 10px;

        }


        .hero p {

            font-size: 17px;
            line-height: 1.6;
            max-width: 700px;
            margin: auto;

        }


        .hero-buttons {

            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;

        }


        .hero-btn {

            padding: 12px 25px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: .3s;

        }


        .hero-btn:hover {

            transform: translateY(-3px);

        }


        .primary {

            background: white;
            color: #2563eb;

        }


        .secondary {

            background: rgba(255, 255, 255, .2);
            color: white;
            border: 1px solid rgba(255, 255, 255, .4);

        }



        /* Section */

        .section-title {

            text-align: center;
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 26px;

        }



        /* Cards */

        .grid {

            margin-top: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 18px;

        }


        .card {

            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
            transition: .3s;

        }


        .card:hover {

            transform: translateY(-5px);

        }


        .card h2 {

            color: #2563eb;
            margin-bottom: 10px;
            font-size: 21px;

        }


        .card p {

            color: #64748b;
            line-height: 1.5;
            margin-bottom: 15px;

        }



        /* Buttons */


        .btn {

            width: 100%;
            margin-top: 8px;
            padding: 11px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;

        }


        .btn-primary {

            background: #2563eb;
            color: white;

        }


        .btn-secondary {

            background: #0f172a;
            color: white;

        }


        .btn:hover {

            opacity: .9;

        }



        @media(max-width:768px) {

            .hero h1 {

                font-size: 30px;

            }


            .hero {

                padding: 25px;

            }

        }
    </style>

</head>


<body>


    <div class="container">


        <div class="hero">


            <h1>
                🚀 Laravel Ziggy Route Generator
            </h1>


            <p>

                Generate Laravel named routes directly inside JavaScript using Ziggy.
                Explore dynamic URL generation, route parameters, route inspection
                and interactive developer tools.

            </p>



            <div class="hero-buttons">


                <button
                    class="hero-btn primary"
                    onclick="goInspector()">

                    🔍 Route Inspector

                </button>



                <button
                    class="hero-btn secondary"
                    onclick="goPlayground()">

                    🎯 Route Playground

                </button>


            </div>


        </div>



        <h2 class="section-title">
            ⚡ Ziggy Features
        </h2>



        <div class="grid">



            <div class="card">


                <h2>
                    📦 Basic Routes
                </h2>


                <p>
                    Navigate Laravel named routes directly using JavaScript.
                </p>


                <button class="btn btn-primary"
                    onclick="goAbout()">

                    About Page

                </button>


                <button class="btn btn-secondary"
                    onclick="goContact()">

                    Contact Page

                </button>


            </div>





            <div class="card">


                <h2>
                    🔗 Route Parameters
                </h2>


                <p>
                    Generate dynamic URLs with route parameters.
                </p>


                <button class="btn btn-primary"
                    onclick="goToUser(5)">

                    User #5

                </button>


                <button class="btn btn-secondary"
                    onclick="goToUser(10)">

                    User #10

                </button>


            </div>





            <div class="card">


                <h2>
                    🛒 Optional Parameters
                </h2>


                <p>
                    Test optional route parameters using Ziggy.
                </p>


                <button class="btn btn-primary"
                    onclick="goToProduct(42)">

                    Product #42

                </button>


                <button class="btn btn-secondary"
                    onclick="goToProduct()">

                    All Products

                </button>


            </div>





            <div class="card">


                <h2>
                    📝 Multiple Parameters
                </h2>


                <p>
                    Generate URLs containing multiple parameters.
                </p>


                <button class="btn btn-primary"
                    onclick="goToPost('technology','laravel-tips')">

                    View Blog Post

                </button>


            </div>


        </div>

        <!-- Route Information -->

        <h2 class="section-title">
            🔍 Route Information
        </h2>


        <div class="grid">


            <div class="card">

                <h2>
                    📍 Current Route
                </h2>


                <p>
                    Check current URL information using Ziggy.
                </p>


                <button
                    class="btn btn-primary"
                    onclick="showCurrentRoute()">

                    Show Current Route

                </button>


            </div>




            <div class="card">

                <h2>
                    🛣️ Available Routes
                </h2>


                <p>
                    Display all Laravel routes available in JavaScript.
                </p>


                <button
                    class="btn btn-secondary"
                    onclick="showAllRoutes()">

                    Show All Routes

                </button>


            </div>


        </div>





        <!-- Developer Tools -->


        <h2 class="section-title">
            ⚡ Ziggy Developer Tools
        </h2>



        <div class="card">


            <h2>
                🚀 Route Utilities
            </h2>


            <p>

                Inspect routes and generate Laravel URLs dynamically.

            </p>



            <div class="grid">


                <div>

                    <button
                        class="btn btn-primary"
                        onclick="goInspector()">

                        🔍 Open Route Inspector

                    </button>


                </div>



                <div>

                    <button
                        class="btn btn-secondary"
                        onclick="goPlayground()">

                        🎯 Open Route Playground

                    </button>


                </div>


            </div>


        </div>






        <!-- Result -->

        <h2 class="section-title">
            📌 Generated Result
        </h2>



        <div id="result"
            class="card"
            style="
background:#0f172a;
color:#22c55e;
font-family:Consolas,monospace;
min-height:70px;
display:flex;
align-items:center;
">


            Waiting for action...


        </div>






        <!-- Code Example -->


        <h2 class="section-title">
            💻 Ziggy Code Examples
        </h2>



        <div class="card"
            style="
background:#111827;
color:#e2e8f0;
font-family:Consolas,monospace;
overflow:auto;
">


            <pre>


// Basic Route

route('about');


// Route Parameter

route('user.profile',{
    id:5
});


// Multiple Parameters

route('post.details',{
    category:'technology',
    slug:'laravel-tips'
});


// Get All Routes

Object.keys(Ziggy.routes);


</pre>


        </div>







        <footer
            style="
margin-top:25px;
text-align:center;
padding:15px;
color:#64748b;
">


            <p>
                Laravel 12 • Ziggy 2.x • Vite • JavaScript
            </p>


            <p>
                🚀 Dynamic Laravel Routes Powered by Ziggy
            </p>


        </footer>





    </div>






    <script>
        function showResult(message) {

            document.getElementById('result').innerHTML =
                `
<strong>Result:</strong>
<br><br>
${message}
`;

        }


        function goAbout() {

            const url = route('about');

            showResult(url);

            setTimeout(() => {

                window.location.href = url;

            }, 800);

        }

        function goContact() {

            const url = route('contact');

            showResult(url);


            setTimeout(() => {

                window.location.href = url;

            }, 800);


        }

        function goToUser(id) {

            const url = route('user.profile', {
                id: id
            });


            showResult(url);


            setTimeout(() => {

                window.location.href = url;

            }, 800);


        }


        function goToProduct(id = null) {


            let url;


            if (id) {

                url = route('product.show', {
                    id: id
                });

            } else {

                url = route('product.show');

            }

            showResult(url);



            setTimeout(() => {

                window.location.href = url;

            }, 800);



        }

        function goToPost(category, slug) {


            const url = route('post.details', {

                category: category,

                slug: slug

            });

            showResult(url);

            setTimeout(() => {

                window.location.href = url;

            }, 800);


        }

        function showCurrentRoute() {

            const currentRoute = route().current();

            if (currentRoute) {

                showResult(
                    `
            URL: ${window.location.href}
            <br>
            Route Name: ${currentRoute}
            `
                );

            } else {

                showResult(
                    `
            URL: ${window.location.href}
            <br>
            Route Name: Not Found
            `
                );

            }

        }

        function showAllRoutes() {


            const routes =
                Object.keys(window.Ziggy.routes)
                .join("<br>");



            showResult(routes);


        }


        function goInspector() {


            window.location.href =
                route('route.inspector');


        }

        function goPlayground() {


            window.location.href =
                route('route.playground');


        }

        console.log("🚀 Ziggy Loaded");

        console.log(window.Ziggy);
    </script>


</body>

</html>