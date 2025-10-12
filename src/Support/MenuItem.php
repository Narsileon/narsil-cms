<?php

namespace Narsil\Support;

#region USE

use JsonSerializable;
use Narsil\Enums\Forms\MethodEnum;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class MenuItem implements JsonSerializable
{
    #region PROPERTIES

    /**
     * The group of the menu item.
     *
     * @var ?string
     */
    protected ?string $group = null;

    /**
     * The href of the anchor.
     *
     * @var ?string
     */
    protected ?string $href = null;

    /**
     * The label of the menu item.
     *
     * @var ?string
     */
    protected ?string $label = null;

    /**
     * The icon of the menu item.
     *
     * @var ?string
     */
    protected ?string $icon = null;

    /**
     * The method of the anchor.
     *
     * @var ?string
     */
    protected ?string $method = MethodEnum::GET->value;

    /**
     * The modal toggle.
     *
     * @var ?boolean
     */
    protected ?bool $modal = null;

    /**
     * The target of the anchor.
     *
     * @var ?string
     */
    protected ?string $target = null;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return array_filter([
            'group' => $this->getGroup(),
            'href' => $this->getHref(),
            'icon' => $this->getIcon(),
            'label' => $this->getLabel(),
            'method' => $this->getMethod(),
            'modal' => $this->getModal(),
            'target' => $this->getTarget(),
        ]);
    }

    #region • GETTERS

    /**
     * Get the group of the menu item.
     *
     * @return string|null
     */
    final public function getGroup(): ?string
    {
        return $this->group;
    }

    /**
     * Get the href of the anchor.
     *
     * @return string|null
     */
    final public function getHref(): ?string
    {
        return $this->href;
    }

    /**
     * Get the icon of the menu item.
     *
     * @return string|null
     */
    final public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * Get the label of the menu item.
     *
     * @return string|null
     */
    final public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Get the method of the anchor.
     *
     * @return string|null
     */
    final public function getMethod(): ?string
    {
        return $this->method;
    }

    /**
     * Get the modal toggle.
     *
     * @return boolean|null
     */
    final public function getModal(): ?bool
    {
        return $this->modal;
    }

    /**
     * Get the target of the anchor.
     *
     * @return string|null
     */
    final public function getTarget(): ?string
    {
        return $this->target;
    }

    #endregion

    #region • SETTERS

    /**
     * Set the group of the menu item.
     *
     * @param string $group
     *
     * @return static
     */
    final public function setGroup(string $group): static
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Set the href of the anchor.
     *
     * @param string $href
     *
     * @return static
     */
    final public function setHref(string $href): static
    {
        $this->href = $href;

        return $this;
    }

    /**
     * Set the icon of the menu item.
     *
     * @param string $icon
     *
     * @return static
     */
    final public function setIcon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Set the label of the menu item.
     *
     * @param string $label
     *
     * @return static
     */
    final public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Set the method of the anchor.
     *
     * @param MethodEnum $method
     *
     * @return static
     */
    final public function setMethod(MethodEnum $method): static
    {
        $this->method = $method->value;

        return $this;
    }

    /**
     * Set the modal toggle.
     *
     * @param boolean $modal
     *
     * @return static
     */
    final public function setModal(bool $modal): static
    {
        $this->modal = $modal;

        return $this;
    }

    /**
     * Set the target of the anchor.
     *
     * @param string $target
     *
     * @return static
     */
    final public function setTarget(string $target): static
    {
        $this->target = $target;

        return $this;
    }

    #endregion

    #endregion
}
