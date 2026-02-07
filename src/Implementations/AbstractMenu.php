<?php

namespace Narsil\Cms\Implementations;

#region USE

use Narsil\Cms\Contracts\Menu;
use Narsil\Cms\Support\MenuItem;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractMenu implements Menu
{
    #region PROPERTIES

    /**
     * The registred menu items.
     *
     * @var MenuItem[]
     */
    protected array $menuItems = [];

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return $this->content();
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array
     */
    abstract protected function content(): array;

    /**
     * {@inheritDoc}
     */
    public function add(MenuItem $menuItem): self
    {
        $this->menuItems[] = $menuItem;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function remove(string $id): self
    {
        return $this;
    }

    #endregion
}
