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
     * @return array Defines the form template.
     */
    public static function form(): array;

    #endregion

    #region FLUENT METHODS

    /**
     * @param string $description Sets the description of the form.
     *
     * @return static
     */
    public function description(string $description): static;

    /**
     * @param MethodEnum $method Sets the method of the submit action.
     *
     * @return static
     */
    public function method(MethodEnum $method): static;

    /**
     * @param string $submit Sets the label of the submit button.
     *
     * @return static
     */
    public function submit(string $submit): static;

    /**
     * @param string $title Sets the title of the form.
     *
     * @return static
     */
    public function title(string $title): static;

    /**
     * @param string $url Sets the url of the submit action.
     *
     * @return static
     */
    public function url(string $url): static;

    #endregion
}
