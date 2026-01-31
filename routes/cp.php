<?php

#region USE

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Narsil\Http\Controllers\Collections\Blocks\BlockCreateController;
use Narsil\Http\Controllers\Collections\Blocks\BlockDestroyController;
use Narsil\Http\Controllers\Collections\Blocks\BlockDestroyManyController;
use Narsil\Http\Controllers\Collections\Blocks\BlockEditController;
use Narsil\Http\Controllers\Collections\Blocks\BlockIndexController;
use Narsil\Http\Controllers\Collections\Blocks\BlockReplicateController;
use Narsil\Http\Controllers\Collections\Blocks\BlockReplicateManyController;
use Narsil\Http\Controllers\Collections\Blocks\BlockStoreController;
use Narsil\Http\Controllers\Collections\Blocks\BlockUpdateController;
use Narsil\Http\Controllers\Collections\CollectionSummaryController;
use Narsil\Http\Controllers\Collections\Fields\FieldCreateController;
use Narsil\Http\Controllers\Collections\Fields\FieldDestroyController;
use Narsil\Http\Controllers\Collections\Fields\FieldDestroyManyController;
use Narsil\Http\Controllers\Collections\Fields\FieldEditController;
use Narsil\Http\Controllers\Collections\Fields\FieldIndexController;
use Narsil\Http\Controllers\Collections\Fields\FieldReplicateController;
use Narsil\Http\Controllers\Collections\Fields\FieldReplicateManyController;
use Narsil\Http\Controllers\Collections\Fields\FieldStoreController;
use Narsil\Http\Controllers\Collections\Fields\FieldUpdateController;
use Narsil\Http\Controllers\Collections\Templates\TemplateCreateController;
use Narsil\Http\Controllers\Collections\Templates\TemplateDestroyController;
use Narsil\Http\Controllers\Collections\Templates\TemplateDestroyManyController;
use Narsil\Http\Controllers\Collections\Templates\TemplateEditController;
use Narsil\Http\Controllers\Collections\Templates\TemplateIndexController;
use Narsil\Http\Controllers\Collections\Templates\TemplateReplicateController;
use Narsil\Http\Controllers\Collections\Templates\TemplateReplicateManyController;
use Narsil\Http\Controllers\Collections\Templates\TemplateStoreController;
use Narsil\Http\Controllers\Collections\Templates\TemplateUpdateController;
use Narsil\Http\Controllers\Configurations\ConfigurationEditController;
use Narsil\Http\Controllers\Configurations\ConfigurationUpdateController;
use Narsil\Http\Controllers\DashboardController;
use Narsil\Http\Controllers\Entities\EntityCreateController;
use Narsil\Http\Controllers\Entities\EntityDestroyController;
use Narsil\Http\Controllers\Entities\EntityDestroyManyController;
use Narsil\Http\Controllers\Entities\EntityEditController;
use Narsil\Http\Controllers\Entities\EntityIndexController;
use Narsil\Http\Controllers\Entities\EntityReplicateController;
use Narsil\Http\Controllers\Entities\EntityReplicateManyController;
use Narsil\Http\Controllers\Entities\EntitySearchController;
use Narsil\Http\Controllers\Entities\EntityStoreController;
use Narsil\Http\Controllers\Entities\EntityUnpublishController;
use Narsil\Http\Controllers\Entities\EntityUpdateController;
use Narsil\Http\Controllers\Forms\Fieldsets\FieldsetCreateController;
use Narsil\Http\Controllers\Forms\Fieldsets\FieldsetDestroyController;
use Narsil\Http\Controllers\Forms\Fieldsets\FieldsetDestroyManyController;
use Narsil\Http\Controllers\Forms\Fieldsets\FieldsetEditController;
use Narsil\Http\Controllers\Forms\Fieldsets\FieldsetIndexController;
use Narsil\Http\Controllers\Forms\Fieldsets\FieldsetReplicateController;
use Narsil\Http\Controllers\Forms\Fieldsets\FieldsetReplicateManyController;
use Narsil\Http\Controllers\Forms\Fieldsets\FieldsetStoreController;
use Narsil\Http\Controllers\Forms\Fieldsets\FieldsetUpdateController;
use Narsil\Http\Controllers\Forms\FormCreateController;
use Narsil\Http\Controllers\Forms\FormDestroyController;
use Narsil\Http\Controllers\Forms\FormDestroyManyController;
use Narsil\Http\Controllers\Forms\FormEditController;
use Narsil\Http\Controllers\Forms\FormIndexController;
use Narsil\Http\Controllers\Forms\FormReplicateController;
use Narsil\Http\Controllers\Forms\FormReplicateManyController;
use Narsil\Http\Controllers\Forms\FormSearchController;
use Narsil\Http\Controllers\Forms\FormStoreController;
use Narsil\Http\Controllers\Forms\FormUpdateController;
use Narsil\Http\Controllers\Forms\Inputs\InputCreateController;
use Narsil\Http\Controllers\Forms\Inputs\InputDestroyController;
use Narsil\Http\Controllers\Forms\Inputs\InputDestroyManyController;
use Narsil\Http\Controllers\Forms\Inputs\InputEditController;
use Narsil\Http\Controllers\Forms\Inputs\InputIndexController;
use Narsil\Http\Controllers\Forms\Inputs\InputReplicateController;
use Narsil\Http\Controllers\Forms\Inputs\InputReplicateManyController;
use Narsil\Http\Controllers\Forms\Inputs\InputStoreController;
use Narsil\Http\Controllers\Forms\Inputs\InputUpdateController;
use Narsil\Http\Controllers\Globals\Footers\FooterCreateController;
use Narsil\Http\Controllers\Globals\Footers\FooterDestroyController;
use Narsil\Http\Controllers\Globals\Footers\FooterDestroyManyController;
use Narsil\Http\Controllers\Globals\Footers\FooterEditController;
use Narsil\Http\Controllers\Globals\Footers\FooterIndexController;
use Narsil\Http\Controllers\Globals\Footers\FooterReplicateController;
use Narsil\Http\Controllers\Globals\Footers\FooterStoreController;
use Narsil\Http\Controllers\Globals\Footers\FooterUpdateController;
use Narsil\Http\Controllers\Globals\Headers\HeaderCreateController;
use Narsil\Http\Controllers\Globals\Headers\HeaderDestroyController;
use Narsil\Http\Controllers\Globals\Headers\HeaderDestroyManyController;
use Narsil\Http\Controllers\Globals\Headers\HeaderEditController;
use Narsil\Http\Controllers\Globals\Headers\HeaderIndexController;
use Narsil\Http\Controllers\Globals\Headers\HeaderReplicateController;
use Narsil\Http\Controllers\Globals\Headers\HeaderStoreController;
use Narsil\Http\Controllers\Globals\Headers\HeaderUpdateController;
use Narsil\Http\Controllers\Hosts\HostCreateController;
use Narsil\Http\Controllers\Hosts\HostDestroyController;
use Narsil\Http\Controllers\Hosts\HostDestroyManyController;
use Narsil\Http\Controllers\Hosts\HostEditController;
use Narsil\Http\Controllers\Hosts\HostIndexController;
use Narsil\Http\Controllers\Hosts\HostReplicateController;
use Narsil\Http\Controllers\Hosts\HostReplicateManyController;
use Narsil\Http\Controllers\Hosts\HostStoreController;
use Narsil\Http\Controllers\Hosts\HostUpdateController;
use Narsil\Http\Controllers\Policies\Permissions\PermissionEditController;
use Narsil\Http\Controllers\Policies\Permissions\PermissionIndexController;
use Narsil\Http\Controllers\Policies\Permissions\PermissionUpdateController;
use Narsil\Http\Controllers\Policies\Roles\RoleCreateController;
use Narsil\Http\Controllers\Policies\Roles\RoleDestroyController;
use Narsil\Http\Controllers\Policies\Roles\RoleDestroyManyController;
use Narsil\Http\Controllers\Policies\Roles\RoleEditController;
use Narsil\Http\Controllers\Policies\Roles\RoleIndexController;
use Narsil\Http\Controllers\Policies\Roles\RoleReplicateController;
use Narsil\Http\Controllers\Policies\Roles\RoleReplicateManyController;
use Narsil\Http\Controllers\Policies\Roles\RoleStoreController;
use Narsil\Http\Controllers\Policies\Roles\RoleUpdateController;
use Narsil\Http\Controllers\SessionController;
use Narsil\Http\Controllers\Sites\Pages\SitePageCreateController;
use Narsil\Http\Controllers\Sites\Pages\SitePageDestroyController;
use Narsil\Http\Controllers\Sites\Pages\SitePageEditController;
use Narsil\Http\Controllers\Sites\Pages\SitePageSearchController;
use Narsil\Http\Controllers\Sites\Pages\SitePageStoreController;
use Narsil\Http\Controllers\Sites\Pages\SitePageUpdateController;
use Narsil\Http\Controllers\Sites\SiteEditController;
use Narsil\Http\Controllers\Sites\SiteSummaryController;
use Narsil\Http\Controllers\Sites\SiteUpdateController;
use Narsil\Http\Controllers\Storages\MediaCreateController;
use Narsil\Http\Controllers\Storages\MediaDestroyController;
use Narsil\Http\Controllers\Storages\MediaDestroyManyController;
use Narsil\Http\Controllers\Storages\MediaEditController;
use Narsil\Http\Controllers\Storages\MediaIndexController;
use Narsil\Http\Controllers\Storages\MediaStoreController;
use Narsil\Http\Controllers\Storages\MediaSummaryController;
use Narsil\Http\Controllers\Storages\MediaUpdateController;
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
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\Input;
use Narsil\Models\Globals\Footer;
use Narsil\Models\Globals\Header;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Storages\Media;
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

        Route::prefix(Str::slug(Fieldset::TABLE))->name(Str::slug(Fieldset::TABLE) . '.')->group(function ()
        {
            Route::get('/', FieldsetIndexController::class)
                ->name('index');
            Route::get('/create', FieldsetCreateController::class)
                ->name('create');
            Route::post('/', FieldsetStoreController::class)
                ->name('store');
            Route::get('/{fieldset}/edit', FieldsetEditController::class)
                ->name('edit');
            Route::patch('/{fieldset}', FieldsetUpdateController::class)
                ->name('update');
            Route::delete('/{fieldset}', FieldsetDestroyController::class)
                ->name('destroy');
            Route::delete('/', FieldsetDestroyManyController::class)
                ->name('destroy-many');
            Route::post('/{fieldset}/replicate', FieldsetReplicateController::class)
                ->name('replicate');
            Route::post('/replicate-many', FieldsetReplicateManyController::class)
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

        Route::prefix(Str::slug(Form::TABLE))->name(Str::slug(Form::TABLE) . '.')->group(function ()
        {
            Route::get('/', FormIndexController::class)
                ->name('index');
            Route::get('/create', FormCreateController::class)
                ->name('create');
            Route::post('/', FormStoreController::class)
                ->name('store');
            Route::get('/{form}/edit', FormEditController::class)
                ->name('edit');
            Route::patch('/{form}', FormUpdateController::class)
                ->name('update');
            Route::delete('/{form}', FormDestroyController::class)
                ->name('destroy');
            Route::delete('/', FormDestroyManyController::class)
                ->name('destroy-many');
            Route::post('/{form}/replicate', FormReplicateController::class)
                ->name('replicate');
            Route::post('/replicate-many', FormReplicateManyController::class)
                ->name('replicate-many');
            Route::get('/search', FormSearchController::class)
                ->name('search');
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

        Route::prefix(Str::slug(Input::TABLE))->name(Str::slug(Input::TABLE) . '.')->group(function ()
        {
            Route::get('/', InputIndexController::class)
                ->name('index');
            Route::get('/create', InputCreateController::class)
                ->name('create');
            Route::post('/', InputStoreController::class)
                ->name('store');
            Route::get('/{input}/edit', InputEditController::class)
                ->name('edit');
            Route::patch('/{input}', InputUpdateController::class)
                ->name('update');
            Route::delete('/{input}', InputDestroyController::class)
                ->name('destroy');
            Route::delete('/', InputDestroyManyController::class)
                ->name('destroy-many');
            Route::post('/{input}/replicate', InputReplicateController::class)
                ->name('replicate');
            Route::post('/replicate-many', InputReplicateManyController::class)
                ->name('replicate-many');
        });

        Route::prefix(Str::slug(Media::TABLE))->name(Str::slug(Media::TABLE) . '.')->group(function ()
        {
            Route::get('/', MediaSummaryController::class)
                ->name('summary');
            Route::get('/{disk}', MediaIndexController::class)
                ->name('index');
            Route::get('/{disk}/create', MediaCreateController::class)
                ->name('create');
            Route::post('/{disk}', MediaStoreController::class)
                ->name('store');
            Route::get('/{disk}/{id}/edit', MediaEditController::class)
                ->name('edit');
            Route::patch('/{disk}/{id}', MediaUpdateController::class)
                ->name('update');
            Route::delete('/{disk}/{id}', MediaDestroyController::class)
                ->name('destroy');
            Route::delete('/{disk}', MediaDestroyManyController::class)
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
