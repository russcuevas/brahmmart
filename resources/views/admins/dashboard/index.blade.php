<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brahmmart</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/dashboard.css') }}">
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
    </style>
</head>

<body>
    <div class="admin-layout">

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

                <a href="{{ route('admin.students.page') }}"
                    class="sidebar-nav-item {{ request()->routeIs('admin.students.page') ? 'active' : '' }}"
                    id="nav-students">
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
                        <p id="greetingText">Welcome back, Admin</p>
                    </div>
                </div>

            </header>

            {{-- Page Content --}}
            <div class="page-content">

                {{-- Stats Grid --}}
                <div class="stats-grid">
                    {{-- Card 1 — Revenue --}}
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-card-icon primary">
                                <i class="fas fa-peso-sign"></i>
                            </div>
                            <div class="stat-card-trend up">
                                <i class="fas fa-arrow-up"></i> 12.5%
                            </div>
                        </div>
                        <div class="stat-card-value">₱48,250</div>
                        <div class="stat-card-label">Total Revenue</div>
                    </div>

                    {{-- Card 2 — Orders --}}
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-card-icon secondary">
                                <i class="fas fa-shopping-bag"></i>
                            </div>
                            <div class="stat-card-trend up">
                                <i class="fas fa-arrow-up"></i> 8.3%
                            </div>
                        </div>
                        <div class="stat-card-value">324</div>
                        <div class="stat-card-label">Total Orders</div>
                    </div>

                    {{-- Card 3 — Customers --}}
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-card-icon success">
                                <i class="fas fa-user-group"></i>
                            </div>
                            <div class="stat-card-trend up">
                                <i class="fas fa-arrow-up"></i> 5.2%
                            </div>
                        </div>
                        <div class="stat-card-value">1,248</div>
                        <div class="stat-card-label">Active Customers</div>
                    </div>

                    {{-- Card 4 — Products --}}
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-card-icon info">
                                <i class="fas fa-boxes-stacked"></i>
                            </div>
                            <div class="stat-card-trend down">
                                <i class="fas fa-arrow-down"></i> 2.1%
                            </div>
                        </div>
                        <div class="stat-card-value">156</div>
                        <div class="stat-card-label">Products in Stock</div>
                    </div>
                </div>

                {{-- Content Grid — Chart + Activity --}}
                <div class="content-grid">
                    {{-- Sales Chart --}}
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Sales Overview</h3>
                            <div class="card-header-actions">
                                <button class="card-tab-btn active" data-range="week">Weekly</button>
                                <button class="card-tab-btn" data-range="month">Monthly</button>
                                <button class="card-tab-btn" data-range="year">Yearly</button>
                            </div>
                        </div>
                        <div class="chart-area" id="chartArea">
                            {{-- Chart bars rendered by JS --}}
                        </div>
                    </div>

                    {{-- Recent Activity --}}
                    <div class="content-card">
                        <div class="card-header">
                            <h3>Recent Activity</h3>
                            <div class="card-header-actions">
                                <button class="card-tab-btn active">All</button>
                            </div>
                        </div>
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-icon sale">
                                    <i class="fas fa-cart-shopping"></i>
                                </div>
                                <div class="activity-info">
                                    <h4>New Order #1024</h4>
                                    <p>Maria Santos placed an order</p>
                                </div>
                                <span class="activity-time">2 min ago</span>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon user">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="activity-info">
                                    <h4>New Account Registered</h4>
                                    <p>John Dela Cruz — BSIT 3A</p>
                                </div>
                                <span class="activity-time">15 min ago</span>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon stock">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <div class="activity-info">
                                    <h4>Stock Updated</h4>
                                    <p>PE Uniform — +50 units added</p>
                                </div>
                                <span class="activity-time">1 hr ago</span>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon alert">
                                    <i class="fas fa-triangle-exclamation"></i>
                                </div>
                                <div class="activity-info">
                                    <h4>Low Stock Alert</h4>
                                    <p>Criminology Polo — 3 left</p>
                                </div>
                                <span class="activity-time">3 hr ago</span>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon sale">
                                    <i class="fas fa-peso-sign"></i>
                                </div>
                                <div class="activity-info">
                                    <h4>Payment Received</h4>
                                    <p>₱2,450.00 from Ana Reyes</p>
                                </div>
                                <span class="activity-time">5 hr ago</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Recent Orders Table --}}
                <div class="content-card">
                    <div class="card-header">
                        <h3>Recent Orders</h3>
                        <div class="card-header-actions">
                            <button class="card-tab-btn active">All</button>
                            <button class="card-tab-btn">Pending</button>
                            <button class="card-tab-btn">Completed</button>
                        </div>
                    </div>
                    <div class="orders-table-wrap">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Order ID</th>
                                    <th>Product</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="order-customer">
                                            <div class="order-avatar av-1"><img style="height: 50px; width: 50px;"
                                                    src="{{ asset('favicon.png') }}" alt=""></div> &nbsp;
                                            <span class="order-customer-name">Maria Santos <br>
                                                <small>2420650</small></span>
                                        </div>
                                    </td>
                                    <td><span class="order-id">#ORD-1024</span></td>
                                    <td>PE Uniform Set</td>
                                    <td>₱1,850.00</td>
                                    <td><span class="status-badge completed"><span class="status-dot"></span>
                                            Completed</span></td>
                                    <td>May 7, 2026</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="order-customer">
                                            <div class="order-avatar av-2">JD</div>
                                            <span class="order-customer-name">John Dela Cruz</span>
                                        </div>
                                    </td>
                                    <td><span class="order-id">#ORD-1023</span></td>
                                    <td>School Polo (L)</td>
                                    <td>₱650.00</td>
                                    <td><span class="status-badge pending"><span class="status-dot"></span>
                                            Pending</span></td>
                                    <td>May 6, 2026</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="order-customer">
                                            <div class="order-avatar av-3">AR</div>
                                            <span class="order-customer-name">Ana Reyes</span>
                                        </div>
                                    </td>
                                    <td><span class="order-id">#ORD-1022</span></td>
                                    <td>Crim Uniform Complete</td>
                                    <td>₱2,450.00</td>
                                    <td><span class="status-badge completed"><span class="status-dot"></span>
                                            Completed</span></td>
                                    <td>May 6, 2026</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="order-customer">
                                            <div class="order-avatar av-4">RG</div>
                                            <span class="order-customer-name">Rico Garcia</span>
                                        </div>
                                    </td>
                                    <td><span class="order-id">#ORD-1021</span></td>
                                    <td>ID Lace + Holder</td>
                                    <td>₱180.00</td>
                                    <td><span class="status-badge processing"><span class="status-dot"></span>
                                            Processing</span></td>
                                    <td>May 5, 2026</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="order-customer">
                                            <div class="order-avatar av-5">LC</div>
                                            <span class="order-customer-name">Lara Cruz</span>
                                        </div>
                                    </td>
                                    <td><span class="order-id">#ORD-1020</span></td>
                                    <td>Nursing Uniform (M)</td>
                                    <td>₱1,200.00</td>
                                    <td><span class="status-badge cancelled"><span class="status-dot"></span>
                                            Cancelled</span></td>
                                    <td>May 5, 2026</td>
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
        greetingEl.textContent = `${greeting}, Admin`;

        // ===== CHART BARS ANIMATION =====
        const chartData = {
            week: [{
                    label: 'Mon',
                    val: 65
                },
                {
                    label: 'Tue',
                    val: 45
                },
                {
                    label: 'Wed',
                    val: 80
                },
                {
                    label: 'Thu',
                    val: 55
                },
                {
                    label: 'Fri',
                    val: 90
                },
                {
                    label: 'Sat',
                    val: 70
                },
                {
                    label: 'Sun',
                    val: 40
                },
            ],
            month: [{
                    label: 'W1',
                    val: 60
                },
                {
                    label: 'W2',
                    val: 75
                },
                {
                    label: 'W3',
                    val: 50
                },
                {
                    label: 'W4',
                    val: 85
                },
            ],
            year: [{
                    label: 'Jan',
                    val: 40
                },
                {
                    label: 'Feb',
                    val: 55
                },
                {
                    label: 'Mar',
                    val: 65
                },
                {
                    label: 'Apr',
                    val: 50
                },
                {
                    label: 'May',
                    val: 80
                },
                {
                    label: 'Jun',
                    val: 70
                },
                {
                    label: 'Jul',
                    val: 60
                },
                {
                    label: 'Aug',
                    val: 45
                },
                {
                    label: 'Sep',
                    val: 75
                },
                {
                    label: 'Oct',
                    val: 85
                },
                {
                    label: 'Nov',
                    val: 90
                },
                {
                    label: 'Dec',
                    val: 95
                },
            ],
        };

        const chartArea = document.getElementById('chartArea');

        function renderChart(range) {
            const data = chartData[range];
            chartArea.innerHTML = '';

            data.forEach((item, i) => {
                const group = document.createElement('div');
                group.className = 'chart-bar-group';

                const bar = document.createElement('div');
                bar.className = `chart-bar ${i % 2 === 0 ? 'primary' : 'secondary'}`;
                bar.style.height = '0px';
                bar.title = `${item.label}: ${item.val}%`;

                const label = document.createElement('span');
                label.className = 'chart-bar-label';
                label.textContent = item.label;

                group.appendChild(bar);
                group.appendChild(label);
                chartArea.appendChild(group);

                // Animate bars
                requestAnimationFrame(() => {
                    setTimeout(() => {
                        bar.style.height = `${(item.val / 100) * 230}px`;
                    }, i * 60);
                });
            });
        }

        // Init chart
        renderChart('week');

        // Tab buttons
        document.querySelectorAll('.card-tab-btn[data-range]').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.card-tab-btn[data-range]').forEach(b => b.classList.remove(
                    'active'));
                btn.classList.add('active');
                renderChart(btn.dataset.range);
            });
        });
    </script>
</body>

</html>
