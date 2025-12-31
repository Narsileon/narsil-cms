<?php

namespace Narsil\Services;

#region USE

use Illuminate\Support\Collection;
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
     * @param integer|string $collection
     *
     * @return ?Template
     */
    public static function getTemplate(int|string $collection): ?Template
    {
        $query = Template::query()
            ->with([
                Template::RELATION_TABS . '.' . TemplateTab::RELATION_ELEMENTS . '.' . TemplateTabElement::RELATION_BLOCK,
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
     *
     * @return Collection<BlockElement|TemplateTabElement>
     */
    public static function getFieldElements(Template $template): Collection
    {
        return $template->{Template::RELATION_TABS}
            ->flatMap(function ($templateTab)
            {
                return static::getTabFieldElements($templateTab);
            });
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Block $block
     *
     * @return Collection<BlockElement|TemplateTabElement>
     */
    protected static function getBlockFieldElements(Block $block): Collection
    {
        return $block->{Block::RELATION_ELEMENTS}
            ->flatMap(function ($blockElement)
            {
                if ($blockElement->{BlockElement::ELEMENT_TYPE} === Field::class)
                {
                    return [$blockElement];
                }
                else
                {
                    return static::getBlockFieldElements($blockElement->{BlockElement::RELATION_BLOCK});
                }
            });
    }

    /**
     * @param TemplateTab $templateTab
     *
     * @return Collection<BlockElement|TemplateTabElement>
     */
    protected static function getTabFieldElements(TemplateTab $templateTab): Collection
    {
        return $templateTab->{TemplateTab::RELATION_ELEMENTS}
            ->flatMap(function ($templateTabElement)
            {
                if ($templateTabElement->{TemplateTabElement::ELEMENT_TYPE} === Field::class)
                {
                    return [$templateTabElement];
                }
                else
                {
                    return static::getBlockFieldElements($templateTabElement->{TemplateTabElement::RELATION_BLOCK});
                }
            });
    }

    #endregion
}
