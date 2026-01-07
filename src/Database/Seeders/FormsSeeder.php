<?php

namespace Narsil\Database\Seeders;

#region USE

use Illuminate\Database\Seeder;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\FieldsetElement;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\FormTab;
use Narsil\Models\Forms\FormTabElement;
use Narsil\Models\Forms\Input;
use Narsil\Models\Forms\InputOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class FormsSeeder extends Seeder
{
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

        $fieldsetElements = $fieldset->{Fieldset::RELATION_ELEMENTS} ?? [];

        foreach ($fieldsetElements as $position => $fieldsetElement)
        {
            $element = $fieldsetElement->{FieldsetElement::RELATION_ELEMENT};

            if (!$element)
            {
                continue;
            }

            if ($element instanceof Input)
            {
                $element->fill([
                    Input::HANDLE => $fieldsetElement->{FieldsetElement::HANDLE},
                    Input::LABEL => $fieldsetElement->{FieldsetElement::LABEL},
                ]);

                $element = $this->saveInput($element);
            }
            else if ($element instanceof Fieldset)
            {
                $element = $this->saveFieldset($element);
            }

            FieldsetElement::create([
                FieldsetElement::ELEMENT_ID => $element->getKey(),
                FieldsetElement::ELEMENT_TYPE => $element->getTable(),
                FieldsetElement::HANDLE => $fieldsetElement->{FieldsetElement::HANDLE} ?? $element->{FieldsetElement::HANDLE},
                FieldsetElement::LABEL => $element->{FieldsetElement::LABEL},
                FieldsetElement::OWNER_ID => $model->getKey(),
                FieldsetElement::POSITION => $position,
                FieldsetElement::REQUIRED => $fieldsetElement->{FieldsetElement::REQUIRED} ?? $element->{FieldsetElement::REQUIRED},
                FieldsetElement::WIDTH => $fieldsetElement->{FieldsetElement::WIDTH} ?? 100,
            ]);
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

        $formTabs = $form->{Form::RELATION_TABS} ?? [];

        foreach ($formTabs as $position => $formTab)
        {
            $formTabModel = FormTab::query()
                ->where(FormTab::FORM_ID, $formModel->{Form::ID})
                ->where(FormTab::HANDLE, $formTab->{FormTab::HANDLE})
                ->first();

            if (!$formTabModel)
            {
                $formTabModel = FormTab::create([
                    FormTab::DESCRIPTION => $formTab->{Form::DESCRIPTION},
                    FormTab::HANDLE => $formTab->{FormTab::HANDLE},
                    FormTab::LABEL => $formTab->{FormTab::LABEL},
                    FormTab::POSITION => $position,
                    FormTab::FORM_ID => $formModel->{Form::ID},
                ]);
            }
            else
            {
                $formTabModel->update([
                    FormTab::LABEL => $formTab->{FormTab::LABEL},
                    FormTab::POSITION => $position,
                ]);
            }

            $formTabElements = $formTab->{FormTab::RELATION_ELEMENTS} ?? [];

            foreach ($formTabElements as $position => $formTabElement)
            {
                $element = $formTabElement->{FieldsetElement::RELATION_ELEMENT};

                if (!$element)
                {
                    continue;
                }

                if ($element instanceof Input)
                {
                    $element->fill([
                        Input::HANDLE => $formTabElement->{FormTabElement::HANDLE},
                        Input::LABEL => $formTabElement->{FormTabElement::LABEL},
                    ]);

                    $element = $this->saveInput($element);
                }
                else if ($element instanceof Fieldset)
                {
                    $element = $this->saveFieldset($element);
                }

                FormTabElement::create([
                    FormTabElement::ELEMENT_ID => $element->getKey(),
                    FormTabElement::ELEMENT_TYPE => $element->getTable(),
                    FormTabElement::HANDLE => $formTabElement->{FormTabElement::HANDLE} ?? $element->{FormTabElement::HANDLE},
                    FormTabElement::LABEL => $element->{FormTabElement::LABEL},
                    FormTabElement::OWNER_UUID => $formTabModel->getKey(),
                    FormTabElement::POSITION => $position,
                    FormTabElement::REQUIRED => $formTabElement->{FormTabElement::REQUIRED} ?? $element->{FormTabElement::REQUIRED},
                    FormTabElement::WIDTH => $formTabElement->{FormTabElement::WIDTH} ?? 100,
                ]);
            }
        }

        return $formModel;
    }

    #endregion
}
