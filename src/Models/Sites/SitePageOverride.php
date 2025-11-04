<?php

namespace Narsil\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageOverride extends Model
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

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
    final public const TABLE = 'site_page_overrides';

    #region • COLUMNS

    /**
     * The name of the "country" column.
     *
     * @var string
     */
    final public const COUNTRY = 'country';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "left id" column.
     *
     * @var string
     */
    final public const LEFT_ID = 'left_id';

    /**
     * The name of the "parent id" column.
     *
     * @var string
     */
    final public const PARENT_ID = 'parent_id';

    /**
     * The name of the "right id" column.
     *
     * @var string
     */
    final public const RIGHT_ID = 'right_id';

    /**
     * The name of the "site page id" column.
     *
     * @var string
     */
    final public const SITE_PAGE_ID = 'site_page_id';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "parent" relation.
     *
     * @var string
     */
    final public const RELATION_PARENT = 'parent';

    /**
     * The name of the "site page" relation.
     *
     * @var string
     */
    final public const RELATION_SITE_PAGE = 'site_page';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated parent.
     *
     * @return BelongsTo
     */
    final public function parent(): BelongsTo
    {
        return $this
            ->belongsTo(
                SitePage::class,
                self::PARENT_ID,
                SitePage::ID
            );
    }

    /**
     * Get the associated site page.
     *
     * @return BelongsTo
     */
    final public function site_page(): BelongsTo
    {
        return $this
            ->belongsTo(
                SitePage::class,
                self::SITE_PAGE_ID,
                SitePage::ID
            );
    }

    #endregion

    #endregion
}
