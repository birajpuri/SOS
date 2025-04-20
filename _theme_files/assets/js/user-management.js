// User Management Operations

const API_BASE_URL = '/api/admin';

// Fetch all users
async function fetchUsers(page = 1) {
    try {
        const response = await fetch(`${API_BASE_URL}/users?page=${page}`);
        const data = await response.json();
        if (response.ok) {
            renderUsersTable(data.data);
            renderPagination(data);
        } else {
            showError(data.message);
        }
    } catch (error) {
        showError('Failed to fetch users');
    }
}

// Add new user
async function addUser(userData) {
    try {
        const response = await fetch(`${API_BASE_URL}/users`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(userData)
        });
        const data = await response.json();
        if (response.ok) {
            showSuccess('User added successfully');
            closeModal();
            fetchUsers();
        } else {
            showError(data.message);
        }
    } catch (error) {
        showError('Failed to add user');
    }
}

// Update user
async function updateUser(userId, userData) {
    try {
        const response = await fetch(`${API_BASE_URL}/users/${userId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(userData)
        });
        const data = await response.json();
        if (response.ok) {
            showSuccess('User updated successfully');
            closeModal();
            fetchUsers();
        } else {
            showError(data.message);
        }
    } catch (error) {
        showError('Failed to update user');
    }
}

// Delete user
async function deleteUser(userId) {
    if (!confirm('Are you sure you want to delete this user?')) return;
    
    try {
        const response = await fetch(`${API_BASE_URL}/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json'
            }
        });
        if (response.ok) {
            showSuccess('User deleted successfully');
            fetchUsers();
        } else {
            const data = await response.json();
            showError(data.message);
        }
    } catch (error) {
        showError('Failed to delete user');
    }
}

// Render users table
function renderUsersTable(users) {
    const tbody = document.querySelector('.responsive-table tbody');
    tbody.innerHTML = users.map(user => `
        <tr>
            <td data-label="User ID">#${user.id}</td>
            <td data-label="Name">${user.name}</td>
            <td data-label="Email">${user.email}</td>
            <td data-label="Phone">${user.phone}</td>
            <td data-label="Total Bookings">${user.bookings_count || 0}</td>
            <td data-label="Status"><span class="status ${user.status?.toLowerCase() || 'active'}">${user.status || 'Active'}</span></td>
            <td data-label="Actions">
                <div class="action-buttons">
                    <button class="btn btn-view" onclick="viewUserDetails(${user.id})">
                        <i class="fas fa-eye"></i> View
                    </button>
                    <button class="btn btn-edit" onclick="openEditModal(${user.id})">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-delete" onclick="deleteUser(${user.id})">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

// Form handling
const userForm = document.getElementById('userForm');
let editingUserId = null;

userForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(userForm);
    const userData = Object.fromEntries(formData.entries());
    
    if (editingUserId) {
        await updateUser(editingUserId, userData);
    } else {
        await addUser(userData);
    }
});

// Modal handling
function openModal(isEdit = false) {
    const modal = document.getElementById('formModal');
    const modalTitle = document.getElementById('modalTitle');
    modalTitle.textContent = isEdit ? 'Edit User' : 'Add New User';
    modal.style.display = 'block';
    if (!isEdit) {
        userForm.reset();
        editingUserId = null;
    }
}

function closeModal() {
    const modal = document.getElementById('formModal');
    modal.style.display = 'none';
    userForm.reset();
    editingUserId = null;
}

// Utility functions
function showSuccess(message) {
    // Implement your success notification
    alert(message);
}

function showError(message) {
    // Implement your error notification
    alert(message);
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    fetchUsers();
});