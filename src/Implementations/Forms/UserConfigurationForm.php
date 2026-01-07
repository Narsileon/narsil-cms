<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Locale;
use Narsil\Contracts\Fields\RangeField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Forms\UserConfigurationForm as Contract;
use Narsil\Enums\ColorEnum;
use Narsil\Enums\RequestMethodEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;
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
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this
            ->action(route('user-configurations.update'))
            ->method(RequestMethodEnum::PUT->value)
            ->submitLabel(trans('narsil::ui.save'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        $localeSelectOptions = static::getLocaleSelectOptions();

        return [
            [
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => UserConfiguration::LANGUAGE,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.language'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class)
                                ->defaultValue(App::getLocale()),
                            Field::RELATION_OPTIONS => $localeSelectOptions,
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => UserConfiguration::COLOR,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.color'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class)
                                ->defaultValue(ColorEnum::GRAY->value),
                            Field::RELATION_OPTIONS => ColorEnum::selectOptions(),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => UserConfiguration::RADIUS,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.radius'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => RangeField::class,
                            Field::SETTINGS => app(RangeField::class)
                                ->defaultValue([0.25])
                                ->max(1)
                                ->min(0)
                                ->step(0.05),
                        ],
                    ],
                ],
            ],
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
