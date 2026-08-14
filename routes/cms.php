<?php

#region USE

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Narsil\Base\Services\ModelRouteRegistrar;
use Narsil\Cms\Http\Controllers\Collections\CollectionSummaryController;
use Narsil\Cms\Http\Controllers\Configurations\ConfigurationEditController;
use Narsil\Cms\Http\Controllers\Configurations\ConfigurationUpdateController;
use Narsil\Cms\Http\Controllers\DashboardController;
use Narsil\Cms\Http\Controllers\Entities\EntityCreateController;
use Narsil\Cms\Http\Controllers\Entities\EntityDestroyController;
use Narsil\Cms\Http\Controllers\Entities\EntityDestroyManyController;
use Narsil\Cms\Http\Controllers\Entities\EntityEditController;
use Narsil\Cms\Http\Controllers\Entities\EntityIndexController;
use Narsil\Cms\Http\Controllers\Entities\EntityReplicateController;
use Narsil\Cms\Http\Controllers\Entities\EntityReplicateManyController;
use Narsil\Cms\Http\Controllers\Entities\EntitySearchController;
use Narsil\Cms\Http\Controllers\Entities\EntityStoreController;
use Narsil\Cms\Http\Controllers\Entities\EntityUnpublishController;
use Narsil\Cms\Http\Controllers\Entities\EntityUpdateController;
use Narsil\Cms\Http\Controllers\LiveEditor\LiveEditorNodeDestroyController;
use Narsil\Cms\Http\Controllers\LiveEditor\LiveEditorNodeFormController;
use Narsil\Cms\Http\Controllers\LiveEditor\LiveEditorNodeReorderController;
use Narsil\Cms\Http\Controllers\LiveEditor\LiveEditorNodeStoreController;
use Narsil\Cms\Http\Controllers\LiveEditor\LiveEditorNodeUpdateController;
use Narsil\Cms\Http\Controllers\LiveEditor\LiveEditorShowController;
use Narsil\Cms\Http\Controllers\Sites\Pages\SitePageCreateController;
use Narsil\Cms\Http\Controllers\Sites\Pages\SitePageDestroyController;
use Narsil\Cms\Http\Controllers\Sites\Pages\SitePageEditController;
use Narsil\Cms\Http\Controllers\Sites\Pages\SitePageSearchController;
use Narsil\Cms\Http\Controllers\Sites\Pages\SitePageStoreController;
use Narsil\Cms\Http\Controllers\Sites\Pages\SitePageUpdateController;
use Narsil\Cms\Http\Controllers\Sites\SiteEditController;
use Narsil\Cms\Http\Controllers\Sites\SiteSummaryController;
use Narsil\Cms\Http\Controllers\Sites\SiteUpdateController;
use Narsil\Cms\Http\Middleware\CountryMiddleware;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Models\Sites\SitePage;

#endregion

Route::middleware([
    'auth',
    'verified',
])->group(
    function ()
    {
        Route::get('/', DashboardController::class)
            ->name('dashboard');

        #region RESOURCES

        app(ModelRouteRegistrar::class)->register();

        Route::prefix(Str::slug(Entity::TABLE))->name(Str::slug(Entity::TABLE) . '.')->group(function ()
        {
            Route::get('/search', EntitySearchController::class)
                ->name('search');
        });

        Route::prefix(Str::slug(Site::VIRTUAL_TABLE))->name(Str::slug(Site::VIRTUAL_TABLE) . '.')->group(function ()
        {
            Route::get('/', SiteSummaryController::class)
                ->name('summary');
            Route::get('/{site}/edit', SiteEditController::class)
                ->middleware(CountryMiddleware::class)
                ->name('edit');
            Route::patch('/{site:hostname}', SiteUpdateController::class)
                ->name('update');

            Route::name('pages.')->group(function ()
            {
                Route::get('/{site}/create', SitePageCreateController::class)
                    ->name('create');
                Route::post('/{site}', SitePageStoreController::class)
                    ->name('store');
                Route::get('/{site}/{sitePage}/edit', SitePageEditController::class)
                    ->name('edit');
                Route::patch('/{site}/{sitePage}', SitePageUpdateController::class)
                    ->name('update');
                Route::delete('/{site}/{sitePage}', SitePageDestroyController::class)
                    ->name('destroy');
            });
        });

        Route::prefix(Str::slug(SitePage::TABLE))->name(Str::slug(SitePage::TABLE) . '.')->group(function ()
        {
            Route::get('/search', SitePageSearchController::class)
                ->name('search');
        });

        Route::prefix('collections')->name('collections.')->group(function ()
        {
            Route::get('/', CollectionSummaryController::class)
                ->name('summary');
            Route::get('/{collection}', EntityIndexController::class)
                ->name('index');
            Route::get('/{collection}/create', EntityCreateController::class)
                ->name('create');
            Route::post('/{collection}', EntityStoreController::class)
                ->name('store');
            Route::get('/{collection}/{id}/edit', EntityEditController::class)
                ->name('edit');
            Route::patch('/{collection}/{id}', EntityUpdateController::class)
                ->name('update');
            Route::delete('/{collection}/{id}', EntityDestroyController::class)
                ->name('destroy');
            Route::delete('/{collection}', EntityDestroyManyController::class)
                ->name('destroy-many');
            Route::post('/{collection}/{id}/replicate', EntityReplicateController::class)
                ->name('replicate');
            Route::post('/{collection}/replicate-many', EntityReplicateManyController::class)
                ->name('replicate-many');
            Route::post('/{collection}/{id}/unpublish', EntityUnpublishController::class)
                ->name('unpublish');
        });

        Route::prefix('live-editor')->name('live-editor.')->group(function ()
        {
            Route::get('/{sitePage}', LiveEditorShowController::class)
                ->name('show');

            Route::prefix('/{sitePage}/nodes')->name('nodes.')->group(function ()
            {
                Route::post('/', LiveEditorNodeStoreController::class)
                    ->name('store');
                Route::patch('/reorder', LiveEditorNodeReorderController::class)
                    ->name('reorder');
                Route::get('/{nodeUuid}/form', LiveEditorNodeFormController::class)
                    ->name('form');
                Route::patch('/{nodeUuid}', LiveEditorNodeUpdateController::class)
                    ->name('update');
                Route::delete('/{nodeUuid}', LiveEditorNodeDestroyController::class)
                    ->name('destroy');
            });
        });

        Route::prefix('settings')->name('settings.')->group(function ()
        {
            Route::get('/', ConfigurationEditController::class)
                ->name('edit');
            Route::patch('/', ConfigurationUpdateController::class)
                ->name('update');
        });

        #endregion
    }
);
