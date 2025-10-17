<?php

#region USE

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Narsil\Http\Controllers\BlockController;
use Narsil\Http\Controllers\CollectionController;
use Narsil\Http\Controllers\DashboardController;
use Narsil\Http\Controllers\EntityController;
use Narsil\Http\Controllers\FieldController;
use Narsil\Http\Controllers\HostController;
use Narsil\Http\Controllers\RoleController;
use Narsil\Http\Controllers\SessionController;
use Narsil\Http\Controllers\SiteController;
use Narsil\Http\Controllers\TemplateController;
use Narsil\Http\Controllers\UserBookmarkController;
use Narsil\Http\Controllers\UserConfigurationController;
use Narsil\Http\Controllers\UserController;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Policies\Role;
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
    Route::controller($controller)->group(function () use ($controller, $except, $table)
    {
        $plural = Str::slug($table);
        $singular = Str::singular($table);

        if (!in_array('destroyMany', $except))
        {
            Route::delete($plural, 'destroyMany')
                ->name("$plural.destroyMany");
        }
        if (!in_array('replicate', $except))
        {
            Route::post("$plural/{{$singular}}/replicate", 'replicate')
                ->name("$plural.replicate");
        }
        if (!in_array('replicateMany', $except))
        {
            Route::post("$plural/replicateMany", 'replicateMany')
                ->name("$plural.replicateMany");
        }

        Route::resource($plural, $controller)
            ->except($except);
    });
}

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

        resource(Block::TABLE, BlockController::class, [
            'show',
        ]);
        resource(Field::TABLE, FieldController::class, [
            'show',
        ]);
        resource(Host::TABLE, HostController::class, [
            'show',
        ]);
        resource(Role::TABLE, RoleController::class, [
            'show',
        ]);
        resource(Template::TABLE, TemplateController::class, [
            'show',
        ]);
        resource(User::TABLE, UserController::class, [
            'replicate',
            'replicateMany',
            'show',
        ]);

        #endregion

        #region COLLECTIONS

        Route::get('collections', CollectionController::class)
            ->name('collections.summary');

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
            Route::post('collections/{collection}/replicateMany', 'replicateMany')
                ->name('collections.replicateMany');
            Route::patch('collections/{collection}/{id}', 'update')
                ->name('collections.update');
            Route::delete('collections/{collection}/{id}', 'destroy')
                ->name('collections.destroy');
            Route::get('collections/{collection}/{id}/edit', 'edit')
                ->name('collections.edit');
            Route::post('collections/{collection}/{id}/replicate', 'replicate')
                ->name('collections.replicate');
        });

        Route::controller(SiteController::class)->group(function ()
        {
            Route::get('sites', 'index')
                ->name('sites.index');
            Route::patch('sites/{site}/{id}', 'update')
                ->name('sites.update');
            Route::get('sites/{site}/{id}/edit', 'edit')
                ->name('sites.edit');
        });

        #endregion

        #region USERS

        Route::resource('/user-bookmarks', UserBookmarkController::class)
            ->only([
                'index',
                'store',
                'update',
                'destroy',
            ]);

        Route::delete('/sessions', SessionController::class)
            ->name('sessions.delete');

        #endregion
    }
);

#region USERS

Route::resource('/user-configuration', UserConfigurationController::class)
    ->only([
        'index',
        'store',
    ]);

#endregion
