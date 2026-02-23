<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Http\Data\OptionData;
use Narsil\Base\Implementations\Form;
use Narsil\Base\Services\ModelService;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Forms\TemplateForm as Contract;
use Narsil\Cms\Contracts\Forms\TemplateTabElementForm;
use Narsil\Cms\Contracts\Forms\TemplateTabForm;
use Narsil\Cms\Http\Data\Forms\Inputs\RelationsInputData;
use Narsil\Cms\Models\Collections\Block;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Collections\TemplateTab;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateForm extends Form implements Contract
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
    protected function getSteps(): array
    {
        $blockOptions = static::getBlockOptions();
        $fieldOptions = static::getFieldOptions();

        return [
            new FormStepData(
                id: 'definition',
                label: trans('narsil::ui.definition'),
                elements: [
                    new FieldData(
                        id: Template::TABLE_NAME,
                        required: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: Template::SINGULAR,
                        required: true,
                        translatable: true,
                        width: 50,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: Template::PLURAL,
                        required: true,
                        translatable: true,
                        width: 50,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: Template::RELATION_TABS,
                        input: new RelationsInputData()
                            ->set('form', app(TemplateTabForm::class))
                            ->intermediate(
                                label: trans('narsil-cms::validation.attributes.tab'),
                                optionLabel: TemplateTab::LABEL,
                                optionValue: TemplateTab::HANDLE,
                                relation: new FieldData(
                                    id: TemplateTab::RELATION_ELEMENTS,
                                    input: new RelationsInputData()
                                        ->set('form', app(TemplateTabElementForm::class))
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
