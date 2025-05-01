<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Patient Dashboard</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            :root {
                --primary-color: #2563eb;
                --secondary-color: #1e40af;
                --accent-color: #3b82f6;
                --text-color: #1f2937;
                --light-gray: #f3f4f6;
                --white: #ffffff;
                --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Poppins', sans-serif;
            }

            body {
                background-color: var(--light-gray);
                color: var(--text-color);
            }

            .navbar {
                background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
                padding: 1rem 2rem;
                position: sticky;
                top: 0;
                z-index: 1000;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                height: 80px;
            }

            .nav-container {
                max-width: 1400px;
                margin: 0 auto;
                display: flex;
                align-items: center;
                justify-content: space-between;
                height: 100%;
            }

            .search-box {
                position: relative;
                width: 40%;
            }

            .search-input {
                width: 100%;
                padding: 0.75rem 1.5rem;
                border: 2px solid rgba(255, 255, 255, 0.2);
                border-radius: 2rem;
                font-size: 0.95rem;
                transition: all 0.3s ease;
                background-color: rgba(255, 255, 255, 0.1);
                color: var(--white);
                backdrop-filter: blur(5px);
            }

            .search-input::placeholder {
                color: rgba(255, 255, 255, 0.7);
            }

            .search-input:focus {
                outline: none;
                border-color: var(--white);
                background-color: rgba(255, 255, 255, 0.15);
                box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
            }

            .nav-links {
                display: flex;
                align-items: center;
                gap: 2rem;
                list-style: none;
                height: 100%;
            }

            .nav-links li {
                display: flex;
                align-items: center;
                height: 100%;
            }

            .nav-links a {
                text-decoration: none;
                color: var(--white);
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                transition: all 0.3s ease;
                padding: 0.75rem 1.25rem;
                border-radius: 0.75rem;
                font-size: 1rem;
                white-space: nowrap;
            }

            .nav-links a:hover {
                background-color: rgba(255, 255, 255, 0.15);
                transform: translateY(-2px);
            }

            .nav-links li:last-child a {
                background-color: rgba(255, 255, 255, 0.1);
                border: 1px solid rgba(255, 255, 255, 0.2);
                margin-left: 2rem;
            }

            .nav-links li:last-child a:hover {
                background-color: rgba(255, 255, 255, 0.2);
            }

            .nav-img {
                width: 45px;
                height: 45px;
                border-radius: 50%;
                object-fit: cover;
                border: 2px solid rgba(255, 255, 255, 0.3);
                transition: all 0.3s ease;
                margin-left: 2rem;
            }

            .nav-img:hover {
                transform: scale(1.05);
                border-color: var(--white);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }

            .doctors-section {
                max-width: 1400px;
                margin: 3rem auto;
                padding: 0 2rem;
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 2rem;
            }

            .doctor-box {
                background-color: var(--white);
                border-radius: 1.25rem;
                overflow: hidden;
                box-shadow: var(--shadow);
                transition: all 0.3s ease;
                padding: 1.25rem;
            }

            .doctor-box:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            }

            .doctor-img {
                width: 100%;
                height: 200px;
                object-fit: cover;
                border-radius: 1rem;
                margin-bottom: 1rem;
            }

            .doctor-box h3 {
                font-size: 1.25rem;
                color: var(--text-color);
                margin-bottom: 0.75rem;
            }

            .doctor-box p {
                color: #4b5563;
                margin-bottom: 0.5rem;
                font-size: 0.95rem;
            }

            .book-appointment-btn {
                display: inline-block;
                background-color: var(--primary-color);
                color: var(--white);
                padding: 0.75rem 1.5rem;
                border-radius: 0.75rem;
                text-decoration: none;
                font-weight: 500;
                transition: all 0.3s ease;
                width: 100%;
                text-align: center;
                margin-top: 1rem;
            }

            .book-appointment-btn:hover {
                background-color: var(--secondary-color);
                transform: translateY(-2px);
            }

            @media (max-width: 500px) {
                .nav-container {
                    flex-direction: column;
                    gap: 1rem;
                }

                .search-box {
                    width: 100%;
                }

                .nav-links {
                    width: 100%;
                    justify-content: space-between;
                }

                .doctors-section {
                    grid-template-columns: 1fr;
                }
            }

            .welcome-section {
                background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
                color: var(--white);
                padding: 3rem 0;
                margin-bottom: 2rem;
            }

            .welcome-container {
                max-width: 1400px;
                margin: 0 auto;
                padding: 0 2rem;
            }

            .welcome-section h1 {
                font-size: 2.5rem;
                font-weight: 600;
                margin-bottom: 1rem;
            }

            .welcome-subtitle {
                font-size: 1.2rem;
                opacity: 0.9;
                margin-bottom: 2rem;
            }

            .welcome-stats {
                display: flex;
                justify-content: center;
                gap: 1.5rem;
                margin-top: 2rem;
            }

            .stat-card {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 1rem;
                padding: 1.5rem;
                display: flex;
                align-items: center;
                gap: 1.5rem;
                transition: transform 0.3s ease;
                max-width: 400px;
                width: 100%;
            }

            .stat-card:hover {
                transform: translateY(-5px);
            }

            .stat-card i {
                font-size: 2rem;
                color: var(--white);
            }

            .stat-info h3 {
                font-size: 1.2rem;
                margin-bottom: 0.5rem;
            }

            .stat-info p {
                opacity: 0.9;
                font-size: 0.95rem;
            }

            @media (max-width: 500px) {
                .welcome-section h1 {
                    font-size: 2rem;
                }

                .welcome-subtitle {
                    font-size: 1rem;
                }

                .welcome-stats {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    </head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="search-box">
                <input type="text" placeholder="Search doctors by name, specialization..." class="search-input" id="doctorSearch">
            </div>
            <ul class="nav-links">
            <li><a href="{{ route('profile') }}"><i class="fas fa-user"></i> Profile</a></li>

                <!--  -->
                <li><a href="{{ route('appointments.index') }}"><i class="fas fa-calendar-check"></i> My Appointments</a></li>
                <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Log out
                </a></li>
                <img src="{{ Auth::user()->patient->photo ? asset('storage/patient-photos/' . Auth::user()->patient->photo) : asset('storage/patient-photos/default-avatar.png') }}" alt="Profile" class="nav-img">
            </ul>
        </div>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="welcome-section">
        <div class="welcome-container">
            <h1>Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="welcome-subtitle">We're here to help you find the best healthcare professionals</p>
            <div class="welcome-stats">
                <div class="stat-card">
                    <i class="fas fa-user-md"></i>
                    <div class="stat-info">
                        <h3>Available Doctors</h3>
                        <p>{{ count($doctors) }} specialists ready to assist you</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="doctors-section">
        @foreach($doctors as $doctor)
            <div class="doctor-box">
                <img src="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : asset('default-doctor.png') }}" 
                     alt="Doctor Photo" 
                     class="doctor-img">
                <h3>{{ $doctor->title }}</h3>
                <p><strong>Degree:</strong> {{ $doctor->degree }}</p>
                <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                <p><strong>Location:</strong> {{ $doctor->location }}</p>
                <a href="{{ route('patient.appointments.create', $doctor->id) }}" class="book-appointment-btn">
                    Book Appointment
                </a>
            </div>
        @endforeach
    </section>

    <script>
        document.getElementById('doctorSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const doctorCards = document.querySelectorAll('.doctor-box');
            
            doctorCards.forEach(card => {
                const doctorInfo = card.textContent.toLowerCase();
                if(doctorInfo.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>