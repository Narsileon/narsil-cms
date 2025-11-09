<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\FileField;
use Narsil\Contracts\Fields\RangeField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\TextareaField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\SitePageForm as Contract;
use Narsil\Enums\SEO\ChangeFreqEnum;
use Narsil\Enums\SEO\OpenGraphTypeEnum;
use Narsil\Enums\SEO\RobotsEnum;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
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
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->description(trans('narsil::models.' . Host::class))
            ->routes(RouteService::getNames(Host::TABLE))
            ->submitLabel(trans('narsil::ui.save'))
            ->title(trans('narsil::models.' . Host::class));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        return [
            new TemplateSection([
                TemplateSection::HANDLE => 'main',
                TemplateSection::NAME => trans('narsil::ui.main'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => SitePage::TITLE,
                            Field::NAME => trans('narsil::validation.attributes.title'),
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->required(true),
                        ])
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => SitePage::SLUG,
                            Field::NAME => trans('narsil::validation.attributes.slug'),
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->generate(SitePage::TITLE)
                                ->required(true),
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
                                        Field::TRANSLATABLE => true,
                                        Field::TYPE => TextareaField::class,
                                        Field::SETTINGS => app(TextareaField::class),
                                    ])
                                ]),
                                new BlockElement([
                                    BlockElement::RELATION_ELEMENT => new Field([
                                        Field::HANDLE => SitePage::ROBOTS,
                                        Field::NAME => trans('narsil::validation.attributes.robots'),
                                        Field::TYPE => SelectField::class,
                                        Field::RELATION_OPTIONS => RobotsEnum::options(),
                                        Field::SETTINGS => app(SelectField::class)
                                            ->defaultValue(RobotsEnum::ALL->value)
                                            ->displayValue(false)
                                            ->required(true),
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
                                        Field::TYPE => SelectField::class,
                                        Field::RELATION_OPTIONS => OpenGraphTypeEnum::options(),
                                        Field::SETTINGS => app(SelectField::class)
                                            ->defaultValue(OpenGraphTypeEnum::WEBSITE->value)
                                            ->displayValue(false)
                                            ->required(true),
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
                            Field::TYPE => SelectField::class,
                            Field::RELATION_OPTIONS => ChangeFreqEnum::options(),
                            Field::SETTINGS => app(SelectField::class)
                                ->defaultValue(ChangeFreqEnum::NEVER->value)
                                ->displayValue(false)
                                ->required(true),
                        ])
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => SitePage::PRIORITY,
                            Field::NAME => trans('narsil::validation.attributes.priority'),
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

    #endregion
}
