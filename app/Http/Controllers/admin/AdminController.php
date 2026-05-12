<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminsPage()
    {
        $admins = Admins::latest()->get();
        return view('admins.admins.index', compact('admins'));
    }

    public function StoreAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
        ]);

        Admins::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Admin account created successfully!');
    }

    public function UpdateAdmin(Request $request, $id)
    {
        $admin = Admins::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:admins,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return back()->with('success', 'Admin account updated successfully!');
    }

    public function DeleteAdmin($id)
    {
        // Prevent deleting yourself if possible, or just delete
        $admin = Admins::findOrFail($id);
        
        // Count how many admins left
        if (Admins::count() <= 1) {
            return back()->with('error', 'Cannot delete the only admin account left.');
        }

        $admin->delete();

        return back()->with('success', 'Admin account deleted successfully!');
    }
}
