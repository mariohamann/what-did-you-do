<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->

    <!-- Scripts used for the Map Component-->
    <!-- TODO: doublecheck again if there is no package that includes this version of the geocoder -->
    <script src="https://tiles.locationiq.com/v3/libs/gl-geocoder/4.5.1/locationiq-gl-geocoder.min.js?v=0.2.3"></script>
    <link rel="stylesheet"
        href="https://tiles.locationiq.com/v3/libs/gl-geocoder/4.5.1/locationiq-gl-geocoder.css?v=0.2.3"
        type="text/css" />

    @routes
    @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
