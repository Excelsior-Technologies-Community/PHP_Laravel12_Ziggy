<!DOCTYPE html>
<html>
<head>
    <title>About Us</title>
    @vite('resources/js/app.js')
    <style>
        body { font-family: Arial; margin: 40px; }
        .nav { margin: 20px 0; }
        .btn { padding: 10px; background: #3b82f6; color: white; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>📖 About Page</h1>
    <p>This page demonstrates Ziggy navigation from Blade templates.</p>
    
    <div class="nav">
        <a href="{{ route('home') }}" class="btn">← Back to Home</a>
        <button onclick="goHome()" class="btn">Home via Ziggy JS</button>
        <button onclick="goContact()" class="btn">Contact via Ziggy JS</button>
    </div>
    
    <script>
        function goHome() {
            window.location.href = route('home');
        }
        
        function goContact() {
            window.location.href = route('contact');
        }
        
        // Show current route in console
        console.log('Current route:', Ziggy.current);
        console.log('Available routes:', Object.keys(Ziggy.routes));
    </script>
</body>
</html>