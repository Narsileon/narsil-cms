<?php

namespace Narsil\Cms\Implementations\Forms\Fortify;

#region USE

use Narsil\Cms\Contracts\Fields\CheckboxField;
use Narsil\Cms\Contracts\Fields\EmailField;
use Narsil\Cms\Contracts\Fields\PasswordField;
use Narsil\Cms\Contracts\Forms\Fortify\LoginForm as Contract;
use Narsil\Cms\Enums\Forms\AutoCompleteEnum;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Models\Collections\BlockElement;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\User;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class LoginForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->action(route('login'))
            ->method(RequestMethodEnum::POST->value)
            ->submitLabel(trans('narsil-cms::ui.log_in'));
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
                        BlockElement::HANDLE => User::EMAIL,
                        BlockElement::LABEL => trans('narsil-cms::validation.attributes.email'),
                        BlockElement::REQUIRED => true,
                        BlockElement::RELATION_BASE => [
                            Field::PLACEHOLDER => 'email@example.com',
                            Field::TYPE => EmailField::class,
                            Field::SETTINGS => app(EmailField::class)
                                ->autoComplete(AutoCompleteEnum::EMAIL->value)
                                ->icon('email'),
                        ],
                    ],
                    [
                        BlockElement::HANDLE => User::PASSWORD,
                        BlockElement::LABEL => trans('narsil-cms::validation.attributes.password'),
                        BlockElement::REQUIRED => true,
                        BlockElement::RELATION_BASE => [
                            Field::TYPE => PasswordField::class,
                            Field::SETTINGS => app(PasswordField::class)
                                ->append(view('narsil-cms::components.link', [
                                    'label' => trans('narsil-cms::passwords.link'),
                                    'route' => route('password.request'),
                                ])->render())
                                ->autoComplete(AutoCompleteEnum::CURRENT_PASSWORD->value),
                        ],
                    ],
                    [
                        BlockElement::CLASS_NAME => 'flex-row-reverse justify-end',
                        BlockElement::HANDLE => User::REMEMBER,
                        BlockElement::LABEL => trans('narsil-cms::validation.attributes.remember'),
                        BlockElement::RELATION_BASE => [
                            Field::TYPE => CheckboxField::class,
                            Field::SETTINGS => app(CheckboxField::class),
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion
}
