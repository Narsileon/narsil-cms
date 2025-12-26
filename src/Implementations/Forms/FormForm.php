<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\RelationsField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\FormFieldsetElementForm;
use Narsil\Contracts\Forms\FormPageForm;
use Narsil\Contracts\Forms\FormForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateSection;
use Narsil\Models\Structures\TemplateSectionElement;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\FormFieldset;
use Narsil\Models\Forms\FormInput;
use Narsil\Models\Forms\FormPage;
use Narsil\Models\Forms\FormPageElement;
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
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->routes(RouteService::getNames(Form::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        $formFieldsetSelectOptions = static::getFormFieldsetsSelectOptions();
        $formInputSelectOptions = static::getFormInputSelectOptions();
        $widthSelectOptions = static::getWidthSelectOptions();

        return [
            new TemplateSection([
                TemplateSection::HANDLE => 'definition',
                TemplateSection::NAME => trans('narsil::ui.definition'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Form::HANDLE,
                            Field::NAME => trans('narsil::validation.attributes.handle'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ])
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::WIDTH => 50,
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Form::TITLE,
                            Field::NAME => trans('narsil::validation.attributes.title'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ])
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::WIDTH => 50,
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Form::DESCRIPTION,
                            Field::NAME => trans('narsil::validation.attributes.description'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ])
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Form::RELATION_PAGES,
                            Field::NAME => trans('narsil::validation.attributes.pages'),
                            Field::TYPE => RelationsField::class,
                            Field::SETTINGS => app(RelationsField::class)
                                ->form(app(FormPageForm::class)->jsonSerialize())
                                ->intermediate(
                                    label: trans('narsil::ui.page'),
                                    optionLabel: FormPage::NAME,
                                    optionValue: FormPage::HANDLE,
                                    relation: new Field([
                                        Field::HANDLE => FormPage::RELATION_ELEMENTS,
                                        Field::NAME => trans('narsil::validation.attributes.elements'),
                                        Field::TYPE => RelationsField::class,
                                        Field::SETTINGS => app(RelationsField::class)
                                            ->form(app(FormFieldsetElementForm::class)->jsonSerialize())
                                            ->addOption(
                                                identifier: FormFieldset::TABLE,
                                                label: ModelService::getModelLabel(FormFieldset::class),
                                                optionLabel: FormPageElement::NAME,
                                                optionValue: FormPageElement::HANDLE,
                                                options: $formFieldsetSelectOptions,
                                                routes: RouteService::getNames(FormFieldset::TABLE),
                                            )
                                            ->addOption(
                                                identifier: FormInput::TABLE,
                                                label: ModelService::getModelLabel(FormInput::class),
                                                optionLabel: FormPageElement::NAME,
                                                optionValue: FormPageElement::HANDLE,
                                                options: $formInputSelectOptions,
                                                routes: RouteService::getNames(FormInput::TABLE),
                                            )
                                            ->widthOptions($widthSelectOptions),
                                    ])
                                )
                                ->placeholder(trans('narsil::ui.add_section')),
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
    protected static function getFormFieldsetsSelectOptions(): array
    {
        return FormFieldset::query()
            ->orderBy(FormFieldset::NAME)
            ->get()
            ->map(function (FormFieldset $formFieldset)
            {
                $option = new SelectOption()
                    ->id($formFieldset->{FormFieldset::ID})
                    ->identifier($formFieldset->{FormFieldset::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($formFieldset->{FormFieldset::ATTRIBUTE_ICON})
                    ->optionLabel($formFieldset->getTranslations(FormFieldset::NAME))
                    ->optionValue($formFieldset->{FormFieldset::HANDLE});

                return $option;
            })
            ->toArray();
    }

    /**
     * Get the form input select options.
     *
     * @return array<SelectOption>
     */
    protected static function getFormInputSelectOptions(): array
    {
        return FormInput::query()
            ->orderBy(FormInput::NAME)
            ->get()
            ->map(function (FormInput $formInput)
            {
                return new SelectOption()
                    ->id($formInput->{FormInput::ID})
                    ->identifier($formInput->{FormInput::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($formInput->{FormInput::ATTRIBUTE_ICON})
                    ->optionLabel($formInput->getTranslations(FormInput::NAME))
                    ->optionValue($formInput->{FormInput::HANDLE});
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
