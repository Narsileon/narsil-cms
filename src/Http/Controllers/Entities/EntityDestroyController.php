<?php

namespace Narsil\Cms\Http\Controllers\Entities;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Cms\Enums\ModelEventEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Traits\IsCollectionController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityDestroyController extends RedirectController
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
        $entity = $this->entityClass::query()
            ->firstWhere([
                Entity::ID => $id
            ]);

        $this->authorize(PermissionEnum::DELETE, $entity);

        $entity->forceDelete();

        return $this
            ->redirect(route('collections.index', [
                'collection' => $collection,
            ]))
            ->with('success', trans('narsil::toasts.success.' . ModelEventEnum::DELETED->value, [
                'model' => $this->template->{Template::SINGULAR},
                'table' => $this->template->{Template::PLURAL},
            ]));
    }

    #endregion
}
