<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\SwitchInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Http\Data\OptionData;
use Narsil\Base\Implementations\Form;
use Narsil\Base\Services\ModelService;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Forms\BlockElementForm;
use Narsil\Cms\Contracts\Forms\BlockForm as Contract;
use Narsil\Cms\Http\Data\Forms\Inputs\RelationsInputData;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;

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
        $blockOptions = static::getBlockOptions();
        $fieldOptions = static::getFieldOptions();

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
                            ->addOption(
                                identifier: Block::TABLE,
                                label: ModelService::getModelLabel(Block::TABLE),
                                optionLabel: BlockElement::LABEL,
                                optionValue: BlockElement::HANDLE,
                                options: $blockOptions,
                                routes: RouteService::getNames(Block::TABLE),
                            )
                            ->addOption(
                                identifier: Field::TABLE,
                                label: ModelService::getModelLabel(Field::TABLE),
                                optionLabel: BlockElement::LABEL,
                                optionValue: BlockElement::HANDLE,
                                options: $fieldOptions,
                                routes: RouteService::getNames(Field::TABLE),
                            ),
                    ),
                ],
            ),
        ];
    }

    /**
     * Get the block options.
     *
     * @return OptionData[]
     */
    protected static function getBlockOptions(): array
    {
        return Block::query()
            ->orderBy(Block::LABEL)
            ->get()
            ->map(function (Block $block)
            {
                $option = new OptionData(
                    label: $block->getTranslations(Block::LABEL),
                    value: $block->{Block::HANDLE},
                )
                    ->icon($block->{Block::ATTRIBUTE_ICON})
                    ->id($block->{Block::ID})
                    ->identifier($block->{Block::ATTRIBUTE_IDENTIFIER});

                return $option;
            })
            ->toArray();
    }

    /**
     * Get the field options.
     *
     * @return OptionData[]
     */
    protected static function getFieldOptions(): array
    {
        return Field::query()
            ->orderBy(Field::LABEL)
            ->get()
            ->map(function (Field $field)
            {

                $option = new OptionData(
                    label: $field->getTranslations(Field::LABEL),
                    value: $field->{Field::HANDLE},
                )
                    ->icon($field->{Field::ATTRIBUTE_ICON})
                    ->id($field->{Field::ID})
                    ->identifier($field->{Field::ATTRIBUTE_IDENTIFIER});

                return $option;
            })
            ->toArray();
    }

    #endregion
}
