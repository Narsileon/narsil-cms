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
        $this->label = $label;
        $this->value = $value;
    }

    #endregion

    #region PROPERTIES

    /**
     * The icon of the select option.
     *
     * @var string
     */
    protected ?string $icon = null;

    /**
     * The identifier of the select option.
     *
     * @var string
     */
    protected ?string $identifier = null;

    /**
     * The label of the select option.
     *
     * @var string
     */
    protected string $label = '';

    /**
     * The value of the select option.
     *
     * @var string
     */
    protected string $value = '';

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

    #region • GETTERS

    /**
     * Get the icon of the select option.
     *
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * Get the identifier of the select option.
     *
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    /**
     * Get the label of the select option.
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Get the value of the select option.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    #endregion

    #region • SETTERS

    /**
     * Set the icon of the select option.
     *
     * @param string $icon
     *
     * @return static
     */
    public function setIcon(string $icon): static
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
    public function setIdentifier(string $identifier): static
    {
        $this->identifier = $identifier;

        return $this;
    }

    /**
     * Sets the label of the select option.
     *
     * @param string $label
     *
     * @return static
     */
    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Sets the value of the select option.
     *
     * @param string $value
     *
     * @return static
     */
    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }


    #endregion

    #endregion
}
