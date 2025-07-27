<?php

namespace Narsil\Enums\Fields;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum InputTypeEnum: string
{
    case CHECKBOX  = 'checkbox';
    case DATE      = 'date';
    case EMAIL     = 'email';
    case NUMBER    = 'number';
    case PASSWORD  = 'password';
    case RANGE     = 'range';
    case RICH_TEXT = 'rich_text';
    case SELECT    = 'select';
    case SWITCH    = 'switch';
    case TAB       = 'tab';
    case TEXT      = 'text';
    case TIME      = 'time';
}
