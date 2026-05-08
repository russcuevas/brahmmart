<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brahmmart</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/customers/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="admin-layout"> {{-- Using same class as admin for layout consistency --}}

        {{-- ===== SIDEBAR OVERLAY (Mobile) ===== --}}
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        {{-- ===== SIDEBAR ===== --}}
        <aside class="sidebar" id="sidebar">

            {{-- Brand --}}
            <div class="sidebar-brand">
                <div class="sidebar-brand-icon">
                    <img style="height: 50px; width: 50px;" src="{{ asset('logo-plain.png') }}" alt="BRAHMMART">
                </div>
                <div class="sidebar-brand-text">
                    <h2>BRAHMMART</h2>
                    <span>Student Panel</span>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="sidebar-nav">
                <div class="sidebar-nav-label">Main Menu</div>

                <a href="#" class="sidebar-nav-item active" id="nav-dashboard">
                    <i class="fas fa-home"></i>
                    Dashboard
                </a>

                <a href="#" class="sidebar-nav-item" id="nav-orders">
                    <i class="fas fa-receipt"></i>
                    My Orders
                    <span class="nav-badge">2</span>
                </a>

                <a href="#" class="sidebar-nav-item" id="nav-id-scheduling">
                    <i class="fas fa-id-card"></i>
                    ID Scheduling
                </a>

                <div class="sidebar-nav-label" style="margin-top: 16px;">Quick Links</div>

                <a href="{{ route('shop.page') }}" class="sidebar-nav-item">
                    <i class="fas fa-shop"></i>
                    Shop
                </a>

                <a href="/" class="sidebar-nav-item">
                    <i class="fas fa-house"></i>
                    Home
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
                        <h4>{{ Auth::guard('customer')->user()->email }}</h4>
                        <span>Logout</span>
                    </div>
                </div>
                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </aside>

        {{-- ===== MAIN CONTENT ===== --}}
        <main class="main-content">

            {{-- Top Header --}}
            <header class="top-header">
                <div class="header-left">
                    <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle sidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="header-greeting">
                        <h1>Dashboard</h1>
                        <p id="greetingText">Welcome back, {{ Auth::guard('customer')->user()->fullname }}</p>
                    </div>
                </div>
                <div class="header-right">
                    <button class="header-icon-btn" id="notifBtn" aria-label="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notif-dot"></span>
                    </button>
                    <button class="header-icon-btn" id="settingsBtn" aria-label="Profile">
                        <i class="fas fa-user"></i>
                    </button>
                </div>
            </header>

            {{-- Page Content --}}
            <div class="page-content">

                {{-- Stats Grid --}}
                <div class="stats-grid">
                    {{-- Card 1 — Active Orders --}}
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-card-icon primary">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">02</div>
                        <div class="stat-card-label">Active Orders</div>
                    </div>

                    {{-- Card 2 — Total Spent --}}
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-card-icon secondary">
                                <i class="fas fa-peso-sign"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">₱1,850</div>
                        <div class="stat-card-label">Total Spent</div>
                    </div>

                    {{-- Card 3 — ID Status --}}
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-card-icon success">
                                <i class="fas fa-id-card-clip"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">Pending</div>
                        <div class="stat-card-label">ID Status</div>
                    </div>

                    {{-- Card 4 — Wishlist --}}
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-card-icon info">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">05</div>
                        <div class="stat-card-label">Wishlist Items</div>
                    </div>
                </div>

                {{-- Recent Orders Table --}}
                <div class="content-card">
                    <div class="card-header">
                        <h3>My Recent Orders</h3>
                        <div class="card-header-actions">
                            <a href="#" class="card-tab-btn active">View All</a>
                        </div>
                    </div>
                    <div class="orders-table-wrap">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="order-id">#ORD-1024</span></td>
                                    <td>PE Uniform Set</td>
                                    <td>₱1,850.00</td>
                                    <td><span class="status-badge processing"><span class="status-dot"></span>
                                            Processing</span></td>
                                    <td>May 7, 2026</td>
                                    <td><button class="card-tab-btn">View Details</button></td>
                                </tr>
                                <tr>
                                    <td><span class="order-id">#ORD-1023</span></td>
                                    <td>School Polo (L)</td>
                                    <td>₱650.00</td>
                                    <td><span class="status-badge completed"><span class="status-dot"></span>
                                            Completed</span></td>
                                    <td>May 6, 2026</td>
                                    <td><button class="card-tab-btn">View Details</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        // ===== SIDEBAR TOGGLE (Mobile) =====
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

        menuToggle.addEventListener('click', () => {
            sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
        });

        overlay.addEventListener('click', closeSidebar);

        // Close sidebar on resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024) closeSidebar();
        });

        // ===== DYNAMIC GREETING =====
        const greetingEl = document.getElementById('greetingText');
        const hour = new Date().getHours();
        let greeting = 'Good evening';
        if (hour < 12) greeting = 'Good morning';
        else if (hour < 18) greeting = 'Good afternoon';
        greetingEl.textContent = `${greeting}, {{ Auth::guard('customer')->user()->fullname }}`;

        // ===== TOAST NOTIFICATIONS =====
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif
    </script>
</body>

</html>
