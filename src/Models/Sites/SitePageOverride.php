<?php

namespace Narsil\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageOverride extends Model
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
    final public const TABLE = 'site_page_overrides';

    #region • COLUMNS

    /**
     * The name of the "country" column.
     *
     * @var string
     */
    final public const COUNTRY = 'country';

    /**
     * The name of the "left id" column.
     *
     * @var string
     */
    final public const LEFT_ID = 'left_id';

    /**
     * The name of the "page id" column.
     *
     * @var string
     */
    final public const PAGE_ID = 'page_id';

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
     * The name of the "parent" relation.
     *
     * @var string
     */
    final public const RELATION_PARENT = 'parent';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated site page.
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

    #endregion

    #endregion
}
