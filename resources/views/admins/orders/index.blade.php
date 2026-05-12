<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brahmmart - Orders</title>
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

        .status-select {
            padding: 8px 14px;
            border-radius: 12px;
            border: 1.5px solid #eee;
            font-size: 14px;
            cursor: pointer;
            outline: none;
            transition: all 0.2s;
            font-family: inherit;
        }

        .status-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(var(--primary-rgb), 0.1);
        }

        .order-id {
            font-weight: 700;
            color: var(--primary);
            font-size: 15px;
        }

        .order-date {
            font-size: 13px;
            color: #777;
            font-weight: 500;
        }

        .badge-pending {
            background: #fff7ed;
            color: #9a3412;
        }

        .badge-processing {
            background: #eff6ff;
            color: #1e40af;
        }

        .badge-completed {
            background: #f0fdf4;
            color: #166534;
        }

        .badge-cancelled {
            background: #fef2f2;
            color: #991b1b;
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

        .modal-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
        }

        @media (max-width: 992px) {
            .modal-grid {
                grid-template-columns: 1fr !important;
                gap: 20px !important;
            }
        }

        #walkinItemsContainer::-webkit-scrollbar {
            width: 6px;
        }

        #walkinItemsContainer::-webkit-scrollbar-thumb {
            background: #eee;
            border-radius: 10px;
        }

        .swal2-container {
            z-index: 10000 !important;
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
                    <span class="nav-badge">{{ count($orders) }}</span>
                </a>



            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    style="cursor: pointer;">
                    <div class="sidebar-user-avatar"><img style="height: 50px; width: 50px;"
                            src="{{ asset('favicon.png') }}" alt=""></div>
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
                        <h1>Orders</h1>
                        <p>Track and manage customer orders</p>
                    </div>
                </div>
            </header>


            <div class="page-content">
                <button class="quick-action-btn primary-btn" style="margin-bottom: 24px;" onclick="openWalkinModal()">
                    <i class="fas fa-cash-register"></i> Add Walk-in Order
                </button>

                <div class="content-card">
                    <div class="card-header">
                        <h3>Orders</h3>
                        <div class="card-header-actions">

                            <span class="badge"
                                style="background: var(--primary); color: #fff !important; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                Total: {{ count($orders) }}
                            </span>
                        </div>
                    </div>

                    <div class="orders-table-wrap">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>
                                            <span class="order-id">#{{ $order->id }}</span>
                                        </td>
                                        <td>
                                            <div class="order-customer">
                                                <span
                                                    class="order-customer-name">{{ $order->customer->fullname }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="price">₱{{ number_format($order->total_price, 2) }}</span>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.orders.update', $order->id) }}"
                                                method="POST" id="status-form-{{ $order->id }}">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="status-select"
                                                    data-original-value="{{ $order->status }}"
                                                    onchange="handleStatusChange(this, {{ $order->id }})">
                                                    <option value="pending"
                                                        {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                                    </option>
                                                    <option value="processing"
                                                        {{ $order->status == 'processing' ? 'selected' : '' }}>
                                                        Processing</option>
                                                    <option value="completed"
                                                        {{ $order->status == 'completed' ? 'selected' : '' }}>Completed
                                                    </option>
                                                    <option value="cancelled"
                                                        {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                                    </option>
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <span
                                                class="order-date">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 8px;">
                                                <button class="quick-action-btn primary-btn"
                                                    onclick='showOrderDetails(@json($order))'
                                                    style="padding: 8px 12px; font-size: 12px; height: auto;">
                                                    <i class="fas fa-eye"></i> View Details
                                                </button>
                                                <button class="quick-action-btn"
                                                    onclick="confirmDelete({{ $order->id }})"
                                                    style="padding: 8px; font-size: 12px; height: auto; color: var(--accent);">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- Order Details Modal Overlay --}}
    <div class="sidebar-overlay" id="modalOverlay" style="z-index: 2000;"></div>
    <div id="orderModal"
        style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2001; background: #fff; width: 95%; max-width: 700px; border-radius: 24px; box-shadow: 0 40px 100px rgba(0,0,0,0.4); overflow: hidden; animation: modalFadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);">
        <div
            style="padding: 24px 32px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(to right, #fff, #fafafa);">
            <div>
                <h3
                    style="margin: 0; color: var(--primary); font-size: 1.5rem; font-weight: 700; letter-spacing: -0.5px;">
                    Order Details</h3>
                <p id="modalOrderIdHeader" style="margin: 4px 0 0 0; color: #777; font-size: 13px;">Reviewing items
                    for
                    order #...</p>
            </div>
            <button onclick="closeModal()"
                style="background: #f5f5f5; border: none; width: 40px; height: 40px; border-radius: 12px; font-size: 20px; cursor: pointer; color: #999; transition: all 0.2s; display: flex; align-items: center; justify-content: center;"
                onmouseover="this.style.background='#eee'; this.style.color='#333'"
                onmouseout="this.style.background='#f5f5f5'; this.style.color='#999'">&times;</button>
        </div>
        <div id="modalContent" style="padding: 32px; max-height: 70vh; overflow-y: auto; background: #fcfcfc;">
            {{-- Content injected via JS --}}
        </div>
        <div style="padding: 24px 32px; border-top: 1px solid #f0f0f0; text-align: right; background: #fff;">
            <button class="quick-action-btn" onclick="closeModal()"
                style="height: auto; padding: 12px 30px; border-radius: 12px; font-weight: 600; color: #666; background: #f5f5f5; border: none; transition: all 0.2s;"
                onmouseover="this.style.background='#eee'" onmouseout="this.style.background='#f5f5f5'">Close
                Window</button>
        </div>
    </div>

    {{-- Walk-in Order Modal --}}
    <div id="walkinModal"
        style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2001; background: #fff; width: 95%; max-width: 1000px; border-radius: 24px; box-shadow: 0 40px 100px rgba(0,0,0,0.4); overflow: hidden; animation: modalFadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);">
        <form id="walkinOrderForm" action="{{ route('admin.orders.store_walkin') }}" method="POST">
            @csrf
            <div
                style="padding: 24px 32px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; background: linear-gradient(to right, #fff, #fafafa);">
                <div>
                    <h3
                        style="margin: 0; color: var(--primary); font-size: 1.5rem; font-weight: 700; letter-spacing: -0.5px;">
                        Create Walk-in Order</h3>
                    <p style="margin: 4px 0 0 0; color: #777; font-size: 13px;">Enter customer details and select
                        products</p>
                </div>
                <button type="button" onclick="closeWalkinModal()"
                    style="background: #f5f5f5; border: none; width: 40px; height: 40px; border-radius: 12px; font-size: 20px; cursor: pointer; color: #999; transition: all 0.2s; display: flex; align-items: center; justify-content: center;"
                    onmouseover="this.style.background='#eee'; this.style.color='#333'"
                    onmouseout="this.style.background='#f5f5f5'; this.style.color='#999'">&times;</button>
            </div>

            <div style="padding: 32px; max-height: 75vh; overflow-y: auto; background: #fcfcfc;">
                <div class="modal-grid" style="gap: 32px;">
                    {{-- Left Side: Customer Info --}}
                    <div
                        style="background: #fff; padding: 24px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f0f0f0;">
                        <div
                            style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; color: var(--primary);">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fas fa-user-circle" style="font-size: 20px;"></i>
                                <h4 style="margin: 0; font-size: 16px; font-weight: 600;">Customer Information</h4>
                            </div>
                            <button type="button" onclick="openAccountSearchModal()" class="quick-action-btn"
                                style="height: auto; padding: 6px 12px; font-size: 11px; border-radius: 8px; border: 1.5px solid var(--primary); color: var(--primary); font-weight: 600; background: transparent;">
                                <i class="fas fa-search" style="margin-right: 4px;"></i> UB Mart Account?
                            </button>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label
                                style="display: block; font-size: 13px; font-weight: 600; color: #555; margin-bottom: 8px;">Full
                                Name</label>
                            <div style="position: relative;">
                                <i class="fas fa-user"
                                    style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 14px;"></i>
                                <input type="text" name="fullname" required
                                    style="width: 100%; padding: 12px 12px 12px 40px; border: 1.5px solid #eee; border-radius: 12px; font-size: 14px; transition: all 0.2s; font-family: inherit;"
                                    placeholder="John Doe"
                                    onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 4px rgba(var(--primary-rgb), 0.1)'"
                                    onblur="this.style.borderColor='#eee'; this.style.boxShadow='none'">
                            </div>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label
                                style="display: block; font-size: 13px; font-weight: 600; color: #555; margin-bottom: 8px;">Email
                                Address</label>
                            <div style="position: relative;">
                                <i class="fas fa-envelope"
                                    style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 14px;"></i>
                                <input type="email" name="email" required
                                    style="width: 100%; padding: 12px 12px 12px 40px; border: 1.5px solid #eee; border-radius: 12px; font-size: 14px; transition: all 0.2s; font-family: inherit;"
                                    placeholder="john@example.com"
                                    onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 4px rgba(var(--primary-rgb), 0.1)'"
                                    onblur="this.style.borderColor='#eee'; this.style.boxShadow='none'">
                            </div>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label
                                style="display: block; font-size: 13px; font-weight: 600; color: #555; margin-bottom: 8px;">
                                Address</label>
                            <div style="position: relative;">
                                <i class="fas fa-location-dot"
                                    style="position: absolute; left: 14px; top: 16px; color: #aaa; font-size: 14px;"></i>
                                <textarea name="address" required rows="3"
                                    style="width: 100%; padding: 12px 12px 12px 40px; border: 1.5px solid #eee; border-radius: 12px; font-size: 14px; transition: all 0.2s; resize: none; font-family: inherit;"
                                    placeholder="Enter full address details..."
                                    onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 4px rgba(var(--primary-rgb), 0.1)'"
                                    onblur="this.style.borderColor='#eee'; this.style.boxShadow='none'"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Right Side: Order Items --}}
                    <div style="display: flex; flex-direction: column;">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <div style="display: flex; align-items: center; gap: 10px; color: var(--primary);">
                                <i class="fas fa-shopping-basket" style="font-size: 20px;"></i>
                                <h4 style="margin: 0; font-size: 16px; font-weight: 600;">Order Items</h4>
                            </div>
                            <button type="button" onclick="addWalkinItemRow()" class="quick-action-btn primary-btn"
                                style="height: auto; padding: 8px 16px; font-size: 13px; border-radius: 10px; box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.2);">
                                <i class="fas fa-plus"></i> Add Item
                            </button>
                        </div>

                        <div id="walkinItemsContainer"
                            style="flex-grow: 1; min-height: 200px; max-height: 400px; overflow-y: auto; padding: 4px; margin-bottom: 20px;">
                            <!-- Item rows will be added here -->
                        </div>

                        <div
                            style="background: linear-gradient(135deg, var(--primary), #912e44); padding: 24px; border-radius: 20px; color: #fff; box-shadow: 0 10px 30px rgba(var(--primary-rgb), 0.2); display: flex; justify-content: space-between; align-items: center; position: relative; overflow: hidden;">
                            <div
                                style="position: absolute; right: -20px; bottom: -20px; font-size: 100px; opacity: 0.1; transform: rotate(-15deg);">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div>
                                <span
                                    style="display: block; font-size: 14px; opacity: 0.8; font-weight: 500; margin-bottom: 4px;">Grand
                                    Total</span>
                                <span id="walkinTotalPrice"
                                    style="font-size: 32px; font-weight: 700; letter-spacing: -1px;">₱0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                style="padding: 24px 32px; border-top: 1px solid #f0f0f0; text-align: right; background: #fff; display: flex; justify-content: flex-end; gap: 16px;">
                <button type="button" class="quick-action-btn" onclick="closeWalkinModal()"
                    style="height: auto; padding: 14px 28px; border-radius: 12px; font-weight: 600; color: #666; background: #f5f5f5; border: none; transition: all 0.2s;"
                    onmouseover="this.style.background='#eee'"
                    onmouseout="this.style.background='#f5f5f5'">Cancel</button>
                <button type="submit" class="quick-action-btn primary-btn"
                    style="height: auto; padding: 14px 40px; border-radius: 12px; font-weight: 700; font-size: 15px; box-shadow: 0 8px 20px rgba(var(--primary-rgb), 0.3);">
                    <i class="fas fa-check-circle" style="margin-right: 8px;"></i> Complete Order
                </button>
            </div>
        </form>
    </div>

    {{-- Account Search Modal --}}
    <div id="accountSearchModal"
        style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 3000; background: #fff; width: 90%; max-width: 500px; border-radius: 20px; box-shadow: 0 40px 100px rgba(0,0,0,0.5); overflow: hidden; animation: modalFadeIn 0.3s ease;">
        <div
            style="padding: 20px 24px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; background: #fafafa;">
            <h4 style="margin: 0; color: var(--primary); font-weight: 700;">Find UB Mart Account</h4>
            <button type="button" onclick="closeAccountSearchModal()"
                style="background: none; border: none; font-size: 24px; cursor: pointer; color: #999;">&times;</button>
        </div>
        <div style="padding: 24px;">
            <div style="position: relative; margin-bottom: 20px;">
                <i class="fas fa-search"
                    style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #aaa; font-size: 14px;"></i>
                <input type="text" id="accountSearchInput" onkeyup="filterAccounts()"
                    placeholder="Search by name or email..."
                    style="width: 100%; padding: 12px 12px 12px 40px; border: 1.5px solid #eee; border-radius: 12px; font-family: inherit; font-size: 14px; transition: all 0.2s;"
                    onfocus="this.style.borderColor='var(--primary)';" onblur="this.style.borderColor='#eee';">
            </div>
            <div id="accountsList" style="max-height: 350px; overflow-y: auto; padding-right: 4px;">
                <!-- Accounts injected here -->
            </div>
        </div>
    </div>
    <div id="accountSearchOverlay" onclick="closeAccountSearchModal()"
        style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 2999; backdrop-filter: blur(2px);">
    </div>

    {{-- Pickup Date Modal --}}
    <div id="pickupModal"
        style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 3005; background: #fff; width: 90%; max-width: 400px; border-radius: 20px; box-shadow: 0 40px 100px rgba(0,0,0,0.5); overflow: hidden; animation: modalFadeIn 0.3s ease;">
        <div style="padding: 20px 24px; border-bottom: 1px solid #f0f0f0; background: #fafafa;">
            <h4 style="margin: 0; color: var(--primary); font-weight: 700;">Set Pick-up Date</h4>
        </div>
        <div style="padding: 24px;">
            <p style="font-size: 14px; color: #666; margin-bottom: 20px;">Please specify the date and time when the
                customer can pick up their order.</p>
            <div style="margin-bottom: 24px;">
                <label
                    style="display: block; font-size: 12px; font-weight: 700; color: #999; text-transform: uppercase; margin-bottom: 8px;">Date
                    and Time</label>
                <input type="datetime-local" id="pickup_date_input"
                    style="width: 100%; padding: 12px; border: 1.5px solid #eee; border-radius: 12px; font-family: inherit; font-size: 14px;">
            </div>
            <div style="display: flex; gap: 12px;">
                <button type="button" onclick="closePickupModal()" class="quick-action-btn"
                    style="flex: 1; background: #f5f5f5; color: #666; border: none; height: auto; padding: 12px;">Cancel</button>
                <button type="button" onclick="confirmPickup()" class="quick-action-btn primary-btn"
                    style="flex: 1; height: auto; padding: 12px;">Confirm</button>
            </div>
        </div>
    </div>
    <div id="pickupOverlay" onclick="closePickupModal()"
        style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 3004; backdrop-filter: blur(2px);">
    </div>

    <form id="deleteOrderForm" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024) closeSidebar();
        });

        // ===== ORDER DETAILS MODAL =====
        function showOrderDetails(order) {
            document.getElementById('modalOrderIdHeader').textContent = `Reviewing items for order #${order.id}`;

            const hasEmailable = order.items.some(item => item.product.is_emailable == 1);
            let orderNoteHtml = '';

            if (hasEmailable) {
                if (order.order_note) {
                    orderNoteHtml = `
                        <div style="background: #fff8f8; padding: 16px; border-radius: 16px; border: 1.5px solid #fee2e2; margin-bottom: 24px; position: relative;">
                            <div style="display: flex; gap: 12px; align-items: flex-start;">
                                <i class="fas fa-sticky-note" style="color: var(--primary); margin-top: 4px;"></i>
                                <div style="flex: 1;">
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                        <span style="display: block; font-size: 11px; color: #999; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Order Notes</span>
                                        <button onclick="editOrderNote(${order.id}, \`${order.order_note.replace(/`/g, '\\`').replace(/\n/g, '\\n').replace(/\r/g, '')}\`)" 
                                            style="background: transparent; border: none; color: var(--primary); cursor: pointer; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </div>
                                    <span style="font-weight: 500; color: #333; font-size: 14px; white-space: pre-line;">${order.order_note}</span>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    orderNoteHtml = `

                    `;
                }
            }

            let html = `
                ${orderNoteHtml}
                <div style="background: #fff; padding: 24px; border-radius: 20px; border: 1.5px solid #f0f0f0; margin-bottom: 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px; color: var(--primary);">
                        <i class="fas fa-user-circle" style="font-size: 18px;"></i>
                        <h4 style="margin: 0; font-size: 15px; font-weight: 600;">Customer Info</h4>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <span style="display: block; font-size: 11px; color: #999; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Name</span>
                            <span style="font-weight: 600; color: #333;">${order.customer.fullname}</span>
                        </div>
                        <div>
                            <span style="display: block; font-size: 11px; color: #999; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Email</span>
                            <span style="color: #666;">${order.customer.email}</span>
                        </div>
                        <div style="grid-column: span 2;">
                            <span style="display: block; font-size: 11px; color: #999; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Shipping Address</span>
                            <span style="color: #666; font-size: 14px; line-height: 1.5;">${order.customer.address}</span>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: 16px; color: var(--primary); display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-list-ul" style="font-size: 16px;"></i>
                    <h4 style="margin: 0; font-size: 15px; font-weight: 600;">Purchased Items</h4>
                </div>

                <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px;">
            `;

            order.items.forEach(item => {
                let variantInfo = item.variant ?
                    `<span style="background: #f0f0f0; padding: 2px 8px; border-radius: 4px; font-size: 11px; color: #666; margin-left: 8px;">Size: ${item.variant.size}</span>` :
                    '';

                let typeBadge = item.product.is_emailable == 1 ?
                    `<span style="background: #fff5f7; color: var(--primary); padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; text-transform: uppercase; margin-left: 8px; border: 1px solid rgba(var(--primary-rgb), 0.2);">Custom Sizing</span>` :
                    `<span style="background: #f0fdf4; color: #166534; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; text-transform: uppercase; margin-left: 8px; border: 1px solid #bbf7d0;">Standard</span>`;

                let itemNoteBtn = item.product.is_emailable == 1 ?
                    `<button onclick="editItemSizingNote(${item.id}, \`${(item.sizing_notes || '').replace(/`/g, '\\`').replace(/\n/g, '\\n').replace(/\r/g, '')}\`, this)" 
                        style="background: #fcfcfc; border: 1.5px solid #eee; padding: 4px 10px; border-radius: 8px; font-size: 11px; font-weight: 600; cursor: pointer; color: var(--primary); margin-left: auto; display: flex; align-items: center; gap: 4px; transition: all 0.2s;"
                        onmouseover="this.style.background='var(--primary)'; this.style.color='#fff'; this.style.borderColor='var(--primary)'"
                        onmouseout="this.style.background='#fcfcfc'; this.style.color='var(--primary)'; this.style.borderColor='#eee'">
                        <i class="fas fa-plus"></i> ${item.sizing_notes ? 'Edit sizing' : 'Add sizing'}
                    </button>` : '';

                let sizingInfo = `
                    <div id="item-sizing-note-${item.id}" style="${item.sizing_notes ? 'display: block;' : 'display: none;'} margin-top: 8px; padding: 8px 12px; background: #fff5f7; border-radius: 8px; border: 1px dashed rgba(var(--primary-rgb), 0.3); font-size: 12px; color: var(--primary);">
                        <i class="fas fa-info-circle"></i> <strong>Sizing Notes:</strong> <span>${item.sizing_notes || ''}</span>
                    </div>`;

                html += `
                    <div style="display: flex; flex-direction: column; padding: 16px; background: #fff; border-radius: 16px; border: 1px solid #f0f0f0;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="width: 40px; height: 40px; background: #fafafa; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                    <i class="fas fa-box" style="font-size: 16px;"></i>
                                </div>
                                <div>
                                    <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 4px;">
                                        <span style="font-weight: 600; color: #333; font-size: 14px;">${item.product.product_name}</span>
                                        ${variantInfo}
                                        ${typeBadge}
                                    </div>
                                    <small style="color: #999; display: block; margin-top: 2px;">${item.quantity} unit(s) x ₱${parseFloat(item.price_at_order).toLocaleString(undefined, {minimumFractionDigits: 2})}</small>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                ${itemNoteBtn}
                                <span style="font-weight: 700; color: var(--primary); font-size: 15px; min-width: 80px; text-align: right;">₱${(item.quantity * item.price_at_order).toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                            </div>
                        </div>
                        ${sizingInfo}
                    </div>
                `;
            });

            html += `
                </div>
                <div style="background: linear-gradient(135deg, #333, #111); padding: 24px; border-radius: 20px; color: #fff; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <div>
                        <span style="display: block; font-size: 13px; opacity: 0.7; margin-bottom: 4px;">Total Paid</span>
                        <span style="font-size: 26px; font-weight: 700; letter-spacing: -1px;">₱${parseFloat(order.total_price).toLocaleString(undefined, {minimumFractionDigits: 2})}</span>
                    </div>
                </div>
            `;

            document.getElementById('modalContent').innerHTML = html;
            document.getElementById('orderModal').style.display = 'block';
            document.getElementById('modalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('orderModal').style.display = 'none';
            document.getElementById('modalOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        function editOrderNote(orderId, currentNote) {
            Swal.fire({
                title: 'Order Notes',
                input: 'textarea',
                inputLabel: 'Special Instructions / Notes',
                inputValue: currentNote || '',
                inputPlaceholder: 'Enter instructions for uniforms here...',
                showCancelButton: true,
                confirmButtonColor: '#752738',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Save Note',
                cancelButtonText: 'Cancel',
                inputAttributes: {
                    'rows': 5
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/orders/${orderId}/update-note`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                order_note: result.value
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Find the container in the modal
                                const container = document.querySelector(
                                    '#modalContent [style*="background: #fff8f8"]');
                                if (container) {
                                    // Update existing note
                                    const noteSpan = container.querySelector(
                                        'span[style*="white-space: pre-line"]');
                                    if (noteSpan) noteSpan.textContent = result.value;

                                    // Update edit button onclick
                                    const editBtn = container.querySelector('button[onclick*="editOrderNote"]');
                                    if (editBtn) {
                                        const escapedValue = result.value.replace(/`/g, '\\`').replace(/\n/g,
                                            '\\n').replace(/\r/g, '');
                                        editBtn.setAttribute('onclick',
                                            `editOrderNote(${orderId}, \`${escapedValue}\`)`);
                                    }
                                } else {
                                    // If it was an "+ Add Note" button, we might need a refresh to show the new structure
                                    // or just reload for simplicity since adding a whole new block is complex via JS
                                    window.location.reload();
                                    return;
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Saved!',
                                    text: 'Order note has been updated.',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Failed to update note.', 'error');
                        });
                }
            });
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the order!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#752738',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteOrderForm');
                    form.action = `/admin/orders/${id}`;
                    form.submit();
                }
            });
        }

        function editItemSizingNote(itemId, currentNote, btnElement) {
            Swal.fire({
                title: 'Sizing Details',
                input: 'textarea',
                inputLabel: 'Enter measurements or notes for this item',
                inputValue: currentNote || '',
                inputPlaceholder: 'Example: XL chest, custom sleeve length...',
                showCancelButton: true,
                confirmButtonColor: '#752738',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Save Details',
                cancelButtonText: 'Cancel',
                inputAttributes: {
                    'rows': 4
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/order-items/${itemId}/update-note`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                sizing_notes: result.value
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update display in modal
                                const noteDiv = document.getElementById(`item-sizing-note-${itemId}`);
                                if (noteDiv) {
                                    noteDiv.querySelector('span').textContent = result.value;
                                    noteDiv.style.display = result.value ? 'block' : 'none';
                                }

                                // Update button text and onclick handler for next time
                                if (btnElement) {
                                    btnElement.innerHTML =
                                        `<i class="fas fa-plus"></i> ${result.value ? 'Edit sizing' : 'Add sizing'}`;
                                    const escapedValue = result.value.replace(/`/g, '\\`').replace(/\n/g, '\\n')
                                        .replace(/\r/g, '');
                                    btnElement.setAttribute('onclick',
                                        `editItemSizingNote(${itemId}, \`${escapedValue}\`, this)`);
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated!',
                                    text: 'Sizing details saved.',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Error', 'Failed to update sizing notes.', 'error');
                        });
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

        let walkinItemCount = 0;
        const products = @json($products);
        const variants = @json($variants);
        const allCustomers = @json($customers);

        function openAccountSearchModal() {
            document.getElementById('accountSearchModal').style.display = 'block';
            document.getElementById('accountSearchOverlay').style.display = 'block';
            document.getElementById('accountSearchInput').value = '';
            renderAccountsList(allCustomers);
            setTimeout(() => document.getElementById('accountSearchInput').focus(), 100);
        }

        function closeAccountSearchModal() {
            document.getElementById('accountSearchModal').style.display = 'none';
            document.getElementById('accountSearchOverlay').style.display = 'none';
        }

        function renderAccountsList(customers) {
            const container = document.getElementById('accountsList');
            container.innerHTML = customers.map(c => `
                <div onclick="selectCustomer(${c.id})" style="padding: 14px; border-bottom: 1px solid #f8f8f8; cursor: pointer; border-radius: 12px; transition: all 0.2s; margin-bottom: 4px;" onmouseover="this.style.background='#fcf2f4'; this.style.transform='translateX(4px)'" onmouseout="this.style.background='transparent'; this.style.transform='translateX(0)'">
                    <div style="font-weight: 700; color: #333; font-size: 14px;">${c.fullname}</div>
                    <div style="font-size: 12px; color: #888; display: flex; align-items: center; gap: 6px;">
                        <i class="fas fa-envelope" style="font-size: 10px;"></i> ${c.email}
                    </div>
                </div>
            `).join('');
            if (customers.length === 0) {
                container.innerHTML =
                    '<div style="padding: 40px 20px; text-align: center; color: #aaa; font-size: 14px;"><i class="fas fa-user-slash" style="font-size: 24px; display: block; margin-bottom: 10px; opacity: 0.5;"></i>No accounts found.</div>';
            }
        }

        function filterAccounts() {
            const query = document.getElementById('accountSearchInput').value.toLowerCase();
            const filtered = allCustomers.filter(c =>
                c.fullname.toLowerCase().includes(query) ||
                c.email.toLowerCase().includes(query)
            );
            renderAccountsList(filtered);
        }

        function selectCustomer(id) {
            const customer = allCustomers.find(c => c.id === id);
            if (customer) {
                const form = document.getElementById('walkinOrderForm');
                form.querySelector('input[name="fullname"]').value = customer.fullname;
                form.querySelector('input[name="email"]').value = customer.email;
                form.querySelector('textarea[name="address"]').value = customer.address || '';
                closeAccountSearchModal();

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: "Account linked: " + customer.fullname,
                    showConfirmButton: false,
                    timer: 2500
                });
            }
        }

        let pendingStatusForm = null;

        function handleStatusChange(selectElement, orderId) {
            const status = selectElement.value;
            const form = document.getElementById(`status-form-${orderId}`);

            if (status === 'completed') {
                pendingStatusForm = form;
                openPickupModal();
            } else {
                form.submit();
            }
        }

        function openPickupModal() {
            document.getElementById('pickupModal').style.display = 'block';
            document.getElementById('pickupOverlay').style.display = 'block';
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            document.getElementById('pickup_date_input').min = now.toISOString().slice(0, 16);
        }

        function closePickupModal() {
            document.getElementById('pickupModal').style.display = 'none';
            document.getElementById('pickupOverlay').style.display = 'none';
            if (pendingStatusForm) {
                const select = pendingStatusForm.querySelector('select');
                select.value = select.getAttribute('data-original-value');
                pendingStatusForm = null;
            }
        }

        function confirmPickup() {
            const dateInput = document.getElementById('pickup_date_input').value;
            if (!dateInput) {
                Swal.fire('Error', 'Please select a pick-up date and time.', 'error');
                return;
            }

            if (pendingStatusForm) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'pick_up_date';
                hiddenInput.value = dateInput;
                pendingStatusForm.appendChild(hiddenInput);
                pendingStatusForm.submit();
            }
        }

        function openWalkinModal() {
            document.getElementById('walkinModal').style.display = 'block';
            document.getElementById('modalOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
            if (walkinItemCount === 0) {
                addWalkinItemRow();
            }
        }

        function closeWalkinModal() {
            document.getElementById('walkinModal').style.display = 'none';
            document.getElementById('modalOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        document.getElementById('modalOverlay').addEventListener('click', () => {
            closeModal();
            closeWalkinModal();
        });

        function addWalkinItemRow() {
            const container = document.getElementById('walkinItemsContainer');
            const rowId = walkinItemCount++;
            const row = document.createElement('div');
            row.className = 'walkin-item-row';
            row.id = `walkin-item-${rowId}`;
            row.style =
                "margin-bottom: 16px; padding: 20px; background: #fff; border-radius: 16px; border: 1px solid #f0f0f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); position: relative; animation: slideIn 0.3s ease-out;";

            row.innerHTML = `
                <style>
                    @keyframes slideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
                </style>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 700; color: #999; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px;">Select Product</label>
                        <select name="items[${rowId}][product_id]" required onchange="updateWalkinVariants(${rowId})" class="status-select" style="width: 100%; height: 42px; border: 1.5px solid #eee; border-radius: 10px; font-family: inherit;">
                            <option value="">Choose a product...</option>
                            ${products.map(p => `<option value="${p.id}">${p.product_name}</option>`).join('')}
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 700; color: #999; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px;">Size / Variant</label>
                        <select name="items[${rowId}][variant_id]" id="variant-${rowId}" onchange="calculateWalkinTotal()" class="status-select" style="width: 100%; height: 42px; border: 1.5px solid #eee; border-radius: 10px; font-family: inherit;">
                            <option value="">Standard</option>
                        </select>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 0.8fr 1.2fr auto; gap: 12px; align-items: end; margin-bottom: 12px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 700; color: #999; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px;">Quantity</label>
                        <input type="number" name="items[${rowId}][quantity]" value="1" min="1" required onchange="calculateWalkinTotal()" style="width: 100%; height: 42px; padding: 0 12px; border: 1.5px solid #eee; border-radius: 10px; font-size: 14px; font-family: inherit;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 700; color: #999; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px;">Unit Price</label>
                        <div style="position: relative;">
                            <span style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-weight: 600; color: var(--primary);">₱</span>
                            <input type="text" id="price-display-${rowId}" readonly style="width: 100%; height: 42px; padding: 0 12px 0 28px; border: 1.5px solid #f5f5f5; border-radius: 10px; background: #f9f9f9; font-size: 15px; font-weight: 700; color: var(--primary); font-family: inherit;">
                        </div>
                    </div>
                    <button type="button" onclick="removeWalkinItemRow(${rowId})" style="background: #fff; border: 1.5px solid #fee2e2; color: #ef4444; width: 42px; height: 42px; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#ef4444'; this.style.color='#fff'; this.style.borderColor='#ef4444'" onmouseout="this.style.background='#fff'; this.style.color='#ef4444'; this.style.borderColor='#fee2e2'"><i class="fas fa-trash-alt"></i></button>
                </div>
                <div id="sizing-notes-container-${rowId}" style="display: none; animation: fadeIn 0.3s ease;">
                    <label style="display: block; font-size: 11px; font-weight: 700; color: var(--primary); text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px;">Sizing Notes (Custom)</label>
                    <textarea name="items[${rowId}][sizing_notes]" placeholder="Enter sizing details (e.g., XL shoulder, L waist)..." 
                        style="width: 100%; padding: 12px; border: 1.5px solid rgba(var(--primary-rgb), 0.2); border-radius: 10px; font-size: 13px; font-family: inherit; resize: none; background: rgba(var(--primary-rgb), 0.02);" rows="2"></textarea>
                </div>
            `;
            container.appendChild(row);
        }

        function removeWalkinItemRow(id) {
            const row = document.getElementById(`walkin-item-${id}`);
            if (row) {
                row.remove();
                calculateWalkinTotal();
            }
        }

        function updateWalkinVariants(rowId) {
            const productId = document.querySelector(`select[name="items[${rowId}][product_id]"]`).value;
            const variantSelect = document.getElementById(`variant-${rowId}`);
            const priceDisplay = document.getElementById(`price-display-${rowId}`);

            if (!productId) {
                variantSelect.innerHTML = '<option value="">Standard</option>';
                priceDisplay.value = '';
                calculateWalkinTotal();
                return;
            }

            const product = products.find(p => p.id == productId);
            const productVariants = variants.filter(v => v.product_id == productId);
            const sizingNotesContainer = document.getElementById(`sizing-notes-container-${rowId}`);

            if (product && product.is_emailable == 1) {
                sizingNotesContainer.style.display = 'block';
            } else {
                sizingNotesContainer.style.display = 'none';
                sizingNotesContainer.querySelector('textarea').value = '';
            }

            checkEmailableStatus();

            if (productVariants.length > 0) {
                variantSelect.innerHTML = productVariants.map(v =>
                    `<option value="${v.id}">${v.size} - ₱${parseFloat(v.price).toLocaleString(undefined, {minimumFractionDigits: 2})}</option>`
                ).join('');
                priceDisplay.value = parseFloat(productVariants[0].price).toLocaleString(undefined, {
                    minimumFractionDigits: 2
                });
            } else {
                variantSelect.innerHTML = '<option value="">Standard</option>';
                priceDisplay.value = parseFloat(product.product_price).toLocaleString(undefined, {
                    minimumFractionDigits: 2
                });
            }
            calculateWalkinTotal();
        }

        function calculateWalkinTotal() {
            let total = 0;
            const rows = document.querySelectorAll('.walkin-item-row');
            rows.forEach(row => {
                const rowId = row.id.split('-').pop();
                const productId = row.querySelector(`select[name="items[${rowId}][product_id]"]`).value;
                if (!productId) return;

                const variantSelect = document.getElementById(`variant-${rowId}`);
                const quantity = row.querySelector(`input[name="items[${rowId}][quantity]"]`).value;

                let price = 0;
                if (variantSelect.value) {
                    const selectedVariant = variants.find(v => v.id == variantSelect.value);
                    price = selectedVariant ? selectedVariant.price : 0;
                } else {
                    const product = products.find(p => p.id == productId);
                    price = product ? product.product_price : 0;
                }

                total += price * quantity;
                const rowPriceDisplay = document.getElementById(`price-display-${rowId}`);
                if (rowPriceDisplay) {
                    rowPriceDisplay.value = parseFloat(price).toLocaleString(undefined, {
                        minimumFractionDigits: 2
                    });
                }
            });

            const totalDisplay = document.getElementById('walkinTotalPrice');
            if (totalDisplay) {
                totalDisplay.innerText = `₱${total.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
            }

            checkEmailableStatus();
        }

        function checkEmailableStatus() {
            const rows = document.querySelectorAll('.walkin-item-row');
            let hasEmailable = false;
            rows.forEach(row => {
                const rowId = row.id.split('-').pop();
                const productId = row.querySelector(`select[name="items[${rowId}][product_id]"]`).value;
                const product = products.find(p => p.id == productId);
                if (product && product.is_emailable == 1) hasEmailable = true;
            });

            const generalNoteContainer = document.getElementById('general-note-container');
            if (hasEmailable) {
                generalNoteContainer.style.display = 'block';
            } else {
                generalNoteContainer.style.display = 'none';
                generalNoteContainer.querySelector('textarea').value = '';
            }
        }
    </script>
</body>

</html>
