<?php

namespace Narsil\Cms\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Base\Traits\HasUuidKey;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageEntity extends Pivot
{
    use HasUuidKey;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->timestamps = false;

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'site_page_entity';

    #region • COLUMNS

    /**
     * The name of the "language" column.
     *
     * @var string
     */
    final public const LANGUAGE = 'language';

    /**
     * The name of the "site page id" column.
     *
     * @var string
     */
    final public const SITE_PAGE_ID = 'site_page_id';

    /**
     * The name of the "target id" column.
     *
     * @var string
     */
    final public const TARGET_ID = 'target_id';

    /**
     * The name of the "target type" column.
     *
     * @var string
     */
    final public const TARGET_TYPE = 'target_type';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "site page" relation.
     *
     * @var string
     */
    final public const RELATION_SITE_PAGE = 'site_page';

    /**
     * The name of the "target" relation.
     *
     * @var string
     */
    final public const RELATION_TARGET = 'target';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated target.
     *
     * @return MorphTo
     */
    final public function target(): MorphTo
    {
        return $this
            ->morphTo(
                self::RELATION_TARGET,
                self::TARGET_TYPE,
                self::TARGET_ID,
                Entity::ID,
            )
            ->where(Entity::REVISION, '>', 0);
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
