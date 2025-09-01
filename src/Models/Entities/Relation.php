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

        $id = self::ID;
        $ownerTable    = self::OWNER_TABLE;
        $ownerUuid = self::OWNER_UUID;
        $targetTable   = self::TARGET_TABLE;
        $targetUuid = self::TARGET_UUID;

        $cte = 'cte';
        $processed = 'processed';
        $visited = 'visited';

        $rawQuery = <<<SQL
WITH RECURSIVE $cte AS (
    SELECT
        $id,
        $ownerTable,
        $ownerUuid,
        $targetTable,
        $targetUuid,
        JSON_ARRAY(
            CONCAT($ownerTable, ':', $ownerUuid), 
            CONCAT($targetTable, ':', $targetUuid)
        ) AS $visited,
        0 AS $processed
    FROM 
        $tableName
    WHERE 
        $ownerTable = ? 
        AND $ownerUuid = ?
    UNION ALL
    SELECT
        r.$id,
        r.$ownerTable,
        r.$ownerUuid,
        r.$targetTable,
        r.$targetUuid,
        JSON_ARRAY_APPEND(
            cte.$visited, 
            '$', 
            CONCAT(r.$targetTable, ':', r.$targetUuid)
        ),
        JSON_CONTAINS(
            cte.$visited, 
            JSON_QUOTE(CONCAT(r.$targetTable, ':', r.$targetUuid))
        ) AS $processed
    FROM 
        {$tableName} r
    INNER JOIN $cte cte
        ON cte.$targetTable = r.$ownerTable 
        AND cte.$targetUuid = r.$ownerUuid
    WHERE 
        cte.$processed = 0
)
SELECT 
    $id,
    $ownerTable,
    $ownerUuid,
    $targetTable,
    $targetUuid
FROM 
    $cte
SQL;

        return $query->from(DB::raw("($rawQuery) as relation_chain"))
            ->setBindings([$table, $uuid]);
    }

    #endregion

    #endregion
}
