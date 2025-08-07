<?php

namespace Narsil\Contracts;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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
    /**
     * @return string
     */
    public static function getLabel(): string;

    #endregion

    #region FLUENT METHODS

    /**
     * @param string $className
     *
     * @return static Returns the current object instance.
     */
    public function className(string $className): static;

    #endregion
}
