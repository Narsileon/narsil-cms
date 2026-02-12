<?php

namespace Narsil\Cms\Models\Collections;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Narsil\Base\Traits\HasUuidPrimaryKey;
use Narsil\Cms\Models\ValidationRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldValidationRule extends Pivot
{
    use HasUuidPrimaryKey;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->timestamps = false;

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'field_validation_rule';

    #region • COLUMNS

    /**
     * The name of the "field id" column.
     *
     * @var string
     */
    final public const FIELD_ID = 'field_id';

    /**
     * The name of the "rule id" column.
     *
     * @var string
     */
    final public const VALIDATION_RULE_ID = 'validation_rule_id';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "field" relation.
     *
     * @var string
     */
    final public const RELATION_FIELD = 'field';

    /**
     * The name of the "validation rule" relation.
     *
     * @var string
     */
    final public const RELATION_VALIDATION_RULE = 'validation_rule';

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

    /**
     * Get the associated validation rule.
     *
     * @return BelongsTo
     */
    final public function validation_rule(): BelongsTo
    {
        return $this
            ->belongsTo(
                ValidationRule::class,
                self::VALIDATION_RULE_ID,
                ValidationRule::ID,
            );
    }

    #endregion

    #endregion
}
