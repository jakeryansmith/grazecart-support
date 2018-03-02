<?php

namespace App\Http\Controllers\Marketing;

use App\Topic;
use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use TheSeer\Tokenizer\Token;

class DocumentationController extends Controller
{
    /**
     * Show all documentation topics.
     *
     * @return mixed
     */
    public function index() {
        return view('marketing.documentation.index')
            ->withTopics(Topic::where('visible')->orderBy('sort_order')->get());
    }

    /**
     * Show individual topic.
     *
     * @param $topicSlug
     * @return mixed
     */
    public function showTopic($topicSlug) {
        $topics = Topic::select(['id','title','slug','icon'])->where('visible', true)->orderBy('sort_order')->get();
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

    /**
     * Show individual article.
     *
     * @param $topicSlug
     * @param $articleSlug
     * @return mixed
     */
    public function showArticle($topicSlug, $articleSlug) {
        $topics = Topic::select(['id','title','slug','icon'])->where('visible', true)->orderBy('sort_order')->get();
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
