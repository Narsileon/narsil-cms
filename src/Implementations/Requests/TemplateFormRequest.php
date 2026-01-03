<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Contracts\FormRequests\TemplateFormRequest as Contract;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Implementations\AbstractFormRequest;
use Narsil\Models\Structures\Template;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->template)
        {
            return Gate::allows(PermissionEnum::UPDATE, $this->template);
        }

        return Gate::allows(PermissionEnum::CREATE, Template::class);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Template::HANDLE => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Template::class,
                    Template::HANDLE,
                )->ignore($this->template?->{Template::ID}),
            ],
            Template::PLURAL => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],
            Template::SINGULAR => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],

            Template::RELATION_TABS => [
                FormRule::ARRAY,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
        ];
    }

    #endregion
}
