<?php

namespace Narsil\Models;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class AuditLog extends Model
{
    use HasUuids;

    #region CONSTRUCTOR

    /**
     * @param array $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->primaryKey = self::UUID;

        $this->mergeCasts([
            self::NEW_VALUES => 'array',
            self::OLD_VALUES => 'array',
        ]);

        $this->guarded = [];

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public const TABLE = 'audit_logs';

    #region • COLUMNS

    /**
     * @var string The name of the "event" column.
     */
    public const EVENT = 'event';

    /**
     * The name of the "model id" column.
     *
     * @var string
     */
    public const MODEL_ID = 'model_id';

    /**
     * The name of the "model type" column.
     *
     * @var string
     */
    public const MODEL_TYPE = 'model_type';

    /**
     * The name of the "new values" column.
     *
     * @var string
     */
    public const NEW_VALUES = 'new_values';

    /**
     * The name of the "old values" column.
     *
     * @var string
     */
    public const OLD_VALUES = 'old_values';

    /**
     * The name of the "user id" column.
     *
     * @var string
     */
    public const USER_ID = 'user_id';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    public const UUID = 'uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "model" relation.
     *
     * @var string
     */
    public const RELATION_MODEL = 'model';

    /**
     * The name of the "user" relation.
     *
     * @var string
     */
    public const RELATION_USER = 'user';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated model.
     *
     * @return MorphTo
     */
    public function model(): MorphTo
    {
        return $this->morphTo(
            self::RELATION_MODEL,
            self::MODEL_TYPE,
            self::MODEL_ID
        );
    }

    /**
     * Get the associated user.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
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
