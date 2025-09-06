<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\TextInput;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Users\UserBookmark;

#endregion

/**
 * @author Jonathan Rigaux
 * @version 1.0.0
 */
class UserBookmarkForm extends AbstractForm
{
    #region CONSTRUCTOR

    /**
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->description = trans('narsil::bookmarks.bookmark');
        $this->submitLabel = trans('narsil::ui.save');
        $this->title = trans('narsil::bookmarks.bookmark');
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
                Field::HANDLE => UserBookmark::NAME,
                Field::NAME => trans('narsil::validation.attributes.name'),
                Field::TYPE => TextInput::class,
                Field::SETTINGS => app(TextInput::class),
            ]),
        ];
    }

    #endregion
}
