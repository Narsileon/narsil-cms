<?php

namespace Narsil\Validation;

#region USE

use Illuminate\Validation\Rule;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
abstract class FormRule extends Rule
{
    #region CONSTANTS

    /**
     * @var string The "array" rule.
     */
    final public const ARRAY = 'array';
    /**
     * @var string The "boolean" rule.
     */
    final public const BOOLEAN = 'boolean';
    /**
     * @var string The "confirmed" rule.
     */
    final public const CONFIRMED = 'confirmed';
    /**
     * @var string The "date" rule.
     */
    final public const DATE = 'date';
    /**
     * @var string The "decimal" rule.
     */
    final public const DECIMAL = 'decimal';
    /**
     * @var string The "distinct" rule.
     */
    final public const DISTINCT = 'distinct';
    /**
     * @var string The "email" rule.
     */
    final public const EMAIL = 'email';
    /**
     * @var string The "image" rule.
     */
    final public const IMAGE = 'image';
    /**
     * @var string The "integer" rule.
     */
    final public const INTEGER = 'integer';
    /**
     * @var string The "nullable" rule.
     */
    final public const NULLABLE = 'nullable';
    /**
     * @var string The "numeric" rule.
     */
    final public const NUMERIC = 'numeric';
    /**
     * @var string The "required" rule.
     */
    final public const REQUIRED = 'required';
    /**
     * @var string The "sometimes" rule.
     */
    final public const SOMETIMES = 'sometimes';
    /**
     * @var string The "string" rule.
     */
    final public const STRING = 'string';
    /**
     * @var string The "url" rule.
     */
    final public const URL = 'url';
    /**
     * @var string The "uuid" rule.
     */
    final public const UUID = 'uuid';

    #endregion

    #region PUBLIC METHODS

    /**
     * @param string $value
     *
     * @return string
     */
    final public static function after(string $value): string
    {
        return "after:$value";
    }

    /**
     * @param string $value
     *
     * @return string
     */
    final public static function afterOrEqual(string $value): string
    {
        return "after_or_equal:$value";
    }

    /**
     * @param string $value
     *
     * @return string
     */
    final public static function before(string $value): string
    {
        return "before:$value";
    }

    /**
     * @param string $value
     *
     * @return string
     */
    final public static function beforeOrEqual(string $value): string
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
