<?php

namespace App\Http\Controllers\customers;

use App\Http\Controllers\Controller;
use App\Models\IdScheduling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IDSchedulingController extends Controller
{
    public function index()
    {
        $scheduling = IdScheduling::where('customer_id', Auth::guard('customer')->id())->first();
        return view('customers.scheduling.index', compact('scheduling'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_year' => 'required|string',
            'student_no' => 'required|string',
            'guardian_name' => 'required|string',
            'guardian_contact_no' => 'required|string',
            'picture_id' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'e_signature' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $customer_id = Auth::guard('customer')->id();

        // Check if already submitted
        if (IdScheduling::where('customer_id', $customer_id)->exists()) {
            return back()->with('error', 'You have already submitted an ID scheduling request.');
        }

        $data = $request->all();
        $data['customer_id'] = $customer_id;
        $data['status'] = 'Pending';

        if ($request->hasFile('picture_id')) {
            $image = $request->file('picture_id');
            $name = time() . '_pic_' . $customer_id . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/assets/images/id/pictures');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $image->move($destinationPath, $name);
            $data['picture_id'] = $name;
        }

        if ($request->hasFile('e_signature')) {
            $image = $request->file('e_signature');
            $name = time() . '_sig_' . $customer_id . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/assets/images/id/signatures');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            
            $image->move($destinationPath, $name);
            $data['e_signature'] = $name;
        }

        IdScheduling::create($data);

        return redirect()->route('customer.scheduling.index')->with('success', 'ID Scheduling request submitted successfully!');
    }

    public function destroy($id)
    {
        $scheduling = IdScheduling::where('id', $id)
            ->where('customer_id', Auth::guard('customer')->id())
            ->firstOrFail();

        // Optional: Delete physical files
        $picPath = public_path('/assets/images/id/pictures/' . $scheduling->picture_id);
        $sigPath = public_path('/assets/images/id/signatures/' . $scheduling->e_signature);

        if (file_exists($picPath)) @unlink($picPath);
        if (file_exists($sigPath)) @unlink($sigPath);

        $scheduling->delete();

        return redirect()->route('customer.scheduling.index')->with('success', 'You can now submit a new ID request.');
    }
}
