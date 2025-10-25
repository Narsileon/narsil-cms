<?php

namespace Narsil\Validation;

#region USE

use Illuminate\Validation\Rule;
use Narsil\Enums\Forms\RuleEnum;

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
    final public const ALPHA_DASH = RuleEnum::ALPHA_DASH->value;

    /**
     * The name of the "array" rule.
     *
     * @var string
     */
    final public const ARRAY = RuleEnum::ARRAY->value;

    /**
     * The name of the "boolean" rule.
     *
     * @var string
     */
    final public const BOOLEAN = RuleEnum::BOOLEAN->value;

    /**
     * The name of the "confirmed" rule.
     *
     * @var string
     */
    final public const CONFIRMED = RuleEnum::CONFIRMED->value;

    /**
     * The name of the "date" rule.
     *
     * @var string
     */
    final public const DATE = RuleEnum::DATE->value;

    /**
     * The name of the "decimal" rule.
     *
     * @var string
     */
    final public const DECIMAL = RuleEnum::DECIMAL->value;

    /**
     * The name of the "distinct" rule.
     *
     * @var string
     */
    final public const DISTINCT = RuleEnum::DISTINCT->value;

    /**
     * The name of the "email" rule.
     *
     * @var string
     */
    final public const EMAIL = RuleEnum::EMAIL->value;

    /**
     * The name of the "image" rule.
     *
     * @var string
     */
    final public const IMAGE = RuleEnum::IMAGE->value;

    /**
     * The name of the "integer" rule.
     *
     * @var string
     */
    final public const INTEGER = RuleEnum::INTEGER->value;

    /**
     * The name of the "lowercase" rule.
     *
     * @var string
     */
    final public const LOWERCASE = RuleEnum::LOWERCASE->value;

    /**
     * The name of the "nullable" rule.
     *
     * @var string
     */
    final public const NULLABLE = RuleEnum::NULLABLE->value;

    /**
     * The name of the "numeric" rule.
     *
     * @var string
     */
    final public const NUMERIC = RuleEnum::NUMERIC->value;

    /**
     * The name of the "required" rule.
     *
     * @var string
     */
    final public const REQUIRED = RuleEnum::REQUIRED->value;

    /**
     * The name of the "sometimes" rule.
     *
     * @var string
     */
    final public const SOMETIMES = RuleEnum::SOMETIMES->value;

    /**
     * The name of the "string" rule.
     *
     * @var string
     */
    final public const STRING = RuleEnum::STRING->value;

    /**
     * The name of the "url" rule.
     *
     * @var string
     */
    final public const URL = RuleEnum::URL->value;

    /**
     * The name of the "uuid" rule.
     *
     * @var string
     */
    final public const UUID = RuleEnum::UUID->value;

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
