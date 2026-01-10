<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Locale;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Forms\ConfigurationForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\Collections\TemplateTabElement;
use Narsil\Models\Configuration;
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
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Configuration::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        $frontendLanguages = HostLocaleLanguage::getUniqueLanguages();
        $backendLanguages = Config::get('narsil.locales');

        return [
            [
                TemplateTab::HANDLE => 'frontend',
                TemplateTab::LABEL => trans('narsil::ui.frontend'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Configuration::DEFAULT_LANGUAGE,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.default_language'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => new Field([
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class),
                            Field::RELATION_OPTIONS => $this->getLanguageSelectOptions($frontendLanguages),
                        ]),
                    ],
                ],
            ],
            [
                TemplateTab::HANDLE => 'backend',
                TemplateTab::LABEL => trans('narsil::ui.backend'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Configuration::DEFAULT_LANGUAGE,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.default_language'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class),
                            Field::RELATION_OPTIONS => $this->getLanguageSelectOptions($backendLanguages),
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Get the language select options.
     *
     * @param array<string> $languages
     *
     * @return array<SelectOption>
     */
    protected function getLanguageSelectOptions(array $languages): array
    {
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
