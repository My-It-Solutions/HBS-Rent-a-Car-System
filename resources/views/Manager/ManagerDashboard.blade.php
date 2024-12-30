<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HBS Car Rental Management System</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Google Fonts for Oxanium -->
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/Style.css') }}">
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                <img src="{{ asset('images/logo.png') }}" class="logo-icon" alt="HBS Car Rental Logo">
            </div>
            <div class="header-title">HBS RENT A CAR</div>
            <div class="card1">
                <div class="card1-content">
                    <form method="POST" class="btn1-submit" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('LogOut') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Sidebar -->
            <div class="sidebar">
                <nav class="nav">
                    <div class="nav-item">
                        <a class="nav-link active" href="{{ url('manager/dashboard') }}">
                            <img src="{{ asset('images/1.png') }}" alt="Dashboard" class="nav-icon"> DASHBOARD
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link"><img src="{{ asset('images/2.png') }}" alt="Vehicles" class="nav-icon">
                            VEHICLES</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-link" href="{{ url('addvehicle') }}">Add Vehicle</a>
                            <a class="dropdown-link" href="{{ url('manager/vehicles') }}">List Vehicle</a>
                        </div>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link"><img src="{{ asset('images/3.png') }}" alt="Bookings" class="nav-icon">
                            BOOKINGS</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-link" href="{{ url('manager/addbook') }}">Book Vehicle</a>
                            <a class="dropdown-link" href="{{ url('bookings') }}">Booking History</a>
                            <a class="dropdown-link" href="{{ url('postbookings') }}">Completed Businesses</a>
                        </div>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link"><img src="{{ asset('images/4.png') }}" alt="Customers" class="nav-icon">
                            CUSTOMERS</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-link" href="{{ url('/customers/create') }}">Add Customer</a>
                            <a class="dropdown-link" href="{{ url('customers') }}">List Customer</a>
                        </div>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="{{ url('hr-management') }}"><img src="{{ asset('images/5.png') }}"
                                alt="HRM" class="nav-icon"> HRM</a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="{{ url('crms') }}"><img src="{{ asset('images/6.png') }}"
                                alt="CRM" class="nav-icon"> CRM</a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="{{ route('inventory.index') }}">
                            <img src="{{ asset('images/7.png') }}" alt="Inventory" class="nav-icon"> INVENTORY
                        </a>
                    </div>
                </nav>
            </div>

            <!-- Main Content Section -->
            <div class="content">
                <div class="card1-content">
                    <div class="welcome-message">
                        <h1>Hi! Welcome Back</h1>
                    </div>
                    <div class="card1-submit-container">
                        <a class="nav-link" href="{{ route('bookings.index') }}"
                            class="card1-btn-submit">AllBookings</a>
                    </div>
                </div>
                <!-- Calendar Section -->
                <div class="calendar">
                    <div class="calendar-header">
                        <a href="{{ route('manager.dashboard', ['month' => $currentMonth - 1, 'year' => $currentYear]) }}"
                            class="month-nav">&lt; Prev</a>
                        <div class="month-year">
                            {{ Carbon\Carbon::create($currentYear, $currentMonth)->format('F Y') }}
                        </div>
                        <a href="{{ route('manager.dashboard', ['month' => $currentMonth + 1, 'year' => $currentYear]) }}"
                            class="month-nav">Next &gt;</a>
                    </div>

                    <div class="calendar-days-header">
                        <div class="calendar-day-name">Sun</div>
                        <div class="calendar-day-name">Mon</div>
                        <div class="calendar-day-name">Tue</div>
                        <div class="calendar-day-name">Wed</div>
                        <div class="calendar-day-name">Thu</div>
                        <div class="calendar-day-name">Fri</div>
                        <div class="calendar-day-name">Sat</div>
                    </div>

                    <div class="calendar-days">
                        @php
                            $daysInMonth = Carbon\Carbon::create($currentYear, $currentMonth)->daysInMonth;
                            $firstDayOfMonth = Carbon\Carbon::create($currentYear, $currentMonth)->startOfMonth()
                                ->dayOfWeek;
                        @endphp

                        <!-- Empty cells for days before the first day of the month -->
                        @for ($i = 0; $i < $firstDayOfMonth; $i++)
                            <div class="calendar-day empty"></div>
                        @endfor

                        <!-- Days of the month -->
                        @for ($i = 1; $i <= $daysInMonth; $i++)
                            @php
                                $date = Carbon\Carbon::create($currentYear, $currentMonth, $i)->toDateString();
                                $count = $bookingCounts[$date] ?? 0;
                                $class = $count > 10 ? 'available' : ($count > 0 ? 'onsite' : 'onhire');
                            @endphp
                            <div class="calendar-day {{ $class }}" data-date="{{ $date }}">
                                {{ $i }}</div>
                        @endfor
                    </div>
                    <div class="status-summary">
                        <div class="status-box available">
                            <img src="{{ asset('images/a.png') }}" alt="Available Icon"> More than 10 Bookings
                        </div>
                        <div class="status-box onsite">
                            <img src="{{ asset('images/b.png') }}" alt="Onsite Icon"> 1-10 Bookings
                        </div>
                        <div class="status-box onhire">
                            <img src="{{ asset('images/c.png') }}" alt="Onhire Icon"> No Bookings
                        </div>
                    </div>
                </div>

                <!-- Modal for Booking Details -->
                <div id="bookingModal" class="modal hidden">
                    <div class="modal-content">
                        <span class="close-btn">&times;</span>
                        <h3>Booking Details</h3>
                        <div id="bookingDetails">Loading...</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© 2024. All rights reserved. Designed by Ezone IT Solutions.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('bookingModal');
            const modalContent = document.getElementById('bookingDetails');
            const closeModalBtn = document.querySelector('.close-btn');
    
            document.querySelectorAll('.calendar-day').forEach(day => {
                day.addEventListener('click', () => {
                    const date = day.getAttribute('data-date');
                    if (date) {
                        fetch(`/manager/bookings?date=${date}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.bookings && data.bookings.length > 0) {
                                    modalContent.innerHTML = `
                                        <ul>
                                            ${data.bookings.map(booking => `
                                                <li>
                                                    ${booking.full_name} - ${booking.vehicle_name} [${booking.vehicle_number}] - ${booking.booking_time}
                                                </li>`).join('')}
                                        </ul>`;
                                } else {
                                    modalContent.innerHTML = '<p>No bookings on this day.</p>';
                                }
                                modal.classList.remove('hidden');
                            })
                            .catch(error => {
                                modalContent.innerHTML = '<p>Error loading bookings.</p>';
                                console.error(error);
                            });
                    }
                });
            });
    
            closeModalBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
    </script>
    
    <style>
        .hidden {
            display: none;
        }

        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            position: relative;
        }

        .close-btn {
            position: absolute;
            right: 10px;
            cursor: pointer;
        }
    </style>
</body>

</html>
