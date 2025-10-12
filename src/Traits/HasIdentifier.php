<?php

namespace Narsil\Traits;

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
     * @return string
     */
    public function getIdentifierAttribute(): string
    {
        $key = $this->getKey();
        $table = $this->getTable();

        return !empty($key) ? "$table-$key" : $table;
    }

    #endregion
}
