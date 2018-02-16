<?php

namespace App\Http\Controllers\API;

use App\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicController extends Controller
{
    /**
     * Return all topics.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index() {
        return Topic::orderBy('sort_order')->get();
    }

    /**
     * Store a new topic.
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
        return Topic::create($request->validate([
            'title' => 'required'
        ]));
    }

    /**
     * Update the given topic.
     * @param Request $request
     * @param $topicId
     * @return mixed
     */
    public function update(Request $request, $topicId) {
        $request->validate([
            'title' => 'required'
        ]);
        return tap(Topic::findOrFail($topicId))->update($request->all());
    }

    /**
     * Delete the given topic.
     * @param $topicId
     * @return mixed
     */
    public function destroy($topicId) {
        Topic::findOrFail($topicId)->delete();
        return response()->json('Topic deleted');
    }
}
