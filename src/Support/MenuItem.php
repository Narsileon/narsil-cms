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
     * @var string
     */
    protected ?string $group = null;

    /**
     * @var string
     */
    protected ?string $href = null;

    /**
     * @var string
     */
    protected ?string $label = null;

    /**
     * @var string
     */
    protected ?string $icon = null;

    /**
     * @var string
     */
    protected ?string $method = MethodEnum::GET->value;

    /**
     * @var string
     */
    protected ?bool $modal = null;

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
        ];
    }

    #region • FLUENT METHODS

    /**
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
     * @param boolean $modal
     *
     * @return static
     */
    final public function modal(bool $modal): static
    {
        $this->modal = $modal;

        return $this;
    }

    #endregion

    #endregion
}
