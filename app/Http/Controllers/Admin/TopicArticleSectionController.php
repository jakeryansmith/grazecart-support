<?php

namespace App\Http\Controllers\Admin;

use App\Topic;
use App\Article;
use App\ArticleSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopicArticleSectionController extends Controller
{
    /**
     * Show the form for editing the Article Section.
     *
     * @param $topic
     * @param $article
     * @param $section
     * @return mixed
     */
    public function edit($topic, $article, $section) {
        return view('admin.topics.articles.sections.edit')
            ->withTopic(Topic::whereSlug($topic)->firstOrFail())
            ->withArticle(Article::whereSlug($article)->firstOrFail())
            ->withSection(ArticleSection::whereSlug($section)->firstOrFail());
    }

    /**
     * Update the given Article Section
     *
     * @param Request $request
     * @param $topicId
     * @param $articleId
     * @param $sectionId
     * @return \Illuminate\Http\RedirectResponse
     * @internal param $topic
     * @internal param $article
     */
    public function update(Request $request, $topicId, $articleId, $sectionId)
    {
        $request->validate([
            'title' => 'sometimes|required',
            'keywords' => 'nullable',
            'body' => 'required',
            'visible' => 'boolean'
        ]);

        $request['body'] = str_replace('<p></p>','<hr>', $request->get('body'));

        $articleSection = tap(ArticleSection::findOrFail($sectionId))->update($request->only([
            'title','description','url','keywords','body','visible','slug'
        ]));

        if($request->has('slug'))
        {
            $url = explode('#', $articleSection->url);
            $articleSection->url = $url[0].'#'.$request->get('slug');
            $articleSection->save();
        }

        if($request->ajax())
        {
            return response()->json('Article section saved');
        }

        return back();
    }
}
