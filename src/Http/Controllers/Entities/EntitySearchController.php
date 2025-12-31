<?php

namespace Narsil\Http\Controllers\Entities;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Narsil\Http\Controllers\RedirectController;
use Narsil\Http\Requests\SearchRequest;
use Narsil\Models\Entities\Entity;
use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntitySearchController extends RedirectController
{
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

        $selectOptions = Entity::query()
            ->when($search, function ($query) use ($locale, $search)
            {
                return $query
                    ->where(Entity::SLUG . '->' . $locale, 'like', "%$search%");
            })
            ->get()
            ->map(function (Entity $entity)
            {
                return (new SelectOption())
                    ->optionLabel($entity->{Entity::SLUG})
                    ->optionValue($entity->{Entity::ID});
            })
            ->all();

        return response()
            ->json($selectOptions);
    }

    #endregion
}
