<?php

namespace Narsil\Http\Requests;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\FormRequests\TemplateFormRequest as Contract;
use Narsil\Models\Elements\Template;
use Narsil\Validation\FormRule;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Template::NAME => [
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
