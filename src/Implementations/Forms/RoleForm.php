<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Narsil\Base\Models\Policies\Permission;
use Narsil\Base\Models\Policies\Role;
use Narsil\Cms\Contracts\Fields\CheckboxField;
use Narsil\Cms\Contracts\Fields\TextField;
use Narsil\Cms\Contracts\Forms\RoleForm as Contract;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\FieldOption;
use Narsil\Cms\Models\Collections\TemplateTab;
use Narsil\Cms\Models\Collections\TemplateTabElement;
use Narsil\Cms\Services\ModelService;
use Narsil\Cms\Services\RouteService;
use Narsil\Cms\Support\SelectOption;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class RoleForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     */
    public function __construct(?Model $model = null)
    {
        parent::__construct($model);

        $this->routes(RouteService::getNames(Role::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        $permissionSelectOptions = static::getPermissionSelectOptions();

        $permissionElements = $permissionSelectOptions
            ->sortBy(function ($options, $group)
            {
                return $group;
            })
            ->map(function ($options, $group)
            {
                return [
                    TemplateTabElement::HANDLE => Role::RELATION_PERMISSIONS,
                    TemplateTabElement::LABEL => $group,
                    TemplateTabElement::RELATION_BASE => [
                        Field::TYPE => CheckboxField::class,
                        Field::SETTINGS => app(CheckboxField::class),
                        Field::RELATION_OPTIONS => $options,
                    ],
                ];
            })
            ->values()
            ->toArray();

        return [
            [
                TemplateTab::HANDLE => 'definition',
                TemplateTab::LABEL => trans('narsil-cms::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::DESCRIPTION => ModelService::getFieldDescription(Role::TABLE, Role::NAME),
                        TemplateTabElement::HANDLE => Role::NAME,
                        TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.name'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_BASE => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::DESCRIPTION => ModelService::getFieldDescription(Role::TABLE, Role::LABEL),
                        TemplateTabElement::HANDLE => Role::LABEL,
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
            [
                TemplateTab::HANDLE => Role::RELATION_PERMISSIONS,
                TemplateTab::LABEL => ModelService::getTableLabel(Permission::TABLE),
                TemplateTab::RELATION_ELEMENTS => $permissionElements,
            ],
        ];
    }

    /**
     * @return Collection<string,array<SelectOption>>
     */
    protected static function getPermissionSelectOptions(): Collection
    {
        return Permission::query()
            ->get()
            ->groupBy(function (Permission $permission)
            {
                $key = Str::beforeLast($permission->{Permission::NAME}, '_');

                return ModelService::getTableLabel($key);
            })
            ->map(function ($permissions)
            {
                return $permissions->map(function (Permission $permission)
                {
                    return [
                        FieldOption::LABEL => $permission->{Permission::LABEL},
                        FieldOption::VALUE => $permission->{Permission::ID},
                    ];
                })->toArray();
            });
    }

    #endregion
}
