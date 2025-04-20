<x-app-layout>
  <x-slot name="title">Show on Map - Ambulance Admin</x-slot>
  
  <div class="header">
    <button class="menu-toggle">
      <i class="fas fa-bars"></i>
    </button>
    <h1>Live Location Tracking</h1>
    <input type="search" placeholder="Search location..." class="search-bar" />
  </div>

  <div id="map">
    <div class="map-controls">
      <select id="vehicleFilter">
        <option value="all">All Vehicles</option>
        <option value="active">Active Only</option>
        <option value="idle">Idle Only</option>
      </select>
      <button id="centerMap">
        <i class="fas fa-location-arrow"></i> Center Map
      </button>
    </div>

    <div class="vehicle-list">
      <h3>Active Vehicles</h3>
      <div id="vehicleListContent"></div>
    </div>
  </div>

  @push('styles')
  <style>
    #map {
      height: calc(100vh - 100px);
      border-radius: 8px;
      position: relative;
    }

    .vehicle-list {
      position: absolute;
      right: 20px;
      top: 100px;
      background: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      width: 300px;
      max-height: 70vh;
      overflow-y: auto;
    }

    .vehicle-item {
      display: flex;
      align-items: center;
      padding: 10px;
      border-bottom: 1px solid #eee;
      cursor: pointer;
      transition: 0.3s;
    }

    .vehicle-item:hover {
      background: #f5f5f5;
    }

    .vehicle-status {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      margin-right: 10px;
    }

    .status-active {
      background: #4CAF50;
    }

    .status-idle {
      background: #FFC107;
    }

    .map-controls {
      position: absolute;
      top: 100px;
      left: 20px;
      background: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      z-index: 1000;
    }

    select,
    button {
      padding: 8px 15px;
      border: 1px solid #ddd;
      border-radius: 4px;
      margin: 5px 0;
      width: 100%;
    }

    button {
      background: #2c3e50;
      color: white;
      border: none;
      cursor: pointer;
    }

    button:hover {
      background: #34495e;
    }

    .menu-toggle {
      display: none;
      background: none;
      border: none;
      font-size: 1.5em;
      cursor: pointer;
    }

    @media (max-width: 1024px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.expanded {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
      }

      .menu-toggle {
        display: block;
      }
    }
  </style>
  @endpush

  @push('scripts')
  <script>
      // Authentication check before anything loads
      (function() {
          const isLoggedIn = localStorage.getItem('isLoggedIn');
          if (isLoggedIn !== 'true') {
              window.location.replace('../../login.html');
              throw new Error('Not authenticated'); // Stops further JavaScript execution
          }
      })();
  </script> 
  
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <script>
    // Updated sample ambulance data (Nepal locations)
    // Updated sample ambulance data (Nepal locations)
    function handleLogout() {
      // Clear login state
      localStorage.removeItem('isLoggedIn');
      localStorage.removeItem('userEmail');

      // Redirect to login page
      window.location.href = '../../login.html';
    }
    const ambulances = [
      {
        id: 'AMB-001',
        driver: 'Ramesh Gurung',
        status: 'active',
        position: [27.7172, 85.3240],  // Kathmandu (Thamel)
        lastUpdate: '2 mins ago',
        location: 'Thamel, Kathmandu'
      },
      {
        id: 'AMB-002',
        driver: 'Anjali Thapa',
        status: 'idle',
        position: [27.6710, 85.4298],  // Bhaktapur Durbar Square
        lastUpdate: '15 mins ago',
        location: 'Bhaktapur'
      },
      {
        id: 'AMB-003',
        driver: 'Rajesh Shrestha',
        status: 'active',
        position: [27.6730, 85.4278],  // Patan Durbar Square
        lastUpdate: '5 mins ago',
        location: 'Lalitpur'
      },
      {
        id: 'AMB-004',
        driver: 'Sunita Rai',
        status: 'active',
        position: [28.2096, 83.9856],  // Pokhara (Lakeside)
        lastUpdate: '7 mins ago',
        location: 'Lakeside, Pokhara'
      },
      {
        id: 'AMB-005',
        driver: 'Bikram Basnet',
        status: 'idle',
        position: [27.5811, 84.8481],  // Chitwan (Sauraha)
        lastUpdate: '20 mins ago',
        location: 'Sauraha, Chitwan'
      },
      {
        id: 'AMB-006',
        driver: 'Niraj Malla',
        status: 'active',
        position: [26.4525, 87.2718],  // Biratnagar
        lastUpdate: '3 mins ago',
        location: 'Biratnagar'
      },
      {
        id: 'AMB-007',
        driver: 'Sabina Magar',
        status: 'idle',
        position: [28.1084, 81.6198],  // Nepalgunj
        lastUpdate: '12 mins ago',
        location: 'Nepalgunj'
      },
      {
        id: 'AMB-008',
        driver: 'Amit Chaudhary',
        status: 'active',
        position: [26.8144, 87.2795],  // Dharan
        lastUpdate: '4 mins ago',
        location: 'Dharan'
      },
      {
        id: 'AMB-009',
        driver: 'Puja Limbu',
        status: 'active',
        position: [27.7000, 83.4667],  // Butwal
        lastUpdate: '8 mins ago',
        location: 'Butwal'
      },
      {
        id: 'AMB-010',
        driver: 'Santosh Yadav',
        status: 'idle',
        position: [26.7282, 85.9392],  // Janakpur
        lastUpdate: '25 mins ago',
        location: 'Janakpur'
      },
      {
        id: 'AMB-011',
        driver: 'Laxmi Tamang',
        status: 'active',
        position: [28.6945, 80.6053],  // Dhangadhi
        lastUpdate: '6 mins ago',
        location: 'Dhangadhi'
      },
      {
        id: 'AMB-012',
        driver: 'Bishal Gurung',
        status: 'idle',
        position: [27.4167, 85.0333],  // Hetauda
        lastUpdate: '18 mins ago',
        location: 'Hetauda'
      }
    ];

    // Initialize map without setting view yet
    const map = L.map('map');
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Store markers for filtering
    const markers = new Map();
    const markerGroup = L.featureGroup();

    // Create custom ambulance icons
    const activeIcon = L.icon({
      iconUrl: 'data:image/svg+xml;base64,' + btoa(`
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="32" height="32">
<!-- Ambulance body -->
<rect x="8" y="20" width="48" height="20" fill="#4CAF50"/>
<!-- Roof -->
<polygon points="8,20 8,12 28,12 38,20" fill="#4CAF50"/>
<!-- Windows -->
<rect x="12" y="14" width="12" height="6" fill="white"/>
<rect x="32" y="14" width="12" height="6" fill="white"/>
<!-- Wheels -->
<circle cx="20" cy="44" r="4" fill="black"/>
<circle cx="44" cy="44" r="4" fill="black"/>
<!-- Ambulance cross -->
<rect x="28" y="24" width="8" height="2" fill="white"/>
<rect x="31" y="21" width="2" height="8" fill="white"/>
</svg>
`),
      iconSize: [32, 32],
      iconAnchor: [16, 16],
      popupAnchor: [0, -16]
    });

    const idleIcon = L.icon({
      iconUrl: 'data:image/svg+xml;base64,' + btoa(`
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="32" height="32">
<!-- Ambulance body -->
<rect x="8" y="20" width="48" height="20" fill="#FFC107"/>
<!-- Roof -->
<polygon points="8,20 8,12 28,12 38,20" fill="#FFC107"/>
<!-- Windows -->
<rect x="12" y="14" width="12" height="6" fill="white"/>
<rect x="32" y="14" width="12" height="6" fill="white"/>
<!-- Wheels -->
<circle cx="20" cy="44" r="4" fill="black"/>
<circle cx="44" cy="44" r="4" fill="black"/>
<!-- Ambulance cross -->
<rect x="28" y="24" width="8" height="2" fill="white"/>
<rect x="31" y="21" width="2" height="8" fill="white"/>
</svg>
`),
      iconSize: [32, 32],
      iconAnchor: [16, 16],
      popupAnchor: [0, -16]
    });

    // Function to update vehicle list
    function updateVehicleList(filter = 'all') {
      const vehicleListContent = document.getElementById('vehicleListContent');
      vehicleListContent.innerHTML = '';

      ambulances.forEach(ambulance => {
        if (filter === 'all' || ambulance.status === filter) {
          const div = document.createElement('div');
          div.className = 'vehicle-item';
          div.innerHTML = `
      <span class="vehicle-status status-${ambulance.status}"></span>
      <div>
        <strong>${ambulance.id}</strong>
        <div>Driver: ${ambulance.driver}</div>
        <small>Status: ${ambulance.status === 'active' ? 'On Trip' : 'Idle'}</small>
        <div>Location: ${ambulance.location}</div>
        <small>Last update: ${ambulance.lastUpdate}</small>
      </div>`;
          div.addEventListener('mouseenter', () => {
            const marker = markers.get(ambulance.id);
            marker.openPopup();
          });
          div.addEventListener('mouseleave', () => {
            const marker = markers.get(ambulance.id);
            marker.closePopup();
          });
          vehicleListContent.appendChild(div);
        }
      });
    }

    // Add markers for each ambulance
    ambulances.forEach(ambulance => {
      const marker = L.marker(ambulance.position, {
        icon: ambulance.status === 'active' ? activeIcon : idleIcon
      }).bindPopup(`
  <strong>${ambulance.id}</strong><br>
  Driver: ${ambulance.driver}<br>
  Status: ${ambulance.status === 'active' ? 'On Trip' : 'Idle'}<br>
  Location: ${ambulance.location}<br>
  Last update: ${ambulance.lastUpdate}
`);
      markers.set(ambulance.id, marker);
      markerGroup.addLayer(marker);
    });

    // Add the marker group to the map
    markerGroup.addTo(map);

    // Fit the map to show all markers with padding
    map.fitBounds(markerGroup.getBounds(), {
      padding: [50, 50], // Add 50px padding around the bounds
      maxZoom: 7  // Limit the zoom level to show more context
    });

    // Initialize vehicle list
    updateVehicleList();

    // Handle filter change
    document.getElementById('vehicleFilter').addEventListener('change', (e) => {
      const filter = e.target.value;
      updateVehicleList(filter);

      // Show/hide markers based on filter
      markers.forEach((marker, id) => {
        const ambulance = ambulances.find(a => a.id === id);
        if (filter === 'all' || ambulance.status === filter) {
          marker.addTo(map);
        } else {
          marker.remove();
        }
      });
    });

    // Handle center map button
    document.getElementById('centerMap').addEventListener('click', () => {
      map.fitBounds(markerGroup.getBounds(), {
        padding: [50, 50],
        maxZoom: 7
      });
    });

    // Handle sidebar toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');

    menuToggle.addEventListener('click', () => {
      sidebar.classList.toggle('expanded');
    });

    // Handle window resize
    window.addEventListener('resize', () => {
      if (window.innerWidth > 1024) {
        sidebar.classList.remove('expanded');
      }
    });
  </script>
  @endpush
</x-app-layout>