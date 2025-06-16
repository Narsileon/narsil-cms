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
     * @var string
     */
    public const EMAIL = 'email';
    /**
     * @var string
     */
    public const TOKEN = 'token';

    /**
     * @var string
     */
    public const TABLE = 'password_reset_tokens';

    #endregion
}
