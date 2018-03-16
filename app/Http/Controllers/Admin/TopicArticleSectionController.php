<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\ArticleSection;
use App\Topic;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use League\HTMLToMarkdown\HtmlConverter;

class TopicArticleSectionController extends Controller
{
    public function edit($topic, $article, $section) {
        return view('admin.topics.articles.sections.edit')
            ->withTopic(Topic::whereSlug($topic)->firstOrFail())
            ->withArticle(Article::whereSlug($article)->firstOrFail())
            ->withSection(ArticleSection::whereSlug($section)->firstOrFail());
    }

    public function update(Request $request, $topic, $article, $section)
    {
        $request->validate([
            'title' => 'sometimes|required',
            'keywords' => 'nullable',
            'body' => 'required',
            'visible' => 'boolean'
        ]);

        $request['body'] = str_replace('<p><br></p>','<hr>', $request->get('body'));
        ArticleSection::findOrFail($section)->update($request->only([
            'title','description','url','keywords','body','visible'
        ]));

        return back();
    }
}
