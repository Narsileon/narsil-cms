<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Locale;
use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Base\Http\Data\OptionData;
use Narsil\Base\Implementations\Form;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Forms\ConfigurationForm as Contract;
use Narsil\Cms\Models\Configuration;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConfigurationForm extends Form implements Contract
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
    protected function getSteps(): array
    {
        $frontendLanguages = HostLocaleLanguage::getUniqueLanguages();
        $backendLanguages = Config::get('narsil.locales', []);

        return [
            new FormStepData(
                id: 'frontend',
                label: trans('narsil-cms::ui.frontend'),
                elements: [
                    new FieldData(
                        id: Configuration::DEFAULT_LANGUAGE,
                        required: true,
                        input: new SelectInputData(
                            options: $this->getLanguageOptions($frontendLanguages),
                        ),
                    ),
                ],
            ),
            new FormStepData(
                id: 'backend',
                label: trans('narsil-cms::ui.backend'),
                elements: [
                    new FieldData(
                        id: Configuration::DEFAULT_LANGUAGE,
                        required: true,
                        input: new SelectInputData(
                            options: $this->getLanguageOptions($backendLanguages),
                        ),
                    ),
                ],
            ),
        ];
    }

    /**
     * Get the language options.
     *
     * @param string[] $languages
     *
     * @return OptionData[]
     */
    protected function getLanguageOptions(array $languages): array
    {
        $options = [];

        foreach ($languages as $language)
        {
            $label = Locale::getDisplayLanguage($language, App::getLocale());

            $options[] = new OptionData(
                label: ucfirst($label),
                value: $language
            );
        }

        usort($options, function (OptionData $a, OptionData $b)
        {
            return strcasecmp($a->label, $b->label);
        });

        return array_values($options);
    }

    #endregion
}
