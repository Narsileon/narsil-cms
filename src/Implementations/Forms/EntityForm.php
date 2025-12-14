<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\EntityForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\TemplateSectionElement;
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
     *
     * @return void
     */
    public function __construct(Template $template)
    {
        $this->template = $template;

        parent::__construct();

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
        $templateSections = $this->template->{Template::RELATION_SECTIONS}->toArray();

        $templateSections[] = static::sidebarSection([
            new TemplateSectionElement([
                TemplateSectionElement::RELATION_ELEMENT => new Field([
                    Field::HANDLE => Entity::SLUG,
                    Field::NAME => trans('narsil::validation.attributes.slug'),
                    Field::TRANSLATABLE => true,
                    Field::TYPE => TextField::class,
                    Field::SETTINGS => app(TextField::class)
                        ->required(true),
                ]),
            ]),
        ]);

        return $templateSections;
    }

    #endregion
}
