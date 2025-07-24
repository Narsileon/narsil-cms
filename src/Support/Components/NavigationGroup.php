<?php

namespace Narsil\Support\Components;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class NavigationGroup extends AbstractComponent
{
    #region CONSTRUCTOR

    /**
     * @param string $id
     *
     * @return void
     */
    public function __construct(string $label)
    {
        $this
            ->setLabel($label);
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * @param array $children
     *
     * @return static Returns the current object instance.
     */
    final public function setChildren(array $children): static
    {
        $this->props['children'] = $children;

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

    #endregion
}
