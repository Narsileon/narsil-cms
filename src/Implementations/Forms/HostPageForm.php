<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\FileField;
use Narsil\Contracts\Fields\RichTextField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\HostForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Models\Hosts\Host;
use Narsil\Models\Hosts\HostPage;
use Narsil\Services\RouteService;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class HostForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->setDescription(trans('narsil::models.host'))
            ->setRoutes(RouteService::getNames(Host::TABLE))
            ->setSubmitLabel(trans('narsil::ui.save'))
            ->setTitle(trans('narsil::models.host'));
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
                    TemplateSectionElement::RELATION_ELEMENT => new Block([
                        Block::NAME => 'Meta',
                        Block::RELATION_ELEMENTS => [
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
                                    Field::TYPE => RichTextField::class,
                                    Field::SETTINGS => app(RichTextField::class),
                                ])
                            ]),
                            new BlockElement([
                                BlockElement::RELATION_ELEMENT => new Field([
                                    Field::HANDLE => HostPage::ROBOTS,
                                    Field::NAME => trans('narsil::validation.attributes.robots'),
                                    Field::TRANSLATABLE => true,
                                    Field::TYPE => TextField::class,
                                    Field::SETTINGS => app(TextField::class),
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
                                    Field::TYPE => TextField::class,
                                    Field::SETTINGS => app(TextField::class),
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
                                    Field::TYPE => RichTextField::class,
                                    Field::SETTINGS => app(RichTextField::class),
                                ])
                            ]),
                            new BlockElement([
                                BlockElement::RELATION_ELEMENT => new Field([
                                    Field::HANDLE => HostPage::OPEN_GRAPH_IMAGE,
                                    Field::NAME => trans('narsil::validation.attributes.image'),
                                    Field::TYPE => FileField::class,
                                    Field::SETTINGS => app(FileField::class)
                                        ->setAccept('image/*')
                                        ->setIcon('image'),
                                ]),
                            ]),
                        ],
                    ]),
                ]),
            ]),
            static::informationSection(),
        ];
    }

    #endregion
}
