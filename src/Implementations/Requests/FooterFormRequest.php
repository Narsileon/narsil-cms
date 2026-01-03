<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\File;
use Narsil\Contracts\FormRequests\FooterFormRequest as Contract;
use Narsil\Enums\Policies\PermissionEnum;
use Narsil\Implementations\AbstractFormRequest;
use Narsil\Models\Globals\Footer;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->footer)
        {
            return Gate::allows(PermissionEnum::UPDATE, $this->footer);
        }

        return Gate::allows(PermissionEnum::CREATE, Footer::class);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Footer::ADDRESS_LINE_1 => [
                FormRule::STRING,
                FormRule::NULLABLE,
            ],
            Footer::ADDRESS_LINE_2 => [
                FormRule::STRING,
                FormRule::NULLABLE,
            ],
            Footer::COMPANY => [
                FormRule::STRING,
                FormRule::NULLABLE,
            ],
            Footer::EMAIL => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
            ],
            Footer::HANDLE => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Footer::class,
                    Footer::HANDLE,
                )->ignore($this->footer?->{Footer::ID}),
            ],
            Footer::LOGO => [
                File::image()
                    ->dimensions(
                        FormRule::dimensions()
                            ->maxWidth(2048)
                            ->maxHeight(2048)
                    ),
                FormRule::NULLABLE,
            ],
            Footer::PHONE => [
                FormRule::STRING,
                FormRule::NULLABLE,
            ],

            Footer::RELATION_LINKS => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
            ],
            Footer::RELATION_SOCIAL_MEDIA => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
            ],
        ];
    }

    #endregion
}
