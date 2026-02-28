<?php

namespace Narsil\Cms\Database\Seeders\Blocks;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Cms\Database\Seeders\Fields\PaddingFieldSeeder;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class PaddingBlockSeeder extends Seeder
{
    #region CONSTANTS

    /**
     * The name of the "bottom" field.
     *
     * @var string
     */
    public const BOTTOM = 'bottom';

    /**
     * The name of the "top" field.
     *
     * @var string
     */
    public const TOP = 'top';

    #endregion

    #region PUBLIC METHODS

    /**
     * @return Block
     */
    public function run(): Block
    {
        if ($block = Block::firstWhere(Block::HANDLE, 'padding'))
        {
            return $block;
        }

        $PaddingFieldSeeder = new PaddingFieldSeeder()->run();

        return Block::factory()
            ->hasAttached(
                $PaddingFieldSeeder,
                [
                    BlockElement::HANDLE => self::TOP,
                    BlockElement::LABEL  => 'Top',
                    BlockElement::POSITION => 0,
                    BlockElement::REQUIRED => true,
                    BlockElement::WIDTH => 50
                ],
                Block::RELATION_FIELDS
            )
            ->hasAttached(
                $PaddingFieldSeeder,
                [
                    BlockElement::HANDLE => self::BOTTOM,
                    BlockElement::LABEL => 'Bottom',
                    BlockElement::POSITION => 1,
                    BlockElement::REQUIRED => true,
                    BlockElement::WIDTH => 50
                ],
                Block::RELATION_FIELDS
            )
            ->create([
                Block::COLLAPSIBLE => true,
                Block::HANDLE => 'padding',
                Block::LABEL => 'Padding',
            ]);
    }

    #endregion
}
