<?php

namespace Narsil\Cms\Database\Seeders\Blocks;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Cms\Database\Seeders\Fields\RichTextFieldSeeder;
use Narsil\Cms\Http\Data\Forms\Inputs\BuilderInputData;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
final class HeroHeaderBlockSeeder extends Seeder
{
    #region CONSTANTS

    /**
     * The name of the "buttons" field.
     *
     * @var string
     */
    public const BUTTONS = 'buttons';

    /**
     * The name of the "excerpt" field.
     *
     * @var string
     */
    public const EXCERPT = 'excerpt';

    /**
     * The name of the "headline" block.
     *
     * @var string
     */
    public const HEADLINE = 'headline';

    /**
     * The name of the "layout" block.
     *
     * @var string
     */
    public const LAYOUT = 'layout';

    #endregion

    #region PUBLIC METHODS

    /**
     * @return Block
     */
    public function run(): Block
    {
        if ($block = Block::firstWhere(Block::HANDLE, 'hero_header'))
        {
            return $block;
        }

        $ButtonBlockSeeder = new ButtonBlockSeeder()->run();
        $HeadlineBlockSeeder = new HeadlineBlockSeeder()->run();
        $LayoutBlockSeeder = new LayoutBlockSeeder()->run();
        $RichTextFieldSeeder = new RichTextFieldSeeder()->run();

        return Block::factory()
            ->hasAttached(
                $LayoutBlockSeeder,
                [
                    BlockElement::HANDLE => self::LAYOUT,
                    BlockElement::LABEL => 'Layout',
                    BlockElement::POSITION => 0,
                ],
                Block::RELATION_BLOCKS
            )
            ->hasAttached(
                $HeadlineBlockSeeder,
                [
                    BlockElement::HANDLE => self::HEADLINE,
                    BlockElement::LABEL => 'Headline',
                    BlockElement::POSITION => 1,
                ],
                Block::RELATION_BLOCKS
            )
            ->hasAttached(
                $RichTextFieldSeeder,
                [
                    BlockElement::HANDLE => self::EXCERPT,
                    BlockElement::LABEL  => 'Excerpt',
                    BlockElement::POSITION => 2,
                    BlockElement::REQUIRED => true,
                    BlockElement::TRANSLATABLE => true,
                ],
                Block::RELATION_FIELDS
            )
            ->hasAttached(
                Field::factory()->state([
                    Field::HANDLE => 'hero_header_builder',
                    Field::LABEL => 'Hero Header Builder',
                    Field::TYPE => BuilderInputData::TYPE,
                ])->hasAttached(
                    $ButtonBlockSeeder,
                    [],
                    Field::RELATION_BLOCKS
                ),
                [
                    BlockElement::HANDLE => 'buttons',
                    BlockElement::LABEL  => 'Buttons',
                    BlockElement::POSITION => 3,
                ],
                Block::RELATION_FIELDS
            )
            ->create([
                Block::HANDLE => 'hero_header',
                Block::LABEL => 'Hero Header',
            ]);
    }

    #endregion
}
