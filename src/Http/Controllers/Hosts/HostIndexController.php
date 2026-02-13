<?php

namespace Narsil\Cms\Http\Controllers\Hosts;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Cms\Http\Collections\DataTableCollection;
use Narsil\Cms\Http\Controllers\RenderController;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;
use Narsil\Cms\Services\ModelService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostIndexController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return JsonResponse|Response
     */
    public function __invoke(Request $request): JsonResponse|Response
    {
        $this->authorize(AbilityEnum::VIEW_ANY, Host::class);

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
        $query = Host::query()
            ->with([
                Host::RELATION_LANGUAGES,
                Host::RELATION_LOCALES,
            ])
            ->withCount([
                Host::RELATION_LOCALES,
                Host::RELATION_LANGUAGES => function ($query)
                {
                    $query->select(
                        DB::raw('COUNT(DISTINCT ' . HostLocaleLanguage::LANGUAGE . ')')
                    );
                },
            ]);

        return new DataTableCollection($query, Host::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getDescription(): string
    {
        return ModelService::getTableLabel(Host::TABLE);
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return ModelService::getTableLabel(Host::TABLE);
    }

    #endregion
}
