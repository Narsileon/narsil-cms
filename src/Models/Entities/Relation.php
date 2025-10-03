<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class Relation extends Model
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->guarded = array_merge([
            self::ID,
        ], $this->guarded);

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
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

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
     * The name of the "target table" column.
     *
     * @var string
     */
    final public const TARGET_TABLE = 'target_table';

    /**
     * The name of the "target uuid" column.
     *
     * @var string
     */
    final public const TARGET_UUID = 'target_uuid';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • SCOPES

    /**
     * Get the associated entities.
     *
     * @param Builder $query
     * @param string $table
     * @param string $uuid
     *
     * @return Builder
     */
    public function scopeEntities(Builder $query, string $table, string $uuid): Builder
    {
        $sql = file_get_contents(__DIR__ . '/../../SQL/relations.sql');

        return $query->from(DB::raw("($sql) as relation_chain"))
            ->setBindings([$table, $uuid]);
    }

    #endregion

    #endregion
}
