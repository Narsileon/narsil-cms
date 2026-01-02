<?php

namespace Narsil\Database\Seeders\Entities;

#region USE

use Narsil\Database\Seeders\Blocks\HeadlineBlockSeeder;
use Narsil\Database\Seeders\Blocks\HeroHeaderBlockSeeder;
use Narsil\Database\Seeders\EntitySeeder;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Structures\Template;
use Narsil\Services\CollectionService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HomeContentSeeder extends EntitySeeder
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function data(): array
    {
        return [
            HeroHeaderBlockSeeder::HERO_HEADER => [
                HeadlineBlockSeeder::HEADLINE => [
                    HeadlineBlockSeeder::HEADLINE => 'Welcome to Narsil CMS!',
                    HeadlineBlockSeeder::HEADLINE_LEVEL => 'h1',
                    HeadlineBlockSeeder::HEADLINE_STYLE => 'h1',
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function entity(): Entity
    {
        return new Entity([
            Entity::SLUG => 'home',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function template(): Template
    {
        return CollectionService::getTemplate('contents');
    }

    #endregion
}
