<?php

namespace Narsil\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\Hosts\Host;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteUrl extends Model
{
    use HasUuids;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->primaryKey = self::UUID;

        $this->mergeGuarded([
            self::UUID,
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
    final public const TABLE = 'site_urls';

    #region • COLUMNS

    /**
     * The name of the "country" column.
     *
     * @var string
     */
    final public const COUNTRY = 'country';

    /**
     * The name of the "language" column.
     *
     * @var string
     */
    final public const LANGUAGE = 'language';

    /**
     * The name of the "page id" column.
     *
     * @var string
     */
    final public const PAGE_ID = 'page_id';

    /**
     * The name of the "path" column.
     *
     * @var string
     */
    final public const PATH = 'path';

    /**
     * The name of the "site id" column.
     *
     * @var string
     */
    final public const SITE_ID = 'site_id';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "page" relation.
     *
     * @var string
     */
    final public const RELATION_PAGE = 'page';

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
     * Get the associated page.
     *
     * @return BelongsTo
     */
    final public function page(): BelongsTo
    {
        return $this
            ->belongsTo(
                SitePage::class,
                self::PAGE_ID,
                SitePage::ID
            );
    }

    /**
     * Get the associated site.
     *
     * @return BelongsTo
     */
    final public function site(): BelongsTo
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
