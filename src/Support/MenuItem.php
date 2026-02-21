<?php

namespace Narsil\Cms\Support;

#region USE

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Fluent;
use Illuminate\Support\Str;
use Narsil\Base\Enums\RequestMethodEnum;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class MenuItem extends Fluent
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct(string $id)
    {
        $this->id($id);
        $this->method(RequestMethodEnum::GET->value);
    }

    #endregion

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
     * Set the position of the menu item.
     *
     * @param string $before
     *
     * @return static
     */
    final public function before(string $before): static
    {
        $this->set('before', $before);

        return $this;
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
     * Set the id of the menu item.
     *
     * @param string $id
     *
     * @return static
     */
    final public function id(string $id): static
    {
        $this->set('id', $id);

        return $this;
    }

    /**
     * Set the label of the menu item.
     *
     * @param string $label
     *
     * @return static
     */
    final public function label(string $label, bool $upperFirst = true): static
    {
        $this->set('label', $upperFirst ? Str::ucfirst($label) : $label);

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
     * Set the parameters of the menu items.
     *
     * @param array $parameters
     *
     * @return static
     */
    final public function parameters(array $parameters): static
    {
        $this->set('parameters', $parameters);

        return $this;
    }

    /**
     * Set the associated permissions.
     *
     * @param string[] $permissions
     *
     * @return static
     */
    final public function permissions(array $permissions): static
    {
        $this->set('permissions', $permissions);

        return $this;
    }

    /**
     * Set the route of the menu items.
     *
     * @param string $route
     *
     * @return static
     */
    final public function route(string $route): static
    {
        $this->set('route', $route);

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
