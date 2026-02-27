<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\ArrayInputData;
use Narsil\Base\Http\Data\Forms\Inputs\FileInputData;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Base\Http\Data\Forms\Inputs\SwitchInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Implementations\Form;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Forms\FooterForm as Contract;
use Narsil\Cms\Models\Globals\Footer;
use Narsil\Cms\Models\Globals\FooterLink;
use Narsil\Cms\Models\Globals\FooterSocialMedium;
use Narsil\Cms\Services\LocaleService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FooterForm extends Form implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Footer::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getSteps(): array
    {
        return [
            new FormStepData(
                id: 'definition',
                label: trans('narsil::ui.definition'),
                elements: [
                    new FieldData(
                        id: Footer::SLUG,
                        required: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        icon: 'image',
                        id: Footer::LOGO,
                        input: new FileInputData(
                            accept: 'image/*',
                        ),
                    ),
                    new FieldData(
                        id: Footer::COPYRIGHT,
                        required: true,
                        translatable: true,
                        input: new TextInputData(),
                    ),
                ],
            ),
            new FormStepData(
                id: 'organization',
                label: trans('narsil-cms::validation.attributes.organization'),
                elements: [
                    new FieldData(
                        id: Footer::ORGANIZATION,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: Footer::EMAIL,
                        translatable: true,
                        width: 50,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: Footer::PHONE,
                        width: 50,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: Footer::STREET,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: Footer::POSTAL_CODE,
                        width: 50,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: Footer::CITY,
                        width: 50,
                        translatable: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: Footer::COUNTRY,
                        input: new SelectInputData(
                            options: LocaleService::countryOptions(),
                        ),
                    ),
                    new FieldData(
                        id: Footer::ORGANIZATION_SCHEMA,
                        input: new SwitchInputData(
                            defaultValue: true,
                        ),
                    ),
                ],
            ),
            new FormStepData(
                id: 'meta_navigation',
                label: trans('narsil-cms::ui.meta_navigation'),
                elements: [
                    new FieldData(
                        id: Footer::RELATION_LINKS,
                        label: trans('narsil-cms::ui.links'),
                        input: new ArrayInputData(
                            labelPath: FooterLink::LABEL,
                            elements: [
                                new FieldData(
                                    id: FooterLink::SITE_PAGE_ID,
                                    required: true,
                                    input: new SelectInputData(),
                                ),
                            ],
                        ),
                    ),
                ],
            ),
            new FormStepData(
                id: 'social_media',
                label: trans('narsil-cms::ui.social_media'),
                elements: [
                    new FieldData(
                        id: Footer::RELATION_SOCIAL_MEDIA,
                        label: trans('narsil-cms::ui.links'),
                        input: new ArrayInputData(
                            labelPath: FooterSocialMedium::LABEL,
                            elements: [
                                new FieldData(
                                    id: FooterSocialMedium::LABEL,
                                    required: true,
                                    translatable: true,
                                    input: new TextInputData(),
                                ),
                                new FieldData(
                                    id: FooterSocialMedium::URL,
                                    required: true,
                                    input: new TextInputData(),
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
