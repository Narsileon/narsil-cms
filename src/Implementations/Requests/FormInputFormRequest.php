<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\FormInputFormRequest as Contract;
use Narsil\Models\Forms\FormInput;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormInputFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        return [
            FormInput::HANDLE => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    FormInput::class,
                    FormInput::HANDLE,
                )->ignore($model?->{FormInput::ID}),
            ],
            FormInput::NAME => [
                FormRule::REQUIRED,
            ],
            FormInput::REQUIRED => [
                FormRule::BOOLEAN,
            ],
            FormInput::SETTINGS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
            FormInput::TYPE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],

            FormInput::RELATION_OPTIONS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
            FormInput::RELATION_VALIDATION_RULES => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
        ];
    }

    #endregion
}
