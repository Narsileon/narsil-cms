<?php

namespace App\Support;

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
        $this->href($href);
        $this->label($label);
    }

    #endregion

    #region CONSTANTS

    /**
     * @var string The name of "href" prop.
     */
    final public const HREF = 'href';
    /**
     * @var string The name of "icon" prop.
     */
    final public const ICON = 'icon';
    /**
     * @var string The name of "label" prop.
     */
    final public const LABEL = 'label';

    #endregion

    #region PROPERTIES

    /**
     * @var array<string,mixed>
     */
    protected array $props = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * Gets the input prop.
     *
     * @return array Returns the props of the input.
     */
    final public function get(): array
    {
        return $this->props;
    }

    /**
     * Sets the href prop.
     *
     * @param string $href
     *
     * @return static Returns the current object instance.
     */
    final public function href(string $href): static
    {
        $this->props[self::HREF] = $href;

        return $this;
    }

    /**
     * Sets the icon prop.
     *
     * @param string $icon
     *
     * @return static Returns the current object instance.
     */
    final public function icon(string $icon): static
    {
        $this->props[self::ICON] = $icon;

        return $this;
    }

    /**
     * Sets the label prop.
     *
     * @param string $label
     *
     * @return static Returns the current object instance.
     */
    final public function label(string $label): static
    {
        $this->props[self::LABEL] = $label;

        return $this;
    }

    #endregion
}
