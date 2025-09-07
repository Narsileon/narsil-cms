<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\Fortify\TwoFactorChallengeForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class TwoFactorChallengeForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->action = route('two-factor.login');
        $this->description = trans('narsil::ui.two_factor_authentication');
        $this->submitLabel = trans('narsil::ui.confirm');
        $this->title = trans('narsil::ui.two_factor_authentication');
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
                Field::HANDLE => 'code',
                Field::NAME => trans('narsil::validation.attributes.code'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->setAutoComplete(AutoCompleteEnum::ONE_TIME_CODE)
                    ->setIcon('circle-check'),
            ]),
            new Field([
                Field::HANDLE => 'recovery_code',
                Field::NAME => trans('narsil::validation.attributes.recovery_code'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->setAutoComplete(AutoCompleteEnum::ONE_TIME_CODE)
                    ->setIcon('circle-check'),
            ]),
        ];
    }

    #endregion
}
