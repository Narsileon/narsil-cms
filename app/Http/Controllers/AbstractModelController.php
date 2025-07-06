<?php

namespace App\Http\Controllers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

#endregion

/**
 * @version 1.0.0
 * @author Jonathan Rigaux
 */
abstract class AbstractModelController
{
    #region PROTECTED METHODS

    /**
     * @param string $table
     *
     * @return array
     */
    protected function getAttributes(string $table): array
    {
        $formRequest = Config::get("narsil.validation.$table");

        $data = request()->all();
        $rules = (new $formRequest())->rules();

        $validator = Validator::make($data, $rules);

        return $validator->validated();
    }

    /**
     * @param string $table
     *
     * @return RedirectResponse
     */
    protected function redirectOnDestroyed(string $table): RedirectResponse
    {
        return redirect(route("$table.index"))
            ->with('success', trans("toasts.success.$table.deleted"));
    }

    /**
     * @param string $table
     *
     * @return RedirectResponse
     */
    protected function redirectOnStored(string $table): RedirectResponse
    {
        return redirect(route("$table.index"))
            ->with('success', trans("toasts.success.$table.created"));
    }

    /**
     * @param string $table
     *
     * @return RedirectResponse
     */
    protected function redirectOnUpdated(string $table): RedirectResponse
    {
        return redirect(route("$table.index"))
            ->with('success', trans("toasts.success.$table.updated"));
    }

    #endregion
}
