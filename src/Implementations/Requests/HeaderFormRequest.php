<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\File;
use Narsil\Cms\Contracts\Requests\HeaderFormRequest as Contract;
use Narsil\Cms\Enums\Policies\PermissionEnum;
use Narsil\Cms\Implementations\AbstractFormRequest;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->header)
        {
            return Gate::allows(PermissionEnum::UPDATE, $this->header);
        }

        return Gate::allows(PermissionEnum::CREATE, Header::class);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Header::SLUG => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Header::class,
                    Header::SLUG,
                )->ignore($this->header?->{Header::ID}),
            ],
            Header::LOGO => [
                File::image()
                    ->dimensions(
                        FormRule::dimensions()
                            ->maxWidth(2048)
                            ->maxHeight(2048)
                    ),
                FormRule::NULLABLE,
            ],
        ];
    }

    #endregion
}
