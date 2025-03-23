<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        // Ensure only 'admin' role users can access this controller
        $this->middleware('role:admin');
    }

    /**
     * Show the Admin Dashboard.
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
