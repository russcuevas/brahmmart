<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brahmmart - Admin Accounts</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/dashboard.css') }}">
    <style>
        :root {
            --primary-rgb: 117, 39, 56;
            --accent-rgb: 255, 77, 77;
        }

        body {
            font-family: 'Outfit', sans-serif;
        }

        .admin-card {
            background: #fff;
            padding: 24px;
            border-radius: 20px;
            border: 1.5px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-color: var(--primary);
        }

        .admin-avatar {
            width: 60px;
            height: 60px;
            background: rgba(var(--primary-rgb), 0.05);
            color: var(--primary);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .admin-info h4 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }

        .admin-info p {
            margin: 4px 0 0;
            font-size: 13px;
            color: #888;
        }

        .admin-actions {
            margin-left: auto;
            display: flex;
            gap: 8px;
        }

        .action-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 14px;
        }

        .edit-btn {
            background: #f0f7ff;
            color: #007bff;
        }

        .edit-btn:hover {
            background: #007bff;
            color: #fff;
        }

        .delete-btn {
            background: #fff5f5;
            color: #ff4d4d;
        }

        .delete-btn:hover {
            background: #ff4d4d;
            color: #fff;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -48%) scale(0.96);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #eee;
            border-radius: 12px;
            font-family: inherit;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 4px rgba(var(--primary-rgb), 0.1);
        }

        /* Sidebar Clickability Fix */
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
    </style>
</head>

