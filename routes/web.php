<?php

#region USE

use Illuminate\Support\Facades\Route;
use Narsil\Http\Controllers\Forms\FormSubmitController;
use Narsil\Http\Controllers\Sitemaps\SitemapController;
use Narsil\Http\Controllers\Sitemaps\SitemapIndexController;

#endregion

Route::redirect('/admin', '/narsil/dashboard');

Route::get('/sitemap_index.xml', SitemapIndexController::class);
Route::get('/sitemap/{country}.xml', SitemapController::class);

Route::post('/forms/{form}/submit', FormSubmitController::class);
