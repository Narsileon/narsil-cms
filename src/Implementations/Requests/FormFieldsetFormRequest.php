<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\FormFieldsetFormRequest as Contract;
use Narsil\Models\Forms\FormFieldset;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormFieldsetFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        return [
            FormFieldset::HANDLE => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    FormFieldset::class,
                    FormFieldset::HANDLE,
                )->ignore($model?->{FormFieldset::ID}),

            ],
            FormFieldset::NAME => [
                FormRule::REQUIRED,
            ],

            FormFieldset::RELATION_ELEMENTS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
        ];
    }

    #endregion
}
