<?php

namespace Narsil\Models\Collections;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldOption extends Model
{
    use HasTranslations;
    use HasUuids;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->primaryKey = self::UUID;

        $this->translatable = [
            self::LABEL,
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
    final public const TABLE = 'field_options';

    #region • COLUMNS

    /**
     * The name of the "field id" column.
     *
     * @var string
     */
    final public const FIELD_ID = 'field_id';

    /**
     * The name of the "label" column.
     *
     * @var string
     */
    final public const LABEL = 'label';

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

    /**
     * The name of the "value" column.
     *
     * @var string
     */
    final public const VALUE = 'value';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "field" relation.
     *
     * @var string
     */
    final public const RELATION_FIELD = 'field';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated field.
     *
     * @return BelongsTo
     */
    final public function field(): BelongsTo
    {
        return $this
            ->belongsTo(
                Field::class,
                self::FIELD_ID,
                Field::ID,
            );
    }

    #endregion

    #endregion
}
