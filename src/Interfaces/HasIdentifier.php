<?php

namespace Narsil\Interfaces;

interface HasIdentifier
{
    #region CONSTANTS

    public const ATTRIBUTE_IDENTIFIER = 'identifier';

    #endregion

    #region ATTRIBUTES

    /**
     * @return string
     */
    public function getIdentifierAttribute(): string;

    #endregion
}
