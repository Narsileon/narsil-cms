<?php

declare(strict_types=1);

namespace Narsil\Cms\Definitions;

#region USE

use Narsil\Base\Definitions\AbstractModelDefinition;
use Narsil\Cms\Contracts\Forms\RedirectForm;
use Narsil\Cms\Contracts\Requests\RedirectFormRequest;
use Narsil\Cms\Implementations\Tables\RedirectTable;
use Narsil\Cms\Models\Redirect;

#endregion

final class RedirectDefinition extends AbstractModelDefinition
{
    #region PUBLIC METHODS

    /**
     * {@inheritDoc}
     */
    public function form(): ?string
    {
        return RedirectForm::class;
    }

    /**
     * {@inheritDoc}
     */
    public function model(): string
    {
        return Redirect::class;
    }

    /**
     * {@inheritDoc}
     */
    public function request(): ?string
    {
        return RedirectFormRequest::class;
    }

    /**
     * {@inheritDoc}
     */
    public function route(): string
    {
        return Redirect::TABLE;
    }

    /**
     * {@inheritDoc}
     */
    public function table(): ?string
    {
        return RedirectTable::class;
    }

    #endregion
}
