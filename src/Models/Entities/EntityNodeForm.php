<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Narsil\Models\Forms\Form;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityNodeForm extends Pivot
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
    final public const TABLE = 'entity_node_form';

    #region • COLUMNS

    /**
     * The name of the "entity field uuid" column.
     *
     * @var string
     */
    final public const ENTITY_NODE_UUID = 'entity_node_uuid';

    /**
     * The name of the "form id" column.
     *
     * @var string
     */
    final public const FORM_ID = 'form_id';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "entity field" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITY_NODE = 'entity_node';

    /**
     * The name of the "form" relation.
     *
     * @var string
     */
    final public const RELATION_FORM = 'form';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated entity node.
     *
     * @return BelongsTo
     */
    final public function entity_node(): BelongsTo
    {
        return $this
            ->belongsTo(
                EntityNode::class,
                self::ENTITY_NODE_UUID,
                EntityNode::UUID,
            );
    }

    /**
     * Get the associated form.
     *
     * @return BelongsTo
     */
    final public function form(): BelongsTo
    {
        return $this
            ->belongsTo(
                Form::class,
                self::FORM_ID,
                Form::ID,
            );
    }

    #endregion

    #endregion
}
