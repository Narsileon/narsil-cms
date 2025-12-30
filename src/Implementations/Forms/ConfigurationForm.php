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
use Narsil\Models\Configuration;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;
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
    protected function getLayout(): array
    {
        $frontendLanguages = HostLocaleLanguage::getUniqueLanguages();
        $backendLanguages = Config::get('narsil.locales');

        return [
            new TemplateTab([
                TemplateTab::HANDLE => 'frontend',
                TemplateTab::NAME => trans('narsil::ui.frontend'),
                TemplateTab::RELATION_ELEMENTS => [
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Configuration::DEFAULT_LANGUAGE,
                            Field::NAME => trans('narsil::validation.attributes.default_language'),
                            Field::REQUIRED => true,
                            Field::TYPE => SelectField::class,
                            Field::RELATION_OPTIONS => $this->getLanguageSelectOptions($frontendLanguages),
                            Field::SETTINGS => app(SelectField::class),
                        ]),
                    ]),
                ],
            ]),
            new TemplateTab([
                TemplateTab::HANDLE => 'backend',
                TemplateTab::NAME => trans('narsil::ui.backend'),
                TemplateTab::RELATION_ELEMENTS => [
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Configuration::DEFAULT_LANGUAGE,
                            Field::NAME => trans('narsil::validation.attributes.default_language'),
                            Field::REQUIRED => true,
                            Field::TYPE => SelectField::class,
                            Field::RELATION_OPTIONS => $this->getLanguageSelectOptions($backendLanguages),
                            Field::SETTINGS => app(SelectField::class),
                        ]),
                    ]),
                ],
            ]),
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
