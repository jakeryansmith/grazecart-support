<?php

namespace App\Http\Controllers\API;

use App\Guide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuidesController extends Controller
{
    /**
     * Return all guides.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index() {
        return Guide::orderBy('sort_order')->get();
    }

    /**
     * Store a new guide.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
        $guide = Guide::create($request->validate([
            'visible' => 'boolean',
            'title' => 'required',
        ]));

        $guide->url = '/guides/'.$guide->slug;
        $guide->save();
        return $guide;
    }

    /**
     * Update the given guide.
     *
     * @param Request $request
     * @param $guideId
     * @return mixed
     */
    public function update(Request $request, $guideId) {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        return tap(Guide::findOrFail($guideId))->update($request->only([
            'title','body','visible','category_id','keywords','url'
        ]));
    }

    /**
     * Delete the given guide.
     *
     * @param $guideId
     * @return mixed
     */
    public function destroy($guideId) {
        Guide::findOrFail($guideId)->delete();
        return response()->json('Guide deleted');
    }
}
