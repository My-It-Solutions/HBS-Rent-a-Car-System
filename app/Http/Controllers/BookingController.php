<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    // Display all bookings
    public function index(Request $request)
    {
        $query = Booking::query();
    
        if ($request->filled('mobile_number')) {
            $query->where('mobile_number', 'LIKE', "%" . $request->input('mobile_number') . "%");
        }
    
        if ($request->filled('full_name')) {
            $query->where('full_name', 'LIKE', "%" . $request->input('full_name') . "%");
        }
    
        if ($request->filled('vehicle_number')) {
            $query->where('vehicle_number', 'LIKE', "%" . $request->input('vehicle_number') . "%");
        }
    
        if ($request->filled('id')) {
            $query->where('id', $request->input('id')); // Exact match for ID
        }
    
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
    
        // Date Range Filtering
        if ($request->filled('from_date')) {
            $query->whereDate('from_date', '>=', $request->input('from_date'));
        }
    
        if ($request->filled('to_date')) {
            $query->whereDate('from_date', '<=', $request->input('to_date'));
        }
    
        $bookings = $query->orderBy('created_at', 'desc')->get();
    
        // Fetch distinct values for dropdowns
        $vehicleNumbers = Booking::select('vehicle_number')->distinct()->pluck('vehicle_number');
        $fullNames = Booking::select('full_name')->distinct()->pluck('full_name');
        $statuses = Booking::select('status')->distinct()->pluck('status');
    
        return view('Manager.ManagerBookings', compact('bookings', 'vehicleNumbers', 'fullNames', 'statuses'));
    }
    
    




    // Show form to create a new booking
    public function create()
    {
        return view('bookings.create');
    }

    // Store new booking data and redirect to DetailedBooking.blade.php
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable',
            'full_name' => 'required|string|max:255',
            'mobile_number' => 'required',
            'nic' => 'nullable|string|max:20',
            'deposit' => 'nullable',
            'booking_time' => 'required',
            'arrival_time' => 'required',
            'price_per_day' => 'required|numeric',
            'vehicle_number' => 'required',
            'fuel_type' => 'required',
            'vehicle_name' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'officer' => 'nullable|string',
            'reason' => 'nullable|string',
            'method' => 'nullable|string',
            'guarantor' => 'nullable|string',
            'extra_km_chg' => 'nullable|string',
            'free_km' => 'nullable|string',
            'free_kmd' => 'nullable|string',
            'start_km' => 'nullable|string',
            'driving_photos.*' => 'nullable|file|mimes:jpg,jpeg,png',
            'nic_photos.*' => 'nullable|file|mimes:jpg,jpeg,png',
            'deposit_img.*' => 'nullable|file|mimes:jpg,jpeg,png',
            'grnt_nic.*' => 'nullable|file|mimes:jpg,jpeg,png',
            'status' => 'nullable',
        ]);

        $validatedData['additional_chagers'] = $validatedData['additional_chagers'] ?? 0.00;
        $validatedData['discount_price'] = $validatedData['discount_price'] ?? 0.00;

        // Calculate days and total price
        $fromDateTime = new \DateTime($request->input('from_date') . ' ' . $request->input('booking_time'));
        $toDateTime = new \DateTime($request->input('to_date') . ' ' . $request->input('arrival_time'));
        $interval = $fromDateTime->diff($toDateTime);
        $days = ceil(($interval->days * 24 + $interval->h) / 24);
        $pricePerDay = $request->input('price_per_day');
        $additionalCharges = $request->input('additional_chagers') ?? 0;
        $discountPrice = $request->input('discount_price') ?? 0;
        $payed = $request->input('payed') ?? 0;
        $totalPrice = ($pricePerDay * $days) + $additionalCharges - $discountPrice - $payed;

        $request->merge(['days' => $days, 'price' => $totalPrice]);

        // Save booking data
        $booking = new Booking($request->except(['driving_photos', 'nic_photos', 'deposit_img']));

        // Handle file uploads
        $booking->driving_photos = $request->hasFile('driving_photos')
            ? $this->uploadFiles($request->file('driving_photos'), 'driving_photos')
            : [];
        $booking->nic_photos = $request->hasFile('nic_photos')
            ? $this->uploadFiles($request->file('nic_photos'), 'nic_photos')
            : [];
        $booking->deposit_img = $request->hasFile('deposit_img')
            ? $this->uploadFiles($request->file('deposit_img'), 'deposit_img')
            : [];
        $booking->grnt_nic = $request->hasFile('grnt_nic')
            ? $this->uploadFiles($request->file('grnt_nic'), 'grnt_nic')
            : [];            

        $booking->save();

        if (!empty($request->input('nic')) && !Customer::where('nic', $request->input('nic'))->exists()) {
            // Store customer data in customers table only if NIC is unique
            Customer::create([
                'title' => $request->input('title'),
                'full_name' => $request->input('full_name'),
                'phone' => $request->input('mobile_number'),
                'nic' => $request->input('nic'),
                // Add more fields if necessary
            ]);
        }

        return redirect()->route('bookings.show', ['id' => $booking->id])
            ->with('success', 'Booking created successfully.');
    }

    /**
     * Helper function to handle file uploads.
     */
    private function uploadFiles($files, $directory)
    {
        $filePaths = [];
        foreach ($files as $file) {
            $path = $file->store($directory, 'public');
            $filePaths[] = $path;
        }
        return $filePaths;
    }


    // Show a specific booking

    // Show a specific booking
    public function show($id)
    {
        // Fetch the specific booking using the ID
        $booking = Booking::findOrFail($id);

        // Fetch the customer information based on the booking's full_name
        $customer = Customer::where('full_name', $booking->full_name)->first();

        // Pass both booking and customer data to the view
        return view('Manager.DetailedBooking', compact('booking', 'customer'));
    }

    // Show form to edit a booking
    public function edit(Booking $booking)
    {
        return view('Manager.EditBooking', compact('booking'));
    }

    // Update booking data
    public function update(Request $request, Booking $booking)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255',
            'mobile_number' => 'required',
            'nic' => 'nullable|string|max:20',
            'deposit' => 'nullable',
            'booking_time' => 'required',
            'arrival_time' => 'required',
            'vehicle_number' => 'nullable',
            'fuel_type' => 'nullable',
            'vehicle_name' => 'nullable',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'officer' => 'nullable|string',
            'method' => 'nullable|string',
            'guarantor' => 'nullable|string',
            'payed' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'discount_price' =>'nullable|string',
            'additional_chagers'=>'nullable|string',
            'price' =>'nullable|string',
            'deposit' =>'nullable|string',
            'reason' =>'nullable|string',
            'start_km' => 'nullable|string',
            'driving_photos.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'nic_photos.*' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validatedData['additional_chagers'] = $validatedData['additional_chagers'] ?? 0.00;
        $validatedData['discount_price'] = $validatedData['discount_price'] ?? 0.00;

        // Update basic details
        $booking->update($validatedData);

        // Handling Driving Photos (if new ones are uploaded)
        if ($request->hasFile('driving_photos')) {
            // Delete old photos
            if ($booking->driving_photos) {
                foreach ($booking->driving_photos as $oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }

            // Store new photos
            $drivingPhotos = [];
            foreach ($request->file('driving_photos') as $photo) {
                $path = $photo->store('driving_photos', 'public');
                $drivingPhotos[] = $path;
            }
            $booking->driving_photos = $drivingPhotos;
        }

        // Handling NIC Photos (if new ones are uploaded)
        if ($request->hasFile('nic_photos')) {
            // Delete old photos
            if ($booking->nic_photos) {
                foreach ($booking->nic_photos as $oldPhoto) {
                    Storage::disk('public')->delete($oldPhoto);
                }
            }

            // Store new photos
            $nicPhotos = [];
            foreach ($request->file('nic_photos') as $photo) {
                $path = $photo->store('nic_photos', 'public');
                $nicPhotos[] = $path;
            }
            $booking->nic_photos = $nicPhotos;
        }

        // Save JSON fields explicitly
        $booking->save();

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }


    // Delete a booking
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }



    public function calendarView()
    {
        // Get the current month and year for the calendar
        $currentMonth = request()->input('month', now()->month);
        $currentYear = request()->input('year', now()->year);

        // Calculate the start and end of the selected month
        $startDate = Carbon::createFromDate($currentYear, $currentMonth, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // Fetch bookings grouped by day
        $bookingCounts = Booking::whereBetween('from_date', [$startDate, $endDate])
            ->selectRaw('DATE(from_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        // Pass data to the calendar view
        return view('Manager.ManagerDashboard', compact('bookingCounts', 'currentMonth', 'currentYear'));
    }

    public function getBookingsByDate(Request $request)
    {
        $date = $request->input('date');
    
        // Get bookings for the 'from_date' (IN)
        $inBookings = Booking::whereDate('from_date', $date)->pluck('vehicle_number');
    
        // Get bookings for the 'to_date' (OUT)
        $outBookings = Booking::whereDate('to_date', $date)->pluck('vehicle_number');
    
        // Get all booked vehicles for the selected date
        $bookedVehicles = $inBookings->merge($outBookings)->unique();
    
        // Get all vehicle numbers from vehicles table
        $allVehicles = Vehicle::pluck('vehicle_number');
    
        // Get available vehicles (not in bookedVehicles)
        $availableVehicles = $allVehicles->diff($bookedVehicles);
    
        // Fetch vehicle details for available vehicles
        $availableVehiclesData = Vehicle::whereIn('vehicle_number', $availableVehicles)->get();
    
        return response()->json([
            'in_bookings' => Booking::whereDate('from_date', $date)->get(),
            'out_bookings' => Booking::whereDate('to_date', $date)->get(),
            'available_vehicles' => $availableVehiclesData
        ]);
    }
    
    


    public function postBooking($id)
    {
        // Fetch the booking details using the ID
        $booking = Booking::findOrFail($id);

        // Pass the relevant details to the view
        return view('Manager.PostBooking', compact('booking'));
    }   
}