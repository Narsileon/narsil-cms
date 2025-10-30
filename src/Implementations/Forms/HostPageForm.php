<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\FileField;
use Narsil\Contracts\Fields\RangeField;
use Narsil\Contracts\Fields\SelectField;
use Narsil\Contracts\Fields\TextareaField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\HostForm as Contract;
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
use Narsil\Models\Hosts\HostPage;
use Narsil\Services\RouteService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HostPageForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->setDescription(trans('narsil::models.' . Host::class))
            ->setRoutes(RouteService::getNames(Host::TABLE))
            ->setSubmitLabel(trans('narsil::ui.save'))
            ->setTitle(trans('narsil::models.' . Host::class));
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function layout(): array
    {
        return [
            static::mainSection([
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => HostPage::TITLE,
                        Field::NAME => trans('narsil::validation.attributes.title'),
                        Field::TRANSLATABLE => true,
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(TextField::class)
                            ->required(true),
                    ])
                ]),
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
                                        Field::HANDLE => HostPage::META_DESCRIPTION,
                                        Field::NAME => trans('narsil::validation.attributes.description'),
                                        Field::TRANSLATABLE => true,
                                        Field::TYPE => TextareaField::class,
                                        Field::SETTINGS => app(TextareaField::class),
                                    ])
                                ]),
                                new BlockElement([
                                    BlockElement::RELATION_ELEMENT => new Field([
                                        Field::HANDLE => HostPage::ROBOTS,
                                        Field::NAME => trans('narsil::validation.attributes.robots'),
                                        Field::TYPE => SelectField::class,
                                        Field::SETTINGS => app(SelectField::class)
                                            ->defaultValue(RobotsEnum::ALL->value)
                                            ->displayValue(false)
                                            ->options(RobotsEnum::options())
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
                                        Field::HANDLE => HostPage::OPEN_GRAPH_TYPE,
                                        Field::NAME => trans('narsil::validation.attributes.type'),
                                        Field::TYPE => SelectField::class,
                                        Field::SETTINGS => app(SelectField::class)
                                            ->defaultValue(OpenGraphTypeEnum::WEBSITE->value)
                                            ->displayValue(false)
                                            ->options(OpenGraphTypeEnum::options())
                                            ->required(true),
                                    ])
                                ]),
                                new BlockElement([
                                    BlockElement::RELATION_ELEMENT => new Field([
                                        Field::HANDLE => HostPage::OPEN_GRAPH_TITLE,
                                        Field::NAME => trans('narsil::validation.attributes.title'),
                                        Field::TRANSLATABLE => true,
                                        Field::TYPE => TextField::class,
                                        Field::SETTINGS => app(TextField::class),
                                    ])
                                ]),
                                new BlockElement([
                                    BlockElement::RELATION_ELEMENT => new Field([
                                        Field::HANDLE => HostPage::OPEN_GRAPH_DESCRIPTION,
                                        Field::NAME => trans('narsil::validation.attributes.description'),
                                        Field::TRANSLATABLE => true,
                                        Field::TYPE => TextareaField::class,
                                        Field::SETTINGS => app(TextareaField::class),
                                    ])
                                ]),
                                new BlockElement([
                                    BlockElement::RELATION_ELEMENT => new Field([
                                        Field::HANDLE => HostPage::OPEN_GRAPH_IMAGE,
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
                            Field::HANDLE => HostPage::CHANGE_FREQ,
                            Field::NAME => trans('narsil::validation.attributes.change_freq'),
                            Field::TYPE => SelectField::class,
                            Field::SETTINGS => app(SelectField::class)
                                ->defaultValue(ChangeFreqEnum::NEVER->value)
                                ->displayValue(false)
                                ->options(ChangeFreqEnum::options())
                                ->required(true),
                        ])
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => HostPage::PRIORITY,
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
            static::informationSection(),
        ];
    }

    #endregion
}
