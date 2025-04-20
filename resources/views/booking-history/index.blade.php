<x-app-layout>
  <x-slot name="title">Booking History</x-slot>
    <div class="recent-requests">
      <h2>Booking History</h2>
      <table>
        <thead>
          <tr>
            <th>Request ID</th>
            <th>Patient Name</th>
            <th>Location</th>
            <th>Assigned To.</th>
            <th>Vehicle No.</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>#12345</td>
            <td>John Doe</td>
            <td>123 Main St</td>
            <td>Mike Johnson</td>
            <td>AB-1234</td>
            <td><span class="status active">Active</span></td>
            <td>
              <button class="btn btn-view"
                onclick="openModal('12345', 'John Doe', '123 Main St', 'Mike Johnson', 'AB-1234', 'Active')">
                <i class="fas fa-eye"></i>
                View </button>
            </td>
          </tr>
          <tr>
            <td>#12344</td>
            <td>Jane Smith</td>
            <td>456 Oak Ave</td>
            <td>Sarah Wilson</td>
            <td>CD-5678</td>
            <td><span class="status pending">Pending</span></td>
            <td>
              <button class="btn btn-view"
                onclick="openModal('12344', 'Jane Smith', '456 Oak Ave', 'Sarah Wilson', 'CD-5678', 'Pending')">
                <i class="fas fa-eye"></i>
                View
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div id="bookingModal" class="modal">
      <div class="modal-header">
        <h2>Booking Details</h2>
        <span class="close-btn" onclick="closeModal()">&times;</span>
      </div>
      <div class="modal-body">
        <p><strong>Request ID:</strong> <span id="modalRequestId"></span></p>
        <p><strong>Patient Name:</strong> <span id="modalPatientName"></span></p>
        <p><strong>Location:</strong> <span id="modalLocation"></span></p>
        <p><strong>Hospital:</strong> <span id="modalHospital">Ghopa</span></p>
        <p><strong>Assigned To:</strong> <span id="modalDriver"></span></p>
        <p><strong>Vehicle No.:</strong> <span id="modalVehicle"></span></p>
        <p><strong>Status:</strong> <span id="modalStatus"></span></p>
      </div>
    </div>
  
  @push('styles')
  <style>
    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #fff;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      border-radius: 10px;
      width: 300px;
      z-index: 1001;
    }
  
    .modal.active {
      display: block !important;
    }
  
    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }
  
    .close-btn {
      cursor: pointer;
      font-size: 24px;
      transition: opacity 0.2s;
    }
  
    .close-btn:hover {
      opacity: 0.8;
    }
  
    .modal-body p {
      margin: 10px 0;
      line-height: 1.5;
    }
  </style>
  @endpush
  @push('scripts')
  {{-- <script>
    // Authentication check before anything loads
    (function () {
      const isLoggedIn = localStorage.getItem('isLoggedIn');
      if (isLoggedIn !== 'true') {
        window.location.replace('../../login.html');
        throw new Error('Not authenticated'); // Stops further JavaScript execution
      }
    })();
  </script> --}}
  
  <script>
    function openModal(requestId, patientName, location, driver, vehicle, status) {
      const overlay = document.getElementById("overlay");
      const modal = document.getElementById("bookingModal");
  
      document.getElementById("modalRequestId").textContent = requestId;
      document.getElementById("modalPatientName").textContent = patientName;
      document.getElementById("modalLocation").textContent = location;
      document.getElementById("modalDriver").textContent = driver;
      document.getElementById("modalVehicle").textContent = vehicle;
      document.getElementById("modalStatus").innerHTML = `<span class="status ${status.toLowerCase()}">${status}</span>`;
  
      modal.classList.add("active");
      overlay.classList.add("active");
    }
  
    function closeModal() {
      document.getElementById("bookingModal").classList.remove("active");
      document.getElementById("overlay").classList.remove("active");
    }
  
    // Close modal when clicking outside
    document.getElementById('overlay').addEventListener('click', closeModal);
  </script>
  @endpush
</x-app-layout>