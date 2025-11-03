<?php

namespace Narsil\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\Hosts\Host;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasDatetimes;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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

        $this->with = [
            self::RELATION_HOST,
        ];

        $this->mergeGuarded([
            self::ID,
        ]);

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
     * The name of the "host id" column.
     *
     * @var string
     */
    final public const HOST_ID = 'host_id';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "host" relation.
     *
     * @var string
     */
    final public const RELATION_HOST = 'host';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated host.
     *
     * @return BelongsTo
     */
    final public function host(): BelongsTo
    {
        return $this
            ->belongsTo(
                Host::class,
                self::HOST_ID,
                Host::ID,
            );
    }

    #endregion

    #endregion
}
