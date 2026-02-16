<?php

namespace Narsil\Cms\Implementations\Forms\Fortify;

#region USE

use Narsil\Base\Enums\AutoCompleteEnum;
use Narsil\Base\Models\User;
use Narsil\Cms\Contracts\Fields\PasswordField;
use Narsil\Cms\Contracts\Forms\Fortify\ConfirmPasswordForm as Contract;
use Narsil\Cms\Enums\RequestMethodEnum;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class ConfirmPasswordForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->action(route('password.confirm'))
            ->method(RequestMethodEnum::POST->value)
            ->submitLabel(trans('narsil-ui::ui.confirm'));
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
                        TemplateTabElement::HANDLE => User::PASSWORD,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.password'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => PasswordField::class,
                            Field::SETTINGS => app(PasswordField::class)
                                ->autoComplete(AutoCompleteEnum::ONE_TIME_CODE->value),
                        ],
                    ],
                ],
            ]
        ];
    }

    #endregion
}
