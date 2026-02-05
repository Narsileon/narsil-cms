<?php

namespace Narsil\Cms\Implementations;

#region USE

use Narsil\Cms\Contracts\Menu;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractMenu implements Menu
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return $this->content();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array
     */
    abstract protected function content(): array;

    #endregion
}
