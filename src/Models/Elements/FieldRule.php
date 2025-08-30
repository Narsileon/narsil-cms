<?php

namespace Narsil\Models\Elements;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class FieldRule extends Model
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
    final public const TABLE = 'field_rules';

    #region • COLUMNS

    /**
     * The name of the "field id" column.
     *
     * @var string
     */
    final public const FIELD_ID = 'field_id';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "rule" column.
     *
     * @var string
     */
    final public const RULE = 'rule';

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

    #region RELATIONSHIPS

    /**
     * Get the associated field.
     *
     * @return BelongsTo
     */
    public function field(): BelongsTo
    {
        return $this
            ->belongsTo(
                Field::class,
                self::FIELD_ID,
                Field::ID,
            );
    }

    #endregion
}
