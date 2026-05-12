<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function StudentsPage()
    {
        $students = Customers::latest()->get();
        return view('students.index', compact('students'));
    }

    public function StoreStudent(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone_number' => 'required|string|max:20',
            'gender' => 'required|string',
            'password' => 'required|string|min:8',
            'address' => 'nullable|string',
            'department' => 'nullable|string',
            'grade_year' => 'nullable|string',
            'program' => 'nullable|string',
        ]);

        Customers::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'department' => $request->department,
            'grade_year' => $request->grade_year,
            'program' => $request->program,
            'is_verified' => 1, // Admin-created accounts are verified by default
        ]);

        return back()->with('success', 'Student account created successfully!');
    }

    public function UpdateStudent(Request $request, $id)
    {
        $student = Customers::findOrFail($id);

        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $id,
            'phone_number' => 'required|string|max:20',
            'gender' => 'required|string',
            'password' => 'nullable|string|min:8',
            'address' => 'nullable|string',
            'department' => 'nullable|string',
            'grade_year' => 'nullable|string',
            'program' => 'nullable|string',
        ]);

        $data = $request->only(['fullname', 'email', 'phone_number', 'gender', 'address', 'department', 'grade_year', 'program']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $student->update($data);

        return back()->with('success', 'Student account updated successfully!');
    }

    public function DeleteStudent($id)
    {
        $student = Customers::findOrFail($id);
        $student->delete();

        return back()->with('success', 'Student account deleted successfully!');
    }
}
