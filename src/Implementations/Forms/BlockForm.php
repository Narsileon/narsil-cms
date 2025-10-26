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

        $this
            ->setDescription(trans('narsil::models.' . Block::class))
            ->setRoutes(RouteService::getNames(Block::TABLE))
            ->setSubmitLabel(trans('narsil::ui.save'))
            ->setTitle(trans('narsil::models.' . Block::class));
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function layout(): array
    {
        $blockSelectOptions = static::getBlockSelectOptions();
        $fieldSelectOptions = static::getFieldSelectOptions();
        $widthSelectOptions = static::getWidthSelectOptions();

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
                                label: trans('narsil::models.' . Block::class),
                                optionLabel: BlockElement::NAME,
                                optionValue: BlockElement::HANDLE,
                                options: $blockSelectOptions,
                                routes: RouteService::getNames(Block::TABLE),
                            )
                            ->addOption(
                                identifier: Field::TABLE,
                                label: trans('narsil::models.' . Field::class),
                                optionLabel: BlockElement::NAME,
                                optionValue: BlockElement::HANDLE,
                                options: $fieldSelectOptions,
                                routes: RouteService::getNames(Field::TABLE),
                            )
                            ->setWidthOptions($widthSelectOptions),
                    ]),
                ]),
            ]),
            static::informationSection(),
        ];
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * Get the block select options.
     *
     * @return array<SelectOption>
     */
    protected static function getBlockSelectOptions(): array
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
     * Get the field select options.
     *
     * @return array<SelectOption>
     */
    protected static function getFieldSelectOptions(): array
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
     * Get the width select options.
     *
     * @return array<SelectOption>
     */
    protected static function getWidthSelectOptions(): array
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
