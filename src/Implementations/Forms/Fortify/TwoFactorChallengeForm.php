<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\Fortify\TwoFactorChallengeForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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

        $this
            ->setAction(route('two-factor.login'))
            ->setDescription(trans('narsil::ui.two_factor_authentication'))
            ->setSubmitLabel(trans('narsil::ui.confirm'))
            ->setTitle(trans('narsil::ui.two_factor_authentication'));
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function layout(): array
    {
        return [
            new Field([
                Field::HANDLE => 'code',
                Field::NAME => trans('narsil::validation.attributes.code'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->setAutoComplete(AutoCompleteEnum::ONE_TIME_CODE)
                    ->setIcon('circle-check'),
            ]),
            new Field([
                Field::HANDLE => 'recovery_code',
                Field::NAME => trans('narsil::validation.attributes.recovery_code'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->setAutoComplete(AutoCompleteEnum::ONE_TIME_CODE)
                    ->setIcon('circle-check'),
            ]),
        ];
    }

    #endregion
}
