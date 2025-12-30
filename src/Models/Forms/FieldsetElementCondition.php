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
class FieldsetElementCondition extends AbstractCondition
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
    final public const TABLE = 'fieldset_element_conditions';

    #region • COLUMNS

    /**
     * The name of the "fieldset element uuid" column.
     *
     * @var string
     */
    final public const FIELDSET_ELEMENT_UUID = 'fieldset_element_uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "fieldset element" relation.
     *
     * @var string
     */
    final public const RELATION_FIELDSET_ELEMENT = 'fieldset_element';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated fieldset element.
     *
     * @return BelongsTo
     */
    final public function fieldset_element(): BelongsTo
    {
        return $this
            ->belongsTo(
                FieldsetElement::class,
                self::FIELDSET_ELEMENT_UUID,
                FieldsetElement::UUID,
            );
    }

    #endregion

    #endregion
}
