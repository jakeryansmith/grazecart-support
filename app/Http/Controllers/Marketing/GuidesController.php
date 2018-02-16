<?php

namespace App\Http\Controllers\Marketing;

use App\Guide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuidesController extends Controller
{
    /**
     * Show page of all guides
     *
     * @return mixed
     */
    public function index()
    {
        return view('marketing.guides.index')->withGuides(Guide::where('visible', true)->orderBy('sort_order')->get());
    }

    public function show($guideId)
    {
        return view('marketing.guides.show')->withGuide(Guide::whereSlug($guideId)->where('visible', true)->firstOrFail());
    }
}
