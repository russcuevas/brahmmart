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

            <form action="" method="POST">
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
                            value="{{ old('first_name') }}">
                        <input type="email" name="email" placeholder="Email" required
                            value="{{ old('last_name') }}">
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
                    <input type="password" name="password" placeholder="Password" required>
                </div>


                <!-- Department Section -->
                <div class="section">
                    <h2 class="section-title">Department </h2>
                    <select name="department" required>
                        <option value="" disabled selected>Select your department</option>
                        <option value="junior high school"
                            {{ old('department') == 'junior high school' ? 'selected' : '' }}>Junior High School
                        </option>
                        <option value="shs" {{ old('department') == 'shs' ? 'selected' : '' }}>SHS</option>
                        <option value="college" {{ old('department') == 'college' ? 'selected' : '' }}>College</option>
                    </select>
                </div>

                <!-- Education Section (Custom for User) -->
                <div class="section">
                    <h2 class="section-title">Education</h2>
                    <div class="input-row">
                        <select name="grade_level" required>
                            <option value="" disabled selected>Grade/Level</option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                        <select name="Program" required>
                            <option value="" disabled selected>Program</option>
                            <option value="BSIT">BSIT</option>
                            <option value="BSCS">BSCS</option>
                            <option value="BSA">BSA</option>
                        </select>
                    </div>
                </div>

                <div class="footer-text">
                    <p>People who use our service may have uploaded your contact information to BRAHMMART. <a
                            href="#">Learn more</a>.</p>
                    <p>By tapping Submit, you agree to create an account and to BRAHMMART's <a href="#">Terms</a>,
                        <a href="#">Privacy Policy</a> and <a href="#">Cookies Policy</a>.
                    </p>
                </div>

                <button type="submit" class="submit-btn">Register</button>
            </form>

            <div class="login-link">
                Already have an account? <a href="/login">Sign In</a>
            </div>
        </div>
    </div>

</body>

</html>
