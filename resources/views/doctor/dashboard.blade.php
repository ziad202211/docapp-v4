<!-- resources/views/doctor/dashboard.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/doctor-dashboard.css') }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        html {
            margin: 0;
            padding: 0;
        }

        .alert {
            padding: 15px;
            margin: 20px 0;
            border: 1px solid transparent;
            border-radius: 4px;
            font-size: 16px;
            position: relative;
            animation: slideIn 0.5s ease-out;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .alert .close-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px;
            color: inherit;
            background: none;
            border: none;
            padding: 0 5px;
        }

        .alert .close-btn:hover {
            opacity: 0.8;
        }

        .notification-wrapper {
            position: relative;
            margin-right: 20px;
        }

        .notification-icon {
            cursor: pointer;
            position: relative;
            font-size: 24px;
            color: #4a5568;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.1);
            padding: 8px;
            border-radius: 50%;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .notification-icon:hover {
            transform: scale(1.1) rotate(15deg);
            color: #2d3748;
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(135deg, #ff4d4d, #ff1a1a);
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            font-weight: bold;
            min-width: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(255, 77, 77, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 77, 77, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(255, 77, 77, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(255, 77, 77, 0);
            }
        }

        .notification-box {
            position: absolute;
            top: 100%;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            width: 380px;
            max-height: 500px;
            overflow-y: auto;
            display: none;
            z-index: 1000;
            margin-top: 10px;
            transform-origin: top right;
        }

        .notification-box.active {
            display: block;
            animation: scaleIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .notification-item {
            padding: 18px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(5px);
            margin: 4px;
            border-radius: 12px;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item:hover {
            background: rgba(255, 255, 255, 0.9);
            transform: translateX(-4px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .notification-content {
            flex: 1;
            margin-right: 10px;
        }

        .notification-content p {
            margin: 0 0 8px 0;
            font-weight: 600;
            color: #1a202c;
            font-size: 15px;
            letter-spacing: 0.3px;
        }

        .notification-content small {
            color: #4a5568;
            font-size: 13px;
            line-height: 1.6;
            display: block;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin: 2px 0;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .status-pending {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #92400e;
        }
        
        .status-confirmed {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #166534;
        }
        
        .status-cancelled {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #991b1b;
        }
        
        .status-completed {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
        }

        /* Custom scrollbar for notification box */
        .notification-box::-webkit-scrollbar {
            width: 6px;
        }

        .notification-box::-webkit-scrollbar-track {
            background: rgba(241, 241, 241, 0.5);
            border-radius: 3px;
            margin: 4px;
        }

        .notification-box::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #cbd5e0, #a0aec0);
            border-radius: 3px;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .notification-box::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #a0aec0, #718096);
        }

        /* No notifications message styling */
        .notification-box p {
            text-align: center;
            color: #718096;
            padding: 30px;
            font-size: 14px;
            font-style: italic;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            margin: 4px;
        }

        /* Profile Update Section Styles */
        .profile-section {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        .profile-section h2 {
            color: #1a202c;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .profile-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 45px;
        }

        .form-group {
            position: relative;
            margin-bottom: 30px;
        }

        .form-group label {
            display: block;
            margin-bottom: 12px;
            color: #2d3748;
            font-weight: 600;
            font-size: 15px;
        }

        .form-group input[type="text"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background: #ffffff;
            color: #2d3748;
            font-size: 15px;
            transition: border-color 0.2s ease;
            margin-bottom: 8px;
        }

        .form-group input[type="text"]:focus {
            outline: none;
            border-color: #4299e1;
            background: #f8fafc;
        }

        .form-group input[type="file"] {
            padding: 12px;
            background: #f8fafc;
            cursor: pointer;
        }

        .form-group input[type="file"]::-webkit-file-upload-button {
            background: #4299e1;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            margin-right: 10px;
        }

        .submit-btn {
            grid-column: 1 / -1;
            background: #4299e1;
            color: white;
            padding: 16px 32px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 30px;
        }

        .submit-btn:hover {
            background: #3182ce;
        }

        /* Profile Photo Preview */
        .photo-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e2e8f0;
            margin: 10px 0;
        }

        /* Form Validation Styles */
        .form-group input:invalid {
            border-color: #fc8181;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-section {
                margin: 20px;
                padding: 20px;
            }

            .profile-form {
                grid-template-columns: 1fr;
            }

            .submit-btn {
                width: 100%;
            }
        }

        /* Availability Section Styles */
        .availability-section {
            max-width: 1000px;
            margin: 40px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        .availability-section h2 {
            color: #1a202c;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
        }

        .day-schedule {
            margin-bottom: 25px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }

        .day-schedule:hover {
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .day-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .day-header strong {
            font-size: 18px;
            color: #2d3748;
            font-weight: 600;
            margin-right: 20px;
        }

        .day-off-toggle {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .day-off-toggle label {
            color: #4a5568;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .day-off-toggle input[type="checkbox"] {
            width: 18px;
            height: 18px;
            border: 2px solid #e2e8f0;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
        }

        .day-off-toggle input[type="checkbox"]:checked {
            background-color: #4299e1;
            border-color: #4299e1;
        }

        .time-range {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .time-select {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .time-select label {
            color: #4a5568;
            font-weight: 500;
            font-size: 14px;
        }

        .time-select select {
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background: #ffffff;
            color: #2d3748;
            font-size: 14px;
            cursor: pointer;
            transition: border-color 0.2s ease;
        }

        .time-select select:focus {
            outline: none;
            border-color: #4299e1;
        }

        .save-schedule-btn {
            background: #4299e1;
            color: white;
            padding: 16px 32px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 30px;
            width: 100%;
            max-width: 300px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .save-schedule-btn:hover {
            background: #3182ce;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .availability-section {
                margin: 20px;
                padding: 20px;
            }

            .time-range {
                grid-template-columns: 1fr;
            }

            .day-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .day-off-toggle {
                margin-left: 0;
            }
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background: #2563eb;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid #1d4ed8;
        }

        .navbar-left a {
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 0.5px;
            transition: color 0.2s ease;
        }

        .navbar-left a:hover {
            color: #bfdbfe;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .navbar-right a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .navbar-right a:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
        }

        .notification-icon {
            position: relative;
            font-size: 22px;
            color: #ffffff;
            cursor: pointer;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.2s ease;
        }

        .notification-icon:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 11px;
            font-weight: 600;
            min-width: 18px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
        }

        .navbar-right img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .navbar-right img:hover {
            border-color: #ffffff;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px 20px;
            }

            .navbar-left a {
                font-size: 18px;
            }

            .navbar-right {
                gap: 15px;
            }

            .navbar-right a {
                padding: 6px 12px;
                font-size: 14px;
            }

            .navbar-right img {
                width: 35px;
                height: 35px;
            }
        }
    </style>
</head>
<body>
<div class="navbar">
    <div class="navbar-left">
        <a href="{{ route('doctor.dashboard') }}">Doctor Dashboard</a>
    </div>
    <div class="navbar-right">
        <div class="notification-wrapper">
            <div class="notification-icon notification-bell" onclick="toggleNotifications()" style="color: white;">🔔
                @if(isset($notifications) && $notifications->count() > 0)
                    <span class="notification-badge">{{ $notifications->count() }}</span>
                @endif
            </div>
            <div class="notification-box" id="notificationBox">
                @if(isset($notifications) && $notifications->count() > 0)
                    @foreach($notifications as $notification)
                        <div class="notification-item" data-id="{{ $notification['id'] }}" data-doctor-id="{{ $notification['doctor_id'] }}">
                            <div class="notification-content">
                                <p style="color: #2196F3; font-weight: bold;">{{ $notification['data']['message'] ?? 'No message' }}</p>
                                <small>
                                    <strong>Patient:</strong> {{ $notification['data']['patient_name'] ?? 'Unknown' }}<br>
                                    <strong>Status:</strong> <span class="status-badge status-{{ $notification['data']['status'] ?? 'pending' }}">{{ ucfirst($notification['data']['status'] ?? 'pending') }}</span><br>
                                    <strong>Appointment Date:</strong> {{ \Carbon\Carbon::parse($notification['data']['appointment_date'])->format('M d, Y') }}<br>
                                    <strong>Appointment Time:</strong> {{ \Carbon\Carbon::parse($notification['data']['appointment_time'])->format('h:i A') }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p style="text-align: center; color: #666; padding: 20px;">No notifications found</p>
                @endif
            </div>
        </div>
        <a href="{{ route('doctor.appointments') }}" style="color: white;">Appointments</a>
        <a href="{{ route('logout') }}" style="color: white; margin-left: 20px; text-decoration: none;" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <img src="{{ Auth::user()->doctor->photo ? asset('storage/' . Auth::user()->doctor->photo) : asset('default-profile.png') }}" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
    </div>
</div>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    // Initialize Pusher
    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        encrypted: true
    });

    // Subscribe to the private channel for the doctor
    const channel = pusher.subscribe('private-doctor.{{ Auth::id() }}');

    // Listen for the AppointmentBooked event
    channel.bind('AppointmentBooked', function(data) {
        console.log('New notification received:', data);
        
        // Create new notification element
        const notificationBox = document.getElementById('notificationBox');
        const notificationItem = document.createElement('div');
        notificationItem.className = 'notification-item';
        notificationItem.setAttribute('data-id', data.notification.id);
        
        const notificationContent = `
            <div class="notification-content">
                <p style="color: #2196F3; font-weight: bold;">${data.notification.data.message}</p>
                <small>
                    <strong>Patient:</strong> ${data.notification.data.patient_name}<br>
                    <strong>Phone:</strong> ${data.notification.data.patient_phone}<br>
                    <strong>Appointment Date:</strong> ${new Date(data.notification.data.appointment_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric', timeZone: 'Africa/Cairo' })}<br>
                    <strong>Appointment Time:</strong> ${new Date('2000-01-01 ' + data.notification.data.appointment_time).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', timeZone: 'Africa/Cairo' })}<br>
                    <strong>Location:</strong> ${data.notification.data.location}<br>
                    <strong>Status:</strong> <span class="status-badge status-${data.notification.data.status}">${data.notification.data.status.charAt(0).toUpperCase() + data.notification.data.status.slice(1)}</span>
                </small>
            </div>
        `;
        
        notificationItem.innerHTML = notificationContent;
        
        // Add animation class
        notificationItem.classList.add('new-notification');
        
        // Insert at the top of the notification box
        if (notificationBox.firstChild) {
            notificationBox.insertBefore(notificationItem, notificationBox.firstChild);
        } else {
            notificationBox.appendChild(notificationItem);
        }
        
        // Update notification badge
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            badge.textContent = parseInt(badge.textContent) + 1;
        } else {
            const notificationIcon = document.querySelector('.notification-icon');
            const newBadge = document.createElement('span');
            newBadge.className = 'notification-badge';
            newBadge.textContent = '1';
            notificationIcon.appendChild(newBadge);
        }
        
        // Show notification box if it's hidden
        notificationBox.classList.add('active');
        
        // Play notification sound
        const audio = new Audio('{{ asset('sounds/notification.mp3') }}');
        audio.play().catch(e => console.log('Audio play failed:', e));
    });

    // Add animation styles
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .new-notification {
            animation: slideIn 0.5s ease-out;
        }
    `;
    document.head.appendChild(style);

    function toggleNotifications() {
        const box = document.getElementById('notificationBox');
        box.classList.toggle('active');
    }

    function markAsRead(notificationId) {
        fetch(`/doctor/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const notification = document.querySelector(`.notification-item[data-id="${notificationId}"]`);
                if (notification) {
                    notification.remove();
                }
                
                // Update notification count
                const badge = document.querySelector('.notification-badge');
                if (badge) {
                    const count = parseInt(badge.textContent) - 1;
                    if (count > 0) {
                        badge.textContent = count;
                    } else {
                        badge.remove();
                        document.querySelector('.notification-box p').textContent = 'No new notifications';
                    }
                }
            }
        });
    }

    // Close notification box when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.notification-wrapper')) {
            document.getElementById('notificationBox').classList.remove('active');
        }
    });
