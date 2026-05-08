<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brahmmart</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/auth/register.css') }}">
</head>

<body>

    <div class="fb-container">
        <div class="top-nav">
            <a href="/"><i class="fas fa-chevron-left back-icon"></i></a>

            <div class="meta-logo">
                <img style="height: 50px; width: 50px;" src="{{ asset('favicon.png') }}" alt="">
            </div>
        </div>

        <div class="fb-content">
            <div class="header-section">
                <h1>Get started on BRAHMMART</h1>
                <p>Create an account to easily purchase your school essentials, from textbooks and uniforms to premium
                    academic supplies tailored for the University of Batangas community.</p>
            </div>

            @if ($errors->any())
                <div
                    style="background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; border: 1px solid #fecaca;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('auth.register.request') }}" method="POST">
                @csrf

                <!-- Name Section -->
                <div class="section">
                    <h2 class="section-title">Name</h2>
                    <input type="text" name="fullname" placeholder="Fullname" required>
                </div>

                <!-- Gender Section -->
                <div class="section">
                    <h2 class="section-title">Gender <i class="fas fa-question-circle title-hint"></i></h2>
                    <select name="gender" required>
                        <option value="" disabled selected>Select your gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <!-- Contact Section -->
                <div class="section">
                    <h2 class="section-title">Contact Information</h2>
                    <div class="input-row">
                        <input type="text" name="phone_number" placeholder="Phone number" required
                            value="{{ old('phone_number') }}">
                        <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                    </div>
                </div>

                <!-- Address Section -->
                <div class="section">
                    <h2 class="section-title">Address</h2>
                    <input type="text" name="address" placeholder="Address" required value="{{ old('address') }}">
                </div>

                <!-- Password Section -->
                <div class="section">
                    <h2 class="section-title">Password</h2>
                    <div class="input-row">
                        <input type="password" name="password" placeholder="Password" required>
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                    </div>
                </div>


                <!-- Department Section -->
                <div class="section">
                    <h2 class="section-title">Department</h2>
                    <select name="department" id="departmentSelect" required>
                        <option value="" disabled selected>Select your department</option>
                        <option value="junior high school"
                            {{ old('department') == 'junior high school' ? 'selected' : '' }}>Junior High School
                        </option>
                        <option value="shs" {{ old('department') == 'shs' ? 'selected' : '' }}>Senior High School
                            (SHS)</option>
                        <option value="college" {{ old('department') == 'college' ? 'selected' : '' }}>College</option>
                    </select>
                </div>

                <!-- Education Section -->
                <div class="section">
                    <h2 class="section-title">Education</h2>
                    <div class="input-row">
                        <select name="grade_level" id="gradeLevelSelect" required>
                            <option value="" disabled selected>Grade/Level</option>
                        </select>

                        <div id="programWrapper" style="flex: 1;">
                            <select name="program" id="programSelect">
                                <option value="" disabled selected>Program</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="footer-text">
                    <p>People who use our service may have uploaded your contact information to BRAHMMART. <a
                            href="#">Learn more</a>.</p>
                    <p>By tapping Submit, you agree to create an account and to BRAHMMART's <a href="#">Terms</a>,
                        <a href="#">Privacy Policy</a> and <a href="#">Cookies Policy</a>.
                    </p>
                </div>

                <button type="submit" class="submit-btn">Create Account</button>
            </form>

            <div class="footer-section">
                Already have an account? <a href="/login">Sign In</a>
            </div>
        </div>
    </div>
    <script>
        const departmentSelect = document.getElementById('departmentSelect');
        const gradeLevelSelect = document.getElementById('gradeLevelSelect');
        const programSelect = document.getElementById('programSelect');
        const programWrapper = document.getElementById('programWrapper');

        const options = {
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

        departmentSelect.addEventListener('change', function() {
            const selected = this.value;
            const config = options[selected];

            // Reset Level
            gradeLevelSelect.innerHTML = '<option value="" disabled selected>Grade/Level</option>';
            config.levels.forEach(level => {
                const opt = document.createElement('option');
                opt.value = level;
                opt.textContent = level;
                gradeLevelSelect.appendChild(opt);
            });

            // Reset Program
            if (config.showProgram) {
                programWrapper.style.display = 'block';
                programSelect.required = true;
                programSelect.innerHTML = '<option value="" disabled selected>Program</option>';
                config.programs.forEach(program => {
                    const opt = document.createElement('option');
                    opt.value = program;
                    opt.textContent = program;
                    programSelect.appendChild(opt);
                });
            } else {
                programWrapper.style.display = 'none';
                programSelect.required = false;
                programSelect.value = '';
            }
        });

        // Trigger change on load if there's an old value
        if (departmentSelect.value) {
            departmentSelect.dispatchEvent(new Event('change'));
        }
    </script>
</body>

</html>
