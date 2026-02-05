<?php

namespace Narsil\Cms\Http\Controllers\Storages;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Collections\DataTableCollection;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Models\Storages\Media;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MediaIndexController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $disk
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, string $disk): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Media::class);

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
     * @param string $disk
     *
     * @return DataTableCollection
     */
    protected function getCollection(): DataTableCollection
    {
        $disk = request('disk');

        $query = Media::query()
            ->where(Media::DISK, $disk);

        return new DataTableCollection($query, Media::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        $disk = request('disk');

        return ModelService::getTableLabel($disk);
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        $disk = request('disk');

        return ModelService::getTableLabel($disk);
    }

    #endregion
}
