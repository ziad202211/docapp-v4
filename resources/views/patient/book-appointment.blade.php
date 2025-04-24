<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link rel="stylesheet" href="{{ asset('css/patient-dashboard.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 80px auto 40px;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .doctor-details {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .doctor-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 5px solid #e3f2fd;
        }

        .doctor-details h2 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .doctor-details p {
            margin: 10px 0;
            color: #555;
            font-size: 16px;
        }

        .booking-form {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .booking-form h3 {
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 22px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #2c3e50;
            font-weight: 500;
            font-size: 16px;
        }

        .available-days {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .day-button {
            padding: 12px 25px;
            border: 2px solid #e3f2fd;
            border-radius: 8px;
            background: #f8f9fa;
            cursor: pointer;
            font-weight: 500;
            color: #2c3e50;
            transition: all 0.3s ease;
        }

        .day-button:hover {
            background: #e3f2fd;
            border-color: #2196f3;
        }

        .day-button.active {
            background: #2196f3;
            color: white;
            border-color: #2196f3;
        }

        .time-slots {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 12px;
            margin-top: 20px;
        }

        .time-slot {
            padding: 12px;
            border: 2px solid #e3f2fd;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            font-weight: 500;
            color: #2c3e50;
            transition: all 0.3s ease;
        }

        .time-slot:hover {
            background: #e3f2fd;
            border-color: #2196f3;
        }

        .time-slot.selected {
            background: #4caf50;
            color: white;
            border-color: #4caf50;
        }

        .time-slot.unavailable {
            background: #f44336;
            color: white;
            border-color: #f44336;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .book-appointment-btn {
            width: 100%;
            padding: 15px;
            background: #2196f3;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .book-appointment-btn:hover {
            background: #1976d2;
            transform: translateY(-2px);
        }

        .book-appointment-btn:disabled {
            background: #bdbdbd;
            cursor: not-allowed;
            transform: none;
        }

        .navbar {
            background: #2196f3;
            padding: 15px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar ul {
            list-style: none;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .navbar a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .time-slots {
                grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="{{ route('patient.dashboard') }}">Back to Dashboard</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="doctor-details">
            <img src="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : asset('default-doctor.png') }}" 
                 alt="Doctor Photo" 
                 class="doctor-img">
            <h2>{{ $doctor->title }} </h2>
            <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>
            <p><strong>Location:</strong> {{ $doctor->location }}</p>
            <p><strong>Degree:</strong> {{ $doctor->degree }}</p>
        </div>

        <div class="booking-form">
            <h3>Book Appointment</h3>
            <form action="{{ route('patient.appointments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                <input type="hidden" name="appointment_date" id="selected_date">
                <input type="hidden" name="appointment_time" id="selected_time">

                <div class="form-group">
                    <label>Available Days:</label>
                    <div class="available-days">
                        @foreach($doctor->schedules as $schedule)
                            <button type="button" 
                                    class="day-button" 
                                    data-day="{{ $schedule->day }}"
                                    onclick="selectDay(this, '{{ $schedule->day }}', {{ $schedule->start_time }}, {{ $schedule->end_time }})">
                                {{ $schedule->day }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <label>Available Time Slots:</label>
                    <div class="time-slots" id="timeSlots">
                        <!-- Time slots will be populated here -->
                    </div>
                </div>

                <button type="submit" class="book-appointment-btn" id="submitBtn" disabled>Confirm Appointment</button>
            </form>
        </div>
    </div>

    <script>
        let selectedDay = null;
        let selectedTime = null;

        function formatTime(hour, minute) {
            const period = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minute.toString().padStart(2, '0')} ${period}`;
        }

        function selectDay(button, day, startTime, endTime) {
            // Update selected day
            selectedDay = day;
            document.querySelectorAll('.day-button').forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // Generate time slots
            const timeSlotsContainer = document.getElementById('timeSlots');
            timeSlotsContainer.innerHTML = '';

            // Create 30-minute intervals
            for (let hour = startTime; hour < endTime; hour++) {
                for (let minute = 0; minute < 60; minute += 30) {
                    const timeString = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                    const displayTime = formatTime(hour, minute);
                    const timeSlot = document.createElement('div');
                    timeSlot.className = 'time-slot';
                    timeSlot.textContent = displayTime;
                    timeSlot.dataset.time = timeString;
                    timeSlot.onclick = () => selectTime(timeSlot, timeString);
                    timeSlotsContainer.appendChild(timeSlot);
                }
            }

            // Reset selection
            selectedTime = null;
            document.getElementById('selected_date').value = '';
            document.getElementById('selected_time').value = '';
            document.getElementById('submitBtn').disabled = true;
        }

        function selectTime(element, time) {
            // Update selected time
            selectedTime = time;
            document.querySelectorAll('.time-slot').forEach(slot => slot.classList.remove('selected'));
            element.classList.add('selected');

            // Set the hidden input values
            document.getElementById('selected_time').value = time;
            document.getElementById('submitBtn').disabled = false;
        }

        // Get current date and set it as minimum
        const today = new Date();
        const minDate = today.toISOString().split('T')[0];
        document.getElementById('appointment_date').min = minDate;
    </script>
</body>
</html> 