<?php

namespace Narsil\Cms\Http\Controllers\Policies\Roles;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Http\Collections\DataTableCollection;
use Narsil\Base\Models\Policies\Role;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleIndexController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(AbilityEnum::VIEW_ANY, Role::class);

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
        $query = Role::query()
            ->with([
                Role::RELATION_PERMISSIONS,
                Role::RELATION_USERS,
            ])
            ->withCount([
                Role::RELATION_PERMISSIONS,
                Role::RELATION_USERS,
            ]);

        return new DataTableCollection($query, Role::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getTableLabel(Role::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getTableLabel(Role::TABLE);
    }

    #endregion
}
