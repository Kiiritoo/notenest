<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteNest - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        purple: {
                            100: '#F3E8FF',
                            500: '#8B5CF6',
                            600: '#7C3AED',
                            700: '#6D28D9',
                        },
                        indigo: {
                            200: '#C7D2FE',
                        },
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-gradient-to-br from-purple-100 to-indigo-200 min-h-screen">
    <div class="absolute inset-0 bg-white opacity-10 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] [mask-image:radial-gradient(ellipse_50%_50%_at_50%_50%,#000_70%,transparent_100%)]"></div>
    <main class="relative z-10">
        @yield('content')
    </main>
</body>
</html>