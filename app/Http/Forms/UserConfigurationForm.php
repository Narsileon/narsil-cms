<?php

namespace App\Http\Forms;

#region USE

use App\Enums\ColorEnum;
use App\Enums\Forms\TypeEnum;
use App\Enums\ThemeEnum;
use App\Http\Forms\AbstractForm;
use App\Interfaces\Forms\IUserConfigurationForm;
use App\Models\UserConfiguration;
use App\Support\Input;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Locale;
use ResourceBundle;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserConfigurationForm extends AbstractForm implements IUserConfigurationForm
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function getInputs(): array
    {
        $colorOptions = $this->getColorOptions();
        $localeOptions = $this->getLocaleOptions();
        $themeOptions = $this->getThemesOptions();

        return [
            (new Input(UserConfiguration::LOCALE, 'en'))
                ->type(TypeEnum::SELECT)
                ->options($localeOptions)
                ->get(),
            (new Input(UserConfiguration::THEME, 'system'))
                ->type(TypeEnum::SELECT)
                ->options($themeOptions)
                ->get(),
            (new Input(UserConfiguration::COLOR, 'neutral'))
                ->type(TypeEnum::SELECT)
                ->options($colorOptions)
                ->get(),
            (new Input(UserConfiguration::RADIUS, 0.65))
                ->type(TypeEnum::SLIDER)
                ->max(2)
                ->min(0)
                ->step(0.05)
                ->get(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array<string>
     */
    protected function getColorOptions(): array
    {
        $options = [];

        foreach (ColorEnum::cases() as $case)
        {
            $options[] = [
                'bg-color'   => "bg-$case->value-500",
                'label'      => trans("colors.$case->value"),
                'text-color' => "text-$case->value-500",
                'value'      => $case->value,
            ];
        }

        return $options;
    }

    #endregion

    /**
     * @return array<string>
     */
    protected function getLocaleOptions(): array
    {
        $locales = ResourceBundle::getLocales('');

        $allowedLocales = explode(',', Config::get('app.locales', 'de,en,fr'));

        $options = [];

        foreach ($locales as $locale)
        {
            if (!in_array($locale, $allowedLocales))
            {
                continue;
            }

            $options[] = [
                'value' => $locale,
                'label' => Str::ucfirst(Locale::getDisplayName($locale, App::getLocale())),
            ];
        }

        usort($options, function ($a, $b)
        {
            return strcmp($a['label'], $b['label']);
        });


        return array_values($options);
    }

    /**
     * @return array<string>
     */
    protected function getThemesOptions(): array
    {
        $options = [];

        foreach (ThemeEnum::cases() as $case)
        {
            $options[] = [
                'value' => $case->value,
                'label' => trans("themes.$case->value"),
            ];
        }

        return $options;
    }

    #endregion
}
