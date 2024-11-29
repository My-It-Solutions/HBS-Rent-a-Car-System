<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HBS Car Rental Management System</title>
    <!-- Google Fonts for Oxanium -->
    <link rel="stylesheet" href="{{ asset('css/Style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;700&display=swap" rel="stylesheet">

</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo-section">
                <img src="{{ asset('images/logo.png') }}" class="logo-icon" alt="HBS Car Rental Logo">
            </div>
            <div class="header-title">HBS Car Rental Management System</div>
            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        <!-- Main Content -->
        <div class="main-content">
            <!-- Sidebar -->
            <div class="sidebar">
                <nav class="nav">
                    <div class="nav-item">
                        <a class="nav-link active" href="{{ url('manager/dashboard') }}"><img
                                src="{{ asset('images/1.png') }}" alt="Dashboard" class="nav-icon"> DASHBOARD</a>
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
                            <a class="nav-link" href="{{ url('hr-management') }}"><img
                                    src="{{ asset('images/5.png') }}" alt="HRM" class="nav-icon"> HRM</a>
                        </div>
                    <div class="nav-item">
                        <a class="nav-link" href="{{ url('crms')}}"><img src="{{ asset('images/6.png') }}" alt="CRM"
                                class="nav-icon"> CRM</a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="{{ route('inventory.index') }}">
                            <img src="{{ asset('images/7.png') }}" alt="Inventory" class="nav-icon">
                            INVENTORY 
                        </a>
                    </div>                    
                    <div class="nav-item">
                        <a class="nav-link" href="#"><img src="{{ asset('images/8.png') }}" alt="Accounting"
                                class="nav-icon"> ACCOUNTING (under development...)</a>
                    </div>
                </nav>
            </div>

            <!-- Main Content Section -->
            <div class="content">
                <!-- Calendar Section -->
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <a href="{{ route('bookings.index') }}" class="btn btn-primary">View All Bookings</a>
                    </div>
                    <div class="welcome-message">
                        <h2>Hi</h2>
                        <h1>Welcome Back</h1>
                    </div>
                
                    <div class="calendar">
                        <div class="calendar-header">
                            <a href="{{ route('manager.dashboard', ['month' => $currentMonth - 1, 'year' => $currentYear]) }}" 
                               class="btn btn-sm btn-secondary">&lt; Prev</a>
                            <div class="month-year">
                                {{ Carbon\Carbon::create($currentYear, $currentMonth)->format('F Y') }}
                            </div>
                            <a href="{{ route('manager.dashboard', ['month' => $currentMonth + 1, 'year' => $currentYear]) }}" 
                               class="btn btn-sm btn-secondary">Next &gt;</a>
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
                                $firstDayOfMonth = Carbon\Carbon::create($currentYear, $currentMonth)->startOfMonth()->dayOfWeek;
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
                                <div class="calendar-day {{ $class }}">{{ $i }}</div>
                            @endfor
                        </div>
                        <div class="status-summary">
                            <div class="status-box available">
                                <img src="{{ asset('images/a.png') }}" alt="Available Icon">
                                More than 10 Bookings
                            </div>
                            <div class="status-box onsite">
                                <img src="{{ asset('images/b.png') }}" alt="Onsite Icon">
                                Avarage
                            </div>
                            <div class="status-box onhire">
                                <img src="{{ asset('images/c.png') }}" alt="Onhire Icon">
                                No Bookings 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© 2024. All rights reserved. Designed by Ezone IT Solutions.</p>
        </div>
    </div>
</body>
</html>
