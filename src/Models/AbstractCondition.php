<?php

namespace Narsil\Cms\Models;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Traits\HasUuidKey;
use Narsil\Cms\Traits\IsOrderable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractCondition extends Model
{
    use HasUuidKey;
    use IsOrderable;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->timestamps = false;

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    #region • COLUMNS

    /**
     * The name of the "handle" column.
     *
     * @var string
     */
    final public const HANDLE = 'handle';

    /**
     * The name of the "operator" column.
     *
     * @var string
     */
    final public const OPERATOR = 'operator';

    /**
     * The name of the "value" column.
     *
     * @var string
     */
    final public const VALUE = 'value';

    #endregion

    #endregion
}
