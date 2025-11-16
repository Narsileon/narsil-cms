<?php

namespace Narsil\Implementations;

#region USE

use Illuminate\Support\Fluent;
use Narsil\Contracts\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractField extends Fluent implements Field
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    final public function append(string $append): static
    {
        $this->set('append', $append);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function readOnly(bool $readOnly): static
    {
        $this->set('readOnly', $readOnly);

        return $this;
    }

    #endregion
}
