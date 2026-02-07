<?php

namespace Narsil\Cms\Enums;

#region USE

use Narsil\Cms\Support\SelectOption;
use Narsil\Cms\Traits\Enumerable;

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
    public static function selectOptions(): array
    {
        $options = [];

        foreach (self::cases() as $case)
        {
            $label = view('narsil-cms::components.bullet-label', [
                'color' => $case->value,
                'label' => trans("narsil-cms::colors.$case->value"),
            ])->render();

            $option = new SelectOption()
                ->optionLabel($label)
                ->optionValue($case->value);

            $options[] = $option;
        }

        return $options;
    }

    #endregion
}
