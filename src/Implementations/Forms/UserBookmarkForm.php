<?php

namespace Narsil\Implementations\Forms;

#region USE

use Narsil\Contracts\Fields\TextField;
use Narsil\Implementations\AbstractForm;
use Narsil\Models\Structures\Field;
use Narsil\Models\Users\UserBookmark;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class UserBookmarkForm extends AbstractForm
{
    #region PROTECTED METHODS

    /**
     * {@inheritDoc}
     */
    protected function getLayout(): array
    {
        return [
            new Field([
                Field::HANDLE => UserBookmark::NAME,
                Field::LABEL => trans('narsil::validation.attributes.name'),
                Field::TYPE => TextField::class,
                Field::SETTINGS => app(TextField::class),
            ]),
        ];
    }

    #endregion
}
