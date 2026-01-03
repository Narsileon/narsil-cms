<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Contracts\FormRequests\FormFormRequest as Contract;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Implementations\AbstractFormRequest;
use Narsil\Models\Forms\Form;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->form)
        {
            return Gate::allows(PermissionEnum::UPDATE, $this->form);
        }

        return Gate::allows(PermissionEnum::CREATE, Form::class);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
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
                )->ignore($this->form?->{Form::ID}),
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
