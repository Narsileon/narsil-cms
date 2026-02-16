<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Fields\RelationsField;
use Narsil\Cms\Contracts\Fields\SwitchField;
use Narsil\Cms\Contracts\Fields\TextField;
use Narsil\Cms\Contracts\Forms\BlockElementForm;
use Narsil\Cms\Contracts\Forms\BlockForm as Contract;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;
use Narsil\Cms\Services\ModelService;
use Narsil\Cms\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Block::TABLE));
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
                TemplateTab::LABEL => trans('narsil-cms::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::DESCRIPTION => ModelService::getAttributeDescription(Block::TABLE, Block::HANDLE),
                        TemplateTabElement::HANDLE => Block::HANDLE,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.handle'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::DESCRIPTION => ModelService::getAttributeDescription(Block::TABLE, Block::LABEL),
                        TemplateTabElement::HANDLE => Block::LABEL,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.label'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Block::COLLAPSIBLE,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.collapsible'),
                        TemplateTabElement::WIDTH => 50,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => SwitchField::class,
                            Field::SETTINGS => app(SwitchField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Block::VIRTUAL,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.virtual'),
                        TemplateTabElement::WIDTH => 50,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => SwitchField::class,
                            Field::SETTINGS => app(SwitchField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Block::RELATION_ELEMENTS,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.elements'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => RelationsField::class,
                            Field::SETTINGS => app(RelationsField::class)
                                ->form(app(BlockElementForm::class)->jsonSerialize())
                                ->addOption(
                                    identifier: Block::TABLE,
                                    label: ModelService::getModelLabel(Block::TABLE),
                                    optionLabel: BlockElement::LABEL,
                                    optionValue: BlockElement::HANDLE,
                                    options: $blockSelectOptions,
                                    routes: RouteService::getNames(Block::TABLE),
                                )
                                ->addOption(
                                    identifier: Field::TABLE,
                                    label: ModelService::getModelLabel(Field::TABLE),
                                    optionLabel: BlockElement::LABEL,
                                    optionValue: BlockElement::HANDLE,
                                    options: $fieldSelectOptions,
                                    routes: RouteService::getNames(Field::TABLE),
                                )
                                ->widthOptions($widthSelectOptions),
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

                $option = new SelectOption()
                    ->id($field->{Field::ID})
                    ->identifier($field->{Field::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($field->{Field::ATTRIBUTE_ICON})
                    ->optionLabel($field->getTranslations(Field::LABEL))
                    ->optionValue($field->{Field::HANDLE});

                return $option;
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
