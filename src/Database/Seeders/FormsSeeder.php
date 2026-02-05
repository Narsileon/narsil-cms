<?php

namespace Narsil\Cms\Database\Seeders;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Cms\Models\Forms\Fieldset;
use Narsil\Cms\Models\Forms\FieldsetElement;
use Narsil\Cms\Models\Forms\Form;
use Narsil\Cms\Models\Forms\FormStep;
use Narsil\Cms\Models\Forms\FormStepElement;
use Narsil\Cms\Models\Forms\Input;
use Narsil\Cms\Models\Forms\InputOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FormsSeeder extends Seeder
{
    #region CONSTANTS

    /**
     * @var array
     */
    private const FIELD_FILLABLE_ATTRIBUTES = [
        Input::HANDLE,
        Input::LABEL,
        Input::DESCRIPTION,
    ];

    #endregion

    #region PROTECTED METHODS

    /**
     * @param Fieldset $fieldset
     *
     * @return Fieldset
     */
    protected function saveFieldset(Fieldset $fieldset): Fieldset
    {
        $model = Fieldset::query()
            ->where(Fieldset::HANDLE, $fieldset->{Fieldset::HANDLE})
            ->first();

        if ($model)
        {
            return $model;
        }

        $model = Fieldset::create([
            Fieldset::HANDLE => $fieldset->{Fieldset::HANDLE},
            Fieldset::LABEL => $fieldset->{Fieldset::LABEL},
        ]);

        $elements = $fieldset->{Fieldset::RELATION_ELEMENTS} ?? [];

        foreach ($elements as $position => $element)
        {
            $base = $element->{FieldsetElement::RELATION_BASE};

            if (!$base)
            {
                continue;
            }

            if ($base instanceof Input)
            {
                foreach (self::FIELD_FILLABLE_ATTRIBUTES as $attribute)
                {
                    if (empty($base->getAttribute($attribute)))
                    {
                        $base->setAttribute($attribute, $element->{$attribute});
                    }
                }

                $base = $this->saveInput($base);
            }
            else if ($base instanceof Fieldset)
            {
                $base = $this->saveFieldset($base);
            }

            $elementModel = FieldsetElement::create([
                FieldsetElement::BASE_ID => $base->getKey(),
                FieldsetElement::BASE_TYPE => $base->getTable(),
                FieldsetElement::DESCRIPTION => $element->{FieldsetElement::DESCRIPTION},
                FieldsetElement::HANDLE => $element->{FieldsetElement::HANDLE},
                FieldsetElement::LABEL => $element->{FieldsetElement::LABEL},
                FieldsetElement::OWNER_ID => $model->getKey(),
                FieldsetElement::POSITION => $position,
                FieldsetElement::REQUIRED => $element->{FieldsetElement::REQUIRED} ?? false,
                FieldsetElement::WIDTH => $element->{FieldsetElement::WIDTH} ?? 100,
            ]);

            $elementModel->conditions()->createMany($element->{FieldsetElement::RELATION_CONDITIONS});
        }

        return $model;
    }

    /**
     * @param Input $input
     *
     * @return Input
     */
    protected function saveInput(Input $input): Input
    {
        $model = Input::query()
            ->where(Input::HANDLE, $input->{Input::HANDLE})
            ->first();

        if ($model)
        {
            return $model;
        }

        $model = Input::create([
            Input::HANDLE => $input->{Input::HANDLE},
            Input::LABEL => $input->{Input::LABEL},
            Input::SETTINGS => $input->{Input::SETTINGS},
            Input::TYPE => $input->{Input::TYPE},
        ]);

        if ($inputOptions = $input->{Input::RELATION_OPTIONS})
        {
            foreach ($inputOptions as $position => $inputOption)
            {
                InputOption::create([
                    InputOption::INPUT_ID => $model->{Input::ID},
                    InputOption::LABEL => $inputOption->{InputOption::LABEL},
                    InputOption::POSITION => $position,
                    InputOption::VALUE => $inputOption->{InputOption::VALUE},
                ]);
            }
        }

        return $model;
    }

    /**
     * @param Form $form
     *
     * @return Form
     */
    protected function saveForm(Form $form): Form
    {
        $formModel = Form::query()
            ->where(Form::SLUG, $form->{Form::SLUG})
            ->first();

        if ($formModel)
        {
            return $formModel;
        }

        $formModel = Form::create([
            Form::SLUG => $form->{Form::SLUG},
        ]);

        $formSteps = $form->{Form::RELATION_STEPS} ?? [];

        foreach ($formSteps as $position => $formStep)
        {
            $formStepModel = FormStep::query()
                ->where(FormStep::FORM_ID, $formModel->{Form::ID})
                ->where(FormStep::HANDLE, $formStep->{FormStep::HANDLE})
                ->first();

            if (!$formStepModel)
            {
                $formStepModel = FormStep::create([
                    FormStep::DESCRIPTION => $formStep->{Form::DESCRIPTION},
                    FormStep::HANDLE => $formStep->{FormStep::HANDLE},
                    FormStep::LABEL => $formStep->{FormStep::LABEL},
                    FormStep::POSITION => $position,
                    FormStep::FORM_ID => $formModel->{Form::ID},
                ]);
            }
            else
            {
                $formStepModel->update([
                    FormStep::LABEL => $formStep->{FormStep::LABEL},
                    FormStep::POSITION => $position,
                ]);
            }

            $elements = $formStep->{FormStep::RELATION_ELEMENTS} ?? [];

            foreach ($elements as $position => $element)
            {
                $base = $element->{FieldsetElement::RELATION_BASE};

                if (!$base)
                {
                    continue;
                }

                if ($base instanceof Input)
                {
                    foreach (self::FIELD_FILLABLE_ATTRIBUTES as $attribute)
                    {
                        if (empty($base->getAttribute($attribute)))
                        {
                            $base->setAttribute($attribute, $element->{$attribute});
                        }
                    }

                    $base = $this->saveInput($base);
                }
                else if ($base instanceof Fieldset)
                {
                    $base = $this->saveFieldset($base);
                }

                $elementModel = FormStepElement::create([
                    FormStepElement::BASE_ID => $base->getKey(),
                    FormStepElement::BASE_TYPE => $base->getTable(),
                    FormStepElement::DESCRIPTION => $element->{FormStepElement::DESCRIPTION},
                    FormStepElement::HANDLE => $element->{FormStepElement::HANDLE},
                    FormStepElement::LABEL => $base->{FormStepElement::LABEL},
                    FormStepElement::OWNER_UUID => $formStepModel->getKey(),
                    FormStepElement::POSITION => $position,
                    FormStepElement::REQUIRED => $element->{FormStepElement::REQUIRED} ?? false,
                    FormStepElement::WIDTH => $element->{FormStepElement::WIDTH} ?? 100,
                ]);

                $elementModel->conditions()->createMany($element->{FormStepElement::RELATION_CONDITIONS});
            }
        }

        return $formModel;
    }

    #endregion
}
