<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\RelationsInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\BlockElementForm;
use Narsil\Contracts\Forms\BlockForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Services\RouteService;
use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->description = trans('narsil::models.block');
        $this->title = trans('narsil::models.block');
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
                        Field::HANDLE => Block::NAME,
                        Field::NAME => trans('narsil::ui.default_name'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ])
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Block::HANDLE,
                        Field::NAME => trans('narsil::ui.default_handle'),
                        Field::TYPE => TextInput::class,
                        Field::SETTINGS => app(TextInput::class)
                            ->required(true),
                    ])
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Block::RELATION_ELEMENTS,
                        Field::NAME => trans('narsil::validation.attributes.elements'),
                        Field::TYPE => RelationsInput::class,
                        Field::SETTINGS => app(RelationsInput::class)
                            ->form(app(BlockElementForm::class)->jsonSerialize())
                            ->addOption(
                                identifier: Block::TABLE,
                                label: trans('narsil::models.block'),
                                optionLabel: BlockElement::NAME,
                                optionValue: BlockElement::HANDLE,
                                options: $blockOptions,
                                routes: RouteService::getNames(Block::TABLE),
                            )
                            ->addOption(
                                identifier: Field::TABLE,
                                label: trans('narsil::models.field'),
                                optionLabel: BlockElement::NAME,
                                optionValue: BlockElement::HANDLE,
                                options: $fieldOptions,
                                routes: RouteService::getNames(Field::TABLE),
                            )
                            ->widthOptions($widthOptions),
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
