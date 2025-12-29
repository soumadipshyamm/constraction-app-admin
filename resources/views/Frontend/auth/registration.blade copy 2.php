<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #e74c3c;
            --light-gray: #f8f9fa;
            --dark-gray: #343a40;
            --border-radius: 8px;
            --box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #4a4a4a;
        }

        .registration-container {
            max-width: 1000px;
            margin: 3rem auto;
            padding: 2rem;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        .registration-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eee;
        }

        .registration-header h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .section-title {
            color: var(--primary-color);
            font-weight: 600;
            margin: 1.5rem 0 1rem;
            position: relative;
            padding-left: 15px;
        }

        .section-title:before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 70%;
            width: 4px;
            background: var(--primary-color);
            border-radius: 10px;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #555;
        }

        .form-control {
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.75rem 2rem;
            font-weight: 600;
            border-radius: var(--border-radius);
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .file-upload-container {
            border: 2px dashed #ddd;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .file-upload-container:hover {
            border-color: var(--primary-color);
        }

        .file-upload-container i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .file-upload-input {
            display: none;
        }

        .error-message {
            color: var(--accent-color);
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .terms-check {
            display: flex;
            align-items: flex-start;
            margin: 1.5rem 0;
        }

        .terms-check input {
            margin-top: 0.25rem;
            margin-right: 0.5rem;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
        }

        .login-link a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .banner-img {
            width: 100%;
            border-radius: var(--border-radius);
            object-fit: cover;
            height: 180px;
            margin-bottom: 2rem;
            box-shadow: var(--box-shadow);
        }

        @media (max-width: 768px) {
            .registration-container {
                margin: 1rem;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="registration-container">
            <div class="registration-header">
                <img src="https://via.placeholder.com/1200x400?text=Company+Registration" alt="Registration Banner" class="banner-img">
                <h1>Company Registration</h1>
                <p class="text-muted">Create your company account in just a few minutes</p>
            </div>

            <form id="registrationForm">
                <!-- Company Details Section -->
                <h4 class="section-title">Company Information</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="registration_name" class="form-label">Company Name *</label>
                        <input type="text" class="form-control" id="registration_name" name="registration_name" placeholder="Acme Corporation" required>
                        <div class="error-message" id="registration_name_error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="company_registration_no" class="form-label">Registration Number *</label>
                        <input type="text" class="form-control" id="company_registration_no" name="company_registration_no" placeholder="123456789" required>
                        <div class="error-message" id="company_registration_no_error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="company_address" class="form-label">Company Address *</label>
                        <input type="text" class="form-control" id="company_address" name="company_address" placeholder="123 Business St, City" required>
                        <div class="error-message" id="company_address_error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="company_phone" class="form-label">Company Phone *</label>
                        <input type="tel" class="form-control" id="company_phone" name="company_phone" placeholder="+1 (555) 123-4567" required>
                        <div class="error-message" id="company_phone_error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="website_link" class="form-label">Website (Optional)</label>
                        <div class="input-group">
                            <span class="input-group-text">https://</span>
                            <input type="text" class="form-control" id="website_link" name="website_link" placeholder="yourcompany.com">
                        </div>
                    </div>
                </div>

                <!-- User Details Section -->
                <h4 class="section-title">Account Details</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Full Name *</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" required>
                        <div class="error-message" id="name_error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email Address *</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="john@company.com" required>
                        <div class="error-message" id="email_error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number *</label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="+1 (555) 987-6543" required>
                        <div class="error-message" id="phone_error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="designation" class="form-label">Designation</label>
                        <input type="text" class="form-control" id="designation" name="designation" placeholder="e.g., CEO, Manager">
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Password *</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
                        <div class="error-message" id="password_error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirm Password *</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                        <div class="error-message" id="password_confirmation_error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="country" class="form-label">Country *</label>
                        <select class="form-select" id="country" name="country" required>
                            <option value="" disabled selected>Select your country</option>
                            <option value="US">United States</option>
                            <option value="UK">United Kingdom</option>
                            <option value="CA">Canada</option>
                            <!-- More countries would be added here -->
                        </select>
                        <div class="error-message" id="country_error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="states" class="form-label">State/Province *</label>
                        <select class="form-select" id="states" name="states" required disabled>
                            <option value="" disabled selected>Select country first</option>
                        </select>
                        <div class="error-message" id="states_error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="city" class="form-label">City *</label>
                        <select class="form-select" id="city" name="city" required disabled>
                            <option value="" disabled selected>Select state first</option>
                        </select>
                        <div class="error-message" id="city_error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="dob" class="form-label">Date of Birth *</label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                        <div class="error-message" id="dob_error"></div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Profile Photo</label>
                        <div class="file-upload-container" onclick="document.getElementById('profile_images').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p class="mb-1">Click to upload or drag and drop</p>
                            <p class="text-muted small mb-0">PNG, JPG, GIF up to 5MB</p>
                            <input type="file" class="file-upload-input" id="profile_images" name="profile_images" accept="image/*">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="terms-check">
                            <input type="checkbox" class="form-check-input" id="termCondition" name="termCondition" required>
                            <label for="termCondition" class="form-check-label">
                                I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and <a href="#" class="text-primary">Privacy Policy</a> *
                            </label>
                        </div>
                        <div class="error-message" id="termCondition_error"></div>
                    </div>

                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i> Complete Registration
                        </button>
                    </div>
                </div>

                <div class="login-link">
                    Already have an account? <a href="#">Sign in here</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Country-State-City AJAX handling
            $('#country').change(function() {
                const countryId = $(this).val();
                $('#states').prop('disabled', false).html('<option value="" disabled selected>Loading states...</option>');

                // In a real app, this would be an AJAX call to get states for the selected country
                setTimeout(() => {
                    const states = {
                        US: ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California'],
                        UK: ['England', 'Scotland', 'Wales', 'Northern Ireland'],
                        CA: ['Alberta', 'British Columbia', 'Manitoba', 'New Brunswick']
                    };

                    const stateOptions = states[countryId] ?
                        states[countryId].map(state => `<option value="${state}">${state}</option>`) :
                        ['<option value="" disabled selected>No states available</option>'];

                    $('#states').html(stateOptions.join(''));
                }, 500);
            });

            $('#states').change(function() {
                const state = $(this).val();
                $('#city').prop('disabled', false).html('<option value="" disabled selected>Loading cities...</option>');

                // In a real app, this would be an AJAX call to get cities for the selected state
                setTimeout(() => {
                    const cityOptions = [
                        '<option value="City 1">City 1</option>',
                        '<option value="City 2">City 2</option>',
                        '<option value="City 3">City 3</option>'
                    ];

                    $('#city').html(cityOptions.join(''));
                }, 500);
            });

            // Form validation
            $('#registrationForm').submit(function(e) {
                e.preventDefault();
                let isValid = true;

                // Clear previous errors
                $('.error-message').text('');

                // Validate required fields
                $('[required]').each(function() {
                    if (!$(this).val() && $(this).is(':visible')) {
                        isValid = false;
                        const fieldName = $(this).attr('name');
                        $(`#${fieldName}_error`).text('This field is required');
                    }
                });

                // Password match validation
                if ($('#password').val() !== $('#password_confirmation').val()) {
                    isValid = false;
                    $('#password_confirmation_error').text('Passwords do not match');
                }

                // Terms checkbox validation
                if (!$('#termCondition').is(':checked')) {
                    isValid = false;
                    $('#termCondition_error').text('You must accept the terms and conditions');
                }

                if (isValid) {
                    // Submit the form if validation passes
                    alert('Form submitted successfully!');
                    // In a real app, you would submit to the server here
                    // this.submit();
                }
            });

            // Show file name when selected
            $('#profile_images').change(function() {
                const fileName = $(this).val().split('\\').pop();
                if (fileName) {
                    $('.file-upload-container p:first').text(fileName);
                }
            });
        });
    </script>
</body>
</html>
