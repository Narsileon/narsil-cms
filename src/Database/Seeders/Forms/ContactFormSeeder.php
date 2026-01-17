<?php

namespace Narsil\Database\Seeders\Forms;

#region USE

use Narsil\Contracts\Fields\EmailField;
use Narsil\Contracts\Fields\TextareaField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Database\Seeders\FormSeeder;
use Narsil\Models\Forms\Fieldset;
use Narsil\Models\Forms\FieldsetElement;
use Narsil\Models\Forms\Form;
use Narsil\Models\Forms\FormStep;
use Narsil\Models\Forms\FormStepElement;
use Narsil\Models\Forms\Input;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ContactFormSeeder extends FormSeeder
{
    #region PROTECTED METHODS

    /**
     * {@inheritdoc}
     */
    protected function form(): Form
    {
        return new Form([
            Form::SLUG => 'contact',
        ])->setRelation(
            Form::RELATION_STEPS,
            [
                new FormStep([
                    FormStep::HANDLE => 'contact_content',
                    FormStep::LABEL => 'How can we help you?',
                ])->setRelation(
                    FormStep::RELATION_ELEMENTS,
                    [
                        new FormStepElement([
                            FormStepElement::HANDLE => 'message',
                            FormStepElement::LABEL => 'Message',
                            FormStepElement::REQUIRED => true,
                        ])->setRelation(
                            FormStepElement::RELATION_BASE,
                            new Input([
                                Input::TYPE => TextareaField::class,
                            ]),
                        ),
                    ],
                ),
                new FormStep([
                    FormStep::HANDLE => 'contact_informations',
                    FormStep::LABEL => 'How can we contact you back?',
                ])->setRelation(
                    FormStep::RELATION_ELEMENTS,
                    [
                        new FormStepElement([
                            FormStepElement::HANDLE => 'personal_information',
                            FormStepElement::LABEL => 'Personal information',
                            FormStepElement::WIDTH => 50,
                        ])->setRelation(
                            FormStepElement::RELATION_BASE,
                            new Fieldset([
                                Fieldset::HANDLE => 'personal_information',
                                Fieldset::LABEL => 'Personal information',
                            ])->setRelation(
                                Fieldset::RELATION_ELEMENTS,
                                [
                                    new FieldsetElement([
                                        FieldsetElement::HANDLE => 'first_name',
                                        FieldsetElement::LABEL => 'First name',
                                        FieldsetElement::REQUIRED => true,
                                        FieldsetElement::WIDTH => 50,
                                    ])->setRelation(
                                        FieldsetElement::RELATION_BASE,
                                        new Input([
                                            Input::TYPE => TextField::class,
                                        ]),
                                    ),
                                    new FieldsetElement([
                                        FieldsetElement::HANDLE => 'last_name',
                                        FieldsetElement::LABEL => 'Last name',
                                        FieldsetElement::REQUIRED => true,
                                        FieldsetElement::WIDTH => 50,
                                    ])->setRelation(
                                        FieldsetElement::RELATION_BASE,
                                        new Input([
                                            Input::TYPE => TextField::class,
                                        ]),
                                    ),
                                    new FieldsetElement([
                                        FieldsetElement::HANDLE => 'email',
                                        FieldsetElement::LABEL => 'Email',
                                        FieldsetElement::REQUIRED => true,
                                    ])->setRelation(
                                        FieldsetElement::RELATION_BASE,
                                        new Input([
                                            Input::TYPE => EmailField::class,
                                        ]),
                                    ),
                                ],
                            ),
                        ),
                    ],
                ),
            ],
        );
    }

    #endregion
}
