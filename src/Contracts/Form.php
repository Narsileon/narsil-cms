<?php

namespace Narsil\Contracts;

#region USE

use Illuminate\Database\Eloquent\Model;
use JsonSerializable;
use Narsil\Enums\Forms\MethodEnum;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
interface Form extends JsonSerializable
{
    #region PUBLIC METHODS

    /**
     * Define the layout of the form.
     *
     * @return array
     */
    public function layout(): array;

    #region • SETTERS

    /**
     * Set the action of the form.
     *
     * @param string $action
     *
     * @return static
     */
    public function action(string $action): static;

    /**
     * Set the data of the form.
     *
     * @param Model|array $data
     *
     * @return static
     */
    public function data(Model|array $data): static;

    /**
     * Set the description of the form.
     *
     * @param string $description
     *
     * @return static
     */
    public function description(string $description): static;

    /**
     * Set the id of the form.
     *
     * @param mixed $id
     *
     * @return static
     */
    public function id(mixed $id): static;

    /**
     * Set the method of the form.
     *
     * @param MethodEnum $method
     *
     * @return static
     */
    public function method(MethodEnum $method): static;

    /**
     * Set the icon of the submit button.
     *
     * @param ?string $submitIcon
     *
     * @return static
     */
    public function submitIcon(?string $submitIcon): static;

    /**
     * Set the label of the submit button.
     *
     * @param string $submitLabel
     *
     * @return static
     */
    public function submitLabel(string $submitLabel): static;

    /**
     * Set the title of the form.
     *
     * @param string $title
     *
     * @return static
     */
    public function title(string $title): static;

    #endregion

    #endregion
}
