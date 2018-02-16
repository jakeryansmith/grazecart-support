<?php

namespace App\Http\Controllers\Admin;

use App\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicController extends Controller
{
    public function index() {
        return view('admin.topics.index');
    }

    public function edit($topicId) {
        return view('admin.topics.edit')->withTopic(Topic::whereSlug($topicId)->firstOrFail());
    }

    public function update(Request $request, $topicId) {
        Topic::findOrFail($topicId)->update($request->all());
        return back();
    }
}
