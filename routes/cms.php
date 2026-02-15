<?php

#region USE

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Narsil\Base\Models\Policies\Permission;
use Narsil\Base\Models\Policies\Role;
use Narsil\Base\Models\Users\UserConfiguration;
use Narsil\Cms\Http\Controllers\Collections\Blocks\BlockCreateController;
use Narsil\Cms\Http\Controllers\Collections\Blocks\BlockDestroyController;
use Narsil\Cms\Http\Controllers\Collections\Blocks\BlockDestroyManyController;
use Narsil\Cms\Http\Controllers\Collections\Blocks\BlockEditController;
use Narsil\Cms\Http\Controllers\Collections\Blocks\BlockIndexController;
use Narsil\Cms\Http\Controllers\Collections\Blocks\BlockReplicateController;
use Narsil\Cms\Http\Controllers\Collections\Blocks\BlockReplicateManyController;
use Narsil\Cms\Http\Controllers\Collections\Blocks\BlockStoreController;
use Narsil\Cms\Http\Controllers\Collections\Blocks\BlockUpdateController;
use Narsil\Cms\Http\Controllers\Collections\CollectionSummaryController;
use Narsil\Cms\Http\Controllers\Collections\Fields\FieldCreateController;
use Narsil\Cms\Http\Controllers\Collections\Fields\FieldDestroyController;
use Narsil\Cms\Http\Controllers\Collections\Fields\FieldDestroyManyController;
use Narsil\Cms\Http\Controllers\Collections\Fields\FieldEditController;
use Narsil\Cms\Http\Controllers\Collections\Fields\FieldIndexController;
use Narsil\Cms\Http\Controllers\Collections\Fields\FieldReplicateController;
use Narsil\Cms\Http\Controllers\Collections\Fields\FieldReplicateManyController;
use Narsil\Cms\Http\Controllers\Collections\Fields\FieldStoreController;
use Narsil\Cms\Http\Controllers\Collections\Fields\FieldUpdateController;
use Narsil\Cms\Http\Controllers\Collections\Templates\TemplateCreateController;
use Narsil\Cms\Http\Controllers\Collections\Templates\TemplateDestroyController;
use Narsil\Cms\Http\Controllers\Collections\Templates\TemplateDestroyManyController;
use Narsil\Cms\Http\Controllers\Collections\Templates\TemplateEditController;
use Narsil\Cms\Http\Controllers\Collections\Templates\TemplateIndexController;
use Narsil\Cms\Http\Controllers\Collections\Templates\TemplateReplicateController;
use Narsil\Cms\Http\Controllers\Collections\Templates\TemplateReplicateManyController;
use Narsil\Cms\Http\Controllers\Collections\Templates\TemplateStoreController;
use Narsil\Cms\Http\Controllers\Collections\Templates\TemplateUpdateController;
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
use Narsil\Cms\Http\Controllers\Globals\Footers\FooterCreateController;
use Narsil\Cms\Http\Controllers\Globals\Footers\FooterDestroyController;
use Narsil\Cms\Http\Controllers\Globals\Footers\FooterDestroyManyController;
use Narsil\Cms\Http\Controllers\Globals\Footers\FooterEditController;
use Narsil\Cms\Http\Controllers\Globals\Footers\FooterIndexController;
use Narsil\Cms\Http\Controllers\Globals\Footers\FooterReplicateController;
use Narsil\Cms\Http\Controllers\Globals\Footers\FooterStoreController;
use Narsil\Cms\Http\Controllers\Globals\Footers\FooterUpdateController;
use Narsil\Cms\Http\Controllers\Globals\Headers\HeaderCreateController;
use Narsil\Cms\Http\Controllers\Globals\Headers\HeaderDestroyController;
use Narsil\Cms\Http\Controllers\Globals\Headers\HeaderDestroyManyController;
use Narsil\Cms\Http\Controllers\Globals\Headers\HeaderEditController;
use Narsil\Cms\Http\Controllers\Globals\Headers\HeaderIndexController;
use Narsil\Cms\Http\Controllers\Globals\Headers\HeaderReplicateController;
use Narsil\Cms\Http\Controllers\Globals\Headers\HeaderStoreController;
use Narsil\Cms\Http\Controllers\Globals\Headers\HeaderUpdateController;
use Narsil\Cms\Http\Controllers\Hosts\HostCreateController;
use Narsil\Cms\Http\Controllers\Hosts\HostDestroyController;
use Narsil\Cms\Http\Controllers\Hosts\HostDestroyManyController;
use Narsil\Cms\Http\Controllers\Hosts\HostEditController;
use Narsil\Cms\Http\Controllers\Hosts\HostIndexController;
use Narsil\Cms\Http\Controllers\Hosts\HostReplicateController;
use Narsil\Cms\Http\Controllers\Hosts\HostReplicateManyController;
use Narsil\Cms\Http\Controllers\Hosts\HostStoreController;
use Narsil\Cms\Http\Controllers\Hosts\HostUpdateController;
use Narsil\Cms\Http\Controllers\Policies\Permissions\PermissionEditController;
use Narsil\Cms\Http\Controllers\Policies\Permissions\PermissionIndexController;
use Narsil\Cms\Http\Controllers\Policies\Permissions\PermissionUpdateController;
use Narsil\Cms\Http\Controllers\Policies\Roles\RoleCreateController;
use Narsil\Cms\Http\Controllers\Policies\Roles\RoleDestroyController;
use Narsil\Cms\Http\Controllers\Policies\Roles\RoleDestroyManyController;
use Narsil\Cms\Http\Controllers\Policies\Roles\RoleEditController;
use Narsil\Cms\Http\Controllers\Policies\Roles\RoleIndexController;
use Narsil\Cms\Http\Controllers\Policies\Roles\RoleReplicateController;
use Narsil\Cms\Http\Controllers\Policies\Roles\RoleReplicateManyController;
use Narsil\Cms\Http\Controllers\Policies\Roles\RoleStoreController;
use Narsil\Cms\Http\Controllers\Policies\Roles\RoleUpdateController;
use Narsil\Cms\Http\Controllers\SessionController;
use Narsil\Cms\Http\Controllers\Sites\Pages\SitePageCreateController;
use Narsil\Cms\Http\Controllers\Sites\Pages\SitePageDestroyController;
use Narsil\Cms\Http\Controllers\Sites\Pages\SitePageEditController;
use Narsil\Cms\Http\Controllers\Sites\Pages\SitePageSearchController;
use Narsil\Cms\Http\Controllers\Sites\Pages\SitePageStoreController;
use Narsil\Cms\Http\Controllers\Sites\Pages\SitePageUpdateController;
use Narsil\Cms\Http\Controllers\Sites\SiteEditController;
use Narsil\Cms\Http\Controllers\Sites\SiteSummaryController;
use Narsil\Cms\Http\Controllers\Sites\SiteUpdateController;
use Narsil\Cms\Http\Controllers\Storages\Assets\AssetCreateController;
use Narsil\Cms\Http\Controllers\Storages\Assets\AssetDestroyController;
use Narsil\Cms\Http\Controllers\Storages\Assets\AssetDestroyManyController;
use Narsil\Cms\Http\Controllers\Storages\Assets\AssetEditController;
use Narsil\Cms\Http\Controllers\Storages\Assets\AssetIndexController;
use Narsil\Cms\Http\Controllers\Storages\Assets\AssetStoreController;
use Narsil\Cms\Http\Controllers\Storages\Assets\AssetUpdateController;
use Narsil\Cms\Http\Controllers\Users\Bookmarks\UserBookmarkDestroyController;
use Narsil\Cms\Http\Controllers\Users\Bookmarks\UserBookmarkIndexController;
use Narsil\Cms\Http\Controllers\Users\Bookmarks\UserBookmarkStoreController;
use Narsil\Cms\Http\Controllers\Users\Bookmarks\UserBookmarkUpdateController;
use Narsil\Cms\Http\Controllers\Users\Configurations\UserConfigurationEditController;
use Narsil\Cms\Http\Controllers\Users\Configurations\UserConfigurationUpdateController;
use Narsil\Cms\Http\Controllers\Users\UserCreateController;
use Narsil\Cms\Http\Controllers\Users\UserDestroyController;
use Narsil\Cms\Http\Controllers\Users\UserDestroyManyController;
use Narsil\Cms\Http\Controllers\Users\UserEditController;
use Narsil\Cms\Http\Controllers\Users\UserIndexController;
use Narsil\Cms\Http\Controllers\Users\UserStoreController;
use Narsil\Cms\Http\Controllers\Users\UserUpdateController;
use Narsil\Cms\Http\Middleware\CountryMiddleware;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Sites\Site;
use Narsil\Cms\Models\Sites\SitePage;
use Narsil\Cms\Models\Storages\Asset;
use Narsil\Cms\Models\User;
use Narsil\Cms\Models\Users\UserBookmark;

