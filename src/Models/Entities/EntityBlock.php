<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Traits\HasTemplate;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityBlock extends Model
{
    use HasTemplate;
    use HasUuids;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = static::getTableName();

        $this->primaryKey = self::UUID;
        $this->timestamps = false;

        $this->with = [
            self::RELATION_BLOCK,
            self::RELATION_FIELDS,
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
    final public const TABLE = 'entity_blocks';

    #region • COLUMNS

    /**
     * The name of the "block id" column.
     *
     * @var string
     */
    final public const BLOCK_ID = 'block_id';

    /**
     * The name of the "entity field uuid" column.
     *
     * @var string
     */
    final public const ENTITY_FIELD_UUID = 'entity_field_uuid';

    /**
     * The name of the "entity uuid" column.
     *
     * @var string
     */
    final public const ENTITY_UUID = 'entity_uuid';

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
     * The name of the "block" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCK = 'block';

    /**
     * The name of the "entity" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITY = 'entity';

    /**
     * The name of the "fields" relation.
     *
     * @var string
     */
    final public const RELATION_FIELDS = 'fields';

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getTableName(): string
    {
        $singular = Str::singular(static::$template?->{Template::HANDLE} ?? "");

        return $singular . '_blocks';
    }

    /**
     * @return array
     */
    final public function toArrayWithTranslations(): array
    {
        $attributes = parent::toArray();

        foreach ($this->getRelations() as $relation => $model)
        {
            if ($model instanceof Collection)
            {
                $attributes[$relation] = $model->map(function ($item)
                {
                    return method_exists($item, 'toArrayWithTranslations')
                        ? $item->toArrayWithTranslations()
                        : $item->toArray();
                })->all();
            }
        }

        return $attributes;
    }

    #region • RELATIONSHIPS

    /**
     * Get the associated block.
     *
     * @return BelongsTo
     */
    final public function block(): BelongsTo
    {
        return $this
            ->belongsTo(
                Block::class,
                self::BLOCK_ID,
                Block::ID,
            );
    }

    /**
     * Get the associated entity.
     *
     * @return BelongsTo
     */
    final public function entity(): BelongsTo
    {
        return $this
            ->belongsTo(
                Entity::class,
                self::ENTITY_UUID,
                Entity::UUID,
            );
    }

    /**
     * Get the associated fields.
     *
     * @return HasMany
     */
    final public function fields(): HasMany
    {
        return $this
            ->hasMany(
                EntityBlockField::class,
                EntityBlockField::ENTITY_BLOCK_UUID,
                self::UUID,
            );
    }

    #endregion

    #endregion
}
