<?php

namespace Narsil\Models\Forms;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Narsil\Models\Forms\FormStep;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormStepElement extends Element
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->timestamps = false;

        $this->translatable = [
            self::DESCRIPTION,
            self::LABEL,
        ];

        $this->with = [
            self::RELATION_BASE,
            self::RELATION_CONDITIONS,
        ];

        $this->mergeAppends([
            self::ATTRIBUTE_ICON,
            self::ATTRIBUTE_IDENTIFIER,
        ]);

        $this->mergeCasts([
            self::REQUIRED => 'boolean',
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
    final public const TABLE = 'form_step_element';

    #region • COLUMNS

    /**
     * The name of the "fieldset id" column.
     *
     * @var string
     */
    final public const FIELDSET_ID = 'fieldset_id';

    /**
     * The name of the "input id" column.
     *
     * @var string
     */
    final public const INPUT_ID = 'input_id';

    /**
     * The name of the "owner uuid" column.
     *
     * @var string
     */
    final public const OWNER_UUID = 'owner_uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "fieldset" relation.
     *
     * @var string
     */
    final public const RELATION_FIELDSET = 'fieldset';

    /**
     * The name of the "input" relation.
     *
     * @var string
     */
    final public const RELATION_INPUT = 'input';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * {@inheritDoc}
     */
    final public function conditions(): HasMany
    {
        return $this
            ->hasMany(
                FormStepElementCondition::class,
                FormStepElementCondition::FORM_STEP_ELEMENT_UUID,
                self::UUID,
            )
            ->orderBy(FormStepElementCondition::POSITION);
    }

    /**
     * Get the associated fieldset.
     *
     * @return BelongsTo
     */
    final public function fieldset(): BelongsTo
    {
        return $this
            ->belongsTo(
                Fieldset::class,
                self::FIELDSET_ID,
                Fieldset::ID,
            );
    }

    /**
     * Get the associated input.
     *
     * @return BelongsTo
     */
    final public function input(): BelongsTo
    {
        return $this
            ->belongsTo(
                Input::class,
                self::INPUT_ID,
                Input::ID,
            );
    }

    /**
     * {@inheritDoc}
     */
    final public function owner(): BelongsTo
    {
        return $this
            ->belongsTo(
                FormStep::class,
                self::OWNER_UUID,
                FormStep::UUID,
            );
    }

    #endregion

    #endregion
}
