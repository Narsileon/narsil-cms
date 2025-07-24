<?php

namespace Narsil\Models\Users;

#region USE

use Narsil\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Session extends Model
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

        $this->keyType = 'string';
        $this->incrementing = false;

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of the "id" column.
     */
    final public const ID = 'id';
    /**
     * @var string The name of the "ip address" column.
     */
    final public const IP_ADDRESS = 'ip_address';
    /**
     * @var string The name of the "last activity" column.
     */
    final public const LAST_ACTIVITY = 'last_activity';
    /**
     * @var string The name of the "payload" column.
     */
    final public const PAYLOAD = 'payload';
    /**
     * @var string The name of the "user agent" column.
     */
    final public const USER_AGENT = 'user_agent';
    /**
     * @var string The name of the "user id" column.
     */
    final public const USER_ID = 'user_id';

    /**
     * @var string The name of the "user" relation.
     */
    final public const RELATION_USER = 'user';

    /**
     * @var string The table associated with the model.
     */
    final public const TABLE = 'sessions';

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
