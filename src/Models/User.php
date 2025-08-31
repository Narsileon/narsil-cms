<?php

namespace Narsil\Models;

#region USE

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Narsil\Casts\ImageCast;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Policies\UserPermission;
use Narsil\Models\Policies\UserRole;
use Narsil\Models\Users\Session;
use Narsil\Models\Users\UserConfiguration;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasPermissions;
use Narsil\Traits\HasRoles;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasAuditLogs;
    use HasDatetimes;
    use HasPermissions;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->appends = array_merge([
            self::ATTRIBUTE_FULL_NAME,
        ], $this->appends);

        $this->casts = array_merge([
            self::AVATAR => ImageCast::class . ':avatars',
            self::EMAIL_VERIFIED_AT => 'datetime',
            self::ENABLED => 'boolean',
            self::PASSWORD => 'hashed',
        ], $this->casts);

        $this->guarded = array_merge([
            self::EMAIL_VERIFIED_AT,
            self::ID,
            self::PASSWORD,
            self::REMEMBER_TOKEN,
            self::TWO_FACTOR_CONFIRMED_AT,
            self::TWO_FACTOR_RECOVERY_CODES,
            self::TWO_FACTOR_SECRET,
        ], $this->guarded);

        $this->hidden = array_merge([
            self::PASSWORD,
            self::REMEMBER_TOKEN,
            self::TWO_FACTOR_RECOVERY_CODES,
            self::TWO_FACTOR_SECRET,
        ], $this->hidden);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'users';

    #region • COLUMNS

    /**
     * The name of the "avatar" column.
     *
     * @var string
     */
    final public const AVATAR = 'avatar';

    /**
     * The name of the "email" column.
     *
     * @var string
     */
    final public const EMAIL = 'email';

    /**
     * The name of the "email verified at" column.
     *
     * @var string
     */
    final public const EMAIL_VERIFIED_AT = 'email_verified_at';

    /**
     * The name of the "enabled" column.
     *
     * @var string
     */
    final public const ENABLED = 'enabled';

    /**
     * The name of the "first name" column.
     *
     * @var string
     */
    final public const FIRST_NAME = 'first_name';

    /**
     * The name of the "last name" column.
     *
     * @var string
     */
    final public const LAST_NAME = 'last_name';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "password" column.
     *
     * @var string
     */
    final public const PASSWORD = 'password';

    /**
     * The name of the "remember" column.
     *
     * @var string
     */
    final public const REMEMBER = 'remember';

    /**
     * The name of the "remember token" column.
     *
     * @var string
     */
    final public const REMEMBER_TOKEN = 'remember_token';

    /**
     * The name of the "two factor confirmed at" column.
     *
     * @var string
     */
    final public const TWO_FACTOR_CONFIRMED_AT = 'two_factor_confirmed_at';

    /**
     * The name of the "two factor recovery codes" column.
     *
     * @var string
     */
    final public const TWO_FACTOR_RECOVERY_CODES = 'two_factor_recovery_codes';

    /**
     * The name of the "two factor secret" column.
     *
     * @var string
     */
    final public const TWO_FACTOR_SECRET = 'two_factor_secret';

    #endregion

    #region • ATTRIBUTES

    /**
     * The name of the "current password" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_CURRENT_PASSWORD = 'current_password';

    /**
     * The name of the "full name" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_FULL_NAME = 'full_name';

    /**
     * The name of the "password confirmation" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_PASSWORD_CONFIRMATION = 'password_confirmation';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "configuration" relation.
     *
     * @var string
     */
    final public const RELATION_CONFIGURATION = 'configuration';

    /**
     * The name of the "sessions" relation.
     *
     * @var string
     */
    final public const RELATION_SESSIONS = 'sessions';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • ACCESSORS

    /**
     * Get the full name of the user.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    #endregion

    #region • RELATIONSHIPS

    /**
     * Get the associated configuration.
     *
     * @return HasOne
     */
    public function configuration(): HasOne
    {
        return $this
            ->hasOne(
                UserConfiguration::class,
                UserConfiguration::USER_ID,
                self::ID
            );
    }

    /**
     * {@inheritDoc}
     */
    public function permissions(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Permission::class,
                UserPermission::TABLE,
                UserPermission::USER_ID,
                UserPermission::PERMISSION_ID,
            );
    }

    /**
     * {@inheritDoc}
     */
    public function roles(): BelongsToMany
    {
        return $this
            ->belongsToMany(
                Role::class,
                UserRole::TABLE,
                UserRole::USER_ID,
                UserRole::ROLE_ID,
            );
    }

    /**
     * Get the associated sessions.
     *
     * @return HasMany
     */
    public function sessions(): HasMany
    {
        return $this
            ->hasMany(
                Session::class,
                Session::USER_ID,
                self::ID
            );
    }

    #endregion

    #endregion
}
