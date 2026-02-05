<?php

namespace Narsil\Cms\Contracts\Fields;

#region USE

use Narsil\Cms\Contracts\Field as Contract;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 *
 * @see vendor/narsil/cms/config/narsil/bindings/fields.php
 */
interface TextField extends Contract
{
    #region PUBLIC METHODS

    /**
     * Set the auto complete attribute.
     *
     * @param string $autoComplete
     *
     * @return static
     */
    public function autoComplete(string $autoComplete): static;

    /**
     * Set the default value.
     *
     * @param string $value
     *
     * @return static
     */
    public function defaultvalue(string $value): static;

    /**
     * Set the generate attribute.
     *
     * @param string $generate
     *
     * @return static
     */
    public function generate(string $generate): static;

    /**
     * Set the icon attribute.
     *
     * @param string $icon
     *
     * @return static
     */
    public function icon(string $icon): static;

    /**
     * Set the max length attribute.
     *
     * @param string $maxLength e.g. "255"
     *
     * @return static
     */
    public function maxLength(string $maxLength): static;

    /**
     * Set the min length attribute.
     *
     * @param string $minLength e.g. "8"
     *
     * @return static
     */
    public function minLength(string $minLength): static;

    /**
     * Set the smart values attribute.
     *
     * @param string $smartValues
     *
     * @return static
     */
    public function smartValues(string $smartValues): static;

    /**
     * Set the type attribute.
     *
     * @param string $type
     *
     * @return static
     */
    public function type(string $type): static;

    #endregion
}
