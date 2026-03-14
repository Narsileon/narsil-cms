<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Base\Implementations\Form;
use Narsil\Base\Services\LocaleService;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Forms\ConfigurationForm as Contract;
use Narsil\Cms\Models\Configuration;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;

#endregion

/**
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
                            options: LocaleService::languageOptions($frontendLanguages),
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
                            options: LocaleService::languageOptions($backendLanguages),
                        ),
                    ),
                ],
            ),
        ];
    }
}
