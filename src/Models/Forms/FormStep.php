<?php

namespace Narsil\Models\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Narsil\Traits\HasTranslations;
use Narsil\Traits\HasUuidKey;
use Narsil\Traits\IsOrderable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormStep extends Model
{
    use HasTranslations;
    use HasUuidKey;
    use IsOrderable;

    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(array $attributes = [])
    {
        $this->table = self::TABLE;

        $this->touches = [
            self::RELATION_FORM,
        ];

        $this->translatable = [
            self::DESCRIPTION,
            self::LABEL,
        ];

        $this->with = [
            self::RELATION_ELEMENTS,
        ];

        parent::__construct($attributes);
    }

    #endregion

    #region CONSTANTS

    /**
     * The table associated with the model.
     *
     * @var string
     */
    final public const TABLE = 'form_steps';

    #region • COLUMNS

    /**
     * The name of the "description" column.
     *
     * @var string
     */
    final public const DESCRIPTION = 'description';

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
     * The name of the "label" column.
     *
     * @var string
     */
    final public const LABEL = 'label';

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
                FormStepElement::class,
                FormStepElement::OWNER_UUID,
                self::UUID,
            )
            ->orderBy(FormStepElement::POSITION);
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
                FormStepElement::RELATION_BASE,
                FormStepElement::TABLE,
                FormStepElement::OWNER_UUID,
                FormStepElement::BASE_ID,
            )
            ->using(FormStepElement::class);
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
                FormStepElement::RELATION_BASE,
                FormStepElement::TABLE,
                FormStepElement::OWNER_UUID,
                FormStepElement::BASE_ID,
            )
            ->using(FormStepElement::class);
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
