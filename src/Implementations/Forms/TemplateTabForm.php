<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\TemplateForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\Collections\TemplateTabElement;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TemplateTabForm extends AbstractForm implements Contract
{
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
                        TemplateTabElement::HANDLE => TemplateTabElement::HANDLE,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.handle'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => TemplateTabElement::LABEL,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.label'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion
}
