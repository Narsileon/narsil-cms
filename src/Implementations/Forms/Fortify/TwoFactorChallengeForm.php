<?php

namespace Narsil\Implementations\Forms\Fortify;

#region USE

use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\Fortify\TwoFactorChallengeForm as Contract;
use Narsil\Enums\Fields\AutoCompleteEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;

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
    public function elements(): array
    {
        return [
            new Field([
                Field::HANDLE => 'code',
                Field::NAME => trans('narsil-cms::validation.attributes.code'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE->value),
            ]),
            new Field([
                Field::HANDLE => 'recovery_code',
                Field::NAME => trans('narsil-cms::validation.attributes.recovery_code'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE->value),
            ]),
        ];
    }

    #endregion
}
