<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Database\Eloquent\Model;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\EntityForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\Template;
use Narsil\Models\Structures\TemplateTabElement;
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
            'collection' => $template->{Template::HANDLE},
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
    protected function getLayout(): array
    {
        $templateTabs = $this->template->{Template::RELATION_TABS}->toArray();

        $templateTabs[] = static::sidebarTab([
            new TemplateTabElement([
                TemplateTabElement::RELATION_ELEMENT => new Field([
                    Field::HANDLE => Entity::SLUG,
                    Field::NAME => trans('narsil::validation.attributes.slug'),
                    Field::REQUIRED => true,
                    Field::TRANSLATABLE => true,
                    Field::TYPE => TextField::class,
                    Field::SETTINGS => app(TextField::class),
                ]),
            ]),
        ]);

        return $templateTabs;
    }

    #endregion
}
