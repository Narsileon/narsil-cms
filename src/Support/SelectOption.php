<?php

namespace Narsil\Support;

#region USE

use Illuminate\Support\Fluent;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SelectOption extends Fluent
{
    #region PUBLIC METHODS

    /**
     * Set the associated id.
     *
     * @param string $id
     *
     * @return static
     */
    final public function id(string $id): static
    {
        $this->set('id', $id);

        return $this;
    }

    /**
     * Set the associated identifier.
     *
     * @param string $identifier
     *
     * @return static
     */
    final public function identifier(string $identifier): static
    {
        $this->set('identifier', $identifier);

        return $this;
    }

    /**
     * Set the icon of the select option.
     *
     * @param string $icon
     *
     * @return static
     */
    final public function optionIcon(string $icon): static
    {
        $this->set('icon', $icon);

        return $this;
    }

    /**
     * Set the label of the select option.
     *
     * @param string|array $label
     *
     * @return static
     */
    final public function optionLabel(string|array $label): static
    {
        $this->set('label', $label);

        return $this;
    }

    /**
     * Set the value of the select option.
     *
     * @param string $value
     *
     * @return static
     */
    final public function optionValue(string $value): static
    {
        $this->set('value', $value);

        return $this;
    }

    #endregion
}
