<?php

namespace Narsil\Cms\Database\Factories\Templates;

#region USE

use Narsil\Cms\Database\Factories\Blocks\AccordionBlock;
use Narsil\Cms\Database\Factories\Blocks\CallToActionBlock;
use Narsil\Cms\Database\Factories\Blocks\HeroHeaderBlock;
use Narsil\Cms\Http\Data\Forms\Inputs\BuilderInputData;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class ContentTemplate
{
    #region CONSTANTS

    /**
     * The name of the "content" field.
     *
     * @var string
     */
    public const CONTENT = 'content';

    #endregion


    #region PUBLIC METHODS

    /**
     * @return Template
     */
    public static function run(): Template
    {
        if ($field = Template::firstWhere(Template::TABLE_NAME, 'content'))
        {
            return $field;
        }

        $accordionBlock = AccordionBlock::run();
        $callToActionBlock = CallToActionBlock::run();
        $heroHeaderBlock = HeroHeaderBlock::run();

        return Template::factory()
            ->has(
                TemplateTab::factory()->state([
                    TemplateTab::HANDLE => 'content',
                    TemplateTab::LABEL => 'content',
                ])->hasAttached(
                    Field::factory()->state([
                        Field::HANDLE => 'content_builder',
                        Field::LABEL => 'Content Builder',
                        Field::TYPE => BuilderInputData::TYPE,
                    ])->hasAttached(
                        $accordionBlock,
                        [],
                        Field::RELATION_BLOCKS
                    )->hasAttached(
                        $callToActionBlock,
                        [],
                        Field::RELATION_BLOCKS
                    )->hasAttached(
                        $heroHeaderBlock,
                        [],
                        Field::RELATION_BLOCKS
                    ),
                    [
                        TemplateTabElement::HANDLE => self::CONTENT,
                        TemplateTabElement::LABEL  => 'Content',
                        TemplateTabElement::POSITION => 1,
                    ],
                    TemplateTab::RELATION_FIELDS
                ),
                Template::RELATION_TABS
            )
            ->create([
                Template::PLURAL => 'Contents',
                Template::SINGULAR => 'Content',
                Template::TABLE_NAME => 'contents',
            ]);
    }

    #endregion
}
