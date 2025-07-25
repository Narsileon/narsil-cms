<?php

namespace Narsil\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\Text\TextField;
use Narsil\Contracts\Forms\Fortify\TwoFactorChallengeForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Forms\AbstractForm;
use Narsil\Models\Fields\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TwoFactorChallengeForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function content(): array
    {
        return [
            new Field([
                Field::HANDLE => 'code',
                Field::NAME => trans('narsil-cms::validation.attributes.code'),
                Field::SETTINGS => app(TextField::class)
                    ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE->value)
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => 'recovery_code',
                Field::NAME => trans('narsil-cms::validation.attributes.recovery_code'),
                Field::SETTINGS => app(TextField::class)
                    ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE->value)
                    ->toArray(),
            ]),
        ];
    }

    #endregion
}
