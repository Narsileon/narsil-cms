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
     * The name of the "array" rule.
     *
     * @var string
     */
    final public const ARRAY = 'array';

    /**
     * The name of the "boolean" rule.
     *
     * @var string
     */
    final public const BOOLEAN = 'boolean';

    /**
     * The name of the "confirmed" rule.
     *
     * @var string
     */
    final public const CONFIRMED = 'confirmed';

    /**
     * The name of the "date" rule.
     *
     * @var string
     */
    final public const DATE = 'date';

    /**
     * The name of the "decimal" rule.
     *
     * @var string
     */
    final public const DECIMAL = 'decimal';

    /**
     * The name of the "distinct" rule.
     *
     * @var string
     */
    final public const DISTINCT = 'distinct';

    /**
     * The name of the "email" rule.
     *
     * @var string
     */
    final public const EMAIL = 'email';

    /**
     * The name of the "image" rule.
     *
     * @var string
     */
    final public const IMAGE = 'image';

    /**
     * The name of the "integer" rule.
     *
     * @var string
     */
    final public const INTEGER = 'integer';

    /**
     * The name of the "nullable" rule.
     *
     * @var string
     */
    final public const NULLABLE = 'nullable';

    /**
     * The name of the "numeric" rule.
     *
     * @var string
     */
    final public const NUMERIC = 'numeric';

    /**
     * The name of the "required" rule.
     *
     * @var string
     */
    final public const REQUIRED = 'required';

    /**
     * The name of the "sometimes" rule.
     *
     * @var string
     */
    final public const SOMETIMES = 'sometimes';

    /**
     * The name of the "string" rule.
     *
     * @var string
     */
    final public const STRING = 'string';

    /**
     * The name of the "url" rule.
     *
     * @var string
     */
    final public const URL = 'url';

    /**
     * The name of the "uuid" rule.
     *
     * @var string
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
