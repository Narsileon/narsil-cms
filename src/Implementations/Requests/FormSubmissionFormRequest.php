<?php

namespace Narsil\Implementations\Requests;

#region USE

use Narsil\Contracts\FormRequests\FormSubmissionFormRequest as Contract;
use Narsil\Implementations\AbstractFormRequest;
use Narsil\Validation\FormRule;

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
