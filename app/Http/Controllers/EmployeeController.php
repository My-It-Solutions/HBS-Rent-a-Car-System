<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Show a list of all employees.
     */
    public function index()
    {
        $businessId = Auth::user()->business_id; // Get the logged-in user's business ID

        $employees = Employee::where('business_id', $businessId)->get(); // Filter by business_id

        return view('Manager.ManagerEmployees', compact('employees'));
    }


    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        return view('Manager.AddEmp');
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'emp_name' => 'required|string|max:255',
            'nic' => 'required|string|max:20|unique:employees,nic',
            'mobile_number' => 'required|string|max:15',
            'salary' => 'nullable|string',
            'acc_number'  => 'required|string|max:30',
            'bank' => 'required|string',
            'email' => 'required|email|unique:employees,email',
            'address' => 'required|string|max:255',
            'join_date' => 'required|date',
            'birthday' => 'nullable|date',
            'remaining_leaves' => 'required|integer|min:0',
            'photo.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'doc_photos.*' => 'file|mimes:pdf,doc,docx,jpeg,png,jpg,gif|max:5120'
        ]);
        $businessId = Auth::user()->business_id;

        // Auto-generate emp_id
        $lastEmployee = Employee::orderBy('id', 'desc')->first();
        $nextId = $lastEmployee ? $lastEmployee->id + 1 : 1;
        $empId = 'Emp' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Handle file uploads
        $photoPaths = [];
        $docPhotoPaths = []; // Array to store doc_photos paths

        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $photo) {
                $photoPaths[] = $photo->store('employee_photos', 'public');
            }
        }

        if ($request->hasFile('doc_photos')) {
            foreach ($request->file('doc_photos') as $docPhoto) {
                $docPhotoPaths[] = $docPhoto->store('employee_documents', 'public');
            }
        }

        // Set salary and remaining_salary values
        $salary = $request->salary ?? '0'; // Default to '0' if null
        $remainingSalary = $salary; // Remaining salary should be the same as salary initially

        // Create Employee
        Employee::create([
            'business_id' => $businessId,
            'emp_id' => $empId,
            'title' => $request->title,
            'emp_name' => $request->emp_name,
            'nic' => $request->nic,
            'mobile_number' => $request->mobile_number,
            'salary'  => $salary,
            'remaining_salary' => $remainingSalary, // Set remaining_salary same as salary
            'acc_number' => $request->acc_number,
            'bank' => $request->bank,
            'email' => $request->email,
            'address' => $request->address,
            'join_date' => $request->join_date,
            'age' => $this->calculateAge($request->birthday),
            'remaining_leaves' => $request->remaining_leaves,
            'photo' => $photoPaths,
            'doc_photos' => $docPhotoPaths,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }


    /**
     * Show the form for editing the specified employee.
     */
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('Manager.EditEmployee', compact('employee'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'emp_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'salary' => 'nullable|string',
            'acc_number' => 'required|string|max:30',
            'bank' => 'required|string',
            'join_date' => 'required|date',
            'email' => 'required|email',
            'age' => 'required',
            'nic' => 'required|string|max:12',
            'address' => 'required|string',
            'photo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'doc_photos.*' => 'nullable|file|mimes:pdf,doc,docx,jpeg,png,jpg,gif|max:5120',
        ]);

        $employee = Employee::findOrFail($id);

        // Update basic employee fields
        $employee->update($request->only(['emp_name', 'mobile_number', 'acc_number', 'bank', 'join_date', 'email', 'age', 'nic', 'address']));

        // Handle photo update
        $photoPaths = $employee->photo ?? [];

        if ($request->hasFile('photo')) {
            foreach ($photoPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            $photoPaths = [];
            foreach ($request->file('photo') as $file) {
                $photoPaths[] = $file->store('employee_photos', 'public');
            }

            $employee->update(['photo' => $photoPaths]);
        }

        // Handle document photo update
        $docPhotoPaths = $employee->doc_photos ?? [];

        if ($request->hasFile('doc_photos')) {
            foreach ($docPhotoPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            $docPhotoPaths = [];
            foreach ($request->file('doc_photos') as $docFile) {
                $docPhotoPaths[] = $docFile->store('employee_documents', 'public');
            }

            $employee->update(['doc_photos' => $docPhotoPaths]);
        }

        // Run the copy storage function
        $this->copyStorageToPublic();

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    // Function to copy storage to public
    private function copyStorageToPublic()
    {
        $source = storage_path('app/public');
        $destination = public_path('storage');

        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }

        $this->copyDirectory($source, $destination);
    }

    // Helper function to copy directories
    private function copyDirectory($source, $destination)
    {
        $directory = opendir($source);

        if (!file_exists($destination)) {
            mkdir($destination, 0777, true);
        }

        while (($file = readdir($directory)) !== false) {
            if ($file !== '.' && $file !== '..') {
                $srcFile = $source . DIRECTORY_SEPARATOR . $file;
                $destFile = $destination . DIRECTORY_SEPARATOR . $file;

                if (is_dir($srcFile)) {
                    $this->copyDirectory($srcFile, $destFile);
                } else {
                    copy($srcFile, $destFile);
                }
            }
        }

        closedir($directory);
    }



    /**
     * Remove the specified employee from storage.
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        // Delete associated photos
        if ($employee->photo) {
            foreach ($employee->photo as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }

    /**
     * Calculate age from birthday.
     */
    private function calculateAge($birthday)
    {
        if ($birthday) {
            // Convert the birthday string into a DateTime object
            $birthdayDate = new \DateTime($birthday);
            $currentDate = new \DateTime(); // Get the current date

            // Calculate the difference in years
            $age = $currentDate->diff($birthdayDate)->y;

            return $age; // Return the whole number of years
        }

        return null;
    }

    public function search(Request $request)
    {
        $query = $request->get('query', '');
        $employees = Employee::where('emp_id', 'like', "%$query%")
            ->orWhere('emp_name', 'like', "%$query%")
            ->select('emp_id', 'emp_name')
            ->get();

        return response()->json($employees);
    }

    public function show($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            // Redirect or handle the error if the vehicle is not found
            return redirect()->route('employees.index')->with('error', 'Employee not found.');
        }

        // Pass the customer data to the view
        return view('Manager.ManagerDetailedEmployee', compact('employee'));
    }


    public function autocomplete(Request $request)
    {
        $query = $request->get('term', '');
        $businessId = Auth::user()->business_id;

        $employees = Employee::where('business_id', $businessId) // Filter by business_id
            ->where('emp_name', 'LIKE', $query . '%')
            ->distinct()
            ->pluck('emp_name');

        return response()->json($employees);
    }


    public function searche(Request $request)
    {
        $search = $request->input('q');
        $employees = Employee::where('emp_name', 'LIKE', "%{$search}%")
            ->select('emp_id', 'emp_name')
            ->get();

        return response()->json($employees);
    }
}
