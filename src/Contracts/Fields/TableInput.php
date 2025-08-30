<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface TableInput extends Contract
{
    #region PUBLIC METHODS

    #region • FLUENT METHODS

    /**
     * @param array $columns
     *
     * @return static Returns the current object instance.
     */
    public function columns(array $columns): static;

    /**
     * @param string $placeholder
     *
     * @return static Returns the current object instance.
     */
    public function placeholder(string $placeholder): static;

    /**
     * @param array $value The default value.
     *
     * @return static Returns the current object instance.
     */
    public function value(array $value): static;

    #endregion

    #endregion
}
