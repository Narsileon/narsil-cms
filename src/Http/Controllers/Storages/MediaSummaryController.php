<?php

namespace Narsil\Cms\Http\Controllers\Storages;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Response;
use Narsil\Cms\Enums\DiskEnum;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Http\Data\SummaryData;
use Narsil\Cms\Models\Storages\Media;
use Narsil\Cms\Services\ModelService;

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
