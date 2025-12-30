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
    protected function getLayout(): array
    {
        $permissionSelectOptions = static::getPermissionSelectOptions();

        $permissionElements = $permissionSelectOptions
            ->sortBy(function ($options, $group)
            {
                return $group;
            })
            ->map(function ($options, $group)
            {
                return new TemplateTabElement([
                    TemplateTabElement::RELATION_ELEMENT => new Field([
                        Field::HANDLE => Role::RELATION_PERMISSIONS,
                        Field::NAME => $group,
                        Field::TYPE => CheckboxField::class,
                        Field::RELATION_OPTIONS => $options,
                        Field::SETTINGS => app(CheckboxField::class),
                    ]),
                ]);
            })
            ->values()
            ->toArray();

        return [
            new TemplateTab([
                TemplateTab::HANDLE => 'definition',
                TemplateTab::NAME => trans('narsil::ui.definition'),
                TemplateTab::RELATION_ELEMENTS => [
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Role::NAME,
                            Field::NAME => trans('narsil::validation.attributes.name'),
                            Field::REQUIRED => true,
                            Field::TRANSLATABLE => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateTabElement([
                        TemplateTabElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Role::HANDLE,
                            Field::NAME => trans('narsil::validation.attributes.handle'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                ],
            ]),
            new TemplateTab([
                TemplateTab::HANDLE => Role::RELATION_PERMISSIONS,
                TemplateTab::NAME => ModelService::getTableLabel(Permission::TABLE),
                TemplateTab::RELATION_ELEMENTS => $permissionElements,
            ]),
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
                $key = Str::beforeLast($permission->{Permission::HANDLE}, '_');

                return ModelService::getTableLabel($key);
            })
            ->map(function ($permissions)
            {
                return $permissions->map(function (Permission $permission)
                {
                    $option = new SelectOption()
                        ->optionLabel($permission->{Permission::NAME})
                        ->optionValue($permission->{Permission::ID});

                    return $option;
                })->toArray();
            });
    }

    #endregion
}
