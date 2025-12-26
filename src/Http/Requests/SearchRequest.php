<?php

namespace Narsil\Http\Requests;

#region USE

use Illuminate\Foundation\Http\FormRequest;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SearchRequest extends FormRequest
{
    #region CONSTANTS

    /**
     * The name of the "search" parameter.
     *
     * @var string
     */
    final public const SEARCH = 'search';

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return [
            self::SEARCH => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
