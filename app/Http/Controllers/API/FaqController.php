<?php

namespace App\Http\Controllers\API;

use App\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    /**
     * Return all faqs.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index() {
        return Faq::orderBy('sort_order')->get();
    }

    /**
     * Store a new faq.
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
        $faq = Faq::create($request->validate([
            'visible' => 'boolean',
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]));

        $faq->url = '/faqs/'.$faq->slug;
        $faq->save();
        return $faq;
    }

    /**
     * Update the given faq.
     *
     * @param Request $request
     * @param $faqId
     * @return mixed
     */
    public function update(Request $request, $faqId) {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
       return tap(Faq::findOrFail($faqId))->update($request->only([
            'title','body','visible','category_id','keywords','url'
        ]));
    }

    /**
     * Delete the given faq.
     *
     * @param $faqId
     * @return mixed
     */
    public function destroy($faqId) {
        Faq::findOrFail($faqId)->delete();
        return response()->json('Faq deleted');
    }
}
