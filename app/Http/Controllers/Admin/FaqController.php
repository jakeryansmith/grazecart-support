<?php

namespace App\Http\Controllers\Admin;

use App\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    /**
     * Show list of all faqs.
     *
     * @return mixed
     */
    public function index() {
        return view('admin.faqs.index')->withFaqs(Faq::orderBy('sort_order')->get());
    }

    /**
     * Show page for editing the given faq.
     *
     * @param $faqId
     * @return mixed
     */
    public function edit($faqId) {
        return view('admin.faqs.edit')
            ->withFaq(Faq::findOrFail($faqId));
    }

    /**
     * Update the given faq.
     *
     * @param Request $request
     * @param $faqId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $faqId) {
        Faq::findOrFail($faqId)->update($request->all());
        return back();
    }
}
