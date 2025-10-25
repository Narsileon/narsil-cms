<?php

namespace Narsil\Enums\Configuration;

#region USE

use Narsil\Support\SelectOption;
use Narsil\Traits\Enumerable;

#endregion

/**
 * Enumeration of Tailwind CSS colors.
 *
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
enum ColorEnum: string
{
    use Enumerable;

    case GRAY = 'gray';
    case RED = 'red';
    case ORANGE  = 'orange';
    case AMBER = 'amber';
    case YELLOW = 'yellow';
    case LIME = 'lime';
    case GREEN = 'green';
    case EMERALD = 'emerald';
    case TEAL = 'teal';
    case CYAN = 'cyan';
    case SKY = 'sky';
    case BLUE = 'blue';
    case INDIGO = 'indigo';
    case VIOLET = 'violet';
    case PURPLE = 'purple';
    case FUCHSIA = 'fuchsia';
    case PINK = 'pink';
    case ROSE = 'rose';

    #region PUBLIC METHODS

    /**
     * Get the enum as select options.
     *
     * @return array<SelectOption>
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case)
        {
            $label = view('narsil::components.bullet-label', [
                'color' => $case->value,
                'label' => trans("narsil::colors.$case->value"),
            ])->render();

            $options[] = new SelectOption(
                label: $label,
                value: $case->value
            );
        }

        return $options;
    }

    #endregion
}
