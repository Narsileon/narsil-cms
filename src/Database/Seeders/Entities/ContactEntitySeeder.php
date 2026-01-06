<?php

namespace Narsil\Database\Seeders\Entities;

#region USE

use Narsil\Database\Seeders\Blocks\FormBlockSeeder;
use Narsil\Database\Seeders\EntitySeeder;
use Narsil\Database\Seeders\Forms\ContactFormSeeder;
use Narsil\Database\Seeders\Templates\ContentTemplateSeeder;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Entities\EntityNode;
use Narsil\Models\Forms\Form;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Template;

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
        $formBlock = new FormBlockSeeder()->run();
        $contactForm = new ContactFormSeeder()->run();

        return [
            ContentTemplateSeeder::CONTENT => [[
                EntityNode::BLOCK_ID => $formBlock->{Block::ID},
                EntityNode::RELATION_CHILDREN => [
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
