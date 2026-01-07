<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\Fields\FileField;
use Narsil\Contracts\Fields\RangeField;
use Narsil\Contracts\Fields\RelationsField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\SwitchField;
use Narsil\Contracts\Fields\TextareaField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\SitePageForm as Contract;
use Narsil\Enums\SEO\ChangeFreqEnum;
use Narsil\Enums\SEO\OpenGraphTypeEnum;
use Narsil\Enums\SEO\RobotsEnum;
use Narsil\Enums\SitePageAdapterEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Sites\SitePage;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\Template;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;
use Narsil\Models\Structures\TemplateTabElementCondition;
use Narsil\Services\RouteService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class SitePageForm extends AbstractForm implements Contract
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
    protected function getTabs(): array
    {
        $collections = $this->getCollections();

        return [
            [
                TemplateTab::HANDLE => 'main',
                TemplateTab::LABEL => trans('narsil::ui.main'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => SitePage::TITLE,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.title'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => SitePage::SLUG,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.slug'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->generate(SitePage::TITLE),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => SitePage::ADAPTER,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.adapter'),
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class)
                                ->defaultValue(SitePageAdapterEnum::ENTITY->value),
                            Field::RELATION_OPTIONS => SitePageAdapterEnum::selectOptions(),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => SitePage::ENTITY,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.entity'),
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_CONDITIONS => [
                            [
                                TemplateTabElementCondition::HANDLE => SitePage::ADAPTER,
                                TemplateTabElementCondition::OPERATOR => '=',
                                TemplateTabElementCondition::VALUE => SitePageAdapterEnum::ENTITY->value,
                            ],
                        ],
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => RelationsField::class,
                            Field::SETTINGS => app(RelationsField::class)
                                ->collections($collections)
                                ->defaultValue([])
                                ->multiple(false),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => SitePage::COLLECTION,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.collection'),
                        TemplateTabElement::RELATION_CONDITIONS => [
                            [
                                TemplateTabElementCondition::HANDLE => SitePage::ADAPTER,
                                TemplateTabElementCondition::OPERATOR => '=',
                                TemplateTabElementCondition::VALUE => SitePageAdapterEnum::COLLECTION->value,
                            ],
                        ],
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class),
                            Field::RELATION_OPTIONS => Template::selectOptions(),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => SitePage::SHOW_IN_MENU,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.show_in_menu'),
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => SwitchField::class,
                            Field::SETTINGS => app(SwitchField::class)
                                ->defaultValue(true),
                        ],
                    ],
                ],
            ],
            [
                TemplateTab::HANDLE => 'SEO',
                TemplateTab::LABEL => 'SEO',
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::RELATION_ELEMENT => [
                            Block::LABEL => 'Meta',
                            Block::RELATION_ELEMENTS => [
                                [
                                    BlockElement::HANDLE => SitePage::META_DESCRIPTION,
                                    BlockElement::LABEL => trans('narsil::validation.attributes.description'),
                                    BlockElement::REQUIRED => true,
                                    BlockElement::TRANSLATABLE => true,
                                    BlockElement::RELATION_ELEMENT => [
                                        Field::TYPE => TextareaField::class,
                                        Field::SETTINGS => app(TextareaField::class),
                                    ],
                                ],
                                [
                                    BlockElement::HANDLE => SitePage::ROBOTS,
                                    BlockElement::LABEL => trans('narsil::validation.attributes.robots'),
                                    BlockElement::REQUIRED => true,
                                    BlockElement::RELATION_ELEMENT => [
                                        Field::TYPE => SelectField::class,
                                        Field::SETTINGS => app(SelectField::class)
                                            ->defaultValue(RobotsEnum::ALL->value)
                                            ->displayValue(false),
                                        Field::RELATION_OPTIONS => RobotsEnum::selectOptions(),
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        TemplateTabElement::RELATION_ELEMENT => [
                            Block::LABEL => 'Open Graph',
                            Block::RELATION_ELEMENTS => [
                                [
                                    BlockElement::HANDLE => SitePage::OPEN_GRAPH_TYPE,
                                    BlockElement::LABEL => trans('narsil::validation.attributes.type'),
                                    BlockElement::REQUIRED => true,
                                    BlockElement::RELATION_ELEMENT => [
                                        Field::TYPE => SelectField::class,
                                        Field::SETTINGS => app(SelectField::class)
                                            ->defaultValue(OpenGraphTypeEnum::WEBSITE->value)
                                            ->displayValue(false),
                                        Field::RELATION_OPTIONS => OpenGraphTypeEnum::selectOptions(),
                                    ],
                                ],
                                [
                                    BlockElement::HANDLE => SitePage::OPEN_GRAPH_TITLE,
                                    BlockElement::LABEL => trans('narsil::validation.attributes.title'),
                                    BlockElement::TRANSLATABLE => true,
                                    BlockElement::RELATION_ELEMENT => [
                                        Field::TYPE => TextField::class,
                                        Field::SETTINGS => app(TextField::class),
                                    ],
                                ],
                                [
                                    BlockElement::HANDLE => SitePage::OPEN_GRAPH_DESCRIPTION,
                                    BlockElement::LABEL => trans('narsil::validation.attributes.description'),
                                    BlockElement::TRANSLATABLE => true,
                                    BlockElement::RELATION_ELEMENT => [
                                        Field::TYPE => TextareaField::class,
                                        Field::SETTINGS => app(TextareaField::class),
                                    ],
                                ],
                                [
                                    BlockElement::HANDLE => SitePage::OPEN_GRAPH_IMAGE,
                                    BlockElement::LABEL => trans('narsil::validation.attributes.image'),
                                    BlockElement::RELATION_ELEMENT => [
                                        Field::TYPE => FileField::class,
                                        Field::SETTINGS => app(FileField::class)
                                            ->accept('image/*')
                                            ->icon('image'),
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            [
                TemplateTab::HANDLE => 'Sitemap',
                TemplateTab::LABEL => 'Sitemap',
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => SitePage::CHANGE_FREQ,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.change_freq'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class)
                                ->defaultValue(ChangeFreqEnum::NEVER->value)
                                ->displayValue(false),
                            Field::RELATION_OPTIONS => ChangeFreqEnum::selectOptions(),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => SitePage::PRIORITY,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.priority'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => RangeField::class,
                            Field::SETTINGS => app(RangeField::class)
                                ->defaultValue([1.0])
                                ->max(1)
                                ->min(0)
                                ->step(0.05),
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    protected function getCollections(): array
    {
        return Template::query()
            ->pluck(Template::ID)
            ->toArray();
    }

    #endregion
}
