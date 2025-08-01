<?php

namespace Narsil\Traits;

trait Identifiable
{
    #region PUBLIC METHODS

    /**
     * @return string
     */
    public function getIdentifierAttribute(): string
    {
        return $this->getTable() . '-' . $this->getKey();
    }

    #endregion
}
