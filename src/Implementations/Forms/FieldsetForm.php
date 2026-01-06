<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\Fields\RelationsField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\FieldsetForm as Contract;
use Narsil\Contracts\Forms\FieldsetElementForm;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\FieldsetElement;
use Narsil\Models\Forms\Input;
use Narsil\Services\ModelService;
use Narsil\Services\RouteService;
use Narsil\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FieldsetForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Fieldset::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        $inputSelectOptions = static::getInputSelectOptions();
        $widthSelectOptions = static::getWidthSelectOptions();

        return [
            new TemplateTab([
                TemplateTab::HANDLE => 'definition',
                TemplateTab::LABEL => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Fieldset::HANDLE,
                            Field::LABEL => trans('narsil::ui.default_handle'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Fieldset::LABEL,
                            Field::LABEL => trans('narsil::ui.default_label'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Fieldset::RELATION_ELEMENTS,
                            Field::LABEL => trans('narsil::validation.attributes.elements'),
                            Field::TYPE => RelationsField::class,
                            Field::SETTINGS => app(RelationsField::class)
                                ->form(app(FieldsetElementForm::class)->jsonSerialize())
                                ->addOption(
                                    identifier: Input::TABLE,
                                    label: ModelService::getModelLabel(Input::class),
                                    optionLabel: FieldsetElement::LABEL,
                                    optionValue: FieldsetElement::HANDLE,
                                    options: $inputSelectOptions,
                                    routes: RouteService::getNames(Input::TABLE),
                                )
                                ->widthOptions($widthSelectOptions),
                        ]),
                    ]),
                ],
            ]),
        ];
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

                $option = new SelectOption()
                    ->id($input->{Input::ID})
                    ->identifier($input->{Input::ATTRIBUTE_IDENTIFIER})
                    ->optionIcon($input->{Input::ATTRIBUTE_ICON})
                    ->optionLabel($input->getTranslations(Input::LABEL))
                    ->optionValue($input->{Input::HANDLE});

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
