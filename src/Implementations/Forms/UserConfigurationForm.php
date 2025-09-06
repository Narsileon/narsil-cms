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
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Users\UserConfiguration;
use Narsil\Support\SelectOption;
use ResourceBundle;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class UserConfigurationForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->method = MethodEnum::PUT;
        $this->submitLabel = trans('narsil::ui.save');
        $this->url = route('user-configuration.store');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function form(): array
    {
        $colorOptions = static::getColorOptions();
        $localeOptions = static::getLocaleOptions();
        $themeOptions = static::getThemesOptions();

        return [
            new Field([
                Field::HANDLE => UserConfiguration::LOCALE,
                Field::NAME => trans('narsil::validation.attributes.language'),
                Field::TYPE => SelectInput::class,
                Field::SETTINGS => app(SelectInput::class)
                    ->options($localeOptions)
                    ->value('en'),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::THEME,
                Field::NAME => trans('narsil::validation.attributes.theme'),
                Field::TYPE => SelectInput::class,
                Field::SETTINGS => app(SelectInput::class)
                    ->options($themeOptions)
                    ->value('system'),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::COLOR,
                Field::NAME => trans('narsil::validation.attributes.color'),
                Field::TYPE => SelectInput::class,
                Field::SETTINGS => app(SelectInput::class)
                    ->options($colorOptions)
                    ->value('neutral'),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::RADIUS,
                Field::NAME => trans('narsil::validation.attributes.radius'),
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
    protected static function getColorOptions(): array
    {
        $options = [];

        foreach (ColorEnum::cases() as $case)
        {
            $options[] = new SelectOption(trans("narsil::colors.$case->value"), $case->value);
        }

        return $options;
    }

    #endregion

    /**
     * @return array<string>
     */
    protected static function getLocaleOptions(): array
    {
        $locales = ResourceBundle::getLocales('');

        $allowedLocales = Config::get('narsil.locales', []);

        $options = [];

        foreach ($locales as $locale)
        {
            if (!in_array($locale, $allowedLocales))
            {
                continue;
            }

            $options[] = new SelectOption(
                label: Str::ucfirst(Locale::getDisplayName($locale, App::getLocale())),
                value: $locale
            )->jsonSerialize();
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
    protected static function getThemesOptions(): array
    {
        $options = [];

        foreach (ThemeEnum::cases() as $case)
        {
            $options[] = new SelectOption(trans("narsil::themes.$case->value"), $case->value);
        }

        return $options;
    }

    #endregion
}
