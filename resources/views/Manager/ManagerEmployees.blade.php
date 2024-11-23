<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HBS Car Rental Management System</title>
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
                <img src="logo.png" class="logo-icon" alt="Logo">
            </div>
            <div class="header-title">HBS Car Rental Management System</div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
             <!-- Sidebar -->
             <div class="sidebar">
                <nav class="nav">
                    <div class="nav-item">
                        <a class="nav-link" href="{{ url('manager/dashboard') }}"><img
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
                            <a class="nav-link active" href="{{ url('hr-management') }}"><img
                                    src="{{ asset('images/5.png') }}" alt="HRM" class="nav-icon"> HRM</a>
                        </div>
                    <div class="nav-item">
                        <a class="nav-link" href="#"><img src="{{ asset('images/6.png') }}" alt="CRM"
                                class="nav-icon"> CRM (under development...)</a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="{{ route('inventory.index') }}">
                            <img src="{{ asset('images/7.png') }}" alt="Inventory" class="nav-icon">
                            INVENTORY (under development...)
                        </a>
                    </div>                    
                    <div class="nav-item">
                        <a class="nav-link" href="#"><img src="{{ asset('images/8.png') }}" alt="Accounting"
                                class="nav-icon"> ACCOUNTING (under development...)</a>
                    </div>
                </nav>
            </div>

<div class="table-content">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>EMP ID</th>
                            <th>EMP NAME</th>
                            <th>M/NUMBER</th>
                            <th>JOIN DATE</th>
                            <th>EMAIL ADDRESS</th>
                            <th>DISTRICT </th>
                            <th>NIC NO </th>
                            <th>ADDRESS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>E0001</td>
                            <td>MOHAMED SAHAN</td>
                            <td>+94782877888</td>
                            <td>2024-10-10</td>
                            <td>sahansafa2002@gmail.com</td>
                            <td>ANURADHEPURA</td>
                            <td>200131802340 </td>
                            <td class="text-start">IKKIRIGOLLEWA,<br> WAHAMALGOLLEWA, <br> TEMPLEROAD, <br> ANURADHEPURA.</td>
                        </tr>
                        <tr>
                            <td>E0001</td>
                            <td>MOHAMED SAHAN</td>
                            <td>+94782877888</td>
                            <td>2024-10-10</td>
                            <td>sahansafa2002@gmail.com</td>
                            <td>ANURADHEPURA</td>
                            <td>200131802340 </td>
                            <td class="text-start">IKKIRIGOLLEWA,<br> WAHAMALGOLLEWA, <br> TEMPLEROAD, <br> ANURADHEPURA.</td>
                        </tr>
                        <tr>
                            <td>E0001</td>
                            <td>MOHAMED SAHAN</td>
                            <td>+94782877888</td>
                            <td>2024-10-10</td>
                            <td>sahansafa2002@gmail.com</td>
                            <td>ANURADHEPURA</td>
                            <td>200131802340 </td>
                            <td class="text-start">IKKIRIGOLLEWA,<br> WAHAMALGOLLEWA, <br> TEMPLEROAD, <br> ANURADHEPURA.</td>
                        </tr>
                        <tr>
                            <td>E0001</td>
                            <td>MOHAMED SAHAN</td>
                            <td>+94782877888</td>
                            <td>2024-10-10</td>
                            <td>sahansafa2002@gmail.com</td>
                            <td>ANURADHEPURA</td>
                            <td>200131802340 </td>
                            <td class="text-start">IKKIRIGOLLEWA,<br> WAHAMALGOLLEWA, <br> TEMPLEROAD, <br> ANURADHEPURA.</td>
                        </tr>
                        <tr>
                            <td>E0001</td>
                            <td>MOHAMED SAHAN</td>
                            <td>+94782877888</td>
                            <td>2024-10-10</td>
                            <td>sahansafa2002@gmail.com</td>
                            <td>ANURADHEPURA</td>
                            <td>200131802340 </td>
                            <td class="text-start">IKKIRIGOLLEWA,<br> WAHAMALGOLLEWA, <br> TEMPLEROAD, <br> ANURADHEPURA.</td>
                        </tr>
                        <tr>
                            <td>E0001</td>
                            <td>MOHAMED SAHAN</td>
                            <td>+94782877888</td>
                            <td>2024-10-10</td>
                            <td>sahansafa2002@gmail.com</td>
                            <td>ANURADHEPURA</td>
                            <td>200131802340 </td>
                            <td class="text-start">IKKIRIGOLLEWA,<br> WAHAMALGOLLEWA, <br> TEMPLEROAD, <br> ANURADHEPURA.</td>
                        </tr>
                        <tr>
                            <td>E0001</td>
                            <td>MOHAMED SAHAN</td>
                            <td>+94782877888</td>
                            <td>2024-10-10</td>
                            <td>sahansafa2002@gmail.com</td>
                            <td>ANURADHEPURA</td>
                            <td>200131802340 </td>
                            <td class="text-start">IKKIRIGOLLEWA,<br> WAHAMALGOLLEWA, <br> TEMPLEROAD, <br> ANURADHEPURA.</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
</div>

        <!-- Footer -->
        <div class="footer">
            <p>Copyright © 2022 Golden Ray. All Rights Reserved. Designed By Ezone IT SOLUTION</p>
        </div>
    </div>
</body>
</html>
