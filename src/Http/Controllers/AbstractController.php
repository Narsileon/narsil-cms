<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Narsil\Http\Requests\QueryRequest;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
abstract class AbstractController
{
    use AuthorizesRequests;

    #region PROTECTED METHODS

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
     * @param string|null $to
     * @param mixed $data
     *
     * @return RedirectResponse
     */
    protected function redirect(?string $to = null, mixed $data = []): RedirectResponse
    {
        if (request()->get('_back'))
        {
            return back()
                ->with('data', $data);
        }
        else
        {
            $to = request('_to', $to);

            return redirect($to);
        }
    }

    /**
     * @param string $component
     * @param string $title
     * @param string $description
     * @param array $props
     *
     * @return JsonResponse|Response
     */
    protected function render(string $component, string $title = '', string $description = '', array $props = []): JsonResponse|Response
    {
        $TranslationsBag = app(TranslationsBag::class);

        if (request()->boolean('_modal'))
        {
            $translations = $TranslationsBag
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

        $translations = $TranslationsBag->get();

        return Inertia::render($component, array_merge([
            'description' => $description,
            'translations' => $translations,
            'title' => $title,
        ], $props));
    }

    #endregion
}
