// Driver Management Operations

const API_BASE_URL = '/api/admin';

// Fetch all drivers
async function fetchDrivers(page = 1) {
    try {
        const response = await fetch(`${API_BASE_URL}/drivers?page=${page}`);
        const data = await response.json();
        if (response.ok) {
            renderDriversTable(data.data);
            renderPagination(data);
        } else {
            showError(data.message);
        }
    } catch (error) {
        showError('Failed to fetch drivers');
    }
}

// Add new driver
async function addDriver(driverData) {
    try {
        const response = await fetch(`${API_BASE_URL}/drivers`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(driverData)
        });
        const data = await response.json();
        if (response.ok) {
            showSuccess('Driver added successfully');
            closeModal();
            fetchDrivers();
        } else {
            showError(data.message);
        }
    } catch (error) {
        showError('Failed to add driver');
    }
}

// Update driver
async function updateDriver(driverId, driverData) {
    try {
        const response = await fetch(`${API_BASE_URL}/drivers/${driverId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(driverData)
        });
        const data = await response.json();
        if (response.ok) {
            showSuccess('Driver updated successfully');
            closeModal();
            fetchDrivers();
        } else {
            showError(data.message);
        }
    } catch (error) {
        showError('Failed to update driver');
    }
}

// Delete driver
async function deleteDriver(driverId) {
    if (!confirm('Are you sure you want to delete this driver?')) return;
    
    try {
        const response = await fetch(`${API_BASE_URL}/drivers/${driverId}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json'
            }
        });
        if (response.ok) {
            showSuccess('Driver deleted successfully');
            fetchDrivers();
        } else {
            const data = await response.json();
            showError(data.message);
        }
    } catch (error) {
        showError('Failed to delete driver');
    }
}

// Render drivers table
function renderDriversTable(drivers) {
    const tbody = document.querySelector('.responsive-table tbody');
    tbody.innerHTML = drivers.map(driver => `
        <tr>
            <td data-label="Location">${driver.location || '-'}</td>
            <td data-label="Name">${driver.name}</td>
            <td data-label="Status"><span class="status ${driver.status?.toLowerCase() || 'active'}">${driver.status || 'Active'}</span></td>
            <td data-label="License Number">${driver.license_number}</td>
            <td data-label="Actions">
                <div class="action-buttons">
                    <button class="btn btn-view" onclick="viewDriverDetails(${driver.id})">
                        <i class="fas fa-eye"></i> View
                    </button>
                    <button class="btn btn-edit" onclick="openEditModal(${driver.id})">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn btn-delete" onclick="deleteDriver(${driver.id})">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

// Form handling
const driverForm = document.getElementById('driverForm');
let editingDriverId = null;

driverForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(driverForm);
    const driverData = Object.fromEntries(formData.entries());
    
    if (editingDriverId) {
        await updateDriver(editingDriverId, driverData);
    } else {
        await addDriver(driverData);
    }
});

// Modal handling
function openModal(type = 'add', driverId = null) {
    const modal = document.getElementById('formModal');
    const modalTitle = document.getElementById('modalTitle');
    modalTitle.textContent = type === 'edit' ? 'Edit Driver' : 'Add New Driver';
    modal.classList.add('active');
    
    if (type === 'edit' && driverId) {
        editingDriverId = driverId;
        fetchDriverDetails(driverId);
    } else {
        driverForm.reset();
        editingDriverId = null;
    }
}

function closeModal() {
    const modal = document.getElementById('formModal');
    modal.classList.remove('active');
    driverForm.reset();
    editingDriverId = null;
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
    fetchDrivers();
});