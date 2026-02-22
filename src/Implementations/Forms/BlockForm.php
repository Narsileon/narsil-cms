<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\SwitchInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Implementations\Form;
use Narsil\Base\Services\ModelService;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Forms\BlockElementForm;
use Narsil\Cms\Contracts\Forms\BlockForm as Contract;
use Narsil\Cms\Http\Data\Forms\Inputs\RelationsInputData;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockForm extends Form implements Contract
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
    protected function getSteps(): array
    {
        $blockSelectOptions = static::getBlockSelectOptions();
        $fieldSelectOptions = static::getFieldSelectOptions();
        $widthSelectOptions = static::getWidthSelectOptions();

        return [
            new FormStepData(
                elements: [
                    new FieldData(
                        description: ModelService::getAttributeDescription(Block::TABLE, Block::HANDLE),
                        id: Block::HANDLE,
                        required: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        description: ModelService::getAttributeDescription(Block::TABLE, Block::LABEL),
                        id: Block::LABEL,
                        required: true,
                        translatable: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: Block::COLLAPSIBLE,
                        width: 50,
                        input: new SwitchInputData(),
                    ),
                    new FieldData(
                        id: Block::VIRTUAL,
                        width: 50,
                        input: new SwitchInputData(),
                    ),
                    new FieldData(
                        id: Block::RELATION_ELEMENTS,
                        input: new RelationsInputData()
                            ->set('form', app(BlockElementForm::class))
                            ->widthOptions($widthSelectOptions)
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
                            ),
                    ),
                ],
            ),
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
