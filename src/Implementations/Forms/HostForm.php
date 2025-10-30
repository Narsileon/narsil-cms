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
 * @version 1.0.0
 * @author Jonathan Rigaux
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
            ->description(trans('narsil::models.' . Host::class))
            ->routes(RouteService::getNames(Host::TABLE))
            ->submitLabel(trans('narsil::ui.save'))
            ->title(trans('narsil::models.' . Host::class));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
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
                            ->required(true),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Host::HANDLE,
                        Field::NAME => trans('narsil::validation.attributes.handle'),
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(TextField::class)
                            ->required(true),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Host::RELATION_LOCALES,
                        Field::NAME => trans('narsil::validation.attributes.locales'),
                        Field::TYPE => ArrayField::class,
                        Field::SETTINGS => app(ArrayField::class)
                            ->block(new Block([
                                Block::RELATION_ELEMENTS => [
                                    new BlockElement([
                                        BlockElement::RELATION_ELEMENT => new Field([
                                            Field::HANDLE => HostLocale::PATTERN,
                                            Field::NAME => trans('narsil::validation.attributes.pattern'),
                                            Field::TYPE => TextField::class,
                                            Field::SETTINGS => app(TextField::class)
                                                ->required(true),
                                        ]),
                                    ]),
                                    new BlockElement([
                                        BlockElement::RELATION_ELEMENT => new Field([
                                            Field::HANDLE => HostLocale::COUNTRY,
                                            Field::NAME => trans('narsil::validation.attributes.country'),
                                            Field::TYPE => SelectField::class,
                                            Field::SETTINGS => app(SelectField::class)
                                                ->options($countrySelectOptions),
                                        ]),
                                    ]),
                                    new BlockElement([
                                        BlockElement::RELATION_ELEMENT => new Field([
                                            Field::HANDLE => HostLocale::RELATION_LANGUAGES,
                                            Field::NAME => trans('narsil::validation.attributes.languages'),
                                            Field::TYPE => TableField::class,
                                            Field::SETTINGS => app(TableField::class)
                                                ->columns([
                                                    new Field([
                                                        Field::HANDLE => HostLocaleLanguage::LANGUAGE,
                                                        Field::NAME => trans('narsil::validation.attributes.language'),
                                                        Field::TYPE => SelectField::class,
                                                        Field::SETTINGS => app(SelectField::class)
                                                            ->options($languageSelectOptions)
                                                            ->required(true),
                                                    ]),
                                                ])
                                                ->placeholder(trans('narsil::ui.add')),
                                        ])
                                    ]),
                                ],
                            ]))
                            ->labelKey(HostLocale::COUNTRY),
                    ]),
                ]),
            ]),
            static::informationSection(),
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

        $defaultOption = new SelectOption()
            ->optionLabel(trans('narsil::ui.default'))
            ->optionValue('default');

        array_unshift($options, $defaultOption);

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
