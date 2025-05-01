<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Doctor Appointment | Home</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            background-color: #f7fafc;
        }

        .header {
            height: 50vh;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('{{ asset('images/bg.jpg') }}');
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            padding: 2rem 1rem;
            position: relative;
        }

        .header h1 {
            font-size: 2.5rem;
        }

        .main {
            text-align: center;
            padding: 5rem 2rem;
            background-color: #f0f7ff;
            position: relative;
            margin-top: -60px;
            border-radius: 0;
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
            clip-path: polygon(0 0, 100% 5%, 100% 100%, 0% 100%);
        }

        .main h2 {
            font-size: 2.8rem;
            margin-bottom: 1.5rem;
            color: #1a365d;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        .main h2 span {
            color: #3182ce;
        }

        .main p {
            font-size: 1.2rem;
            color: #4a5568;
            margin-bottom: 2.5rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.7;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 2rem;
        }

        .btn {
            padding: 1rem 2.5rem;
            margin: 0;
            border: none;
            background-color: #3182ce;
            color: white;
            font-size: 1.1rem;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 6px rgba(49, 130, 206, 0.2);
        }

        .btn i {
            font-size: 1.2rem;
        }

        .btn:hover {
            background-color: #2c5282;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(49, 130, 206, 0.3);
        }

        .btn-secondary {
            background-color: white;
            color: #3182ce;
            border: 2px solid #3182ce;
        }

        .btn-secondary:hover {
            background-color: #3182ce;
            color: white;
        }

        .appointment-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 3rem;
            padding: 1.5rem;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #3182ce;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .auth-links {
            position: absolute;
            top: 1rem;
            right: 1rem;
            z-index: 1000;
        }

        .auth-links a {
            margin-left: 1rem;
            font-size: 17px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            transition: color 0.3s ease, text-decoration 0.3s ease;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .auth-links a:hover {
            color: rgb(144, 186, 255);
            text-decoration: none;
        }

        .section {
            padding: 4rem 2rem;
            text-align: center;
        }

        .section h2 {
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #1a365d;
            position: relative;
            display: inline-block;
        }

        .section h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: #3182ce;
            border-radius: 2px;
        }

        .section p {
            font-size: 1.1rem;
            color: #4a5568;
        }

        .team {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 3rem;
            margin-top: 3rem;
            padding: 0 2rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .team-member {
            background-color: white;
            border-radius: 15px;
            padding: 1.5rem;
            width: 280px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .team-member:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .team-member::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #3182ce, #2c5282);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .team-member:hover::before {
            transform: scaleX(1);
        }

        .team-member img {
            width: 100%;
            height: 250px;
            object-fit: contain;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
            background-color: #f8fafc;
            padding: 0.5rem;
        }

        .team-member:hover img {
            transform: scale(1.05);
        }

        .team-member h3 {
            margin-top: 0.5rem;
            font-size: 1.3rem;
            color: #1a365d;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .team-member p {
            color: #4a5568;
            font-size: 1rem;
            margin: 0;
            font-weight: 500;
        }

        .footer {
            background-color: #2c5282;
            color: white;
            text-align: center;
            padding: 2rem 1rem;
        }

        .footer h3 {
            margin-bottom: 0.5rem;
        }

        .footer p {
            margin: 0.3rem 0;
            font-size: 0.95rem;
        }
        .logo-container {
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 1000;
        }

        .logo-container img {
            width: 140px;
            height: auto;
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.5));
        }

        .impact-section {
            padding: 5rem 2rem;
            background-color: #ffffff;
            text-align: center;
        }

        .impact-section h2 {
            font-size: 2.5rem;
            color: #1a365d;
            margin-bottom: 3rem;
            position: relative;
            display: inline-block;
        }

        .impact-section h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: #3182ce;
            border-radius: 2px;
        }

        .impact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .impact-card {
            background: #f8fafc;
            padding: 2rem;
            border-radius: 12px;
            transition: transform 0.3s ease;
        }

        .impact-card:hover {
            transform: translateY(-5px);
        }

        .impact-icon {
            font-size: 2.5rem;
            color: #3182ce;
            margin-bottom: 1rem;
        }

        .impact-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1a365d;
            margin-bottom: 0.5rem;
        }

        .impact-label {
            font-size: 1.1rem;
            color: #4a5568;
            font-weight: 500;
        }

    </style>
</head>

<body class="antialiased">
<div class="logo-container">
    <img src="{{ asset('images/logov2.png') }}" alt="Logo">
</div>

    @if (Route::has('login'))
        <div class="auth-links">
            @auth
                @if(auth()->user()->role === 'doctor')
                    <a href="{{ route('doctor.dashboard') }}">Dashboard</a>
                @elseif(auth()->user()->role === 'patient')
                    <a href="{{ route('patient.dashboard') }}">Dashboard</a>
                @endif
            @else
                <a href="{{ route('login') }}">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif
            
    
    
    <div class="header">
    
        <h1>Welcome to Ekshefli</h1>
        <p>Your trusted platform for booking doctor appointments online</p>
    </div>

    <div class="main">
        <h2>Book Your <span>Appointment</span> Today</h2>
        <p>Browse qualified doctors, view availability, and secure your consultation in just a few clicks. Experience healthcare at your fingertips with our seamless booking system.</p>
        <div class="btn-container">
            <a href="{{ route('login') }}" class="btn">
                <i class="fas fa-calendar-check"></i>
                Get Started
            </a>
            <a href="{{ route('register') }}" class="btn btn-secondary">
                <i class="fas fa-user-plus"></i>
                Create Account
            </a>
        </div>
        <div class="appointment-stats">
            <div class="stat-item">
                <div class="stat-number">500+</div>
                <div class="stat-label">Certified Doctors</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">10K+</div>
                <div class="stat-label">Patients Served</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">95%</div>
                <div class="stat-label">Positive Feedback</div>
            </div>
        </div>
    </div>

    <!-- About Us Section -->
    <div class="section" style="background-color: #e2e8f0;">
        <h2>About Us</h2>
        <p>Ekshefli is a leading online platform that connects patients with professional, verified doctors across all specialties. We aim to simplify the healthcare experience by enabling seamless appointment scheduling and care access.</p>
    </div>

    <!-- Doctor Team Section -->
    <div class="section">
        <h2>Meet Our Doctors</h2>
        <div class="team">
            <div class="team-member">
                <img src="{{ asset('images/doctors/Doctor-PNG-Images.png') }}" alt="Doctor A">
                <h3>Dr. Aya Omarah</h3>
                <p>Cardiologist</p>
            </div>
            <div class="team-member">
                <img src="{{ asset('images/doctors/bob.png') }}" alt="Doctor B">
                <h3>Dr. Morad Mansoury</h3>
                <p>Dermatologist</p>
            </div>
            <div class="team-member">
                <img src="{{ asset('images/doctors/clara-removebg-preview.png') }}" alt="Doctor C">
                <h3>Dr. Sarah Haitham</h3>
                <p>Neurologist</p>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <h3>Ekshefli</h3>
        <p>Contact: +20 123-456-7890</p>
        <p>Email: support@ekshefli.com</p>
        <p>&copy; 2025 Ekshefli. All rights reserved.</p>
    </div>
</body>
</html>
