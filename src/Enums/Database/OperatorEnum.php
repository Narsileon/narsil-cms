<?php

namespace Narsil\Enums\Database;

#region USE

use Narsil\Traits\Enumerable;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
}
