<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\SwitchField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\TemplateForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;

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
                            Field::HANDLE => TemplateSection::NAME,
                            Field::NAME => trans('narsil::validation.attributes.name'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new BlockElement([
                        BlockElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => TemplateSection::HANDLE,
                            Field::NAME => trans('narsil::validation.attributes.handle'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new BlockElement([
                        BlockElement::WIDTH => 50,
                        BlockElement::RELATION_ELEMENT =>  new Field([
                            Field::HANDLE => TemplateSectionElement::REQUIRED,
                            Field::NAME => trans('narsil::validation.attributes.required'),
                            Field::TYPE => SwitchField::class,
                            Field::SETTINGS => app(SwitchField::class),
                        ]),
                    ]),
                    new BlockElement([
                        BlockElement::WIDTH => 50,
                        BlockElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => TemplateSectionElement::TRANSLATABLE,
                            Field::NAME => trans('narsil::validation.attributes.translatable'),
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
