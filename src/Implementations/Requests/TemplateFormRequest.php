<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\TemplateFormRequest as Contract;
use Narsil\Models\Elements\Template;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(?Model $model = null): array
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
                )->ignore($model?->{Template::ID}),
            ],
            Template::PLURAL => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],
            Template::SINGULAR => [
                FormRule::ARRAY,
                FormRule::REQUIRED,
            ],

            Template::RELATION_SECTIONS => [
                FormRule::ARRAY,
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
        ];
    }

    #endregion
}
