<?php

namespace Narsil\Cms\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Cms\Contracts\Fields\TextField;
use Narsil\Cms\Contracts\Forms\EntityForm as Contract;
use Narsil\Cms\Implementations\AbstractForm;
use Narsil\Cms\Models\Collections\Field;
use Narsil\Cms\Models\Collections\Template;
use Narsil\Cms\Models\Collections\TemplateTabElement;
use Narsil\Cms\Models\Entities\Entity;
use Narsil\Cms\Services\RouteService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class EntityForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * {@inheritDoc}
     *
     * @param Template $template
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
                TemplateTabElement::LABEL => trans('narsil-cms::validation.attributes.slug'),
                TemplateTabElement::REQUIRED => true,
                TemplateTabElement::TRANSLATABLE => true,
                TemplateTabElement::RELATION_BASE => [
                    Field::TYPE => TextField::class,
                    Field::SETTINGS => app(TextField::class),
                ],
            ],
        ]);

        return $templateTabs;
    }

    #endregion
}
