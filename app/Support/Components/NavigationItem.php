<?php

namespace App\Support\Components;

#region USE

use App\Enums\Forms\MethodEnum;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class NavigationItem
{
    #region CONSTRUCTOR

    /**
     * @param string $id
     *
     * @return void
     */
    public function __construct(string $href, string $label)
    {
        $this
            ->setHref($href)
            ->setLabel($label)
            ->setMethod(MethodEnum::GET);
    }

    #endregion

    #region PROPERTIES

    /**
     * @var array<string,mixed>
     */
    protected array $props = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * @return array Returns the props.
     */
    final public function get(): array
    {
        return $this->props;
    }

    /**
     * @param string $href
     *
     * @return static Returns the current object instance.
     */
    final public function setHref(string $href): static
    {
        $this->props['href'] = $href;

        return $this;
    }

    /**
     * @param string $icon
     *
     * @return static Returns the current object instance.
     */
    final public function setIcon(string $icon): static
    {
        $this->props['icon'] = $icon;

        return $this;
    }

    /**
     * @param string $label
     *
     * @return static Returns the current object instance.
     */
    final public function setLabel(string $label): static
    {
        $this->props['label'] = $label;

        return $this;
    }

    /**
     * @param MethodEnum $method
     *
     * @return static Returns the current object instance.
     */
    final public function setMethod(MethodEnum $method): static
    {
        $this->props['method'] = $method->value;

        return $this;
    }

    /**
     * @param boolean $modal
     *
     * @return static Returns the current object instance.
     */
    final public function setModal(bool $modal): static
    {
        $this->props['modal'] = $modal;

        return $this;
    }

    #endregion
}
