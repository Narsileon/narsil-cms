<?php

namespace Narsil\Models\Policies;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Narsil\Models\Policies\Role;
use Narsil\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserRole extends Pivot
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
     * @var string The name of the "role id" column.
     */
    final public const ROLE_ID = 'role_id';
    /**
     * @var string The name of the "user id" column.
     */
    final public const USER_ID = 'user_id';

    /**
     * @var string The name of the "role" relation.
     */
    final public const RELATION_ROLE = 'role';
    /**
     * @var string The name of the "user" relation.
     */
    final public const RELATION_USER = 'user';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'user_role';

    #endregion

    #region RELATIONS

    /**
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

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this
            ->belongsTo(
                User::class,
                self::USER_ID,
                User::ID,
            );
    }

    #endregion
}
