<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .container {
            width: 100%;
            max-width: 900px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px 60px;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .profile-form {
            display: flex;
            flex-direction: column;
            gap: 25px;
            max-width: 800px;
            margin: 0 auto;
        }

        .profile-form h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 10px;
            font-size: 28px;
            position: relative;
            padding-bottom: 15px;
        }

        .profile-form h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: #3498db;
            border-radius: 3px;
        }

        /* Photo section styles */
        .photo-section {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 40px;
            margin-bottom: 30px;
        }

        .profile-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #3498db;
            box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
            position: relative;
            transition: transform 0.3s ease;
        }

        .profile-photo:hover {
            transform: scale(1.05);
        }

        .profile-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-upload-container {
            position: relative;
            display: inline-block;
        }

        .photo-upload-label {
            display: inline-block;
            padding: 10px 20px;
            background: #3498db;
            color: white;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            box-shadow: 0 2px 5px rgba(52, 152, 219, 0.3);
        }

        .photo-upload-label:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(52, 152, 219, 0.4);
        }

        .photo-upload-label i {
            margin-right: 8px;
        }

        #photo-upload {
            display: none;
        }

        /* Form group styles */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            position: relative;
            max-width: 100%;
        }

        .form-group label {
            color: #2c3e50;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .form-group label i {
            color: #3498db;
            font-size: 16px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 14px 18px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            width: 100%;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3498db;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-group input.error,
        .form-group select.error,
        .form-group textarea.error {
            border-color: #e74c3c;
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 4px;
            display: none;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* Button styles */
        .save-button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 14px 25px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(52, 152, 219, 0.2);
            position: relative;
            overflow: hidden;
        }

        .save-button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(52, 152, 219, 0.3);
        }

        .save-button:active {
            transform: translateY(0);
        }

        .save-button.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .save-button i {
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .save-button:hover i {
            transform: translateX(3px);
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .save-button.loading .loading-spinner {
            display: block;
        }

        .save-button.loading i {
            display: none;
        }

        /* Success message */
        .success-message {
            display: none;
            text-align: center;
            color: #27ae60;
            font-weight: 500;
            margin-top: 15px;
            animation: fadeIn 0.3s ease-out;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 30px;
                max-width: 95%;
            }

            .photo-section {
                flex-direction: column;
                gap: 20px;
            }

            .profile-photo {
                width: 120px;
                height: 120px;
            }

            .form-group input,
            .form-group select,
            .form-group textarea {
                padding: 12px 15px;
            }

            .save-button {
                padding: 12px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <form class="profile-form" id="profileForm" action="{{ route('patient.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h2>User Profile</h2>
            
            @if(session('success'))
                <div class="success-message" style="display: block;">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="photo-section">
                <div class="profile-photo">
                    <img id="photo-preview" src="{{ $patient->photo ? asset('storage/patient-photos/' . $patient->photo) : asset('default-avatar.png') }}" alt="Profile Photo">
                </div>
                <div class="photo-upload-container">
                    <label for="photo-upload" class="photo-upload-label">
                        <i class="fas fa-camera"></i> Change Photo
                    </label>
                    <input type="file" id="photo-upload" name="photo" accept="image/*">
                </div>
            </div>

            <div class="form-group">
                <label for="fullName">
                    <i class="fas fa-user"></i> Full Name
                </label>
                <input type="text" id="fullName" name="name" value="{{ $user->name }}" required>
                <div class="error-message" id="fullNameError"></div>
            </div>

            <div class="form-group">
                <label for="phone">
                    <i class="fas fa-phone"></i> Phone Number
                </label>
                <input type="tel" id="phone" name="phone" value="{{ $patient->phone }}" required>
                <div class="error-message" id="phoneError"></div>
            </div>

            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i> Email
                </label>
                <input type="email" id="email" name="email" value="{{ $user->email }}" required>
                <div class="error-message" id="emailError"></div>
            </div>

            <div class="form-group">
                <label for="gender">
                    <i class="fas fa-venus-mars"></i> Gender
                </label>
                <select id="gender" name="gender" required>
                    <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                </select>
                <div class="error-message" id="genderError"></div>
            </div>

            <div class="form-group">
                <label for="medicalRecord">
                    <i class="fas fa-notes-medical"></i> Medical Record
                </label>
                <textarea id="medicalRecord" name="medical_record" rows="4">{{ $patient->medical_record }}</textarea>
                <div class="error-message" id="medicalRecordError"></div>
            </div>

            <button type="submit" class="save-button">
                <i class="fas fa-save"></i>
                <div class="loading-spinner"></div>
                Save Changes
            </button>
            <div class="success-message" id="successMessage"></div>
        </form>
    </div>

    <script>
        // Form validation
        function validateForm() {
            let isValid = true;
            const form = document.getElementById('profileForm');
            const inputs = form.querySelectorAll('input, select, textarea');
            
            inputs.forEach(input => {
                const errorElement = document.getElementById(`${input.id}Error`);
                if (!input.checkValidity()) {
                    input.classList.add('error');
                    if (errorElement) {
                        errorElement.style.display = 'block';
                        errorElement.textContent = input.validationMessage;
                    }
                    isValid = false;
                } else {
                    input.classList.remove('error');
                    if (errorElement) {
                        errorElement.style.display = 'none';
                    }
                }
            });
            
            return isValid;
        }

        // Handle photo upload preview
        document.getElementById('photo-upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 5 * 1024 * 1024) { // 5MB limit
                    alert('File size should be less than 5MB');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photo-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Handle form submission
        document.getElementById('profileForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!validateForm()) {
                return;
            }

            const saveButton = document.querySelector('.save-button');
            const successMessage = document.getElementById('successMessage');
            
            // Show loading state
            saveButton.classList.add('loading');
            
            // Submit the form
            const formData = new FormData(this);
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            if (!csrfToken) {
                console.error('CSRF token not found');
                alert('Security token missing. Please refresh the page and try again.');
                return;
            }

            // Log form data for debugging
            console.log('Submitting form with data:');
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Network response was not ok');
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Success response:', data);
                saveButton.classList.remove('loading');
                if (successMessage) {
                    successMessage.style.display = 'block';
                    successMessage.textContent = data.message || 'Profile updated successfully!';
                    successMessage.style.color = '#27ae60';
                    
                    // Hide success message after 3 seconds
                    setTimeout(() => {
                        successMessage.style.display = 'none';
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                saveButton.classList.remove('loading');
                if (successMessage) {
                    successMessage.style.display = 'block';
                    successMessage.textContent = error.message || 'An error occurred while updating your profile. Please try again.';
                    successMessage.style.color = '#e74c3c';
                }
            });
        });

        // Add input validation on blur
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                validateForm();
            });
        });
    </script>
</body>
</html>