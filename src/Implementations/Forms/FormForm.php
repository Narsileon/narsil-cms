<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Cms\Contracts\Fields\RelationsField;
use Narsil\Cms\Contracts\Fields\TableField;
use Narsil\Cms\Contracts\Fields\TextField;
use Narsil\Cms\Contracts\Forms\FieldsetElementForm;
use Narsil\Cms\Contracts\Forms\FormForm as Contract;
use Narsil\Cms\Contracts\Forms\FormStepForm;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;
use Narsil\Cms\Models\Forms\Fieldset;
use Narsil\Cms\Models\Forms\Form;
use Narsil\Cms\Models\Forms\FormStep;
use Narsil\Cms\Models\Forms\FormStepElement;
use Narsil\Cms\Models\Forms\FormWebhook;
use Narsil\Cms\Models\Forms\Input;
use Narsil\Cms\Services\ModelService;
use Narsil\Cms\Services\RouteService;
use Narsil\Cms\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Form::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        $fieldsetSelectOptions = static::getFieldsetsSelectOptions();
        $inputSelectOptions = static::getInputSelectOptions();
        $widthSelectOptions = static::getWidthSelectOptions();

        return [
            [
                TemplateTab::HANDLE => 'definition',
                TemplateTab::LABEL => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Form::SLUG,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.slug'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Form::RELATION_WEBHOOKS,
                        TemplateTabElement::LABEL => ModelService::getTableLabel(FormWebhook::TABLE),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TableField::class,
                            Field::SETTINGS => app(TableField::class)
                                ->columns([
                                    [
                                        BlockElement::HANDLE => FormWebhook::URL,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.url'),
                                        BlockElement::REQUIRED => true,
                                        BlockElement::RELATION_BASE => [
                                            Field::TYPE => TextField::class,
                                            Field::SETTINGS => app(TextField::class),
                                        ],
                                    ],
                                ]),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Form::RELATION_STEPS,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.steps'),
                        TemplateTabElement::RELATION_BASE => [
                            Field::PLACEHOLDER => trans('narsil::ui.add_tab'),
                            Field::TYPE => RelationsField::class,
                            Field::SETTINGS => app(RelationsField::class)
                                ->form(app(FormStepForm::class)->jsonSerialize())
                                ->intermediate(
                                    label: trans('narsil::ui.page'),
                                    optionLabel: FormStep::LABEL,
                                    optionValue: FormStep::HANDLE,
                                    relation: [
                                        BlockElement::HANDLE => FormStep::RELATION_ELEMENTS,
                                        BlockElement::LABEL => trans('narsil::validation.attributes.elements'),
                                        BlockElement::RELATION_BASE => [
                                            Field::TYPE => RelationsField::class,
                                            Field::SETTINGS => app(RelationsField::class)
                                                ->form(app(FieldsetElementForm::class)->jsonSerialize())
                                                ->addOption(
                                                    identifier: Fieldset::TABLE,
                                                    label: ModelService::getModelLabel(Fieldset::class),
                                                    optionLabel: FormStepElement::LABEL,
                                                    optionValue: FormStepElement::HANDLE,
                                                    options: $fieldsetSelectOptions,
                                                    routes: RouteService::getNames(Fieldset::TABLE),
                                                )
                                                ->addOption(
                                                    identifier: Input::TABLE,
                                                    label: ModelService::getModelLabel(Input::class),
                                                    optionLabel: FormStepElement::LABEL,
                                                    optionValue: FormStepElement::HANDLE,
                                                    options: $inputSelectOptions,
                                                    routes: RouteService::getNames(Input::TABLE),
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
     * Get the form fieldset select options.
     *
     * @return array<SelectOption>
     */
    protected static function getFieldsetsSelectOptions(): array
    {
        return Fieldset::query()
            ->orderBy(Fieldset::LABEL)
            ->get()
            ->map(function (Fieldset $fieldset)
            {
                $option = new SelectOption()
                    ->id($fieldset->{Fieldset::ID})
                    ->identifier($fieldset->{Fieldset::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($fieldset->{Fieldset::ATTRIBUTE_ICON})
                    ->optionLabel($fieldset->getTranslations(Fieldset::LABEL))
                    ->optionValue($fieldset->{Fieldset::HANDLE});

                return $option;
            })
            ->toArray();
    }

    /**
     * Get the input select options.
     *
     * @return array<SelectOption>
     */
    protected static function getInputSelectOptions(): array
    {
        return Input::query()
            ->orderBy(Input::LABEL)
            ->get()
            ->map(function (Input $input)
            {
                return new SelectOption()
                    ->id($input->{Input::ID})
                    ->identifier($input->{Input::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($input->{Input::ATTRIBUTE_ICON})
                    ->optionLabel($input->getTranslations(Input::LABEL))
                    ->optionValue($input->{Input::HANDLE});
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
