<?php

namespace Narsil;

#region USE

use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Narsil
{
    /**
     * @param string $component
     * @param array $props
     *
     * @return JsonResponse|Response
     */
    public static function render(string $component, array $props = []): JsonResponse|Response
    {
        $labels = app(LabelsBag::class)->get();

        if (request()->boolean('_modal'))
        {
            return response()->json([
                'component' => $component,
                'props' => array_merge([
                    '_modal' => true,
                    'labels' => $labels,
                ], $props),
            ]);
        }

        return Inertia::render($component, array_merge([
            'labels' => $labels,
        ], $props));
    }
}
