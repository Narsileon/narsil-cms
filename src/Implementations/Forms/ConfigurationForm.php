<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Support\Facades\App;
use Locale;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Forms\ConfigurationForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Configuration;
use Narsil\Models\Elements\Field;
use Narsil\Models\Hosts\HostLocaleLanguage;
use Narsil\Services\RouteService;
use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConfigurationForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->routes(RouteService::getNames(Configuration::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        $languageSelectOptions = $this->getLanguageSelectOptions();

        return [
            new Field([
                Field::HANDLE => Configuration::DEFAULT_LANGUAGE,
                Field::NAME => trans('narsil::validation.attributes.default_language'),
                Field::TYPE => SelectField::class,
                Field::RELATION_OPTIONS => $languageSelectOptions,
                Field::SETTINGS => app(SelectField::class)
                    ->required(true),
            ]),
        ];
    }

    /**
     * Get the language select options.
     *
     * @return array<SelectOption>
     */
    protected function getLanguageSelectOptions(): array
    {
        $languages = HostLocaleLanguage::getUniqueLanguages();

        $options = [];

        foreach ($languages as $language)
        {
            $label = Locale::getDisplayLanguage($language, App::getLocale());

            $options[] = new SelectOption()
                ->optionLabel(ucfirst($label))
                ->optionValue($language);
        }

        usort($options, function (SelectOption $a, SelectOption $b)
        {
            return strcasecmp($a->label, $b->label);
        });

        return array_values($options);
    }

    #endregion
}
