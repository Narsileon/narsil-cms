<?php

namespace Narsil\Database\Seeders\Forms;

#region USE

use Narsil\Contracts\Fields\EmailField;
use Narsil\Contracts\Fields\TextareaField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Database\Seeders\FormSeeder;
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
            Form::TITLE => 'Contact us',
            Form::DESCRIPTION => 'Please complete the form below to contact us.',
            Form::RELATION_TABS => [
                new FormTab([
                    FormTab::HANDLE => 'contact_informations',
                    FormTab::LABEL => 'contact',
                    FormTab::RELATION_ELEMENTS => [
                        new FormTabElement([
                            FormTabElement::REQUIRED => true,
                            FormTabElement::WIDTH => 50,
                            FormTabElement::RELATION_ELEMENT => new Input([
                                Input::HANDLE => 'first_name',
                                Input::LABEL => 'First name',
                                Input::REQUIRED => true,
                                Input::TYPE => TextField::class,
                            ]),
                        ]),
                        new FormTabElement([
                            FormTabElement::REQUIRED => true,
                            FormTabElement::WIDTH => 50,
                            FormTabElement::RELATION_ELEMENT => new Input([
                                Input::HANDLE => 'last_name',
                                Input::LABEL => 'Last name',
                                Input::REQUIRED => true,
                                Input::TYPE => TextField::class,
                            ]),
                        ]),
                        new FormTabElement([
                            FormTabElement::REQUIRED => true,
                            FormTabElement::RELATION_ELEMENT => new Input([
                                Input::HANDLE => 'email',
                                Input::LABEL => 'Email',
                                Input::REQUIRED => true,
                                Input::TYPE => EmailField::class,
                            ]),
                        ]),
                    ],
                ]),
                new FormTab([
                    FormTab::HANDLE => 'contact_message',
                    FormTab::LABEL => 'contact',
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
            ],
        ]);
    }

    #endregion
}
