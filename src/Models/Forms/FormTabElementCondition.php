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
class FormTabElementCondition extends AbstractCondition
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
    final public const TABLE = 'form_tab_element_conditions';

    #region • COLUMNS

    /**
     * The name of the "form tab element uuid" column.
     *
     * @var string
     */
    final public const FORM_TAB_ELEMENT_UUID = 'form_tab_element_uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "form tab element" relation.
     *
     * @var string
     */
    final public const RELATION_FORM_TAB_ELEMENT = 'form_tab_element';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated form tab element.
     *
     * @return BelongsTo
     */
    final public function form_tab_element(): BelongsTo
    {
        return $this
            ->belongsTo(
                FormTabElement::class,
                self::FORM_TAB_ELEMENT_UUID,
                FormTabElement::UUID,
            );
    }

    #endregion

    #endregion
}
