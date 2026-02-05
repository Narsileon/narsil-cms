<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Cms\Contracts\Fields\ArrayField;
use Narsil\Cms\Contracts\Fields\SelectField;
use Narsil\Cms\Contracts\Fields\TableField;
use Narsil\Cms\Contracts\Fields\TextField;
use Narsil\Cms\Contracts\Forms\HostForm as Contract;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;
use Narsil\Cms\Services\LocaleService;
use Narsil\Cms\Services\ModelService;
use Narsil\Cms\Services\RouteService;

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
        $countrySelectOptions = LocaleService::countrySelectOptions();
        $languageSelectOptions = LocaleService::languageSelectOptions();

        return [
            [
                TemplateTab::HANDLE => 'definition',
                TemplateTab::LABEL => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::DESCRIPTION => ModelService::getFieldDescription(Host::TABLE, Host::HOSTNAME),
                        TemplateTabElement::HANDLE => Host::HOSTNAME,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.host'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::DESCRIPTION => ModelService::getFieldDescription(Host::TABLE, Host::LABEL),
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
                        TemplateTabElement::DESCRIPTION => ModelService::getFieldDescription(HostLocale::TABLE, HostLocale::PATTERN, [
                            'example' => 'https://{host}/{language}'
                        ]),
                        TemplateTabElement::HANDLE => Host::RELATION_DEFAULT_LOCALE . '.' . HostLocale::PATTERN,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.pattern'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->defaultvalue('https://{host}/{language}'),
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
                                        BlockElement::DESCRIPTION => ModelService::getFieldDescription(HostLocale::TABLE, HostLocale::PATTERN, [
                                            'example' => 'https://{host}/{language}-{country}'
                                        ]),
                                        BlockElement::HANDLE => HostLocale::PATTERN,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.pattern'),
                                        BlockElement::REQUIRED => true,
                                        BlockElement::RELATION_BASE => [
                                            Field::TYPE => TextField::class,
                                            Field::SETTINGS => app(TextField::class)
                                                ->defaultvalue('https://{host}/{language}-{country}'),
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

    #endregion
}
