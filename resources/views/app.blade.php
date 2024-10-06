<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        @vite('resources/js/app.js')
        @inertiaHead
    </head>
    <body class="font-sans antialiased bg-gray-200 dark:bg-black dark:text-white/50 ">
         @inertia 
    </body>
</html>
