<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\EntityForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Collections\Field;
use Narsil\Models\Collections\Template;
use Narsil\Models\Collections\TemplateTabElement;
use Narsil\Models\Entities\Entity;
use Narsil\Services\RouteService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @param Template $template
     * @param Model|null $model
     *
     * @return void
     */
    public function __construct(Template $template, ?Model $model = null)
    {
        $this->template = $template;

        parent::__construct($model);

        $this->routes(RouteService::getNames('collections', [
            'collection' => $template->{Template::TABLE_NAME},
        ]));
    }

    #endregion

    #region PROPERTIES

    /**
     * @var Template
     */
    protected Template $template;

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getTabs(): array
    {
        $templateTabs = $this->template->{Template::RELATION_TABS}->toArray();

        $templateTabs[] = static::sidebarTab([
            [
                TemplateTabElement::HANDLE => Entity::SLUG,
                TemplateTabElement::LABEL => trans('narsil::validation.attributes.slug'),
                TemplateTabElement::REQUIRED => true,
                TemplateTabElement::TRANSLATABLE => true,
                TemplateTabElement::RELATION_ELEMENT => [
                    Field::TYPE => TextField::class,
                    Field::SETTINGS => app(TextField::class),
                ],
            ],
        ]);

        return $templateTabs;
    }

    #endregion
}
