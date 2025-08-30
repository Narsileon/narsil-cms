<?php

namespace Narsil\Contracts;

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface Field
{
    #region PUBLIC METHODS

    /**
     * @param string|null $prefix
     *
     * @return array
     */
    public static function getForm(?string $prefix = null): array;

    /**
     * @return string
     */
    public static function getIcon(): string;

    #region • FLUENT METHODS

    /**
     * @param string $className
     *
     * @return static Returns the current object instance.
     */
    public function className(string $className): static;

    #endregion

    #endregion
}
