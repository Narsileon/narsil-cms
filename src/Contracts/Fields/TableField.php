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

    #region • SETTERS

    /**
     * Set the columns.
     *
     * @param array $columns
     *
     * @return static
     */
    public function setColumns(array $columns): static;

    /**
     * Set the default value.
     *
     * @param array $value
     *
     * @return static
     */
    public function setDefaultValue(array $value): static;

    /**
     * Set the placeholder attribute.
     *
     * @param string $placeholder
     *
     * @return static
     */
    public function setPlaceholder(string $placeholder): static;

    #endregion

    #endregion
}
