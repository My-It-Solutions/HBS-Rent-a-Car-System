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
        <form action="{{ route('bookings.update', $booking->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="form-section">
                <h1 class="title">Edit Booking</h1>
                
                <!-- Show Success or Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-row">
                    <label for="full_name" class="form-label">Full Name</label>
                    <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name', $booking->full_name) }}" required>
                    @error('full_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label for="mobile_number" class="form-label">Mobile Number</label>
                    <input type="text" name="mobile_number" id="mobile_number" class="form-control" value="{{ old('mobile_number', $booking->mobile_number) }}" required>
                    @error('mobile_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label for="nic" class="form-label">NIC</label>
                    <input type="text" name="nic" id="nic" class="form-control" value="{{ old('nic', $booking->nic) }}" readonly>
                    @error('nic')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <label for="from_date" class="form-label">From Date</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" value="{{ old('from_date', $booking->from_date) }}" required>
                    @error('from_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label for="booking_time" class="form-label">Booking Time</label>
                    <input type="time" name="booking_time" id="booking_time" class="form-control" value="{{ old('booking_time', $booking->booking_time) }}" required>
                    @error('booking_time')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-row">
                    <label for="to_date" class="form-label">To Date</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" value="{{ old('to_date', $booking->to_date) }}" required>
                    @error('to_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label for="arrival_time" class="form-label">Arrival Time</label>
                    <input type="time" name="arrival_time" id="arrival_time" class="form-control" value="{{ old('arrival_time', $booking->arrival_time) }}" required>
                    @error('arrival_time')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <label for="vehicle_number" class="form-label">Vehicle Number</label>
                    <input type="text" name="vehicle_number" id="vehicle_number" class="form-control" value="{{ old('vehicle_number', $booking->vehicle_number) }}" readonly>
                    @error('vehicle_number')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <label for="vehicle_name" class="form-label">Vehicle Name</label>
                    <input type="text" name="vehicle_name" id="vehicle_name" class="form-control" value="{{ old('vehicle_name', $booking->vehicle_name) }}" readonly>
                    @error('vehicle_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <label for="deposit" class="form-label">Deposit</label>
                    <input type="text" name="deposit" id="deposit" class="form-control" value="{{ old('deposit', $booking->deposit) }}" >
                    @error('deposit')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <label for="officer" class="form-label">Released Officer</label>
                    <input type="text" name="officer" id="officer" class="form-control" value="{{ old('officer', $booking->officer) }}" >
                    @error('officer')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <label for="method" class="form-label">Payment Note</label>
                    <input type="text" name="method" class="form-control" value="{{ old('method', $booking->method) }}" >
                    @error('method')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <label for="driving_photos" class="form-label">Update Driving Photos</label>
                    <input type="file" name="driving_photos[]" id="driving_photos" class="form-control" multiple>
                    @error('driving_photos')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <label for="nic_photos" class="form-label">Update NIC Photos</label>
                    <input type="file" name="nic_photos[]" id="nic_photos" class="form-control" multiple>
                    @error('nic_photos')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="submit-container">
                    <button type="submit" class="btn-submit">Update Booking</button>
                    <a href="{{ route('bookings.index') }}" class="btn-submit">Cancel</a>
                </div>
        </div>
        </form>
    </div>
</body>
</html>
