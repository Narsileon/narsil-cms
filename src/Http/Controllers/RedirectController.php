<?php

namespace Narsil\Cms\Http\Controllers;

#region USE

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class RedirectController
{
    use AuthorizesRequests;

    #region PROTECTED METHODS

    /**
     * @param string|null $to
     * @param mixed $data
     *
     * @return RedirectResponse
     */
    protected function redirect(?string $to = null, mixed $data = []): RedirectResponse
    {
        if (request()->get('_back'))
        {
            return back()
                ->with('data', $data);
        }
        else
        {
            $to = request('_to', $to);

            return redirect($to);
        }
    }

    #endregion
}
