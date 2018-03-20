<?php

namespace App\Http\Controllers\Admin;

use App\Topic;
use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicArticleController extends Controller
{
    /**
     * Show the form for editing the Article.
     *
     * @param $topicId
     * @param $articleId
     * @return mixed
     */
    public function edit($topicId, $articleId) {
        return view('admin.topics.articles.edit')
            ->withTopic(Topic::whereSlug($topicId)->firstOrFail())
            ->withArticle(Article::whereSlug($articleId)->firstOrFail());
    }

    /**
     * Update the given Article.
     *
     * @param Request $request
     * @param $topicId
     * @param $articleId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $topicId, $articleId) {
        Article::findOrFail($articleId)->update($request->all());
        return back();
    }
}
