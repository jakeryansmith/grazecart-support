<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function index() {
    	return view('admin.documents.index');
    }

    public function edit($documentId) {
    	return view('admin.documents.edit')->withDocument(Article::whereSlug($documentId)->first());
    }
}
