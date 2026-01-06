<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Narsil\Models\Structures\Template;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;
use Narsil\Services\DatabaseService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class TemplateService
{
    #region PUBLIC METHODS

    /**
     * @param Template $template
     *
     * @return void
     */
    public static function replicate(Template $template): void
    {
        $replicated = $template->replicate();

        $replicated
            ->fill([
                Template::TABLE_NAME => DatabaseService::generateUniqueValue($replicated, Template::TABLE_NAME, $template->{Template::TABLE_NAME}),
            ])
            ->save();

        static::syncTemplateTabs($replicated, $template->tabs()->get()->toArray());
    }

    /**
     * @param TemplateTab $templateTab
     * @param array $elements
     *
     * @return void
     */
    public static function syncTemplateTabElements(TemplateTab $templateTab, array $elements): void
    {
        $uuids = [];

        foreach ($elements as $position => $element)
        {
            $identifier = Arr::get($element, TemplateTabElement::ATTRIBUTE_IDENTIFIER);

            if (!$identifier || ! Str::contains($identifier, '-'))
            {
                continue;
            }

            [$table, $id] = explode('-', $identifier);

            $templateTabElement = TemplateTabElement::updateOrCreate([
                TemplateTabElement::OWNER_UUID => $templateTab->{TemplateTab::UUID},
                TemplateTabElement::HANDLE => Arr::get($element, TemplateTabElement::HANDLE),
                TemplateTabElement::ELEMENT_TYPE => $table,
                TemplateTabElement::ELEMENT_ID => $id,
            ], [
                TemplateTabElement::LABEL => Arr::get($element, TemplateTabElement::LABEL, []),
                TemplateTabElement::POSITION => $position,
                TemplateTabElement::WIDTH => Arr::get($element, TemplateTabElement::WIDTH, 100),
            ]);

            $uuids[] = $templateTabElement->{TemplateTabElement::UUID};
        }

        $templateTab
            ->elements()
            ->whereNotIn(TemplateTabElement::UUID, $uuids)
            ->delete();
    }

    /**
     * @param Template $template
     * @param array $tabs
     *
     * @return void
     */
    public static function syncTemplateTabs(Template $template, array $tabs): void
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

            static::syncTemplateTabElements($templateTab, Arr::get($tab, TemplateTab::RELATION_ELEMENTS, []));

            $uuids[] = $templateTab->{TemplateTab::UUID};
        }

        $template
            ->tabs()
            ->whereNotIn(TemplateTab::UUID, $uuids)
            ->delete();
    }

    #endregion
}
