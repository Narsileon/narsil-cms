<?php

namespace Narsil\Models\Users;

#region USE

use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class PasswordResetToken extends Model
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'password_reset_tokens';

    #region • COLUMNS

    /**
     * The name of the "email" column.
     *
     * @var string
     */
    final public const EMAIL = 'email';

    /**
     * The name of the "token" column.
     *
     * @var string
     */
    final public const TOKEN = 'token';

    #endregion

    #endregion
}
