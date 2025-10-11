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
    public protected(set) ?string $group = null;

    /**
     * The href of the anchor.
     *
     * @var ?string
     */
    public protected(set) ?string $href = null;

    /**
     * The label of the menu item.
     *
     * @var ?string
     */
    public protected(set) ?string $label = null;

    /**
     * The icon of the menu item.
     *
     * @var ?string
     */
    public protected(set) ?string $icon = null;

    /**
     * The method of the anchor.
     *
     * @var ?string
     */
    public protected(set) ?string $method = MethodEnum::GET->value;

    /**
     * The modal toggle.
     *
     * @var ?boolean
     */
    public protected(set) ?bool $modal = null;

    /**
     * The target of the anchor.
     *
     * @var ?string
     */
    public protected(set) ?string $target = null;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return [
            'group' => $this->group,
            'href' => $this->href,
            'icon' => $this->icon,
            'label' => $this->label,
            'method' => $this->method,
            'modal' => $this->modal,
            'target' => $this->target
        ];
    }

    #region • SETTERS

    /**
     * Set the group of the menu item.
     *
     * @param string $group
     *
     * @return static
     */
    final public function group(string $group): static
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
    final public function href(string $href): static
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
    final public function icon(string $icon): static
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
    final public function label(string $label): static
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
    final public function method(MethodEnum $method): static
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
    final public function modal(bool $modal): static
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
    final public function target(string $target): static
    {
        $this->target = $target;

        return $this;
    }

    #endregion

    #endregion
}
