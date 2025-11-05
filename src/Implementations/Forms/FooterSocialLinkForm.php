<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\FooterSocialLinkForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Globals\FooterSocialLink;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterSocialLinkForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        return [
            new Field([
                Field::HANDLE => FooterSocialLink::LABEL,
                Field::NAME => trans('narsil::validation.attributes.label'),
                Field::TRANSLATABLE => true,
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->required(true),
            ]),
            new Field([
                Field::HANDLE => FooterSocialLink::URL,
                Field::NAME => trans('narsil::validation.attributes.url'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->required(true),
            ]),
        ];
    }

    #endregion
}
