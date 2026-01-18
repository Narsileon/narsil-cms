<?php

namespace Narsil\Contracts\FormRequests;

#region USE

use Narsil\Contracts\FormRequest;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @see vendor/narsil/cms/config/narsil/bindings/form-requests.php
 */
interface FormSubmitFormRequest extends FormRequest
{
    #region CONSTANTS

    /**
     * @var string
     */
    public const STEP = '_step';

    #endregion
}
