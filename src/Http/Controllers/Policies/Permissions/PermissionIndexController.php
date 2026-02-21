<?php

namespace Narsil\Cms\Http\Controllers\Policies\Permissions;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Http\Collections\DataTableCollection;
use Narsil\Base\Models\Policies\Permission;
use Narsil\Base\Services\ModelService;
use Narsil\Cms\Http\Controllers\RenderController;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PermissionIndexController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(AbilityEnum::VIEW_ANY, Permission::class);

        $collection = $this->getCollection();

        return $this->render('narsil/cms::resources/index', [
            'collection' => $collection,
        ]);
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
        $query = Permission::query()
            ->with([
                Permission::RELATION_ROLES,
                Permission::RELATION_USERS,
            ])
            ->withCount([
                Permission::RELATION_ROLES,
                Permission::RELATION_USERS,
            ]);

        return new DataTableCollection($query, Permission::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getTableLabel(Permission::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getTableLabel(Permission::TABLE);
    }

    #endregion
}
