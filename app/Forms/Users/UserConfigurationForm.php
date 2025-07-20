<?php

namespace App\Forms\Users;

#region USE

use App\Contracts\Fields\Number\RangeFieldSettings;
use App\Contracts\Fields\Select\SelectFieldSettings;
use App\Contracts\Forms\Users\UserConfigurationForm as Contract;
use App\Enums\Configuration\ColorEnum;
use App\Enums\Configuration\ThemeEnum;
use App\Forms\AbstractForm;
use App\Models\Fields\Field;
use App\Models\Users\UserConfiguration;
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
     * {@inheritDoc}
     */
    protected function getContent(): array
    {
        $colorOptions = $this->getColorOptions();
        $localeOptions = $this->getLocaleOptions();
        $themeOptions = $this->getThemesOptions();

        return [
            new Field([
                Field::HANDLE => UserConfiguration::LOCALE,
                Field::NAME => trans('validation.attributes.locale'),
                Field::SETTINGS => app(SelectFieldSettings::class)
                    ->options($localeOptions)
                    ->value('en')
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::THEME,
                Field::NAME => trans('validation.attributes.theme'),
                Field::SETTINGS => app(SelectFieldSettings::class)
                    ->options($themeOptions)
                    ->value('system')
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::COLOR,
                Field::NAME => trans('validation.attributes.color'),
                Field::SETTINGS => app(SelectFieldSettings::class)
                    ->options($colorOptions)
                    ->value('neutral')
                    ->toArray(),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::RADIUS,
                Field::NAME => trans('validation.attributes.radius'),
                Field::SETTINGS => app(RangeFieldSettings::class)
                    ->max('1')
                    ->min('0')
                    ->step('0.05')
                    ->value(['0.65'])
                    ->toArray(),
            ]),
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
