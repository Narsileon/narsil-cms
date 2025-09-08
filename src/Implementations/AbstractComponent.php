<?php

namespace Narsil\Implementations;

#region USE

use JsonSerializable;
use Narsil\Contracts\Block;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
abstract class AbstractComponent implements Block, JsonSerializable
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
