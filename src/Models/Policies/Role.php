<?php

namespace Narsil\Models\Policies;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Role extends Model
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
     * @var string The name of the "name" column.
     */
    final public const NAME = 'name';

    /**
     * @var string The name of the "permissions" relation.
     */
    final public const RELATION_PERMISSIONS = 'permissions';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'roles';

    #endregion

    #region RELATIONSHIPS

    /**
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
