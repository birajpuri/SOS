<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Ambulance App' }}</title>

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Add Leaflet CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div class="overlay"></div>
    <nav class="sidebar">
        <div class="logo">
            <i class="fas fa-ambulance"></i>
            Ambulance Admin
        </div>
        <a href="index.html" class="nav-item active ">
            <i class="fas fa-home"></i>
            Dashboard
        </a>
        <a href="pages/booking-history/index.html" class="nav-item ">
            <i class="fas fa-home"></i>
            Booking History
        </a>
        <a href='{{route('user.index')}}' class="nav-item">
            <i class="fas fa-users"></i>
            Manage Users
        </a>
        <a href="pages/show-on-map/index.html" class="nav-item">
            <i class="fas fa-map-marker-alt"></i>
            Show on Map
        </a>
        <a href="pages/manage-drivers/index.html" class="nav-item">
            <i class="fas fa-id-card"></i>
            Manage Drivers
        </a>
        <a href="pages/manage-vehicles/index.html" class="nav-item ">
            <i class="fas fa-ambulance"></i>
            Manage Vehicles
        </a>
        <a href="pages/hospital/index.html" class="nav-item">
            <i class="fas fa-ambulance"></i>
            Hospital
        </a>
        <a href="pages/emergency-sos/index.html" class="nav-item">
            <i class="fas fa-exclamation-circle"></i>
            Emergency SOS
        </a>
        <a href="pages/help-and-support/index.html" class="nav-item  ">
            <i class="fas fa-headset"></i>
            Help & Support
        </a>
        <a href="pages/settings/index.html" class="nav-item">
            <i class="fas fa-cog"></i>
            Settings
        </a>
        <form action="{{ route('logout') }}" method="POST" class="nav-item">
            @csrf
            <button type="submit">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </form>
    </nav>
    <main class="main-content">
       {{ $slot }}
    </main>
    @stack('scripts')
</body>

</html>
