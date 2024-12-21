<?php

namespace App\Http\Controllers;

use App\Models\PostBooking;
use App\Models\Booking;
use Illuminate\Http\Request;

class PostBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the query parameters
        $vehicleNumber = $request->input('vehicle_number');
        $fromDate = $request->input('from_date');
        $order = $request->input('order');
    
        // Start building the query
        $query = PostBooking::query();
    
        // Apply filters
        if ($vehicleNumber) {
            $query->where('vehicle_number', 'like', "%$vehicleNumber%");
        }
    
        if ($fromDate) {
            $query->whereDate('from_date', '>=', $fromDate);
        }
    
        // Determine pagination based on order
        if ($order) {
            [$start, $end] = explode('-', $order);
            $query->skip((int) $start - 1)->take((int) $end - (int) $start + 1);
        }
    
        // Get the filtered results, ordered by latest first
        $postBookings = $query->latest()->get();
    
        // Return the view with the filtered results
        return view('Manager.AllPostBookings', compact('postBookings'));
    }
    
    public function create()
    {
        return view('Manager.PostBooking');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'nullable|string',
            'nic' => 'nullable|string',
            'mobile_number' => 'nullable|string',
            'vehicle_number' => 'nullable|string',
            'vehicle' => 'nullable|string',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'base_price' => 'nullable|string',
            'extra_km' => 'nullable|string',
            'extra_hours' => 'nullable|string',
            'damage_fee' => 'nullable|string',
            'after_additional' => 'nullable|string',
            'reason' => 'nullable|string',
            'after_discount' => 'nullable|string',
            'paid' => 'nullable|string',
            'due' => 'nullable|string',
            'total_income' => 'nullable|string',
            'due_paid' => 'nullable|boolean',
            'deposit_refunded' => 'nullable|boolean',
            'vehicle_checked' => 'nullable|boolean',
            'officer' => 'nullable|string',
        ]);
    
        PostBooking::create($validated);

        $booking = Booking::find($request->id); // Assuming `id` is passed in the form
    $booking->update(['status' => 'Completed']);
    
        return redirect()->route('bookings.index');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(PostBooking $postBooking)
    {
        return view('Manager.DetailedPostBookings', compact('postBooking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostBooking $postBooking)
    {
        return view('postbookings.edit', compact('postBooking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PostBooking $postBooking)
    {
        $validated = $request->validate([
            'full_name' => 'nullable|string',
            'nic' => 'nullable|string',
            'mobile_number' => 'nullable|string',
            'vehicle_number' => 'nullable|string',
            'vehicle' => 'nullable|string',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'base_price' => 'nullable|string',
            'extra_km' => 'nullable|string',
            'extra_hours' => 'nullable|string',
            'damage_fee' => 'nullable|string',
            'after_additional' => 'nullable|string',
            'reason' => 'nullable|string',
            'after_discount' => 'nullable|string',
            'paid' => 'nullable|string',
            'due' => 'nullable|string',
            'total_income' => 'nullable|string',
            'due_paid' => 'nullable|boolean',
            'deposit_refunded' => 'nullable|boolean',
            'vehicle_checked' => 'nullable|boolean',
            'officer' => 'nullable|string',
        ]);

        $postBooking->update($validated);

        return redirect()->route('postbookings.index')->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostBooking $postBooking)
    {
        $postBooking->delete();

        return redirect()->route('postbookings.index')->with('success', 'Booking deleted successfully.');
    }
}