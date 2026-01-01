<?php

namespace Narsil\Database\Seeders\Templates\Contents;

#region USE

use Narsil\Database\Seeders\Blocks\FormBlockSeeder;
use Narsil\Database\Seeders\Templates\ContentTemplateSeeder;
use Narsil\Models\Entities\EntityNode;
use Narsil\Models\Structures\Block;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ContactContent
{
    #region PROTECTED METHODS

    /**
     * @return array
     */
    protected function template(): array
    {
        $formBlock = new FormBlockSeeder()->run();

        return [
            ContentTemplateSeeder::CONTENT => [[
                EntityNode::BLOCK_ID => $formBlock->{Block::ID},
                EntityNode::RELATION_CHILDREN => [],
            ]],
        ];
    }

    #endregion
}
