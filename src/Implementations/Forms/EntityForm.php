<?php

namespace Narsil\Implementations\Forms;

#region USE

use Illuminate\Support\Str;
use Narsil\Contracts\Forms\EntityForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Block;
use Narsil\Models\Elements\Template;
use Narsil\Models\Elements\TemplateSection;
use Narsil\Models\Elements\TemplateSectionElement;
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
            ->setAutoSave(true)
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
        $sets = $this->template->{Template::RELATION_SETS};

        $sections = $this->template->{Template::RELATION_SECTIONS}->toArray();

        if (count($sets) > 0)
        {
            $contentSection = new TemplateSection([
                TemplateSection::HANDLE => 'content',
                TemplateSection::NAME => trans('narsil::ui.content'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Block([
                            Block::HANDLE => 'blocks',
                            Block::NAME => trans('narsil::tables.blocks'),
                            Block::RELATION_ELEMENTS => [],
                            Block::RELATION_SETS => $sets,
                        ]),
                    ]),
                ],
            ])->toArray();

            if (count($sections) > 0)
            {
                array_splice($sections, 1, 0, [$contentSection]);
            }
            else
            {
                array_unshift($sections, $contentSection);
            }
        }

        return [...$sections, static::informationSection()];
    }

    #endregion
}
