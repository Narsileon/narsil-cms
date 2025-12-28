<?php

namespace Narsil\Models;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Condition extends Model
{
    use HasUuids;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->primaryKey = self::UUID;

        $this->mergeGuarded([
            self::UUID,
        ]);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'conditions';

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
     * The name of the "owner uuid" column.
     *
     * @var string
     */
    final public const OWNER_UUID = 'owner_uuid';

    /**
     * The name of the "owner type" column.
     *
     * @var string
     */
    final public const OWNER_TYPE = 'owner_type';

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

    #region • RELATIONS

    /**
     * The name of the "owner" relation.
     *
     * @var string
     */
    final public const RELATION_OWNER = 'owner';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated owner.
     *
     * @return MorphTo
     */
    final public function owner(): MorphTo
    {
        return $this
            ->morphTo(
                self::RELATION_OWNER,
                self::OWNER_TYPE,
                self::OWNER_UUID,
            );
    }

    #endregion

    #endregion
}