#endregion

Route::middleware([
    'auth',
    'verified',
])->group(
    function ()
    {
        Route::get('/dashboard', DashboardController::class)
            ->name('dashboard');

        Route::redirect('/', '/admin/dashboard');

        #region RESOURCES

        Route::prefix(Str::slug(Block::TABLE))->name(Str::slug(Block::TABLE) . '.')->group(function ()
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

        Route::prefix(Str::slug(Entity::TABLE))->name(Str::slug(Entity::TABLE) . '.')->group(function ()
        {
            Route::get('/search', EntitySearchController::class)
                ->name('search');
        });

        Route::prefix(Str::slug(Field::TABLE))->name(Str::slug(Field::TABLE) . '.')->group(function ()
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

        Route::prefix(Str::slug(Footer::TABLE))->name(Str::slug(Footer::TABLE) . '.')->group(function ()
        {
            Route::get('/', FooterIndexController::class)
                ->name('index');
            Route::get('/create', FooterCreateController::class)
                ->name('create');
            Route::post('/', FooterStoreController::class)
                ->name('store');
            Route::get('/{footer}/edit', FooterEditController::class)
                ->name('edit');
            Route::patch('/{footer}', FooterUpdateController::class)
                ->name('update');
            Route::delete('/{footer}', FooterDestroyController::class)
                ->name('destroy');
            Route::delete('/', FooterDestroyManyController::class)
                ->name('destroy-many');
            Route::post('/{footer}/replicate', FooterReplicateController::class)
                ->name('replicate');
        });

        Route::prefix(Str::slug(Header::TABLE))->name(Str::slug(Header::TABLE) . '.')->group(function ()
        {
            Route::get('/', HeaderIndexController::class)
                ->name('index');
            Route::get('/create', HeaderCreateController::class)
                ->name('create');
            Route::post('/', HeaderStoreController::class)
                ->name('store');
            Route::get('/{header}/edit', HeaderEditController::class)
                ->name('edit');
            Route::patch('/{header}', HeaderUpdateController::class)
                ->name('update');
            Route::delete('/{header}', HeaderDestroyController::class)
                ->name('destroy');
            Route::delete('/', HeaderDestroyManyController::class)
                ->name('destroy-many');
            Route::post('/{header}/replicate', HeaderReplicateController::class)
                ->name('replicate');
        });

        Route::prefix(Str::slug(Host::TABLE))->name(Str::slug(Host::TABLE) . '.')->group(function ()
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

        Route::prefix(Str::slug(Asset::TABLE))->name(Str::slug(Asset::TABLE) . '.')->group(function ()
        {
            Route::get('/', AssetIndexController::class)
                ->name('index');
            Route::get('//create', AssetCreateController::class)
                ->name('create');
            Route::post('/', AssetStoreController::class)
                ->name('store');
            Route::get('/{asset}/edit', AssetEditController::class)
                ->name('edit');
            Route::patch('/{asset}', AssetUpdateController::class)
                ->name('update');
            Route::delete('/{asset}', AssetDestroyController::class)
                ->name('destroy');
            Route::delete('/', AssetDestroyManyController::class)
                ->name('destroy-many');
        });

        Route::prefix(Str::slug(Permission::TABLE))->name(Str::slug(Permission::TABLE) . '.')->group(function ()
        {
            Route::get('/', PermissionIndexController::class)
                ->name('index');
            Route::get('/{permission}/edit', PermissionEditController::class)
                ->name('edit');
            Route::patch('/{permission}', PermissionUpdateController::class)
                ->name('update');
        });

        Route::prefix(Str::slug(Role::TABLE))->name(Str::slug(Role::TABLE) . '.')->group(function ()
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

        Route::prefix(Str::slug(Template::TABLE))->name(Str::slug(Template::TABLE) . '.')->group(function ()
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

        Route::prefix(Str::slug(User::TABLE))->name(Str::slug(User::TABLE) . '.')->group(function ()
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
                ->name('index');
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
            Route::post('/{collection}/{id}/unpublish', EntityUnpublishController::class)
                ->name('unpublish');
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

#region USERS

Route::prefix(Str::slug(UserConfiguration::TABLE))->name(Str::slug(UserConfiguration::TABLE) . '.')->group(function ()
{
    Route::get('/', UserConfigurationEditController::class)
        ->name('edit');
    Route::post('/', UserConfigurationUpdateController::class)
        ->name('update');
});

Route::delete('/sessions', SessionController::class)
    ->name('sessions.delete');

#endregion
