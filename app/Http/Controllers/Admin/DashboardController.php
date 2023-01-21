<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use function inertia;

class DashboardController extends Controller
{
    protected $screen = 'Admin/Dashboard';

    public function index()
    {
        return inertia($this->screen);
    }
}
