<?php

namespace App\Http\Controllers\API;

use App\Article;
use App\ArticleSection;
use App\Topic;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicArticleSectionController extends Controller
{
    /**
     * Return all sections for the given article.
     * @param $articleId
     * @return mixed
     */
    public function index($topicId, $articleId) {
        return ArticleSection::orderBy('sort_order')
            ->where('article_id', $articleId)
            ->get();
    }

    /**
     * Save a new section for the given article.
     * @param Request $request
     * @param $topicId
     * @param $articleId
     * @return mixed
     */
    public function store(Request $request, $topicId, $articleId) {
        $request->validate([
            'title' => 'required',
            'tags' => 'nullable'
        ]);

        $topic = Topic::findOrFail($topicId);
        $article = Article::findOrFail($articleId);

        $section = ArticleSection::create([
            'title' => $request->get('title'),
            'article_id' => $articleId,
            'sort_order' => 0,
        ]);

        $section->url = '/docs/topic/'.$topic->slug.'/article/'.$article->slug.'#'.$section->slug;
        $section->save();

        return response()->json($section, 200);
    }

    /**
     * Update the section for the given article.
     * @param Request $request
     * @param $articleId
     * @param $sectionId
     * @return mixed
     */
    public function update(Request $request, $topicId, $articleId, $sectionId) {
        return tap(ArticleSection::findOrFail($sectionId))
            ->update($request->only('sort_order'));
    }

    /**
     * Update the section for the given article.
     * @param $articleId
     * @param $sectionId
     * @return mixed
     */
    public function destroy($topicId, $articleId, $sectionId) {
        ArticleSection::findOrFail($sectionId)->delete();
        return response()->json('Segment deleted');
    }
}
