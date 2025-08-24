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
     * @return array
     */
    public function getColumns(): array;

    /**
     * @return array
     */
    public function getColumnOrder(): array;

    /**
     * @return array
     */
    public function getColumnVisibility(): array;

    /**
     * @return array
     */
    public function getRoutes(): array;

    #endregion
}
