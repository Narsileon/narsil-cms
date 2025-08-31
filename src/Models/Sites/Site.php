<?php

namespace Narsil\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\Sites\SiteGroup;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasDatetimes;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class Site extends Model
{
    use HasAuditLogs;
    use HasDatetimes;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->casts = array_merge([
            self::PRIMARY => 'boolean',
        ], $this->casts);

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        $this->with = array_merge([
            self::RELATION_GROUP,
        ], $this->with);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'sites';

    #region • COLUMNS

    /**
     * The name of the "enabled" column.
     *
     * @var string
     */
    final public const ENABLED = 'enabled';

    /**
     * The name of the "group id" column.
     *
     * @var string
     */
    final public const GROUP_ID = 'group_id';

    /**
     * The name of the "handle" column.
     *
     * @var string
     */
    final public const HANDLE = 'handle';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "language" column.
     *
     * @var string
     */
    final public const LANGUAGE = 'language';

    /**
     * The name of the "name" column.
     *
     * @var string
     */
    final public const NAME = 'name';

    /**
     * The name of the "primary" column.
     *
     * @var string
     */
    final public const PRIMARY = 'primary';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "group" relation.
     *
     * @var string
     */
    final public const RELATION_GROUP = 'group';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated group.
     *
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this
            ->belongsTo(
                SiteGroup::class,
                self::GROUP_ID,
                SiteGroup::ID
            );
    }

    #endregion

    #endregion
}
