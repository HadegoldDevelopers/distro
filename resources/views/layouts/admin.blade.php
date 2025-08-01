<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

<!-- Alpine.js for Dropdowns -->
<script src="//unpkg.com/alpinejs" defer></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">
 @include('partials.admin.aside')
    <div class="min-h-screen flex">
      
       
        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-8 overflow-auto">
        @include('partials.flash-messages')

            @yield('content')
        </main>
    </div>

</body>
</html>
