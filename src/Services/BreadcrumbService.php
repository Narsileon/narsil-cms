<?php

namespace Narsil\Cms\Services;

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

            if ($segment === 'admin')
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

                $key = Str::replace('-', '_', (string)$segment);

                $label = ModelService::getTableLabel($key);

                if (Str::contains($label, '::'))
                {
                    $label = trans('narsil-cms::ui.' . $key);
                }

                if (Str::contains($label, '::'))
                {
                    $label = $key;
                }

                $breadcrumbs[] = [
                    'label' => $label,
                    'href'  => $path,
                ];
            }
        }

        return $breadcrumbs;
    }

    #endregion
}
