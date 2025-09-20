<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\TextInput;
use Narsil\Contracts\Forms\BlockForm as Contract;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\BlockElement;
use Narsil\Models\Elements\Field;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
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

        $this->description = trans('narsil::ui.element');
        $this->submitLabel = trans('narsil::ui.save');
        $this->title = trans('narsil::ui.element');
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
                Field::HANDLE => BlockElement::NAME,
                Field::NAME => trans('narsil::validation.attributes.name'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->setRequired(true),
            ]),
            new Field([
                Field::HANDLE => BlockElement::HANDLE,
                Field::NAME => trans('narsil::validation.attributes.handle'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->setRequired(true),
            ]),
        ];
    }

    #endregion
}
