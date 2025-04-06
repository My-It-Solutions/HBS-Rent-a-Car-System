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
                        <a class="nav-link" href="{{ url('manager/dashboard') }}"><img src="{{ asset('images/1.png') }}"
                                alt="Dashboard" class="nav-icon"> DASHBOARD</a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link"><img src="{{ asset('images/2.png') }}" alt="Vehicles" class="nav-icon">
                            VEHICLES</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-link" href="{{ url('addvehicle') }}">Add Vehicle</a>
                            <a class="dropdown-link" href="{{ url('manager/vehicles') }}">List Vehicle</a>
                            <a class="dropdown-link" href="{{ url('vehicle_owners') }}">Vehicle Owner Management</a>
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
                        <a class="nav-link active" href="{{ url('hr-management') }}"><img
                                src="{{ asset('images/5.png') }}" alt="HRM" class="nav-icon"> HRM</a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="{{ url('crms') }}"><img src="{{ asset('images/6.png') }}"
                                alt="CRM" class="nav-icon"> CRM</a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="{{ route('inventory.index') }}">
                            <img src="{{ asset('images/7.png') }}" alt="Inventory" class="nav-icon">
                            INVENTORY
                        </a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="#"><img src="{{ asset('images/8.png') }}" alt="Accounting"
                                class="nav-icon"> Finance</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-link" href="{{ url('expenses') }}">Expences</a>
                            <a class="dropdown-link" href="{{ url('profit-loss-report') }}">P/L Report</a>
                            {{-- <a class="dropdown-link" href="{{ url('customers') }}">Cash Book</a> --}}
                        </div>
                    </div>
                </nav>
            </div>

            <div class="content">
                <div class="card1">
                    <div class="card1-content">
                        <a href="{{ route('hrmanagement') }}" class="btn-submit">Back</a>
                    </div><br>
                    <div class="card1-content">
                        <a href="{{ route('attendances.index') }}" class="btn-submit">View Attendances Sheet</a>
                    </div>
                </div>

                <div class="table-content">
                    <table>
                        <thead>
                            <tr>
                                <th></th>
                                <th>Employee Name</th>
                                <th>Employee ID</th>
                                <th>Current Day</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <td>
                                        @if (!empty($employee->photo) && isset($employee->photo[0]))
                                            <img src="{{ asset('storage/' . $employee->photo[0]) }}" alt="emp Image"
                                                style="width: 100px; height: auto;">
                                        @else
                                            No Image Available
                                        @endif
                                    </td>
                                    <td>{{ $employee->emp_name }}</td>
                                    <td>{{ $employee->emp_id }}</td>
                                    <td>{{ now()->format('Y-m-d') }}</td>
                                    <td>
                                        <div style="display: flex; justify-content: center; gap: 5px;">
                                            <form method="POST"
                                                action="{{ route('attendance.store', ['id' => $employee->id, 'type' => 'Normal']) }}"
                                                class="attendance-form">
                                                @csrf
                                                <button type="submit" class="btn-edit"
                                                    {{ $employee->attendance_today ? 'disabled' : '' }}>Normal Working
                                                    Day</button>
                                            </form>

                                            <form method="POST"
                                                action="{{ route('attendance.store', ['id' => $employee->id, 'type' => 'Half Day']) }}"
                                                class="attendance-form">
                                                @csrf
                                                <button type="submit" class="btn-edit"
                                                    style="background-color: orange; color: white;"
                                                    {{ $employee->attendance_today ? 'disabled' : '' }}>Half Day
                                                    Leave</button>
                                            </form>

                                            <form method="POST"
                                                action="{{ route('attendance.store', ['id' => $employee->id, 'type' => 'Leave']) }}"
                                                class="attendance-form">
                                                @csrf
                                                <button type="submit" class="btn-edit"
                                                    style="background-color: red; color: white;"
                                                    {{ $employee->attendance_today ? 'disabled' : '' }}>Leave</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                @if (session('success'))
                    <div style="color: green;">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div style="color: red;">{{ session('error') }}</div>
                @endif

            </div>
        </div>
        <!-- Footer -->
        <div class="footer">
            <p>© 2024. All rights reserved. Designed by Ezone IT Solutions.</p>
        </div>
    </div>
</body>
<script>
    const forms = document.querySelectorAll('.attendance-form');

    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const buttons = form.querySelectorAll('button');
            buttons.forEach(button => {
                button.disabled = true;
                button.innerText = 'Processing...';
            });
        });
    });
</script>

</html>
