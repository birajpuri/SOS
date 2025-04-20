<x-app-layout>
    <x-slot name="title">Manage Drivers - Ambulance Admin</x-slot>
    <div class="header">
        <button class="menu-toggle"><i class="fas fa-bars"></i></button>
        <h1>Manage Drivers</h1>
    </div>
    <div class="table-container">
        <div class="table-header">
            <h2>Drivers List</h2>
            <button class="add-button" onclick="openModal('add')"><i class="fas fa-plus"></i> Add New</button>
        </div>
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Location</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>License Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>New York</td>
                    <td>John Doe</td>
                    <td><span class="status active">Active</span></td>
                    <td>AB12345</td>
                    <td style="display: flex;gap: 5px;">
                        <button class="btn btn-edit" onclick="openModal('edit', 'John Doe', 'New York', 'Active', 'AB12345')"><i class="fas fa-edit"></i> Edit</button>
                        <button class="btn btn-delete" onclick="confirmDelete('John Doe')"><i class="fas fa-trash"></i> Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Modal -->
    <div class="modal" id="formModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Add New Driver</h3>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <form id="driverForm">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" id="driverName" class="form-input" required>
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" id="driverLocation" class="form-input" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select id="driverStatus" class="form-select">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>License Number</label>
                    <input type="text" id="driverLicense" class="form-input" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-save">Save</button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
        
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
        function openModal(type, name = '', location = '', status = '', license = '') {
            document.getElementById('formModal').classList.add('active');
            document.getElementById('modalTitle').innerText = type === 'edit' ? 'Edit Driver' : type === 'view' ? 'Driver Details' : 'Add New Driver';
            document.getElementById('driverName').value = name;
            document.getElementById('driverLocation').value = location;
            document.getElementById('driverStatus').value = status;
            document.getElementById('driverLicense').value = license;
            if (type === 'view') {
                document.querySelectorAll('.form-input, .form-select').forEach(el => el.disabled = true);
            } else {
                document.querySelectorAll('.form-input, .form-select').forEach(el => el.disabled = false);
            }
        }
        function closeModal() {
            document.getElementById('formModal').classList.remove('active');
            document.getElementById('driverForm').reset();
        }
        function confirmDelete(name) {
            if (confirm(`Are you sure you want to delete ${name}?`)) {
                // Handle delete logic here
            }
        }
    </script>
    @endpush
</x-app-layout>