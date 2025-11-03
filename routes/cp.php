<?php

#region USE

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Narsil\Http\Controllers\Blocks\BlockCreateController;
use Narsil\Http\Controllers\Blocks\BlockDestroyController;
use Narsil\Http\Controllers\Blocks\BlockDestroyManyController;
use Narsil\Http\Controllers\Blocks\BlockEditController;
use Narsil\Http\Controllers\Blocks\BlockIndexController;
use Narsil\Http\Controllers\Blocks\BlockReplicateController;
use Narsil\Http\Controllers\Blocks\BlockReplicateManyController;
use Narsil\Http\Controllers\Blocks\BlockStoreController;
use Narsil\Http\Controllers\Blocks\BlockUpdateController;
use Narsil\Http\Controllers\Collections\CollectionSummaryController;
use Narsil\Http\Controllers\DashboardController;
use Narsil\Http\Controllers\Entities\EntityCreateController;
use Narsil\Http\Controllers\Entities\EntityDestroyController;
use Narsil\Http\Controllers\Entities\EntityDestroyManyController;
use Narsil\Http\Controllers\Entities\EntityEditController;
use Narsil\Http\Controllers\Entities\EntityIndexController;
use Narsil\Http\Controllers\Entities\EntityReplicateController;
use Narsil\Http\Controllers\Entities\EntityReplicateManyController;
use Narsil\Http\Controllers\Entities\EntityStoreController;
use Narsil\Http\Controllers\Entities\EntityUpdateController;
use Narsil\Http\Controllers\Fields\FieldCreateController;
use Narsil\Http\Controllers\Fields\FieldDestroyController;
use Narsil\Http\Controllers\Fields\FieldDestroyManyController;
use Narsil\Http\Controllers\Fields\FieldEditController;
use Narsil\Http\Controllers\Fields\FieldIndexController;
use Narsil\Http\Controllers\Fields\FieldReplicateController;
use Narsil\Http\Controllers\Fields\FieldReplicateManyController;
use Narsil\Http\Controllers\Fields\FieldStoreController;
use Narsil\Http\Controllers\Fields\FieldUpdateController;
use Narsil\Http\Controllers\HostPages\HostPageCreateController;
use Narsil\Http\Controllers\HostPages\HostPageDestroyController;
use Narsil\Http\Controllers\HostPages\HostPageEditController;
use Narsil\Http\Controllers\HostPages\HostPageStoreController;
use Narsil\Http\Controllers\HostPages\HostPageUpdateController;
use Narsil\Http\Controllers\Hosts\HostCreateController;
use Narsil\Http\Controllers\Hosts\HostDestroyController;
use Narsil\Http\Controllers\Hosts\HostDestroyManyController;
use Narsil\Http\Controllers\Hosts\HostEditController;
use Narsil\Http\Controllers\Hosts\HostIndexController;
use Narsil\Http\Controllers\Hosts\HostReplicateController;
use Narsil\Http\Controllers\Hosts\HostReplicateManyController;
use Narsil\Http\Controllers\Hosts\HostStoreController;
use Narsil\Http\Controllers\Hosts\HostUpdateController;
use Narsil\Http\Controllers\Roles\RoleCreateController;
use Narsil\Http\Controllers\Roles\RoleDestroyController;
use Narsil\Http\Controllers\Roles\RoleDestroyManyController;
use Narsil\Http\Controllers\Roles\RoleEditController;
use Narsil\Http\Controllers\Roles\RoleIndexController;
use Narsil\Http\Controllers\Roles\RoleReplicateController;
use Narsil\Http\Controllers\Roles\RoleReplicateManyController;
use Narsil\Http\Controllers\Roles\RoleStoreController;
use Narsil\Http\Controllers\Roles\RoleUpdateController;
use Narsil\Http\Controllers\SessionController;
use Narsil\Http\Controllers\Sites\SiteEditController;
use Narsil\Http\Controllers\Sites\SiteSummaryController;
use Narsil\Http\Controllers\Sites\SiteUpdateController;
use Narsil\Http\Controllers\Templates\TemplateCreateController;
use Narsil\Http\Controllers\Templates\TemplateDestroyController;
use Narsil\Http\Controllers\Templates\TemplateDestroyManyController;
use Narsil\Http\Controllers\Templates\TemplateEditController;
use Narsil\Http\Controllers\Templates\TemplateIndexController;
use Narsil\Http\Controllers\Templates\TemplateReplicateController;
use Narsil\Http\Controllers\Templates\TemplateReplicateManyController;
use Narsil\Http\Controllers\Templates\TemplateStoreController;
use Narsil\Http\Controllers\Templates\TemplateUpdateController;
use Narsil\Http\Controllers\UserBookmarks\UserBookmarkDestroyController;
use Narsil\Http\Controllers\UserBookmarks\UserBookmarkIndexController;
use Narsil\Http\Controllers\UserBookmarks\UserBookmarkStoreController;
use Narsil\Http\Controllers\UserBookmarks\UserBookmarkUpdateController;
use Narsil\Http\Controllers\UserConfigurations\UserConfigurationEditController;
use Narsil\Http\Controllers\UserConfigurations\UserConfigurationUpdateController;
use Narsil\Http\Controllers\Users\UserCreateController;
use Narsil\Http\Controllers\Users\UserDestroyController;
use Narsil\Http\Controllers\Users\UserDestroyManyController;
use Narsil\Http\Controllers\Users\UserEditController;
use Narsil\Http\Controllers\Users\UserIndexController;
use Narsil\Http\Controllers\Users\UserStoreController;
use Narsil\Http\Controllers\Users\UserUpdateController;
use Narsil\Http\Middleware\CountryMiddleware;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Role;
use Narsil\Models\User;
use Narsil\Models\Users\UserBookmark;
use Narsil\Models\Users\UserConfiguration;

