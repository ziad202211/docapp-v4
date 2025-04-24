<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="{{ asset('css/auth-styles.css') }}">
</head>
<body class="bg-gray-100">

    <div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
        <!-- Register Label -->
        <h2 class="text-2xl font-semibold text-gray-800 ">Register</h2>
        
        <div class="flex justify-center mb-4">
            <!-- Uncomment the logo image if needed -->
            <!-- <a href="/">
                <img src="logo.png" alt="Logo" class="w-20 h-20">
            </a> -->
        </div>

        <!-- Validation Errors -->
        <div class="mb-4">
            <!-- You can display errors here using your backend framework -->
        </div>

        <form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="mb-4">
        <label for="name" class="block text-gray-700">{{ __('Name') }}</label>
        <input id="name" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="name" value="{{ old('name') }}" required autofocus>
    </div>

    <!-- Email Address -->
    <div class="mb-4">
        <label for="email" class="block text-gray-700">{{ __('Email') }}</label>
        <input id="email" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="email" name="email" value="{{ old('email') }}" required>
    </div>

    <!-- Role Selection -->
    <div class="mb-4">
        <label for="role" class="block text-gray-700">{{ __('Register as') }}</label>
        <select name="role" id="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
        <option>Doctor or Patient</option>
            <option value="doctor">Doctor</option>
            <option value="patient">Patient</option>
        </select>
    </div>

    <!-- Gender Selection -->
    <div class="mb-4">
        <label for="gender" class="block text-gray-700">{{ __('Gender') }}</label>
        <select name="gender" id="gender" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
            <option value="" disabled selected>Select your gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
    </div>

    <!-- Password -->
    <div class="mb-4">
        <label for="password" class="block text-gray-700">{{ __('Password') }}</label>
        <input id="password" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="password" name="password" required autocomplete="new-password">
    </div>

    <!-- Confirm Password -->
    <div class="mb-4">
        <label for="password_confirmation" class="block text-gray-700">{{ __('Confirm Password') }}</label>
        <input id="password_confirmation" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="password" name="password_confirmation" required>
    </div>
    <!-- Specialization (only for doctors) -->
<div class="mb-4" id="specializationField" style="display: none;">
    <label for="specialization" class="block text-gray-700">{{ __('Specialization') }}</label>
    <input id="specialization" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="text" name="specialization" value="{{ old('specialization') }}">
</div>

<!-- Medical Record (only for patients) -->
<div class="mb-4" id="medicalRecordField" style="display: none;">
    <label for="medical_record" class="block text-gray-700">{{ __('Medical Record') }}</label>
    <textarea id="medical_record" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" name="medical_record">{{ old('medical_record') }}</textarea>
</div>

<!-- Date of Birth (only for patients) -->
<div class="mb-4" id="dobField" style="display: none;">
    <label for="date_of_birth" class="block text-gray-700">{{ __('Date of Birth') }}</label>
    <input id="date_of_birth" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
</div>

    <div class="flex items-center justify-between mt-4">
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            {{ __('Register') }}
        </button>
    </div>
</form>

    </div>
    <script>
    document.getElementById('role').addEventListener('change', function() {
        var role = this.value;
        if (role == 'doctor') {
            document.getElementById('specializationField').style.display = 'block';
            document.getElementById('medicalRecordField').style.display = 'none';
            document.getElementById('dobField').style.display = 'none';
        } else if (role == 'patient') {
            document.getElementById('specializationField').style.display = 'none';
            document.getElementById('medicalRecordField').style.display = 'block';
            document.getElementById('dobField').style.display = 'block';
        }
    });
</script>

</body>
</html>
