<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Management System</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <!-- Google Fonts for Oxanium -->
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/Style.css') }}">
    <style>
        /* Custom styling to fit content within viewport */
        body {
            font-family: 'Oxanium', sans-serif;
            /* Font family */
            font-weight: bold;
            /* Make all text bold */
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f8f9fa;
        }

        .card-body {
            padding: 0.5rem;
            /* Reduces padding inside cards */
        }

        .text-center {
            margin: 0.5rem 0;
            /* Reduces top and bottom margins */
        }

        /* Font size adjustments */
        h1 {
            font-size: 2rem;
            /* Reduced main heading font size */
            text-align: center;
            margin-left: 20%;
        }

        h5 {
            font-size: 1.6rem;
            /* Reduced subheading font size */
            margin-bottom: 0;
            te
        }

        p,
        button,
        .text-muted {
            font-size: 1.2rem;
            /* Reduced paragraph and button font size */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            @if ($vehicle)
                <div class="form-section">
                    <h1>vehicle's Details</h1>
                    <h5 class="card-title text-primary mb-3">Vehicle Informations</h5>
                    <p><strong>Vehcile:</strong> <span id="fullName">{{ $vehicle->vehicle_model }}
                            {{ $vehicle->vehicle_name }} [{{ $vehicle->vehicle_type }}]</span></p>
                    <p><strong>Register Number:</strong> <span id="mobileNumber">{{ $vehicle->vehicle_number }}</span>
                    </p>
                    <p><strong>Engine Number:</strong> <span id="mobileNumber">{{ $vehicle->engine_number }}</span></p>
                    <p><strong>Chassis Number:</strong> <span id="nic">{{ $vehicle->chassis_number }}</span></p>
                    <p><strong>Manufactured Year:</strong> <span id="nic">{{ $vehicle->model_year }}</span></p>

                    <h5 class="card-title text-primary mb-3">Price Informations</h5>
                    <p><strong>Price Per Day:</strong> <span id="nic">{{ $vehicle->price_per_day }}</span></p>
                    <p><strong>Free KM Range:</strong> <span id="nic">{{ $vehicle->free_km }}</span></p>
                    <p><strong>Price For Additional 1KM:</strong> <span
                            id="nic">{{ $vehicle->extra_km_chg }}</span></p>

                    <h5 class="card-title text-primary mb-3">Documents Informations</h5>
                    <p><strong>License Expire Date:</strong> <span
                            id="nic">{{ $vehicle->license_exp_date }}</span></p>
                    <p><strong>Insurance Expire Date:</strong> <span
                            id="nic">{{ $vehicle->insurance_exp_date }}</span></p>

                    <!-- Photos Section -->
                    <h5 class="card-title text-primary mt-3 mb-2">Photos</h5>
                    <div class="form-section">

                        @if (!empty($vehicle->images))
                            @foreach ($vehicle->images as $photo)
                                <div class="col-6 col-md-4 col-lg-3 mb-3">
                                    <img src="{{ asset('storage/' . $photo) }}" class="img-fluid img-thumbnail">
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted">No Images for this vehicle.</p>
                        @endif
                    </div>


                    <!-- Edit and Delete Buttons -->
                    <div class="submit-container">
                        <div class="form-row">
                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn-edit">Edit vehicle</a>

                            <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete"
                                    onclick="return confirm('Are you sure you want to delete this vehicle?')">Delete
                                    vehicle</button>
                            </form>
                        </div>
                    </div>

                </div>
            @else
                <p class="text-center text-danger mt-3">No vehicle found.</p>
            @endif
        </div>
    </div>
</body>

</html>
