<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\Fields\ArrayField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\HostForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Services\RouteService;

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
        $hostLocaleForm = app(HostLocaleForm::class);

        return [
            [
                TemplateTab::HANDLE => 'definition',
                TemplateTab::LABEL => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Host::HOST,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.host'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Host::LABEL,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.label'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_ELEMENT => [
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
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Host::RELATION_DEFAULT_LOCALE . '.' . HostLocale::RELATION_LANGUAGES,
                        TemplateTabElement::RELATION_ELEMENT => $hostLocaleForm->getLanguagesField(),
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
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => ArrayField::class,
                            Field::SETTINGS => app(ArrayField::class)
                                ->form($hostLocaleForm->layout)
                                ->labelKey(HostLocale::COUNTRY),
                        ],
                    ],
                ],
            ],
        ];
    }

    #region PROTECTED METHODS

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
