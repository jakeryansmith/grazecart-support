<?php
Route::group(['namespace' => 'Marketing'], function() {
    Route::get('/', 'HomepageController@index');

    Route::get('/docs', 'DocumentationController@index');
    Route::get('/docs/search', ['uses' => 'DocumentationSearchController@index']);
    Route::get('/docs/topic/{topic}', ['uses' => 'DocumentationController@showTopic']);
    Route::get('/docs/topic/{topic}/article/{article}', ['uses' => 'DocumentationController@showArticle']);

    // FAQs
    Route::get('faqs', 'FaqController@index');
    Route::get('faqs/{faqs}', 'FaqController@show');

    // Guides
    Route::get('guides', 'GuidesController@index');
    Route::get('guides/{guides}', 'GuidesController@show');
});


Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function()
{
	Route::get('/', 'TopicController@index');

	// Topics
	Route::get('topics', 'TopicController@index');
    Route::get('topics/{topic}/edit', 'TopicController@edit');
    Route::put('topics/{topic}', 'TopicController@update');

    // Articles
    Route::get('topics/{topic}/articles/{article}/edit', 'TopicArticleController@edit');
    Route::put('topics/{topic}/articles/{article}', 'TopicArticleController@update');

    // Article Sections
    Route::get('topics/{topic}/articles/{article}/sections/{section}/edit', 'TopicArticleSectionController@edit');
    Route::put('topics/{topic}/articles/{article}/sections/{section}', 'TopicArticleSectionController@update');

    // FAQs
    Route::get('faqs', 'FaqController@index');
    Route::get('faqs/{faqs}/edit', 'FaqController@edit');
    Route::put('faqs/{faqs}', 'FaqController@update');

    // Guides
    Route::get('guides', 'GuidesController@index');
    Route::get('guides/{guides}/edit', 'GuidesController@edit');
    Route::put('guides/{guides}', 'GuidesController@update');
});