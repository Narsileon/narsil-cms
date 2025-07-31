<?php

namespace Narsil\Implementations;

#region USE

use Narsil\Contracts\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractField implements Field
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
    public function toArray(): array
    {
        return $this->settings;
    }

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
}
