<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Narsil\Cms\Contracts\Requests\ConfigurationFormRequest as Contract;
use Narsil\Cms\Implementations\AbstractFormRequest;
use Narsil\Cms\Models\Configuration;
use Narsil\Cms\Validation\FormRule;

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
