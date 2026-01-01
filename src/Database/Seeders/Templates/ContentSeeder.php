<?php

namespace Narsil\Database\Seeders\Templates;

#region USE

use Narsil\Contracts\Fields\BuilderField;
use Narsil\Database\Seeders\Blocks\AccordionBlockSeeder;
use Narsil\Database\Seeders\Blocks\FormBlockSeeder;
use Narsil\Database\Seeders\Blocks\HeroHeaderBlockSeeder;
use Narsil\Database\Seeders\TemplateSeeder;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\Template;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ContentSeeder extends TemplateSeeder
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function template(): Template
    {
        $accordionBlock = new AccordionBlockSeeder()->run();
        $formBlock = new FormBlockSeeder()->run();
        $heroHeaderBlock = new HeroHeaderBlockSeeder()->run();

        return new Template([
            Template::HANDLE => 'contents',
            Template::PLURAL => 'contents',
            Template::SINGULAR => 'content',
            Template::RELATION_TABS => [
                new TemplateTab([
                    TemplateTab::HANDLE => 'content',
                    TemplateTab::NAME => 'content',
                    TemplateTab::RELATION_ELEMENTS => [
                        new TemplateTabElement([
                            TemplateTabElement::RELATION_ELEMENT => new Field([
                                Field::HANDLE => 'content',
                                Field::NAME => 'content',
                                Field::TYPE => BuilderField::class,
                                Field::RELATION_BLOCKS => [
                                    $accordionBlock,
                                    $formBlock,
                                    $heroHeaderBlock,
                                ]
                            ]),
                        ]),
                    ]
                ]),
            ],
        ]);
    }

    #endregion
}
