<?php

namespace Narsil\Http\Controllers\Forms\Fieldsets;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Collections\DataTableCollection;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Forms\FormFieldset;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormFieldsetIndexController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, FormFieldset::class);

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
        $query = FormFieldset::query()
            ->with([
                FormFieldset::RELATION_INPUTS,
            ])
            ->withCount([
                FormFieldset::RELATION_INPUTS,
            ]);

        return new DataTableCollection($query, FormFieldset::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans('narsil::tables.' . FormFieldset::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil::tables.' . FormFieldset::TABLE);
    }

    #endregion
}
