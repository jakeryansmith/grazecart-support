<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicArticleController extends Controller
{
    public function edit($topicId, $articleId) {
        return view('admin.topics.articles.edit')
            ->withTopic(Topic::whereSlug($topicId)->firstOrFail())
            ->withArticle(Article::whereSlug($articleId)->firstOrFail());
    }

    public function update(Request $request, $topicId, $articleId) {
        Article::findOrFail($articleId)->update($request->all());
        return back();
    }
}
