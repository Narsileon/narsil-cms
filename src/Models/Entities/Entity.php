<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasRevisions;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class Entity extends Model
{
    use Blameable;
    use HasDatetimes;
    use HasUuids;
    use HasRevisions;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = static::$tableName;

        $this->primaryKey = self::UUID;

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
    final public const TABLE = 'entities';

    #region • RELATIONS

    /**
     * The name of the "blocks" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCKS = 'blocks';

    /**
     * The name of the "entities" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITIES = 'entities';

    #endregion

    #endregion

    #region PROPERTIES

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected static string $tableName = self::TABLE;

    #endregion

    #region PUBLIC METHODS

    /**
     * @return string
     */
    public static function getBlocksTableName(): string
    {
        $singular = Str::singular(static::$tableName);

        return $singular . '_blocks';
    }

    /**
     * @return string
     */
    public static function getEntitiesTableName(): string
    {
        $singular = Str::singular(static::$tableName);

        return $singular . '_entities';
    }

    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return static::$tableName;
    }

    /**
     * @return void
     */
    public static function setTableName(string $tableName): void
    {
        static::$tableName = $tableName;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected static function maxRevisions(): ?int
    {
        return null;
    }

    #endregion
}
