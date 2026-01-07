<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\Fortify\TwoFactorForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;
use Narsil\Support\TranslationsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TwoFactorForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->action(route('two-factor.confirm'))
            ->method(RequestMethodEnum::POST->value)
            ->submitLabel(trans('narsil::ui.confirm'));

        app(TranslationsBag::class)
            ->add('validation.custom.code.invalid')
            ->add('narsil::two-factor.recovery_codes_copied')
            ->add('narsil::two-factor.recovery_codes_description')
            ->add('narsil::two-factor.recovery_codes_title')
            ->add('narsil::two-factor.two_factor_authentication')
            ->add('narsil::ui.copy_clipboard');
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        return [
            [
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::DESCRIPTION => trans('narsil::two-factor.code_description'),
                        TemplateTabElement::HANDLE => 'code',
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.code'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE->value)
                                ->icon('circle-check'),
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion
}
