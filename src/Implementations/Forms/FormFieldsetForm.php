<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Support\Str;
use Narsil\Contracts\Fields\RelationsField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\FormFieldsetForm as Contract;
use Narsil\Contracts\Forms\FormFieldsetElementForm;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
use Narsil\Models\Forms\FormFieldset;
use Narsil\Models\Forms\FormFieldsetElement;
use Narsil\Models\Forms\FormInput;
use Narsil\Services\RouteService;
use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormFieldsetForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->routes(RouteService::getNames(FormFieldset::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        $formInputSelectOptions = static::getFormInputSelectOptions();
        $widthSelectOptions = static::getWidthSelectOptions();

        return [
            new TemplateSection([
                TemplateSection::HANDLE => 'definition',
                TemplateSection::NAME => trans('narsil::ui.definition'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => FormFieldset::NAME,
                            Field::NAME => trans('narsil::ui.default_name'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => FormFieldset::HANDLE,
                            Field::NAME => trans('narsil::ui.default_handle'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => FormFieldset::RELATION_ELEMENTS,
                            Field::NAME => trans('narsil::validation.attributes.elements'),
                            Field::TYPE => RelationsField::class,
                            Field::SETTINGS => app(RelationsField::class)
                                ->form(app(FormFieldsetElementForm::class)->jsonSerialize())
                                ->addOption(
                                    identifier: FormInput::TABLE,
                                    label: Str::ucfirst(trans('narsil::models.' . FormInput::class)),
                                    optionLabel: FormFieldsetElement::NAME,
                                    optionValue: FormFieldsetElement::HANDLE,
                                    options: $formInputSelectOptions,
                                    routes: RouteService::getNames(FormInput::TABLE),
                                )
                                ->widthOptions($widthSelectOptions),
                        ]),
                    ]),
                ],
            ]),
        ];
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

                $option = new SelectOption()
                    ->id($formInput->{FormInput::ID})
                    ->identifier($formInput->{FormInput::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($formInput->{FormInput::ATTRIBUTE_ICON})
                    ->optionLabel($formInput->getTranslations(FormInput::NAME))
                    ->optionValue($formInput->{FormInput::HANDLE});

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
