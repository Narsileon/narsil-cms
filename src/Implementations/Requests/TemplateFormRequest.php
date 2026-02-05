<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Narsil\Cms\Contracts\FormRequests\TemplateFormRequest as Contract;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Implementations\AbstractFormRequest;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Validation\FormRule;

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
            Template::TABLE_NAME => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Template::class,
                    Template::TABLE_NAME,
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
