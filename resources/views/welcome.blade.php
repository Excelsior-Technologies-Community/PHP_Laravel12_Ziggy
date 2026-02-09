<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziggy Demo - Home</title>
    @vite('resources/js/app.js')
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; padding: 20px; }
        .container { background: #f5f5f5; padding: 20px; border-radius: 8px; }
        .btn { padding: 10px 20px; margin: 5px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-primary { background: #3b82f6; color: white; }
        .btn-secondary { background: #6b7280; color: white; }
        .code-block { background: #1e293b; color: #e2e8f0; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .result { background: #dcfce7; padding: 10px; border-radius: 4px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏠 Ziggy Demo Project</h1>
        <p>Laravel routes accessible in JavaScript using Ziggy</p>
        
        <h2>📦 Basic Navigation</h2>
        <button class="btn btn-primary" onclick="goAbout()">Go to About Page</button>
        <button class="btn btn-primary" onclick="goContact()">Go to Contact Page</button>
        
        <h2>🔗 Route with Parameters</h2>
        <button class="btn btn-secondary" onclick="goToUser(5)">View User ID: 5</button>
        <button class="btn btn-secondary" onclick="goToUser(10)">View User ID: 10</button>
        
        <h2>🛒 Optional Parameters</h2>
        <button class="btn btn-secondary" onclick="goToProduct(42)">View Product ID: 42</button>
        <button class="btn btn-secondary" onclick="goToProduct()">View All Products</button>
        
        <h2>📝 Multiple Parameters</h2>
        <button class="btn btn-secondary" onclick="goToPost('technology', 'laravel-tips')">View Post</button>
        
        <h2>🔍 Current Route Info</h2>
        <button class="btn" onclick="showCurrentRoute()">Show Current Route</button>
        <button class="btn" onclick="showAllRoutes()">Show All Available Routes</button>
        
        <div id="result" class="result"></div>
        
        <h2>💻 Code Examples</h2>
        <div class="code-block">
            <pre><code>
// Basic route usage:
route('about'); // Returns: http://localhost:8000/about

// With parameters:
route('user.profile', { id: 5 }); // Returns: http://localhost:8000/user/5

// Multiple parameters:
route('post.details', { 
    category: 'tech', 
    slug: 'laravel-12' 
}); // Returns: http://localhost:8000/post/tech/laravel-12

// Check current route:
Ziggy.current; // Returns current route name and parameters
            </code></pre>
        </div>
    </div>

    <script>
        function showResult(message) {
            document.getElementById('result').innerHTML = `<strong>Result:</strong> ${message}`;
        }

        function goAbout() {
            const url = route('about');
            showResult(`Navigating to: ${url}`);
            setTimeout(() => window.location.href = url, 1000);
        }

        function goContact() {
            const url = route('contact');
            showResult(`Navigating to: ${url}`);
            setTimeout(() => window.location.href = url, 1000);
        }

        function goToUser(id) {
            const url = route('user.profile', { id: id });
            showResult(`User URL: ${url}`);
            setTimeout(() => window.location.href = url, 1000);
        }

        function goToProduct(id = null) {
            if (id) {
                const url = route('product.show', { id: id });
                showResult(`Product URL: ${url}`);
                setTimeout(() => window.location.href = url, 1000);
            } else {
                const url = route('product.show');
                showResult(`All Products URL: ${url}`);
                setTimeout(() => window.location.href = url, 1000);
            }
        }

        function goToPost(category, slug) {
            const url = route('post.details', { 
                category: category, 
                slug: slug 
            });
            showResult(`Post URL: ${url}`);
            setTimeout(() => window.location.href = url, 1000);
        }

        function showCurrentRoute() {
            if (Ziggy.current) {
                showResult(`Current route: ${Ziggy.current.name} with params: ${JSON.stringify(Ziggy.current.params)}`);
            } else {
                showResult('No current route data available');
            }
        }

        function showAllRoutes() {
            const routes = Object.keys(Ziggy.routes).join(', ');
            showResult(`Available routes: ${routes}`);
        }

        // Example of using Ziggy in console
        console.log('Try these in console:');
        console.log('1. route("about")');
        console.log('2. route("user.profile", { id: 7 })');
        console.log('3. Ziggy.current');
        console.log('4. Ziggy.routes');
    </script>
</body>
</html>