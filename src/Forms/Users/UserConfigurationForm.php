<?php

namespace Narsil\Forms\Users;

#region USE

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Locale;
use Narsil\Contracts\Fields\Number\RangeField;
use Narsil\Contracts\Fields\Select\SelectField;
use Narsil\Contracts\Forms\Users\UserConfigurationForm as Contract;
use Narsil\Enums\Configuration\ColorEnum;
use Narsil\Enums\Configuration\ThemeEnum;
use Narsil\Forms\AbstractForm;
use Narsil\Models\Fields\Field;
use Narsil\Models\Users\UserConfiguration;
use ResourceBundle;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserConfigurationForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function fields(): array
    {
        $colorOptions = $this->getColorOptions();
        $localeOptions = $this->getLocaleOptions();
        $themeOptions = $this->getThemesOptions();

        return [[
            Field::HANDLE => UserConfiguration::LOCALE,
            Field::ICON => 'languages',
            Field::NAME => trans('narsil-cms::validation.attributes.locale'),
            Field::SETTINGS => app(SelectField::class)
                ->options($localeOptions)
                ->value('en')
                ->toArray(),
        ], [
            Field::HANDLE => UserConfiguration::THEME,
            Field::ICON => 'sun-moon',
            Field::NAME => trans('narsil-cms::validation.attributes.theme'),
            Field::SETTINGS => app(SelectField::class)
                ->options($themeOptions)
                ->value('system')
                ->toArray(),
        ], [
            Field::HANDLE => UserConfiguration::COLOR,
            Field::ICON => 'palette',
            Field::NAME => trans('narsil-cms::validation.attributes.color'),
            Field::SETTINGS => app(SelectField::class)
                ->options($colorOptions)
                ->value('neutral')
                ->toArray(),
        ], [
            Field::HANDLE => UserConfiguration::RADIUS,
            Field::ICON => 'square-round-corner',
            Field::NAME => trans('narsil-cms::validation.attributes.radius'),
            Field::SETTINGS => app(RangeField::class)
                ->max(1)
                ->min(0)
                ->step(0.05)
                ->value([0.50])
                ->toArray(),
        ]];
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
                'label'      => trans("narsil-cms::colors.$case->value"),
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
                'label' => trans("narsil-cms::themes.$case->value"),
            ];
        }

        return $options;
    }

    #endregion
}
