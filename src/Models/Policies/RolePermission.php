<?php

namespace Narsil\Models\Policies;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RolePermission extends Pivot
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
        $this->timestamps = false;

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
    final public const TABLE = 'role_permission';

    #region • COLUMNS

    /**
     * The name of the "permission id" column.
     *
     * @var string
     */
    final public const PERMISSION_ID = 'permission_id';

    /**
     * The name of the "role id" column.
     *
     * @var string
     */
    final public const ROLE_ID = 'role_id';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "permission" relation.
     *
     * @var string
     */
    final public const RELATION_PERMISSION = 'permission';

    /**
     * The name of the "role" relation.
     *
     * @var string
     */
    final public const RELATION_ROLE = 'role';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated permission.
     *
     * @return BelongsTo
     */
    final public function permission(): BelongsTo
    {
        return $this
            ->belongsTo(
                Permission::class,
                self::PERMISSION_ID,
                Permission::ID,
            );
    }

    /**
     * Get the associated role.
     *
     * @return BelongsTo
     */
    final public function role(): BelongsTo
    {
        return $this
            ->belongsTo(
                Role::class,
                self::ROLE_ID,
                Role::ID,
            );
    }

    #endregion

    #endregion
}
