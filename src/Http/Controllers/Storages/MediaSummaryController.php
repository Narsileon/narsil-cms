<?php

namespace Narsil\Http\Controllers\Storages;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Response;
use Narsil\Enums\DiskEnum;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Http\Data\SummaryData;
use Narsil\Models\Storages\Media;
use Narsil\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MediaSummaryController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string $collection
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(PermissionEnum::VIEW_ANY, Media::class);

        $items = [];

        foreach (DiskEnum::cases() as $case)
        {
            $items[] = new SummaryData(
                href: route('media.index', [
                    'disk' => $case->value,
                ]),
                name: Str::ucfirst(trans(ModelService::getTableLabel($case->value))),
            );
        }

        return $this->render('narsil/cms::summary/index', [
            'items' => $items,
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return trans(ModelService::getTableLabel(Media::TABLE));
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans(ModelService::getTableLabel(Media::TABLE));
    }

    #endregion
}