</script>

<h1>Welcome, Dr. {{ Auth::user()->name }}</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
@endif

<h2>Update Your Profile</h2>
<div class="profile-section">
    <form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
    @csrf
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="{{ Auth::user()->doctor->title ?? '' }}" required>
        </div>

        <div class="form-group">
            <label>Degree</label>
            <input type="text" name="degree" value="{{ Auth::user()->doctor->degree ?? '' }}" required>
        </div>

        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" value="{{ Auth::user()->doctor->location ?? '' }}" required>
        </div>

        <div class="form-group">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ Auth::user()->doctor->phone ?? '' }}" required>
        </div>

        <div class="form-group">
            <label>Photo</label>
            @if(Auth::user()->doctor->photo)
                <img src="{{ asset('storage/' . Auth::user()->doctor->photo) }}" alt="Profile Photo" class="photo-preview">
            @endif
            <input type="file" name="photo" accept="image/*">
        </div>

        <button type="submit" class="submit-btn">Update Profile</button>
</form>
</div>

<h2>Set Your Availability</h2>
<div class="availability-section">
<form action="{{ route('doctor.schedule.store') }}" method="POST">
    @csrf
    @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
            <div class="day-schedule">
                <div class="day-header">
                    <strong>{{ $day }}</strong>
                    <div class="day-off-toggle">
                        <label>
                <input type="checkbox" name="availability[{{ $day }}][off]" value="1"
                                onchange="toggleAvailability(this, '{{ $day }}')">
                            Day Off
            </label>
                    </div>
                </div>

                <div id="time-range-{{ $day }}" class="time-range">
                    <div class="time-select">
                        <label>From:</label>
                <select name="availability[{{ $day }}][from]">
                    @for ($i = 0; $i < 24; $i++)
                        <option value="{{ $i }}">
                            {{ date('g:i A', mktime($i, 0)) }}
                        </option>
                    @endfor
                </select>
                    </div>

                    <div class="time-select">
                        <label>To:</label>
                <select name="availability[{{ $day }}][to]">
                    @for ($i = 1; $i <= 24; $i++)
                        <option value="{{ $i }}">
                            {{ date('g:i A', mktime($i, 0)) }}
                        </option>
                    @endfor
                </select>
                    </div>
            </div>
        </div>
    @endforeach

        <button type="submit" class="save-schedule-btn">Save Schedule</button>
</form>
</div>

<script>
    function toggleAvailability(checkbox, day) {
        const container = document.getElementById('time-range-' + day);
        container.style.display = checkbox.checked ? 'none' : 'block';
    }
</script>
</body>
</html>
