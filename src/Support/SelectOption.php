<?php

namespace Narsil\Support;

#region USE

use JsonSerializable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SelectOption implements JsonSerializable
{
    #region CONSTRUCTOR

    /**
     * @param string|array $label
     * @param string $value
     *
     * @return void
     */
    public function __construct(string|array $label, string $value)
    {
        $this->setLabel($label);
        $this->setValue($value);
    }

    #endregion

    #region PROPERTIES

    /**
     * The icon of the select option.
     *
     * @var string
     */
    private ?string $icon = null;

    /**
     * The id of the select option.
     *
     * @var string
     */
    private ?string $id = null;

    /**
     * The identifier of the select option.
     *
     * @var string
     */
    private ?string $identifier = null;

    /**
     * The label of the select option.
     *
     * @var string|array
     */
    private string|array $label = '';

    /**
     * The value of the select option.
     *
     * @var string
     */
    private string $value = '';

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return array_filter([
            'icon' => $this->getIcon(),
            'id' => $this->getId(),
            'identifier' => $this->getIdentifier(),
            'label' => $this->getLabel(),
            'value' => $this->getValue(),
        ]);
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
     * Get the id of the select option.
     *

     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
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
     * @return string|array
     */
    public function getLabel(): string|array
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
     * Set the id of the select option.
     *
     * @param string $id
     *
     * @return static
     */
    public function setId(string $id): static
    {
        $this->id = $id;

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
     * Set the label of the select option.
     *
     * @param string|array $label
     *
     * @return static
     */
    public function setLabel(string|array $label): static
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
    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    #endregion

    #endregion
}
