<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\SwitchInput;
use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\SiteForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Sites\Site;

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

        $this->description = $template->{Template::NAME};
        $this->title = $template->{Template::NAME};
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
    public function form(): array
    {
        return $this->template->{Template::RELATION_SECTIONS}->toArray();
    }

    #endregion
}