<body>
    <div class="admin-layout">
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <aside class="sidebar" id="sidebar">

            {{-- Brand --}}
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <img style="height: 50px; width: 50px;" src="{{ asset('logo-plain.png') }}" alt="BRAHMMART">
                </div>
                <div class="sidebar-brand-text">
                    <h2>BRAHMMART</h2>
                    <span>Admin Panel</span>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="sidebar-nav">
                <div class="sidebar-nav-label">Main Menu</div>

                <a href="{{ route('admin.dashboard.page') }}"
                    class="sidebar-nav-item {{ request()->routeIs('admin.dashboard.page') ? 'active' : '' }}"
                    id="nav-dashboard">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>


                <a href="{{ route('admin.admins.page') }}"
                    class="sidebar-nav-item {{ request()->routeIs('admin.admins.page') ? 'active' : '' }}"
                    id="nav-accounts">
                    <i class="fas fa-user-tie"></i>
                    Admins
                </a>

                <a href="{{ route('admin.students.page') }}" class="sidebar-nav-item {{ request()->routeIs('admin.students.page') ? 'active' : '' }}" id="nav-students">
                    <i class="fas fa-user-graduate"></i>
                    Students
                </a>

                <a href="{{ route('admin.scheduling.page') }}"
                    class="sidebar-nav-item {{ request()->routeIs('admin.scheduling.page') ? 'active' : '' }}"
                    id="nav-id-scheduling">
                    <i class="fas fa-id-card"></i>
                    ID Scheduling
                </a>

                <a href="{{ route('admin.inventory.page') }}"
                    class="sidebar-nav-item {{ request()->routeIs('admin.inventory.page') ? 'active' : '' }}"
                    id="nav-inventory">
                    <i class="fas fa-boxes-stacked"></i>
                    Inventory
                </a>

                <div class="sidebar-nav-label" style="margin-top: 16px;">Management</div>

                <a href="{{ route('admin.orders.page') }}"
                    class="sidebar-nav-item {{ request()->routeIs('admin.orders.page') ? 'active' : '' }}"
                    id="nav-orders">
                    <i class="fas fa-receipt"></i>
                    Orders
                </a>



            </nav>

            {{-- Sidebar Footer --}}
            <div class="sidebar-footer">
                <div class="sidebar-user"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    style="cursor: pointer;">
                    <div class="sidebar-user-avatar"><img style="height: 50px; width: 50px;"
                            src="{{ asset('favicon.png') }}" alt="">
                    </div>
                    <div class="sidebar-user-info">
                        <h4>{{ Auth::guard('admin')->user()->email }}</h4>
                        <span>Logout</span>
                    </div>
                </div>
                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <button class="mobile-menu-toggle" id="mobileMenuToggle"><i class="fas fa-bars"></i></button>
                    <div class="header-greeting">
                        <h1>Admin Accounts</h1>
                        <p>Manage administrative access</p>
                    </div>
                </div>
            </header>

            <div class="page-content">
                <button class="quick-action-btn primary-btn" style="margin-bottom: 24px;" onclick="openAddModal()">
                    <i class="fas fa-plus-circle"></i> Add New Admin
                </button>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 24px;">
                    @foreach ($admins as $admin)
                        <div class="admin-card">
                            <div class="admin-avatar">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div class="admin-info">
                                <h4>{{ $admin->email }}</h4>
                                <p>Joined {{ $admin->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="admin-actions">
                                <button class="action-btn edit-btn"
                                    onclick='openEditModal(@json($admin))'>
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete-btn" onclick="confirmDelete({{ $admin->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>

    {{-- Add Admin Modal --}}
    <div id="modalOverlay"
        style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 2000; backdrop-filter: blur(2px);"
        onclick="closeAllModals()"></div>

    <div id="addModal"
        style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2001; background: #fff; width: 95%; max-width: 450px; border-radius: 24px; box-shadow: 0 40px 100px rgba(0,0,0,0.4); overflow: hidden; animation: modalFadeIn 0.3s ease;">
        <form action="{{ route('admin.admins.store') }}" method="POST">
            @csrf
            <div
                style="padding: 24px 32px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
                <h3 style="margin: 0; color: var(--primary); font-size: 1.25rem; font-weight: 700;">Add New Admin</h3>
                <button type="button" onclick="closeAllModals()"
                    style="background: none; border: none; font-size: 24px; cursor: pointer; color: #999;">&times;</button>
            </div>
            <div style="padding: 32px;">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required class="form-input"
                        placeholder="admin@example.com">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required class="form-input"
                        placeholder="Min. 8 characters">
                </div>
            </div>
            <div style="padding: 24px 32px; border-top: 1px solid #f0f0f0; text-align: right; background: #fff;">
                <button type="button" onclick="closeAllModals()" class="quick-action-btn"
                    style="background: #f5f5f5; color: #666; border: none; height: auto; padding: 12px 24px; margin-right: 8px;">Cancel</button>
                <button type="submit" class="quick-action-btn primary-btn"
                    style="height: auto; padding: 12px 32px;">Create Account</button>
            </div>
        </form>
    </div>

    {{-- Edit Admin Modal --}}
    <div id="editModal"
        style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2001; background: #fff; width: 95%; max-width: 450px; border-radius: 24px; box-shadow: 0 40px 100px rgba(0,0,0,0.4); overflow: hidden; animation: modalFadeIn 0.3s ease;">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div
                style="padding: 24px 32px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
                <h3 style="margin: 0; color: var(--primary); font-size: 1.25rem; font-weight: 700;">Edit Admin Account
                </h3>
                <button type="button" onclick="closeAllModals()"
                    style="background: none; border: none; font-size: 24px; cursor: pointer; color: #999;">&times;</button>
            </div>
            <div style="padding: 32px;">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" id="editEmail" required class="form-input">
                </div>
                <div class="form-group">
                    <label>New Password (Optional)</label>
                    <input type="password" name="password" class="form-input"
                        placeholder="Leave blank to keep current">
                </div>
            </div>
            <div style="padding: 24px 32px; border-top: 1px solid #f0f0f0; text-align: right; background: #fff;">
                <button type="button" onclick="closeAllModals()" class="quick-action-btn"
                    style="background: #f5f5f5; color: #666; border: none; height: auto; padding: 12px 24px; margin-right: 8px;">Cancel</button>
                <button type="submit" class="quick-action-btn primary-btn"
                    style="height: auto; padding: 12px 32px;">Update Account</button>
            </div>
        </form>
    </div>

    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        // ===== MOBILE MENU TOGGLE =====
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('mobileMenuToggle');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (menuToggle) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
            });
        }

        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024) closeSidebar();
        });

        function openAddModal() {
            document.getElementById('addModal').style.display = 'block';
            document.getElementById('modalOverlay').style.display = 'block';
        }

        function openEditModal(admin) {
            document.getElementById('editForm').action = `/admin/accounts/${admin.id}`;
            document.getElementById('editEmail').value = admin.email;
            document.getElementById('editModal').style.display = 'block';
            document.getElementById('modalOverlay').style.display = 'block';
        }

        function closeAllModals() {
            document.getElementById('addModal').style.display = 'none';
            document.getElementById('editModal').style.display = 'none';
            document.getElementById('modalOverlay').style.display = 'none';
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This admin will lose all access!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#752738',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = `/admin/accounts/${id}`;
                    form.submit();
                }
            });
        }

        @if (session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if (session('error'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ $errors->first() }}"
            });
        @endif
    </script>
</body>

</html>
