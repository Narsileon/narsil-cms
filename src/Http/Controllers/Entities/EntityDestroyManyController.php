<?php

namespace Narsil\Cms\Http\Controllers\Entities;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\DestroyManyRequest;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Traits\IsCollectionController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityDestroyManyController extends RedirectController
{
    use IsCollectionController;

    #region PUBLIC METHODS

    /**
     * @param DestroyManyRequest $request
     * @param integer|string $collection
     *
     * @return RedirectResponse
     */
    public function __invoke(DestroyManyRequest $request, int|string $collection): RedirectResponse
    {
        $this->authorize(AbilityEnum::DELETE_ANY, $this->entityClass);

        $ids = $request->validated(DestroyManyRequest::IDS);

        $this->entityClass::query()
            ->whereIn(Entity::ID, $ids)
            ->forceDelete();

        return $this
            ->redirect(route('collections.index', [
                'collection' => $collection,
            ]))
            ->with('success', trans('narsil-cms::toasts.success.' . ModelEventEnum::DELETED_MANY->value, [
                'model' => $this->template->{Template::SINGULAR},
                'table' => $this->template->{Template::PLURAL},
            ]));
    }

    #endregion
}
