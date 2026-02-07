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
    public function add(MenuItem $menuItem): self
    {
        $this->menuItems[] = $menuItem;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return $this->content();
    }

    /**
     * {@inheritDoc}
     */
    public function remove(string $id): self
    {
        $this->menuItems = array_values(array_filter($this->menuItems, function (MenuItem $menuItem) use ($id)
        {
            return $menuItem->get('id') !== $id;
        }));

        return $this;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array
     */
    protected function content(): array
    {
        $filteredMenuItems = MenuItem::filterByPermissions(collect($this->menuItems));

        return $filteredMenuItems->all();
    }

    #endregion
}
