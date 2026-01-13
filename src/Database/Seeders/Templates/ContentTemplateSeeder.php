<?php

namespace Narsil\Database\Seeders\Templates;

#region USE

use Narsil\Contracts\Fields\BuilderField;
use Narsil\Database\Seeders\Blocks\AccordionBlockSeeder;
use Narsil\Database\Seeders\Blocks\CallToActionBlockSeeder;
use Narsil\Database\Seeders\Blocks\FormBlockSeeder;
use Narsil\Database\Seeders\Blocks\HeroHeaderBlockSeeder;
use Narsil\Database\Seeders\TemplateSeeder;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\Template;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\Collections\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ContentTemplateSeeder extends TemplateSeeder
{
    #region CONSTANTS

    /**
     * The name of the "content" handle
     *
     * @var string
     */
    const CONTENT = 'content';

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function template(): Template
    {
        $accordionBlock = new AccordionBlockSeeder()->run();
        $callToActionBlock = new CallToActionBlockSeeder()->run();
        $formBlock = new FormBlockSeeder()->run();
        $heroHeaderBlock = new HeroHeaderBlockSeeder()->run();

        return new Template([
            Template::TABLE_NAME => 'contents',
            Template::PLURAL => 'contents',
            Template::SINGULAR => 'content',
        ])->setRelation(
            Template::RELATION_TABS,
            [
                new TemplateTab([
                    TemplateTab::HANDLE => 'content',
                    TemplateTab::LABEL => 'content',
                ])->setRelation(
                    TemplateTab::RELATION_ELEMENTS,
                    [
                        new TemplateTabElement([
                            TemplateTabElement::HANDLE => self::CONTENT,
                            TemplateTabElement::LABEL => 'content',
                        ])->setRelation(
                            TemplateTabElement::RELATION_BASE,
                            new Field([
                                Field::TYPE => BuilderField::class,
                            ])->setRelation(
                                Field::RELATION_BLOCKS,
                                [
                                    $accordionBlock,
                                    $callToActionBlock,
                                    $formBlock,
                                    $heroHeaderBlock,
                                ],
                            ),
                        ),
                    ],
                ),
            ],
        );
    }

    #endregion
}
