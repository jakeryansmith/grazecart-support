<?php

// Documentation
Route::resource('faqs', 'FaqController');
Route::resource('topics', 'TopicController');
Route::resource('photos', 'PhotoController');
Route::resource('topics.articles', 'TopicArticleController');
Route::resource('topics.articles.sections', 'TopicArticleSectionController');
Route::resource('guides', 'GuidesController');
Route::get('faq-categories', function ()
{
    return response()->json(config('faqs.categories'));
});
