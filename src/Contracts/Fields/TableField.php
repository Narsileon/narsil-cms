<?php

namespace Narsil\Cms\Contracts\Fields;

#region USE

use Narsil\Cms\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @see vendor/narsil/cms/config/narsil/bindings/fields.php
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

    #endregion
}
