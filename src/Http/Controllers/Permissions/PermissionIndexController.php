<?php

namespace Narsil\Http\Controllers\Permissions;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Collections\DataTableCollection;
use Narsil\Http\Controllers\AbstractController;
use Narsil\Models\Policies\Permission;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PermissionIndexController extends AbstractController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Permission::class);

        $title = trans('narsil::tables.' . Permission::TABLE);
        $description = trans('narsil::tables.' . Permission::TABLE);
        $collection = $this->getCollection();

        return $this->render(
            component: 'narsil/cms::resources/index',
            title: $title,
            description: $description,
            props: [
                'collection' => $collection,
            ]
        );
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the associated collection.
     *
     * @return DataTableCollection
     */
    protected function getCollection(): DataTableCollection
    {
        $query = Permission::query();

        return new DataTableCollection($query, Permission::TABLE);
    }

    #endregion
}
