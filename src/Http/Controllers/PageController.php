<?php

namespace Narsil\Http\Controllers;

#region

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostLocaleLanguage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PageController extends Controller
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string|null $slug
     *
     * @return mixed
     */
    public function __invoke(Request $request): mixed
    {
        return back();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Request $request
     *
     * @return array|null
     */
    protected function resolveURL(Request $request): ?array
    {
        $handle = $request->getHost();

        $host = Host::query()
            ->with([
                Host::RELATION_LOCALES,
                Host::RELATION_LOCALES . '.' . HostLocale::RELATION_LANGUAGES
            ])
            ->where(Host::HANDLE, $handle)->firstOrFail();

        if (!$host)
        {
            abort(404);
        }

        $url = $request->fullUrl();

        foreach ($host->{Host::RELATION_LOCALES} as $hostLocale)
        {
            $regex = $hostLocale->{HostLocale::REGEX};

            if (preg_match($regex, $url, $matches))
            {
                return [
                    'host' => $matches['host'] ?? null,
                    'language' => $matches['language'] ?? null,
                    'country' => $matches['country'] ?? null,
                    'slugs' => isset($matches['slug']) ? explode('/', trim($matches['slug'], '/')) : [],
                ];
            }

            $defaultLocale = $hostLocale->{HostLocale::RELATION_LANGUAGES}?->first();

            if (!$defaultLocale)
            {
                continue;
            }

            $defaultLanguage = $defaultLocale?->{HostLocaleLanguage::LANGUAGE};

            if (!$defaultLanguage)
            {
                continue;
            }

            if (preg_match($regex, $url . '/' . $defaultLanguage, $matches))
            {
                return [
                    'host' => $matches['host'] ?? null,
                    'language' => $matches['language'] ?? null,
                    'country' => $matches['country'] ?? null,
                    'slugs' => [],
                ];
            }
        }

        return null;
    }

    #endregion
}
