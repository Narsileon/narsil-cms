<?php

namespace Narsil\Models\Hosts;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostPageOverride extends Model
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
    final public const TABLE = 'host_page_overrides';

    #region • COLUMNS

    /**
     * The name of the "host locale uuid" column.
     *
     * @var string
     */
    final public const HOST_LOCALE_UUID = 'host_locale_uuid';

    /**
     * The name of the "host page id" column.
     *
     * @var string
     */
    final public const HOST_PAGE_ID = 'host_page_id';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "parent id" column.
     *
     * @var string
     */
    final public const PARENT_ID = 'parent_id';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "host page" relation.
     *
     * @var string
     */
    final public const RELATION_HOST = 'host_page';

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
     * Get the associated host page.
     *
     * @return BelongsTo
     */
    final public function host_page(): BelongsTo
    {
        return $this
            ->belongsTo(
                HostPage::class,
                self::HOST_PAGE_ID,
                HostPage::ID
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
                HostPage::class,
                self::PARENT_ID,
                HostPage::ID
            );
    }

    #endregion

    #endregion
}
