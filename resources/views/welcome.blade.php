<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Email Campaign App</title>
    @vite('resources/js/main.js') <!-- Use the correct entry point -->
</head>
<body>
    <div id="app"></div>
</body>
</html>
