<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\Structures\Template;
use Narsil\Models\Entities\Entity;
use Narsil\Services\CollectionService;
use Narsil\Traits\HasTemplate;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityData extends Model
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

        $this->mergeGuarded([
            self::UUID,
        ]);

        if (static::$template)
        {
            $casts = $this->generateCasts(CollectionService::getTemplateFields(static::$template));

            $this->mergeCasts($casts);
        }

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'entity_data';

    #region • COLUMNS

    /**
     * The name of the "entity uuid" column.
     *
     * @var string
     */
    final public const ENTITY_UUID = 'entity_uuid';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "entity" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITY = 'entity';

    #endregion

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public static function getTableName(): string
    {
        return static::$template?->{Template::HANDLE} ?? "";
    }

    #region • RELATIONSHIPS

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

    #endregion

    #endregion
}
