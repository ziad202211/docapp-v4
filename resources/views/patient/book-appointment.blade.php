<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 10px;
            margin-top: 20px;
            max-height: 400px;
            overflow-y: auto;
            padding: 10px;
        }

        .time-slot {
            padding: 10px;
            border: 2px solid #e3f2fd;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            font-weight: 500;
            color: #2c3e50;
            transition: all 0.3s ease;
            min-width: 100px;
            margin: 5px;
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
            background-color: #f44336;
            color: white;
            cursor: not-allowed;
            opacity: 0.7;
            pointer-events: none;
        }

        .time-slot.unavailable:hover {
            background-color: #f44336;
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

        .alert-success {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: fadeIn 0.5s;
        }

        .alert-danger {
            background-color: #f44336;
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
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
            
            <div id="message-container"></div>

            <form action="{{ route('patient.appointments.store') }}" method="POST" id="appointmentForm">
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
                                    data-start-time="{{ $schedule->start_time }}"
                                    data-end-time="{{ $schedule->end_time }}">
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

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('appointmentForm');
                    const messageContainer = document.getElementById('message-container');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    form.addEventListener('submit', function(e) {
                        e.preventDefault(); // Prevent default form submission
                        
                        if (!selectedDay || !selectedTime) {
                            showMessage('Please select both a day and time slot before confirming.', 'danger');
                            return false;
                        }

                        // Create FormData object
                        const formData = new FormData(form);
                        
                        // Convert FormData to JSON
                        const jsonData = {};
                        formData.forEach((value, key) => {
                            jsonData[key] = value;
                        });
                        
                        // Submit the form using fetch API
                        fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(jsonData)
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(data => {
                                    throw new Error(data.message || 'An error occurred while booking the appointment');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                showMessage(data.message, 'success');
                                
                                // Reset form
                                form.reset();
                                document.getElementById('submitBtn').disabled = true;
                                document.querySelectorAll('.day-button').forEach(btn => btn.classList.remove('active'));
                                document.querySelectorAll('.time-slot').forEach(slot => slot.classList.remove('selected'));
                                document.getElementById('timeSlots').innerHTML = '';
                            } else {
                                showMessage(data.message || 'An error occurred while booking the appointment', 'danger');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showMessage(error.message || 'An error occurred while booking the appointment', 'danger');
                        });
                    });

                    function showMessage(message, type) {
                        // Clear any existing messages
                        messageContainer.innerHTML = '';
                        
                        // Create message element
                        const messageDiv = document.createElement('div');
                        messageDiv.className = `alert alert-${type}`;
                        messageDiv.innerHTML = `
                            <span style="flex: 1;">${message}</span>
                            <button type="button" class="close-alert" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer; margin-left: 10px;">&times;</button>
                        `;
                        
                        // Add to container
                        messageContainer.appendChild(messageDiv);
                        
                        // Add close button functionality
                        const closeButton = messageDiv.querySelector('.close-alert');
                        closeButton.addEventListener('click', function() {
                            messageDiv.style.display = 'none';
                        });
                        
                        // Auto-hide after 5 seconds
                        setTimeout(() => {
                            messageDiv.style.display = 'none';
                        }, 5000);
                    }
                });
            </script>
        </div>
    </div>

    <script>
        // Handle closing alerts
        document.addEventListener('DOMContentLoaded', function() {
            const closeButtons = document.querySelectorAll('.close-alert');
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.parentElement.style.display = 'none';
                });
            });

            // Auto-hide success message after 5 seconds
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.display = 'none';
                }, 5000);
            }
        });

        // Debug the existing appointments
        console.log('Existing appointments:', @json($existingAppointments));
        
        const existingAppointments = @json($existingAppointments);
        let selectedDay = null;
        let selectedTime = null;

        function formatTime(hour, minute) {
            const period = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minute.toString().padStart(2, '0')} ${period}`;
        }

        function isTimeSlotBooked(date, time) {
            return existingAppointments.some(appointment => 
                appointment.date === date && appointment.time === time
            );
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
                    const timeString = formatTime(hour, minute);
                    
                    // Get the date for this time slot
                    const today = new Date();
                    while (today.getDay() !== getDayNumber(day)) {
                        today.setDate(today.getDate() + 1);
                    }
                    const formattedDate = today.toISOString().split('T')[0];
                    
                    // Check if this time slot is booked
                    const isBooked = isTimeSlotBooked(formattedDate, timeString);
                    
                    // Create time slot element
                    const timeSlot = document.createElement('div');
                    timeSlot.className = 'time-slot' + (isBooked ? ' unavailable' : '');
                    timeSlot.textContent = timeString;
                    timeSlot.dataset.time = timeString;
                    
                    if (!isBooked) {
                        timeSlot.onclick = () => selectTime(timeSlot, timeString);
                    } else {
                        timeSlot.title = 'This slot is already booked';
                        timeSlot.style.cursor = 'not-allowed';
                    }
                    
                    // Add to container
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
            
            // Get the selected day and convert it to a proper date format
            const selectedDay = document.querySelector('.day-button.active').dataset.day;
            const today = new Date();
            
            // Find the next occurrence of the selected day
            while (today.getDay() !== getDayNumber(selectedDay)) {
                today.setDate(today.getDate() + 1);
            }
            
            // Format the date as YYYY-MM-DD
            const formattedDate = today.toISOString().split('T')[0];
            document.getElementById('selected_date').value = formattedDate;
            
            document.getElementById('submitBtn').disabled = false;
        }

        // Helper function to convert day name to day number
        function getDayNumber(dayName) {
            const days = {
                'Sunday': 0,
                'Monday': 1,
                'Tuesday': 2,
                'Wednesday': 3,
                'Thursday': 4,
                'Friday': 5,
                'Saturday': 6
            };
            return days[dayName];
        }

        // Initialize the form
        document.addEventListener('DOMContentLoaded', function() {
            // Get all day buttons
            const dayButtons = document.querySelectorAll('.day-button');
            
            // Add click event to each button
            dayButtons.forEach(button => {
                const day = button.dataset.day;
                const startTime = parseInt(button.dataset.startTime);
                const endTime = parseInt(button.dataset.endTime);
                
                button.onclick = () => selectDay(button, day, startTime, endTime);
            });
        });
    </script>
</body>
</html>