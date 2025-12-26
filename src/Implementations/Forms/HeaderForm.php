<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\FileField;
use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\HeaderForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;
use Narsil\Models\Structures\TemplateSection;
use Narsil\Models\Structures\TemplateSectionElement;
use Narsil\Models\Globals\Header;
use Narsil\Services\RouteService;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class HeaderForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->routes(RouteService::getNames(Header::TABLE));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        return [
            new TemplateSection([
                TemplateSection::HANDLE => 'definition',
                TemplateSection::NAME => trans('narsil::ui.definition'),
                TemplateSection::RELATION_ELEMENTS => [
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Header::HANDLE,
                            Field::NAME => trans('narsil::validation.attributes.handle'),
                            Field::REQUIRED => true,
                            Field::TYPE => TextField::class,
                            Field::SETTINGS => app(TextField::class),
                        ]),
                    ]),
                    new TemplateSectionElement([
                        TemplateSectionElement::RELATION_ELEMENT => new Field([
                            Field::HANDLE => Header::LOGO,
                            Field::NAME => trans('narsil::validation.attributes.logo'),
                            Field::TYPE => FileField::class,
                            Field::SETTINGS => app(FileField::class)
                                ->accept('image/*')
                                ->icon('image'),
                        ]),
                    ]),
                ],
            ]),
        ];
    }

    #endregion
}
