<?php

namespace Narsil\Cms\Models;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Base\Models\User as BaseUser;
use Narsil\Base\Traits\AuditLoggable;
use Narsil\Cms\Casts\ImageCast;
use Narsil\Cms\Models\Policies\Permission;
use Narsil\Cms\Models\Policies\Role;
use Narsil\Cms\Models\Policies\UserPermission;
use Narsil\Cms\Models\Policies\UserRole;
use Narsil\Cms\Models\Users\UserBookmark;
use Narsil\Cms\Traits\Blameable;
use Narsil\Cms\Traits\HasDatetimes;
use Narsil\Cms\Traits\Policies\HasPermissions;
use Narsil\Cms\Traits\Policies\HasRoles;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class User extends BaseUser
{
    use Blameable;
    use AuditLoggable;
    use HasDatetimes;
    use HasPermissions;
    use HasRoles;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->mergeAppends([
            self::ATTRIBUTE_FULL_NAME,
        ]);

        $this->mergeCasts([
            self::AVATAR => ImageCast::class . ':avatars',
            self::EMAIL_VERIFIED_AT => 'datetime',
            self::ENABLED => 'boolean',
            self::PASSWORD => 'hashed',
        ]);

        $this->mergeGuarded([
            self::EMAIL_VERIFIED_AT,
            self::ID,
            self::PASSWORD,
            self::REMEMBER_TOKEN,
            self::TWO_FACTOR_CONFIRMED_AT,
            self::TWO_FACTOR_RECOVERY_CODES,
            self::TWO_FACTOR_SECRET,
        ]);

        $this->mergeHidden([
            self::PASSWORD,
            self::REMEMBER_TOKEN,
            self::TWO_FACTOR_RECOVERY_CODES,
            self::TWO_FACTOR_SECRET,
        ]);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    #region • COLUMNS

    /**
     * The name of the "avatar" column.
     *
     * @var string
     */
    final public const AVATAR = 'avatar';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "configuration" relation.
     *
     * @var string
     */
    final public const RELATION_BOOKMARKS = 'bookmarks';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated bookmarks.
     *
     * @return HasMany
     */
    final public function bookmarks(): HasMany
    {
        return $this
            ->hasMany(
                UserBookmark::class,
                UserBookmark::USER_ID,
                self::ID
            );
    }

    /**
     * {@inheritDoc}
     */
    final public function permissions(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Permission::class,
                UserPermission::TABLE,
                UserPermission::USER_ID,
                UserPermission::PERMISSION_ID,
            )
            ->using(UserPermission::class);
    }

    /**
     * {@inheritDoc}
     */
    final public function roles(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Role::class,
                UserRole::TABLE,
                UserRole::USER_ID,
                UserRole::ROLE_ID,
            )
            ->using(UserRole::class);
    }

    #endregion

    #endregion
}
