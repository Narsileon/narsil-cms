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
        $key = $this->getKey();
        $table = $this->getTable();

        return !empty($key) ? "$table-$key" : $table;
    }

    #endregion
}
