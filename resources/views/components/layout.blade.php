<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Aturin</title>
</head>
<body class="flex relative flex-col sm:flex-row h-screen">

    <!-- Sidebar -->
    <x-sidebar class="fixed sm:relative top-0 left-0 w-full sm:w-[20%] h-full sm:h-screen bg-white shadow z-[60]"></x-sidebar>

    <!-- Main content -->
    <main class="bg-gray-100 relative w-full sm:w-[80%] h-full sm:h-auto overflow-auto p-4 z-[50]">
        {{ $slot }}
    </main>

</body>
</html>
