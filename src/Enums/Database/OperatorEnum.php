<?php

namespace Narsil\Cms\Enums\Database;

#region USE

use Narsil\Cms\Support\SelectOption;
use Narsil\Cms\Traits\Enumerable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum OperatorEnum: string
{
    use Enumerable;

    case AFTER = 'after';
    case AFTER_OR_EQUAL = 'after_or_equal';
    case BEFORE = 'before';
    case BEFORE_OR_EQUAL = 'before_or_equal';
    case CONTAINS = 'contains';
    case DOESNT_END_WITH = 'doesnt_end_with';
    case DOESNT_START_WITH = 'doesnt_start_with';
    case ENDS_WITH = 'ends_with';
    case EQUALS = 'equals';
    case GREATER_THAN = 'greater_than';
    case GREATER_THAN_OR_EQUAL = 'greater_than_or_equal';
    case LESS_THAN = 'less_than';
    case LESS_THAN_OR_EQUAL = 'less_than_or_equal';
    case NOT_CONTAINS = 'not_contains';
    case NOT_EQUALS = 'not_equals';
    case STARTS_WITH = 'starts_with';

    #region PUBLIC METHODS

    /**
     * Get the enum value as a select option.
     *
     * @param OperatorEnum $case
     *
     * @return SelectOption
     */
    public static function selectOption(OperatorEnum $case): SelectOption
    {
        return new SelectOption()
            ->optionLabel(trans('narsil::operators.' . $case->value))
            ->optionValue($case->value);
    }

    #endregion
}
