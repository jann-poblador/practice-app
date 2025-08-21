<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? env('APP_NAME') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <nav class="bg-gray-800 p-4">
            <div class="container mx-auto">
                <ul class="flex space-x-4">
                    <li><a href="{{ url('/') }}" class="text-white">Home</a></li>
                    <li><a href="{{ url('/about') }}" class="text-white">About</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-white">Contact</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        {{ $slot }}
    </main>
</body>
</html>