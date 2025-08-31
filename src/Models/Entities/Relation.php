<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Narsil\Traits\HasTableName;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class Relation extends Model
{
    use HasTableName;

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
        $tableName   = self::TABLE;
        $ownerTable    = self::OWNER_TABLE;
        $ownerUuid = self::OWNER_UUID;
        $targetTable   = self::TARGET_TABLE;
        $targetUuid = self::TARGET_UUID;

        $rawQuery = <<<SQL
WITH RECURSIVE relation_chain AS (
    SELECT
        id,
        {$ownerTable} AS owner_table,
        {$ownerUuid} AS owner_uuid,
        {$targetTable} AS target_table,
        {$targetUuid} AS target_uuid,
        CONCAT({$ownerTable}, ':', {$ownerUuid}, '|', {$targetTable}, ':', {$targetUuid}) AS path
    FROM {$tableName}
    WHERE {$ownerTable} = ? AND {$ownerUuid} = ?

    UNION ALL

    SELECT
        r.id,
        r.{$ownerTable} AS owner_table,
        r.{$ownerUuid} AS owner_uuid,
        r.{$targetTable} AS target_table,
        r.{$targetUuid} AS target_uuid,
        CONCAT(rc.path, '|', r.{$targetTable}, ':', r.{$targetUuid}) AS path
    FROM {$tableName} r
    INNER JOIN relation_chain rc
        ON rc.target_table = r.{$ownerTable} AND rc.target_uuid = r.{$ownerUuid}
    WHERE NOT FIND_IN_SET(CONCAT(r.{$targetTable}, ':', r.{$targetUuid}), rc.path)
)
SELECT id, owner_table, owner_uuid, target_table, target_uuid
FROM relation_chain
SQL;

        return $query->from(DB::raw("($rawQuery) as relation_chain"))
            ->setBindings([$table, $uuid]);
    }

    #endregion

    #endregion
}
