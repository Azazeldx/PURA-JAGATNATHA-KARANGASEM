<?php

use App\Http\Controllers\MainController;
use App\Services\FeatureService;
use App\Services\GeneralSettingsService;
use Illuminate\Support\Facades\Route;

Route::controller(MainController::class)->group(function () {

	$feature = app(FeatureService::class);

	Route::get('/', 'page')
		->name('home');
	
	if ($feature->enabled('global.navigation')) {
		// $navigation = app(GeneralSettingsService::class)->get('navigation');
		// if ($feature->get('global.navigation.homepage')) {
		// }
		
		// Pages (Published)
		Route::get('/{slug}', 'page')
			->name('exryze.page.dynamic');

		// Search page

		// Posts Detail (Not Published)
		Route::get('/{type}/{slug}', 'post')
			->name('exryze.post.detail');
	}
	
});