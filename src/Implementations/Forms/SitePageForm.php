<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\Fields\EntityField;
use Narsil\Contracts\Fields\FileField;
use Narsil\Contracts\Fields\RangeField;
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
use Narsil\Models\Collections\Block;
use Narsil\Models\Collections\BlockElement;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\Template;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\Collections\TemplateTabElement;
use Narsil\Models\Collections\TemplateTabElementCondition;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Sites\SitePage;
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
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => SitePage::SLUG,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.slug'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->generate(SitePage::TITLE),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => SitePage::ADAPTER,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.adapter'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class)
                                ->defaultValue(SitePageAdapterEnum::ENTITY->value),
                            Field::RELATION_OPTIONS => SitePageAdapterEnum::selectOptions(),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => SitePage::RELATION_ENTITIES,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.entity'),
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_CONDITIONS => [
                            [
                                TemplateTabElementCondition::HANDLE => SitePage::ADAPTER,
                                TemplateTabElementCondition::OPERATOR => '=',
                                TemplateTabElementCondition::VALUE => SitePageAdapterEnum::ENTITY->value,
                            ],
                        ],
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => EntityField::class,
                            Field::SETTINGS => app(EntityField::class)
                                ->collections(Template::all()->pluck(Template::ID)->toArray()),
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
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class),
                            Field::RELATION_OPTIONS => Template::selectOptions(),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => SitePage::SHOW_IN_MENU,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.show_in_menu'),
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_BASE => [
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
                        TemplateTabElement::RELATION_BASE => [
                            Block::LABEL => 'Meta',
                            Block::RELATION_ELEMENTS => [
                                [
                                    BlockElement::HANDLE => SitePage::META_DESCRIPTION,
                                    BlockElement::LABEL => trans('narsil::validation.attributes.description'),
                                    BlockElement::REQUIRED => true,
                                    BlockElement::TRANSLATABLE => true,
                                    BlockElement::RELATION_BASE => [
                                        Field::TYPE => TextareaField::class,
                                        Field::SETTINGS => app(TextareaField::class),
                                    ],
                                ],
                                [
                                    BlockElement::HANDLE => SitePage::ROBOTS,
                                    BlockElement::LABEL => trans('narsil::validation.attributes.robots'),
                                    BlockElement::REQUIRED => true,
                                    BlockElement::RELATION_BASE => [
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
                        TemplateTabElement::RELATION_BASE => [
                            Block::LABEL => 'Open Graph',
                            Block::RELATION_ELEMENTS => [
                                [
                                    BlockElement::HANDLE => SitePage::OPEN_GRAPH_TYPE,
                                    BlockElement::LABEL => trans('narsil::validation.attributes.type'),
                                    BlockElement::REQUIRED => true,
                                    BlockElement::RELATION_BASE => [
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
                                    BlockElement::RELATION_BASE => [
                                        Field::TYPE => TextField::class,
                                        Field::SETTINGS => app(TextField::class),
                                    ],
                                ],
                                [
                                    BlockElement::HANDLE => SitePage::OPEN_GRAPH_DESCRIPTION,
                                    BlockElement::LABEL => trans('narsil::validation.attributes.description'),
                                    BlockElement::TRANSLATABLE => true,
                                    BlockElement::RELATION_BASE => [
                                        Field::TYPE => TextareaField::class,
                                        Field::SETTINGS => app(TextareaField::class),
                                    ],
                                ],
                                [
                                    BlockElement::HANDLE => SitePage::OPEN_GRAPH_IMAGE,
                                    BlockElement::LABEL => trans('narsil::validation.attributes.image'),
                                    BlockElement::RELATION_BASE => [
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
                        TemplateTabElement::RELATION_BASE => [
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
                        TemplateTabElement::RELATION_BASE => [
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
