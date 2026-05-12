<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Scheduling | Brahmmart</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/customers/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #752738;
            --secondary: #ffc107;
            --success: #28a745;
            --text-muted: #888;
            --border-color: #f0f0f0;
        }

        .step-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .step-progress {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
            padding: 0 40px;
        }

        .step-progress::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 80px;
            right: 80px;
            height: 2px;
            background: #e0e0e0;
            z-index: 1;
        }

        .progress-line {
            position: absolute;
            top: 20px;
            left: 80px;
            width: 0%;
            height: 2px;
            background: var(--primary);
            z-index: 2;
            transition: width 0.4s ease;
        }

        .step-indicator {
            position: relative;
            z-index: 3;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .step-dot {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--text-muted);
            transition: all 0.3s ease;
        }

        .step-indicator.active .step-dot {
            border-color: var(--primary);
            background: var(--primary);
            color: #fff;
            box-shadow: 0 0 0 6px rgba(117, 39, 56, 0.1);
        }

        .step-indicator.completed .step-dot {
            border-color: var(--success);
            background: var(--success);
            color: #fff;
        }

        .step-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
        }

        .step-indicator.active .step-label {
            color: var(--primary);
        }

        .step-content {
            display: none;
            animation: slideUp 0.5s ease;
        }

        .step-content.active {
            display: block;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .upload-card {
            border: 2px dashed #e0e0e0;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            background: #fafafa;
        }

        .upload-card:hover {
            border-color: var(--primary);
            background: #fff;
        }

        .upload-card i {
            font-size: 40px;
            color: var(--text-muted);
            margin-bottom: 16px;
        }

        .upload-card.has-file {
            border-style: solid;
            border-color: var(--success);
        }

        .preview-img {
            max-width: 100%;
            max-height: 400px;
            border-radius: 12px;
            margin-top: 16px;
            display: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            object-fit: contain;
        }

        .instruction-box {
            background: #fff8e1;
            border-left: 4px solid var(--secondary);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .instruction-box i {
            color: var(--secondary);
            font-size: 20px;
            margin-top: 2px;
        }

        .instruction-box h4 {
            margin: 0 0 8px;
            color: #856404;
        }

        .instruction-box p {
            margin: 0;
            font-size: 14px;
            color: #856404;
            line-height: 1.6;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 4px rgba(117, 39, 56, 0.05);
        }

        .btn-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .btn-nav {
            padding: 12px 32px;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-prev {
            background: #f5f5f5;
            color: #666;
        }

        .btn-next {
            background: var(--primary);
            color: #fff;
        }

        .btn-next:disabled {
            background: #e0e0e0;
            cursor: not-allowed;
        }

        .status-card {
            background: #fff;
            border-radius: 24px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
        }

        .status-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 24px;
        }

        .status-icon.pending {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .status-icon.approved {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .status-icon.rejected {
            background: rgba(220, 38, 38, 0.1);
            color: #dc2626;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .summary-label {
            color: #888;
            font-size: 14px;
        }

        .summary-value {
            font-weight: 600;
            color: #333;
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
                    <span>Student Panel</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="sidebar-nav-label">Main Menu</div>
                <a href="{{ route('customer.dashboard.page') }}" class="sidebar-nav-item" id="nav-dashboard">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="{{ route('customer.orders.page') }}" class="sidebar-nav-item" id="nav-orders">
                    <i class="fas fa-receipt"></i> My Orders
                </a>
                <a href="{{ route('customer.scheduling.index') }}" class="sidebar-nav-item active"
                    id="nav-id-scheduling">
                    <i class="fas fa-id-card"></i> ID Scheduling
                </a>
                <div class="sidebar-nav-label" style="margin-top: 16px;">Quick Links</div>
                <a href="{{ route('shop.page') }}" class="sidebar-nav-item">
                    <i class="fas fa-shop"></i> Shop
                </a>
                <a href="/" class="sidebar-nav-item">
                    <i class="fas fa-house"></i> Home
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-user"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    style="cursor: pointer;">
                    <div class="sidebar-user-avatar"><img style="height: 50px; width: 50px;"
                            src="{{ asset('favicon.png') }}" alt=""></div>
                    <div class="sidebar-user-info">
                        <h4>{{ Auth::guard('customer')->user()->email }}</h4>
                        <span>Logout</span>
                    </div>
                </div>
                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">@csrf
                </form>
            </div>
        </aside>

        <main class="main-content">
            <header class="top-header">
                <div class="header-left">
                    <button class="mobile-menu-toggle" id="mobileMenuToggle"><i class="fas fa-bars"></i></button>
                    <div class="header-greeting">
                        <h1>ID Scheduling</h1>
                        <p>Complete your student identity profile</p>
                    </div>
                </div>
            </header>

            <div class="page-content">
                @if ($scheduling)
                    <div class="status-card">
                        <div
                            class="status-icon {{ strtolower($scheduling->status) == 'pending' ? 'pending' : (strtolower($scheduling->status) == 'approved' ? 'approved' : 'rejected') }}">
                            <i
                                class="fas {{ strtolower($scheduling->status) == 'pending' ? 'fa-clock' : (strtolower($scheduling->status) == 'approved' ? 'fa-check-circle' : 'fa-times-circle') }}"></i>
                        </div>
                        <h2 style="margin-bottom: 8px;">Request {{ $scheduling->status }}</h2>
                        <p style="color: var(--text-muted); margin-bottom: 32px;">
                            @if (strtolower($scheduling->status) == 'pending')
                                Your ID request is currently being reviewed by the administration.
                            @elseif(strtolower($scheduling->status) == 'approved')
                                Your ID request has been approved! Pickup scheduled for:
                                <strong>{{ $scheduling->pick_up_date ? date('M d, Y h:i A', strtotime($scheduling->pick_up_date)) : 'TBA' }}</strong>
                            @else
                                Your ID request was not approved. Please check your email for the specific reason and
                                try again with the corrected information.
                            @endif
                        </p>

                        @if (strtolower($scheduling->status) == 'rejected')
                            <div style="margin-bottom: 32px;">
                                <form action="{{ route('customer.scheduling.destroy', $scheduling->id) }}"
                                    method="POST" id="reapplyForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-nav btn-next"
                                        style="margin: 0 auto; background: #752738;" onclick="confirmReapply()">
                                        <i class="fas fa-redo"></i> Request Again
                                    </button>
                                </form>
                            </div>
                        @endif

                        <div
                            style="max-width: 500px; margin: 0 auto; text-align: left; background: #fafafa; padding: 24px; border-radius: 20px;">
                            <div class="summary-item">
                                <span class="summary-label">Student No.</span>
                                <span class="summary-value">{{ $scheduling->student_no }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Guardian</span>
                                <span class="summary-value">{{ $scheduling->guardian_name }}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Guardian Contact</span>
                                <span class="summary-value">{{ $scheduling->guardian_contact_no }}</span>
                            </div>
                            <div class="summary-item" style="border-bottom: none;">
                                <span class="summary-label">Date Submitted</span>
                                <span class="summary-value">{{ $scheduling->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="step-container">
                        <div class="step-progress">
                            <div class="progress-line" id="progressLine"></div>
                            <div class="step-indicator active" data-step="1">
                                <div class="step-dot">1</div>
                                <span class="step-label">Basic Info</span>
                            </div>
                            <div class="step-indicator" data-step="2">
                                <div class="step-dot">2</div>
                                <span class="step-label">ID Photo</span>
                            </div>
                            <div class="step-indicator" data-step="3">
                                <div class="step-dot">3</div>
                                <span class="step-label">Signature</span>
                            </div>
                            <div class="step-indicator" data-step="4">
                                <div class="step-dot">4</div>
                                <span class="step-label">Finish</span>
                            </div>
                        </div>

                        <form action="{{ route('customer.scheduling.store') }}" method="POST" id="schedulingForm"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- Step 1: Basic Info -->
                            <div class="step-content active" id="step1">
                                <div class="content-card">
                                    <h3 style="margin-bottom: 24px; color: var(--primary);">Student Information</h3>
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label>School Year</label>
                                            <select name="school_year" class="form-control" required>
                                                <option value="">Select School Year</option>
                                                <option value="2023-2024">2023-2024</option>
                                                <option value="2024-2025">2024-2025</option>
                                                <option value="2025-2026">2025-2026</option>
                                                <option value="2026-2027">2026-2027</option>
                                                <option value="2027-2028">2027-2028</option>
                                                <option value="2028-2029">2028-2029</option>
                                                <option value="2029-2030">2029-2030</option>
                                                <option value="2030-2031">2030-2031</option>
                                                <option value="2031-2032">2031-2032</option>
                                                <option value="2032-2033">2032-2033</option>
                                                <option value="2033-2034">2033-2034</option>
                                                <option value="2034-2035">2034-2035</option>
                                                <option value="2035-2036">2035-2036</option>
                                                <option value="2036-2037">2036-2037</option>
                                                <option value="2037-2038">2037-2038</option>
                                                <option value="2038-2039">2038-2039</option>
                                                <option value="2039-2040">2039-2040</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Student Number</label>
                                            <input type="text" name="student_no" class="form-control"
                                                placeholder="e.g. 21-12345" required>
                                        </div>
                                    </div>
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label>Guardian Full Name</label>
                                            <input type="text" name="guardian_name" class="form-control"
                                                placeholder="Enter guardian name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Guardian Contact No.</label>
                                            <input type="text" name="guardian_contact_no" class="form-control"
                                                placeholder="e.g. 09123456789" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: ID Photo -->
                            <div class="step-content" id="step2">
                                <div class="content-card">
                                    <div class="instruction-box">
                                        <i class="fas fa-info-circle"></i>
                                        <div>
                                            <h4>Photo Instructions</h4>
                                            <p>Please upload a formal 2x2 picture. Ensure you are wearing formal attire
                                                with a <strong>plain white or pastel yellow background</strong>. Good
                                                lighting and high resolution are preferred for better ID quality.</p>
                                        </div>
                                    </div>

                                    <div class="upload-card" onclick="document.getElementById('picture_id').click()">
                                        <input type="file" name="picture_id" id="picture_id"
                                            style="display: none;" accept="image/*"
                                            onchange="previewImage(this, 'pic-preview')">
                                        <i class="fas fa-user-tie" id="pic-icon"></i>
                                        <p id="pic-text">Click to upload formal 2x2 picture</p>
                                        <img id="pic-preview" class="preview-img" alt="Preview">
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Signature -->
                            <div class="step-content" id="step3">
                                <div class="content-card">
                                    <div class="instruction-box">
                                        <i class="fas fa-pen-nib"></i>
                                        <div>
                                            <h4>Signature Instructions</h4>
                                            <p>Please sign on a <strong>clean white bond paper</strong>. Take a clear,
                                                well-lit photo of your signature and crop it to focus on the signature
                                                itself before uploading.</p>
                                        </div>
                                    </div>

                                    <div class="upload-card" onclick="document.getElementById('e_signature').click()">
                                        <input type="file" name="e_signature" id="e_signature"
                                            style="display: none;" accept="image/*"
                                            onchange="previewImage(this, 'sig-preview')">
                                        <i class="fas fa-signature" id="sig-icon"></i>
                                        <p id="sig-text">Click to upload your e-signature</p>
                                        <img id="sig-preview" class="preview-img" alt="Preview">
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4: Summary -->
                            <div class="step-content" id="step4">
                                <div class="content-card">
                                    <h3 style="margin-bottom: 24px; color: var(--primary);">Review Submission</h3>
                                    <p style="color: var(--text-muted); margin-bottom: 24px;">Please review your
                                        information before submitting. Once submitted, you cannot change these details.
                                    </p>

                                    <div style="background: #fafafa; padding: 24px; border-radius: 20px;">
                                        <div class="summary-item">
                                            <span class="summary-label">Student Name</span>
                                            <span
                                                class="summary-value">{{ Auth::guard('customer')->user()->fullname }}</span>
                                        </div>
                                        <div class="summary-item">
                                            <span class="summary-label">Student No.</span>
                                            <span id="sum-student-no" class="summary-value">-</span>
                                        </div>
                                        <div class="summary-item">
                                            <span class="summary-label">School Year</span>
                                            <span id="sum-school-year" class="summary-value">-</span>
                                        </div>
                                        <div class="summary-item">
                                            <span class="summary-label">Guardian</span>
                                            <span id="sum-guardian" class="summary-value">-</span>
                                        </div>
                                        <div class="summary-item" style="border-bottom: none;">
                                            <span class="summary-label">Guardian Contact</span>
                                            <span id="sum-guardian-contact" class="summary-value">-</span>
                                        </div>
                                    </div>

                                    <div style="display: flex; gap: 20px; margin-top: 24px;">
                                        <div style="flex: 1; text-align: center;">
                                            <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">
                                                Formal Photo</p>
                                            <div id="sum-pic-container"
                                                style="height: 250px; background: #eee; border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                                <img id="sum-pic"
                                                    style="max-width: 100%; max-height: 100%; object-fit: contain; display: none;">
                                            </div>
                                        </div>
                                        <div style="flex: 1; text-align: center;">
                                            <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 8px;">
                                                Signature</p>
                                            <div id="sum-sig-container"
                                                style="height: 150px; background: #eee; border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                                <img id="sum-sig"
                                                    style="max-width: 100%; max-height: 100%; object-fit: contain; display: none; background: #fff;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="btn-actions">
                                <button type="button" class="btn-nav btn-prev" id="btnPrev"
                                    style="visibility: hidden;">
                                    <i class="fas fa-arrow-left"></i> Previous
                                </button>
                                <button type="button" class="btn-nav btn-next" id="btnNext">
                                    Next <i class="fas fa-arrow-right"></i>
                                </button>
                                <button type="submit" class="btn-nav btn-next" id="btnSubmit"
                                    style="display: none; background: var(--success);">
                                    Submit Request <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <script>
        // Sidebar logic
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('mobileMenuToggle');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.add('open');
            overlay.classList.add('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        });

        // Multi-step logic
        let currentStep = 1;
        const totalSteps = 4;
        const btnNext = document.getElementById('btnNext');
        const btnPrev = document.getElementById('btnPrev');
        const btnSubmit = document.getElementById('btnSubmit');
        const progressLine = document.getElementById('progressLine');
        const indicators = document.querySelectorAll('.step-indicator');
        const contents = document.querySelectorAll('.step-content');

        function updateSteps() {
            // Update Indicators
            indicators.forEach(ind => {
                const step = parseInt(ind.dataset.step);
                ind.classList.remove('active', 'completed');
                if (step === currentStep) ind.classList.add('active');
                if (step < currentStep) ind.classList.add('completed');
            });

            // Update Progress Line
            const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
            progressLine.style.width = `calc(${progress}% - 80px)`;
            if (currentStep === 1) progressLine.style.width = '0%';

            // Update Content
            contents.forEach(content => content.classList.remove('active'));
            document.getElementById(`step${currentStep}`).classList.add('active');

            // Update Buttons
            btnPrev.style.visibility = currentStep === 1 ? 'hidden' : 'visible';

            if (currentStep === totalSteps) {
                btnNext.style.display = 'none';
                btnSubmit.style.display = 'flex';
                updateSummary();
            } else {
                btnNext.style.display = 'flex';
                btnSubmit.style.display = 'none';
            }
        }

        function validateStep(step) {
            if (step === 1) {
                const sy = document.querySelector('[name="school_year"]').value;
                const sn = document.querySelector('[name="student_no"]').value;
                const gn = document.querySelector('[name="guardian_name"]').value;
                const gc = document.querySelector('[name="guardian_contact_no"]').value;
                return sy && sn && gn && gc;
            }
            if (step === 2) {
                return document.getElementById('picture_id').files.length > 0;
            }
            if (step === 3) {
                return document.getElementById('e_signature').files.length > 0;
            }
            return true;
        }

        btnNext.addEventListener('click', () => {
            if (!validateStep(currentStep)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Information',
                    text: 'Please complete all fields and uploads for this step.',
                    confirmButtonColor: '#752738'
                });
                return;
            }
            if (currentStep < totalSteps) {
                currentStep++;
                updateSteps();
            }
        });

        btnPrev.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                updateSteps();
            }
        });

        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            const icon = document.getElementById(previewId === 'pic-preview' ? 'pic-icon' : 'sig-icon');
            const text = document.getElementById(previewId === 'pic-preview' ? 'pic-text' : 'sig-text');
            const card = input.parentElement;

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'inline-block';
                    icon.style.display = 'none';
                    text.style.display = 'none';
                    card.classList.add('has-file');

                    // Update summary images
                    if (previewId === 'pic-preview') {
                        const sumPic = document.getElementById('sum-pic');
                        sumPic.src = e.target.result;
                        sumPic.style.display = 'block';
                    } else {
                        const sumSig = document.getElementById('sum-sig');
                        sumSig.src = e.target.result;
                        sumSig.style.display = 'block';
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function updateSummary() {
            document.getElementById('sum-student-no').textContent = document.querySelector('[name="student_no"]').value;
            document.getElementById('sum-school-year').textContent = document.querySelector('[name="school_year"]').value;
            document.getElementById('sum-guardian').textContent = document.querySelector('[name="guardian_name"]').value;
            document.getElementById('sum-guardian-contact').textContent = document.querySelector(
                '[name="guardian_contact_no"]').value;
        }

        // Form Submission
        document.getElementById('schedulingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Submit ID Request?',
                text: "Ensure all information and photos are correct.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Submit Now'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#752738'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#752738'
            });
        @endif

        function confirmReapply() {
            Swal.fire({
                title: 'Request Again?',
                text: "This will delete your previous rejected application and allow you to submit a new one.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#752738',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Start Over'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('reapplyForm').submit();
                }
            });
        }
    </script>
</body>

</html>
