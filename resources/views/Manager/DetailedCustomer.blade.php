<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Management System</title>
    <!-- Google Fonts for Oxanium -->
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jsPDF CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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

        .container {
            max-height: 90vh;
            /* Adjusts max height to fit within the screen */
            overflow-y: auto;
            padding: 1rem;
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
            font-size: 1.5rem;
            /* Reduced main heading font size */
        }

        h5,
        h6 {
            font-size: 1rem;
            /* Reduced subheading font size */
        }

        p,
        button,
        .text-muted {
            font-size: 0.875rem;
            /* Reduced paragraph and button font size */
        }
    </style>
</head>

<body>

    <div class="container my-3">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-3">Customer's Details</h1>

                @if ($customer)
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary mb-3">Informations</h5>
                            <p><strong>Full Name:</strong> <span id="fullName">{{ $customer->title }}
                                    {{ $customer->full_name }}</span></p>
                            <p><strong>Mobile Number:</strong> <span id="mobileNumber">{{ $customer->phone }}</span></p>
                            <p><strong>WhatsApp Number:</strong> <span
                                    id="whatsapp">{{ $customer->whatsapp ?? 'No Whatsapp Number exists' }}</span></p>
                            <p><strong>Email Address:</strong> <span
                                    id="mobileNumber">{{ $customer->email ?? 'No email exists' }}</span></p>
                            <p><strong>NIC:</strong> <span id="nic">{{ $customer->nic }}</span></p>

                            <!-- Photos Section -->
                            <h5 class="card-title text-primary mt-3 mb-2">Photos</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>NIC Photos</h6>
                                    <div class="row">
                                        @if (!empty($customer->nic_photos))
                                            @foreach ($customer->nic_photos as $photo)
                                                <div class="col-6 col-md-4 col-lg-3 mb-3">
                                                    <img src="{{ asset('storage/' . $photo) }}"
                                                        class="img-fluid img-thumbnail" alt="NIC Photo">
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted">No NIC photos for this vehicle.</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Driving Licsence Photos</h6>
                                    <div class="row">
                                        @if (!empty($customer->dl_photos))
                                            @foreach ($customer->dl_photos as $photo)
                                                <div class="col-6 col-md-4 col-lg-3 mb-3">
                                                    <img src="{{ asset('storage/' . $photo) }}"
                                                        class="img-fluid img-thumbnail" alt="DL Photo">
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted">No NIC photos available.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Edit and Delete Buttons -->
                            <div class="mt-3">
                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">Edit
                                    customer</a>

                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this customer?')">Delete
                                        customer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-center text-danger mt-3">No customer found.</p>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
