<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brahmmart</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin/dashboard.css') }}">
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


                <a href="#" class="sidebar-nav-item" id="nav-accounts">
                    <i class="fas fa-user-tie"></i>
                    Admins
                    <span class="nav-badge">24</span>
                </a>

                <a href="#" class="sidebar-nav-item" id="nav-students">
                    <i class="fas fa-user-graduate"></i>
                    Students
                    <span class="nav-badge">24</span>
                </a>

                <a href="#" class="sidebar-nav-item" id="nav-id-scheduling">
                    <i class="fas fa-id-card"></i>
                    ID Scheduling
                    <span class="nav-badge">30</span>
                </a>

                <a href="{{ route('admin.inventory.page') }}"
                    class="sidebar-nav-item {{ request()->routeIs('admin.inventory.page') ? 'active' : '' }}"
                    id="nav-inventory">
                    <i class="fas fa-boxes-stacked"></i>
                    Inventory
                    <span class="nav-badge">{{ count($products) }}</span>
                </a>

                <div class="sidebar-nav-label" style="margin-top: 16px;">Management</div>

                <a href="#" class="sidebar-nav-item" id="nav-orders">
                    <i class="fas fa-receipt"></i>
                    Orders
                </a>

                <a href="#" class="sidebar-nav-item" id="nav-analytics">
                    <i class="fas fa-chart-simple"></i>
                    Analytics
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
                        <h1>Inventory</h1>
                        <p>Manage your products and stock levels</p>
                    </div>
                </div>
                <div class="header-right">
                    <button class="header-icon-btn" id="notifBtn" aria-label="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notif-dot"></span>
                    </button>
                    <button class="header-icon-btn" id="settingsBtn" aria-label="Settings">
                        <i class="fas fa-user"></i>
                    </button>
                </div>
            </header>

            {{-- Page Content --}}
            <div class="page-content">
                {{-- Inventory Actions --}}
                <div class="quick-actions" style="margin-bottom: 24px;">
                    <button class="quick-action-btn primary-btn" id="addProductBtn">
                        <i class="fas fa-plus"></i> Add New Product
                    </button>
                </div>
                {{-- Stats Grid --}}
                <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-card-icon secondary">
                                <i class="fas fa-shirt"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">{{ $uniformCount }}</div>
                        <div class="stat-card-label">Uniforms</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-card-icon success">
                                <i class="fas fa-pen-ruler"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">{{ $suppliesCount }}</div>
                        <div class="stat-card-label">School Supplies</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-card-icon info">
                                <i class="fas fa-book"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">{{ $booksCount }}</div>
                        <div class="stat-card-label">Books</div>
                    </div>
                </div>



                {{-- Products Table --}}
                <div class="content-card">

                    <div class="card-header">
                        <h3>Product List</h3>
                        <div class="card-header-actions">
                            <span class="badge"
                                style="background: var(--primary); color: #fff !important; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                Total: {{ count($products) }}
                            </span>
                        </div>
                    </div>
                    <div class="orders-table-wrap">
                        <table class="orders-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Category</th>
                                    <th>Details</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            <div class="order-customer">
                                                <div class="order-avatar av-1">
                                                    @php
                                                        $productImages = json_decode($product->product_image, true);
                                                        $firstImage =
                                                            !empty($productImages) && is_array($productImages)
                                                                ? $productImages[0]
                                                                : null;
                                                    @endphp
                                                    <img style="height: 40px; width: 40px; object-fit: cover;"
                                                        src="{{ $firstImage ? asset($firstImage) : asset('favicon.png') }}"
                                                        alt="">
                                                </div> &nbsp;
                                                <span class="order-customer-name">{{ $product->product_name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge processing"
                                                style="padding: 4px 12px; border-radius: 20px; font-weight: 500;">
                                                {{ $product->category_name }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="quick-action-btn primary-btn"
                                                onclick='showProductDetails(@json($product))'
                                                style="padding: 8px 16px; font-size: 12px; height: auto;">
                                                <i class="fas fa-circle-info"></i> View Details
                                            </button>
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 8px;">
                                                <button class="quick-action-btn"
                                                    onclick='showEditModal(@json($product))'
                                                    style="padding: 8px; font-size: 12px; height: auto;"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="quick-action-btn"
                                                    onclick="confirmDelete({{ $product->id }})"
                                                    style="padding: 8px; font-size: 12px; height: auto; color: var(--accent);"
                                                    title="Delete">
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

    {{-- Hidden Delete Form --}}
    <form id="deleteProductForm" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- ===== PRODUCT DETAILS MODAL (VIEW) ===== --}}
    <div class="sidebar-overlay" id="modalOverlay" style="z-index: 2000; background: rgba(0,0,0,0.7);"></div>
    <div id="productModal"
        style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2001; background: white; width: 95%; max-width: 800px; border-radius: 20px; box-shadow: 0 25px 50px rgba(0,0,0,0.3); overflow: hidden; animation: modalFadeIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);">
        <div
            style="padding: 20px 24px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; background: #fff;">
            <h3 style="margin: 0; color: var(--primary); font-size: 1.25rem;">Product Information</h3>
            <button onclick="closeModal('productModal')"
                style="background: #f5f5f5; border: none; width: 32px; height: 32px; border-radius: 50%; font-size: 18px; cursor: pointer; color: #666; display: flex; align-items: center; justify-content: center;">&times;</button>
        </div>
        <div style="padding: 0; max-height: 80vh; overflow-y: auto;">
            <div class="modal-grid view-grid">
                <div style="padding: 24px; background: #fcfcfc; border-right: 1px solid #eee;" class="modal-left-col">
                    <div id="modalImageContainer"
                        style="width: 100%; aspect-ratio: 1; border-radius: 12px; overflow: hidden; margin-bottom: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); background: white;">
                        <img id="modalMainImage" src="" alt=""
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div id="modalThumbnails" style="display: flex; gap: 8px; flex-wrap: wrap;"></div>
                    <div style="margin-top: 24px;">
                        <label
                            style="display: block; font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Category</label>
                        <p id="modalCategory" style="margin: 0; font-weight: 600; color: var(--secondary);"></p>
                    </div>
                    <div style="margin-top: 16px;">
                        <label
                            style="display: block; font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Type</label>
                        <p id="modalType" style="margin: 0; font-weight: 600; color: var(--primary);"></p>
                    </div>
                    <div id="modalGenderSection" style="margin-top: 16px;">
                        <label
                            style="display: block; font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Gender</label>
                        <p id="modalGender" style="margin: 0; font-weight: 600; color: #752738;"></p>
                    </div>
                </div>
                <div style="padding: 24px;">
                    <h2 id="modalProductName" style="margin: 0 0 12px 0; font-size: 1.5rem; color: #333;"></h2>
                    <div style="margin-bottom: 24px;">
                        <label
                            style="display: block; font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Description</label>
                        <p id="modalDescription" style="margin: 0; color: #666; line-height: 1.6; font-size: 14px;">
                        </p>
                    </div>
                    <div id="variantSection">
                        <label
                            style="display: block; font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Pricing
                            & Inventory</label>
                        <div class="orders-table-wrap" style="border: 1px solid #eee; border-radius: 8px;">
                            <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                                <thead style="background: #f9f9f9;">
                                    <tr style="text-align: left; border-bottom: 1px solid #eee;">
                                        <th style="padding: 10px;">Size</th>
                                        <th style="padding: 10px;">Price</th>
                                        <th style="padding: 10px;">Stock</th>
                                    </tr>
                                </thead>
                                <tbody id="modalVariantTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                    <div id="simpleStockSection" style="display: none;">
                        <label
                            style="display: block; font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Pricing
                            & Inventory</label>
                        <div style="display: flex; gap: 24px;">
                            <div style="flex: 1; background: #f9f9f9; padding: 16px; border-radius: 12px;">
                                <span style="display: block; font-size: 12px; color: #666;">Price</span>
                                <span id="modalSimplePrice"
                                    style="font-size: 20px; font-weight: 700; color: var(--primary);"></span>
                            </div>
                            <div style="flex: 1; background: #f9f9f9; padding: 16px; border-radius: 12px;">
                                <span style="display: block; font-size: 12px; color: #666;">Current Stock</span>
                                <span id="modalSimpleStock"
                                    style="font-size: 20px; font-weight: 700; color: var(--secondary);"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="padding: 16px 24px; border-top: 1px solid #eee; text-align: right; background: #fff;">
            <button class="quick-action-btn" onclick="closeModal('productModal')"
                style="height: auto; padding: 12px 32px; font-weight: 600;">Close Details</button>
        </div>
    </div>

    {{-- ===== EDIT PRODUCT MODAL ===== --}}
    <div id="editModal"
        style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2001; background: white; width: 95%; max-width: 900px; border-radius: 20px; box-shadow: 0 25px 50px rgba(0,0,0,0.3); overflow: hidden; animation: modalFadeIn 0.3s ease;">
        <form id="editProductForm" action="#" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div
                style="padding: 20px 24px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; color: var(--primary);">Edit Product</h3>
                <button type="button" onclick="closeModal('editModal')"
                    style="background: none; border: none; font-size: 24px; cursor: pointer; color: #999;">&times;</button>
            </div>

            <div style="padding: 24px; max-height: 75vh; overflow-y: auto;">
                <div class="modal-grid">

                    {{-- Left Side: Basic Info --}}
                    <div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Product
                                Name</label>
                            <input type="text" id="editName" name="product_name"
                                style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;"
                                required>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label
                                style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Description</label>
                            <textarea id="editDescription" name="product_description" rows="5"
                                style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; resize: vertical;"></textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                            <div>
                                <label
                                    style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Category</label>
                                <input type="hidden" name="category_id" id="editCategoryIdHidden">
                                <div id="editCategoryDisplay"
                                    style="padding: 12px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-weight: 600; color: #555;">
                                    {{-- Category Name injected via JS --}}
                                </div>
                                <select id="editCategorySelect" style="display: none;">
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                    @endforeach
                                </select>
                                <div id="editUniformTypeSection" style="margin-top: 16px;">
                                    <label
                                        style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Uniform
                                        Type</label>
                                    <select name="uniform_category_id" id="editUniformType"
                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                                        @foreach ($uniform_categories as $ucat)
                                            <option value="{{ $ucat->id }}">{{ $ucat->uniform_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="editGenderSection" style="margin-top: 16px;">
                                    <label
                                        style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Gender</label>
                                    <select name="gender" id="editGenderSelect"
                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Unisex">Unisex</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 16px; display: none;" id="editIsUniformSection">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" name="is_emailable" id="editIsUniform"
                                    style="width: 18px; height: 18px;">
                                <span style="font-weight: 600; color: #333;">This product has customization
                                    sizes?</span>
                            </label>
                        </div>

                        <div style="margin-top: 24px;" id="editHasVariantSection">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" name="has_variant" id="editHasVariant"
                                    style="width: 18px; height: 18px;" onchange="toggleEditVariantSection(this)">
                                <span style="font-weight: 600; color: #333;">This product has variants (Sizes)</span>
                            </label>
                        </div>
                    </div>

                    {{-- Right Side: Images & Inventory --}}
                    <div>
                        <div style="margin-bottom: 24px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Product
                                Images</label>
                            <div
                                style="border: 2px dashed #ddd; padding: 20px; border-radius: 12px; text-align: center; position: relative;">
                                <input type="file" id="editImageInput" name="product_images[]" multiple
                                    accept="image/*"
                                    style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer;"
                                    onchange="previewNewImages(event)">
                                <i class="fas fa-cloud-upload-alt"
                                    style="font-size: 32px; color: var(--primary); margin-bottom: 8px;"></i>
                                <p style="margin: 0; font-size: 13px; color: #666;">Click to upload or drag and drop
                                    multiple images</p>
                            </div>
                            <div id="editImagePreviews"
                                style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 16px;"></div>
                        </div>

                        {{-- Variant Section (Conditional) --}}
                        <div id="editVariantSection" style="display: none;">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                <label style="display: block; font-weight: 600; color: #333;">Variants (Sizes)</label>
                                <button type="button" onclick="addEditVariantRow()"
                                    class="quick-action-btn primary-btn"
                                    style="height: auto; padding: 4px 10px; font-size: 12px;">
                                    <i class="fas fa-plus"></i> Add Size
                                </button>
                            </div>
                            <div
                                style="background: #f9f9f9; padding: 16px; border-radius: 12px; border: 1px solid #eee;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <thead style="font-size: 12px; color: #999; text-transform: uppercase;">
                                        <tr>
                                            <th style="text-align: left; padding-bottom: 8px;">Size</th>
                                            <th style="text-align: left; padding-bottom: 8px;">Price</th>
                                            <th style="text-align: left; padding-bottom: 8px;">Stock</th>
                                            <th style="text-align: left; padding-bottom: 8px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="editVariantTableBody"></tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Simple Stock Section (Conditional) --}}
                        <div id="editSimpleSection" style="display: none;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                <div>
                                    <label
                                        style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Price</label>
                                    <input type="number" id="editSimplePrice" name="product_price" step="0.01"
                                        required
                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                                </div>
                                <div>
                                    <label
                                        style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Stock</label>
                                    <input type="number" id="editSimpleStock" name="stocks" required
                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding: 20px 24px; border-top: 1px solid #eee; text-align: right; background: #fcfcfc;">
                <button type="button" class="quick-action-btn" onclick="closeModal('editModal')"
                    style="height: auto; padding: 12px 24px; margin-right: 12px;">Cancel</button>
                <button type="submit" class="quick-action-btn primary-btn"
                    style="height: auto; padding: 12px 32px; font-weight: 600;">Save Changes</button>
            </div>
        </form>
    </div>

    {{-- ===== ADD PRODUCT MODAL ===== --}}
    <div id="addModal"
        style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2001; background: white; width: 95%; max-width: 900px; border-radius: 20px; box-shadow: 0 25px 50px rgba(0,0,0,0.3); overflow: hidden; animation: modalFadeIn 0.3s ease;">
        <form id="addProductForm" action="{{ route('admin.inventory.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div
                style="padding: 20px 24px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; color: var(--primary);">Add New Product</h3>
                <button type="button" onclick="closeModal('addModal')"
                    style="background: none; border: none; font-size: 24px; cursor: pointer; color: #999;">&times;</button>
            </div>

            <div style="padding: 24px; max-height: 75vh; overflow-y: auto;">
                <div class="modal-grid">

                    {{-- Left Side: Basic Info --}}
                    <div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Product
                                Name</label>
                            <input type="text" name="product_name"
                                style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;"
                                placeholder="Enter product name" required>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label
                                style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Description</label>
                            <textarea name="product_description" rows="4"
                                style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; resize: vertical;"
                                placeholder="Enter product description"></textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                            <div>
                                <label
                                    style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Category</label>
                                <select name="category_id" id="addCategorySelect"
                                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;"
                                    required onchange="handleCategoryChange(this)">
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="uniformTypeSection">
                                <label
                                    style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Uniform
                                    Type</label>
                                <select name="uniform_category_id" id="addUniformType"
                                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                                    @foreach ($uniform_categories as $ucat)
                                        <option value="{{ $ucat->id }}">{{ $ucat->uniform_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="addGenderSection" style="margin-top: 20px;">
                                <label
                                    style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Gender</label>
                                <select name="gender" id="addGenderSelect"
                                    style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Unisex" selected>Unisex</option>
                                </select>
                            </div>
                        </div>

                        <div style="margin-top: 16px; display: none;" id="addIsUniformSection">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" name="is_emailable" id="addIsUniform"
                                    style="width: 18px; height: 18px;">
                                <span style="font-weight: 600; color: #333;">This product has customization
                                    sizes?</span>
                            </label>
                        </div>

                        <div style="margin-top: 24px;" id="hasVariantSection">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" name="has_variant" id="addHasVariant"
                                    style="width: 18px; height: 18px;" onchange="toggleAddVariantSection(this)">
                                <span style="font-weight: 600; color: #333;">This product has variants (Sizes)</span>
                            </label>
                        </div>
                    </div>

                    {{-- Right Side: Images & Inventory --}}
                    <div>
                        <div style="margin-bottom: 24px;">
                            <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Product
                                Images</label>
                            <div
                                style="border: 2px dashed #ddd; padding: 20px; border-radius: 12px; text-align: center; position: relative;">
                                <input type="file" id="addImageInput" name="product_images[]" multiple
                                    accept="image/*"
                                    style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer;"
                                    onchange="previewAddImages(event)">
                                <i class="fas fa-cloud-upload-alt"
                                    style="font-size: 32px; color: var(--primary); margin-bottom: 8px;"></i>
                                <p style="margin: 0; font-size: 13px; color: #666;">Click to upload or drag and drop
                                    multiple images</p>
                            </div>
                            <div id="addImagePreviews"
                                style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 16px;"></div>
                        </div>

                        {{-- Variant Section (Dynamic) --}}
                        <div id="addVariantSection" style="display: none;">
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                <label style="display: block; font-weight: 600; color: #333;">Variants (Sizes)</label>
                                <button type="button" onclick="addVariantRow()" class="quick-action-btn primary-btn"
                                    style="height: auto; padding: 4px 10px; font-size: 12px;">
                                    <i class="fas fa-plus"></i> Add Size
                                </button>
                            </div>
                            <div
                                style="background: #f9f9f9; padding: 16px; border-radius: 12px; border: 1px solid #eee;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <thead style="font-size: 12px; color: #999; text-transform: uppercase;">
                                        <tr>
                                            <th style="text-align: left; padding-bottom: 8px;">Size</th>
                                            <th style="text-align: left; padding-bottom: 8px;">Price</th>
                                            <th style="text-align: left; padding-bottom: 8px;">Stock</th>
                                            <th style="text-align: left; padding-bottom: 8px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="addVariantTableBody">
                                        {{-- Rows added via JS --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Simple Stock Section --}}
                        <div id="addSimpleSection">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                <div>
                                    <label
                                        style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Price</label>
                                    <input type="number" name="product_price" step="0.01" placeholder="0.00"
                                        required
                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                                </div>
                                <div>
                                    <label
                                        style="display: block; font-weight: 600; margin-bottom: 8px; color: #333;">Stock</label>
                                    <input type="number" name="stocks" placeholder="0" required
                                        style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding: 20px 24px; border-top: 1px solid #eee; text-align: right; background: #fcfcfc;">
                <button type="button" class="quick-action-btn" onclick="closeModal('addModal')"
                    style="height: auto; padding: 12px 24px; margin-right: 12px;">Cancel</button>
                <button type="submit" class="quick-action-btn primary-btn"
                    style="height: auto; padding: 12px 32px; font-weight: 600;">Save Product</button>
            </div>
        </form>
    </div>

    <style>
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -48%) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        #productModal::-webkit-scrollbar,
        #editModal::-webkit-scrollbar {
            width: 6px;
        }

        #productModal::-webkit-scrollbar-thumb,
        #editModal::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 3px;
        }

        /* Responsive Modal Grid */
        .modal-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .view-grid {
            grid-template-columns: 1fr 1.5fr;
            gap: 0;
        }

        @media (max-width: 768px) {
            .modal-grid {
                grid-template-columns: 1fr !important;
                gap: 16px !important;
            }

            .modal-left-col {
                border-right: none !important;
                border-bottom: 1px solid #eee !important;
            }
        }

        .image-preview-item {
            position: relative;
            width: 80px;
            height: 80px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #eee;
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-remove-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            width: 20px;
            height: 20px;
            background: rgba(255, 0, 0, 0.8);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Define Toast mixin
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

        // Check for session messages
        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif

        // ===== SHARED UI LOGIC =====
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const modalOverlay = document.getElementById('modalOverlay');
        const allVariants = @json($variants);

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

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            modalOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        document.getElementById('mobileMenuToggle').addEventListener('click', () => {
            sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
        });

        overlay.addEventListener('click', closeSidebar);
        modalOverlay.addEventListener('click', () => {
            closeModal('productModal');
            closeModal('editModal');
            closeModal('addModal');
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 1024) closeSidebar();
        });

        // ===== VIEW MODAL LOGIC =====
        function showProductDetails(product) {
            const modal = document.getElementById('productModal');
            document.getElementById('modalProductName').textContent = product.product_name;
            document.getElementById('modalDescription').textContent = product.product_description ||
                'No description provided.';
            document.getElementById('modalCategory').textContent = product.category_name;
            document.getElementById('modalType').textContent = product.uniform_name || 'General Product';

            const genderSection = document.getElementById('modalGenderSection');
            if (product.category_name === 'Uniforms') {
                genderSection.style.display = 'block';
                document.getElementById('modalGender').textContent = product.gender || 'Unisex';
            } else {
                genderSection.style.display = 'none';
            }

            const images = product.product_image ? JSON.parse(product.product_image) : [];
            const mainImg = document.getElementById('modalMainImage');
            const thumbContainer = document.getElementById('modalThumbnails');

            mainImg.src = images.length > 0 ? "{{ asset('') }}" + images[0] : "{{ asset('favicon.png') }}";
            thumbContainer.innerHTML = '';

            if (images.length > 1) {
                images.forEach((img, idx) => {
                    const thumb = document.createElement('img');
                    thumb.src = "{{ asset('') }}" + img;
                    thumb.style.cssText =
                        'width: 50px; height: 50px; object-fit: cover; border-radius: 6px; cursor: pointer; border: 2px solid ' +
                        (idx === 0 ? 'var(--primary)' : 'transparent');
                    thumb.onclick = () => {
                        mainImg.src = thumb.src;
                        Array.from(thumbContainer.children).forEach(c => c.style.borderColor = 'transparent');
                        thumb.style.borderColor = 'var(--primary)';
                    };
                    thumbContainer.appendChild(thumb);
                });
            }

            const variantSection = document.getElementById('variantSection');
            const simpleSection = document.getElementById('simpleStockSection');
            const tableBody = document.getElementById('modalVariantTableBody');

            if (product.has_variant) {
                variantSection.style.display = 'block';
                simpleSection.style.display = 'none';
                tableBody.innerHTML = '';
                allVariants.filter(v => v.product_id === product.id).forEach(v => {
                    const row = document.createElement('tr');
                    row.style.borderBottom = '1px solid #eee';
                    row.innerHTML =
                        `<td style="padding: 10px; font-weight: 600;">${v.size}</td><td style="padding: 10px;">₱${parseFloat(v.price).toLocaleString(undefined, {minimumFractionDigits: 2})}</td><td style="padding: 10px;"><span class="status-badge ${v.stocks <= 10 ? 'cancelled' : 'completed'}" style="padding: 2px 8px; font-size: 11px;">${v.stocks}</span></td>`;
                    tableBody.appendChild(row);
                });
            } else {
                variantSection.style.display = 'none';
                simpleSection.style.display = 'block';
                document.getElementById('modalSimplePrice').textContent = '₱' + parseFloat(product.product_price)
                    .toLocaleString(undefined, {
                        minimumFractionDigits: 2
                    });
                document.getElementById('modalSimpleStock').textContent = product.stocks + ' units';
            }

            modal.style.display = 'block';
            modalOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // ===== EDIT MODAL LOGIC =====
        let selectedFiles = []; // To track new files
        let existingImages = []; // To track images from DB

        function showEditModal(product) {
            const modal = document.getElementById('editModal');
            document.getElementById('editName').value = product.product_name;
            document.getElementById('editDescription').value = product.product_description;
            const categorySelect = document.getElementById('editCategorySelect');
            const uniformSelect = document.getElementById('editUniformType');

            categorySelect.value = product.category_id;
            document.getElementById('editCategoryIdHidden').value = product.category_id;
            document.getElementById('editCategoryDisplay').textContent = product.category_name;
            uniformSelect.value = product.uniform_category_id || '';

            // Set Uniform Type Section visibility
            const uniformSection = document.getElementById('editUniformTypeSection');
            const genderSection = document.getElementById('editGenderSection');
            if (product.category_name === 'School Supplies' || product.category_name === 'Books') {
                uniformSection.style.display = 'none';
                genderSection.style.display = 'none';
                uniformSelect.value = '';
            } else {
                uniformSection.style.display = 'block';
                genderSection.style.display = 'block';
                document.getElementById('editGenderSelect').value = product.gender || 'Unisex';
            }

            // Set Form Action
            document.getElementById('editProductForm').action = `{{ url('/admin/inventory') }}/${product.id}`;

            // Handle Images
            existingImages = product.product_image ? JSON.parse(product.product_image) : [];
            selectedFiles = [];
            renderImagePreviews();

            // Handle Variants vs Simple
            const hasVariantCheckbox = document.getElementById('editHasVariant');
            hasVariantCheckbox.checked = !!product.has_variant;

            const isUniformCheckbox = document.getElementById('editIsUniform');
            isUniformCheckbox.checked = !!product.is_emailable;

            // Trigger visibility for variants checkbox itself
            if (product.category_name === 'Uniforms') {
                document.getElementById('editHasVariantSection').style.display = 'block';
            } else {
                document.getElementById('editHasVariantSection').style.display = 'none';
                hasVariantCheckbox.checked = false;
            }

            const tableBody = document.getElementById('editVariantTableBody');
            tableBody.innerHTML = '';

            if (product.has_variant) {
                allVariants.filter(v => v.product_id === product.id).forEach(v => {
                    addEditVariantRow(v);
                });
            } else {
                document.getElementById('editSimplePrice').value = product.product_price;
                document.getElementById('editSimpleStock').value = product.stocks;
            }

            toggleEditVariantSection(hasVariantCheckbox);

            modal.style.display = 'block';
            modalOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function previewNewImages(event) {
            const files = Array.from(event.target.files);
            if (files.length === 0) return;

            selectedFiles = [...selectedFiles, ...files];
            renderImagePreviews();

            // We don't reset event.target.value here anymore to ensure the files persist 
            // until they are replaced by the DataTransfer object in renderImagePreviews
        }

        function renderImagePreviews() {
            const container = document.getElementById('editImagePreviews');
            container.innerHTML = '';

            // Render Existing
            existingImages.forEach((img, idx) => {
                const item = document.createElement('div');
                item.className = 'image-preview-item';
                item.innerHTML = `
                    <img src="{{ asset('') }}${img}" alt="">
                    <button type="button" class="image-remove-btn" onclick="removeExistingImage(${idx})">&times;</button>
                    <input type="hidden" name="existing_images[]" value="${img}">
                `;
                container.appendChild(item);
            });

            // Render New
            selectedFiles.forEach((file, idx) => {
                const reader = new FileReader();
                const item = document.createElement('div');
                item.className = 'image-preview-item';
                reader.onload = (e) => {
                    item.innerHTML = `
                        <img src="${e.target.result}" alt="">
                        <button type="button" class="image-remove-btn" onclick="removeNewFile(${idx})">&times;</button>
                    `;
                };
                reader.readAsDataURL(file);
                container.appendChild(item);
            });

            // Update a hidden field with selected files using DataTransfer
            const dataTransfer = new DataTransfer();
            selectedFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById('editImageInput').files = dataTransfer.files;
        }

        function removeExistingImage(index) {
            existingImages.splice(index, 1);
            renderImagePreviews();
        }

        function removeNewFile(index) {
            selectedFiles.splice(index, 1);
            renderImagePreviews();
        }

        function toggleEditVariantSection(checkbox) {
            const variantSection = document.getElementById('editVariantSection');
            const simpleSection = document.getElementById('editSimpleSection');
            const isUniformSection = document.getElementById('editIsUniformSection');

            if (checkbox.checked) {
                variantSection.style.display = 'block';
                simpleSection.style.display = 'none';
                isUniformSection.style.display = 'none';
                if (document.getElementById('editVariantTableBody').children.length === 0) {
                    addEditVariantRow();
                }
                variantSection.querySelectorAll('input').forEach(i => i.disabled = false);
                simpleSection.querySelectorAll('input').forEach(i => i.disabled = true);
            } else {
                variantSection.style.display = 'none';
                simpleSection.style.display = 'block';

                // Automatic logic based on category
                const categoryName = document.getElementById('editCategoryDisplay').textContent;
                const isUniformCheckbox = document.getElementById('editIsUniform');

                if (categoryName === 'Uniforms') {
                    isUniformSection.style.display = 'block';
                    // Respect current value or default to false
                } else {
                    isUniformSection.style.display = 'none';
                    isUniformCheckbox.checked = false;
                }

                variantSection.querySelectorAll('input').forEach(i => i.disabled = true);
                simpleSection.querySelectorAll('input').forEach(i => i.disabled = false);
            }
        }

        let editVariantRowIndex = 0;

        function addEditVariantRow(existingVariant = null) {
            const tableBody = document.getElementById('editVariantTableBody');
            const row = document.createElement('tr');

            const size = existingVariant ? existingVariant.size : '';
            const price = existingVariant ? existingVariant.price : '';
            const stocks = existingVariant ? existingVariant.stocks : '';
            const vId = existingVariant ? existingVariant.id : 'new_' + editVariantRowIndex;

            row.innerHTML = `
                <td style="padding: 8px 4px 8px 0;">
                    <input type="text" name="variants[${vId}][size]" value="${size}" placeholder="Size" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px;">
                </td>
                <td style="padding: 8px 4px;">
                    <input type="number" name="variants[${vId}][price]" value="${price}" placeholder="0.00" step="0.01" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px;">
                </td>
                <td style="padding: 8px 4px;">
                    <input type="number" name="variants[${vId}][stocks]" value="${stocks}" placeholder="0" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px;">
                </td>
                <td style="padding: 8px 0; text-align: right;">
                    <button type="button" onclick="this.closest('tr').remove()" style="background: none; border: none; color: #ff4d4d; cursor: pointer; font-size: 16px;"><i class="fas fa-times-circle"></i></button>
                </td>
            `;
            tableBody.appendChild(row);
            editVariantRowIndex++;
        }

        // ===== ADD MODAL LOGIC =====
        let addSelectedFiles = [];

        document.getElementById('addProductBtn').addEventListener('click', () => {
            const modal = document.getElementById('addModal');
            document.getElementById('addProductForm').reset();
            document.getElementById('addImagePreviews').innerHTML = '';
            document.getElementById('addVariantTableBody').innerHTML = '';
            addSelectedFiles = [];
            toggleAddVariantSection(document.getElementById('addHasVariant'));

            modal.style.display = 'block';
            modalOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        function toggleAddVariantSection(checkbox) {
            const variantSection = document.getElementById('addVariantSection');
            const simpleSection = document.getElementById('addSimpleSection');
            const isUniformSection = document.getElementById('addIsUniformSection');
            const tableBody = document.getElementById('addVariantTableBody');

            if (checkbox.checked) {
                variantSection.style.display = 'block';
                simpleSection.style.display = 'none';
                isUniformSection.style.display = 'none';
                if (tableBody.children.length === 0) {
                    addVariantRow(); // Add one default row
                }
                variantSection.querySelectorAll('input').forEach(i => i.disabled = false);
                simpleSection.querySelectorAll('input').forEach(i => i.disabled = true);
            } else {
                variantSection.style.display = 'none';
                simpleSection.style.display = 'block';

                // Automatic logic based on category
                const categorySelect = document.getElementById('addCategorySelect');
                const selectedText = categorySelect.options[categorySelect.selectedIndex].text;
                const isUniformCheckbox = document.getElementById('addIsUniform');

                if (selectedText === 'Uniforms') {
                    isUniformSection.style.display = 'block';
                    // Default to unchecked as requested
                    isUniformCheckbox.checked = false;
                } else {
                    isUniformSection.style.display = 'none';
                    isUniformCheckbox.checked = false;
                }

                variantSection.querySelectorAll('input').forEach(i => i.disabled = true);
                simpleSection.querySelectorAll('input').forEach(i => i.disabled = false);
            }
        }

        function handleCategoryChange(select) {
            const selectedText = select.options[select.selectedIndex].text;
            const uniformSection = document.getElementById('uniformTypeSection');
            const genderSection = document.getElementById('addGenderSection');
            const variantSectionWrap = document.getElementById('hasVariantSection');
            const hasVariantCheckbox = document.getElementById('addHasVariant');
            const uniformSelect = document.getElementById('addUniformType');

            if (selectedText === 'School Supplies' || selectedText === 'Books') {
                uniformSection.style.display = 'none';
                genderSection.style.display = 'none';
                variantSectionWrap.style.display = 'none';
                hasVariantCheckbox.checked = false;
                uniformSelect.value = '';
            } else {
                uniformSection.style.display = 'block';
                genderSection.style.display = 'block';
                variantSectionWrap.style.display = 'block';
            }

            // Refresh variant/uniform sections visibility
            toggleAddVariantSection(hasVariantCheckbox);
        }

        function handleEditCategoryChange(select) {
            const selectedText = select.options[select.selectedIndex].text;
            const uniformSection = document.getElementById('editUniformTypeSection');
            const genderSection = document.getElementById('editGenderSection');
            if (selectedText === 'School Supplies' || selectedText === 'Books') {
                uniformSection.style.display = 'none';
                genderSection.style.display = 'none';
                document.getElementById('editUniformType').value = '';
            } else {
                uniformSection.style.display = 'block';
                genderSection.style.display = 'block';
            }
        }

        let variantRowIndex = 0;

        function addVariantRow() {
            const tableBody = document.getElementById('addVariantTableBody');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td style="padding: 8px 4px 8px 0;"><input type="text" name="variants[${variantRowIndex}][size]" placeholder="S, M, L..." required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px;"></td>
                <td style="padding: 8px 4px;"><input type="number" name="variants[${variantRowIndex}][price]" placeholder="0.00" step="0.01" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px;"></td>
                <td style="padding: 8px 4px;"><input type="number" name="variants[${variantRowIndex}][stocks]" placeholder="0" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px;"></td>
                <td style="padding: 8px 0; text-align: right;"><button type="button" onclick="this.closest('tr').remove()" style="background: none; border: none; color: #ff4d4d; cursor: pointer; font-size: 16px;"><i class="fas fa-times-circle"></i></button></td>
            `;
            tableBody.appendChild(row);
            variantRowIndex++;
        }

        function previewAddImages(event) {
            const files = Array.from(event.target.files);
            if (files.length === 0) return;
            addSelectedFiles = [...addSelectedFiles, ...files];
            renderAddImagePreviews();
        }

        function renderAddImagePreviews() {
            const container = document.getElementById('addImagePreviews');
            container.innerHTML = '';

            addSelectedFiles.forEach((file, idx) => {
                const reader = new FileReader();
                const item = document.createElement('div');
                item.className = 'image-preview-item';
                reader.onload = (e) => {
                    item.innerHTML = `
                        <img src="${e.target.result}" alt="">
                        <button type="button" class="image-remove-btn" onclick="removeAddFile(${idx})">&times;</button>
                    `;
                };
                reader.readAsDataURL(file);
                container.appendChild(item);
            });

            const dataTransfer = new DataTransfer();
            addSelectedFiles.forEach(file => dataTransfer.items.add(file));
            document.getElementById('addImageInput').files = dataTransfer.files;
        }

        function removeAddFile(index) {
            addSelectedFiles.splice(index, 1);
            renderAddImagePreviews();
        }

        // ===== DELETE MODAL LOGIC =====
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This product and all its variants will be permanently removed!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff4d4d',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteProductForm');
                    form.action = `{{ url('/admin/inventory') }}/${id}`;
                    form.submit();
                }
            });
        }
    </script>
</body>

</html>
