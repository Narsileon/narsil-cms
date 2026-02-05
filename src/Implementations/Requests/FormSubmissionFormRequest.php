<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Narsil\Cms\Contracts\FormRequests\FormSubmissionFormRequest as Contract;
use Narsil\Cms\Implementations\AbstractFormRequest;
use Narsil\Cms\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormSubmissionFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            self::STEP => [
                FormRule::INTEGER,
                FormRule::REQUIRED,
            ],
            self::UUID => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
