<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Locale;
use Narsil\Contracts\Fields\RangeInput;
use Narsil\Contracts\Fields\SelectInput;
use Narsil\Contracts\Forms\UserConfigurationForm as Contract;
use Narsil\Enums\Configuration\ColorEnum;
use Narsil\Enums\Configuration\ThemeEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
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
    public function elements(): array
    {
        $colorOptions = $this->getColorOptions();
        $localeOptions = $this->getLocaleOptions();
        $themeOptions = $this->getThemesOptions();

        return [
            new Field([
                Field::HANDLE => UserConfiguration::LOCALE,
                Field::NAME => trans('narsil-cms::validation.attributes.locale'),
                Field::TYPE => SelectInput::class,
                Field::SETTINGS => app(SelectInput::class)
                    ->options($localeOptions)
                    ->value('en'),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::THEME,
                Field::NAME => trans('narsil-cms::validation.attributes.theme'),
                Field::TYPE => SelectInput::class,
                Field::SETTINGS => app(SelectInput::class)
                    ->options($themeOptions)
                    ->value('system'),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::COLOR,
                Field::NAME => trans('narsil-cms::validation.attributes.color'),
                Field::TYPE => SelectInput::class,
                Field::SETTINGS => app(SelectInput::class)
                    ->options($colorOptions)
                    ->value('neutral'),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::RADIUS,
                Field::NAME => trans('narsil-cms::validation.attributes.radius'),
                Field::TYPE => RangeInput::class,
                Field::SETTINGS => app(RangeInput::class)
                    ->max(1)
                    ->min(0)
                    ->step(0.05)
                    ->value([0.50]),
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
