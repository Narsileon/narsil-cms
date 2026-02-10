<?php

namespace Narsil\Cms\Models\Policies;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Narsil\Cms\Models\Policies\Role;
use Narsil\Cms\Models\User;
use Narsil\Base\Traits\HasUuidKey;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserRole extends Pivot
{
    use HasUuidKey;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->timestamps = false;

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'user_role';

    #region • COLUMNS

    /**
     * The name of the "role id" column.
     *
     * @var string
     */
    final public const ROLE_ID = 'role_id';

    /**
     * The name of the "user id" column.
     *
     * @var string
     */
    final public const USER_ID = 'user_id';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "role" relation.
     *
     * @var string
     */
    final public const RELATION_ROLE = 'role';

    /**
     * The name of the "user" relation.
     *
     * @var string
     */
    final public const RELATION_USER = 'user';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

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

    /**
     * Get the associated user.
     *
     * @return BelongsTo
     */
    final public function user(): BelongsTo
    {
        return $this
            ->belongsTo(
                User::class,
                self::USER_ID,
                User::ID,
            );
    }

    #endregion

    #endregion
}
