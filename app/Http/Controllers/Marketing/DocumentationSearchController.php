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
        return view('marketing.documentation.search')
            ->withFaqResults(Faq::search($request->input('q'))->get())
            ->withArticleResults(ArticleSection::search($request->input('q'))->get());
    }
}
