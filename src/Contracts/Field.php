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
     * @return void
     */
    public static function bootTranslations(): void;

    /**
     * @param string|null $prefix
     *
     * @return array
     */
    public static function getForm(?string $prefix = null): array;

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
     * Set the read only attribute.
     *
     * @param boolean $readOnly
     *
     * @return static
     */
    public function readOnly(bool $readOnly): static;

    #endregion

    #endregion
}
