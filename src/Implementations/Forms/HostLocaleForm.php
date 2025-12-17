<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Locale;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\TableField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\HostLocaleForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Hosts\HostLocale;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Support\SelectOption;
use ResourceBundle;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostLocaleForm extends AbstractForm implements Contract
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function getCountryField(): Field
    {
        $countrySelectOptions = $this->getCountrySelectOptions();

        return new Field([
            Field::HANDLE => HostLocale::COUNTRY,
            Field::NAME => trans('narsil::validation.attributes.country'),
            Field::TYPE => SelectField::class,
            Field::RELATION_OPTIONS => $countrySelectOptions,
            Field::SETTINGS => app(SelectField::class),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getLanguagesField(): Field
    {
        $languageSelectOptions = $this->getLanguageSelectOptions();

        return new Field([
            Field::HANDLE => HostLocale::RELATION_LANGUAGES,
            Field::NAME => trans('narsil::validation.attributes.languages'),
            Field::TYPE => TableField::class,
            Field::SETTINGS => app(TableField::class)
                ->columns([
                    new Field([
                        Field::HANDLE => HostLocaleLanguage::LANGUAGE,
                        Field::NAME => trans('narsil::validation.attributes.language'),
                        Field::REQUIRED => true,
                        Field::TYPE => SelectField::class,
                        Field::RELATION_OPTIONS => $languageSelectOptions,
                        Field::SETTINGS => app(SelectField::class),
                    ]),
                ])
                ->placeholder(trans('narsil::ui.add')),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getPatternField(): Field
    {
        return new Field([
            Field::HANDLE => HostLocale::PATTERN,
            Field::NAME => trans('narsil::validation.attributes.pattern'),
            Field::REQUIRED => true,
            Field::TYPE => TextField::class,
            Field::SETTINGS => app(TextField::class),
        ]);
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        return [
            $this->getPatternField(),
            $this->getCountryField(),
            $this->getLanguagesField(),
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
