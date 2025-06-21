<?php

namespace App\Http\Middleware;

#region USE

use App\Services\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Middleware;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class HandleInertiaRequests extends Middleware
{
    #region CONSTANTS

    /**
     * @var string The name of the "shared" prop.
     */
    private const SHARED = "shared";
    /**
     * @var string The name of the "translations" prop.
     */
    private const TRANSLATIONS = "translations";

    #endregion

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

            self::SHARED => [
                self::TRANSLATIONS => TranslationService::getTranslations(App::getLocale())
            ],
        ];
    }

    #endregion
}
