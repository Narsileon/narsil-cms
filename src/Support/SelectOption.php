<?php

namespace Narsil\Support;

#region USE

use JsonSerializable;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class SelectOption implements JsonSerializable
{
    #region CONSTRUCTOR

    /**
     * @param string $label
     * @param mixed $value
     *
     * @return void
     */
    public function __construct(string $label, mixed $value)
    {
        $this->option = [
            'label' => $label,
            'value' => $value,
        ];
    }

    #endregion

    #region PROPERTIES

    /**
     * @var array The array representation of the option.
     */
    protected array $option;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return $this->option;
    }

    #endregion

    #region FLUENT METHODS

    /**
     * Sets the icon.
     *
     * @param string $icon
     *
     * @return static
     */
    public function icon(string $icon): static
    {
        $this->option['icon'] = $icon;

        return $this;
    }

    /**
     * Sets the identifier.
     *
     * @param string $identifier
     *
     * @return static
     */
    public function identifier(string $identifier): static
    {
        $this->option['identifier'] = $identifier;

        return $this;
    }

    #endregion
}
