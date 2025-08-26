<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\BuilderElement;
use Narsil\Contracts\Forms\EntityForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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
        $blocks = $this->template->{Template::RELATION_BLOCKS};

        $sections = $this->template->{Template::RELATION_SECTIONS}->toArray();

        if (count($blocks) > 0)
        {
            $sections[] = new TemplateSection([
                TemplateSection::HANDLE => 'content',
                TemplateSection::NAME => trans('narsil::ui.content'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => 'content',
                            Field::NAME => trans('narsil::validation.attributes.content'),
                            Field::TYPE => BuilderElement::class,
                            Field::RELATION_BLOCKS => $blocks,
                        ]),
                    ]),
                ],
            ])->toArray();
        }

        return $sections;
    }

    #endregion
}
