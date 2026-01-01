<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\FormFormRequest as Contract;
use Narsil\Models\Forms\Form;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        return [
            Form::DESCRIPTION => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],
            Form::SLUG => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Form::class,
                    Form::SLUG,
                )->ignore($model?->{Form::ID}),
            ],
            Form::TITLE => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],

            Form::RELATION_TABS => [
                FormRule::ARRAY,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
        ];
    }

    #endregion
}
