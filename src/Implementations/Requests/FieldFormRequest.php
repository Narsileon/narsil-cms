<?php

declare(strict_types=1);

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Implementations\FormRequest;
use Narsil\Base\Validation\FormRule;
use Narsil\Cms\Contracts\Requests\FieldFormRequest as Contract;
use Narsil\Cms\Models\Collections\Field;

#endregion

class FieldFormRequest extends FormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->field)
        {
            return Gate::allows(AbilityEnum::UPDATE, $this->field);
        }

        return Gate::allows(AbilityEnum::CREATE, Field::class);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Field::DESCRIPTION => [
                FormRule::LIST,
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
                FormRule::LIST,
                FormRule::REQUIRED,
            ],
            Field::DESCRIPTION => [
                FormRule::LIST,
                FormRule::NULLABLE,
            ],
            Field::PLACEHOLDER => [
                FormRule::LIST,
                FormRule::NULLABLE,
            ],
            Field::SETTINGS => [
                FormRule::LIST,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
            Field::TYPE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],

            Field::RELATION_BLOCKS => [
                FormRule::LIST,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
            Field::RELATION_OPTIONS => [
                FormRule::LIST,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
            Field::RELATION_VALIDATION_RULES => [
                FormRule::LIST,
                FormRule::NULLABLE,
                FormRule::SOMETIMES,
            ],
        ];
    }

    #endregion
}
