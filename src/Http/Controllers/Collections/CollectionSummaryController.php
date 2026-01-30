<?php

namespace Narsil\Http\Controllers\Collections;

#region USE

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Inertia\Response;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Http\Controllers\RenderController;
use Narsil\Http\Data\SummaryData;
use Narsil\Models\Collections\Template;
use Narsil\Models\Entities\Entity;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class CollectionSummaryController extends RenderController
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
        $this->authorize(PermissionEnum::VIEW_ANY, Entity::class);

        $locale = App::getLocale();

        $templates = Template::query()
            ->withoutEagerLoads()
            ->orderBy(Template::PLURAL . "->$locale", 'asc')
            ->get();

        $items = $templates->map(function ($template)
        {
            return new SummaryData(
                href: route("collections.index", $template->{Template::TABLE_NAME}),
                name: Str::ucfirst($template->{Template::PLURAL}),
            );
        });

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
        return trans('narsil::ui.collections');
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil::ui.collections');
    }

    #endregion
}
