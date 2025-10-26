<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Support\Str;
use Narsil\Contracts\Forms\EntityForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Template;
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
        parent::__construct();

        $this->template = $template;

        $this
            ->setDescription($template->{Template::NAME})
            ->setRoutes(RouteService::getNames(Template::HANDLE))
            ->setSubmitLabel(trans('narsil::ui.save'))
            ->setTitle(Str::singular($template->{Template::NAME}));
    }

    #endregion

    #region PROPERTIES

    /**
     * @var Template
     */
    protected Template $template;

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function layout(): array
    {
        return $this->template->{Template::RELATION_SECTIONS}->toArray();
    }

    #endregion
}
