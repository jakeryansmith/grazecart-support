<?php

namespace App\Http\Controllers\API;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicArticleController extends Controller
{
    /**
     * Return all articles.
     * @param $topicId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index($topicId) {
        return Article::where('topic_id', $topicId)->orderBy('sort_order')->get();
    }

    /**
     * Store a new article.
     * @param Request $request
     * @param $topicId
     * @return mixed
     */
    public function store(Request $request, $topicId) {
        $request->merge(['topic_id' => $topicId]);
        return Article::create($request->validate([
            'title' => 'required',
            'topic_id' => 'required'
        ]));
    }

    /**
     * Update the given article.
     * @param Request $request
     * @param $articleId
     * @return mixed
     */
    public function update(Request $request, $topicId, $articleId) {
        $request->validate([
            'title' => 'required'
        ]);
        return tap(Article::findOrFail($articleId))->update($request->all());
    }

    /**
     * Delete the given article.
     * @param $articleId
     * @return mixed
     */
    public function destroy($topicId, $articleId) {
        Article::findOrFail($articleId)->delete();
        return response()->json('Document deleted');
    }
}
