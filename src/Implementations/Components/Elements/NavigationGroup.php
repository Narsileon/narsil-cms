<?php

namespace Narsil\Implementations\Components\Elements;

#region USE

use Narsil\Implementations\Components\Elements\AbstractComponentElement;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class NavigationGroup extends AbstractComponentElement
{
    #region CONSTRUCTOR

    /**
     * @param string $id
     *
     * @return void
     */
    public function __construct(string $label)
    {
        $this->label($label);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * @param array $children
     *
     * @return static Returns the current object instance.
     */
    final public function children(array $children): static
    {
        $this->props['children'] = $children;

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

    #endregion
}
