<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\RelationsField;
use Narsil\Contracts\Fields\TextField;
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

        $this
            ->setDescription(trans('narsil::models.' . Template::class))
            ->setRoutes(RouteService::getNames(Template::TABLE))
            ->setSubmitLabel(trans('narsil::ui.save'))
            ->setTitle(trans('narsil::models.' . Template::class));
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
                        Field::HANDLE => Template::NAME,
                        Field::NAME => trans('narsil::validation.attributes.name'),
                        Field::TRANSLATABLE => true,
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(TextField::class)
                            ->setRequired(true),
                    ])
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Template::HANDLE,
                        Field::NAME => trans('narsil::validation.attributes.handle'),
                        Field::TYPE => TextField::class,
                        Field::SETTINGS => app(TextField::class)
                            ->setRequired(true),
                    ])
                ]),
                new TemplateSectionElement([
                    TemplateSectionElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Template::RELATION_SECTIONS,
                        Field::NAME => trans('narsil::validation.attributes.sections'),
                        Field::TYPE => RelationsField::class,
                        Field::SETTINGS => app(RelationsField::class)
                            ->setForm(app(TemplateSectionForm::class)->jsonSerialize())
                            ->setIntermediate(
                                label: trans('narsil::ui.section'),
                                optionLabel: TemplateSection::NAME,
                                optionValue: TemplateSection::HANDLE,
                                relation: new Field([
                                    Field::HANDLE => TemplateSection::RELATION_ELEMENTS,
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
                                ])
                            )
                            ->setPlaceholder(trans('narsil::ui.add_section')),
                    ])
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
                $option = new SelectOption()
                    ->id($block->{Block::ID})
                    ->identifier($block->{Block::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($block->{Block::ATTRIBUTE_ICON})
                    ->optionLabel($block->getTranslations(Block::NAME))
                    ->optionValue($block->{Block::HANDLE});

                return $option;
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
                return new SelectOption()
                    ->id($field->{Field::ID})
                    ->identifier($field->{Field::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($field->{Field::ATTRIBUTE_ICON})
                    ->optionLabel($field->getTranslations(Field::NAME))
                    ->optionValue($field->{Field::HANDLE});
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
        $widths = [25, 33, 50, 67, 75, 100];

        $options = [];

        foreach ($widths as $width)
        {
            $options[] = new SelectOption()
                ->optionLabel($width . '%')
                ->optionValue($width);
        }

        return $options;
    }

    #endregion
}
