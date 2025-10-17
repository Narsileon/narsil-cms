<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Locale;
use Narsil\Contracts\Fields\ArrayField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\TableField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\HostForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Services\RouteService;
use Narsil\Support\SelectOption;
use ResourceBundle;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class HostForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->setDescription(trans('narsil::models.host'))
            ->setRoutes(RouteService::getNames(Host::TABLE))
            ->setSubmitLabel(trans('narsil::ui.save'))
            ->setTitle(trans('narsil::models.host'));
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function layout(): array
    {
        $countrySelectOptions = $this->getCountrySelectOptions();
        $languageSelectOptions = $this->getLanguageSelectOptions();

        return [
            static::mainSection([
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Host::NAME,
                        Field::NAME => trans('narsil::validation.attributes.name'),
                        Field::TRANSLATABLE => true,
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(TextField::class)
                            ->setRequired(true),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Host::HANDLE,
                        Field::NAME => trans('narsil::validation.attributes.handle'),
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(TextField::class)
                            ->setRequired(true),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Host::RELATION_LOCALES,
                        Field::NAME => trans('narsil::validation.attributes.locales'),
                        Field::TYPE => ArrayField::class,
                        Field::SETTINGS => app(ArrayField::class)
                            ->setBlock(new Block([
                                Block::RELATION_ELEMENTS => [
                                    new BlockElement([
                                        BlockElement::RELATION_ELEMENT => new Field([
                                            Field::HANDLE => HostLocale::PATTERN,
                                            Field::NAME => trans('narsil::validation.attributes.pattern'),
                                            Field::TYPE => TextField::class,
                                            Field::SETTINGS => app(TextField::class)
                                                ->setRequired(true),
                                        ]),
                                    ]),
                                    new BlockElement([
                                        BlockElement::RELATION_ELEMENT => new Field([
                                            Field::HANDLE => HostLocale::COUNTRY,
                                            Field::NAME => trans('narsil::validation.attributes.country'),
                                            Field::TYPE => SelectField::class,
                                            Field::SETTINGS => app(SelectField::class)
                                                ->setOptions($countrySelectOptions),
                                        ]),
                                    ]),
                                    new BlockElement([
                                        BlockElement::RELATION_ELEMENT => new Field([
                                            Field::HANDLE => HostLocale::RELATION_LANGUAGES,
                                            Field::NAME => trans('narsil::validation.attributes.languages'),
                                            Field::TYPE => TableField::class,
                                            Field::SETTINGS => app(TableField::class)
                                                ->setColumns([
                                                    new Field([
                                                        Field::HANDLE => HostLocaleLanguage::LANGUAGE,
                                                        Field::NAME => trans('narsil::validation.attributes.language'),
                                                        Field::TYPE => SelectField::class,
                                                        Field::SETTINGS => app(SelectField::class)
                                                            ->setOptions($languageSelectOptions)
                                                            ->setRequired(true),
                                                    ]),
                                                ])
                                                ->setPlaceholder(trans('narsil::ui.add')),
                                        ])
                                    ]),
                                ],
                            ]))
                            ->setLabelKey(HostLocale::COUNTRY),
                    ]),
                ]),
            ]),
            static::informationSection(),
        ];
    }

    #endregion

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

            $options[] = new SelectOption(
                label: ucfirst($label),
                value: $code,
            );
        }

        usort($options, function (SelectOption $a, SelectOption $b)
        {
            return strcasecmp($a->getLabel(), $b->getLabel());
        });

        array_unshift($options, new SelectOption(
            label: trans('narsil::ui.default'),
            value: 'default',
        ));

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

            $options[] = new SelectOption(
                label: ucfirst($label),
                value: $code,
            );
        }

        usort($options, function (SelectOption $a, SelectOption $b)
        {
            return strcasecmp($a->getLabel(), $b->getLabel());
        });

        return array_values($options);
    }

    #endregion
}
