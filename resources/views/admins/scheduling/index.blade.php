<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Scheduling Management | Brahmmart</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .sidebar {
            z-index: 1001 !important;
            position: fixed;
            pointer-events: auto !important;
        }

        .main-content {
            z-index: 1;
            position: relative;
        }

        .sidebar-overlay {
            z-index: 1000;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-badge.pending {
            background: #fff8e1;
            color: #ffc107;
        }

        .status-badge.approved {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-badge.rejected {
            background: #fee2e2;
            color: #b91c1c;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .btn-action {
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-view {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-approve {
            background: #752738;
            color: #fff;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            z-index: 2000;
            display: none;
        }

        .modal-overlay.active {
            display: block;
        }

        .custom-modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2001;
            background: #fff;
            width: 90%;
            max-width: 600px;
            border-radius: 24px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.2);
            display: none;
            overflow: hidden;
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translate(-50%, -48%) scale(0.95); }
            to { opacity: 1; transform: translate(-50%, -50%) scale(1); }
        }

        .custom-modal.active {
            display: block;
        }

        .modal-header {
            padding: 24px 32px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 32px;
            max-height: 70vh;
            overflow-y: auto;
        }

        .modal-footer {
            padding: 20px 32px;
            border-top: 1px solid #f0f0f0;
            text-align: right;
            background: #fafafa;
        }

        .image-preview-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .preview-box {
            background: #f8fafc;
            padding: 16px;
            border-radius: 16px;
            text-align: center;
        }

        .preview-box img {
            max-width: 100%;
            height: 150px;
            object-fit: contain;
            border-radius: 8px;
            margin-top: 8px;
            cursor: pointer;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
    </style>
</head>

<body>
    <div class="admin-layout">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <img style="height: 50px; width: 50px;" src="{{ asset('logo-plain.png') }}" alt="BRAHMMART">
                </div>
                <div class="sidebar-brand-text">
                    <h2>BRAHMMART</h2>
                    <span>Admin Panel</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="sidebar-nav-label">Main Menu</div>
                <a href="{{ route('admin.dashboard.page') }}" class="sidebar-nav-item" id="nav-dashboard">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="{{ route('admin.admins.page') }}" class="sidebar-nav-item" id="nav-accounts">
                    <i class="fas fa-user-tie"></i> Admins
                </a>
                <a href="{{ route('admin.students.page') }}" class="sidebar-nav-item" id="nav-students">
                    <i class="fas fa-user-graduate"></i> Students
                </a>
                <a href="{{ route('admin.scheduling.page') }}" class="sidebar-nav-item active" id="nav-id-scheduling">
                    <i class="fas fa-id-card"></i> ID Scheduling
                </a>
                <a href="{{ route('admin.inventory.page') }}" class="sidebar-nav-item" id="nav-inventory">
                    <i class="fas fa-boxes-stacked"></i> Inventory
                </a>
                <div class="sidebar-nav-label" style="margin-top: 16px;">Management</div>
                <a href="{{ route('admin.orders.page') }}" class="sidebar-nav-item" id="nav-orders">
                    <i class="fas fa-receipt"></i> Orders
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="cursor: pointer;">
                    <div class="sidebar-user-avatar"><img style="height: 50px; width: 50px;" src="{{ asset('favicon.png') }}" alt=""></div>
                    <div class="sidebar-user-info">
                        <h4>{{ Auth::guard('admin')->user()->email }}</h4>
                        <span>Logout</span>
                    </div>
                </div>
                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">@csrf</form>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <button class="mobile-menu-toggle" id="mobileMenuToggle"><i class="fas fa-bars"></i></button>
                    <div class="header-greeting">
                        <h1>ID Scheduling</h1>
                        <p>Manage student identity applications</p>
                    </div>
                </div>
            </header>

            <div class="page-content">
                <div class="content-card">
                    <div class="card-header" style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center;">
                        <h3 style="margin: 0;">Identity Requests</h3>
                        <span class="badge" style="background: #752738; color: #fff; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                            Total: {{ $schedulings->count() }}
                        </span>
                    </div>

                    <div class="orders-table-wrap" style="overflow-x: auto;">
                        <table class="orders-table" style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="text-align: left; border-bottom: 2px solid #f0f0f0;">
                                    <th style="padding: 16px; color: #888; font-size: 13px;">Student</th>
                                    <th style="padding: 16px; color: #888; font-size: 13px;">Student No.</th>
                                    <th style="padding: 16px; color: #888; font-size: 13px;">Status</th>
                                    <th style="padding: 16px; color: #888; font-size: 13px;">Pickup Date</th>
                                    <th style="padding: 16px; color: #888; font-size: 13px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedulings as $scheduling)
                                    <tr style="border-bottom: 1px solid #f5f5f5;">
                                        <td style="padding: 16px;">
                                            <div style="display: flex; align-items: center; gap: 12px;">
                                                <img src="{{ asset('assets/images/id/pictures/' . $scheduling->picture_id) }}" style="width: 40px; height: 40px; border-radius: 10px; object-fit: cover; background: #eee;" alt="">
                                                <div>
                                                    <div style="font-weight: 700; color: #333;">{{ $scheduling->customer->fullname }}</div>
                                                    <div style="font-size: 12px; color: #888;">{{ $scheduling->customer->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 16px; font-weight: 600; color: #555;">{{ $scheduling->student_no }}</td>
                                        <td style="padding: 16px;">
                                            <span class="status-badge {{ strtolower($scheduling->status) }}">
                                                <span class="status-dot"></span>
                                                {{ $scheduling->status }}
                                            </span>
                                        </td>
                                        <td style="padding: 16px;">
                                            @if($scheduling->pick_up_date)
                                                <div style="font-size: 13px; color: #2e7d32; font-weight: 600;">
                                                    <i class="fas fa-calendar-check" style="margin-right: 4px;"></i>
                                                    {{ date('M d, Y h:i A', strtotime($scheduling->pick_up_date)) }}
                                                </div>
                                            @else
                                                <span style="color: #ccc; font-style: italic; font-size: 13px;">Not set</span>
                                            @endif
                                        </td>
                                        <td style="padding: 16px;">
                                            <div style="display: flex; gap: 8px;">
                                                <button class="btn-action btn-view" onclick='openPreviewModal(@json($scheduling))'>
                                                    <i class="fas fa-eye"></i> View
                                                </button>
                                                @if($scheduling->status == 'Pending')
                                                    <button class="btn-action btn-approve" onclick='openApproveModal(@json($scheduling))'>
                                                        <i class="fas fa-calendar-plus"></i> Schedule
                                                    </button>
                                                    <button class="btn-action" style="background: #ef4444; color: #fff;" onclick='handleReject({{ $scheduling->id }})'>
                                                        <i class="fas fa-times-circle"></i> Cancel
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 60px; color: #888;">
                                            <i class="fas fa-id-card" style="font-size: 48px; opacity: 0.1; display: block; margin-bottom: 16px;"></i>
                                            No requests yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Preview Modal -->
    <div class="modal-overlay" id="previewOverlay" onclick="closeModals()"></div>
    <div class="custom-modal" id="previewModal">
        <div class="modal-header">
            <h3>Student Application Details</h3>
            <button onclick="closeModals()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #ccc;">&times;</button>
        </div>
        <div class="modal-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                <div>
                    <label style="color: #999; font-size: 11px; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 4px;">School Year</label>
                    <div id="view-sy" style="font-weight: 600; color: #333;"></div>
                </div>
                <div>
                    <label style="color: #999; font-size: 11px; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 4px;">Guardian Name</label>
                    <div id="view-guardian" style="font-weight: 600; color: #333;"></div>
                </div>
                <div>
                    <label style="color: #999; font-size: 11px; text-transform: uppercase; font-weight: 700; display: block; margin-bottom: 4px;">Guardian Contact</label>
                    <div id="view-contact" style="font-weight: 600; color: #333;"></div>
                </div>
            </div>

            <div class="image-preview-group">
                <div class="preview-box">
                    <p style="font-size: 11px; font-weight: 700; color: #752738; text-transform: uppercase; margin-bottom: 8px;">2x2 Formal Photo</p>
                    <img id="view-pic" src="" alt="" onclick="window.open(this.src)">
                </div>
                <div class="preview-box">
                    <p style="font-size: 11px; font-weight: 700; color: #752738; text-transform: uppercase; margin-bottom: 8px;">E-Signature</p>
                    <img id="view-sig" src="" alt="" onclick="window.open(this.src)">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-action btn-view" onclick="closeModals()">Close</button>
        </div>
    </div>

    <!-- Approve Modal -->
    <div class="modal-overlay" id="approveOverlay" onclick="closeModals()"></div>
    <div class="custom-modal" id="approveModal" style="max-width: 450px;">
        <form id="approveForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h3>Set Pickup Schedule</h3>
                <button type="button" onclick="closeModals()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #ccc;">&times;</button>
            </div>
            <div class="modal-body">
                <div style="margin-bottom: 24px; background: #fff8e1; border-left: 4px solid #ffc107; padding: 16px; border-radius: 8px;">
                    <p style="margin: 0; font-size: 13px; color: #856404; line-height: 1.5;">
                        <i class="fas fa-info-circle"></i> This will mark the application as <strong>Approved</strong> and notify the student via email.
                    </p>
                </div>
                <div class="form-group">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Pickup Date & Time</label>
                    <input type="datetime-local" name="pick_up_date" class="form-control" required style="width: 100%; padding: 12px; border: 1.5px solid #eee; border-radius: 12px; font-family: inherit;">
                </div>
                <input type="hidden" name="status" value="Approved">
            </div>
            <div class="modal-footer" style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" class="btn-action btn-view" onclick="closeModals()">Cancel</button>
                <button type="submit" class="btn-action btn-approve">
                    <i class="fas fa-paper-plane"></i> Approve & Notify
                </button>
            </div>
        </form>
    </div>

    <script>
        // Sidebar logic
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('mobileMenuToggle');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }

        menuToggle.addEventListener('click', openSidebar);
        overlay.addEventListener('click', closeSidebar);

        function openPreviewModal(data) {
            document.getElementById('view-sy').textContent = data.school_year;
            document.getElementById('view-guardian').textContent = data.guardian_name;
            document.getElementById('view-contact').textContent = data.guardian_contact_no;
            document.getElementById('view-pic').src = '/assets/images/id/pictures/' + data.picture_id;
            document.getElementById('view-sig').src = '/assets/images/id/signatures/' + data.e_signature;
            
            document.getElementById('previewOverlay').classList.add('active');
            document.getElementById('previewModal').classList.add('active');
        }

        function openApproveModal(data) {
            const form = document.getElementById('approveForm');
            form.action = '/admin/scheduling/' + data.id;
            document.getElementById('approveOverlay').classList.add('active');
            document.getElementById('approveModal').classList.add('active');
        }

        function handleReject(id) {
            Swal.fire({
                title: 'Cancel ID Request',
                text: "Please provide a reason for cancelling this request:",
                input: 'textarea',
                inputPlaceholder: 'Reason for cancellation (e.g., Blur picture, Wrong background color...)',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Confirm Cancellation',
                inputAttributes: {
                    'required': 'true'
                },
                validationMessage: 'You must provide a reason.'
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    Swal.fire({
                        title: 'Sending Notification...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`/admin/scheduling/${id}/reject`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ reason: result.value })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Cancelled!',
                                text: data.message,
                                confirmButtonColor: '#752738'
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error', 'Something went wrong while sending notification.', 'error');
                    });
                }
            });
        }

        function closeModals() {
            document.querySelectorAll('.modal-overlay, .custom-modal').forEach(el => el.classList.remove('active'));
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session("success") }}',
                confirmButtonColor: '#752738'
            });
        @endif
    </script>
</body>
</html>
