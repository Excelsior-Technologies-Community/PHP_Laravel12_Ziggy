<!DOCTYPE html>
<html>
<head>
    <title>Post</title>
    @vite('resources/js/app.js')
</head>
<body>
    <h1>📝 Post Details</h1>
    <p>Category: {{ $category }}</p>
    <p>Slug: {{ $slug }}</p>
    
    <button onclick="window.location.href = route('home')">Home</button>
</body>
</html>