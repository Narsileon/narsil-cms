<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\FooterLegalLinkForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Globals\FooterLegalLink;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterLegalLinkForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        return [
            new Field([
                Field::HANDLE => FooterLegalLink::LABEL,
                Field::NAME => trans('narsil::validation.attributes.label'),
                Field::TRANSLATABLE => true,
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->required(true),
            ]),
        ];
    }

    #endregion
}
