<?php

#region USE

use Illuminate\Support\Facades\Route;
use Narsil\Cms\Http\Controllers\Sitemaps\SitemapController;
use Narsil\Cms\Http\Controllers\Sitemaps\SitemapIndexController;

#endregion

Route::get('/sitemap_index.xml', SitemapIndexController::class);
Route::get('/sitemap/{country}.xml', SitemapController::class);
