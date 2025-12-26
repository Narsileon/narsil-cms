<?php

namespace Narsil\Http\Controllers\Structures\Templates;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Collections\DataTableCollection;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Structures\Template;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateIndexController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Template::class);

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
        $query = Template::query();

        return new DataTableCollection($query, Template::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getTableLabel(Template::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getTableLabel(Template::TABLE);
    }

    #endregion
}
