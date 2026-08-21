<?php

declare(strict_types=1);

namespace Narsil\Cms\Services;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Narsil\Base\Traits\HasSchemas;
use Narsil\Cms\Models\Redirect;

#endregion

final class RedirectService
{
    use HasSchemas;

    #region PUBLIC METHODS

    /**
     * Resolve a configured redirect for the current URL.
     *
     * @param Request $request
     *
     * @return RedirectResponse|null
     */
    public function resolve(Request $request): ?RedirectResponse
    {
        $redirects = $this->getRedirects();
        $sourceUrls = [
            Str::lower($request->url()),
            Str::lower($request->getPathInfo()),
        ];
        $redirect = null;

        foreach ($sourceUrls as $sourceUrl)
        {
            if (isset($redirects[$sourceUrl]))
            {
                $redirect = $redirects[$sourceUrl];
                break;
            }
        }

        $response = null;

        if ($redirect)
        {
            $response = redirect()->to(
                $redirect[Redirect::URL_DESTINATION],
                $redirect[Redirect::STATUS_CODE],
            );
        }

        return $response;
    }

    #endregion

    #region PRIVATE METHODS

    /**
     * Get all configured redirects for the current schema.
     *
     * @return array<string,array<string,integer|string>>
     */
    private function getRedirects(): array
    {
        $schema = $this->getCurrentSchema();

        return Cache::tags(Redirect::TABLE)->rememberForever("redirects:$schema", function (): array
        {
            return Redirect::query()
                ->get([
                    Redirect::URL_DESTINATION,
                    Redirect::URL_SOURCE,
                    Redirect::STATUS_CODE,
                ])
                ->mapWithKeys(function (Redirect $redirect): array
                {
                    return [
                        Str::lower($redirect->{Redirect::URL_SOURCE}) => [
                            Redirect::URL_DESTINATION => $redirect->{Redirect::URL_DESTINATION},
                            Redirect::STATUS_CODE => (int) $redirect->{Redirect::STATUS_CODE},
                        ],
                    ];
                })
                ->all();
        });
    }

    #endregion
}
