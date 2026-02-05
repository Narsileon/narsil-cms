<?php

namespace Narsil\Cms\Http\Controllers\Entities;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\SearchRequest;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntitySearchController extends RedirectController
{
    #region CONSTANTS

    /**
     * @var string
     */
    private const COLLECTIONS = 'collections';

    #endregion

    #region PUBLIC METHODS

    /**
     * @param SearchRequest $request
     * @param string $search
     *
     * @return JsonResponse
     */
    public function __invoke(SearchRequest $request): JsonResponse
    {
        $locale = App::getLocale();

        $search = $request->validated(SearchRequest::SEARCH);

        $collections = $request->get(self::COLLECTIONS);

        $templates = Template::query()
            ->when($collections, function ($query) use ($collections)
            {
                return $query
                    ->whereIn(Template::ID, $collections);
            })
            ->get();

        $results = collect();

        foreach ($templates as $template)
        {
            $model = $template->entityClass();

            $models = $model::query()
                ->when($search, function ($query) use ($locale, $search)
                {
                    return $query
                        ->where(Entity::SLUG . '->' . $locale, 'like', "%$search%");
                })
                ->get();

            $results = $results->merge($models->map(function ($entity)
            {
                return new SelectOption()
                    ->optionLabel($entity->{Entity::SLUG})
                    ->optionValue($entity->{Entity::ATTRIBUTE_IDENTIFIER});
            }));
        }

        return response()
            ->json($results);
    }

    #endregion
}
