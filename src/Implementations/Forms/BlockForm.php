<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\RelationsField;
use Narsil\Contracts\Fields\TextField;
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
 * @author Jonathan Rigaux
 * @version 1.0.0
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
        $this->routes = RouteService::getNames(Block::TABLE);
        $this->submitLabel = trans('narsil::ui.save');
        $this->title = trans('narsil::models.block');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function layout(): array
    {
        $blockOptions = static::getBlockOptions();
        $fieldOptions = static::getFieldOptions();
        $setOptions = static::getSetOptions();
        $widthOptions = static::getWidthOptions();

        return [
            static::mainSection([
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Block::NAME,
                        Field::NAME => trans('narsil::ui.default_name'),
                        Field::TRANSLATABLE => true,
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(TextField::class)
                            ->setRequired(true),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Block::HANDLE,
                        Field::NAME => trans('narsil::ui.default_handle'),
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(TextField::class)
                            ->setRequired(true),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Block::COLLAPSIBLE,
                        Field::NAME => trans('narsil::validation.attributes.collapsible'),
                        Field::TYPE => CheckboxField::class,
                        Field::SETTINGS => app(CheckboxField::class),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Block::RELATION_ELEMENTS,
                        Field::NAME => trans('narsil::validation.attributes.elements'),
                        Field::TYPE => RelationsField::class,
                        Field::SETTINGS => app(RelationsField::class)
                            ->setForm(app(BlockElementForm::class)->jsonSerialize())
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
                            ->setWidthOptions($widthOptions),
                    ]),
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Block::RELATION_SETS,
                        Field::NAME => trans('narsil::validation.attributes.sets'),
                        Field::TYPE => RelationsField::class,
                        Field::SETTINGS => app(RelationsField::class)
                            ->addOption(
                                identifier: Block::TABLE,
                                label: trans('narsil::models.block'),
                                optionLabel: BlockElement::NAME,
                                optionValue: BlockElement::HANDLE,
                                options: $setOptions,
                                routes: RouteService::getNames(Block::TABLE),
                            )
                            ->setUnique(true),
                    ]),
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
            ->whereDoesntHave(Block::RELATION_SETS)
            ->orderBy(Block::NAME)
            ->get()
            ->map(function (Block $block)
            {
                return new SelectOption(
                    label: $block->getTranslations(Block::NAME),
                    value: $block->{Block::HANDLE},
                )
                    ->setIcon($block->{Block::ATTRIBUTE_ICON})
                    ->setId($block->{Block::ID})
                    ->setIdentifier($block->{Block::ATTRIBUTE_IDENTIFIER});
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
                return new SelectOption(
                    label: $field->getTranslations(Field::NAME),
                    value: $field->{Field::HANDLE},
                )
                    ->setIcon($field->{Field::ATTRIBUTE_ICON})
                    ->setId($field->{Field::ID})
                    ->setIdentifier($field->{Field::ATTRIBUTE_IDENTIFIER});
            })
            ->toArray();
    }

    /**
     * @return array
     */
    protected static function getSetOptions(): array
    {
        return Block::query()
            ->orderBy(Block::NAME)
            ->get()
            ->map(function (Block $block)
            {
                return new SelectOption(
                    label: $block->getTranslations(Block::NAME),
                    value: $block->{Block::HANDLE},
                )
                    ->setIcon($block->{Block::ATTRIBUTE_ICON})
                    ->setId($block->{Block::ID})
                    ->setIdentifier($block->{Block::ATTRIBUTE_IDENTIFIER});
            })
            ->toArray();
    }

    /**
     * @return array
     */
    protected static function getWidthOptions(): array
    {
        return [
            new SelectOption('25%', '25'),
            new SelectOption('33%', '33'),
            new SelectOption('50%', '50'),
            new SelectOption('67%', '67'),
            new SelectOption('75%', '75'),
            new SelectOption('100%', '100'),
        ];
    }

    #endregion
}
