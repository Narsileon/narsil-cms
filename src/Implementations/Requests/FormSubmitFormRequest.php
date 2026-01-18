<?php

namespace Narsil\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Narsil\Contracts\FormRequests\FormSubmitFormRequest as Contract;
use Narsil\Implementations\AbstractFormRequest;
use Narsil\Models\Forms\Element;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\FormStep;
use Narsil\Models\Forms\Input;
use Narsil\Models\ValidationRule;
use Narsil\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormSubmitFormRequest extends AbstractFormRequest implements Contract
{
    #region CONSTRUCTOR

    /**
     * @param Form $form
     *
     * @return void
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var Form
     */
    protected readonly Form $form;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function attributes(): array
    {
        $attributes = [];

        foreach ($this->form->{Form::RELATION_STEPS} as $formStep)
        {
            $this->populateAttributes($attributes, $formStep->{FormStep::RELATION_ELEMENTS});
        }

        return $attributes;
    }

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        $rules = [];

        foreach ($this->form->{Form::RELATION_STEPS} as $formStep)
        {
            $this->populateRules($rules, $formStep->{FormStep::RELATION_ELEMENTS});
        }

        return $rules;
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * @param array $attributes
     * @param Collection $elements
     * @param string|null $path
     *
     * @return void
     */
    protected function populateAttributes(array &$attributes, Collection $elements, ?string $path = null): void
    {
        foreach ($elements as $element)
        {
            $handle = $element->{Element::HANDLE};

            $key = $path ? "$path.$handle" : $handle;

            if ($element->{Element::BASE_TYPE} === Input::TABLE)
            {
                $attributes[$key] = $handle;
            }
            else
            {
                $fieldset = $element->{Element::RELATION_BASE};

                $this->populateAttributes($attributes, $fieldset->{Fieldset::RELATION_ELEMENTS}, $key);
            }
        }
    }

    /**
     * @param array $rules
     * @param Collection $elements
     * @param string|null $path
     *
     * @return void
     */
    protected function populateRules(array &$rules, Collection $elements, ?string $path = null): void
    {
        foreach ($elements as $element)
        {
            $handle = $element->{Element::HANDLE};

            $key = $path ? "$path.$handle" : $handle;

            if ($element->{Element::BASE_TYPE} === Input::TABLE)
            {
                $input = $element->{Element::RELATION_BASE};

                $fieldValidationRules =  $input->{Input::RELATION_VALIDATION_RULES}->pluck(ValidationRule::HANDLE)->toArray();

                $fieldRules = [];

                if ($element->{Element::REQUIRED})
                {
                    $fieldRules[] = FormRule::REQUIRED;

                    if (Str::contains($path, 'children'))
                    {
                        $fieldRules[] = FormRule::SOMETIMES;
                    }
                }
                else
                {
                    $fieldRules[] = FormRule::SOMETIMES;
                    $fieldRules[] = FormRule::NULLABLE;
                }

                $rules[$key] = array_merge($fieldRules, $fieldValidationRules);
            }
            else
            {
                $fieldset = $element->{Element::RELATION_BASE};

                $this->populateRules($rules, $fieldset->{Fieldset::RELATION_ELEMENTS}, $key);
            }
        }
    }

    #endregion
}
