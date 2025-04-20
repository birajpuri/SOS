<x-app-layout>
    <x-slot name="title">Manage Vehicles - Ambulance Admin</x-slot>
    
    <div class="header">
        <button class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <h1>Manage Vehicles</h1>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h2>Vehicles List</h2>
            <button class="add-button" onclick="openModal()">
                <i class="fas fa-plus"></i> Add Vehicle
            </button>
        </div>
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Vehicle ID</th>
                    <th>Model</th>
                    <th>Plate Number</th>
                    <th>Driver</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#001</td>
                    <td>Toyota Hiace</td>
                    <td>ABC-1234</td>
                    <td>John Doe</td>
                    <td><span class="status active">Active</span></td>
                    <td>
                        
                        <button class="btn btn-edit" onclick="openModal(true)">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-delete">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="modal" id="formModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Add Vehicle</h3>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <form id="vehicleForm">
                <div class="form-group">
                    <label>Model</label>
                    <input type="text" required>
                </div>
                <div class="form-group">
                    <label>Plate Number</label>
                    <input type="text" required>
                </div>
                <div class="form-group">
                    <label>Driver</label>
                    <select required>
                        <option value="">Select Driver</option>
                        <option value="John Doe">John Doe</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
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
        function openModal(isEdit = false) {
            document.getElementById('formModal').classList.add('active');
            document.getElementById('modalTitle').textContent = isEdit ? 'Edit Vehicle' : 'Add Vehicle';
        }
        function closeModal() {
            document.getElementById('formModal').classList.remove('active');
        }
    </script>
    @endpush
</x-app-layout>