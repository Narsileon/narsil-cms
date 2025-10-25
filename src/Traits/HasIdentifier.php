<?php

namespace Narsil\Traits;

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

    #region ACCESSORS

    /**
     * Get the associated identifier.
     *
     * @return string
     */
    final public function getIdentifierAttribute(): string
    {
        $key = $this->getKey();
        $table = $this->getTable();

        return !empty($key) ? "$table-$key" : $table;
    }

    #endregion
}
