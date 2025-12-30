<?php

namespace Narsil\Models\Forms;

#region USE

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Narsil\Traits\HasTranslations;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormPage extends Model
{
    use HasTranslations;
    use HasUuids;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->primaryKey = self::UUID;

        $this->touches = [
            self::RELATION_FORM,
        ];

        $this->translatable = [
            self::NAME,
        ];

        $this->with = [
            self::RELATION_ELEMENTS,
        ];

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
    final public const TABLE = 'form_pages';

    #region • COLUMNS

    /**
     * The name of the "form id" column.
     *
     * @var string
     */
    final public const FORM_ID = 'form_id';

    /**
     * The name of the "handle" column.
     *
     * @var string
     */
    final public const HANDLE = 'handle';

    /**
     * The name of the "name" column.
     *
     * @var string
     */
    final public const NAME = 'name';

    /**
     * The name of the "position" column.
     *
     * @var string
     */
    final public const POSITION = 'position';

    /**
     * The name of the "uuid" column.
     *
     * @var string
     */
    final public const UUID = 'uuid';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "blocks" relation.
     *
     * @var string
     */
    final public const RELATION_BlOCKS = 'blocks';

    /**
     * The name of the "elements" relation.
     *
     * @var string
     */
    final public const RELATION_ELEMENTS = 'elements';

    /**
     * The name of the "fields" relation.
     *
     * @var string
     */
    final public const RELATION_FIELDS = 'fields';

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
     * Get the associated elements.
     *
     * @return HasMany
     */
    final public function elements(): HasMany
    {
        return $this
            ->hasMany(
                FormPageElement::class,
                FormPageElement::OWNER_UUID,
                self::UUID,
            )
            ->orderBy(FormPageElement::POSITION);
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
                FormPageElement::RELATION_ELEMENT,
                FormPageElement::TABLE,
                FormPageElement::OWNER_UUID,
                FormPageElement::ELEMENT_ID,
            )
            ->using(FormPageElement::class);
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
                FormPageElement::RELATION_ELEMENT,
                FormPageElement::TABLE,
                FormPageElement::OWNER_UUID,
                FormPageElement::ELEMENT_ID,
            )
            ->using(FormPageElement::class);
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
