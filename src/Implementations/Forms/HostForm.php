<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\ArrayInputData;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TableInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Implementations\Form;
use Narsil\Base\Services\ModelService;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Forms\HostForm as Contract;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Hosts\HostLocale;
use Narsil\Cms\Models\Hosts\HostLocaleLanguage;
use Narsil\Cms\Services\LocaleService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostForm extends Form implements Contract
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
    protected function getSteps(): array
    {
        $countryOptions = LocaleService::countryOptions();
        $languageOptions = LocaleService::languageOptions();

        return [
            new FormStepData(
                id: 'definition',
                label: trans('narsil-cms::ui.definition'),
                elements: [
                    new FieldData(
                        description: ModelService::getAttributeDescription(Host::TABLE, Host::HOSTNAME),
                        id: Host::HOSTNAME,
                        required: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        description: ModelService::getAttributeDescription(Host::TABLE, Host::LABEL),
                        id: Host::LABEL,
                        required: true,
                        translatable: true,
                        input: new TextInputData(),
                    ),
                ],
            ),
            new FormStepData(
                id: 'default_country',
                label: trans('narsil-cms::ui.default_country'),
                elements: [
                    new FieldData(
                        description: ModelService::getAttributeDescription(HostLocale::TABLE, HostLocale::PATTERN, [
                            'example' => 'https://{host}/{language}'
                        ]),
                        id: HostLocale::PATTERN,
                        prefix: Host::RELATION_DEFAULT_LOCALE,
                        required: true,
                        input: new TextInputData(
                            defaultValue: 'https://{host}/{language}'
                        ),
                    ),
                    new FieldData(

                        id: HostLocale::RELATION_LANGUAGES,
                        prefix: Host::RELATION_DEFAULT_LOCALE,
                        input: new TableInputData(
                            columns: [
                                new FieldData(
                                    id: HostLocaleLanguage::LANGUAGE,
                                    required: true,
                                    input: new SelectInputData(
                                        options: $languageOptions
                                    ),
                                ),
                            ],
                        ),
                    ),
                ],
            ),
            new FormStepData(
                id: 'other_countries',
                label: trans('narsil-cms::ui.other_countries'),
                elements: [
                    new FieldData(
                        id: Host::RELATION_OTHER_LOCALES,
                        label: trans('narsil-cms::validation.attributes.locales'),
                        input: new ArrayInputData(
                            labelPath: HostLocale::COUNTRY,
                            elements: [
                                new FieldData(
                                    description: ModelService::getAttributeDescription(HostLocale::TABLE, HostLocale::PATTERN, [
                                        'example' => 'https://{host}/{language}-{country}'
                                    ]),
                                    id: HostLocale::PATTERN,
                                    required: true,
                                    input: new TextInputData(
                                        defaultValue: 'https://{host}/{language}-{country}'
                                    ),
                                ),
                                new FieldData(
                                    id: HostLocale::COUNTRY,
                                    required: true,
                                    input: new SelectInputData(
                                        options: $countryOptions
                                    ),
                                ),
                                new FieldData(
                                    id: HostLocale::RELATION_LANGUAGES,
                                    required: true,
                                    input: new TableInputData(
                                        columns: [
                                            new FieldData(
                                                id: HostLocaleLanguage::LANGUAGE,
                                                required: true,
                                                input: new SelectInputData(
                                                    options: $languageOptions
                                                ),
                                            ),
                                        ],
                                    ),
                                ),
                            ],
                        ),
                    ),
                ],
            ),
        ];
    }

    #endregion
}
