<?php

namespace Narsil\Database\Seeders\Blocks;

#region USE

use Narsil\Contracts\Fields\FormField;
use Narsil\Database\Seeders\BlockSeeder;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormBlockSeeder extends BlockSeeder
{
    #region CONSTANTS

    /**
     * The name of the "form" handle
     *
     * @var string
     */
    const FORM = 'form';

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function block(): Block
    {
        return new Block([
            Block::HANDLE => self::FORM,
            Block::NAME => 'Form',
            Block::RELATION_ELEMENTS => [
                new BlockElement([
                    BlockElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => self::FORM,
                        Field::NAME => 'Form',
                        Field::TYPE => FormField::class,
                    ]),
                ]),
            ],
        ]);
    }

    #endregion
}
