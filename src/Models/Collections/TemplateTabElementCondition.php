<?php

namespace Narsil\Cms\Models\Collections;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Cms\Models\AbstractCondition;
use Narsil\Cms\Models\Collections\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateTabElementCondition extends AbstractCondition
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
    final public const TABLE = 'template_tab_element_conditions';

    #region • COLUMNS

    /**
     * The name of the "template tab element uuid" column.
     *
     * @var string
     */
    final public const TEMPLATE_TAB_ELEMENT_UUID = 'template_tab_element_uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "template tab element" relation.
     *
     * @var string
     */
    final public const RELATION_TEMPLATE_TAB_ELEMENT = 'template_tab_element';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated template tab element.
     *
     * @return BelongsTo
     */
    final public function template_tab_element(): BelongsTo
    {
        return $this
            ->belongsTo(
                TemplateTabElement::class,
                self::TEMPLATE_TAB_ELEMENT_UUID,
                TemplateTabElement::UUID,
            );
    }

    #endregion

    #endregion
}
