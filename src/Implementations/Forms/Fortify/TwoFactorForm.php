<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\Fortify\TwoFactorForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Support\LabelsBag;

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

        $this->submitLabel = trans('narsil-cms::ui.confirm');
        $this->url = route('two-factor.confirm');

        app(LabelsBag::class)
            ->add('validation.custom.code.invalid')
            ->add('narsil-cms::two-factor.recovery_codes_copied')
            ->add('narsil-cms::two-factor.recovery_codes_description')
            ->add('narsil-cms::two-factor.recovery_codes_title')
            ->add('narsil-cms::two-factor.two_factor_authentication');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function form(): array
    {
        return [
            new Field([
                Field::DESCRIPTION => trans('narsil-cms::two-factor.code_description'),
                Field::HANDLE => 'code',
                Field::NAME => trans('narsil-cms::validation.attributes.code'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE->value)
                    ->required(true),
            ]),
        ];
    }

    #endregion
}
