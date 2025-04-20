<x-app-layout>
    <x-slot name="title">Manage Users - Ambulance Admin</x-slot>
    <div class="header">
        <button class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <h1>Manage Users</h1>
        <input type="search" name="search" placeholder="Search..." class="search-bar">
    </div>

    <div class="table-container">
        <div class="table-header">
            <h2>Users List</h2>
            {{-- <button class="add-button" onclick="openModal()">
                <i class="fas fa-plus"></i> Add New User
            </button> --}}
        </div>
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Total Bookings</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user )

                <tr>
                    <td data-label="User ID">{{$user->id}}</td>
                    <td data-label="Name">{{$user->name}}</td>
                    <td data-label="Email">{{$user->email}}</td>
                    <td data-label="Phone">{{$user->phone}}</td>
                    <td data-label="Total Bookings">5</td>
                    <td data-label="Status"><span class="status active">{{$user->status}}</span></td>
                    <td data-label="Actions">
                        <div class="action-buttons">
                            {{-- <a href="{{route('user.show', $id = $user->id)}}">
                                <button class="btn btn-view" >
                                    <i class="fas fa-eye"></i> View
                                </button>
                            </a> --}}
                            <a href="{{route('user.edit', $id = $user->id)}}">

                                <button class="btn btn-edit" >
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </a>
                            <a href="{{route('user.destroy', $id = $user->id)}}">

                                <button class="btn btn-delete">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- User Form Modal -->
    {{-- <div class="modal" id="formModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Add New User</h3>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <form id="userForm" action="{{route('user.update',$id = $user->id)}}" method="POST">
                @csrf
                @method('put')
                <div class="form-group">
                    <label class="form-label">User ID</label>
                    <input type="text" name="id" class="form-input" placeholder="Auto-generated" disabled>
                </div>
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-input" value="{{$user->name}}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" value="{{$user->email}}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" name="phone" class="form-input" value="{{$user->phone}}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Address</label>
                    <input type="address" name="address" class="form-input" {{$user->address}} required>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="active">Active</option>
                        <option value="blocked">Blocked</option>
                        <option value="pending">Pending Verification</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-save">Save</button>
                </div>
            </form>
        </div>
    </div> --}}

    <!-- User Details Modal -->
    <div class="modal" id="userDetailsModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>User Details</h3>
                <button class="close-modal" onclick="closeUserDetails()">&times;</button>
            </div>
            <div class="user-details">
                <div class="detail-group">
                    <label>Booking History</label>
                    <div class="booking-list">
                        <!-- Booking history will be populated dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')

    @endpush

    @push('scripts')
    <script>
        // Authentication check before anything loads
        // (function() {
        //     const isLoggedIn = localStorage.getItem('isLoggedIn');
        //     if (isLoggedIn !== 'true') {
        //         window.location.replace('../../login.html');
        //         throw new Error('Not authenticated'); // Stops further JavaScript execution
        //     }
        // })();
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
        const mainContent = document.querySelector('.main-content');
        const overlay = document.querySelector('.overlay');
        const navItems = document.querySelectorAll('.nav-item');

        function toggleSidebar() {
            sidebar.classList.toggle('expanded');
            overlay.classList.toggle('active');
        }

        menuToggle.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        // Modal functionality
        const modal = document.getElementById('formModal');
        const userDetailsModal = document.getElementById('userDetailsModal');
        const modalTitle = document.getElementById('modalTitle');
        const form = document.getElementById('userForm');

        function openModal(isEdit = false) {
            modal.classList.add('active');
            modalTitle.textContent = isEdit ? 'Edit User' : 'Add New User';
            if (isEdit) {
                // Populate form with existing data
            }
        }

        function closeModal() {
            modal.classList.remove('active');
            form.reset();
        }

        function viewUserDetails(userId) {
            userDetailsModal.classList.add('active');
            // Fetch and display user details
        }

        function closeUserDetails() {
            userDetailsModal.classList.remove('active');
        }

        // Form submission
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            // Handle form submission
            closeModal();
        });

        // Delete confirmation
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', () => {
                if (confirm('Are you sure you want to delete this user?')) {
                    // Handle delete action
                }
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
