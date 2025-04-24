<!-- resources/views/doctor/dashboard.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/doctor-dashboard.css') }}">
    <style>
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
    </style>
</head>
<body>
<div class="navbar">
    <div class="navbar-left">
        <a href="{{ route('doctor.dashboard') }}">Doctor Dashboard</a>
    </div>
    <div class="navbar-right">
        <div class="notification-wrapper">
            <div class="notification-icon notification-bell" onclick="toggleNotifications()">🔔</div>
            <div class="notification-box" id="notificationBox">
                <p>No new notifications</p>
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

<script>
    function toggleNotifications() {
        const box = document.getElementById('notificationBox');
        box.classList.toggle('active');
    }

    window.addEventListener('click', function(e) {
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
<form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>Title:</label>
    <input type="text" name="title" value="{{ Auth::user()->doctor->title ?? '' }}" required><br>

    <label>Degree:</label>
    <input type="text" name="degree" value="{{ Auth::user()->doctor->degree ?? '' }}" required><br>

    <label>Location:</label>
    <input type="text" name="location" value="{{ Auth::user()->doctor->location ?? '' }}" required><br>

    <label>Phone:</label>
    <input type="text" name="phone" value="{{ Auth::user()->doctor->phone ?? '' }}" required><br>

    <label>Photo:</label>
    <input type="file" name="photo"><br>

    <button type="submit">Save Profile</button>
</form>

<h2>Set Your Availability</h2>
<form action="{{ route('doctor.schedule.store') }}" method="POST">
    @csrf
    @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day)
        <div style="margin-bottom: 20px; border: 1px solid #ccc; padding: 15px; border-radius: 8px; background-color: #f9f9f9;">
            <strong style="font-size: 18px;">{{ $day }}</strong>
            <label style="margin-left: 15px; font-weight: normal;">
                <input type="checkbox" name="availability[{{ $day }}][off]" value="1"
                    onchange="toggleAvailability(this, '{{ $day }}')"> Day Off
            </label>
            <br><br>

            <div id="time-range-{{ $day }}">
                <label style="margin-right: 10px;">From:</label>
                <select name="availability[{{ $day }}][from]">
                    @for ($i = 0; $i < 24; $i++)
                        <option value="{{ $i }}">
                            {{ date('g:i A', mktime($i, 0)) }}
                        </option>
                    @endfor
                </select>

                <label style="margin-left: 20px; margin-right: 10px;">To:</label>
                <select name="availability[{{ $day }}][to]">
                    @for ($i = 1; $i <= 24; $i++)
                        <option value="{{ $i }}">
                            {{ date('g:i A', mktime($i, 0)) }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
    @endforeach

    <button type="submit">Save Schedule</button>
</form>

<script>
    function toggleAvailability(checkbox, day) {
        const container = document.getElementById('time-range-' + day);
        container.style.display = checkbox.checked ? 'none' : 'block';
    }
</script>
</body>
</html>
