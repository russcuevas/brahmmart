<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brahmmart - Student Accounts</title>
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

        .student-card {
            background: #fff;
            padding: 24px;
            border-radius: 20px;
            border: 1.5px solid #f0f0f0;
            display: flex;
            flex-direction: column;
            gap: 16px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .student-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-color: var(--primary);
        }

        .student-header {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .student-avatar {
            width: 50px;
            height: 50px;
            background: rgba(var(--primary-rgb), 0.05);
            color: var(--primary);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 700;
        }

        .student-info h4 {
            margin: 0;
            font-size: 15px;
            color: #333;
        }

        .student-info p {
            margin: 2px 0 0;
            font-size: 12px;
            color: #888;
        }

        .student-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            padding-top: 12px;
            border-top: 1px solid #f8f8f8;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .meta-label {
            font-size: 10px;
            text-transform: uppercase;
            color: #aaa;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .meta-value {
            font-size: 13px;
            color: #555;
            font-weight: 500;
        }

        .student-actions {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }

        .action-btn {
            flex: 1;
            height: 36px;
            border-radius: 10px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 13px;
            font-weight: 600;
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

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #555;
            margin-bottom: 6px;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #eee;
            border-radius: 10px;
            font-family: inherit;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 4px rgba(var(--primary-rgb), 0.1);
        }

        /* Sidebar Clickability & Responsive Fix */
        .sidebar {
            z-index: 1001 !important;
            position: fixed;
            pointer-events: auto !important;
            transition: all 0.3s ease;
        }

        @media (max-width: 1024px) {
            .sidebar {
                left: -270px;
            }

            .sidebar.open {
                left: 0 !important;
            }
        }

        .main-content {
            z-index: 1;
            position: relative;
        }

        .sidebar-overlay {
            z-index: 1000;
        }

        .sidebar-overlay.active {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
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

                <a href="{{ route('admin.students.page') }}"
                    class="sidebar-nav-item {{ request()->routeIs('admin.students.page') ? 'active' : '' }}"
                    id="nav-students">
                    <i class="fas fa-user-graduate"></i>
                    Students
                </a>

                <a href="#" class="sidebar-nav-item" id="nav-id-scheduling">
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

        <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <button class="mobile-menu-toggle" id="mobileMenuToggle"><i class="fas fa-bars"></i></button>
                    <div class="header-greeting">
                        <h1>Student Accounts</h1>
                        <p>Manage registered student users</p>
                    </div>
                </div>
            </header>

            <div class="page-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <button class="quick-action-btn primary-btn" onclick="openAddModal()">
                        <i class="fas fa-plus-circle"></i> Add New Student
                    </button>
                    <div style="position: relative; width: 300px;">
                        <i class="fas fa-search"
                            style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #aaa;"></i>
                        <input type="text" id="studentSearch" placeholder="Search students..." class="form-input"
                            style="padding-left: 40px;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 24px;"
                    id="studentsGrid">
                    @foreach ($students as $student)
                        <div class="student-card" data-name="{{ strtolower($student->fullname) }}"
                            data-email="{{ strtolower($student->email) }}">
                            <div class="student-header">
                                <div class="student-avatar">
                                    {{ strtoupper(substr($student->fullname, 0, 1)) }}
                                </div>
                                <div class="student-info">
                                    <h4>{{ $student->fullname }}</h4>
                                    <p>{{ $student->email }}</p>
                                </div>
                            </div>
                            <div class="student-meta">
                                <div class="meta-item">
                                    <span class="meta-label">Program</span>
                                    <span class="meta-value">{{ $student->program ?? 'N/A' }}</span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Year Level</span>
                                    <span class="meta-value">{{ $student->grade_year ?? 'N/A' }}</span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Phone</span>
                                    <span class="meta-value">{{ $student->phone_number }}</span>
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Gender</span>
                                    <span class="meta-value">{{ $student->gender }}</span>
                                </div>
                            </div>
                            <div class="student-actions">
                                <button class="action-btn edit-btn"
                                    onclick='openEditModal(@json($student))'>
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="action-btn delete-btn" onclick="confirmDelete({{ $student->id }})">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>

    <style>
        /* Registration-style Form Enhancements */
        .modal-section {
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #999;
            font-weight: 800;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: var(--primary);
            opacity: 0.5;
        }

        .input-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 600px) {
            .input-row {
                grid-template-columns: 1fr;
            }
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #eee;
            border-radius: 12px;
            font-family: inherit;
            font-size: 14px;
            background: #fafafa;
            transition: all 0.2s;
        }

        .form-input:focus,
        .form-select:focus {
            background: #fff;
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 4px rgba(var(--primary-rgb), 0.1);
        }

        :root {
            --primary-rgb: 117, 39, 56;
            --accent-rgb: 255, 77, 77;
        }

        /* ... existing styles ... */
    </style>
    </head>
    <!-- ... existing body ... -->

    {{-- Add Student Modal --}}
    <div id="modalOverlay"
        style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 2000; backdrop-filter: blur(2px);"
        onclick="closeAllModals()"></div>

    <div id="addModal"
        style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2001; background: #fff; width: 95%; max-width: 600px; border-radius: 24px; box-shadow: 0 40px 100px rgba(0,0,0,0.4); overflow: hidden; animation: modalFadeIn 0.3s ease;">
        <form action="{{ route('admin.students.store') }}" method="POST">
            @csrf
            <div
                style="padding: 24px 32px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; background: #fff;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div
                        style="width: 45px; height: 45px; background: rgba(var(--primary-rgb), 0.1); color: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; color: #333; font-size: 1.1rem; font-weight: 700;">Add New Student</h3>
                        <p style="margin: 2px 0 0; font-size: 12px; color: #888;">Create a new student account</p>
                    </div>
                </div>
                <button type="button" onclick="closeAllModals()"
                    style="background: #f5f5f5; border: none; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; color: #999;">&times;</button>
            </div>

            <div style="padding: 32px; max-height: 70vh; overflow-y: auto;">
                <!-- Name Section -->
                <div class="modal-section">
                    <h2 class="section-title"><i class="fas fa-user"></i> Full Name</h2>
                    <input type="text" name="fullname" placeholder="Juan Dela Cruz" required class="form-input">
                </div>

                <!-- Gender Section -->
                <div class="modal-section">
                    <h2 class="section-title"><i class="fas fa-venus-mars"></i> Gender</h2>
                    <select name="gender" required class="form-select">
                        <option value="" disabled selected>Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <!-- Contact Section -->
                <div class="modal-section">
                    <h2 class="section-title"><i class="fas fa-address-book"></i> Contact Information</h2>
                    <div class="input-row">
                        <input type="text" name="phone_number" placeholder="Phone number" required
                            class="form-input">
                        <input type="email" name="email" placeholder="Email Address" required
                            class="form-input">
                    </div>
                </div>

                <!-- Address Section -->
                <div class="modal-section">
                    <h2 class="section-title"><i class="fas fa-map-marker-alt"></i> Address</h2>
                    <input type="text" name="address" placeholder="Full Address" required class="form-input">
                </div>

                <!-- Password Section -->
                <div class="modal-section">
                    <h2 class="section-title"><i class="fas fa-lock"></i> Password</h2>
                    <input type="password" name="password" placeholder="Password (Min. 8 characters)" required
                        class="form-input">
                </div>

                <!-- Education Section -->
                <div class="modal-section">
                    <h2 class="section-title"><i class="fas fa-university"></i> Department</h2>
                    <select name="department" id="addDepartment" required class="form-select">
                        <option value="" disabled selected>Select department</option>
                        <option value="junior high school">Junior High School</option>
                        <option value="shs">Senior High School (SHS)</option>
                        <option value="college">College</option>
                    </select>
                </div>

                <div class="modal-section">
                    <h2 class="section-title"><i class="fas fa-graduation-cap"></i> Academic Details</h2>
                    <div class="input-row">
                        <select name="grade_year" id="addGradeLevel" required class="form-select">
                            <option value="" disabled selected>Grade/Level</option>
                        </select>
                        <div id="addProgramWrapper" style="display: none;">
                            <select name="program" id="addProgram" class="form-select">
                                <option value="" disabled selected>Program</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding: 24px 32px; border-top: 1px solid #f0f0f0; text-align: right; background: #fafafa;">
                <button type="button" onclick="closeAllModals()" class="action-btn"
                    style="background: #fff; border: 1px solid #eee; color: #666; width: auto; padding: 0 24px; display: inline-flex; margin-right: 8px;">Cancel</button>
                <button type="submit" class="action-btn"
                    style="background: var(--primary); color: #fff; width: auto; padding: 0 32px; display: inline-flex;">Create
                    Account</button>
            </div>
        </form>
    </div>

    {{-- Edit Student Modal --}}
    <div id="editModal"
        style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2001; background: #fff; width: 95%; max-width: 600px; border-radius: 24px; box-shadow: 0 40px 100px rgba(0,0,0,0.4); overflow: hidden; animation: modalFadeIn 0.3s ease;">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div
                style="padding: 24px 32px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; background: #fff;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div
                        style="width: 45px; height: 45px; background: rgba(0,123,255,0.1); color: #007bff; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div>
                        <h3 style="margin: 0; color: #333; font-size: 1.1rem; font-weight: 700;">Edit Student</h3>
                        <p style="margin: 2px 0 0; font-size: 12px; color: #888;">Modify account information</p>
                    </div>
                </div>
                <button type="button" onclick="closeAllModals()"
                    style="background: #f5f5f5; border: none; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; color: #999;">&times;</button>
            </div>

            <div style="padding: 32px; max-height: 70vh; overflow-y: auto;">
                <div class="modal-section">
                    <h2 class="section-title"><i class="fas fa-user"></i> Full Name</h2>
                    <input type="text" name="fullname" id="editFullname" required class="form-input">
                </div>

                <div class="modal-section">
                    <h2 class="section-title"><i class="fas fa-venus-mars"></i> Gender</h2>
                    <select name="gender" id="editGender" required class="form-select">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="modal-section">
                    <h2 class="section-title"><i class="fas fa-address-book"></i> Contact Information</h2>
                    <div class="input-row">
                        <input type="text" name="phone_number" id="editPhone" required class="form-input">
                        <input type="email" name="email" id="editEmail" required class="form-input">
                    </div>
                </div>

                <div class="modal-section">
                    <h2 class="section-title"><i class="fas fa-map-marker-alt"></i> Address</h2>
                    <input type="text" name="address" id="editAddress" required class="form-input">
                </div>

                <div class="modal-section">
                    <h2 class="section-title"><i class="fas fa-lock"></i> New Password (Optional)</h2>
                    <input type="password" name="password" placeholder="Leave blank to keep current"
                        class="form-input">
                </div>

                <div class="modal-section">
                    <h2 class="section-title"><i class="fas fa-university"></i> Department</h2>
                    <select name="department" id="editDepartment" required class="form-select">
                        <option value="junior high school">Junior High School</option>
                        <option value="shs">Senior High School (SHS)</option>
                        <option value="college">College</option>
                    </select>
                </div>

                <div class="modal-section">
                    <h2 class="section-title"><i class="fas fa-graduation-cap"></i> Academic Details</h2>
                    <div class="input-row">
                        <select name="grade_year" id="editGradeLevel" required class="form-select">
                            <option value="" disabled>Grade/Level</option>
                        </select>
                        <div id="editProgramWrapper">
                            <select name="program" id="editProgram" class="form-select">
                                <option value="" disabled>Program</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding: 24px 32px; border-top: 1px solid #f0f0f0; text-align: right; background: #fafafa;">
                <button type="button" onclick="closeAllModals()" class="action-btn"
                    style="background: #fff; border: 1px solid #eee; color: #666; width: auto; padding: 0 24px; display: inline-flex; margin-right: 8px;">Cancel</button>
                <button type="submit" class="action-btn"
                    style="background: #007bff; color: #fff; width: auto; padding: 0 32px; display: inline-flex;">Update
                    Account</button>
            </div>
        </form>
    </div>

    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        // ===== SEARCH LOGIC =====
        document.getElementById('studentSearch').addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            document.querySelectorAll('.student-card').forEach(card => {
                const name = card.dataset.name;
                const email = card.dataset.email;
                if (name.includes(query) || email.includes(query)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // ===== DYNAMIC ACADEMIC SELECTS =====
        const academicOptions = {
            'junior high school': {
                levels: ['1st Year', '2nd Year', '3rd Year', '4th Year'],
                programs: [],
                showProgram: false
            },
            'shs': {
                levels: ['Grade 11', 'Grade 12'],
                programs: [
                    'Humanities and Social Sciences (HUMSS)',
                    'Science, Technology, Engineering, and Mathematics (STEM)',
                    'Accountancy, Business, and Management (ABM)'
                ],
                showProgram: true
            },
            'college': {
                levels: ['1st Year', '2nd Year', '3rd Year', '4th Year'],
                programs: ['Bachelor of Science in Information Technology'],
                showProgram: true
            }
        };

        function setupAcademicSync(deptId, gradeId, progId, progWrapperId) {
            const deptSelect = document.getElementById(deptId);
            const gradeSelect = document.getElementById(gradeId);
            const progSelect = document.getElementById(progId);
            const progWrapper = document.getElementById(progWrapperId);

            deptSelect.addEventListener('change', function() {
                const selected = this.value;
                const config = academicOptions[selected];
                if (!config) return;

                // Update Levels
                gradeSelect.innerHTML = '<option value="" disabled selected>Grade/Level</option>';
                config.levels.forEach(level => {
                    const opt = document.createElement('option');
                    opt.value = level;
                    opt.textContent = level;
                    gradeSelect.appendChild(opt);
                });

                // Update Programs
                if (config.showProgram) {
                    progWrapper.style.display = 'block';
                    progSelect.required = true;
                    progSelect.innerHTML = '<option value="" disabled selected>Program</option>';
                    config.programs.forEach(program => {
                        const opt = document.createElement('option');
                        opt.value = program;
                        opt.textContent = program;
                        progSelect.appendChild(opt);
                    });
                } else {
                    progWrapper.style.display = 'none';
                    progSelect.required = false;
                    progSelect.value = '';
                }
            });
        }

        // Initialize sync for both modals
        setupAcademicSync('addDepartment', 'addGradeLevel', 'addProgram', 'addProgramWrapper');
        setupAcademicSync('editDepartment', 'editGradeLevel', 'editProgram', 'editProgramWrapper');

        function openAddModal() {
            document.getElementById('addModal').style.display = 'block';
            document.getElementById('modalOverlay').style.display = 'block';
        }

        function openEditModal(student) {
            document.getElementById('editForm').action = `/admin/students/${student.id}`;
            document.getElementById('editFullname').value = student.fullname;
            document.getElementById('editEmail').value = student.email;
            document.getElementById('editPhone').value = student.phone_number;
            document.getElementById('editGender').value = student.gender;
            document.getElementById('editAddress').value = student.address || '';

            // Set Department and trigger change
            const deptSelect = document.getElementById('editDepartment');
            deptSelect.value = student.department || '';
            deptSelect.dispatchEvent(new Event('change'));

            // Set Level and Program after sync
            setTimeout(() => {
                document.getElementById('editGradeLevel').value = student.grade_year || '';
                if (student.program) {
                    document.getElementById('editProgram').value = student.program;
                }
            }, 10);

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
                title: 'Delete student?',
                text: "All order history will be affected!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#752738',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = `/admin/students/${id}`;
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
