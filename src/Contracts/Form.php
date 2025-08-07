<?php

namespace Narsil\Contracts;

#region USE

use JsonSerializable;
use Narsil\Enums\Forms\MethodEnum;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface Form extends JsonSerializable
{
    #region PUBLIC METHODS

    /**
     * @return array
     */
    public static function form(): array;

    #endregion

    #region FLUENT METHODS

    /**
     * @param string $description
     *
     * @return static
     */
    public function description(string $description): static;

    /**
     * @param MethodEnum $method
     *
     * @return static
     */
    public function method(MethodEnum $method): static;

    /**
     * @param string $submit
     *
     * @return static
     */
    public function submit(string $submit): static;

    /**
     * @param string $title
     *
     * @return static
     */
    public function title(string $title): static;

    /**
     * @param string $url
     *
     * @return static
     */
    public function url(string $url): static;

    #endregion
}
