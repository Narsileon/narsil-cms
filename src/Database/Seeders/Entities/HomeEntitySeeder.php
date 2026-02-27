<?php

namespace Narsil\Cms\Database\Seeders\Entities;

#region USE

use Faker\Factory;
use Narsil\Cms\Database\Factories\Blocks\AccordionBlock;
use Narsil\Cms\Database\Factories\Blocks\AccordionItemBlock;
use Narsil\Cms\Database\Factories\Blocks\ButtonBlock;
use Narsil\Cms\Database\Factories\Blocks\CallToActionBlock;
use Narsil\Cms\Database\Factories\Blocks\HeadlineBlock;
use Narsil\Cms\Database\Factories\Blocks\HeroHeaderBlock;
use Narsil\Cms\Database\Factories\Blocks\LayoutBlock;
use Narsil\Cms\Database\Factories\Blocks\LinkBlock;
use Narsil\Cms\Database\Factories\Blocks\PaddingBlock;
use Narsil\Cms\Database\Factories\Templates\ContentTemplate;
use Narsil\Cms\Database\Seeders\EntitySeeder;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Models\Sites\SitePage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HomeEntitySeeder extends EntitySeeder
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function data(): array
    {
        $faker = Factory::create();

        $accordionBlock = AccordionBlock::run();
        $accordionItemBlock = AccordionItemBlock::run();
        $buttonBlock = ButtonBlock::run();
        $callToActionBlock = CallToActionBlock::run();
        $heroHeaderBlock = HeroHeaderBlock::run();

        $contactPage = SitePage::query()
            ->where(SitePage::SLUG . '->en', '=', 'contact')
            ->first();

        return [
            ContentTemplate::CONTENT => [
                [
                    EntityNode::BLOCK_ID => $heroHeaderBlock->{Block::ID},
                    EntityNode::RELATION_CHILDREN => [
                        HeroHeaderBlock::LAYOUT => [
                            LayoutBlock::SIZE => 'lg',
                            LayoutBlock::PADDING => [
                                PaddingBlock::TOP => 'md',
                                PaddingBlock::BOTTOM => 'md',
                            ],
                        ],
                        HeroHeaderBlock::HEADLINE => [
                            HeadlineBlock::TITLE => 'Welcome to Narsil CMS!',
                            HeadlineBlock::LEVEL => 'h1',
                            HeadlineBlock::STYLE => 'h1',
                        ],
                        HeroHeaderBlock::EXCERPT => '<p>' . $faker->sentences(6, true) . '</p>',
                        HeroHeaderBlock::BUTTONS => [[
                            EntityNode::BLOCK_ID => $buttonBlock->{Block::ID},
                            EntityNode::RELATION_CHILDREN => [
                                ButtonBlock::LABEL => 'Get started',
                                ButtonBlock::LINK => [
                                    LinkBlock::TYPE => 'external',
                                    LinkBlock::URL => '/admin',
                                ]
                            ],
                        ]],
                    ],
                ],
                [
                    EntityNode::BLOCK_ID => $accordionBlock->{Block::ID},
                    EntityNode::RELATION_CHILDREN => [
                        AccordionBlock::LAYOUT => [
                            LayoutBlock::SIZE => 'sm',
                            LayoutBlock::PADDING => [
                                PaddingBlock::TOP => 'none',
                                PaddingBlock::BOTTOM => 'md',
                            ],
                        ],
                        AccordionBlock::ITEMS => [
                            [
                                EntityNode::BLOCK_ID => $accordionItemBlock->{Block::ID},
                                EntityNode::RELATION_CHILDREN => [
                                    AccordionItemBlock::TRIGGER => $faker->sentence(6, true),
                                    AccordionItemBlock::CONTENT => $faker->sentences(6, true),
                                ],
                            ],
                            [
                                EntityNode::BLOCK_ID => $accordionItemBlock->{Block::ID},
                                EntityNode::RELATION_CHILDREN => [
                                    AccordionItemBlock::TRIGGER => $faker->sentence(6, true),
                                    AccordionItemBlock::CONTENT => $faker->sentences(6, true),
                                ],
                            ],
                            [
                                EntityNode::BLOCK_ID => $accordionItemBlock->{Block::ID},
                                EntityNode::RELATION_CHILDREN => [
                                    AccordionItemBlock::TRIGGER => $faker->sentence(6, true),
                                    AccordionItemBlock::CONTENT => $faker->sentences(6, true),
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    EntityNode::BLOCK_ID => $callToActionBlock->{Block::ID},
                    EntityNode::RELATION_CHILDREN => [
                        CallToActionBlock::LAYOUT => [
                            LayoutBlock::SIZE => 'sm',
                            LayoutBlock::PADDING => [
                                PaddingBlock::TOP => 'none',
                                PaddingBlock::BOTTOM => 'md',
                            ],
                        ],
                        CallToActionBlock::LABEL => 'Contact us',
                        CallToActionBlock::LINK => [
                            LinkBlock::TYPE => 'internal',
                            LinkBlock::PAGE => $contactPage?->{SitePage::ATTRIBUTE_IDENTIFIER},
                        ]
                    ],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function entity(): Entity
    {
        $model = $this->template->entityClass();

        return new $model([
            Entity::SLUG => 'home',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function template(): Template
    {
        return Template::query()
            ->firstWhere(Template::TABLE_NAME, '=', 'contents');
    }

    #endregion
}
