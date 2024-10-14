<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRG5</title>
    @vite('resources/css/app.css')
</head>
<body>
<nav>
    <x-nav-link href="/home" :active="request()->routeIs('home')">Home</x-nav-link>
    <x-nav-link href="/models" :active="request()->routeIs('models')">Models</x-nav-link>
    <x-nav-link href="/about" :active="request()->routeIs('about')">About</x-nav-link>
</nav>

{{$slot}}

</body>
</html>
