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
            ->action(route('user-configurations.update'))
            ->method(MethodEnum::PUT->value)
            ->submitLabel(trans('narsil::ui.save'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        $localeSelectOptions = static::getLocaleSelectOptions();

        return [
            new Field([
                Field::HANDLE => UserConfiguration::LANGUAGE,
                Field::NAME => trans('narsil::validation.attributes.language'),
                Field::REQUIRED => true,
                Field::TYPE => SelectField::class,
                Field::RELATION_OPTIONS => $localeSelectOptions,
                Field::SETTINGS => app(SelectField::class)
                    ->defaultValue(App::getLocale()),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::COLOR,
                Field::NAME => trans('narsil::validation.attributes.color'),
                Field::REQUIRED => true,
                Field::TYPE => SelectField::class,
                Field::RELATION_OPTIONS => ColorEnum::options(),
                Field::SETTINGS => app(SelectField::class)
                    ->defaultValue(ColorEnum::GRAY->value),
            ]),
            new Field([
                Field::HANDLE => UserConfiguration::RADIUS,
                Field::NAME => trans('narsil::validation.attributes.radius'),
                Field::REQUIRED => true,
                Field::TYPE => RangeField::class,
                Field::SETTINGS => app(RangeField::class)
                    ->defaultValue([0.25])
                    ->max(1)
                    ->min(0)
                    ->step(0.05),
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
