<?php

namespace Narsil\Models\Sites;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageRelation extends Model
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
        $this->timestamps = false;

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
    final public const TABLE = 'site_page_relations';

    #region • COLUMNS

    /**
     * The name of the "page id" column.
     *
     * @var string
     */
    final public const PAGE_ID = 'page_id';

    /**
     * The name of the "target id" column.
     *
     * @var string
     */
    final public const TARGET_ID = 'target_id';

    /**
     * The name of the "target table" column.
     *
     * @var string
     */
    final public const TARGET_TABLE = 'target_table';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #endregion
}
