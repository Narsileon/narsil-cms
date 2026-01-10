<?php

namespace Narsil\Traits;

#region USE

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Narsil\Interfaces\IElement;

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
     * Get the associated base.
     *
     * @return MorphTo
     */
    final public function base(): MorphTo
    {
        return $this->morphTo(
            IElement::RELATION_BASE,
            IElement::BASE_TYPE,
            IElement::BASE_ID,
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
                return $this->{IElement::RELATION_BASE}->{IElement::ATTRIBUTE_ICON} ?? null;
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
                $base = $this->{IElement::RELATION_BASE};

                $key = $base->getKey();
                $table = $base->getTable();

                return !empty($key) ? "$table-$key" : $table;
            },
        );
    }

    #endregion

    #endregion
}
