<?php

namespace App\Http\Controllers\Marketing;

use App\Topic;
use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use TheSeer\Tokenizer\Token;

class DocumentationController extends Controller
{
    public function index() {
        return view('marketing.documentation.index')->withTopics(Topic::all());
    }

    public function showTopic($topicSlug) {
        $topics = Topic::select(['id','title','slug','icon'])->where('visible', true)->get();
        $topic = Topic::whereSlug($topicSlug)->firstOrFail();
        $articles = Article::where('topic_id', $topic->id)
            ->where('visible', true)
            ->with('sections')
            ->orderBy('sort_order', 'asc')
            ->get();

        if($articles->isEmpty())
        {
            abort(404);
        }

        return view('marketing.documentation.topic')
            ->withActiveLink($articles->first()->slug)
            ->withArticle($articles->first())
            ->withArticles($articles)
            ->withTopics($topics)
            ->withTopic($topic);
    }

    public function showArticle($topicSlug, $articleSlug) {
        $topics = Topic::select(['id','title','slug','icon'])->where('visible', true)->get();
        $topic = Topic::whereSlug($topicSlug)->firstOrFail();
        $articles = Article::where('topic_id', $topic->id)
            ->where('visible', true)
            ->with('sections')
            ->orderBy('sort_order', 'asc')
            ->get();

        $article = Article::with('sections')->whereSlug($articleSlug)
            ->where('visible', true)
            ->with('sections')
            ->orderBy('sort_order', 'asc')
            ->firstOrFail();

        if($articles->isEmpty())
        {
            abort(404);
        }

        $activeLink = $article->slug;

        return view('marketing.documentation.topic')
            ->withActiveLink($activeLink)
            ->withArticle($article)
            ->withArticles($articles)
            ->withTopics($topics)
            ->withTopic($topic);
    }

}
