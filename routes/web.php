<?php

#region USE

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Narsil\Http\Controllers\BlockController;
use Narsil\Http\Controllers\DashboardController;
use Narsil\Http\Controllers\EntityController;
use Narsil\Http\Controllers\FieldController;
use Narsil\Http\Controllers\RoleController;
use Narsil\Http\Controllers\SessionController;
use Narsil\Http\Controllers\SiteController;
use Narsil\Http\Controllers\SiteGroupController;
use Narsil\Http\Controllers\TemplateController;
use Narsil\Http\Controllers\UserConfigurationController;
use Narsil\Http\Controllers\UserController;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Policies\Role;
use Narsil\Models\Sites\Site;
use Narsil\Models\Sites\SiteGroup;
use Narsil\Models\User;

#endregion

/**
 * @param string $table
 * @param string $controller
 * @param array $except
 *
 * @return void
 */
function resource(string $table, string $controller, array $except = [])
{
    $slug = Str::slug($table);

    Route::controller($controller)->group(function () use ($slug, $controller)
    {
        Route::delete($slug, 'destroyMany')
            ->name("$slug.destroyMany");
        Route::resource($slug, $controller)
            ->except(['show']);
    });
}

Route::middleware([
    'web',
    'auth',
    'verified',
])->group(
    function ()
    {
        Route::get('/dashboard', DashboardController::class)
            ->name('dashboard');

        #region RESOURCES

        resource(Block::TABLE, BlockController::class, [
            'show',
        ]);
        resource(Field::TABLE, FieldController::class, [
            'show',
        ]);
        resource(Role::TABLE, RoleController::class, [
            'show',
        ]);
        resource(SiteGroup::TABLE, SiteGroupController::class, [
            'show',
        ]);
        resource(Site::TABLE, SiteController::class, [
            'show',
        ]);
        resource(Template::TABLE, TemplateController::class, [
            'show',
        ]);
        resource(User::TABLE, UserController::class, [
            'show',
        ]);

        #endregion

        #region ENTITIES

        Route::controller(EntityController::class)->group(function ()
        {
            Route::delete('collections/{collection}', 'destroyMany')
                ->name('collections.destroyMany');
            Route::get('collections/{collection}', 'index')
                ->name('collections.index');
            Route::post('collections/{collection}', 'store')
                ->name('collections.store');
            Route::get('collections/{collection}/create', 'create')
                ->name('collections.create');
            Route::patch('collections/{collection}/{id}', 'update')
                ->name('collections.update');
            Route::delete('collections/{collection}/{id}', 'destroy')
                ->name('collections.destroy');
            Route::get('collections/{collection}/{id}/edit', 'edit')
                ->name('collections.edit');
        });

        #endregion

        #region USERS

        Route::delete('/sessions', SessionController::class)
            ->name('sessions.delete');

        #endregion
    }
);

Route::middleware([
    'web',
])->group(
    function ()
    {
        #region USERS

        Route::resource('/user-configuration', UserConfigurationController::class)
            ->only([
                'index',
                'store',
            ]);

        #endregion
    }
);
