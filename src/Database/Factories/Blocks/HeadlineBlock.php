<?php

namespace Narsil\Cms\Database\Factories\Blocks;

#region USE

use Narsil\Cms\Database\Factories\Fields\HeadlineField;
use Narsil\Cms\Database\Factories\Fields\TitleField;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class HeadlineBlock
{
        #region CONSTANTS

    /**
     * The name of the "level" field.
     *
     * @var string
     */
    public const LEVEL = 'level';

    /**
     * The name of the "style" block.
     *
     * @var string
     */
    public const STYLE = 'style';

    /**
     * The name of the "title" field.
     *
     * @var string
     */
    public const TITLE = 'title';

    #endregion

    #region PUBLIC METHODS

    /**
     * @return Block
     */
    public static function run(): Block
    {
        if ($block = Block::firstWhere(Block::HANDLE, 'headline'))
        {
            return $block;
        }

        $headlineField = HeadlineField::run();
        $titleField = TitleField::run();

        return Block::factory()
            ->hasAttached(
                $titleField,
                [
                    BlockElement::HANDLE => self::TITLE,
                    BlockElement::LABEL => 'Title',
                    BlockElement::POSITION => 0,
                    BlockElement::REQUIRED => true,
                    BlockElement::TRANSLATABLE => true,
                ],
                Block::RELATION_FIELDS
            )
            ->hasAttached(
                $headlineField,
                [
                    BlockElement::HANDLE => self::LEVEL,
                    BlockElement::LABEL  => 'Level',
                    BlockElement::POSITION => 1,
                    BlockElement::REQUIRED => true,
                    BlockElement::WIDTH => 50
                ],
                Block::RELATION_FIELDS
            )
            ->hasAttached(
                $headlineField,
                [
                    BlockElement::HANDLE => self::STYLE,
                    BlockElement::LABEL => 'Style',
                    BlockElement::POSITION => 2,
                    BlockElement::REQUIRED => true,
                    BlockElement::WIDTH => 50
                ],
                Block::RELATION_FIELDS
            )
            ->create([
                Block::COLLAPSIBLE => true,
                Block::HANDLE => 'headline',
                Block::LABEL => 'Headline',
            ]);
    }

    #endregion
}
