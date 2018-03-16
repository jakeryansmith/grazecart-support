<?php

namespace App\Http\Controllers\Admin;

use App\Guide;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuidesController extends Controller
{
    /**
     * Show list of all guides.
     *
     * @return mixed
     */
    public function index() {
        return view('admin.guides.index');
    }

    /**
     * Show page for editing the given guide.
     *
     * @param $guideId
     * @return mixed
     */
    public function edit($guideId) {
        return view('admin.guides.edit')
            ->withGuide(Guide::findOrFail($guideId));
    }

    /**
     * Update the given guide.
     *
     * @param Request $request
     * @param $guideId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $guideId) {

        $guide = tap(Guide::findOrFail($guideId))->update($request->only([
            'title', 'visible', 'keywords', 'cover_photo', 'description', 'draft'
        ]));

        if($guide->draft && $request->filled('draft_body'))
        {
            $guide->draft_body =$request->input('draft_body');
            $guide->save();

            if($request->ajax())
            {
                return response()->json('Saved.');
            }

            return back();
        }

        if(!$guide->draft && $request->filled('body'))
        {
            $guide->body = str_replace('<p></p>','<hr>', $request->get('body'));
            $guide->save();

            if($request->ajax())
            {
                return response()->json('Saved.');
            }

            return back();
        }
        return back();
    }
}
