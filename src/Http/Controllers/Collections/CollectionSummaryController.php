<?php

declare(strict_types=1);

namespace Narsil\Cms\Http\Controllers\Collections;

#region USE

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Http\Controllers\RenderController;
use Narsil\Cms\Http\Data\SummaryData;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Entities\Entity;

#endregion

class CollectionSummaryController extends RenderController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return View
     */
    public function __invoke(Request $request): View
    {
        $this->authorize(AbilityEnum::VIEW_ANY, Entity::class);

        $locale = App::getLocale();

        $templates = Template::query()
            ->withoutEagerLoads()
            ->orderBy(Template::PLURAL . "->$locale", 'asc')
            ->get();

        $items = $templates->map(function ($template)
        {
            return new SummaryData(
                href: route('collections.index', $template->{Template::TABLE_NAME}),
                name: Str::ucfirst($template->{Template::PLURAL}),
            );
        });

        return $this->renderBlade('narsil-cms::pages.summary.index', [
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
        return trans('narsil-cms::ui.collections');
    }

    /**
     * {@inheritDoc}
     */
    protected function getTitle(): string
    {
        return trans('narsil-cms::ui.collections');
    }

    #endregion
}
