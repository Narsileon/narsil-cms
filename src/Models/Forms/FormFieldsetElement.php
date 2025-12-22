<?php

namespace Narsil\Models\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Narsil\Traits\HasElement;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormFieldsetElement extends Model
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
            self::ID,
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
    final public const TABLE = 'form_fieldset_element';

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
                FormFieldset::class,
                self::FIELDSET_ID,
                FormFieldset::ID,
            );
    }

    #endregion

    #endregion
}
