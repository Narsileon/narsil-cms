<?php

namespace Narsil\Services;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Str;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class BreadcrumbService
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return array
     */
    public static function getBreadcrumbs(Request $request): array
    {
        $segments = $request->segments();

        $breadcrumbs = [];

        $path = '';

        foreach ($segments as $segment)
        {
            $path .= '/' . $segment;

            if ($segment === 'narsil')
            {
                continue;
            }

            if (ctype_digit($segment))
            {
                $breadcrumbs[] = [
                    'label' => $segment,
                    'href'  => null,
                ];
            }
            else
            {
                $breadcrumbs[] = [
                    'label' => trans('narsil::ui.' . Str::replace('-', '_', $segment)),
                    'href'  => $path,
                ];
            }
        }

        return $breadcrumbs;
    }

    #endregion
}
