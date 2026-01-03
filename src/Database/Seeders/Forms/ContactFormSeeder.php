<?php

namespace Narsil\Database\Seeders\Forms;

#region USE

use Narsil\Contracts\Fields\EmailField;
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
            Form::RELATION_TABS => [
                new FormTab([
                    FormTab::HANDLE => 'contact',
                    FormTab::NAME => 'contact',
                    FormTab::RELATION_ELEMENTS => [
                        new FormTabElement([
                            FormTabElement::REQUIRED => true,
                            FormTabElement::WIDTH => 50,
                            FormTabElement::RELATION_ELEMENT => new Input([
                                Input::HANDLE => 'first_name',
                                Input::NAME => 'First name',
                                Input::REQUIRED => true,
                                Input::TYPE => TextField::class,
                            ]),
                        ]),
                        new FormTabElement([
                            FormTabElement::REQUIRED => true,
                            FormTabElement::WIDTH => 50,
                            FormTabElement::RELATION_ELEMENT => new Input([
                                Input::HANDLE => 'last_name',
                                Input::NAME => 'Last name',
                                Input::REQUIRED => true,
                                Input::TYPE => TextField::class,
                            ]),
                        ]),
                        new FormTabElement([
                            FormTabElement::REQUIRED => true,
                            FormTabElement::RELATION_ELEMENT => new Input([
                                Input::HANDLE => 'email',
                                Input::NAME => 'Email',
                                Input::REQUIRED => true,
                                Input::TYPE => EmailField::class,
                            ]),
                        ]),
                    ],
                ]),
            ],
        ]);
    }

    #endregion
}
