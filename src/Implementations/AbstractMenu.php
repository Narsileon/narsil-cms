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
     * The registred extend callbacks.
     *
     * @var callable[]
     */
    protected array $extends = [];

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
        if ($before = $menuItem->before)
        {
            foreach ($this->menuItems as $index => $item)
            {
                if ($item->id === $before)
                {
                    array_splice($this->menuItems, $index, 0, [$menuItem]);

                    return $this;
                }
            }
        }
        else
        {
            $this->menuItems[] = $menuItem;
        }

        return $this;
    }

    public function extend(callable $callback): void
    {
        $this->extends[] = $callback;
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
        foreach ($this->extends as $extend)
        {
            $extend($this);
        }

        $filteredMenuItems = MenuItem::filterByPermissions(collect($this->menuItems));

        return $filteredMenuItems->all();
    }

    #endregion
}
