<?php

namespace Narsil\Cms\Models\Users;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Cms\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Session extends Model
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->incrementing = false;
        $this->keyType = 'string';

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'sessions';

    #region • COLUMNS

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "ip address" column.
     *
     * @var string
     */
    final public const IP_ADDRESS = 'ip_address';

    /**
     * The name of the "last activity" column.
     *
     * @var string
     */
    final public const LAST_ACTIVITY = 'last_activity';

    /**
     * The name of the "payload" column.
     *
     * @var string
     */
    final public const PAYLOAD = 'payload';

    /**
     * The name of the "user agent" column.
     *
     * @var string
     */
    final public const USER_AGENT = 'user_agent';

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
