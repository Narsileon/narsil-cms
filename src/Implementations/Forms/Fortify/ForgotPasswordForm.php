<?php

namespace Narsil\Cms\Implementations\Forms\Fortify;

#region USE

use Narsil\Cms\Contracts\Fields\EmailField;
use Narsil\Cms\Contracts\Forms\Fortify\ForgotPasswordForm as Contract;
use Narsil\Cms\Enums\Forms\AutoCompleteEnum;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;
use Narsil\Cms\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ForgotPasswordForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->action(route('password.email'))
            ->method(RequestMethodEnum::POST->value)
            ->submitLabel(trans('narsil::ui.send'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        return [
            [
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::DESCRIPTION => trans('narsil::passwords.instruction'),
                        TemplateTabElement::HANDLE => User::EMAIL,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.email'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => EmailField::class,
                            Field::SETTINGS => app(EmailField::class)
                                ->autoComplete(AutoCompleteEnum::EMAIL->value)
                                ->icon('email'),
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion
}
