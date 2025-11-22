<?php

#region USE

use Illuminate\Support\Facades\Route;
use Narsil\Http\Controllers\PageController;
use Narsil\Http\Controllers\Sitemaps\SitemapController;
use Narsil\Http\Controllers\Sitemaps\SitemapIndexController;

#endregion

Route::get('/sitemap_index.xml', SitemapIndexController::class);
Route::get('/sitemap/{country}.xml', SitemapController::class);

Route::get('/{path?}', PageController::class)
    ->where('path', '.*');

Route::domain('{subdomain}')
    ->get('/{path?}', PageController::class)
    ->where('path', '.*');
