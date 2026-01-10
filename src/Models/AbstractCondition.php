<?php

namespace Narsil\Models;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractCondition extends Model
{
    use HasUuids;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->primaryKey = self::UUID;
        $this->timestamps = false;

        $this->mergeGuarded([
            self::UUID,
        ]);

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
     * The name of the "position" column.
     *
     * @var string
     */
    final public const POSITION = 'position';

    /**
     * The name of the "value" column.
     *
     * @var string
     */
    final public const VALUE = 'value';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #endregion
}
