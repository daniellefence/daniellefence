<!DOCTYPE html>
<html>
<head>
    <title>Test Product View</title>
</head>
<body>
    <h1>Product: {{ $product->title }}</h1>
    <p>Category: {{ $product->category->title }}</p>
    <p>Product ID: {{ $product->id }}</p>
</body>
</html>