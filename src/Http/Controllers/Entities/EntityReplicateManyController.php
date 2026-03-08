<?php

namespace Narsil\Cms\Http\Controllers\Entities;

#region USE

use Illuminate\Http\RedirectResponse;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Base\Http\Controllers\RedirectController;
use Narsil\Base\Http\Requests\ReplicateManyRequest;
use Narsil\Cms\Contracts\Actions\Entities\ReplicateEntity;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Traits\IsCollectionController;

#endregion

/**
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
            app(ReplicateEntity::class)
                ->run($entity);
        }

        return back()
            ->with('success', trans('narsil::toasts.success.' . ModelEventEnum::REPLICATED_MANY->value, [
                'model' => $this->template->{Template::SINGULAR},
                'table' => $this->template->{Template::PLURAL},
            ]));
    }

    #endregion
}
