<?php

namespace App\Http\Middleware;

#region USE

use App\Models\User;
use App\Services\LangService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Inertia\Middleware;

#endregion

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
        $locale = LangService::getLocale();

        return [
            ...parent::share($request),

            'auth' => $this->getAuth(),
            'breadcrumb' => $this->getBreadcrumb(),
            'redirect' => $this->getRedirect(),
            'sidebar' => $this->getSidebar(),
            'shared' => [
                'locale'       => $locale,
                'locales'      => Config::get('narsil.locales', []),
            ],
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array
     */
    protected function getAuth(): array
    {
        $user = Auth::user();

        if (!$user)
        {
            return [];
        }

        return [
            User::EMAIL => $user->{User::EMAIL},
            User::FIRST_NAME => $user->{User::FIRST_NAME},
            User::LAST_NAME => $user->{User::LAST_NAME},
            User::TWO_FACTOR_CONFIRMED_AT => $user->{User::TWO_FACTOR_CONFIRMED_AT},
        ];
    }

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
    protected function getSidebar(): array
    {
        return array_merge(Config::get('narsil.sidebar', [
            'content' => []
        ]), [
            'translations' => [
                'open' => trans('accessibility.open_sidebar'),
                'close' => trans('accessibility.close_sidebar'),
            ],
        ]);
    }

    #endregion
}
