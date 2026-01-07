<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Narsil\Contracts\Fields\CheckboxField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\RoleForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateTab;
use Narsil\Models\Structures\TemplateTabElement;
use Narsil\Models\Policies\Permission;
use Narsil\Models\Policies\Role;
use Narsil\Models\Structures\FieldOption;
use Narsil\Services\ModelService;
use Narsil\Services\RouteService;
use Narsil\Support\SelectOption;

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
                    TemplateTabElement::RELATION_ELEMENT => [
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
                TemplateTab::LABEL => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    [
                        TemplateTabElement::HANDLE => Role::NAME,
                        TemplateTabElement::LABEL => trans('narsil::validation.attributes.name'),
                        TemplateTabElement::REQUIRED => true,
                        TemplateTabElement::RELATION_ELEMENT => [
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ],
                    ],
                    [
                        TemplateTabElement::HANDLE => Role::LABEL,
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
