<?php

namespace App\Http\Middleware\Inertia;

#region USE

use App\Contracts\Components\Sidebar;
use App\Contracts\Components\UserMenu;
use App\Http\Resources\Inertia\UserInertiaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Inertia\Middleware;

#endregions

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HandleInertiaRequests extends Middleware
{
    #region PROPERTIES

    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    #endreion

    #region PUBLIC METHODS

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),

            'auth'       => new UserInertiaResource(),
            'breadcrumb' => $this->getBreadcrumb(),
            'locale' => App::getLocale(),
            'redirect'   => $this->getRedirect(),
            'shared'     => [
                'components' => $this->getComponents(),
            ],
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array
     */
    protected function getBreadcrumb(): array
    {
        $segments = request()->segments();

        $breadcrumbs = [];

        $path = '';

        foreach ($segments as $segment)
        {
            $path .= '/' . $segment;

            $breadcrumbs[] = [
                'label' => trans('ui.' . Str::snake($segment)),
                'href'  => $path,
            ];
        }

        return $breadcrumbs;
    }

    /**
     * @return array
     */
    protected function getRedirect(): array
    {
        return [
            'error' => Session::get('error'),
            'success' => Session::get('success')
        ];
    }

    /**
     * @return array
     */
    protected function getComponents(): array
    {
        return [
            'sidebar' => app(Sidebar::class)->get(),
            'user_menu' => app(UserMenu::class)->get(),
        ];
    }

    #endregion
}
