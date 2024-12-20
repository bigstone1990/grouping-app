<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class GroupingController extends Controller
{
    public function index() {
        return Inertia::render('Grouping/Index');
    }
}
