<?php

namespace Narsil\Models\Policies;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasPermissions;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class Role extends Model
{
    use HasDatetimes;
    use HasPermissions;

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
    final public const TABLE = 'roles';

    #region • COLUMNS

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
     * Get the associated permissions.
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Permission::class,
                RolePermission::TABLE,
                RolePermission::ROLE_ID,
                RolePermission::PERMISSION_ID,
            );
    }

    #endregion
}
