<?php

namespace Narsil\Models\Structures;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Models\AbstractCondition;
use Narsil\Models\Structures\BlockElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockElementCondition extends AbstractCondition
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
    final public const TABLE = 'block_element_conditions';

    #region • COLUMNS

    /**
     * The name of the "block element uuid" column.
     *
     * @var string
     */
    final public const BLOCK_ELEMENT_UUID = 'block_element_uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "block element" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCK_ELEMENT = 'block_element';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated block element.
     *
     * @return BelongsTo
     */
    final public function block_element(): BelongsTo
    {
        return $this
            ->belongsTo(
                BlockElement::class,
                self::BLOCK_ELEMENT_UUID,
                BlockElement::UUID,
            );
    }

    #endregion

    #endregion
}
