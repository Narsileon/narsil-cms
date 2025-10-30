<?php

namespace Narsil\Contracts\Fields;

#region USE

use Narsil\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface TableField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the columns.
     *
     * @param array $columns
     *
     * @return static
     */
    public function columns(array $columns): static;

    /**
     * Set the default value.
     *
     * @param array $value
     *
     * @return static
     */
    public function defaultValue(array $value): static;

    /**
     * Set the placeholder attribute.
     *
     * @param string $placeholder
     *
     * @return static
     */
    public function placeholder(string $placeholder): static;

    #endregion
}
