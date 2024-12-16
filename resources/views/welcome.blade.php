<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TODO List</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-image: url('https://example.com/your-background-image.jpg');
            /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #333;
            /* Adjust text color for better contrast */
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            /* Semi-transparent white background for better readability */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .task-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.2s;
        }

        .task-card:hover {
            transform: scale(1.02);
        }

        .btn-add {
            background-color: #28a745;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-add:hover,
        .btn-delete:hover {
            opacity: 0.8;
        }

        .task-input {
            border-radius: 0.5rem;
        }

        .header-title {
            color: #007bff;
            margin-bottom: 20px;
        }

    </style>
</head>

<body class="antialiased font-sans">
    <div class="container">

        <header class="text-center mb-4">
            @if (Route::has('login'))
                <livewire:welcome.navigation />
            @endif
        </header>
        <div class="container mt-5">
            @livewire('task-manager')
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>

</html>
