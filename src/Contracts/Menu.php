<?php

declare(strict_types=1);

namespace Narsil\Cms\Contracts;

#region USE

use JsonSerializable;
use Narsil\Cms\Support\MenuItem;

#endregion

interface Menu extends JsonSerializable
{
    #region PUBLIC METHODS

    /**
     * @param MenuItem $menuItem
     *
     * @return self
     */
    public function add(MenuItem $menuItem): self;

    /**
     * @param callable $callback
     *
     * @return self
     */
    public function extend(callable $callback): void;

    /**
     * @param string $id
     *
     * @return self
     */
    public function remove(string $id): self;

    #endregion
}
