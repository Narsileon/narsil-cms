<?php

namespace Narsil\Models\Policies;

#region USE

use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RolePermission extends Pivot
{
    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
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
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "permission id" column.
     */
    final public const PERMISSION_ID = 'permission_id';
    /**
     * @var string The name of the "role id" column.
     */
    final public const ROLE_ID = 'role_id';

    /**
     * @var string The name of the "permission" relation.
     */
    final public const RELATION_PERMISSION = 'permission';
    /**
     * @var string The name of the "role" relation.
     */
    final public const RELATION_ROLE = 'role';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'role_permission';

    #endregion

    #region RELATIONS

    /**
     * @return BelongsTo
     */
    final public function permission(): BelongsTo
    {
        return $this->belongsTo(
            Permission::class,
            self::PERMISSION_ID,
            Permission::ID,
        );
    }

    /**
     * @return BelongsTo
     */
    final public function role(): BelongsTo
    {
        return $this->belongsTo(
            Role::class,
            self::ROLE_ID,
            Role::ID,
        );
    }

    #endregion
}
