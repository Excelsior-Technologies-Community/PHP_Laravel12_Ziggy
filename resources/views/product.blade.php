<!DOCTYPE html>
<html>
<head>
    <title>Product</title>
    @vite('resources/js/app.js')
</head>
<body>
    <h1>🛍️ Product Page</h1>
    
    @if($id)
        <p>Showing product with ID: {{ $id }}</p>
    @else
        <p>Showing all products</p>
    @endif
    
    <button onclick="window.location.href = route('home')">Home</button>
</body>
</html>