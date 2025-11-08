<?php

namespace Narsil\Http\Controllers;

#region

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
class PageController extends Controller
{
    #region PUBLIC METHODS

    /**
     * @param Request $request
     * @param string|null $slug
     *
     * @return mixed
     */
    public function __invoke(Request $request): mixed
    {
        return back();
    }

    #endregion
}
