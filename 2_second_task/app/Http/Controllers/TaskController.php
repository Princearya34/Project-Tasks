<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Example function
    public function index()
    {
        return view('tasks.index');
    }
}
