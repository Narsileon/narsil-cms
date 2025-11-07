<?php

namespace Narsil\Support;

#region USE

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Fluent;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MenuItem extends Fluent
{
    #region PUBLIC METHODS

    /**
     * Filters the menu items by permissions.
     *
     * @param Collection<MenuItem> $collection
     *
     * @return Collection
     */
    final public static function filterByPermissions(Collection $collection): Collection
    {
        /**
         * @var User
         */
        $user = Auth::user();

        return $collection
            ->filter(function (MenuItem $item) use ($user)
            {
                $permissions = $item->get('permissions', []);

                if (empty($permissions))
                {
                    return true;
                }

                if (!$user)
                {
                    return false;
                }

                foreach ($permissions as $permission)
                {
                    if ($user->can($permission))
                    {
                        return true;
                    }
                    if (!$user->hasPermission($permission))
                    {
                        return false;
                    }
                }

                return true;
            })
            ->values();
    }

    /**
     * Set the group of the menu item.
     *
     * @param string $group
     *
     * @return static
     */
    final public function group(string $group): static
    {
        $this->set('group', $group);

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
        $this->set('href', $href);

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
        $this->set('icon', $icon);

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
        $this->set('label', $label);

        return $this;
    }

    /**
     * Set the method of the anchor.
     *
     * @param string $method
     *
     * @return static
     */
    final public function method(string $method): static
    {
        $this->set('method', $method);

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
        $this->set('modal', $modal);

        return $this;
    }

    /**
     * Set the associated permissions.
     *
     * @param array<string> $permissions
     *
     * @return static
     */
    final public function permissions(array $permissions): static
    {
        $this->set('permissions', $permissions);

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
        $this->set('target', $target);

        return $this;
    }

    #endregion
}
