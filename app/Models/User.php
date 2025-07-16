<?php

namespace App\Models;

#region USE

use App\Contracts\Enable;
use App\Observers\UserObserver;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements Enable, MustVerifyEmail
{
    use Notifiable;
    use TwoFactorAuthenticatable;

    #region CONSTRUCTOR

    /**
     * @param array $attributes
     * @param string $table
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->casts = array_merge([
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
     * @var string The name of the "email" column.
     */
    final public const EMAIL = 'email';
    /**
     * @var string The name of the "email verified at" column.
     */
    final public const EMAIL_VERIFIED_AT = 'email_verified_at';
    /**
     * @var string The name of the "first name" column.
     */
    final public const FIRST_NAME = 'first_name';
    /**
     * @var string The name of the "last name" column.
     */
    final public const LAST_NAME = 'last_name';
    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "password" column.
     */
    final public const PASSWORD = 'password';
    /**
     * @var string The name of the "remember" column.
     */
    final public const REMEMBER = 'remember';
    /**
     * @var string The name of the "remember token" column.
     */
    final public const REMEMBER_TOKEN = 'remember_token';
    /**
     * @var string The name of the "two factor confirmed at" column.
     */
    final public const TWO_FACTOR_CONFIRMED_AT = 'two_factor_confirmed_at';
    /**
     * @var string The name of the "two factor recovery codes" column.
     */
    final public const TWO_FACTOR_RECOVERY_CODES = 'two_factor_recovery_codes';
    /**
     * @var string The name of the "two factor secret" column.
     */
    final public const TWO_FACTOR_SECRET = 'two_factor_secret';

    /**
     * @var string The name of the "current password" attribute.
     */
    final public const ATTRIBUTE_CURRENT_PASSWORD = 'current_password';
    /**
     * @var string The name of the "password confirmation" attribute.
     */
    final public const ATTRIBUTE_PASSWORD_CONFIRMATION = 'password_confirmation';

    /**
     * @var string The name of the "configuration" relation.
     */
    final public const RELATION_CONFIGURATION = 'configuration';
    /**
     * @var string The name of the "sessions" relation.
     */
    final public const RELATION_SESSIONS = 'sessions';

    /**
     * @var string The name of the "users" table.
     */
    final public const TABLE = 'users';

    #endregion

    #region RELATIONSHIPS

    /**
     * @return HasOne
     */
    public function configuration(): HasOne
    {
        return $this->hasOne(
            UserConfiguration::class,
            UserConfiguration::USER_ID,
            self::ID
        );
    }

    /**
     * @return HasMany
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(
            Session::class,
            Session::USER_ID,
            self::ID
        );
    }

    #endregion
}