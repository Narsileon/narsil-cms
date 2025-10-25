<?php

namespace Narsil\Http\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\FieldFormRequest as Contract;
use Narsil\Models\Elements\Field;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
    {
        return [
            Field::HANDLE => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Field::class,
                    Field::HANDLE,
                )->ignore($model?->{Field::ID}),
            ],
            Field::NAME => [
                FormRule::REQUIRED,
            ],
            Field::SETTINGS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
            Field::TRANSLATABLE => [
                FormRule::BOOLEAN,
            ],
            Field::TYPE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],

            Field::RELATION_OPTIONS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
            Field::RELATION_RULES => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
        ];
    }

    #endregion
}
