<?php

namespace Narsil\Http\Middleware;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;
use Narsil\Contracts\Menus\AuthMenu;
use Narsil\Contracts\Menus\GuestMenu;
use Narsil\Contracts\Menus\Sidebar;
use Narsil\Http\Resources\Users\AuthResource;
use Narsil\Models\Users\UserConfiguration;
use Narsil\Services\BreadcrumbService;

#endregions

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class InertiaMiddleware extends Middleware
{
    #region PROPERTIES

    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'backend';

    #endreion

    #region PUBLIC METHODS

    /**
     * Determine the current asset version.
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
        $user = Auth::user();

        $auth = $user ? new AuthResource($user) : null;
        $navigation = $this->getNavigation($request);
        $redirect = $this->getRedirect($request);
        $session = $this->getSession($request);

        return [
            ...parent::share($request),
            'auth' => $auth,
            'navigation' => $navigation,
            'locale' => $locale,
            'redirect' => $redirect,
            'session' => $session,
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

    /**
     * @param Request $request
     *
     * @return array
     */
    protected function getSession(Request $request): array
    {
        return [
            UserConfiguration::COLOR => Session::get(UserConfiguration::COLOR),
            UserConfiguration::RADIUS => Session::get(UserConfiguration::RADIUS),
            UserConfiguration::THEME => Session::get(UserConfiguration::THEME),
        ];
    }

    #endregion
}
