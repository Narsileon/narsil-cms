<?php

namespace Narsil\Http\Requests;

#region USE

use Illuminate\Foundation\Http\FormRequest;
use Narsil\Validation\FormRule;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class QueryRequest extends FormRequest
{
    #region CONSTANTS

    /**
     * The name of the "filter" parameter.
     *
     * @var string
     */
    final public const FILTER = 'filter';

    /**
     * The name of the "filters" parameter.
     *
     * @var string
     */
    final public const FILTERS = 'filters';

    /**
     * The name of the "search" parameter.
     *
     * @var string
     */
    final public const SEARCH = 'search';

    /**
     * The name of the "sorting" parameter.
     *
     * @var string
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
