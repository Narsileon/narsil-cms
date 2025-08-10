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
class QueryRequest extends FormRequest
{
    #region CONSTANTS

    /**
     * @var string The name of the "filter" parameter.
     */
    final public const FILTER = 'filter';
    /**
     * @var string The name of the "search" parameter.
     */
    final public const SEARCH = 'search';
    /**
     * @var string The name of the "sorting" parameter.
     */
    final public const SORTING = 'sorting';

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
                FormRule::SOMETIMES,
                FormRule::NULLABLE,
            ],
        ];
    }

    #endregion
}
