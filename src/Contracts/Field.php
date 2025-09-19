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
     * Set the append attribute.
     *
     * @param string $append
     *
     * @return static
     */
    public function setAppend(string $append): static;

    /**
     * Set the className attribute.
     *
     * @param string $className
     *
     * @return static
     */
    public function setClassName(string $className): static;

    #endregion

    #endregion
}
