<?php

namespace Narsil\Database\Seeders\Entities;

#region USE

use Faker\Factory;
use Narsil\Database\Seeders\Blocks\AccordionBlockSeeder;
use Narsil\Database\Seeders\Blocks\AccordionItemBlockSeeder;
use Narsil\Database\Seeders\Blocks\ButtonBlockSeeder;
use Narsil\Database\Seeders\Blocks\CallToActionBlockSeeder;
use Narsil\Database\Seeders\Blocks\HeadlineBlockSeeder;
use Narsil\Database\Seeders\Blocks\HeroHeaderBlockSeeder;
use Narsil\Database\Seeders\Blocks\LayoutBlockSeeder;
use Narsil\Database\Seeders\Blocks\LinkBlockSeeder;
use Narsil\Database\Seeders\Blocks\PaddingBlockSeeder;
use Narsil\Database\Seeders\EntitySeeder;
use Narsil\Database\Seeders\Templates\ContentTemplateSeeder;
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityNode;
use Narsil\Models\Sites\SitePage;

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

        $accordionBlock = new AccordionBlockSeeder()->run();
        $accordionItemBlock = new AccordionItemBlockSeeder()->run();
        $buttonBlock = new ButtonBlockSeeder()->run();
        $callToActionBlock = new CallToActionBlockSeeder()->run();
        $heroHeaderBlock = new HeroHeaderBlockSeeder()->run();

        $contactPage = SitePage::query()
            ->where(SitePage::SLUG . '->en', '=', 'contact')
            ->first();

        return [
            ContentTemplateSeeder::CONTENT => [
                [
                    EntityNode::BLOCK_ID => $heroHeaderBlock->{Block::ID},
                    EntityNode::RELATION_CHILDREN => [
                        HeroHeaderBlockSeeder::LAYOUT => [
                            LayoutBlockSeeder::SIZE => 'lg',
                            LayoutBlockSeeder::PADDING => [
                                PaddingBlockSeeder::TOP => 'md',
                                PaddingBlockSeeder::BOTTOM => 'md',
                            ],
                        ],
                        HeroHeaderBlockSeeder::HEADLINE => [
                            HeadlineBlockSeeder::HEADLINE => 'Welcome to Narsil CMS!',
                            HeadlineBlockSeeder::HEADLINE_LEVEL => 'h1',
                            HeadlineBlockSeeder::HEADLINE_STYLE => 'h1',
                        ],
                        HeroHeaderBlockSeeder::EXCERPT => '<p>' . $faker->sentences(6, true) . '</p>',
                        HeroHeaderBlockSeeder::BUTTONS => [[
                            EntityNode::BLOCK_ID => $buttonBlock->{Block::ID},
                            EntityNode::RELATION_CHILDREN => [
                                ButtonBlockSeeder::LABEL => 'Get started',
                                ButtonBlockSeeder::LINK => [
                                    LinkBlockSeeder::TYPE => 'external',
                                    LinkBlockSeeder::URL => '/narsil',
                                ]
                            ],
                        ]],
                    ],
                ],
                [
                    EntityNode::BLOCK_ID => $accordionBlock->{Block::ID},
                    EntityNode::RELATION_CHILDREN => [
                        AccordionBlockSeeder::LAYOUT => [
                            LayoutBlockSeeder::SIZE => 'sm',
                            LayoutBlockSeeder::PADDING => [
                                PaddingBlockSeeder::TOP => 'none',
                                PaddingBlockSeeder::BOTTOM => 'md',
                            ],
                        ],
                        AccordionBlockSeeder::ACCORDION_BUILDER => [
                            [
                                EntityNode::BLOCK_ID => $accordionItemBlock->{Block::ID},
                                EntityNode::RELATION_CHILDREN => [
                                    AccordionItemBlockSeeder::ACCORDION_ITEM_TRIGGER => $faker->sentence(6, true),
                                    AccordionItemBlockSeeder::ACCORDION_ITEM_CONTENT => $faker->sentences(6, true),
                                ],
                            ],
                            [
                                EntityNode::BLOCK_ID => $accordionItemBlock->{Block::ID},
                                EntityNode::RELATION_CHILDREN => [
                                    AccordionItemBlockSeeder::ACCORDION_ITEM_TRIGGER => $faker->sentence(6, true),
                                    AccordionItemBlockSeeder::ACCORDION_ITEM_CONTENT => $faker->sentences(6, true),
                                ],
                            ],
                            [
                                EntityNode::BLOCK_ID => $accordionItemBlock->{Block::ID},
                                EntityNode::RELATION_CHILDREN => [
                                    AccordionItemBlockSeeder::ACCORDION_ITEM_TRIGGER => $faker->sentence(6, true),
                                    AccordionItemBlockSeeder::ACCORDION_ITEM_CONTENT => $faker->sentences(6, true),
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    EntityNode::BLOCK_ID => $callToActionBlock->{Block::ID},
                    EntityNode::RELATION_CHILDREN => [
                        CallToActionBlockSeeder::LAYOUT => [
                            LayoutBlockSeeder::SIZE => 'sm',
                            LayoutBlockSeeder::PADDING => [
                                PaddingBlockSeeder::TOP => 'none',
                                PaddingBlockSeeder::BOTTOM => 'md',
                            ],
                        ],
                        CallToActionBlockSeeder::LABEL => 'Contact us',
                        CallToActionBlockSeeder::LINK => [
                            LinkBlockSeeder::TYPE => 'internal',
                            LinkBlockSeeder::LINK => $contactPage?->{SitePage::ATTRIBUTE_IDENTIFIER},
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
