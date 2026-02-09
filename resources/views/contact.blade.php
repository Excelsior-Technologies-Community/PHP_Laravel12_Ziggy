<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    @vite('resources/js/app.js')
</head>
<body>
    <h1>📞 Contact Page</h1>
    <p>Using Ziggy for all navigation links.</p>
    
    <button onclick="window.location.href = route('home')">Home</button>
    <button onclick="window.location.href = route('about')">About</button>
    
    <h3>Dynamic Links:</h3>
    <button onclick="window.location.href = route('user.profile', {id: 123})">User 123</button>
    <button onclick="window.location.href = route('post.details', {category: 'news', slug: 'latest-update'})">Latest News</button>
</body>
</html>