<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Narsil\Interfaces\IHasElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait HasElement
{
    use HasIdentifier;
    use HasUuids;

    #region PUBLIC METHODS

    #region • RELATIONSHIPS

    /**
     * Get the associated element.
     *
     * @return MorphTo
     */
    final public function element(): MorphTo
    {
        return $this->morphTo(
            IHasElement::RELATION_ELEMENT,
            IHasElement::ELEMENT_TYPE,
            IHasElement::ELEMENT_ID,
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
    final protected function icon(): Attribute
    {
        return Attribute::make(
            get: function ()
            {
                return $this->{IHasElement::RELATION_ELEMENT}->{IHasElement::ATTRIBUTE_ICON} ?? null;
            },
        );
    }

    /**
     * Get the "identifier" attribute.
     *
     * @return string
     */
    final protected function identifier(): Attribute
    {
        return Attribute::make(
            get: function ()
            {
                $element = $this->{IHasElement::RELATION_ELEMENT};

                $key = $element->getKey();
                $table = $element->getTable();

                return !empty($key) ? "$table-$key" : $table;
            },
        );
    }

    #endregion

    #endregion
}
