<?php

namespace Narsil\Models\Globals;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Narsil\Models\Sites\SitePage;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterLink extends Pivot
{
    use HasTranslations;
    use HasUuids;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->primaryKey = self::UUID;
        $this->timestamps = false;

        $this->translatable = [
            self::LABEL,
        ];

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
    final public const TABLE = 'footer_links';

    #region • COLUMNS

    /**
     * The name of the "footer id" column.
     *
     * @var string
     */
    final public const FOOTER_ID = 'footer_id';

    /**
     * The name of the "label" column.
     *
     * @var string
     */
    final public const LABEL = 'label';

    /**
     * The name of the "site page id" column.
     *
     * @var string
     */
    final public const SITE_PAGE_ID = 'site_page_id';

    /**
     * The name of the "position" column.
     *
     * @var string
     */
    final public const POSITION = 'position';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "footer" relation.
     *
     * @var string
     */
    final public const RELATION_FOOTER = 'footer';

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
