<?php

namespace Narsil\Services\Models;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
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
    public static function replicateTemplate(Template $template): void
    {
        $replicated = $template->replicate();

        $replicated
            ->fill([
                Template::HANDLE => DatabaseService::generateUniqueValue($replicated, Template::HANDLE, $template->{Template::HANDLE}),
            ])
            ->save();

        static::syncTemplateSections($replicated, $template->sections()->get()->toArray());
    }

    /**
     * @param TemplateSection $templateSection
     * @param array $elements
     *
     * @return void
     */
    public static function syncTemplateSectionElements(TemplateSection $templateSection, array $elements): void
    {
        $templateSection->blocks()->detach();
        $templateSection->fields()->detach();

        foreach ($elements as $position => $element)
        {
            $identifier = Arr::get($element, TemplateSectionElement::ATTRIBUTE_IDENTIFIER);

            if (!$identifier || ! Str::contains($identifier, '-'))
            {
                continue;
            }

            [$table, $id] = explode('-', $identifier);

            $attributes = [
                TemplateSectionElement::HANDLE => Arr::get($element, TemplateSectionElement::HANDLE),
                TemplateSectionElement::NAME => json_encode(Arr::get($element, TemplateSectionElement::NAME, [])),
                TemplateSectionElement::POSITION => $position,
                TemplateSectionElement::WIDTH => Arr::get($element, TemplateSectionElement::WIDTH, 100),
            ];

            match ($table)
            {
                Block::TABLE => $templateSection->blocks()->attach($id, $attributes),
                Field::TABLE => $templateSection->fields()->attach($id, $attributes),
                default => null,
            };
        }
    }

    /**
     * @param Template $template
     * @param array $sections
     *
     * @return void
     */
    public static function syncTemplateSections(Template $template, array $sections): void
    {
        $ids = [];

        foreach ($sections as $key => $section)
        {
            $templateSection = TemplateSection::updateOrCreate([
                TemplateSection::TEMPLATE_ID => $template->{Template::ID},
                TemplateSection::HANDLE => Arr::get($section, TemplateSection::HANDLE),
            ], [
                TemplateSection::POSITION => $key,
                TemplateSection::NAME => Arr::get($section, TemplateSection::NAME),
            ]);

            static::syncTemplateSectionElements($templateSection, Arr::get($section, TemplateSection::RELATION_ELEMENTS, []));

            $ids[] = $templateSection->{TemplateSection::ID};
        }

        $template
            ->sections()
            ->whereNotIn(TemplateSection::ID, $ids)
            ->delete();
    }

    #endregion
}
