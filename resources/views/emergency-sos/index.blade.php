<x-app-layout>
    <x-slot name="title">Alerts - Admin Dashboard</x-slot>
    <div class="header">
        <button class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <h1>Emergency SOS Alerts</h1>
    </div>

    <div class="table-controls">
        <input type="search" placeholder="Search..." class="search-input">
        <select class="filter-select">
            <option value="">All Status</option>
            <option value="pending">Pending</option>
            <option value="resolved">Resolved</option>
        </select>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h2>SOS Requests</h2>
        </div>
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Patient Name</th>
                    <th>Location</th>
                    <th>Coordinates</th>
                    <th>Request Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td data-label="Request ID">#98765</td>
                    <td data-label="Patient Name">Alice Brown</td>
                    <td data-label="Location">789 Maple St</td>
                    <td data-label="Coordinates">40.7128° N, 74.0060° W</td>
                    <td data-label="Request Time">2024-02-22 14:30</td>
                    <td data-label="Status"><span class="status pending">Pending</span></td>
                    <td data-label="Actions">
                        <div class="action-buttons">
                            <button class="btn btn-view" onclick="openModal('#98765')">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="btn btn-resolve">
                                <i class="fas fa-check"></i> Resolve
                            </button>
                            <button class="btn btn-delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td data-label="Request ID">#98766</td>
                    <td data-label="Patient Name">Bob White</td>
                    <td data-label="Location">321 Pine Ave</td>
                    <td data-label="Coordinates">40.7589° N, 73.9851° W</td>
                    <td data-label="Request Time">2024-02-22 15:45</td>
                    <td data-label="Status"><span class="status resolved">Resolved</span></td>
                    <td data-label="Actions">
                        <div class="action-buttons">
                            <button class="btn btn-view" onclick="openModal('#98766')">
                                <i class="fas fa-eye"></i> View
                            </button>
                            <button class="btn btn-delete">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Modals --}}
    <div id="requestModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h2>Emergency Request Details</h2>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Request ID</div>
                    <div id="modalRequestId"></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Patient Name</div>
                    <div id="modalPatientName"></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Location</div>
                    <div id="modalLocation"></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Coordinates</div>
                    <div id="modalCoordinates"></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Contact Number</div>
                    <div id="modalContact"></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Request Time</div>
                    <div id="modalTime"></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Emergency Type</div>
                    <div id="modalEmergencyType"></div>
                </div>
                <div class="info-item">
                    <div class="info-label">Status</div>
                    <div id="modalStatus"></div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            position: relative;
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            width: 80%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .close-modal {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 24px;
            cursor: pointer;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .info-item {
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .info-label {
            font-weight: bold;
            color: #666;
            margin-bottom: 5px;
        }

        .btn-view {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-view:hover {
            background-color: #45a049;
        }

        .status {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.9em;
        }

        .status.pending {
            background-color: #ffd700;
            color: #000;
        }

        .status.resolved {
            background-color: #4CAF50;
            color: white;
        }
    </style>
    @endpush
    @push('scripts')
    {{-- <script>
        // Authentication check before anything loads
        (function() {
            const isLoggedIn = localStorage.getItem('isLoggedIn');
            if (isLoggedIn !== 'true') {
                window.location.replace('../../login.html');
                throw new Error('Not authenticated'); // Stops further JavaScript execution
            }
        })();
    </script> --}}
    <script>
        function handleLogout() {
            // Clear login state
            localStorage.removeItem('isLoggedIn');
            localStorage.removeItem('userEmail');

            // Redirect to login page
            window.location.href = '../../login.html';
        }
        // Sample data for the modal
        const emergencyData = {
            '#98765': {
                requestId: '#98765',
                patientName: 'Alice Brown',
                location: '789 Maple St',
                coordinates: '40.7128° N, 74.0060° W',
                contactNumber: '+1 (555) 123-4567',
                requestTime: '2024-02-22 14:30',
                emergencyType: 'Medical Emergency',
                status: 'Pending'
            },
            '#98766': {
                requestId: '#98766',
                patientName: 'Bob White',
                location: '321 Pine Ave',
                coordinates: '40.7589° N, 73.9851° W',
                contactNumber: '+1 (555) 987-6543',
                requestTime: '2024-02-22 15:45',
                emergencyType: 'Accident',
                status: 'Resolved'
            }
        };

        function openModal(requestId) {
            const modal = document.getElementById('requestModal');
            const data = emergencyData[requestId];

            // Populate modal with data
            document.getElementById('modalRequestId').textContent = data.requestId;
            document.getElementById('modalPatientName').textContent = data.patientName;
            document.getElementById('modalLocation').textContent = data.location;
            document.getElementById('modalCoordinates').textContent = data.coordinates;
            document.getElementById('modalContact').textContent = data.contactNumber;
            document.getElementById('modalTime').textContent = data.requestTime;
            document.getElementById('modalEmergencyType').textContent = data.emergencyType;
            document.getElementById('modalStatus').textContent = data.status;

            modal.style.display = 'block';
        }

        function closeModal() {
            document.getElementById('requestModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            const modal = document.getElementById('requestModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
    @endpush
</x-app-layout>
