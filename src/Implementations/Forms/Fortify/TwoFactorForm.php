<?php

namespace Narsil\Cms\Implementations\Forms\Fortify;

#region USE

use Narsil\Cms\Contracts\Fields\TextField;
use Narsil\Cms\Contracts\Forms\Fortify\TwoFactorForm as Contract;
use Narsil\Cms\Enums\Forms\AutoCompleteEnum;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;
use Narsil\Ui\Support\TranslationsBag;

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
                        TemplateTabElement::RELATION_BASE => [
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
