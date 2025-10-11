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
     * @param string $value
     *
     * @return void
     */
    public function __construct(string $label, string $value)
    {
        $this->label($label);
        $this->value($value);
    }

    #endregion

    #region PROPERTIES

    /**
     * The icon of the select option.
     *
     * @var string
     */
    public protected(set) ?string $icon = null;

    /**
     * The identifier of the select option.
     *
     * @var string
     */
    public protected(set) ?string $identifier = null;

    /**
     * The label of the select option.
     *
     * @var string
     */
    public protected(set) string $label = '';

    /**
     * The value of the select option.
     *
     * @var string
     */
    public protected(set) string $value = '';

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return [
            'icon' => $this->icon,
            'identifier' => $this->identifier,
            'label' => $this->label,
            'value' => $this->value,
        ];
    }

    #region • SETTERS

    /**
     * Set the icon of the select option.
     *
     * @param string $icon
     *
     * @return static
     */
    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Set the identifier of the select option.
     *
     * @param string $identifier
     *
     * @return static
     */
    public function identifier(string $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Set the label of the select option.
     *
     * @param string $label
     *
     * @return static
     */
    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Set the value of the select option.
     *
     * @param string $value
     *
     * @return static
     */
    public function value(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    #endregion

    #endregion
}
