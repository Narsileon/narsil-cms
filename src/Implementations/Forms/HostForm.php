<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Locale;
use Narsil\Contracts\Fields\ArrayField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\TableField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\HostForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\Collections\TemplateTabElement;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Services\RouteService;
use Narsil\Support\SelectOption;
use ResourceBundle;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Host::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        $countrySelectOptions = $this->getCountrySelectOptions();
        $languageSelectOptions = $this->getLanguageSelectOptions();

        return [
            [
                TemplateTab::HANDLE => 'definition',
                TemplateTab::LABEL => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Host::HOST,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.host'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Host::LABEL,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.label'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                ],
            ],
            [
                TemplateTab::HANDLE => 'default_country',
                TemplateTab::LABEL => trans('narsil::ui.default_country'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Host::RELATION_DEFAULT_LOCALE . '.' . HostLocale::PATTERN,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.pattern'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Host::RELATION_DEFAULT_LOCALE . '.' . HostLocale::RELATION_LANGUAGES,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.languages'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::PLACEHOLDER => trans('narsil::ui.add'),
                            Field::TYPE => TableField::class,
                            Field::SETTINGS => app(TableField::class)
                                ->columns([
                                    [
                                        BlockElement::HANDLE => HostLocaleLanguage::LANGUAGE,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.language'),
                                        BlockElement::REQUIRED => true,
                                        BlockElement::RELATION_BASE => [
                                            Field::TYPE => SelectField::class,
                                            Field::SETTINGS => app(SelectField::class),
                                            Field::RELATION_OPTIONS => $languageSelectOptions,
                                        ],
                                    ],
                                ]),
                        ],
                    ],
                ],
            ],
            [
                TemplateTab::HANDLE => 'other_countries',
                TemplateTab::LABEL => trans('narsil::ui.other_countries'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Host::RELATION_OTHER_LOCALES,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.locales'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => ArrayField::class,
                            Field::SETTINGS => app(ArrayField::class)
                                ->form([
                                    [
                                        BlockElement::HANDLE => HostLocale::PATTERN,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.pattern'),
                                        BlockElement::REQUIRED => true,
                                        BlockElement::RELATION_BASE => [
                                            Field::TYPE => TextField::class,
                                            Field::SETTINGS => app(TextField::class),
                                        ],
                                    ],
                                    [
                                        BlockElement::HANDLE => HostLocale::COUNTRY,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.country'),
                                        BlockElement::REQUIRED => true,
                                        BlockElement::RELATION_BASE => [
                                            Field::TYPE => SelectField::class,
                                            Field::SETTINGS => app(SelectField::class),
                                            Field::RELATION_OPTIONS => $countrySelectOptions,
                                        ],
                                    ],
                                    [
                                        BlockElement::HANDLE => HostLocale::RELATION_LANGUAGES,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.languages'),
                                        BlockElement::REQUIRED => true,
                                        BlockElement::RELATION_BASE => [
                                            Field::PLACEHOLDER => trans('narsil::ui.add'),
                                            Field::TYPE => TableField::class,
                                            Field::SETTINGS => app(TableField::class)
                                                ->columns([
                                                    [
                                                        BlockElement::HANDLE => HostLocaleLanguage::LANGUAGE,
                                                        BlockElement::LABEL => trans('narsil::validation.attributes.language'),
                                                        BlockElement::REQUIRED => true,
                                                        BlockElement::RELATION_BASE => [
                                                            Field::TYPE => SelectField::class,
                                                            Field::SETTINGS => app(SelectField::class),
                                                            Field::RELATION_OPTIONS => $languageSelectOptions,
                                                        ],
                                                    ],
                                                ]),
                                        ],
                                    ],
                                ])
                                ->labelKey(HostLocale::COUNTRY),
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Get the country select options.
     *
     * @return array<SelectOption>
     */
    protected function getCountrySelectOptions(): array
    {
        $locales = \ResourceBundle::getLocales('');

        $codes = array_filter(array_unique(array_map(function ($locale)
        {
            $region = Locale::getRegion($locale);

            if ($region && preg_match('/^[A-Z]{2}$/', $region))
            {
                return $region;
            }

            return null;
        }, $locales)));

        $options = [];

        foreach ($codes as $code)
        {
            $label = Locale::getDisplayRegion('_' . $code, App::getLocale());

            if (!$label || $label === $code)
            {
                continue;
            }

            $options[] = new SelectOption()
                ->optionLabel(ucfirst($label))
                ->optionValue($code);
        }

        usort($options, function (SelectOption $a, SelectOption $b)
        {
            return strcasecmp($a->label, $b->label);
        });

        return array_values($options);
    }

    /**
     * Get the language select options.
     *
     * @return array<SelectOption>
     */
    protected function getLanguageSelectOptions(): array
    {
        $locales = ResourceBundle::getLocales('');

        $codes = array_unique(array_map(function ($locale)
        {
            return Str::substr($locale, 0, 2);
        }, $locales));

        $options = [];

        foreach ($codes as $code)
        {
            $label = Locale::getDisplayLanguage($code, App::getLocale());

            if (!$label || $label === $code)
            {
                continue;
            }

            $options[] = new SelectOption()
                ->optionLabel(ucfirst($label))
                ->optionValue($code);
        }

        usort($options, function (SelectOption $a, SelectOption $b)
        {
            return strcasecmp($a->label, $b->label);
        });

        return array_values($options);
    }

    #endregion
}
