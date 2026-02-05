<?php

namespace Narsil\Cms\Models\Forms;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Narsil\Cms\Models\Collections\BaseElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Fieldset extends BaseElement
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->translatable = [
            self::DESCRIPTION,
            self::LABEL,
        ];

        $this->with = [
            self::RELATION_ELEMENTS,
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
    final public const TABLE = 'fieldsets';

    #region • COUNTS

    /**
     * The name of the "elements" count.
     *
     * @var string
     */
    final public const COUNT_ELEMENTS = 'elements_count';

    /**
     * The name of the "fieldsets" count.
     *
     * @var string
     */
    final public const COUNT_FIELDSETS = 'fieldsets_count';

    /**
     * The name of the "inputs" count.
     *
     * @var string
     */
    final public const COUNT_INPUTS = 'inputs_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "elements" relation.
     *
     * @var string
     */
    final public const RELATION_ELEMENTS = 'elements';

    /**
     * The name of the "fieldsets" relation.
     *
     * @var string
     */
    final public const RELATION_FIELDSETS = 'fieldsets';

    /**
     * The name of the "inputs" relation.
     *
     * @var string
     */
    final public const RELATION_INPUTS = 'inputs';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated elements.
     *
     * @return HasMany
     */
    final public function elements(): HasMany
    {
        return $this
            ->hasMany(
                FieldsetElement::class,
                FieldsetElement::OWNER_ID,
                self::ID,
            )
            ->orderBy(FieldsetElement::POSITION);
    }

    /**
     * Get the associated fieldsets.
     *
     * @return MorphToMany
     */
    final public function fieldsets(): MorphToMany
    {
        return $this
            ->morphedByMany(
                Fieldset::class,
                FieldsetElement::RELATION_BASE,
                FieldsetElement::TABLE,
                FieldsetElement::OWNER_ID,
                FieldsetElement::BASE_ID,
            )
            ->using(FieldsetElement::class);
    }


    /**
     * Get the associated inputs.
     *
     * @return MorphToMany
     */
    final public function inputs(): MorphToMany
    {
        return $this
            ->morphedByMany(
                Input::class,
                FieldsetElement::RELATION_BASE,
                FieldsetElement::TABLE,
                FieldsetElement::OWNER_ID,
                FieldsetElement::BASE_ID,
            )
            ->using(FieldsetElement::class);
    }

    #endregion

    #endregion

    #region PROTECTED METHODS

    #region • ACCESSORS

    /**
     * Get the "icon" attribute.
     *
     * @return string
     */
    protected function icon(): Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return 'fieldset';
            },
        );
    }

    #endregion

    #endregion
}
