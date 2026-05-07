<?php

namespace App\Http\Controllers\customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomersDashboardController extends Controller
{
    public function CustomersDashboardPage()
    {
        return view('customers.dashboard.index');
    }
}
