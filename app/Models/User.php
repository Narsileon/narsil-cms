<?php

namespace App\Models;

#region USE

use App\Models\Session;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class User extends Authenticatable
{
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
            self::ACTIVE => 'boolean',
            self::EMAIL_VERIFIED_AT => 'datetime',
            self::PASSWORD => 'hashed',
        ], $this->casts);

        $this->fillable = array_merge([
            self::EMAIL,
            self::FIRST_NAME,
            self::LAST_NAME,
            self::PASSWORD,
        ], $this->fillable);

        $this->hidden = array_merge([
            self::PASSWORD,
            self::REMEMBER_TOKEN,
        ], $this->hidden);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string
     */
    public const ACTIVE = 'active';
    /**
     * @var string
     */
    public const EMAIL = 'email';
    /**
     * @var string
     */
    public const EMAIL_VERIFIED_AT = 'email_verified_at';
    /**
     * @var string
     */
    public const FIRST_NAME = 'first_name';
    /**
     * @var string
     */
    public const LAST_NAME = 'last_name';
    /**
     * @var string
     */
    public const ID = 'id';
    /**
     * @var string
     */
    public const PASSWORD = 'password';
    /**
     * @var string
     */
    public const PASSWORD_CONFIRMATION = 'password_confirmation';
    /**
     * @var string
     */
    public const REMEMBER = 'remember';
    /**
     * @var string
     */
    public const REMEMBER_TOKEN = 'remember_token';

    /**
     * @var string
     */
    public const RELATION_SESSIONS = 'sessions';

    /**
     * @var string
     */
    public const TABLE = 'users';

    #endregion

    #region RELATIONSHIPS

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
