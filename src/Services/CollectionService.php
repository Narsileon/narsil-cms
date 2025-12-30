<?php

namespace Narsil\Services;

#region USE

use Illuminate\Support\Collection;
use Narsil\Contracts\Fields\BuilderField;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Template;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class CollectionService
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
                    if ($element->{Field::TYPE} === BuilderField::class)
                    {
                        return [];
                    }

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
            });
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
                Template::RELATION_TABS . '.' . TemplateTab::RELATION_BlOCKS,
                Template::RELATION_TABS . '.' . TemplateTab::RELATION_FIELDS,
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
        return $template->{Template::RELATION_TABS}
            ->flatMap(function ($templateTab)
            {
                return static::getTemplateTabFields($templateTab);
            })
            ->when($type, function ($collection) use ($type)
            {
                return $collection->where(Field::TYPE, $type);
            });
    }

    /**
     * @param TemplateTab $templateTab
     * @param ?string $type
     *
     * @return Collection<Field>
     */
    public static function getTemplateTabFields(TemplateTab $templateTab, ?string $type = null): Collection
    {
        return $templateTab->{TemplateTab::RELATION_ELEMENTS}
            ->flatMap(function ($templateTabElement)
            {
                $element = $templateTabElement->{TemplateTabElement::RELATION_ELEMENT};

                if ($templateTabElement->{TemplateTabElement::ELEMENT_TYPE} === Field::class)
                {
                    if ($element->{Field::TYPE} === BuilderField::class)
                    {
                        return [];
                    }

                    $field = clone $element;

                    $field->{Field::HANDLE} = $templateTabElement->{TemplateTabElement::HANDLE};
                    $field->{Field::NAME} = $templateTabElement->{TemplateTabElement::NAME};

                    return [$field];
                }

                return static::getBlockFields($element);
            })
            ->when($type, function ($collection) use ($type)
            {
                return $collection->where(Field::TYPE, $type);
            });
    }

    #endregion
}
