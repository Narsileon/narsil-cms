<?php

declare(strict_types=1);

namespace Narsil\Cms\Contracts;

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
     * @param string $append
     *
     * @return static
     */
    public function append(string $append): static;

    /**
     * @param boolean $readOnly
     *
     * @return static
     */
    public function readOnly(bool $readOnly): static;

    #endregion

    #endregion
}
