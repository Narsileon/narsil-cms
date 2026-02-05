<?php

namespace Narsil\Cms\Database\Seeders\Templates;

#region USE

use Narsil\Cms\Contracts\Fields\BuilderField;
use Narsil\Cms\Database\Seeders\Blocks\AccordionBlockSeeder;
use Narsil\Cms\Database\Seeders\Blocks\CallToActionBlockSeeder;
use Narsil\Cms\Database\Seeders\Blocks\FormBlockSeeder;
use Narsil\Cms\Database\Seeders\Blocks\HeroHeaderBlockSeeder;
use Narsil\Cms\Database\Seeders\TemplateSeeder;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;

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
