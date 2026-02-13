<?php

namespace Narsil\Cms\Http\Controllers\Globals\Footers;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Cms\Http\Collections\DataTableCollection;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterIndexController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(AbilityEnum::VIEW_ANY, Footer::class);

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
        $query = Footer::query()
            ->with([
                Footer::RELATION_LINKS,
                Footer::RELATION_SOCIAL_MEDIA,
                Footer::RELATION_WEBSITES,
            ])
            ->withCount([
                Footer::RELATION_LINKS,
                Footer::RELATION_SOCIAL_MEDIA,
                Footer::RELATION_WEBSITES,
            ]);

        return new DataTableCollection($query, Footer::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getTableLabel(Footer::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getTableLabel(Footer::TABLE);
    }

    #endregion
}
