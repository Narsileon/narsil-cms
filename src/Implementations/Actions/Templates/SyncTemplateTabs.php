<?php

namespace Narsil\Cms\Implementations\Actions\Templates;

#region USE

use Illuminate\Support\Arr;
use Narsil\Base\Implementations\Action;
use Narsil\Cms\Contracts\Actions\Templates\SyncTemplateTabElements;
use Narsil\Cms\Contracts\Actions\Templates\SyncTemplateTabs as Contract;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Collections\TemplateTab;

#endregion

/**
 * @author Jonathan Rigaux
 */
class SyncTemplateTabs extends Action implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function run(Template $template, array $tabs): Template
    {
        $uuids = [];

        foreach ($tabs as $key => $tab)
        {
            $templateTab = TemplateTab::updateOrCreate([
                TemplateTab::TEMPLATE_ID => $template->{Template::ID},
                TemplateTab::HANDLE => Arr::get($tab, TemplateTab::HANDLE),
            ], [
                TemplateTab::POSITION => $key,
                TemplateTab::LABEL => Arr::get($tab, TemplateTab::LABEL),
            ]);

            app(SyncTemplateTabElements::class)
                ->run($templateTab, Arr::get($tab, TemplateTab::RELATION_ELEMENTS, []));

            $uuids[] = $templateTab->{TemplateTab::UUID};
        }

        $template
            ->tabs()
            ->whereNotIn(TemplateTab::UUID, $uuids)
            ->delete();

        return $template;
    }

    #endregion
}
