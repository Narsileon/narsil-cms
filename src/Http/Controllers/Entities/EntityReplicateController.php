<?php

namespace Narsil\Cms\Http\Controllers\Entities;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Enums\ModelEventEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Services\Models\EntityService;
use Narsil\Cms\Traits\IsCollectionController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityReplicateController extends RedirectController
{
    use IsCollectionController;

    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param integer|string $collection
     * @param integer $id
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request, int|string $collection, int $id): RedirectResponse
    {
        $this->authorize(AbilityEnum::CREATE, $this->entityClass);

        $entity = $this->entityClass::query()
            ->firstWhere([
                Entity::ID => $id
            ]);

        EntityService::replicate($entity);

        return back()
            ->with('success', trans('narsil::toasts.success.' . ModelEventEnum::REPLICATED->value, [
                'model' => $this->template->{Template::SINGULAR},
                'table' => $this->template->{Template::PLURAL},
            ]));
    }

    #endregion
}
