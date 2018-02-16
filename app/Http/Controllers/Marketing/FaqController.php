<?php

namespace App\Http\Controllers\Marketing;

use App\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    /**
     * Show page of all FAQs
     *
     * @return mixed
     */
    public function index()
    {
        return view('marketing.faq.index')
            ->withFaqs(Faq::orderBy('sort_order')
                ->where('visible', true)->get()
                ->sortBy('category.sort_order')
                ->groupBy('category_id')
            );
    }

    /**
     * Show individual Faq.
     *
     * @param $faqId
     * @return mixed
     */
    public function show($faqId)
    {
        return view('marketing.faq.show')
            ->withFaq(Faq::whereSlug($faqId)->firstOrFail())
            ->withFaqs(Faq::orderBy('sort_order')
                ->where('visible', true)->get()
                ->sortBy('category.sort_order')
                ->groupBy('category_id')
            );
    }
}
