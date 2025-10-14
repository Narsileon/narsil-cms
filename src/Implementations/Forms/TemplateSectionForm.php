<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\TemplateForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Elements\TemplateSection;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class TemplateSectionForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->setDescription(trans('narsil::ui.section'))
            ->setSubmitLabel(trans('narsil::ui.save'))
            ->setTitle(trans('narsil::ui.section'));
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function layout(): array
    {
        return [
            new Field([
                Field::HANDLE => TemplateSection::NAME,
                Field::NAME => trans('narsil::validation.attributes.name'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => TemplateSection::HANDLE,
                Field::NAME => trans('narsil::validation.attributes.handle'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->setRequired(true),
            ]),
        ];
    }

    #endregion
}
