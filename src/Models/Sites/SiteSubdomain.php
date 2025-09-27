<?php

namespace Narsil\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Models\Sites\Site;
use Narsil\Traits\HasAuditLogs;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SiteSubdomain extends Model
{
    use HasAuditLogs;

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
            self::RELATION_LANGUAGES,
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
    final public const TABLE = 'site_subdomains';

    #region • COLUMNS

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "position" column.
     *
     * @var string
     */
    final public const POSITION = 'position';

    /**
     * The name of the "site id" column.
     *
     * @var string
     */
    final public const SITE_ID = 'site_id';

    /**
     * The name of the "subdomain" column.
     *
     * @var string
     */
    final public const SUBDOMAIN = 'subdomain';

    #endregion

    #region • COUNTS

    /**
     * The name of the "languages" count.
     *
     * @var string
     */
    final public const COUNT_LANGUAGES = 'languages_count';

    #region • RELATIONS

    /**
     * The name of the "languages" relation.
     *
     * @var string
     */
    final public const RELATION_LANGUAGES = 'languages';

    /**
     * The name of the "site" relation.
     *
     * @var string
     */
    final public const RELATION_SITE = 'site';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated languages.
     *
     * @return HasMany
     */
    public function languages(): HasMany
    {
        return $this
            ->hasMany(
                SiteSubdomainLanguage::class,
                SiteSubdomainLanguage::SUBDOMAIN_ID,
                self::ID
            )
            ->orderBy(SiteSubdomainLanguage::LANGUAGE);
    }

    /**
     * Get the associated site.
     *
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this
            ->belongsTo(
                Site::class,
                self::SITE_ID,
                Site::ID
            );
    }

    #endregion

    #endregion
}
