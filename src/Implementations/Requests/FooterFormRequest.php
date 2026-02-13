<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\File;
use Narsil\Base\Enums\AbilityEnum;
use Narsil\Base\Implementations\FormRequest;
use Narsil\Base\Validation\FormRule;
use Narsil\Cms\Contracts\Requests\FooterFormRequest as Contract;
use Narsil\Cms\Models\Globals\Footer;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterFormRequest extends FormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function authorize(): bool
    {
        if ($this->footer)
        {
            return Gate::allows(AbilityEnum::UPDATE, $this->footer);
        }

        return Gate::allows(AbilityEnum::CREATE, Footer::class);
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Footer::CITY => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
            ],
            Footer::COPYRIGHT => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
            ],
            Footer::COUNTRY => [
                FormRule::STRING,
                FormRule::NULLABLE,
            ],
            Footer::EMAIL => [
                FormRule::ARRAY,
                FormRule::NULLABLE,
            ],
            Footer::ORGANIZATION => [
                FormRule::STRING,
                FormRule::NULLABLE,
            ],
            Footer::ORGANIZATION_SCHEMA => [
                FormRule::BOOLEAN,
            ],
            Footer::POSTAL_CODE => [
                FormRule::STRING,
                FormRule::NULLABLE,
            ],
            Footer::SLUG => [
                FormRule::ALPHA_DASH,
                FormRule::LOWERCASE,
                FormRule::doesntStartWith('-'),
                FormRule::doesntEndWith('-'),
                FormRule::REQUIRED,
                FormRule::unique(
                    Footer::class,
                    Footer::SLUG,
                )->ignore($this->footer?->{Footer::ID}),
            ],
            Footer::STREET => [
                FormRule::STRING,
                FormRule::NULLABLE,
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
