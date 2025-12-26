<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\InputFormRequest as Contract;
use Narsil\Models\Forms\Input;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class InputFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        return [
            Input::HANDLE => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Input::class,
                    Input::HANDLE,
                )->ignore($model?->{Input::ID}),
            ],
            Input::NAME => [
                FormRule::REQUIRED,
            ],
            Input::REQUIRED => [
                FormRule::BOOLEAN,
            ],
            Input::SETTINGS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
            Input::TYPE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],

            Input::RELATION_OPTIONS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
            Input::RELATION_VALIDATION_RULES => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
        ];
    }

    #endregion
}
