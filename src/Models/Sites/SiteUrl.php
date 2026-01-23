<?php

namespace Narsil\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Traits\HasUuidKey;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SiteUrl extends Model
{
    use HasUuidKey;
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

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
     * The name of the "host locale language uuid" column.
     *
     * @var string
     */
    final public const HOST_LOCALE_LANGUAGE_UUID = 'host_locale_language_uuid';

    /**
     * The name of the "page id" column.
     *
     * @var string
     */
    final public const PAGE_ID = 'page_id';

    /**
     * The name of the "url" column.
     *
     * @var string
     */
    final public const URL = 'url';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "host locale language" relation.
     *
     * @var string
     */
    final public const RELATION_HOST_LOCALE_LANGUAGE = 'host_locale_language';

    /**
     * The name of the "page" relation.
     *
     * @var string
     */
    final public const RELATION_PAGE = 'page';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated host locale language.
     *
     * @return BelongsTo
     */
    final public function host_locale_language(): BelongsTo
    {
        return $this
            ->belongsTo(
                HostLocaleLanguage::class,
                self::HOST_LOCALE_LANGUAGE_UUID,
                HostLocaleLanguage::UUID,
            );
    }

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


    #endregion

    #endregion
}
