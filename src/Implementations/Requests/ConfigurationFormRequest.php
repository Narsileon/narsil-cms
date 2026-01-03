<?php

namespace Narsil\Implementations\Requests;

#region USE

use Narsil\Contracts\FormRequests\ConfigurationFormRequest as Contract;
use Narsil\Implementations\AbstractFormRequest;
use Narsil\Models\Configuration;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConfigurationFormRequest extends AbstractFormRequest implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            Configuration::DEFAULT_LANGUAGE => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
