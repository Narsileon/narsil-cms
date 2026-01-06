<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\Fortify\TwoFactorChallengeForm as Contract;
use Narsil\Enums\Forms\AutoCompleteEnum;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;

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
            ->action(route('two-factor.login'))
            ->method(RequestMethodEnum::POST->value)
            ->submitLabel(trans('narsil::ui.confirm'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        return [
            new Field([
                Field::HANDLE => 'code',
                Field::LABEL => trans('narsil::validation.attributes.code'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE->value)
                    ->icon('circle-check'),
            ]),
            new Field([
                Field::HANDLE => 'recovery_code',
                Field::LABEL => trans('narsil::validation.attributes.recovery_code'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE->value)
                    ->icon('circle-check'),
            ]),
        ];
    }

    #endregion
}
