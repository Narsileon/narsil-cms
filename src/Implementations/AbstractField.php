<?php

namespace Narsil\Implementations;

#region USE

use JsonSerializable;
use Narsil\Contracts\Field;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
abstract class AbstractField implements Field, JsonSerializable
{
    #region PROPERTIES

    /**
     * @var array The settings of the field.
     */
    protected array $settings = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return $this->settings;
    }

    #region • FLUENT METHODS

    /**
     * {@inheritDoc}
     */
    final public function className(string $className): static
    {
        $this->settings['className'] = $className;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    final public function type(string $type): static
    {
        $this->settings['type'] = $type;

        return $this;
    }

    #endregion

    #endregion
}
