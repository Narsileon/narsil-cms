<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Base\Models\Policies\Permission;
use Narsil\Cms\Contracts\Fields\TextField;
use Narsil\Cms\Contracts\Forms\PermissionForm as Contract;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;
use Narsil\Cms\Services\ModelService;
use Narsil\Cms\Services\RouteService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PermissionForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Permission::TABLE));
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
                TemplateTab::LABEL => trans('narsil-cms::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::DESCRIPTION => ModelService::getFieldDescription(Permission::TABLE, Permission::NAME),
                        TemplateTabElement::HANDLE => Permission::NAME,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.name'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class)
                                ->readOnly(true),
                        ],
                    ],
                    [
                        TemplateTabElement::DESCRIPTION => ModelService::getFieldDescription(Permission::TABLE, Permission::LABEL),
                        TemplateTabElement::HANDLE => Permission::LABEL,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.label'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::TRANSLATABLE => true,
                        TemplateTabElement::RELATION_BASE => [
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
