<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Locale;
use Narsil\Contracts\Fields\RangeField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Forms\UserConfigurationForm as Contract;
use Narsil\Enums\Configuration\ColorEnum;
use Narsil\Enums\Forms\MethodEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Users\UserConfiguration;
use Narsil\Support\SelectOption;
use ResourceBundle;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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

        $this
            ->setAction(route('user-configurations.update'))
            ->setMethod(MethodEnum::PUT)
            ->setSubmitLabel(trans('narsil::ui.save'));
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function layout(): array
    {
        $localeSelectOptions = static::getLocaleSelectOptions();

        return [
            new Field([
                Field::HANDLE => UserConfiguration::LANGUAGE,
                Field::NAME => trans('narsil::validation.attributes.language'),
                Field::TYPE => SelectField::class,
                Field::SETTINGS => app(SelectField::class)
                    ->setDefaultValue(App::getLocale())
                    ->setOptions($localeSelectOptions)
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::COLOR,
                Field::NAME => trans('narsil::validation.attributes.color'),
                Field::TYPE => SelectField::class,
                Field::SETTINGS => app(SelectField::class)
                    ->setDefaultValue(ColorEnum::GRAY->value)
                    ->setOptions(ColorEnum::options())
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::RADIUS,
                Field::NAME => trans('narsil::validation.attributes.radius'),
                Field::TYPE => RangeField::class,
                Field::SETTINGS => app(RangeField::class)
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
     * Get the locale select options.
     *
     * @return array<SelectOption>
     */
    protected static function getLocaleSelectOptions(): array
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

            $label = Str::ucfirst(Locale::getDisplayName($locale, App::getLocale()));

            $options[] = new SelectOption()
                ->optionLabel($label)
                ->optionValue($locale);
        }

        usort($options, function ($a, $b)
        {
            return strcmp($a->label, $b->label);
        });

        return $options;
    }

    #endregion
}
