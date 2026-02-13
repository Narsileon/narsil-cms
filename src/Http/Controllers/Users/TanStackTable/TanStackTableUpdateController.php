<?php

namespace Narsil\Cms\Http\Controllers\Users;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Narsil\Base\Contracts\Requests\TanStackTableFormRequest;
use Narsil\Base\Models\Users\TanStackTable;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class TanStackTableController
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(TanStackTableFormRequest $request): RedirectResponse
    {
        $attributes = $request->validated();

        TanStackTable::updateOrCreate(
            [
                TanStackTable::USER_ID => Auth::id(),
                TanStackTable::TABLE_ID => Arr::get($attributes, TanStackTable::TABLE_ID),
                TanStackTable::NAME => Arr::get($attributes, TanStackTable::NAME),
            ],
            $attributes
        );

        return back();
    }

    #endregion
}
