<?php

namespace Narsil\Models\Forms;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\AbstractCondition;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormStepElementCondition extends AbstractCondition
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'form_step_element_conditions';

    #region • COLUMNS

    /**
     * The name of the "form step element uuid" column.
     *
     * @var string
     */
    final public const FORM_STEP_ELEMENT_UUID = 'form_step_element_uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "form step element" relation.
     *
     * @var string
     */
    final public const RELATION_FORM_STEP_ELEMENT = 'form_step_element';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated form step element.
     *
     * @return BelongsTo
     */
    final public function form_step_element(): BelongsTo
    {
        return $this
            ->belongsTo(
                FormStepElement::class,
                self::FORM_STEP_ELEMENT_UUID,
                FormStepElement::UUID,
            );
    }

    #endregion

    #endregion
}
