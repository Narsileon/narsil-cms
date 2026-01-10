<?php

namespace Narsil\Models\Collections;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Narsil\Models\Forms\FieldsetElement;
use Narsil\Models\Forms\FormTabElement;
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
abstract class BaseElement extends Model
{
    use Blameable;
    use HasAuditLogs;
    use HasDatetimes;
    use HasIdentifier;
    use HasTranslations;

    #region CONSTANTS

    #region • COLUMNS

    /**
     * The name of the "description" column.
     *
     * @var string
     */
    final public const DESCRIPTION = 'description';

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
     * The name of the "label" column.
     *
     * @var string
     */
    final public const LABEL = 'label';

    #endregion

    #region • ATTRIBUTES

    /**
     * The name of the "icon" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_ICON = 'icon';

    #endregion

    #region • RELATIONS

    /**
     * The name of the "fieldset elements" relation.
     *
     * @var string
     */
    final public const RELATION_FIELDSET_ELEMENTS = 'fieldset_elements';

    /**
     * The name of the "form tab elements" relation.
     *
     * @var string
     */
    final public const RELATION_FORM_TAB_ELEMENTS = 'form_tab_elements';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated fieldset elements.
     *
     * @return MorphMany
     */
    final public function fieldset_elements(): MorphMany
    {
        return $this->morphMany(
            FieldsetElement::class,
            FieldsetElement::RELATION_BASE,
            FieldsetElement::BASE_TYPE,
            FieldsetElement::BASE_ID,
            self::ID
        );
    }

    /**
     * Get the associated form tab elements.
     *
     * @return MorphMany
     */
    final public function form_tab_elements(): MorphMany
    {
        return $this->morphMany(
            FormTabElement::class,
            FormTabElement::RELATION_BASE,
            FormTabElement::BASE_TYPE,
            FormTabElement::BASE_ID,
            self::ID
        );
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
    abstract protected function icon(): Attribute;

    #endregion

    #endregion
}
