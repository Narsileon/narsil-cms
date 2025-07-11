<?php

namespace App\Http\Middleware;

#region USE

use App\Models\User;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
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
        $locale = TranslationService::getLocale();

        return [
            ...parent::share($request),

            'auth' => $this->getAuth(),
            'config' => $this->getConfig(),
            'redirect' => $this->getRedirect(),
            'shared' => [
                'locale'       => $locale,
                'locales'      => Config::get('narsil.locales', []),
                'translations' => TranslationService::getTranslations($locale),
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
    protected function getConfig(): array
    {
        return [
            'sidebar' => Config::get('narsil.sidebar', [
                'content' => []
            ]),
        ];
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

    #endregion
}
