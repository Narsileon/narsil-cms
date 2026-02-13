<?php

namespace Narsil\Cms\Http\Controllers\Entities;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Http\Requests\ReplicateManyRequest;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Services\Models\EntityService;
use Narsil\Cms\Traits\IsCollectionController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityReplicateManyController extends RedirectController
{
    use IsCollectionController;

    #region PUBLIC METHODS

    /**
     * @param ReplicateManyRequest $request
     * @param integer|string $collection
     *
     * @return RedirectResponse
     */
    public function __invoke(ReplicateManyRequest $request, int|string $collection): RedirectResponse
    {
        $this->authorize(AbilityEnum::CREATE, $this->entityClass);

        $ids = $request->validated(ReplicateManyRequest::IDS);

        $entities = $this->entityClass::query()
            ->whereIn(Entity::ID, $ids);

        foreach ($entities as $entity)
        {
            EntityService::replicate($entity);
        }

        return back()
            ->with('success', trans('narsil-cms::toasts.success.' . ModelEventEnum::REPLICATED_MANY->value, [
                'model' => $this->template->{Template::SINGULAR},
                'table' => $this->template->{Template::PLURAL},
            ]));
    }

    #endregion
}
