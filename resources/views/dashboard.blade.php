<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>
    <div class="header">
        <button class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <h1>Dashboard Overview</h1>
        <input type="search" placeholder="Search..." class="search-bar">
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Active Ambulances</h3>
            <div class="value">24</div>
        </div>
        <div class="stat-card">
            <h3>Pending Requests</h3>
            <div class="value">8</div>
        </div>
        <div class="stat-card">
            <h3>Completed Today</h3>
            <div class="value">47</div>
        </div>
        <div class="stat-card">
            <h3>Emergency SOS</h3>
            <div class="value">2</div>
        </div>
    </div>

    <div class="map-container">
        <h2>Live Ambulance Tracking</h2>
        <div id="map"></div>
    </div>

    <div class="recent-requests">
        <h2>Recent Requests</h2>
        <table>
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Patient Name</th>
                    <th>Location</th>
                    <th>Driver</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#12345</td>
                    <td>John Doe</td>
                    <td>123 Main St</td>
                    <td>Mike Johnson</td>
                    <td><span class="status active">Active</span></td>
                </tr>
                <tr>
                    <td>#12344</td>
                    <td>Jane Smith</td>
                    <td>456 Oak Ave</td>
                    <td>Sarah Wilson</td>
                    <td><span class="status pending">Pending</span></td>
                </tr>
            </tbody>
        </table>
    </div>
    @push('styles')
    <style>
        .map-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        #map {
            height: 400px;
            width: 100%;
            border-radius: 4px;
        }

        /* Ambulance marker custom style */
        .ambulance-marker {
            background: none;
            border: none;
        }

        .ambulance-marker i {
            font-size: 24px;
            color: #e74c3c;
        }
    </style>
    @endpush
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    {{-- <script>

        (function () {
            const isLoggedIn = localStorage.getItem('isLoggedIn');
            if (isLoggedIn !== 'true') {
                window.location.replace('login.html');
                throw new Error('Not authenticated');
            }
        })();
    
        function handleLogout() {
            // Clear login state
            localStorage.removeItem('isLoggedIn');
            localStorage.removeItem('userEmail');
    
            // Redirect to login page
            window.location.href = 'login.html';
        }
    </script> --}}
    <script>

        // Your previous sidebar toggle code remains the same

        // Initialize the map
        const map = L.map('map').setView([28.6139, 77.2090], 12); // Centered on Delhi by default

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Sample ambulance data - replace with your real-time data
        const ambulances = [
            { id: 1, lat: 28.6129, lng: 77.2295, status: 'active', driver: 'Mike Johnson' },
            { id: 2, lat: 28.6139, lng: 77.2090, status: 'active', driver: 'Sarah Wilson' },
            { id: 3, lat: 28.6219, lng: 77.2190, status: 'pending', driver: 'John Smith' }
        ];

        // Custom ambulance icon
        const createAmbulanceMarker = (ambulance) => {
            const markerHtml = `<i class="fas fa-ambulance" style="color: ${ambulance.status === 'active' ? '#e74c3c' : '#95a5a6'}"></i>`;
            const icon = L.divIcon({
                html: markerHtml,
                className: 'ambulance-marker',
                iconSize: [24, 24],
                iconAnchor: [12, 12]
            });

            const marker = L.marker([ambulance.lat, ambulance.lng], { icon })
                .addTo(map);

            // Add popup with ambulance info
            marker.bindPopup(`
                <b>Ambulance #${ambulance.id}</b><br>
                Driver: ${ambulance.driver}<br>
                Status: ${ambulance.status}
            `);

            return marker;
        };

        // Add ambulance markers to map
        const ambulanceMarkers = ambulances.map(createAmbulanceMarker);

        // Simulate ambulance movement (for demo purposes)
        setInterval(() => {
            ambulances.forEach((ambulance, index) => {
                // Add small random movement
                ambulance.lat += (Math.random() - 0.5) * 0.001;
                ambulance.lng += (Math.random() - 0.5) * 0.001;

                // Update marker position
                ambulanceMarkers[index].setLatLng([ambulance.lat, ambulance.lng]);
            });
        }, 3000);

        // Handle window resize for map
        window.addEventListener('resize', () => {
            map.invalidateSize();
        });
    </script>

    <script>
        // DOM Elements
        const menuToggle = document.querySelector('.menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        const overlay = document.querySelector('.overlay');
        const navItems = document.querySelectorAll('.nav-item');

        // Toggle sidebar
        function toggleSidebar() {
            sidebar.classList.toggle('expanded');
            overlay.classList.toggle('active');
        }

        // Event Listeners
        menuToggle.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Handle navigation item clicks
        navItems.forEach(item => {
            item.addEventListener('click', (e) => {
                // Remove active class from all items
                navItems.forEach(nav => nav.classList.remove('active'));
                // Add active class to clicked item
                item.classList.add('active');

                // On mobile, close sidebar after navigation
                if (window.innerWidth <= 1024) {
                    toggleSidebar();
                }

                //e.preventDefault(); // Prevent default link behavior
            });
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024) {
                sidebar.classList.remove('expanded');
                overlay.classList.remove('active');
            }
        });
    </script>
    @endpush
</x-app-layout>