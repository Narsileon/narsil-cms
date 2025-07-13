<?php

namespace App\Validation;

use Illuminate\Validation\Rule;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FormRule extends Rule
{
    #region CONSTANTS

    /**
     * @var string The name of the "array" type.
     */
    final public const ARRAY = 'array';
    /**
     * @var string The name of the "boolean" type.
     */
    final public const BOOLEAN = 'boolean';
    /**
     * @var string The name of the "date" type.
     */
    final public const DATE = 'date';
    /**
     * @var string The name of the "decimal" type.
     */
    final public const DECIMAL = 'decimal';
    /**
     * @var string The name of the "email" type.
     */
    final public const EMAIL = 'email';
    /**
     * @var string The name of the "image" type.
     */
    final public const IMAGE = 'image';
    /**
     * @var string The name of the "integer" type.
     */
    final public const INTEGER = 'integer';
    /**
     * @var string The name of the "numeric" type.
     */
    final public const NUMERIC = 'numeric';
    /**
     * @var string The name of the "string" type.
     */
    final public const STRING = 'string';
    /**
     * @var string The name of the "url" type.
     */
    final public const URL = 'url';
    /**
     * @var string The name of the "uuid" type.
     */
    final public const UUID = 'uuid';

    /**
     * @var string The name of the "confirmed" utility.
     */
    final public const CONFIRMED = 'confirmed';
    /**
     * @var string The name of the "nullable" utility.
     */
    final public const NULLABLE = 'nullable';
    /**
     * @var string The name of the "required" utility.
     */
    final public const REQUIRED = 'required';
    /**
     * @var string The name of the "sometimes" utility.
     */
    final public const SOMETIMES = 'sometimes';

    #endregion

    #region PUBLIC METHODS

    /**
     * @param string $value
     *
     * @return string
     */
    final public static function dateAfter(string $value): string
    {
        return "after:$value";
    }

    /**
     * @param string $value
     *
     * @return string
     */
    final public static function dateAfterOrEqual(string $value): string
    {
        return "after_or_equal:$value";
    }

    /**
     * @param string $value
     *
     * @return string
     */
    final public static function dateBefore(string $value): string
    {
        return "before:$value";
    }

    /**
     * @param string $value
     *
     * @return string
     */
    final public static function dateBeforeOrEqual(string $value): string
    {
        return "before_or_equal:$value";
    }

    /**
     * @param float $value
     *
     * @return string
     */
    final public static function max(float $value): string
    {
        return "max:$value";
    }

    /**
     * @param float $value
     *
     * @return string
     */
    final public static function min(float $value): string
    {
        return "min:$value";
    }

    #endregion
}
