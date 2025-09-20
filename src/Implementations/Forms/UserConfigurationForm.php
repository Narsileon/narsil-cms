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

        $this->action = route('user-configuration.store');
        $this->method = MethodEnum::PUT;
        $this->submitLabel = trans('narsil::ui.save');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function layout(): array
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
                    ->setDefaultValue('en')
                    ->setOptions($localeOptions),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::THEME,
                Field::NAME => trans('narsil::validation.attributes.theme'),
                Field::TYPE => SelectInput::class,
                Field::SETTINGS => app(SelectInput::class)
                    ->setDefaultValue('system')
                    ->setOptions($themeOptions),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::COLOR,
                Field::NAME => trans('narsil::validation.attributes.color'),
                Field::TYPE => SelectInput::class,
                Field::SETTINGS => app(SelectInput::class)
                    ->setDefaultValue('gray')
                    ->setOptions($colorOptions),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::RADIUS,
                Field::NAME => trans('narsil::validation.attributes.radius'),
                Field::TYPE => RangeInput::class,
                Field::SETTINGS => app(RangeInput::class)
                    ->setDefaultValue([0.50])
                    ->setMax(1)
                    ->setMin(0)
                    ->setStep(0.05),
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
            $optionLabel = view('narsil::components.bullet-label', [
                'color' => $case->value,
                'label' => trans("narsil::colors.$case->value"),
            ])->render();

            $options[] = new SelectOption($optionLabel, $case->value);
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
