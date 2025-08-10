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

        $this->description = trans('narsil-cms::ui.element');
        $this->title = trans('narsil-cms::ui.element');
    }

    #endregion

    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function form(): array
    {
        return [
            new Field([
                Field::HANDLE => BlockElement::NAME,
                Field::NAME => trans('narsil-cms::validation.attributes.name'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->required(true),
            ]),
            new Field([
                Field::HANDLE => BlockElement::HANDLE,
                Field::NAME => trans('narsil-cms::validation.attributes.handle'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class)
                    ->required(true),
            ]),
        ];
    }

    #endregion
}
