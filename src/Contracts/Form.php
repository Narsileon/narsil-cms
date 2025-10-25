<?php

namespace Narsil\Contracts;

#region USE

use Illuminate\Database\Eloquent\Model;
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
     * Define the layout of the form.
     *
     * @return array
     */
    public function layout(): array;

    #region • GETTERS

    /**
     * Get the action of the form.
     *
     * @return string
     */
    public function getAction(): string;

    /**
     * Get the data of the form.
     *
     * @return Model|array
     */
    public function getData(): Model|array;

    /**
     * Get the description of the form.
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Get the id of the form.
     *
     * @return integer|string
     */
    public function getId(): int|string;

    /**
     * Get the language options of the form.
     *
     * @return array<SelectOption>
     */
    public function getLanguageOptions(): array;

    /**
     * Get the method of the form.
     *
     * @return MethodEnum
     */
    public function getMethod(): MethodEnum;

    /**
     * Get the routes associated to the form.
     *
     * @return array<string,string>
     */
    public function getRoutes(): array;

    /**
     * Get the icon of the submit button.
     *
     * @return string|null
     */
    public function getSubmitIcon(): ?string;

    /**
     * Get the label of the submit button.
     *
     * @return string
     */
    public function getSubmitLabel(): string;

    /**
     * Get the title of the form.
     *
     * @return string
     */
    public function getTitle(): string;

    #endregion

    #region • SETTERS

    /**
     * Set the action of the form.
     *
     * @param string $action
     *
     * @return static
     */
    public function setAction(string $action): static;

    /**
     * Set the data of the form.
     *
     * @param Model|array $data
     *
     * @return static
     */
    public function setData(Model|array $data): static;

    /**
     * Set the description of the form.
     *
     * @param string $description
     *
     * @return static
     */
    public function setDescription(string $description): static;

    /**
     * Set the id of the form.
     *
     * @param mixed $id
     *
     * @return static
     */
    public function setId(mixed $id): static;

    /**
     * Set the language options of the form.
     *
     * @param array $locales
     *
     * @return static
     */
    public function setLanguageOptions(array $locales): static;

    /**
     * Set the method of the form.
     *
     * @param MethodEnum $method
     *
     * @return static
     */
    public function setMethod(MethodEnum $method): static;

    /**
     * Set the routes associated to the form.
     *
     * @param array<string,string> $routes
     *
     * @return static
     */
    public function setRoutes(array $routes): static;

    /**
     * Set the icon of the submit button.
     *
     * @param ?string $submitIcon
     *
     * @return static
     */
    public function setSubmitIcon(?string $submitIcon): static;

    /**
     * Set the label of the submit button.
     *
     * @param string $submitLabel
     *
     * @return static
     */
    public function setSubmitLabel(string $submitLabel): static;

    /**
     * Set the title of the form.
     *
     * @param string $title
     *
     * @return static
     */
    public function setTitle(string $title): static;

    #endregion

    #endregion
}
