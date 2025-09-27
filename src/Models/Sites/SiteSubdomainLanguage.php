<?php

namespace Narsil\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Traits\HasAuditLogs;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SiteSubdomainLanguage extends Model
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

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'site_subdomain_languages';

    #region • COLUMNS

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
     * The name of the "position" column.
     *
     * @var string
     */
    final public const POSITION = 'position';

    /**
     * The name of the "subdomain id" column.
     *
     * @var string
     */
    final public const SUBDOMAIN_ID = 'subdomain_id';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "subdomain" relation.
     *
     * @var string
     */
    final public const RELATION_SUBDOMAIN = 'subdomain';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated site.
     *
     * @return BelongsTo
     */
    public function subdomain(): BelongsTo
    {
        return $this
            ->belongsTo(
                SiteSubdomain::class,
                self::SUBDOMAIN_ID,
                SiteSubdomain::ID
            );
    }

    #endregion

    #endregion
}
