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
    #region PUBLIC METHODS

    /**
     * @param string $component
     * @param array $props
     *
     * @return JsonResponse|Response
     */
    public static function render(string $component, string $title = '', string $description = '', array $props = []): JsonResponse|Response
    {
        $labelsBag = app(LabelsBag::class)
            ->add('narsil-cms::accessibility.close_dialog')
            ->add('narsil-cms::ui.cancel');

        $labels = $labelsBag->get();

        if (request()->boolean('_modal'))
        {
            return response()->json([
                'component' => $component,
                'props' => array_merge([
                    '_modal' => true,
                    'description' => $description,
                    'labels' => $labels,
                    'title' => $title,
                ], $props),
            ]);
        }

        return Inertia::render($component, array_merge([
            'description' => $description,
            'labels' => $labels,
            'title' => $title,
        ], $props));
    }

    #endregion
}
