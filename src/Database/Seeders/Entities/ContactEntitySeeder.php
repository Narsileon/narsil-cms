<?php

namespace Narsil\Cms\Database\Seeders\Entities;

#region USE

use Narsil\Cms\Database\Seeders\Blocks\FormBlockSeeder;
use Narsil\Cms\Database\Seeders\Blocks\LayoutBlockSeeder;
use Narsil\Cms\Database\Seeders\Blocks\PaddingBlockSeeder;
use Narsil\Cms\Database\Seeders\EntitySeeder;
use Narsil\Cms\Database\Seeders\Forms\ContactFormSeeder;
use Narsil\Cms\Database\Seeders\Templates\ContentTemplateSeeder;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Models\Entities\EntityNode;
use Narsil\Cms\Form\Models\Form;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ContactEntitySeeder extends EntitySeeder
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function data(): array
    {
        return [];

        $formBlock = new FormBlockSeeder()->run();
        $contactForm = new ContactFormSeeder()->run();

        return [
            ContentTemplateSeeder::CONTENT => [[
                EntityNode::BLOCK_ID => $formBlock->{Block::ID},
                EntityNode::RELATION_CHILDREN => [
                    FormBlockSeeder::LAYOUT => [
                        LayoutBlockSeeder::SIZE => 'sm',
                        LayoutBlockSeeder::PADDING => [
                            PaddingBlockSeeder::TOP => 'md',
                            PaddingBlockSeeder::BOTTOM => 'md',
                        ],
                    ],
                    FormBlockSeeder::FORM => $contactForm->{Form::ATTRIBUTE_IDENTIFIER},
                ],
            ]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function entity(): Entity
    {
        $model = $this->template->entityClass();

        return new $model([
            Entity::SLUG => 'contact',
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
