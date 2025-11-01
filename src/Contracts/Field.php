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

    #region • FLUENT

    /**
     * Set the append attribute.
     *
     * @param string $append
     *
     * @return static
     */
    public function append(string $append): static;

    /**
     * Set the className attribute.
     *
     * @param string $className
     *
     * @return static
     */
    public function className(string $className): static;

    #endregion

    #endregion
}
