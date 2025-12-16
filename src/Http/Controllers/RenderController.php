<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Narsil\Http\Requests\QueryRequest;
use Narsil\Support\TranslationsBag;

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
     * @param Builder $query
     * @param string $column
     * @param mixed $filter
     *
     * @return void
     */
    protected function filter(Builder $query, string $column, mixed $filter = null): void
    {
        if (!$filter)
        {
            $filter = request(QueryRequest::FILTER, null);
        }

        if (!$filter)
        {
            return;
        }

        $query->where($column, '=', $filter);
    }

    /**
     * @param string $component
     * @param array $props
     *
     * @return JsonResponse|Response
     */
    protected function render(string $component, array $props = []): JsonResponse|Response
    {
        $translationsBag = app(TranslationsBag::class);

        $description = Str::ucfirst($this->getDescription());
        $title = Str::ucfirst($this->getTitle());

        if (request()->boolean('_modal'))
        {
            $translations = $translationsBag
                ->add('narsil::accessibility.close_dialog')
                ->add('narsil::ui.cancel')
                ->get();

            return response()->json([
                'component' => $component,
                'props' => array_merge([
                    '_modal' => true,
                    'description' => $description,
                    'translations' => $translations,
                    'title' => $title,
                ], $props),
            ]);
        }

        $translations = $translationsBag->get();

        return Inertia::render($component, array_merge([
            'description' => $description,
            'translations' => $translations,
            'title' => $title,
        ], $props));
    }

    #endregion
}
