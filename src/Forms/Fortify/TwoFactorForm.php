<?php

namespace Narsil\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\Text\TextField;
use Narsil\Contracts\Forms\Fortify\TwoFactorForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Forms\AbstractForm;
use Narsil\Models\Fields\Field;
use Narsil\Support\LabelsBag;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TwoFactorForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function fields(): array
    {
        return [
            [
                Field::DESCRIPTION => trans('two-factor.code_description'),
                Field::HANDLE => 'code',
                Field::NAME => trans('narsil-cms::validation.attributes.code'),
                Field::SETTINGS => app(TextField::class)
                    ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE->value)
                    ->className('col-span-1')
                    ->required(true)
                    ->toArray(),
            ],
        ];
    }

    /**
     * @return void
     */
    protected function registerLabels(): void
    {
        parent::registerLabels();

        app(LabelsBag::class)
            ->add('validation.custom.code.invalid')
            ->add('narsil-cms::two-factor.recovery_codes_copied')
            ->add('narsil-cms::two-factor.recovery_codes_description')
            ->add('narsil-cms::two-factor.recovery_codes_title')
            ->add('narsil-cms::two-factor.two_factor_authentication');
    }

    #endregion
}
