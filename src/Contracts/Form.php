<?php

namespace Narsil\Contracts;

#region USE

use Illuminate\Database\Eloquent\Model;
use JsonSerializable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
interface Form extends JsonSerializable
{
    #region PUBLIC METHODS

    /**
     * Set the "action" attribute of the form.
     *
     * @param string $action
     *
     * @return static
     */
    public function action(string $action): static;

    /**
     * Set the "auto save" attribute of the form.
     *
     * @param string $autoSave
     *
     * @return static
     */
    public function autoSave(string $autoSave): static;

    /**
     * Set the default language of the form.
     *
     * @param string $defaultLanguage
     *
     * @return static
     */
    public function defaultLanguage(string $defaultLanguage): static;

    /**
     * Set the description of the form.
     *
     * @param string $description
     *
     * @return static
     */
    public function description(string $description): static;

    /**
     * Set the data of the form.
     *
     * @param Model|array $data
     *
     * @return static
     */
    public function formData(Model|array $data): static;

    /**
     * Set the "id" attribute of the form.
     *
     * @param mixed $id
     *
     * @return static
     */
    public function id(mixed $id): static;

    /**
     * Set the language options of the form.
     *
     * @param array $locales
     *
     * @return static
     */
    public function languageOptions(array $locales): static;

    /**
     * Set the layout of the form.
     *
     * @param array $layout
     *
     * @return static
     */
    public function layout(array $layout): static;

    /**
     * Set the "method" attribute of the form.
     *
     * @param string $method
     *
     * @return static
     */
    public function method(string $method): static;

    /**
     * Set the routes associated to the form.
     *
     * @param array<string,string> $routes
     *
     * @return static
     */
    public function routes(array $routes): static;

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
}
