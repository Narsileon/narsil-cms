<?php

namespace Narsil\Http\Middleware\Inertia;

#region USE

use Narsil\Contracts\Components\AuthMenu;
use Narsil\Contracts\Components\GuestMenu;
use Narsil\Contracts\Components\Sidebar;
use Narsil\Http\Resources\Inertia\UserInertiaResource;
use Narsil\Services\BreadcrumbService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
        $locale = App::getLocale();

        $auth = new UserInertiaResource();
        $navigation = $this->getNavigation($request);
        $redirect = $this->getRedirect($request);

        return [
            ...parent::share($request),

            'auth'       => $auth,
            'navigation' => $navigation,
            'locale'     => $locale,
            'redirect'   => $redirect,
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Request $request
     *
     * @return array
     */
    protected function getNavigation(Request $request): array
    {
        return [
            'breadcrumb' => BreadcrumbService::getBreadcrumbs($request),
            'sidebar' => app(Sidebar::class)->toArray(),
            'user_menu' => app(Auth::check() ? AuthMenu::class : GuestMenu::class)->toArray(),
        ];
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    protected function getRedirect(Request $request): array
    {
        return [
            'error'   => Session::get('error'),
            'info'    => Session::get('info'),
            'success' => Session::get('success'),
            'warning' => Session::get('warning'),
        ];
    }

    #endregion
}
