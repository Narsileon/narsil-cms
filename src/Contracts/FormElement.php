<?php

namespace Narsil\Contracts;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface FormElement
{
    #region PUBLIC METHODS

    /**
     * @return array
     */
    public static function getForm(): array;
    /**
     * @return string
     */
    public static function getIcon(): string;
    /**
     * @return string
     */
    public static function getLabel(): string;

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array;

    /**
     * @param string $className
     *
     * @return static Returns the current object instance.
     */
    public function className(string $className): static;

    #endregion
}
