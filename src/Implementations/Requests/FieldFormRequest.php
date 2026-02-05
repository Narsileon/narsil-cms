<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Cms\Contracts\FormRequests\FieldFormRequest as Contract;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Implementations\AbstractFormRequest;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->field)
        {
            return Gate::allows(PermissionEnum::UPDATE, $this->field);
        }

        return Gate::allows(PermissionEnum::CREATE, Field::class);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Field::DESCRIPTION => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
            ],
            Field::HANDLE => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Field::class,
                    Field::HANDLE,
                )->ignore($this->field?->{Field::ID}),
            ],
            Field::LABEL => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],
            Field::DESCRIPTION => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
            ],
            Field::PLACEHOLDER => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
            ],
            Field::SETTINGS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
            Field::TYPE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],

            Field::RELATION_BLOCKS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
            Field::RELATION_OPTIONS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
            Field::RELATION_VALIDATION_RULES => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
        ];
    }

    #endregion
}
