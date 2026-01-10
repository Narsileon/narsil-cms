<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\Fields\FileField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\HeaderForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\TemplateTab;
use Narsil\Models\Collections\TemplateTabElement;
use Narsil\Models\Globals\Header;
use Narsil\Services\RouteService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Header::TABLE));
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
                TemplateTab::HANDLE => 'definition',
                TemplateTab::LABEL => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Header::SLUG,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.slug'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Header::LOGO,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.logo'),
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => FileField::class,
                            Field::SETTINGS => app(FileField::class)
                                ->accept('image/*')
                                ->icon('image'),
                        ],
                    ],
                ],
            ],
        ];
    }

    #endregion
}
