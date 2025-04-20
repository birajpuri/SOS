<x-app-layout>
    <x-slot name="title">Hospital Management</x-slot>
    <div class="header">
        <h1>Hospital Management</h1>
        <button class="btn btn-primary" onclick="openModal('addHospitalModal')">
            <i class="fas fa-plus"></i> Add New Hospital
        </button>
    </div>

    <div class="card-container">
        <div class="card" onclick="openModal('addHospitalModal')">
            <i class="fas fa-hospital"></i>
            <h3>Add Hospital</h3>
            <p>Register a new hospital in the system</p>
        </div>
        <div class="card" onclick="openModal('uploadReportModal')">
            <i class="fas fa-file-medical"></i>
            <h3>Upload Medical Report</h3>
            <p>Upload and manage medical reports</p>
        </div>
    </div>

    <div class="table-container">
        <h2>Recent Medical Reports</h2>
        <table>
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Hospital</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>John Doe</td>
                    <td>City Hospital</td>
                    <td>Dr. Smith</td>
                    <td>2024-02-22</td>
                    <td>
                        <button class="btn btn-secondary">View</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Add Hospital Modal -->
    <div id="addHospitalModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('addHospitalModal')">&times;</span>
            <h2>Add New Hospital</h2>
            <form>
                <div class="form-group">
                    <label>Hospital Name</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="tel" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Hospital</button>
            </form>
        </div>
    </div>

    <!-- Upload Report Modal -->
    <div id="uploadReportModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('uploadReportModal')">&times;</span>
            <h2>Upload Medical Report</h2>
            <form>
                <div class="form-group">
                    <label>Select Patient</label>
                    <select class="form-control" required>
                        <option value="">Choose Patient</option>
                        <option value="1">John Doe</option>
                        <option value="2">Jane Smith</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Select Hospital</label>
                    <select class="form-control" required>
                        <option value="">Choose Hospital</option>
                        <option value="1">City Hospital</option>
                        <option value="2">General Hospital</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Doctor Name</label>
                    <input type="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Upload Report</label>
                    <div class="file-upload">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Drag and drop files here or click to browse</p>
                        <input type="file" style="display: none" id="fileInput">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Upload Report</button>
            </form>
        </div>
    </div>
    @push('styles')
    <style>
        /* Core styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        /* Navigation styles */






        /* Card styles */
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card i {
            font-size: 2em;
            color: #3498db;
            margin-bottom: 15px;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 8px;
            position: relative;
        }

        .close-modal {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 24px;
            cursor: pointer;
        }

        /* Form styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
            font-weight: bold;
        }

        .btn-primary {
            background: #3498db;
        }

        .btn-secondary {
            background: #95a5a6;
        }

        .file-upload {
            border: 2px dashed #ddd;
            padding: 20px;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
        }

        .file-upload i {
            font-size: 2em;
            color: #95a5a6;
            margin-bottom: 10px;
        }

        /* Table styles */
        .table-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #f8f9fa;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Authentication check before anything loads
        (function () {
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
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }

        // File upload handling
        document.querySelector('.file-upload').addEventListener('click', function () {
            document.getElementById('fileInput').click();
        });

        document.getElementById('fileInput').addEventListener('change', function (e) {
            const fileName = e.target.files[0].name;
            const fileUploadText = document.querySelector('.file-upload p');
            fileUploadText.textContent = `Selected file: ${fileName}`;
        });
    </script>
    @endpush
</x-app-layout>
