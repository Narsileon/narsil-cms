<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\Sites\SitePage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityNodeSitePage extends AbstractEntityNodeRelation
{
    use HasUuids;

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
    final public const TABLE = 'entity_node_site_pages';

    #region • COLUMNS

    /**
     * The name of the "site page id" column.
     *
     * @var string
     */
    final public const SITE_PAGE_ID = 'site_page_id';

    #endregion

    #region • RELATIONS

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
                SitePage::ID,
            );
    }

    #endregion

    #endregion
}
