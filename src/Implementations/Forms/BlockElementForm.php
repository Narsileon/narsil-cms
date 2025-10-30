<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\TextField;
use Narsil\Contracts\Forms\BlockForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class BlockElementForm extends AbstractForm implements Contract
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->description(trans('narsil::ui.element'))
            ->submitLabel(trans('narsil::ui.save'))
            ->title(trans('narsil::ui.element'));
    }

    #endregion

    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        return [
            new Field([
                Field::HANDLE => BlockElement::NAME,
                Field::NAME => trans('narsil::validation.attributes.name'),
                Field::TRANSLATABLE => true,
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->required(true),
            ]),
            new Field([
                Field::HANDLE => BlockElement::HANDLE,
                Field::NAME => trans('narsil::validation.attributes.handle'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class)
                    ->required(true),
            ]),
        ];
    }

    #endregion
}
