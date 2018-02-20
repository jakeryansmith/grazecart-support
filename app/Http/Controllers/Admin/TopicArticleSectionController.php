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

        ArticleSection::findOrFail($section)->update([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'url' => $request->get('url'),
            'keywords' => $request->get('keywords'),
            'body' => str_replace('<p><br></p>','<hr>', $request->get('body')),
            'visible' => $request->get('visible', false)
        ]);

        return back();
    }
}
