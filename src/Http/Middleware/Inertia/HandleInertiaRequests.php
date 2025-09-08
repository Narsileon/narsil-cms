<?php

namespace Narsil\Http\Middleware\Inertia;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;
use Narsil\Contracts\Blocks\AuthMenu;
use Narsil\Contracts\Blocks\GuestMenu;
use Narsil\Contracts\Blocks\Sidebar;
use Narsil\Http\Resources\UserInertiaResource;
use Narsil\Services\BreadcrumbService;

#endregions

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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

            'auth' => $auth,
            'navigation' => $navigation,
            'locale' => $locale,
            'redirect' => $redirect,
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
            'sidebar' => app(Sidebar::class),
            'userMenu' => app(Auth::check() ? AuthMenu::class : GuestMenu::class),
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
            'data' => Session::get('data'),
            'error' => Session::get('error'),
            'info' => Session::get('info'),
            'success' => Session::get('success'),
            'warning' => Session::get('warning'),
        ];
    }

    #endregion
}
