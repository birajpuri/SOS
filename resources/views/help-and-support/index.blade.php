<x-app-layout>
    <x-slot name="title">Help & Support - Ambulance Admin</x-slot>
    <div class="header">
        <button class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <h1>Help & Support</h1>
        <input type="search" placeholder="Search tickets..." class="search-bar">
    </div>

    <div class="support-grid">
        <div class="support-card">
            <h3><i class="fas fa-ticket-alt"></i> Support Tickets</h3>
            <div class="table-container">
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#TK001</td>
                            <td>App not working</td>
                            <td><span class="ticket-status status-new">New</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary">View</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#TK002</td>
                            <td>Payment issue</td>
                            <td><span class="ticket-status status-open">Open</span></td>
                            <td>
                                <button class="btn btn-sm btn-primary">View</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="support-card">
            <h3><i class="fas fa-chart-bar"></i> Support Statistics</h3>
            <div>
                <p>New Tickets: 5</p>
                <p>Open Tickets: 12</p>
                <p>Closed Today: 8</p>
                <p>Average Response Time: 2.5 hours</p>
            </div>
        </div>
    </div>

    <div class="faq-section">
        <h3>Manage FAQs</h3>
        <button class="add-button" onclick="openFaqModal()">
            <i class="fas fa-plus"></i> Add FAQ
        </button>


        <div class="faq-item">
            <div class="faq-question">
                <span>What payment methods are accepted?</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                We accept all major credit cards, debit cards, and digital wallets. Cash payments are also accepted
                after service completion.
                <div class="action-buttons">
                    <button class="btn btn-sm btn-edit">Edit</button>
                    <button class="btn btn-sm btn-delete">Delete</button>
                </div>
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>What is the cancellation policy?</span>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                Cancellations made within 5 minutes of booking are free. After that, a small fee may apply depending
                on the circumstances.
                <div class="action-buttons">
                    <button class="btn btn-sm btn-edit">Edit</button>
                    <button class="btn btn-sm btn-delete">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Modal -->
    <div class="modal" id="faqModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="faqModalTitle">Add New FAQ</h3>
                <button class="close-modal" onclick="closeFaqModal()">&times;</button>
            </div>
            <form id="faqForm">
                <div class="form-group">
                    <label class="form-label">Question</label>
                    <input type="text" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Answer</label>
                    <textarea class="form-input" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select class="form-select">
                        <option value="general">General</option>
                        <option value="booking">Booking</option>
                        <option value="payment">Payment</option>
                        <option value="technical">Technical</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Display Order</label>
                    <input type="number" class="form-input" min="1">
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-cancel" onclick="closeFaqModal()">Cancel</button>
                    <button type="submit" class="btn btn-save">Save FAQ</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Ticket View Modal -->
    <div class="modal" id="ticketModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Ticket Details</h3>
                <button class="close-modal" onclick="closeTicketModal()">&times;</button>
            </div>
            <div class="ticket-details">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-select">
                        <option value="new">New</option>
                        <option value="open">Open</option>
                        <option value="pending">Pending</option>
                        <option value="resolved">Resolved</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Reply</label>
                    <textarea class="form-input" rows="4"></textarea>
                </div>
                <div class="form-actions">
                    <button class="btn btn-save">Send Reply</button>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .support-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .support-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .support-card h3 {
            margin-top: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .faq-section {
            background: white;
            border-radius: 8px;
            margin: 20px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .faq-item {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }

        .faq-item:last-child {
            border-bottom: none;
        }

        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-weight: 500;
        }

        .faq-answer {
            display: none;
            padding: 10px 0;
            color: #666;
        }

        .faq-answer.active {
            display: block;
        }

        .ticket-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85em;
        }

        .status-new {
            background: #E3F2FD;
            color: #1976D2;
        }

        .status-open {
            background: #E8F5E9;
            color: #388E3C;
        }

        .status-closed {
            background: #FFEBEE;
            color: #D32F2F;
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

        // FAQ functionality
        const faqQuestions = document.querySelectorAll('.faq-question');
        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                const icon = question.querySelector('i');
                answer.classList.toggle('active');
                icon.classList.toggle('fa-chevron-up');
                icon.classList.toggle('fa-chevron-down');
            });
        });

        // Modal functionality
        const faqModal = document.getElementById('faqModal');
        const ticketModal = document.getElementById('ticketModal');

        function openFaqModal() {
            faqModal.classList.add('active');
        }

        function closeFaqModal() {
            faqModal.classList.remove('active');
            document.getElementById('faqForm').reset();
        }

        function openTicketModal() {
            ticketModal.classList.add('active');
        }

        function closeTicketModal() {
            ticketModal.classList.remove('active');
        }

        // Form submissions
        document.getElementById('faqForm').addEventListener('submit', (e) => {
            e.preventDefault();
            // Handle FAQ form submission
            closeFaqModal();
        });

        // Delete confirmations
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', () => {
                if (confirm('Are you sure you want to delete this item?')) {
                    // Handle delete action
                }
            });
        });

        // Window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024) {
                sidebar.classList.remove('expanded');
                overlay.classList.remove('active');
            }
        });
    </script>
    @endpush
</x-app-layout>
