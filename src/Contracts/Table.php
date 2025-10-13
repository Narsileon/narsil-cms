<?php

namespace Narsil\Contracts;

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface Table
{
    #region PUBLIC METHODS

    /**
     * Get the columns of the table.
     *
     * @return array
     */
    public function getColumns(): array;

    /**
     * Get the column order of the table.
     *
     * @return array
     */
    public function getColumnOrder(): array;

    /**
     * Get the column visibility of the table.
     *
     * @return array
     */
    public function getColumnVisibility(): array;

    /**
     * Get the routes associated with the table.
     *
     * @return array
     */
    public function getRoutes(): array;

    #endregion
}
