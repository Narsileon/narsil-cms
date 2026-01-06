<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\SwitchField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\FieldsetElementForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;
use Narsil\Models\Forms\FieldsetElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldsetElementForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        return [
            new Block([
                Block::RELATION_ELEMENTS => [
                    new BlockElement([
                        BlockElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => FieldsetElement::NAME,
                            Field::LABEL => trans('narsil::validation.attributes.name'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new BlockElement([
                        BlockElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => FieldsetElement::HANDLE,
                            Field::LABEL => trans('narsil::validation.attributes.handle'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new BlockElement([
                        BlockElement::RELATION_ELEMENT =>  new Field([
                            Field::HANDLE => FieldsetElement::REQUIRED,
                            Field::LABEL => trans('narsil::validation.attributes.required'),
                            Field::TYPE => SwitchField::class,
                            Field::SETTINGS => app(SwitchField::class),
                        ]),
                    ]),
                ],
            ]),
        ];
    }

    #endregion
}
