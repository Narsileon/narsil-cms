<?php

namespace Narsil\Models\Policies;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class RolePermission extends Pivot
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->incrementing = true;

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

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
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

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
    public function permission(): BelongsTo
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
    public function role(): BelongsTo
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
