<?php

namespace Narsil\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

        $this->with = array_merge([
            self::RELATION_SUBDOMAINS,
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
     * The name of the "domain" column.
     *
     * @var string
     */
    final public const DOMAIN = 'domain';

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

    /**
     * The name of the "pattern" column.
     *
     * @var string
     */
    final public const PATTERN = 'pattern';

    #endregion

    #region • COUNTS

    /**
     * The name of the "subdomains" count.
     *
     * @var string
     */
    final public const COUNT_SUBDOMAINS = 'subdomains_count';

    #region • RELATIONS

    /**
     * The name of the "subdomains" relation.
     *
     * @var string
     */
    final public const RELATION_SUBDOMAINS = 'subdomains';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated subdomains.
     *
     * @return HasMany
     */
    public function subdomains(): HasMany
    {
        return $this
            ->hasMany(
                SiteSubdomain::class,
                SiteSubdomain::SITE_ID,
                self::ID
            )
            ->orderBy(SiteSubdomain::POSITION);
    }

    #endregion

    #endregion
}
