<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\TextField;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Elements\Field;
use Narsil\Models\Users\UserBookmark;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
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

        $this
            ->description(trans('narsil::bookmarks.bookmark'))
            ->submitLabel(trans('narsil::ui.save'))
            ->title(trans('narsil::bookmarks.bookmark'));
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
                Field::HANDLE => UserBookmark::NAME,
                Field::NAME => trans('narsil::validation.attributes.name'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class),
            ]),
        ];
    }

    #endregion
}
