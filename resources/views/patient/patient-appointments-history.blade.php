<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointment History</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-dark: #2563eb;
            --text-color: #1f2937;
            --border-color: #e5e7eb;
            --background-light: #f8fafc;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
            padding: 2rem;
            color: var(--text-color);
            line-height: 1.6;
        }

        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            font-size: 1.25rem;
            color: var(--text-color);
            margin-bottom: 1.5rem;
            padding-left: 1rem;
            border-left: 4px solid var(--primary-color);
            font-weight: 600;
        }

        .appointments-list {
            background: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .appointment-item {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 1.5rem;
            align-items: center;
        }

        .appointment-item:hover {
            background: var(--background-light);
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
        }

        .time-slot {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 140px;
        }

        .doctor-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .doctor-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
        }

        .doctor-details h4 {
            font-size: 1.1rem;
            color: var(--text-color);
            margin-bottom: 0.25rem;
        }

        .doctor-details p {
            color: #64748b;
            font-size: 0.9rem;
        }

        .appointment-status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-confirmed {
            background: #dcfce7;
            color: #166534;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }

            .appointment-item {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .time-slot {
                justify-content: center;
            }

            .doctor-info {
                justify-content: center;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="header">
            <h1>My Appointment History</h1>
        </div>

        <div class="appointments-section">
            <h3 class="section-title">All Appointments</h3>
            <div class="appointments-list">
                @forelse($appointments as $appointment)
                    <div class="appointment-item">
                        <div class="time-slot">
                            <i class="far fa-clock"></i>
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }} at {{ $appointment->appointment_time }}
                        </div>
                        <div class="doctor-info">
                            @if($appointment->doctor->photo)
                                <img src="{{ asset('storage/' . $appointment->doctor->photo) }}" alt="Doctor" class="doctor-avatar">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($appointment->doctor->user->name) }}&background=3b82f6&color=fff" alt="Doctor" class="doctor-avatar">
                            @endif
                            <div class="doctor-details">
                                <h4>Dr. {{ $appointment->doctor->user->name }}</h4>
                                <p>{{ $appointment->doctor->specialization }}</p>
                                <p><i class="fas fa-map-marker-alt"></i> {{ $appointment->doctor->location }}</p>
                                <p><i class="fas fa-phone"></i> {{ $appointment->doctor->phone }}</p>
                            </div>
                        </div>
                        <div class="appointment-status status-{{ $appointment->status }}">
                            <i class="fas fa-circle"></i>
                            {{ ucfirst($appointment->status) }}
                        </div>
                    </div>
                @empty
                    <div class="appointment-item">
                        <p>No appointments found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>