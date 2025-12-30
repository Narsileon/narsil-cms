<?php

namespace Narsil\Models\Entities;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Narsil\Models\Entities\Entity;
use Narsil\Models\Forms\Form;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityForm extends Pivot
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
    final public const TABLE = 'entity_form';

    #region • COLUMNS

    /**
     * The name of the "entity uuid" column.
     *
     * @var string
     */
    final public const ENTITY_UUID = 'entity_uuid';

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
     * The name of the "entity" relation.
     *
     * @var string
     */
    final public const RELATION_ENTITY = 'entity';

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
     * Get the associated entity.
     *
     * @return BelongsTo
     */
    final public function entity(): BelongsTo
    {
        return $this
            ->belongsTo(
                Entity::class,
                self::ENTITY_UUID,
                Entity::UUID,
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
