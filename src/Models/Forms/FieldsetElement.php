<?php

namespace Narsil\Models\Forms;

#region USE

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Narsil\Traits\HasElement;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldsetElement extends MorphPivot
{
    use HasElement;
    use HasTranslations;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->primaryKey = self::UUID;
        $this->timestamps = false;

        $this->translatable = [
            self::DESCRIPTION,
            self::NAME,
        ];

        $this->with = [
            self::RELATION_ELEMENT,
        ];

        $this->mergeAppends([
            self::ATTRIBUTE_ICON,
            self::ATTRIBUTE_IDENTIFIER,
        ]);

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
    final public const TABLE = 'fieldset_element';

    #region • COLUMNS

    /**
     * The name of the "fieldset id" column.
     *
     * @var string
     */
    final public const FIELDSET_ID = 'fieldset_id';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "fieldset" relation.
     *
     * @var string
     */
    final public const RELATION_FIELDSET = 'fieldset';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

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

    #endregion

    #endregion
}
