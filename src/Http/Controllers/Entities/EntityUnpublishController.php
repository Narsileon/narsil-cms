<?php

namespace Narsil\Cms\Http\Controllers\Entities;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Narsil\Cms\Http\Controllers\RedirectController;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Traits\IsCollectionController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityUnpublishController extends RedirectController
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
        $this->entityClass::withTrashed()
            ->where([
                Entity::ID => $id,
                Entity::PUBLISHED => true,
            ])
            ->update([
                Entity::PUBLISHED => false,
            ]);


        return back();
    }

    #endregion
}
