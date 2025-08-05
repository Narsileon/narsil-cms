<?php

namespace Narsil\Traits;

trait Identifiable
{
    #region ATTRIBUTES

    /**
     * @return string
     */
    public function getIdentifierAttribute(): string
    {
        return $this->getTable() . '-' . $this->getKey();
    }

    #endregion
}
