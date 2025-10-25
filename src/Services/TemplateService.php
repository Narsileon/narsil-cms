<?php

namespace Narsil\Services;

#region USE

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class TemplateService
{
    #region PUBLIC METHODS

    /**
     * @param Block $block
     * @param ?string $type
     *
     * @return Collection<Field>
     */
    public static function getBlockFields(Block $block, ?string $type = null): Collection
    {
        return $block->{Block::RELATION_ELEMENTS}
            ->flatMap(function ($blockElement)
            {
                $element = $blockElement->{BlockElement::RELATION_ELEMENT};

                if ($blockElement->{BlockElement::ELEMENT_TYPE} === Field::class)
                {
                    $field = clone $element;

                    $field->{Field::HANDLE} = $blockElement->{BlockElement::HANDLE};
                    $field->{Field::NAME} = $blockElement->{BlockElement::NAME};

                    return [$field];
                }

                return static::getBlockFields($element);
            })
            ->when($type, function ($collection) use ($type)
            {
                return $collection->where(Field::TYPE, $type);
            });;
    }

    /**
     * @param integer|string $collection
     *
     * @return ?Template
     */
    public static function getTemplate(int|string $collection): ?Template
    {
        $query = Template::query()
            ->with([
                Template::RELATION_SECTIONS . '.' . TemplateSection::RELATION_BlOCKS,
                Template::RELATION_SECTIONS . '.' . TemplateSection::RELATION_FIELDS,
            ]);

        if (is_numeric($collection))
        {
            $template = $query
                ->firstWhere(Template::ID, '=', $collection);
        }
        else
        {
            $template = $query
                ->firstWhere(Template::HANDLE, '=', $collection);
        }

        return $template;
    }

    /**
     * @param Template $template
     * @param ?string $type
     *
     * @return Collection<Field>
     */
    public static function getTemplateFields(Template $template, ?string $type = null): Collection
    {
        return $template->{Template::RELATION_SECTIONS}
            ->flatMap(function ($templateSection)
            {
                return static::getTemplateSectionFields($templateSection);
            })
            ->when($type, function ($collection) use ($type)
            {
                return $collection->where(Field::TYPE, $type);
            });
    }

    /**
     * @param TemplateSection $templateSection
     * @param ?string $type
     *
     * @return Collection<Field>
     */
    public static function getTemplateSectionFields(TemplateSection $templateSection, ?string $type = null): Collection
    {
        return $templateSection->{TemplateSection::RELATION_ELEMENTS}
            ->flatMap(function ($templateSectionElement)
            {
                $element = $templateSectionElement->{TemplateSectionElement::RELATION_ELEMENT};

                if ($templateSectionElement->{TemplateSectionElement::ELEMENT_TYPE} === Field::class)
                {
                    $field = clone $element;

                    $field->{Field::HANDLE} = $templateSectionElement->{TemplateSectionElement::HANDLE};
                    $field->{Field::NAME} = $templateSectionElement->{TemplateSectionElement::NAME};

                    return [$field];
                }

                return static::getBlockFields($element);
            })
            ->when($type, function ($collection) use ($type)
            {
                return $collection->where(Field::TYPE, $type);
            });
    }

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

        static::syncSections($replicated, $template->sections()->get()->toArray());
        static::syncSets($replicated, $template->sets()->get()->toArray());
    }

    /**
     * @param TemplateSection $templateSection
     * @param array $elements
     *
     * @return void
     */
    public static function syncElements(TemplateSection $templateSection, array $elements): void
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
                TemplateSectionElement::WIDTH => Arr::get($element, TemplateSectionElement::WIDTH),
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
     * @param Template $block
     * @param array $sections
     *
     * @return void
     */
    public static function syncSections(Template $template, array $sections): void
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

            static::syncElements($templateSection, Arr::get($section, TemplateSection::RELATION_ELEMENTS, []));

            $ids[] = $templateSection->{TemplateSection::ID};
        }

        $template->sections()
            ->whereNotIn(TemplateSection::ID, $ids)
            ->delete();
    }

    /**
     * @param Template $template
     * @param array $blocks
     *
     * @return void
     */
    public static function syncSets(Template $template, array $blocks): void
    {
        $template->sets()->sync(collect($blocks)->pluck(Block::ID));
    }

    #endregion
}
