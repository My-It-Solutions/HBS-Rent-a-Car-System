<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Display a listing of customers
    public function index(Request $request)
    {
        $search = $request->input('search');

        // If a search query exists, filter customers by NIC
        if ($search) {
            $customers = Customer::where('nic', 'LIKE', "%{$search}%")->get();
        } else {
            $customers = Customer::all();
        }

        return view('Manager.ManagerCustomers', compact('customers'));
    }

    // Show the form for creating a new customer
    public function create()
    {
        return view('Manager.ManagerAddCustomer');
    }

    // Store a newly created customer in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:10',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
            'whatsapp' => 'nullable|max:20',
            'email' => 'nullable|email|max:255', // Make email optional
            'nic' => 'required|string|max:12|unique:customers,nic',
            'address' => 'required|string|max:255',
            'nic_photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'dl_photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $nicPhotos = [];
        $dlPhotos = [];

        if ($request->hasFile('nic_photos')) {
            foreach ($request->file('nic_photos') as $file) {
                $nicPhotos[] = $file->store('uploads/nic_photos', 'public');
            }
        }

        if ($request->hasFile('dl_photos')) {
            foreach ($request->file('dl_photos') as $file) {
                $dlPhotos[] = $file->store('uploads/dl_photos', 'public');
            }
        }

        $validated['nic_photos'] = $nicPhotos;
        $validated['dl_photos'] = $dlPhotos;

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
    }

    // Show the form for editing the specified customer
    public function edit(Customer $customer)
    {
        return view('Manager.ManagerEditCustomer', compact('customer'));
    }

    // Update the specified customer in storage
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:10',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
            'whatsapp' => 'nullable|max:20',
            'email' => 'nullable|email|max:255', // Make email optional
            'nic' => 'required|string|max:12|unique:customers,nic,' . $customer->id,
            'address' => 'required|string|max:255',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    // Remove the specified customer from storage
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $customers = Customer::where('full_name', 'LIKE', "%{$query}%")->get();

        return response()->json($customers);
    }

    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return redirect()->route('customers.index')->with('error', 'Customer not found.');
        }

        return view('Manager.DetailedCustomer', compact('customer'));
    }

    public function getCustomerDetails($id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            return response()->json([
                'phone' => $customer->phone,
                'nic' => $customer->nic,
            ]);
        } else {
            return response()->json([
                'message' => 'Customer not found',
            ], 404);
        }
    }
}
