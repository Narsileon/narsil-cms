<?php

namespace Narsil\Models\Forms;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Arr;
use Narsil\Traits\Blameable;
use Narsil\Traits\HasAuditLogs;
use Narsil\Traits\HasDatetimes;
use Narsil\Traits\HasIdentifier;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class Fieldset extends Model
{
    use Blameable;
    use HasAuditLogs;
    use HasDatetimes;
    use HasIdentifier;
    use HasTranslations;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->translatable = [
            self::NAME,
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

        if ($elements = Arr::get($attributes, self::RELATION_ELEMENTS))
        {
            $this->setRelation(self::RELATION_ELEMENTS, collect($elements));
        }
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'fieldsets';

    #region • COLUMNS

    /**
     * The name of the "handle" column.
     *
     * @var string
     */
    final public const HANDLE = 'handle';

    /**
     * The name of the "id" column.
     *
     * @var string
     */
    final public const ID = 'id';

    /**
     * The name of the "name" column.
     *
     * @var string
     */
    final public const NAME = 'name';

    #endregion

    #region • ATTRIBUTES

    /**
     * The name of the "icon" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_ICON = 'icon';

    #endregion

    #region • COUNTS

    /**
     * The name of the "elements" count.
     *
     * @var string
     */
    final public const COUNT_ELEMENTS = 'elements_count';

    /**
     * The name of the "input" count.
     *
     * @var string
     */
    final public const COUNT_INPUTS = 'input_count';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "elements" relation.
     *
     * @var string
     */
    final public const RELATION_ELEMENTS = 'elements';

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
     * Get the associated inputs.
     *
     * @return MorphToMany
     */
    final public function inputs(): MorphToMany
    {
        return $this
            ->morphedByMany(
                Input::class,
                FieldsetElement::RELATION_ELEMENT,
                FieldsetElement::TABLE,
                FieldsetElement::FIELDSET_ID,
                FieldsetElement::ELEMENT_ID,
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
    public function icon(): Attribute
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
