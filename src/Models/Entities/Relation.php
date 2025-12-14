<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Relation extends Model
{
    use SoftDeletes;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->timestamps = false;

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
    final public const TABLE = 'relations';

    #region • COLUMNS

    /**
     * The name of the "deleted at" column.
     *
     * @var string
     */
    final public const DELETED_AT = 'deleted_at';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "owner id" column.
     *
     * @var string
     */
    final public const OWNER_ID = 'owner_id';

    /**
     * The name of the "owner table" column.
     *
     * @var string
     */
    final public const OWNER_TABLE = 'owner_table';

    /**
     * The name of the "owner uuid" column.
     *
     * @var string
     */
    final public const OWNER_UUID = 'owner_uuid';

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

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • SCOPES

    /**
     * Get the associated entities.
     *
     * @param Builder $query
     * @param string $table
     * @param integer $id
     *
     * @return Builder
     */
    public function scopeEntities(Builder $query, string $table, int $id): Builder
    {
        $sql = file_get_contents(__DIR__ . '/../../SQL/relations.sql');

        return $query
            ->withTrashed()
            ->fromRaw("($sql) as relation_chain")
            ->setBindings([$table, $id]);
    }

    #endregion

    #endregion
}
