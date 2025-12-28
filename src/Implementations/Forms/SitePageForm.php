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
use Narsil\Models\Condition;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\Template;
use Narsil\Models\Structures\TemplateSection;
use Narsil\Models\Structures\TemplateSectionElement;
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
    protected function getLayout(): array
    {
        $collections = $this->getCollections();

        return [
            new TemplateSection([
                TemplateSection::HANDLE => 'main',
                TemplateSection::NAME => trans('narsil::ui.main'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => SitePage::TITLE,
                            Field::NAME => trans('narsil::validation.attributes.title'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ])
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => SitePage::SLUG,
                            Field::NAME => trans('narsil::validation.attributes.slug'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->generate(SitePage::TITLE),
                        ])
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => SitePage::ADAPTER,
                            Field::NAME => trans('narsil::validation.attributes.adapter'),
                            Field::TYPE => SelectField::class,
                            Field::RELATION_OPTIONS => SitePageAdapterEnum::selectOptions(),
                            Field::SETTINGS => app(SelectField::class)
                                ->defaultValue(SitePageAdapterEnum::ENTITY->value),
                        ])
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_CONDITIONS => [
                            new Condition([
                                Condition::HANDLE => SitePage::ADAPTER,
                                Condition::OPERATOR => '=',
                                Condition::VALUE => SitePageAdapterEnum::ENTITY->value,
                            ]),
                        ],
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => SitePage::ENTITY,
                            Field::NAME => trans('narsil::validation.attributes.entity'),
                            Field::TRANSLATABLE => true,
                            Field::TYPE => RelationsField::class,
                            Field::SETTINGS => app(RelationsField::class)
                                ->collections($collections)
                                ->defaultValue([])
                                ->multiple(false),
                        ])
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_CONDITIONS => [
                            new Condition([
                                Condition::HANDLE => SitePage::ADAPTER,
                                Condition::OPERATOR => '=',
                                Condition::VALUE => SitePageAdapterEnum::COLLECTION->value,
                            ]),
                        ],
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => SitePage::COLLECTION,
                            Field::NAME => trans('narsil::validation.attributes.collection'),
                            Field::TYPE => SelectField::class,
                            Field::RELATION_OPTIONS => Template::selectOptions(),
                            Field::SETTINGS => app(SelectField::class),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => SitePage::SHOW_IN_MENU,
                            Field::NAME => trans('narsil::validation.attributes.show_in_menu'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => SwitchField::class,
                            Field::SETTINGS => app(SwitchField::class)
                                ->defaultValue(true),
                        ])
                    ]),
                ]
            ]),
            new TemplateSection([
                TemplateSection::HANDLE => 'SEO',
                TemplateSection::NAME => 'SEO',
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Block([
                            Block::NAME => 'Meta',
                            Block::RELATION_ELEMENTS => [
                                new BlockElement([
                                    BlockElement::RELATION_ELEMENT => new Field([
                                        Field::HANDLE => SitePage::META_DESCRIPTION,
                                        Field::NAME => trans('narsil::validation.attributes.description'),
                                        Field::REQUIRED => true,
                                        Field::TRANSLATABLE => true,
                                        Field::TYPE => TextareaField::class,
                                        Field::SETTINGS => app(TextareaField::class),
                                    ])
                                ]),
                                new BlockElement([
                                    BlockElement::RELATION_ELEMENT => new Field([
                                        Field::HANDLE => SitePage::ROBOTS,
                                        Field::NAME => trans('narsil::validation.attributes.robots'),
                                        Field::REQUIRED => true,
                                        Field::TYPE => SelectField::class,
                                        Field::RELATION_OPTIONS => RobotsEnum::selectOptions(),
                                        Field::SETTINGS => app(SelectField::class)
                                            ->defaultValue(RobotsEnum::ALL->value)
                                            ->displayValue(false),
                                    ])
                                ]),
                            ],
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Block([
                            Block::NAME => 'Open Graph',
                            Block::RELATION_ELEMENTS => [
                                new BlockElement([
                                    BlockElement::RELATION_ELEMENT => new Field([
                                        Field::HANDLE => SitePage::OPEN_GRAPH_TYPE,
                                        Field::NAME => trans('narsil::validation.attributes.type'),
                                        Field::REQUIRED => true,
                                        Field::TYPE => SelectField::class,
                                        Field::RELATION_OPTIONS => OpenGraphTypeEnum::selectOptions(),
                                        Field::SETTINGS => app(SelectField::class)
                                            ->defaultValue(OpenGraphTypeEnum::WEBSITE->value)
                                            ->displayValue(false),
                                    ])
                                ]),
                                new BlockElement([
                                    BlockElement::RELATION_ELEMENT => new Field([
                                        Field::HANDLE => SitePage::OPEN_GRAPH_TITLE,
                                        Field::NAME => trans('narsil::validation.attributes.title'),
                                        Field::TRANSLATABLE => true,
                                        Field::TYPE => TextField::class,
                                        Field::SETTINGS => app(TextField::class),
                                    ])
                                ]),
                                new BlockElement([
                                    BlockElement::RELATION_ELEMENT => new Field([
                                        Field::HANDLE => SitePage::OPEN_GRAPH_DESCRIPTION,
                                        Field::NAME => trans('narsil::validation.attributes.description'),
                                        Field::TRANSLATABLE => true,
                                        Field::TYPE => TextareaField::class,
                                        Field::SETTINGS => app(TextareaField::class),
                                    ])
                                ]),
                                new BlockElement([
                                    BlockElement::RELATION_ELEMENT => new Field([
                                        Field::HANDLE => SitePage::OPEN_GRAPH_IMAGE,
                                        Field::NAME => trans('narsil::validation.attributes.image'),
                                        Field::TYPE => FileField::class,
                                        Field::SETTINGS => app(FileField::class)
                                            ->accept('image/*')
                                            ->icon('image'),
                                    ]),
                                ]),
                            ],
                        ]),
                    ]),
                ],
            ]),
            new TemplateSection([
                TemplateSection::HANDLE => 'Sitemap',
                TemplateSection::NAME => 'Sitemap',
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => SitePage::CHANGE_FREQ,
                            Field::NAME => trans('narsil::validation.attributes.change_freq'),
                            Field::REQUIRED => true,
                            Field::TYPE => SelectField::class,
                            Field::RELATION_OPTIONS => ChangeFreqEnum::selectOptions(),
                            Field::SETTINGS => app(SelectField::class)
                                ->defaultValue(ChangeFreqEnum::NEVER->value)
                                ->displayValue(false),
                        ])
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => SitePage::PRIORITY,
                            Field::NAME => trans('narsil::validation.attributes.priority'),
                            Field::REQUIRED => true,
                            Field::TYPE => RangeField::class,
                            Field::SETTINGS => app(RangeField::class)
                                ->defaultValue([1.0])
                                ->max(1)
                                ->min(0)
                                ->step(0.05),
                        ])
                    ]),
                ],
            ]),
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
