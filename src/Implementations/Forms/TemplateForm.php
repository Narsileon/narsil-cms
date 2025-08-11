<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\RelationsInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\BlockElementForm;
use Narsil\Contracts\Forms\TemplateForm as Contract;
use Narsil\Contracts\Forms\TemplateSectionForm;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Services\RouteService;
use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->description = trans('narsil::ui.template');
        $this->title = trans('narsil::ui.template');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function form(): array
    {
        $blockOptions = static::getBlockOptions();
        $fieldOptions = static::getFieldOptions();
        $widthOptions = static::getWidthOptions();

        return [
            static::mainSection([
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Template::NAME,
                        Field::NAME => trans('narsil::validation.attributes.name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ])
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Template::HANDLE,
                        Field::NAME => trans('narsil::validation.attributes.handle'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ])
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Template::RELATION_SECTIONS,
                        Field::NAME => trans('narsil::validation.attributes.elements'),
                        Field::TYPE => RelationsInput::class,
                        Field::SETTINGS => app(RelationsInput::class)
                            ->form(app(TemplateSectionForm::class)->jsonSerialize())
                            ->setIntermediate(
                                label: trans('narsil::ui.section'),
                                optionLabel: TemplateSection::NAME,
                                optionValue: TemplateSection::HANDLE,
                                relation: new Field([
                                    Field::HANDLE => TemplateSection::RELATION_ELEMENTS,
                                    Field::NAME => trans('narsil::validation.attributes.elements'),
                                    Field::TYPE => RelationsInput::class,
                                    Field::SETTINGS => app(RelationsInput::class)
                                        ->form(app(BlockElementForm::class)->jsonSerialize())
                                        ->addOption(
                                            identifier: Block::TABLE,
                                            label: trans('narsil::ui.block'),
                                            optionLabel: BlockElement::NAME,
                                            optionValue: BlockElement::HANDLE,
                                            options: $blockOptions,
                                            routes: RouteService::getNames(Block::TABLE),
                                        )
                                        ->addOption(
                                            identifier: Field::TABLE,
                                            label: trans('narsil::ui.field'),
                                            optionLabel: BlockElement::NAME,
                                            optionValue: BlockElement::HANDLE,
                                            options: $fieldOptions,
                                            routes: RouteService::getNames(Field::TABLE),
                                        )
                                        ->widthOptions($widthOptions),
                                ])
                            )
                            ->placeholder(trans('narsil::ui.add_section')),
                    ])
                ]),
            ]),
            static::informationSection(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @return array
     */
    protected static function getBlockOptions(): array
    {
        return Block::query()
            ->orderBy(Block::NAME)
            ->get()
            ->map(function (Block $block)
            {
                return (new SelectOption($block->{Block::NAME}, $block->{Block::HANDLE}))
                    ->icon($block->{Block::ATTRIBUTE_ICON})
                    ->identifier($block->{Block::ATTRIBUTE_IDENTIFIER});
            })
            ->toArray();
    }

    /**
     * @return array
     */
    protected static function getFieldOptions(): array
    {
        return Field::query()
            ->orderBy(Field::NAME)
            ->get()
            ->map(function (Field $field)
            {
                return (new SelectOption($field->{Field::NAME}, $field->{Field::HANDLE}))
                    ->icon($field->{Field::ATTRIBUTE_ICON})
                    ->identifier($field->{Field::ATTRIBUTE_IDENTIFIER});
            })
            ->toArray();
    }

    /**
     * @return array
     */
    protected static function getWidthOptions(): array
    {
        return [
            new SelectOption('25%', 25),
            new SelectOption('33%', 33),
            new SelectOption('50%', 50),
            new SelectOption('67%', 67),
            new SelectOption('75%', 75),
            new SelectOption('100%', 100),
        ];
    }

    #endregion
}
