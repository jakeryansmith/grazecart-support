<?php

namespace App\Http\Controllers\Marketing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomepageController extends Controller
{
    public function index() {
        return view('marketing.index');
    }
}
