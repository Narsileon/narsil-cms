<?php

namespace App\Models;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#endregion

/**
 * @version 1.0.0
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

        $this->incrementing = false;
        $this->primaryKey = 'user_id';

        $this->guarded = array_merge([
            self::USER_ID,
        ], $this->guarded);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "color" column.
     */
    final public const COLOR = 'color';
    /**
     * @var string The name of the "locale" column.
     */
    final public const LOCALE = 'locale';
    /**
     * @var string The name of the "preferences" column.
     */
    final public const PREFERENCES = 'preferences';
    /**
     * @var string The name of the "radius" column.
     */
    final public const RADIUS = 'radius';
    /**
     * @var string The name of the "theme" column.
     */
    final public const THEME = 'theme';
    /**
     * @var string The name of the "user id" column.
     */
    final public const USER_ID = 'user_id';

    /**
     * @var string The name of the "user" relation.
     */
    final public const RELATION_USER = 'user';

    /**
     * @var string The name of the "user configurations" table.
     */
    final public const TABLE = 'user_configurations';

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
