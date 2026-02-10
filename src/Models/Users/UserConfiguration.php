<?php

namespace Narsil\Cms\Models\Users;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Cms\Models\User;
use Narsil\Base\Traits\HasUuidKey;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserConfiguration extends Model
{
    use HasUuidKey;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->incrementing = false;

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'user_configurations';

    #region • COLUMNS

    /**
     * The name of the "color" column.
     *
     * @var string
     */
    final public const COLOR = 'color';

    /**
     * The name of the "language" column.
     *
     * @var string
     */
    final public const LANGUAGE = 'language';

    /**
     * The name of the "preferences" column.
     *
     * @var string
     */
    final public const PREFERENCES = 'preferences';

    /**
     * The name of the "radius" column.
     *
     * @var string
     */
    final public const RADIUS = 'radius';

    /**
     * The name of the "theme" column.
     *
     * @var string
     */
    final public const THEME = 'theme';

    /**
     * The name of the "user id" column.
     *
     * @var string
     */
    final public const USER_ID = 'user_id';

    #endregion

    #region • RELATIONS

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
                User::ID
            );
    }

    #endregion

    #endregion
}
