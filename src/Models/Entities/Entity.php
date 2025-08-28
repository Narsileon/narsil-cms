<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasRevisions;
use Narsil\Traits\HasTableName;

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
    use HasTableName;

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

        $this->with = array_merge([
            self::RELATION_BLOCKS,
        ], $this->with);

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

    #region RELATIONSHIPS

    /**
     * Get the associated blocks.
     *
     * @return HasMany
     */
    final public function blocks(): HasMany
    {
        return $this
            ->hasMany(
                EntityBlock::class,
                EntityBlock::ENTITY_UUID,
                self::UUID,
            )
            ->whereNull(EntityBlock::PARENT_ID);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function setTableName(string $tableName): void
    {
        static::$tableName = $tableName;

        $singular = Str::singular($tableName);

        EntityBlock::setTableName($singular . '_blocks');
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model)
        {
            $model->{self::ID} = static::max(self::ID) + 1;
        });
    }

    /**
     * {@inheritDoc}
     */
    protected static function maxRevisions(): ?int
    {
        return null;
    }

    #endregion
}
