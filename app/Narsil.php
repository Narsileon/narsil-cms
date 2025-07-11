<?php

namespace App;

#region USE

use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

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
        if (request()->boolean('_modal'))
        {
            return response()->json([
                'component' => $component,
                'props' => array_merge(['_modal' => true], $props),
            ]);
        }

        return Inertia::render($component, $props);
    }
}