#endregion

Route::middleware([
    'auth',
    'verified',
])->group(
    function ()
    {
        Route::get('/dashboard', DashboardController::class)
            ->name('dashboard');

        Route::redirect('/', '/narsil/dashboard');

        #region RESOURCES

        Route::prefix(Block::TABLE)->name(Block::TABLE . '.')->group(function ()
        {
            Route::get('/', BlockIndexController::class)
                ->name('index');
            Route::get('/create', BlockCreateController::class)
                ->name('create');
            Route::post('/', BlockStoreController::class)
                ->name('store');
            Route::get('/{block}/edit', BlockEditController::class)
                ->name('edit');
            Route::patch('/{block}', BlockUpdateController::class)
                ->name('update');
            Route::delete('/{block}', BlockDestroyController::class)
                ->name('destroy');
            Route::delete('/', BlockDestroyManyController::class)
                ->name('destroy-many');
            Route::post('/{block}/replicate', BlockReplicateController::class)
                ->name('replicate');
            Route::post('/replicate-many', BlockReplicateManyController::class)
                ->name('replicate-many');
        });

        Route::prefix(Field::TABLE)->name(Field::TABLE . '.')->group(function ()
        {
            Route::get('/', FieldIndexController::class)
                ->name('index');
            Route::get('/create', FieldCreateController::class)
                ->name('create');
            Route::post('/', FieldStoreController::class)
                ->name('store');
            Route::get('/{field}/edit', FieldEditController::class)
                ->name('edit');
            Route::patch('/{field}', FieldUpdateController::class)
                ->name('update');
            Route::delete('/{field}', FieldDestroyController::class)
                ->name('destroy');
            Route::delete('/', FieldDestroyManyController::class)
                ->name('destroy-many');
            Route::post('/{field}/replicate', FieldReplicateController::class)
                ->name('replicate');
            Route::post('/replicate-many', FieldReplicateManyController::class)
                ->name('replicate-many');
        });

        Route::prefix(Host::TABLE)->name(Host::TABLE . '.')->group(function ()
        {
            Route::get('/', HostIndexController::class)
                ->name('index');
            Route::get('/create', HostCreateController::class)
                ->name('create');
            Route::post('/', HostStoreController::class)
                ->name('store');
            Route::get('/{host}/edit', HostEditController::class)
                ->name('edit');
            Route::patch('/{host}', HostUpdateController::class)
                ->name('update');
            Route::delete('/{host}', HostDestroyController::class)
                ->name('destroy');
            Route::delete('/', HostDestroyManyController::class)
                ->name('destroy-many');
            Route::post('/{host}/replicate', HostReplicateController::class)
                ->name('replicate');
            Route::post('/replicate-many', HostReplicateManyController::class)
                ->name('replicate-many');
        });

        Route::prefix(Role::TABLE)->name(Role::TABLE . '.')->group(function ()
        {
            Route::get('/', RoleIndexController::class)
                ->name('index');
            Route::get('/create', RoleCreateController::class)
                ->name('create');
            Route::post('/', RoleStoreController::class)
                ->name('store');
            Route::get('/{role}/edit', RoleEditController::class)
                ->name('edit');
            Route::patch('/{role}', RoleUpdateController::class)
                ->name('update');
            Route::delete('/{role}', RoleDestroyController::class)
                ->name('destroy');
            Route::delete('/', RoleDestroyManyController::class)
                ->name('destroy-many');
            Route::post('/{role}/replicate', RoleReplicateController::class)
                ->name('replicate');
            Route::post('/replicate-many', RoleReplicateManyController::class)
                ->name('replicate-many');
        });

        Route::prefix(Template::TABLE)->name(Template::TABLE . '.')->group(function ()
        {
            Route::get('/', TemplateIndexController::class)
                ->name('index');
            Route::get('/create', TemplateCreateController::class)
                ->name('create');
            Route::post('/', TemplateStoreController::class)
                ->name('store');
            Route::get('/{template}/edit', TemplateEditController::class)
                ->name('edit');
            Route::patch('/{template}', TemplateUpdateController::class)
                ->name('update');
            Route::delete('/{template}', TemplateDestroyController::class)
                ->name('destroy');
            Route::delete('/', TemplateDestroyManyController::class)
                ->name('destroy-many');
            Route::post('/{template}/replicate', TemplateReplicateController::class)
                ->name('replicate');
            Route::post('/replicate-many', TemplateReplicateManyController::class)
                ->name('replicate-many');
        });

        Route::prefix(User::TABLE)->name(User::TABLE . '.')->group(function ()
        {
            Route::get('/', UserIndexController::class)
                ->name('index');
            Route::get('/create', UserCreateController::class)
                ->name('create');
            Route::post('/', UserStoreController::class)
                ->name('store');
            Route::get('/{user}/edit', UserEditController::class)
                ->name('edit');
            Route::patch('/{user}', UserUpdateController::class)
                ->name('update');
            Route::delete('/{user}', UserDestroyController::class)
                ->name('destroy');
            Route::delete('/', UserDestroyManyController::class)
                ->name('destroy-many');
        });

        Route::prefix(Str::slug(UserBookmark::TABLE))->name(Str::slug(UserBookmark::TABLE) . '.')->group(function ()
        {
            Route::get('/', UserBookmarkIndexController::class)
                ->name('index');;
            Route::post('/', UserBookmarkStoreController::class)
                ->name('store');
            Route::patch('/{userBookmark}', UserBookmarkUpdateController::class)
                ->name('update');
            Route::delete('/{userBookmark}', UserBookmarkDestroyController::class)
                ->name('destroy');
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
        });

        Route::prefix('sites')->name('sites.')->group(function ()
        {
            Route::get('/', SiteSummaryController::class)
                ->name('summary');
            Route::get('/{site}/edit', SiteEditController::class)
                ->middleware(CountryMiddleware::class)
                ->name('edit');
            Route::patch('/{site}', SiteUpdateController::class)
                ->name('update');

            Route::name('pages.')->group(function ()
            {
                Route::get('/{site}/create', HostPageCreateController::class)
                    ->name('create');
                Route::post('/{site}', HostPageStoreController::class)
                    ->name('store');
                Route::get('/{site}/{hostPage}/edit', HostPageEditController::class)
                    ->name('edit');
                Route::patch('/{site}/{hostPage}', HostPageUpdateController::class)
                    ->name('update');
                Route::delete('/{site}/{hostPage}', HostPageDestroyController::class)
                    ->name('destroy');
            });
        });

        #endregion
    }
);

#region USERS

Route::prefix(Str::slug(UserConfiguration::TABLE))->name(Str::slug(UserConfiguration::TABLE) . '.')->group(function ()
{
    Route::get('/', UserConfigurationEditController::class)
        ->name('edit');;
    Route::post('/', UserConfigurationUpdateController::class)
        ->name('update');
});

Route::delete('/sessions', SessionController::class)
    ->name('sessions.delete');

#endregion
