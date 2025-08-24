<?php

namespace Narsil\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Models\Sites\Site;
use Narsil\Traits\HasDatetimes;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SiteGroup extends Model
{
    use HasDatetimes;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'site_groups';

    #region • COLUMNS

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "name" column.
     *
     * @var string
     */
    final public const NAME = 'name';

    #endregion

    #region • COUNTS

    /**
     * The name of the "sites" count.
     *
     * @var string
     */
    final public const COUNT_SITES = 'sites_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "sites" relation.
     *
     * @var string
     */
    final public const RELATION_SITES = 'sites';

    #endregion

    #endregion

    #region RELATIONSHIPS

    /**
     * Get the associated sites.
     *
     * @return HasMany
     */
    public function sites(): HasMany
    {
        return $this
            ->hasMany(
                Site::class,
                Site::GROUP_ID,
                self::ID
            );
    }

    #endregion
}
