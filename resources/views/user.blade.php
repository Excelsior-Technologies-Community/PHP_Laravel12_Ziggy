<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    @vite('resources/js/app.js')
</head>
<body>
    <h1>👤 User Profile</h1>
    <p>Showing user with ID: {{ $id }}</p>
    
    <button onclick="window.location.href = route('home')">Back to Home</button>
    <button onclick="history.back()">Go Back</button>
    
    <script>
        console.log('User ID from Blade: {{ $id }}');
        console.log('Current route params:', Ziggy.current.params);
    </script>
</body>
</html>