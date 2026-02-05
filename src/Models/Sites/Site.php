<?php

namespace Narsil\Cms\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Cms\Database\Factories\SiteFactory;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\Header;
use Narsil\Cms\Models\Hosts\Host;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
#[UseFactory(SiteFactory::class)]
class Site extends Host
{
    #region CONSTANTS

    /**
     * The virtual table associated with the model.
     *
     * @var string
     */
    final public const VIRTUAL_TABLE = 'sites';

    #region • COLUMNS

    /**
     * The name of the "footer id" column.
     *
     * @var string
     */
    final public const FOOTER_ID = 'footer_id';

    /**
     * The name of the "header id" column.
     *
     * @var string
     */
    final public const HEADER_ID = 'header_id';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "footer" relation.
     *
     * @var string
     */
    final public const RELATION_FOOTER = 'footer';

    /**
     * The name of the "header" relation.
     *
     * @var string
     */
    final public const RELATION_HEADER = 'header';

    /**
     * The name of the "pages" relation.
     *
     * @var string
     */
    final public const RELATION_PAGES = 'pages';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated footer.
     *
     * @return BelongsTo
     */
    final public function footer(): BelongsTo
    {
        return $this
            ->belongsTo(
                Footer::class,
                self::FOOTER_ID,
                Footer::ID,
            );
    }

    /**
     * Get the associated header.
     *
     * @return BelongsTo
     */
    final public function header(): BelongsTo
    {
        return $this
            ->belongsTo(
                Header::class,
                self::HEADER_ID,
                Header::ID,
            );
    }

    /**
     * Get the associated pages.
     *
     * @return HasMany
     */
    final public function pages(): HasMany
    {
        return $this
            ->hasMany(
                SitePage::class,
                SitePage::SITE_ID,
                self::ID,
            );
    }

    #endregion

    #endregion
}
