<?php

namespace Narsil\Interfaces;

interface HasIdentifier
{
    #region CONSTANTS

    public const IDENTIFIER = 'identifier';

    #endregion

    #region PUBLIC METHODS

    /**
     * @return string
     */
    public function getIdentifierAttribute(): string;

    #endregion
}
