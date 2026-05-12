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
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 32px;
            width: 100%;
        }

        .stat-card {
            background: #fff;
            padding: 30px 24px;
            border-radius: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.06);
            border-color: var(--primary);
        }

        .stat-card-icon {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 4px;
        }

        .stat-card-icon.primary {
            background: rgba(117, 39, 56, 0.08);
            color: #752738;
        }

        .stat-card-icon.secondary {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .stat-card-icon.success {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .stat-card-value {
            font-size: 32px;
            font-weight: 800;
            color: #1a1a1a;
            line-height: 1;
        }

        .stat-card-label {
            font-size: 14px;
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            z-index: 2000;
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .modal-overlay.active {
            display: block;
        }

        .order-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2001;
            background: #fff;
            width: 95%;
            max-width: 650px;
            border-radius: 28px;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: modalFadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -45%) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #888;
            font-size: 14px;
        }

        .detail-value {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }
    </style>
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

                <a href="{{ route('customer.orders.page') }}" class="sidebar-nav-item {{ request()->routeIs('customer.orders.page') ? 'active' : '' }}" id="nav-orders">
                    <i class="fas fa-receipt"></i>
                    My Orders
                </a>

                <a href="{{ route('customer.scheduling.index') }}" class="sidebar-nav-item {{ request()->routeIs('customer.scheduling.index') ? 'active' : '' }}" id="nav-id-scheduling">
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
            </header>

            {{-- Page Content --}}
            <div class="page-content">

                {{-- Stats Grid --}}
                <div class="stats-grid">
                    {{-- Card 1 — Active Orders --}}
                    <div class="stat-card">
                        <div class="stat-card-icon primary">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="stat-card-value">{{ $activeOrdersCount }}</div>
                        <div class="stat-card-label">Active Orders</div>
                    </div>

                    {{-- Card 2 — Total Spent --}}
                    <div class="stat-card">
                        <div class="stat-card-icon secondary">
                            <i class="fas fa-peso-sign"></i>
                        </div>
                        <div class="stat-card-value">₱{{ number_format($totalSpent, 2) }}</div>
                        <div class="stat-card-label">Total Spent</div>
                    </div>

                    {{-- Card 3 — ID Status --}}
                    <div class="stat-card">
                        <div class="stat-card-icon success">
                            <i class="fas fa-id-card-clip"></i>
                        </div>
                        <div class="stat-card-value">Pending</div>
                        <div class="stat-card-label">ID Status</div>
                    </div>
                </div>

                {{-- Recent Orders Table --}}
                <div class="content-card">
                    <div class="card-header">
                        <h3>My Recent Orders</h3>
                        <div class="card-header-actions">
                            <a href="{{ route('customer.orders.page') }}" class="card-tab-btn active">View All</a>
                        </div>
                    </div>
                    <div class="orders-table-wrap">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                    <tr>
                                        <td><span class="order-id">#{{ $order->id }}</span></td>
                                        <td>₱{{ number_format($order->total_price, 2) }}</td>
                                        <td>
                                            <span class="status-badge {{ strtolower($order->status) }}">
                                                <span class="status-dot"></span>
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <button class="card-tab-btn"
                                                onclick='showOrderDetails(@json($order))'>
                                                <i class="fas fa-eye"></i> View Details
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 40px; color: #888;">
                                            <i class="fas fa-folder-open"
                                                style="font-size: 24px; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                                            No orders found yet.
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

    {{-- Order Details Modal --}}
    <div class="modal-overlay" id="modalOverlay" onclick="closeModal()"></div>
    <div class="order-modal" id="orderModal">
        <div
            style="padding: 24px 32px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; background: #fff;">
            <div>
                <h3 style="margin: 0; color: #752738; font-size: 1.25rem; font-weight: 700;">Order Details</h3>
                <p id="modalOrderId" style="margin: 4px 0 0; font-size: 13px; color: #888;"></p>
            </div>
            <button onclick="closeModal()"
                style="background: #f5f5f5; border: none; width: 36px; height: 36px; border-radius: 10px; cursor: pointer; color: #999; font-size: 18px;">&times;</button>
        </div>

        <div id="modalContent" style="padding: 32px; max-height: 70vh; overflow-y: auto; background: #fcfcfc;">
            {{-- Content injected via JS --}}
        </div>

        <div style="padding: 20px 32px; border-top: 1px solid #f0f0f0; text-align: right; background: #fff;">
            <button class="card-tab-btn" onclick="closeModal()"
                style="background: #f5f5f5; border: none; padding: 10px 24px; border-radius: 12px; font-weight: 600; color: #666; cursor: pointer;">Close
                Details</button>
        </div>
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

        // ===== ORDER DETAILS MODAL LOGIC =====
        function showOrderDetails(order) {
            const modal = document.getElementById('orderModal');
            const overlay = document.getElementById('modalOverlay');
            const content = document.getElementById('modalContent');
            const idHeader = document.getElementById('modalOrderId');

            idHeader.textContent = `Order Reference: #${order.id}`;

            let itemsHtml = '';
            order.items.forEach(item => {
                itemsHtml += `
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px; background: #fff; border: 1px solid #f0f0f0; border-radius: 16px; margin-bottom: 12px;">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="width: 45px; height: 45px; background: #fafafa; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #752738;">
                                <i class="fas fa-box"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0; font-size: 14px; font-weight: 600;">${item.product.product_name}</h4>
                                <p style="margin: 4px 0 0; font-size: 12px; color: #888;">
                                    ${item.variant ? 'Size: ' + item.variant.size : 'Standard Size'} 
                                    &bull; Qty: ${item.quantity}
                                </p>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-weight: 700; color: #752738;">₱${parseFloat(item.price_at_order * item.quantity).toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                        </div>
                    </div>
                `;
            });

            content.innerHTML = `
                <div style="margin-bottom: 24px;">
                    <div class="detail-row">
                        <span class="detail-label">Status</span>
                        <span class="status-badge ${order.status.toLowerCase()}">
                            <span class="status-dot"></span>
                            ${order.status}
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Order Date</span>
                        <span class="detail-value">${new Date(order.created_at).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Pickup Date</span>
                        <span class="detail-value" style="color: ${order.pick_up_date ? '#28a745' : '#888'}">
                            <i class="fas fa-calendar-alt" style="margin-right: 4px;"></i>
                            ${order.pick_up_date ? new Date(order.pick_up_date).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : 'Not yet scheduled'}
                        </span>
                    </div>
                </div>

                <h4 style="margin: 0 0 16px; font-size: 15px; color: #333; font-weight: 700;">Ordered Items</h4>
                <div style="margin-bottom: 24px;">
                    ${itemsHtml}
                </div>

                <div style="background: #752738; padding: 24px; border-radius: 20px; color: #fff; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="display: block; font-size: 12px; opacity: 0.8; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Total Amount Paid</span>
                        <span style="font-size: 24px; font-weight: 800;">₱${parseFloat(order.total_price).toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                    </div>
                    <i class="fas fa-receipt" style="font-size: 32px; opacity: 0.2;"></i>
                </div>
            `;

            modal.style.display = 'block';
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('orderModal').style.display = 'none';
            document.getElementById('modalOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }
    </script>
</body>

</html>
