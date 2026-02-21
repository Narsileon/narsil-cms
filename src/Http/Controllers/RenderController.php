<?php

namespace Narsil\Cms\Http\Controllers;

#region USE

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;
use Narsil\Base\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class RenderController
{
    use AuthorizesRequests;

    #region PROTECTED METHODS

    /**
     * Get the description of the page.
     *
     * @return string
     */
    abstract protected function getDescription(): string;

    /**
     * Get the title of the page.
     *
     * @return string
     */
    abstract protected function getTitle(): string;

    /**
     * @param string $component
     * @param array $props
     *
     * @return JsonResponse|Response
     */
    protected function render(string $component, array $props = []): JsonResponse|Response
    {
        $translationsBag = app(TranslationsBag::class);

        if (request()->boolean('_modal'))
        {
            $translations = $translationsBag
                ->add('narsil-cms::accessibility.close_dialog')
                ->add('narsil::ui.cancel')
                ->get();

            return response()->json([
                'component' => $component,
                'props' => array_merge([
                    '_modal' => true,
                    'description' => $this->getDescription(),
                    'translations' => $translations,
                    'title' => $this->getTitle(),
                ], $props),
            ]);
        }

        $translations = $translationsBag->get();

        return Inertia::render($component, array_merge([
            'description' => $this->getDescription(),
            'translations' => $translations,
            'title' => $this->getTitle(),
        ], $props));
    }

    #endregion
}
