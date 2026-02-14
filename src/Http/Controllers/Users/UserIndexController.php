<?php

namespace Narsil\Cms\Http\Controllers\Users;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Http\Collections\DataTableCollection;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Models\User;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserIndexController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(AbilityEnum::VIEW_ANY, User::class);

        $collection = $this->getCollection();

        return $this->render('narsil/cms::resources/index', [
            'collection' => $collection,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return DataTableCollection
     */
    protected function getCollection(): DataTableCollection
    {
        $query = User::query()
            ->with([
                User::RELATION_PERMISSIONS,
                User::RELATION_ROLES,
            ])
            ->withCount([
                User::RELATION_PERMISSIONS,
                User::RELATION_ROLES,
            ]);

        return new DataTableCollection($query, User::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getTableLabel(User::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getTableLabel(User::TABLE);
    }

    #endregion
}
