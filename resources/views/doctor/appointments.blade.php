<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Appointments</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --success-color: #10b981;
            --success-light: #d1fae5;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --background-light: #f8fafc;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-light);
            margin: 0;
            padding: 20px;
            color: var(--text-primary);
            line-height: 1.5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 40px;
            font-size: 32px;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .section-title {
            font-size: 20px;
            color: var(--text-primary);
            margin: 30px 0 20px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid var(--border-color);
            font-weight: 600;
        }

        .appointments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .appointment-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 24px;
            position: relative;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s ease;
        }

        .appointment-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .appointment-card.today {
            border-left: 4px solid var(--success-color);
            box-shadow: var(--shadow-md);
        }

        .appointment-card.past {
            background: var(--background-light);
            opacity: 0.9;
        }

        .row {
            margin-bottom: 16px;
            display: flex;
            align-items: center;
        }

        .label {
            font-weight: 500;
            width: 120px;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .value {
            color: var(--text-primary);
            font-size: 15px;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 20px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .status.upcoming {
            background: #e0e7ff;
            color: #3730a3;
        }

        .status.today {
            background: var(--success-light);
            color: #065f46;
        }

        .status.past {
            background: #f1f5f9;
            color: var(--text-secondary);
        }

        .status.completed {
            background: #dbeafe;
            color: #1e40af;
        }

        .patient-info {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .medical-record {
            margin-top: 12px;
            padding: 12px;
            background-color: var(--background-light);
            border-radius: 8px;
            font-size: 14px;
            border: 1px solid var(--border-color);
        }

        .complete-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 8px 16px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .complete-btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .complete-btn:disabled {
            background-color: #94a3b8;
            cursor: not-allowed;
            transform: none;
        }

        @media (max-width: 600px) {
            .appointments-grid {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 10px;
            }

            .appointment-card {
                padding: 20px;
            }

            h1 {
                font-size: 24px;
            }
        }

        /* Loading state for the complete button */
        .complete-btn.loading {
            position: relative;
            color: transparent;
        }

        .complete-btn.loading::after {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin: -8px 0 0 -8px;
            border: 2px solid #ffffff;
            border-top-color: transparent;
            border-radius: 50%;
            animation: button-loading 0.6s linear infinite;
        }

        @keyframes button-loading {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Appointments</h1>

        <div class="section-title">Upcoming Appointments</div>
        <div class="appointments-grid">
            @foreach($appointments as $appointment)
                @php
                    $isToday = $appointment->appointment_date == now()->format('Y-m-d');
                    $isPast = $appointment->appointment_date < now()->format('Y-m-d');
                    $isCompleted = $appointment->status === 'completed';
                @endphp
                <div class="appointment-card {{ $isToday ? 'today' : ($isPast ? 'past' : '') }}" id="appointment-{{ $appointment->id }}">
                    @if(!$isCompleted && !$isPast)
                        <button class="complete-btn" 
                                onclick="completeAppointment({{ $appointment->id }})"
                                id="complete-btn-{{ $appointment->id }}">
                            Mark as Done
                        </button>
                    @endif
                    <span class="status {{ $isCompleted ? 'completed' : ($isToday ? 'today' : ($isPast ? 'past' : 'upcoming')) }}"
                          id="status-{{ $appointment->id }}">
                        {{ $isCompleted ? 'Completed' : ($isToday ? 'Today' : ($isPast ? 'Completed' : 'pending')) }}
                    </span>
                    <div class="row">
                        <span class="label">Date:</span>
                        <span class="value">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</span>
                    </div>
                    <div class="row">
                        <span class="label">Time:</span>
                        <span class="value">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</span>
                    </div>
                    @if($appointment->patient && $appointment->patient->user)
                        <div class="patient-info">
                            <div class="row">
                                <span class="label">Patient Name:</span>
                                <span class="value">{{ $appointment->patient->user->name }}</span>
                            </div>
                            <div class="row">
                                <span class="label">Date of Birth:</span>
                                <span class="value">{{ \Carbon\Carbon::parse($appointment->patient->date_of_birth)->format('M d, Y') }}</span>
                            </div>
                            <div class="row">
                                <span class="label">Gender:</span>
                                <span class="value">{{ $appointment->patient->user->gender }}</span>
                            </div>
                            <div class="row">
                                <span class="label">Email:</span>
                                <span class="value">{{ $appointment->patient->user->email }}</span>
                            </div>
                            <div class="row">
                                <span class="label">Phone:</span>
                                <span class="value">
                                    @if($appointment->patient->phone)
                                        {{ $appointment->patient->phone }}
                                    @else
                                        <span style="color: #64748b;">No phone number available</span>
                                    @endif
                                </span>
                            </div>
                            @if($appointment->patient->medical_record)
                                <div class="medical-record">
                                    <div class="row">
                                        <span class="label">Medical Record:</span>
                                    </div>
                                    <div class="value" style="margin-top: 5px;">
                                        {{ $appointment->patient->medical_record }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="patient-info">
                            <div class="row">
                                <span class="value" style="color: #ef4444;">Patient information not available</span>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function completeAppointment(appointmentId) {
            const button = document.getElementById(`complete-btn-${appointmentId}`);
            const statusElement = document.getElementById(`status-${appointmentId}`);
            
            button.disabled = true;
            
            fetch(`/doctor/appointments/${appointmentId}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the status display
                    statusElement.textContent = 'Completed';
                    statusElement.className = 'status completed';
                    
                    // Remove the button
                    button.remove();
                    
                    // Show success message
                    alert('Appointment marked as completed successfully!');
                } else {
                    alert(data.message || 'Failed to update appointment status');
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the appointment status');
                button.disabled = false;
            });
        }
    </script>
</body>
</html>