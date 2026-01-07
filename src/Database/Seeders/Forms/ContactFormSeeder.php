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
use Narsil\Models\Forms\FormTab;
use Narsil\Models\Forms\FormTabElement;
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
            Form::RELATION_TABS,
            [
                new FormTab([
                    FormTab::HANDLE => 'contact_content',
                    FormTab::LABEL => 'How can we help you?',
                ])->setRelation(
                    FormTab::RELATION_ELEMENTS,
                    [
                        new FormTabElement([
                            FormTabElement::HANDLE => 'message',
                            FormTabElement::LABEL => 'Message',
                            FormTabElement::REQUIRED => true,
                        ])->setRelation(
                            FormTabElement::RELATION_ELEMENT,
                            new Input([
                                Input::TYPE => TextareaField::class,
                            ]),
                        ),
                    ],
                ),
                new FormTab([
                    FormTab::HANDLE => 'contact_informations',
                    FormTab::LABEL => 'How can we contact you back?',
                ])->setRelation(
                    FormTab::RELATION_ELEMENTS,
                    [
                        new FormTabElement([
                            FormTabElement::REQUIRED => true,
                            FormTabElement::WIDTH => 50,
                        ])->setRelation(
                            FormTabElement::RELATION_ELEMENT,
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
                                        FieldsetElement::RELATION_ELEMENT,
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
                                        FieldsetElement::RELATION_ELEMENT,
                                        new Input([
                                            Input::TYPE => TextField::class,
                                        ]),
                                    ),
                                    new FieldsetElement([
                                        FieldsetElement::HANDLE => 'email',
                                        FieldsetElement::LABEL => 'Email',
                                        FieldsetElement::REQUIRED => true,
                                    ])->setRelation(
                                        FieldsetElement::RELATION_ELEMENT,
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
