<?php

namespace Narsil\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
trait HasIdentifier
{
    #region CONSTANTS

    #region • ATTRIBUTES

    /**
     * The name of the "identifier" attribute.
     *
     * @var string
     */
    final public const ATTRIBUTE_IDENTIFIER = 'identifier';

    #endregion

    #endregion

    #region PROTECTED METHODS

    #region • ACCESSORS

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
                $key = $this->getKey();
                $table = $this->getTable();

                return !empty($key) ? "$table-$key" : $table;
            },
        );
    }

    #endregion

    #endregion
}
