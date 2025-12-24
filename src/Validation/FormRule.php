<?php

namespace Narsil\Validation;

#region USE

use Illuminate\Validation\Rule;
use Narsil\Enums\ValidationRuleEnum;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FormRule extends Rule
{
    #region CONSTANTS

    /**
     * The name of the "alpha dash" rule.
     *
     * @var string
     */
    final public const ALPHA_DASH = ValidationRuleEnum::ALPHA_DASH->value;

    /**
     * The name of the "array" rule.
     *
     * @var string
     */
    final public const ARRAY = ValidationRuleEnum::ARRAY->value;

    /**
     * The name of the "boolean" rule.
     *
     * @var string
     */
    final public const BOOLEAN = ValidationRuleEnum::BOOLEAN->value;

    /**
     * The name of the "confirmed" rule.
     *
     * @var string
     */
    final public const CONFIRMED = ValidationRuleEnum::CONFIRMED->value;

    /**
     * The name of the "date" rule.
     *
     * @var string
     */
    final public const DATE = ValidationRuleEnum::DATE->value;

    /**
     * The name of the "decimal" rule.
     *
     * @var string
     */
    final public const DECIMAL = ValidationRuleEnum::DECIMAL->value;

    /**
     * The name of the "distinct" rule.
     *
     * @var string
     */
    final public const DISTINCT = ValidationRuleEnum::DISTINCT->value;

    /**
     * The name of the "email" rule.
     *
     * @var string
     */
    final public const EMAIL = ValidationRuleEnum::EMAIL->value;

    /**
     * The name of the "image" rule.
     *
     * @var string
     */
    final public const IMAGE = ValidationRuleEnum::IMAGE->value;

    /**
     * The name of the "integer" rule.
     *
     * @var string
     */
    final public const INTEGER = ValidationRuleEnum::INTEGER->value;

    /**
     * The name of the "lowercase" rule.
     *
     * @var string
     */
    final public const LOWERCASE = ValidationRuleEnum::LOWERCASE->value;

    /**
     * The name of the "nullable" rule.
     *
     * @var string
     */
    final public const NULLABLE = ValidationRuleEnum::NULLABLE->value;

    /**
     * The name of the "numeric" rule.
     *
     * @var string
     */
    final public const NUMERIC = ValidationRuleEnum::NUMERIC->value;

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
    final public const SOMETIMES = ValidationRuleEnum::SOMETIMES->value;

    /**
     * The name of the "string" rule.
     *
     * @var string
     */
    final public const STRING = ValidationRuleEnum::STRING->value;

    /**
     * The name of the "url" rule.
     *
     * @var string
     */
    final public const URL = ValidationRuleEnum::URL->value;

    /**
     * The name of the "uuid" rule.
     *
     * @var string
     */
    final public const UUID = ValidationRuleEnum::UUID->value;

    #endregion

    #region PUBLIC METHODS

    /**
     * Get the "after" rule with the given value.
     *
     * @param string $value
     *
     * @return string
     */
    final public static function after(string $value): string
    {
        return "after:$value";
    }

    /**
     * Get the "after or equal" rule with the given value.
     *
     * @param string $value
     *
     * @return string
     */
    final public static function afterOrEqual(string $value): string
    {
        return "after_or_equal:$value";
    }

    /**
     * Get the "before" rule with the given value.
     *
     * @param string $value
     *
     * @return string
     */
    final public static function before(string $value): string
    {
        return "before:$value";
    }

    /**
     * Get the "before or equal" rule with the given value.
     *
     * @param string $value
     *
     * @return string
     */
    final public static function beforeOrEqual(string $value): string
    {
        return "before_or_equal:$value";
    }

    /**
     * Get the "doesnt end with" rule with the given value.
     *
     * @param string $value
     *
     * @return string
     */
    final public static function doesntEndWith(string $value): string
    {
        return "doesnt_end_with:$value";
    }

    /**
     * Get the "doesnt start with" rule with the given value.
     *
     * @param string $value
     *
     * @return string
     */
    final public static function doesntStartWith(string $value): string
    {
        return "doesnt_start_with:$value";
    }

    /**
     * Get the "max" rule with the given value.
     *
     * @param float $value
     *
     * @return string
     */
    final public static function max(float $value): string
    {
        return "max:$value";
    }

    /**
     * Get the "min" rule with the given value.
     *
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
