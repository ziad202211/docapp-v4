<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Patient Dashboard</title>
        <link rel="stylesheet" href="{{ asset('css/patient-dashboard.css') }}">
    </head>
<body>
    <nav class="navbar">
    <div class="search-box">
            <input type="text" placeholder="Search doctors..." class="search-input" id="doctorSearch">
        </div>
        <ul>
            <li><a href="#">Profile</a></li>
            <li><a href="#">MY appointments</a></li>
            <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log out</a></li>
            <img src="{{ Auth::user()->photo ?? 'default.png' }}" alt="Profile" class="nav-img">
        </ul>
       
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <section class="doctors-section">
        @foreach($doctors as $doctor)
            <div class="doctor-box">
                <img src="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : asset('default-doctor.png') }}" 
                     alt="Doctor Photo" 
                     class="doctor-img">
                <h3>{{ $doctor->title }} </h3>
                <p><strong>Degree:</strong> {{ $doctor->degree }}</p>
                <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
                <p><strong>Location:</strong> {{ $doctor->location }}</p>
                <a href="{{ route('patient.appointments.create', $doctor->id) }}" class="book-appointment-btn">Book Appointment</a>
            </div>
        @endforeach
    </section>

    <script>
        // Simple search functionality
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