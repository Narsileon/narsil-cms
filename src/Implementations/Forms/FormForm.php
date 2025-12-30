<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\Fields\RelationsField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\FieldsetElementForm;
use Narsil\Contracts\Forms\FormTabForm;
use Narsil\Contracts\Forms\FormForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\Input;
use Narsil\Models\Forms\FormTab;
use Narsil\Models\Forms\FormTabElement;
use Narsil\Services\ModelService;
use Narsil\Services\RouteService;
use Narsil\Support\SelectOption;

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
    protected function getLayout(): array
    {
        $fieldsetSelectOptions = static::getFieldsetsSelectOptions();
        $inputSelectOptions = static::getInputSelectOptions();
        $widthSelectOptions = static::getWidthSelectOptions();

        return [
            new TemplateTab([
                TemplateTab::HANDLE => 'definition',
                TemplateTab::NAME => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Form::HANDLE,
                            Field::NAME => trans('narsil::validation.attributes.handle'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ])
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::WIDTH => 50,
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Form::TITLE,
                            Field::NAME => trans('narsil::validation.attributes.title'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ])
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::WIDTH => 50,
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Form::DESCRIPTION,
                            Field::NAME => trans('narsil::validation.attributes.description'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ])
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Form::RELATION_PAGES,
                            Field::NAME => trans('narsil::validation.attributes.pages'),
                            Field::TYPE => RelationsField::class,
                            Field::SETTINGS => app(RelationsField::class)
                                ->form(app(FormTabForm::class)->jsonSerialize())
                                ->intermediate(
                                    label: trans('narsil::ui.page'),
                                    optionLabel: FormTab::NAME,
                                    optionValue: FormTab::HANDLE,
                                    relation: new Field([
                                        Field::HANDLE => FormTab::RELATION_ELEMENTS,
                                        Field::NAME => trans('narsil::validation.attributes.elements'),
                                        Field::TYPE => RelationsField::class,
                                        Field::SETTINGS => app(RelationsField::class)
                                            ->form(app(FieldsetElementForm::class)->jsonSerialize())
                                            ->addOption(
                                                identifier: Fieldset::TABLE,
                                                label: ModelService::getModelLabel(Fieldset::class),
                                                optionLabel: FormTabElement::NAME,
                                                optionValue: FormTabElement::HANDLE,
                                                options: $fieldsetSelectOptions,
                                                routes: RouteService::getNames(Fieldset::TABLE),
                                            )
                                            ->addOption(
                                                identifier: Input::TABLE,
                                                label: ModelService::getModelLabel(Input::class),
                                                optionLabel: FormTabElement::NAME,
                                                optionValue: FormTabElement::HANDLE,
                                                options: $inputSelectOptions,
                                                routes: RouteService::getNames(Input::TABLE),
                                            )
                                            ->widthOptions($widthSelectOptions),
                                    ])
                                )
                                ->placeholder(trans('narsil::ui.add_tab')),
                        ]),
                    ]),
                ],
            ]),
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
            ->orderBy(Fieldset::NAME)
            ->get()
            ->map(function (Fieldset $fieldset)
            {
                $option = new SelectOption()
                    ->id($fieldset->{Fieldset::ID})
                    ->identifier($fieldset->{Fieldset::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($fieldset->{Fieldset::ATTRIBUTE_ICON})
                    ->optionLabel($fieldset->getTranslations(Fieldset::NAME))
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
            ->orderBy(Input::NAME)
            ->get()
            ->map(function (Input $input)
            {
                return new SelectOption()
                    ->id($input->{Input::ID})
                    ->identifier($input->{Input::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($input->{Input::ATTRIBUTE_ICON})
                    ->optionLabel($input->getTranslations(Input::NAME))
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
