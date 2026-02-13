<?php

namespace Narsil\Cms\Models\Collections;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Narsil\Base\Traits\AuditLoggable;
use Narsil\Base\Traits\Blameable;
use Narsil\Base\Traits\HasDatetimes;
use Narsil\Base\Traits\HasTranslations;
use Narsil\Cms\Traits\HasIdentifier;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class BaseElement extends Model
{
    use Blameable;
    use AuditLoggable;
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
     * The name of the "block elements" relation.
     *
     * @var string
     */
    final public const RELATION_BLOCK_ELEMENTS = 'block_elements';

    /**
     * The name of the "template tab elements" relation.
     *
     * @var string
     */
    final public const RELATION_TEMPLATE_TAB_ELEMENTS = 'template_tab_elements';

    #endregion

    #endregion

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated block elements.
     *
     * @return MorphMany
     */
    final public function block_elements(): MorphMany
    {
        return $this->morphMany(
            BlockElement::class,
            BlockElement::RELATION_BASE,
            BlockElement::BASE_TYPE,
            BlockElement::BASE_ID,
            self::ID
        );
    }

    /**
     * Get the associated template tab elements.
     *
     * @return MorphMany
     */
    final public function template_tab_elements(): MorphMany
    {
        return $this->morphMany(
            TemplateTabElement::class,
            TemplateTabElement::RELATION_BASE,
            TemplateTabElement::BASE_TYPE,
            TemplateTabElement::BASE_ID,
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
