<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Helpers\Translator;
use Narsil\Base\Http\Data\ConditionData;
use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FieldsetData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\FileInputData;
use Narsil\Base\Http\Data\Forms\Inputs\RangeInputData;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Base\Http\Data\Forms\Inputs\SwitchInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextareaInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Implementations\Form;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Forms\SitePageForm as Contract;
use Narsil\Cms\Enums\SEO\ChangeFreqEnum;
use Narsil\Cms\Enums\SEO\OpenGraphTypeEnum;
use Narsil\Cms\Enums\SEO\RobotsEnum;
use Narsil\Cms\Enums\SitePageAdapterEnum;
use Narsil\Cms\Http\Data\Forms\Inputs\EntityInputData;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Hosts\Host;
use Narsil\Cms\Models\Sites\SitePage;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageForm extends Form implements Contract
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
        $collections = $this->getCollections();

        return [
            new FormStepData(
                id: 'main',
                label: trans('narsil::ui.main'),
                elements: [
                    new FieldData(
                        id: SitePage::TITLE,
                        required: true,
                        translatable: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: SitePage::SLUG,
                        required: true,
                        translatable: true,
                        input: new TextInputData()
                            ->generate(SitePage::TITLE),
                    ),
                    new FieldData(
                        id: SitePage::ADAPTER,
                        input: new SelectInputData(
                            defaultValue: SitePageAdapterEnum::ENTITY->value,
                            options: SitePageAdapterEnum::options(),
                        ),
                    ),
                    new FieldData(
                        id: SitePage::RELATION_ENTITIES,
                        label: trans('narsil-cms::validation.attributes.entity'),
                        translatable: true,
                        conditions: [
                            new ConditionData(
                                handle: SitePage::ADAPTER,
                                operator: '=',
                                value: SitePageAdapterEnum::ENTITY->value
                            ),
                        ],
                        input: new EntityInputData(
                            collections: $collections,
                        ),
                    ),
                    new FieldData(
                        id: SitePage::COLLECTION,
                        conditions: [
                            new ConditionData(
                                handle: SitePage::ADAPTER,
                                operator: '=',
                                value: SitePageAdapterEnum::COLLECTION->value
                            ),
                        ],
                        input: new SelectInputData(
                            options: Template::options(),
                        ),
                    ),
                    new FieldData(
                        id: SitePage::SHOW_IN_MENU,
                        translatable: true,
                        input: new SwitchInputData(
                            defaultValue: true,
                        ),
                    ),
                ],
            ),
            new FormStepData(
                id: 'seo',
                label: 'SEO',
                elements: [
                    new FieldsetData(
                        label: 'Meta',
                        elements: [
                            new FieldData(
                                id: SitePage::META_DESCRIPTION,
                                label: trans('narsil::validation.attributes.description'),
                                required: true,
                                translatable: true,
                                input: new TextInputData(),
                            ),
                            new FieldData(
                                id: SitePage::ROBOTS,
                                required: true,
                                input: new SelectInputData(
                                    defaultValue: RobotsEnum::ALL->value,
                                    options: RobotsEnum::options(),
                                ),
                            ),
                        ],
                    ),
                    new FieldsetData(
                        label: 'Open Graph',
                        elements: [
                            new FieldData(
                                id: SitePage::OPEN_GRAPH_TYPE,
                                label: Translator::trans('validation.attributes.type'),
                                required: true,
                                input: new SelectInputData(
                                    defaultValue: OpenGraphTypeEnum::WEBSITE->value,
                                    options: OpenGraphTypeEnum::options(),
                                ),
                            ),
                            new FieldData(
                                id: SitePage::OPEN_GRAPH_TITLE,
                                label: Translator::trans('validation.attributes.title'),
                                translatable: true,
                                input: new TextInputData(),
                            ),
                            new FieldData(
                                id: SitePage::OPEN_GRAPH_DESCRIPTION,
                                label: Translator::trans('validation.attributes.description'),
                                translatable: true,
                                input: new TextareaInputData(),
                            ),
                            new FieldData(
                                icon: 'image',
                                id: SitePage::OPEN_GRAPH_IMAGE,
                                label: Translator::trans('validation.attributes.image'),
                                translatable: true,
                                input: new FileInputData(
                                    accept: 'image/*',
                                ),
                            ),
                        ],
                    ),
                ],
            ),
            new FormStepData(
                id: 'sitemap',
                label: 'Sitemap',
                elements: [
                    new FieldData(
                        id: SitePage::CHANGE_FREQ,
                        required: true,
                        input: new SelectInputData(
                            defaultValue: ChangeFreqEnum::NEVER->value,
                            options: ChangeFreqEnum::options(),
                        ),
                    ),
                    new FieldData(
                        id: SitePage::PRIORITY,
                        required: true,
                        input: new RangeInputData(
                            defaultValue: 1.0,
                            max: 1,
                            min: 0,
                            step: 0.05
                        ),
                    ),
                ],
            ),
        ];
    }

    /**
     * @return array
     */
    protected function getCollections(): array
    {
        return Template::query()
            ->without([
                Template::RELATION_TABS,
            ])
            ->pluck(Template::ID)
            ->toArray();
    }

    #endregion
}
