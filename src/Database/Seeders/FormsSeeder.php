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

            $elements = $formTab->{FormTab::RELATION_ELEMENTS} ?? [];

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

                $elementModel = FormTabElement::create([
                    FormTabElement::BASE_ID => $base->getKey(),
                    FormTabElement::BASE_TYPE => $base->getTable(),
                    FormTabElement::DESCRIPTION => $element->{FormTabElement::DESCRIPTION},
                    FormTabElement::HANDLE => $element->{FormTabElement::HANDLE},
                    FormTabElement::LABEL => $base->{FormTabElement::LABEL},
                    FormTabElement::OWNER_UUID => $formTabModel->getKey(),
                    FormTabElement::POSITION => $position,
                    FormTabElement::REQUIRED => $element->{FormTabElement::REQUIRED} ?? false,
                    FormTabElement::WIDTH => $element->{FormTabElement::WIDTH} ?? 100,
                ]);

                $elementModel->conditions()->createMany($element->{FormTabElement::RELATION_CONDITIONS});
            }
        }

        return $formModel;
    }

    #endregion
}
