<?php

namespace Sova\Admin\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin::dashboard');
    }
}