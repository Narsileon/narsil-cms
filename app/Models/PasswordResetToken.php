<?php

namespace App\Models;

#region USE

use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class PasswordResetToken extends Model
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

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "email" column.
     */
    public const EMAIL = 'email';
    /**
     * @var string The name of the "token" column.
     */
    public const TOKEN = 'token';

    /**
     * @var string The name of the "password reset tokens" table.
     */
    public const TABLE = 'password_reset_tokens';

    #endregion
}
