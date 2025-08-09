<?php

namespace Narsil\Http\Controllers;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;
use Narsil\Http\Requests\QueryRequest;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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
     * @param array $rules
     *
     * @return array
     */
    protected function getAttributes(array $rules): array
    {
        $data = request()->all();

        $validator = Validator::make($data, $rules);

        return $validator->validated();
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
        $labelsBag = app(LabelsBag::class);

        if (request()->boolean('_modal'))
        {
            $labelsBag
                ->add('narsil-cms::accessibility.close_dialog')
                ->add('narsil-cms::ui.cancel');

            $labels = $labelsBag->get();

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

        $labels = $labelsBag->get();

        return Inertia::render($component, array_merge([
            'description' => $description,
            'labels' => $labels,
            'title' => $title,
        ], $props));
    }

    #endregion
}
