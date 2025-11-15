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
        return $this->template->{Template::RELATION_SECTIONS}->toArray();
    }

    #endregion
}
