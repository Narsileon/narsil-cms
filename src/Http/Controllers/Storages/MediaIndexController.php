<?php

namespace Narsil\Http\Controllers\Storages;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Collections\DataTableCollection;
use Narsil\Http\Controllers\RenderController;
use Narsil\Models\Storages\Media;

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
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request, string $disk): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Media::class);

        $collection = $this->getCollection($disk);

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
    protected function getCollection(string $disk): DataTableCollection
    {
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

        return trans("narsil::ui.$disk");
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        $disk = request('disk');

        return trans("narsil::ui.$disk");
    }

    #endregion
}
