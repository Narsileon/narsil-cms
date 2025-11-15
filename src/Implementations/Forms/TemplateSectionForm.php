<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\TemplateForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;

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
            new Field([
                Field::HANDLE => TemplateSection::NAME,
                Field::NAME => trans('narsil::validation.attributes.name'),
                Field::TRANSLATABLE => true,
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->required(true),
            ]),
            new Field([
                Field::HANDLE => TemplateSection::HANDLE,
                Field::NAME => trans('narsil::validation.attributes.handle'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->required(true),
            ]),
        ];
    }

    #endregion
}
