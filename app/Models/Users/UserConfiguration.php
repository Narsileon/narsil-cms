<?php

namespace App\Models\Users;

#region USE

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#endregion

/**
 * @version 1.0.0
 *
 * @author Jonathan Rigaux
 */
class UserConfiguration extends Model
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

        $this->primaryKey = 'user_id';
        $this->incrementing = false;

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "language" column.
     */
    public const LANGUAGE = 'language';
    /**
     * @var string The name of the "preferences" column.
     */
    public const PREFERENCES = 'preferences';
    /**
     * @var string The name of the "theme" column.
     */
    public const THEME = 'theme';
    /**
     * @var string The name of the "user id" column.
     */
    public const USER_ID = 'user_id';

    /**
     * @var string The name of the "user" relation.
     */
    public const RELATION_USER = 'user';

    /**
     * @var string The name of the "user configurations" table.
     */
    public const TABLE = 'user_configurations';

    #endregion

    #region RELATIONSHIPS

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            self::USER_ID,
            User::ID
        );
    }

    #endregion
}
