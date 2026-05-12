<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\IdScheduling;
use App\Mail\IDApprovedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminIDSchedulingController extends Controller
{
    public function index()
    {
        $schedulings = IdScheduling::with('customer')->orderBy('created_at', 'desc')->get();
        return view('admins.scheduling.index', compact('schedulings'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pick_up_date' => 'required|date|after:today',
            'status' => 'required|in:Approved,Pending,Rejected'
        ]);

        $scheduling = IdScheduling::findOrFail($id);
        $scheduling->update([
            'pick_up_date' => $request->pick_up_date,
            'status' => $request->status
        ]);

        if ($request->status === 'Approved') {
            // Send email to student
            $student = $scheduling->customer;
            if ($student && $student->email) {
                Mail::to($student->email)->send(new IDApprovedMail($scheduling));
            }
        }

        return back()->with('success', 'ID Request status updated and student notified!');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $scheduling = IdScheduling::findOrFail($id);
        $scheduling->update([
            'status' => 'Rejected'
        ]);

        // Send rejection email
        $student = $scheduling->customer;
        if ($student && $student->email) {
            Mail::to($student->email)->send(new \App\Mail\IDRejectedMail($scheduling, $request->reason));
        }

        return response()->json(['success' => true, 'message' => 'Request rejected and student notified.']);
    }
}
