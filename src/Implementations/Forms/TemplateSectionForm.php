<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\TemplateForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateSectionElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateSectionForm extends AbstractForm implements Contract
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
                            Field::HANDLE => TemplateSectionElement::NAME,
                            Field::NAME => trans('narsil::validation.attributes.name'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new BlockElement([
                        BlockElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => TemplateSectionElement::HANDLE,
                            Field::NAME => trans('narsil::validation.attributes.handle'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                ],
            ]),
        ];
    }

    #endregion
}
