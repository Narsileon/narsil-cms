<?php

namespace Narsil\Models\Policies;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasRoles;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class Permission extends Model
{
    use HasAuditLogs;
    use HasRoles;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

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
    final public const TABLE = 'permissions';

    #region • COLUMNS

    /**
     * The name of the "category" column.
     *
     * @var string
     */
    final public const CATEGORY = 'category';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "name" column.
     *
     * @var string
     */
    final public const NAME = 'name';

    #endregion

    #endregion

    #region RELATIONSHIPS

    /**
     * {@inheritDoc}
     */
    public function roles(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Role::class,
                RolePermission::TABLE,
                RolePermission::PERMISSION_ID,
                RolePermission::ROLE_ID,
            );
    }

    #endregion
}
