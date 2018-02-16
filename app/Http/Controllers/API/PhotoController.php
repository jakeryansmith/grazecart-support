<?php

namespace App\Http\Controllers\API;

use App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PhotoController extends Controller
{
    public function index(Request $request) {
        $query = $request->get('q');
        return Photo::when(strlen($query), function ($q) use ($query) {
            return $q->where('title', 'LIKE', '%'.$query.'%');
        })->paginate(30);
    }

    public function store(Request $request) {
        if(!$request->hasFile('file'))
        {
            return response()->json('No file was provided.', 422);
        }

        if(!$request->file('file')->isValid())
        {
            return response()->json('File is not valid.', 422);
        }

        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png,pdf|max:2000'
        ]);

        $file = $request->file('file');

        if($request->has('tags')) {
            $tags = is_array($request->get('tags')) ? $request->get('tags') : explode(',', $request->get('tags'));
        }
        else {
            $tags = null;
        }
        $file = Photo::uploadMedia($file, $tags);
        return response()->json([
            'responseText' => 'File uploaded',
            'file' => $file
        ], 200);
    }
}
