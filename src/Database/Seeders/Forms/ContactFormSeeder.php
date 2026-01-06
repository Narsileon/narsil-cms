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
            Form::RELATION_TABS => [
                new FormTab([
                    FormTab::HANDLE => 'contact_content',
                    FormTab::LABEL => 'How can we help you?',
                    FormTab::RELATION_ELEMENTS => [
                        new FormTabElement([
                            FormTabElement::REQUIRED => true,
                            FormTabElement::RELATION_ELEMENT => new Input([
                                Input::HANDLE => 'message',
                                Input::LABEL => 'Message',
                                Input::REQUIRED => true,
                                Input::TYPE => TextareaField::class,
                            ]),
                        ]),
                    ],
                ]),
                new FormTab([
                    FormTab::HANDLE => 'contact_informations',
                    FormTab::LABEL => 'How can we contact you back?',
                    FormTab::RELATION_ELEMENTS => [
                        new FormTabElement([
                            FormTabElement::REQUIRED => true,
                            FormTabElement::WIDTH => 50,
                            FormTabElement::RELATION_ELEMENT => new Fieldset([
                                Input::HANDLE => 'personal_information',
                                Input::LABEL => 'Personal information',
                                Input::REQUIRED => true,
                                Fieldset::RELATION_ELEMENTS => [
                                    new FieldsetElement([
                                        FieldsetElement::REQUIRED => true,
                                        FieldsetElement::WIDTH => 50,
                                        FieldsetElement::RELATION_ELEMENT => new Input([
                                            Input::HANDLE => 'first_name',
                                            Input::LABEL => 'First name',
                                            Input::REQUIRED => true,
                                            Input::TYPE => TextField::class,
                                        ]),
                                    ]),
                                    new FieldsetElement([
                                        FieldsetElement::REQUIRED => true,
                                        FieldsetElement::WIDTH => 50,
                                        FieldsetElement::RELATION_ELEMENT => new Input([
                                            Input::HANDLE => 'last_name',
                                            Input::LABEL => 'Last name',
                                            Input::REQUIRED => true,
                                            Input::TYPE => TextField::class,
                                        ]),
                                    ]),
                                    new FieldsetElement([
                                        FieldsetElement::REQUIRED => true,
                                        FieldsetElement::RELATION_ELEMENT => new Input([
                                            Input::HANDLE => 'email',
                                            Input::LABEL => 'Email',
                                            Input::REQUIRED => true,
                                            Input::TYPE => EmailField::class,
                                        ]),
                                    ]),
                                ],
                            ]),
                        ]),
                    ],
                ]),
            ],
        ]);
    }

    #endregion
}
