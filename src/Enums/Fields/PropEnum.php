<?php

namespace Narsil\Enums\Fields;

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum PropEnum: string
{
    case AUTO_COMPLETE         = 'autoComplete';
    case CHECKED               = 'checked';
    case CLASS_NAME            = 'className';
    case MAX                   = 'max';
    case MAX_LENGTH            = 'maxLength';
    case MIN                   = 'min';
    case MIN_LENGTH            = 'minLength';
    case MULTIPLE              = 'multiple';
    case OPTIONS               = 'options';
    case PLACEHOLDER           = 'placeholder';
    case REQUIRED              = 'required';
    case STEP                  = 'step';
    case TYPE                  = 'type';
    case VALUE                 = 'value';
    case VISIBILITY_MODE       = 'visibility_mode';
    case VISIBILITY_CONDITIONS = 'visibility_conditions';
}
