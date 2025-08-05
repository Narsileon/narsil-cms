<?php

namespace Narsil\Interfaces;

interface HasIdentifier
{
    #region CONSTANTS

    public const IDENTIFIER = 'identifier';

    #endregion

    #region ATTRIBUTES

    /**
     * @return string
     */
    public function getIdentifierAttribute(): string;

    #endregion
}
