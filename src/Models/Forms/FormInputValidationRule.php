<?php

namespace Narsil\Models\Forms;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Narsil\Models\ValidationRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormInputValidationRule extends Pivot
{
    use HasUuids;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->primaryKey = self::UUID;
        $this->timestamps = false;

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
    final public const TABLE = 'form_input_validation_rule';

    #region • COLUMNS

    /**
     * The name of the "input id" column.
     *
     * @var string
     */
    final public const INPUT_ID = 'input_id';

    /**
     * The name of the "rule id" column.
     *
     * @var string
     */
    final public const VALIDATION_RULE_ID = 'validation_rule_id';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "input" relation.
     *
     * @var string
     */
    final public const RELATION_INPUT = 'input';

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
     * Get the associated input.
     *
     * @return BelongsTo
     */
    final public function input(): BelongsTo
    {
        return $this
            ->belongsTo(
                FormInput::class,
                self::INPUT_ID,
                FormInput::ID,
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
