<?php

namespace Narsil\Implementations\Components\Elements;

#region USE

use Narsil\Enums\Forms\MethodEnum;
use Narsil\Implementations\Components\Elements\AbstractComponentElement;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class NavigationItem extends AbstractComponentElement
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
            ->href($href)
            ->label($label)
            ->method(MethodEnum::GET);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * @param string $href
     *
     * @return static Returns the current object instance.
     */
    final public function href(string $href): static
    {
        $this->props['href'] = $href;

        return $this;
    }

    /**
     * @param string $icon
     *
     * @return static Returns the current object instance.
     */
    final public function icon(string $icon): static
    {
        $this->props['icon'] = $icon;

        return $this;
    }

    /**
     * @param string $label
     *
     * @return static Returns the current object instance.
     */
    final public function label(string $label): static
    {
        $this->props['label'] = $label;

        return $this;
    }

    /**
     * @param MethodEnum $method
     *
     * @return static Returns the current object instance.
     */
    final public function method(MethodEnum $method): static
    {
        $this->props['method'] = $method->value;

        return $this;
    }

    /**
     * @param boolean $modal
     *
     * @return static Returns the current object instance.
     */
    final public function modal(bool $modal): static
    {
        $this->props['modal'] = $modal;

        return $this;
    }

    #endregion
}
