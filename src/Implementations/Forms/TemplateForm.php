<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\Fields\RelationsField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\BlockElementForm;
use Narsil\Contracts\Forms\TemplateForm as Contract;
use Narsil\Contracts\Forms\TemplateTabForm;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Block;
use Narsil\Models\Structures\BlockElement;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\Template;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;
use Narsil\Services\ModelService;
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
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Template::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        $blockSelectOptions = static::getBlockSelectOptions();
        $fieldSelectOptions = static::getFieldSelectOptions();
        $widthSelectOptions = static::getWidthSelectOptions();

        return [
            [
                TemplateTab::HANDLE => 'definition',
                TemplateTab::LABEL => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Template::TABLE_NAME,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.table_name'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Template::SINGULAR,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.singular'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::WIDTH => 50,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Template::PLURAL,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.plural'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::WIDTH => 50,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Template::RELATION_TABS,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.tabs'),
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::PLACEHOLDER => trans('narsil::ui.add_tab'),
                            Field::TYPE => RelationsField::class,
                            Field::SETTINGS => app(RelationsField::class)
                                ->form(app(TemplateTabForm::class)->jsonSerialize())
                                ->intermediate(
                                    label: trans('narsil::validation.attributes.tab'),
                                    optionLabel: TemplateTab::LABEL,
                                    optionValue: TemplateTab::HANDLE,
                                    relation: [
                                        BlockElement::HANDLE => TemplateTab::RELATION_ELEMENTS,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.elements'),
                                        BlockElement::RELATION_ELEMENT => [
                                            Field::TYPE => RelationsField::class,
                                            Field::SETTINGS => app(RelationsField::class)
                                                ->form(app(BlockElementForm::class)->jsonSerialize())
                                                ->addOption(
                                                    identifier: Block::TABLE,
                                                    label: ModelService::getModelLabel(Block::class),
                                                    optionLabel: TemplateTabElement::LABEL,
                                                    optionValue: TemplateTabElement::HANDLE,
                                                    options: $blockSelectOptions,
                                                    routes: RouteService::getNames(Block::TABLE),
                                                )
                                                ->addOption(
                                                    identifier: Field::TABLE,
                                                    label: ModelService::getModelLabel(Field::class),
                                                    optionLabel: TemplateTabElement::LABEL,
                                                    optionValue: TemplateTabElement::HANDLE,
                                                    options: $fieldSelectOptions,
                                                    routes: RouteService::getNames(Field::TABLE),
                                                )
                                                ->widthOptions($widthSelectOptions),
                                        ],
                                    ],
                                ),
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Get the block select options.
     *
     * @return array<SelectOption>
     */
    protected static function getBlockSelectOptions(): array
    {
        return Block::query()
            ->orderBy(Block::LABEL)
            ->get()
            ->map(function (Block $block)
            {
                $option = new SelectOption()
                    ->id($block->{Block::ID})
                    ->identifier($block->{Block::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($block->{Block::ATTRIBUTE_ICON})
                    ->optionLabel($block->getTranslations(Block::LABEL))
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
            ->orderBy(Field::LABEL)
            ->get()
            ->map(function (Field $field)
            {
                return new SelectOption()
                    ->id($field->{Field::ID})
                    ->identifier($field->{Field::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($field->{Field::ATTRIBUTE_ICON})
                    ->optionLabel($field->getTranslations(Field::LABEL))
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
