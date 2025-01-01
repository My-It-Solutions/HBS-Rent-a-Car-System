<?php

namespace App\Http\Controllers;

use App\Models\Ownerpayment;
use App\Models\VehicleOwner;
use Illuminate\Http\Request;

class OwnerpaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ownerpayments = collect(); // Start with an empty collection
    
        // Check if 'full_name' parameter exists
        if ($request->filled('full_name')) {
            // Perform the query only if the 'full_name' is provided
            $ownerpayments = Ownerpayment::where('full_name', 'LIKE', '%' . $request->input('full_name') . '%')->get();
        }
    
        return view('Manager.AllOwnerPay', compact('ownerpayments'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vehicleOwners = VehicleOwner::select('id', 'full_name','title')->get();
        return view('Manager.AddOwnerPay' , compact('vehicleOwners'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|exists:vehicleowners,id', // Validate the selected ID exists in vehicleowners table
            'vehicle' => 'required|string|max:255',
            'date' => 'required|date',
            'paid_amnt' => 'required|string',
            'bank_details' => 'nullable|string|max:255',
            'acc_no' => 'required|string|max:255',
        ]);
    
        // Retrieve the vehicle owner based on the selected ID
        $vehicleOwner = VehicleOwner::find($request->full_name);
    
        // Concatenate the title with the full name
        $fullNameWithTitle = $vehicleOwner->title . ' ' . $vehicleOwner->full_name;
    
        // Store the data in the ownerpayments table
        Ownerpayment::create([
            'full_name' => $fullNameWithTitle, // Store the owner's full name with title
            'vehicle' => $request->vehicle,
            'date' => $request->date,
            'paid_amnt' => $request->paid_amnt,
            'bank_details' => $request->bank_details,
            'acc_no' => $request->acc_no,
        ]);
    
        return redirect()->route('ownerpayments.index')
                         ->with('success', 'Owner payment created successfully.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Ownerpayment $ownerpayment)
    {
        return view('ownerpayments.show', compact('ownerpayment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ownerpayment $ownerpayment)
    {
        return view('Manager.EditOwnerPay', compact('ownerpayment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ownerpayment $ownerpayment)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'vehicle' => 'required|string|max:255',
            'date' => 'required|date',
            'paid_amnt' => 'required|string',
            'bank_details' => 'nullable|string|max:255',
            'acc_no' => 'required|string|max:255',
        ]);

        $ownerpayment->update($request->all());

        return redirect()->route('ownerpayments.index')
                         ->with('success', 'Owner payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ownerpayment $ownerpayment)
    {
        $ownerpayment->delete();

        return redirect()->route('ownerpayments.index')
                         ->with('success', 'Owner payment deleted successfully.');
    }
}