<?php

namespace App\Http\Controllers;

#region USE

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
        $toast = trans("toasts.success.$table.deleted");

        if (request()->get('_back'))
        {
            return back()->with('success', $toast);
        }
        else
        {
            return redirect(route(Str::slug($table) .  '.index'))
                ->with('success', $toast);
        }
    }

    /**
     * @param string $table
     *
     * @return RedirectResponse
     */
    protected function redirectOnStored(string $table): RedirectResponse
    {
        $toast = trans("toasts.success.$table.created");

        if (request()->get('_back'))
        {
            return back()->with('success', $toast);
        }
        else
        {
            return redirect(route(Str::slug($table) .  '.index'))
                ->with('success', $toast);
        }
    }

    /**
     * @param string $table
     *
     * @return RedirectResponse
     */
    protected function redirectOnUpdated(string $table): RedirectResponse
    {
        $toast = trans("toasts.success.$table.updated");

        if (request()->get('_back'))
        {
            return back()->with('success', $toast);
        }
        else
        {
            return redirect(route(Str::slug($table) .  '.index'))
                ->with('success', $toast);
        }
    }

    #endregion
}
