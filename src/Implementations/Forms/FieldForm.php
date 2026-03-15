<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Narsil\Base\Helpers\Translator;
use Narsil\Base\Http\Data\Forms\FieldData;
use Narsil\Base\Http\Data\Forms\FieldsetData;
use Narsil\Base\Http\Data\Forms\FormStepData;
use Narsil\Base\Http\Data\Forms\Inputs\CheckboxInputData;
use Narsil\Base\Http\Data\Forms\Inputs\SelectInputData;
use Narsil\Base\Http\Data\Forms\Inputs\TextInputData;
use Narsil\Base\Http\Data\OptionData;
use Narsil\Base\Implementations\Form;
use Narsil\Base\Services\FormService;
use Narsil\Base\Services\ModelService;
use Narsil\Base\Services\RouteService;
use Narsil\Cms\Contracts\Forms\FieldForm as Contract;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\ValidationRule;

#endregion

/**
 * @author Jonathan Rigaux
 */
class FieldForm extends Form implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Field::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getSteps(): array
    {
        $validationRuleOptions = FormService::getOptions(ValidationRule::class);

        $settings = [];

        $type = request()->input(Field::TYPE);

        if ($type)
        {
            $concrete = Config::get("narsil.fields.$type");

            $settings = $concrete::getInputForm(Field::SETTINGS);
        }

        $typeOptions = static::getTypeOptions();

        return [
            new FormStepData(
                id: 'definition',
                label: trans('narsil-cms::ui.definition'),
                elements: [
                    new FieldData(
                        id: Field::HANDLE,
                        description: ModelService::getAttributeDescription(Field::TABLE, Field::HANDLE),
                        required: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: Field::LABEL,
                        description: ModelService::getAttributeDescription(Field::TABLE, Field::LABEL),
                        required: true,
                        translatable: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: Field::DESCRIPTION,
                        description: ModelService::getAttributeDescription(Field::TABLE, Field::DESCRIPTION),
                        translatable: true,
                        input: new TextInputData(),
                    ),
                    new FieldData(
                        id: Field::TYPE,
                        required: true,
                        input: new SelectInputData(
                            options: $typeOptions,
                        )
                            ->reload('form'),
                    ),
                    ...($settings ? [
                        new FieldsetData(
                            id: Field::SETTINGS,
                            label: trans('narsil-cms::ui.settings'),
                            elements: $settings,
                        ),
                    ] : []),
                ],
            ),
            new FormStepData(
                id: 'validation',
                label: trans('narsil-cms::ui.validation'),
                elements: [
                    new FieldData(
                        id: Field::RELATION_VALIDATION_RULES,
                        label: trans('narsil-cms::ui.rules'),
                        input: new CheckboxInputData(
                            options: $validationRuleOptions->toArray(),
                        ),
                    ),
                ],
            ),
        ];
    }

    /**
     * Get the type options.
     *
     * @return array<OptionData>
     */
    protected static function getTypeOptions(): array
    {
        $options = [];

        foreach (Config::get('narsil.fields', []) as $type => $input)
        {
            $label = Translator::trans("inputs.$type");

            $options[] = new OptionData(
                value: $type,
                label: $label,
            );
        }

        usort($options, function (OptionData $a, OptionData $b)
        {
            return strcmp($a->label, $b->label);
        });

        return $options;
    }

    #endregion
}
