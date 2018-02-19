<?php

namespace App\Http\Controllers\Marketing;

use App\Faq;
use App\ArticleSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentationSearchController extends Controller
{
    public function index(Request $request)
    {
        $articleResults = ArticleSection::search($request->input('q'))->get();
        $faqResults = Faq::search($request->input('q'))->get();

        return view('marketing.documentation.search')
            ->withCount($faqResults->count() + $articleResults->count())
            ->withFaqResults($faqResults)
            ->withArticleResults($articleResults);
    }
}
