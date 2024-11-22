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
                        <a class="nav-link" href="{{ url('manager/dashboard') }}"><img src="{{ asset('images/1.png') }}"
                                alt="Dashboard" class="nav-icon"> DASHBOARD</a>
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
                        <a class="nav-link active"><img src="{{ asset('images/4.png') }}" alt="Customers" class="nav-icon">
                            CUSTOMERS</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-link" href="{{ url('/customers/create') }}">Add Customer</a>
                            <a class="dropdown-link" href="{{ url('customers') }}">List Customer</a>
                        </div>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link"><img src="{{ asset('images/5.png') }}" alt="HRM" class="nav-icon"> HRM
                            (under development...)</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-link" href="{{ url('manager/addemp') }}">Add Employee</a>
                            <a class="dropdown-link" href="{{ url('manager/emp') }}">List Employee</a>
                            <a class="dropdown-link" href="{{ url('hrm/details') }}">Employee Details</a>
                        </div>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="#"><img src="{{ asset('images/6.png') }}" alt="CRM"
                                class="nav-icon"> CRM (under development...)</a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="#"><img src="{{ asset('images/7.png') }}" alt="Inventory"
                                class="nav-icon"> INVENTORY (under development...)</a>
                    </div>
                    <div class="nav-item">
                        <a class="nav-link" href="#"><img src="{{ asset('images/8.png') }}" alt="Accounting"
                                class="nav-icon"> ACCOUNTING (under development...)</a>
                    </div>
                </nav>
            </div>


            <!-- Form Section -->

            <div class="content">
                <form method="POST" action="{{ route('customers.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-section">
                        {{-- error handling --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-row">
                            <select id="title" name="title" class="selection-list">
                                <option value="" disabled selected>Title</option>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                            </select>
                            <input type="text" id="full_name" name="full_name" placeholder="Full name" required>
                        </div>
                        <div class="form-row">
                            <input type="tel" id="phone" name="phone" placeholder="Mobile number"
                                required>
                            <input type="email" id="email" name="email" placeholder="E-mail address"
                                required>
                        </div>
                        <div class="form-row">
                            <input type="text" id="nic" name="nic" placeholder="NIC Number" required>
                            <input type="text" id="address" name="address" class="address-input"
                                placeholder="Address" required>
                        </div>
                        <div class="form-row">
                            <div class="upload-section">
                                <label for="nic_photos" class="upload-label">
                                    <p>Upload NIC</p>
                                    <input type="file" name="nic_photos[]" id="nic_photos" multiple
                                        class="file-input">
                                </label>
                            </div>
                            <div class="upload-section">
                                <label for="dl_photos" class="upload-label">
                                    <p>Upload Driving Lisance</p>
                                    <input type="file" name="dl_photos[]" id="dl_photos" multiple
                                        class="file-input">
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="submit-container">
                        <button type="submit" class="btn-submit">CANCEL</button>
                        <button type="submit" class="btn-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>© 2024. All rights reserved. Designed by Ezone IT Solutions.</p>
        </div>
    </div>
</body>
<script>
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        initialCountry: "auto",
        geoIpLookup: function(success, failure) {
            fetch("https://ipinfo.io", {
                    headers: {
                        "Accept": "application/json"
                    }
                })
                .then(function(resp) {
                    return resp.json();
                })
                .then(function(resp) {
                    success(resp.country);
                })
                .catch(function() {
                    success("us");
                });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });
</script>

</html>
