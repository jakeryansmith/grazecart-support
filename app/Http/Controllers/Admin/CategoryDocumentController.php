<?php

namespace App\Http\Controllers\Admin;

use App\Topic;
use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryDocumentController extends Controller
{
    public function index($category) {
        return view('admin.categories.show')
            ->withCategory(Topic::whereSlug($category)->with('documents')
                ->firstOrFail());
    }

    public function show($categoryId, $documentId) {
        return view('admin.documents.edit')
            ->withCategory(Topic::whereSlug($categoryId)->firstOrFail())
            ->withDocument(Article::whereSlug($documentId)->orderBy('sort_order')->firstOrFail());
    }
}
