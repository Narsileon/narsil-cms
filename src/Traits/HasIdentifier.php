<?php

namespace Narsil\Traits;

trait HasIdentifier
{
    #region CONSTANTS

    public const ATTRIBUTE_IDENTIFIER = 'identifier';

    #endregion

    #region ATTRIBUTES

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
