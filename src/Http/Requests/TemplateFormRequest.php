<?php

namespace Narsil\Http\Requests;

#region USE

use Narsil\Contracts\FormRequests\TemplateFormRequest as Contract;
use Narsil\Models\Templates\Template;
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
    public function rules(): array
    {
        return [
            Template::HANDLE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
            Template::NAME => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
