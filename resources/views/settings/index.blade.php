<x-app-layout>
    <x-slot name="title">Settings - Ambulance Admin</x-slot>
    
    <div class="header">
        <button class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <h1>Settings</h1>
    </div>

    <div class="settings-container">
        <div class="settings-nav">
            <div class="settings-nav-items">
                <div class="settings-nav-item active">Notifications</div>
                <div class="settings-nav-item">Business Info</div>
                <div class="settings-nav-item">App Preferences</div>
                <div class="settings-nav-item">Security</div>
            </div>
        </div>

        <div class="settings-section">
            <h2>Notification Settings</h2>
            <div class="notification-item">
                <div>
                    <h3>New Booking Alerts</h3>
                    <p>Receive notifications for new bookings</p>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="notification-item">
                <div>
                    <h3>Emergency Alerts</h3>
                    <p>High-priority notifications for emergency situations</p>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="notification-item">
                <div>
                    <h3>Driver Updates</h3>
                    <p>Status changes and location updates from drivers</p>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
        </div>

        <div class="settings-section">
            <h2>Business Information</h2>
            <div class="settings-grid">
                <div class="form-group">
                    <label class="form-label">Business Name</label>
                    <input type="text" class="form-input" value="City Ambulance Services">
                </div>
                <div class="form-group">
                    <label class="form-label">Contact Email</label>
                    <input type="email" class="form-input" value="contact@cityambulance.com">
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" class="form-input" value="+1 234-567-8900">
                </div>
                <div class="form-group">
                    <label class="form-label">Business Address</label>
                    <textarea class="form-input" rows="3">123 Healthcare Street
Medical District
City, State 12345</textarea>
                </div>
            </div>
        </div>

        <div class="settings-section">
            <h2>App Preferences</h2>
            <div class="settings-grid">
                <div class="form-group">
                    <label class="form-label">Theme Color</label>
                    <div class="color-picker">
                        <div class="color-option active" style="background: #1976D2;"></div>
                        <div class="color-option" style="background: #2E7D32;"></div>
                        <div class="color-option" style="background: #C62828;"></div>
                        <div class="color-option" style="background: #7B1FA2;"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Language</label>
                    <select class="form-select">
                        <option>English</option>
                        <option>Spanish</option>
                        <option>French</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Time Zone</label>
                    <select class="form-select">
                        <option>UTC-05:00 Eastern Time</option>
                        <option>UTC-06:00 Central Time</option>
                        <option>UTC-07:00 Mountain Time</option>
                        <option>UTC-08:00 Pacific Time</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="save-bar">
        <button class="btn btn-cancel">Cancel</button>
        <button class="btn btn-primary">Save Changes</button>
    </div> -->

    @push('styles')
    <style>
        .settings-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .settings-nav {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .settings-nav-items {
            display: flex;
            gap: 20px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .settings-nav-item {
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .settings-nav-item.active {
            background: #E3F2FD;
            color: #1976D2;
        }

        .settings-nav-item:hover:not(.active) {
            background: #f5f5f5;
        }

        .settings-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .settings-section h2 {
            margin: 0 0 20px 0;
            padding-bottom: 15px;
            border-bottom: 2px solid #eee;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        .toggle-switch input:checked + .toggle-slider {
            background-color: #2196F3;
        }

        .toggle-switch input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }

        .notification-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .color-picker {
            display: flex;
            gap: 10px;
        }

        .color-option {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .color-option.active {
            border-color: #2196F3;
        }

        .save-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 15px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            text-align: right;
            z-index: 1000;
        }

        .save-bar button {
            margin-left: 10px;
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
    
    <script>
        function handleLogout() {
            // Clear login state
            localStorage.removeItem('isLoggedIn');
            localStorage.removeItem('userEmail');
            
            // Redirect to login page
            window.location.href = '../../login.html';
        }
        // Sidebar functionality
        const menuToggle = document.querySelector('.menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.overlay');

        function toggleSidebar() {
            sidebar.classList.toggle('expanded');
            overlay.classList.toggle('active');
        }

        menuToggle.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Settings navigation
        const navItems = document.querySelectorAll('.settings-nav-item');
        navItems.forEach(item => {
            item.addEventListener('click', () => {
                navItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
            });
        });

        // Color picker
        const colorOptions = document.querySelectorAll('.color-option');
        colorOptions.forEach(option => {
            option.addEventListener('click', () => {
                colorOptions.forEach(o => o.classList.remove('active'));
                option.classList.add('active');
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