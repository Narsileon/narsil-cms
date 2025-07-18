<?php

namespace App\Services;

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

            $breadcrumbs[] = [
                'label' => trans('ui.' . Str::snake($segment)),
                'href'  => $path,
            ];
        }

        return $breadcrumbs;
    }

    #endregion
}
