<?php

namespace Narsil\Cms\Implementations\Requests;

#region USE

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Narsil\Cms\Contracts\FormRequests\FormSubmissionDataFormRequest as Contract;
use Narsil\Cms\Implementations\AbstractFormRequest;
use Narsil\Cms\Models\Forms\Element;
use Narsil\Cms\Models\Forms\Fieldset;
use Narsil\Cms\Models\Forms\Form;
use Narsil\Cms\Models\Forms\FormStep;
use Narsil\Cms\Models\Forms\Input;
use Narsil\Cms\Models\ValidationRule;
use Narsil\Cms\Validation\FormRule;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class FormSubmissionDataFormRequest extends AbstractFormRequest implements Contract
{
    #region CONSTRUCTOR

    /**
     * @param Form $form
     * @param integer $step
     *
     * @return void
     */
    public function __construct(Form $form, int $step)
    {
        $this->form = $form;
        $this->step = $step;
    }

    #endregion

    #region PROPERTIES

    /**
     * @var Form
     */
    protected readonly Form $form;

    /**
     * @var integer
     */
    protected readonly int $step;

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

        foreach ($this->form->{Form::RELATION_STEPS} as $key => $formStep)
        {
            if ($key > $this->step)
            {
                continue;
            }

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
