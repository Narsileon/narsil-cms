<?php

namespace Narsil\Implementations;

#region USE

use JsonSerializable;
use Narsil\Contracts\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractField implements Field, JsonSerializable
{
    #region PROPERTIES

    /**
     * The props of the field.
     *
     * @var array The props of the field.
     */
    protected array $props = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return $this->props;
    }

    #region • SETTERS

    /**
     * {@inheritDoc}
     */
    final public function setAppend(string $append): static
    {
        $this->props['append'] = $append;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function setClassName(string $className): static
    {
        $this->props['className'] = $className;

        return $this;
    }

    #endregion

    #endregion
}
