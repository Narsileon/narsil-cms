<?php

namespace Narsil\Implementations;

#region USE

use JsonSerializable;
use Narsil\Contracts\Component;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractComponent implements Component, JsonSerializable
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return [
            'content' => $this->content(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array
     */
    abstract protected function content(): array;

    #endregion
}
