<?php

namespace App\Http\Forms\Users;

#region USE

use App\Contracts\Forms\Users\UserConfigurationForm as Contract;
use App\Enums\ColorEnum;
use App\Enums\Forms\TypeEnum;
use App\Enums\ThemeEnum;
use App\Http\Forms\AbstractForm;
use App\Models\Users\UserConfiguration;
use App\Support\Forms\Input;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Locale;
use ResourceBundle;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserConfigurationForm extends AbstractForm implements Contract
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function getContent(): array
    {
        $colorOptions = $this->getColorOptions();
        $localeOptions = $this->getLocaleOptions();
        $themeOptions = $this->getThemesOptions();

        return [
            (new Input(UserConfiguration::LOCALE, TypeEnum::SELECT, 'en'))
                ->setOptions($localeOptions)
                ->setPlaceholder(trans('ui.search'))
                ->get(),
            (new Input(UserConfiguration::THEME, TypeEnum::SELECT, 'system'))
                ->setOptions($themeOptions)
                ->setPlaceholder(trans('ui.search'))
                ->get(),
            (new Input(UserConfiguration::COLOR, TypeEnum::SELECT, 'neutral'))
                ->setOptions($colorOptions)
                ->setPlaceholder(trans('ui.search'))
                ->get(),
            (new Input(UserConfiguration::RADIUS, TypeEnum::SLIDER, 0.65))
                ->setMax(2)
                ->setMin(0)
                ->setStep(0.05)
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
