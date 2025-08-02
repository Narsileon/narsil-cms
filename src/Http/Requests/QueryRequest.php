<?php

namespace Narsil\Http\Requests;

#region USE

use Narsil\Contracts\FormRequests\RoleFormRequest as Contract;
use Narsil\Models\Policies\Role;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class QueryRequest implements Contract
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
            Role::NAME => [
                FormRule::STRING,
                FormRule::REQUIRED,
            ],
        ];
    }

    #endregion
}
